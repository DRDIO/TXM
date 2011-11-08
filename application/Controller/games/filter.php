<?php define("ROOT", TRUE);

define("PAGE_TITLE", "Game Filters");
define("PAGE_COMMON", true);
define("AD_APPROVED", true); 
include_once("../includes/header.php");

define("LIMIT", 20);
define("RANGE", 5);
define("COLOR_ALT", "blu-alt");

$filter = new TXM_Games_Filter();

include_once("../includes/footer.php");

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
class TXM_Games_Filter
{
        private $mode;
        private $page;
        private $time;
        private $title;
        
        public function __construct()
        {
                global $_GET;
                
                $this->time = time();
                $this->mode = isset($_GET["id"])   === true ? $_GET["id"]           : "";
                $this->page = isset($_GET["page"]) === true && empty($_GET["page"]) === false ? intval($_GET["page"]) : 1;

                $this->compileSQL();
                $this->getListTotal();
                $this->buildList();
                $this->pagination($this->page, $this->listTotal, LIMIT, RANGE);        
                $this->outputPage();
        }

        public function compileSql()
        {
            // Keep track of a list of possible modes for filter
            // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
            switch ($this->mode) {
                // General Modes 'best', 'popular', 'latest', 'needsvotes'
                // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *     
                case "best":
                    $this->title         = "Only The Best";
                    $this->sqlClause = "";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
                
                case "popular":
                    $this->title         = "Most Popular By Vote";                
                    $this->sqlClause = "";
                    $this->sqlOrder  = "ORDER BY m.vote_offset DESC";
                break;
                
                case "latest":
                    $this->title         = "Latest Flash Entries";                
                    $this->sqlClause = "";
                    $this->sqlOrder  = "ORDER BY m.date DESC";
                break;
                
                case "needsvotes":
                    $this->title         = "Needs More Votes";                
                    $this->sqlClause = "AND m.vote_offset < 5";
                    $this->sqlOrder  = "ORDER BY m.date ASC";
                break;
            
                case "worst":
                    $this->title         = "Only The Worst";                
                    $this->sqlClause = "AND (" . $this->time . " - m.date > 604800)";
                    $this->sqlOrder  = "ORDER BY m.score_offset ASC";
                break;
                
                // Game Specific Modes 'comedy', 'drama', 'horror', 'noir', 'othergames', 'parodies', 'series'
                // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *     
                case "action":
                    $this->title         = "Game Types As Action Shorts";                
                    $this->sqlClause = "AND m.id_type = 11";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
            
                case "fighters":
                    $this->title         = "Game Types As Battle Fighters";
                    $this->sqlClause = "AND m.id_type = 12";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
                
                case "othergames":
                    $this->title         = "Game Types As Other Games";
                    $this->sqlClause = "AND m.id_type = 13";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
                
                case "party":
                    $this->title         = "Game Types As Party Modes";
                    $this->sqlClause = "AND m.id_type = 14";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
                
                case "classic":
                    $this->title         = "Game Types As Classic Platforming";
                    $this->sqlClause = "AND m.id_type = 15";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
            
                case "rpg":
                    $this->title         = "Game Types As Role Playing Games";
                    $this->sqlClause = "AND m.id_type = 16";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
                
                case "puzzle":
                    $this->title         = "Game Types As Cards &amp; Puzzles";
                    $this->sqlClause = "AND m.id_type = 17";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
            
                case "racing":
                    $this->title         = "Game Types As Racing Vehicles";
                    $this->sqlClause = "AND m.id_type = 18";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
            
                case "tutor":
                    $this->title         = "Game Types As Interactive Tutorials";
                    $this->sqlClause = "AND m.id_type = 19";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
                
                case "sports":
                    $this->title         = "Game Types As Sports & Competition";
                    $this->sqlClause = "AND m.id_type = 20";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
            
                // Rating Specific Modes 'childhood', 'everyone', 'teenagers', 'mature', 'adults'
                // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
                case "childhood":
                    $this->title         = "Age Ratings As Early Childhood";
                    $this->sqlClause = "AND m.id_rating = 0";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
                
                case "everyone":
                    $this->title         = "Age Ratings As Everyone Else";
                    $this->sqlClause = "AND m.id_rating = 1";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
            
                case "teen":
                    $this->title         = "Age Ratings As Teenagers &amp; Up";
                    $this->sqlClause = "AND m.id_rating = 2";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
                
                case "mature":
                    $this->title         = "Age Ratings As Mature Content";
                    $this->sqlClause = "AND m.id_rating = 3";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
            
                case "adults":
                    $this->title         = "Age Ratings As Adults Only";
                    $this->sqlClause = "AND m.id_rating = 4";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
                                                    
                // Default, Show all games based on score
                // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *     
                default:
                    $this->title         = "Default";
                    $this->sqlClause = "AND m.id_type <= 10";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";    
                break;
            }
        }
                
        public function getListTotal()
        {
                global $db;
                
                // Get total amount of entries from list
                $sql = "
                        SELECT 
                                count(*) AS count 
                        FROM 
                                games AS m INNER JOIN
                                txm_users AS u ON
                                        m.id_user = u.id
                        WHERE
                                m.deleted = 0
                                " . $this->sqlClause . "
                ";
                
                $result = $db->sql_query($sql);
                
                if ($result === false) {
                        message_die(GENERAL_ERROR, 'Could not obtain Index Info (SQL).', $sql);
                } else {
                        $row = $db->sql_fetchrow($result);
                        $this->listTotal = $row["count"];
                }
        }
        
        public function buildList()
        {
                global $db, $template;
                                
                $sql = "
                        SELECT 
                                m.id,
                                u.id as id_user,
                                u.link_name,
                                u.nick_name,
                                m.title,
                                m.synopsis,
                                m.id_rating AS rating,
                                m.id_type AS type,
                                m.view_offset AS views,
                                m.vote_offset AS votes,
                                m.score_offset AS score
                        FROM 
                                games AS m INNER JOIN
                                txm_users AS u ON
                                        m.id_user = u.id
                        WHERE
                                m.deleted = 0
                                " . $this->sqlClause . "
                                " . $this->sqlOrder . "
                                LIMIT " . (LIMIT * ($this->page - 1)) . "," . LIMIT . "
                ";

                $result = $db->sql_query($sql);
                
                if ($result === false) {
                        message_die(GENERAL_ERROR, "We were unable to retrieve games.", $sql);
                } else if ($db->sql_numrows() === 0) {
                        $template->assign_block_vars("empty", array());
                } else {                    
                        $count = 0;
                        
                        // Build list for the given page and limit range
                        while(($row = $db->sql_fetchrow($result)) !== false)
                        {                
                                $this->_buildRow($row, $count);
                                $count++;
                        }
                }
        }

        private function _buildRow($row, $count)
        {                    
                global $template, $SITE;
                                                        
                $row["color"]          = $count % 2 === 0 ? COLOR_ALT : "";
                $row["title_link"] = str2link($row["title"]);
                $row["title"]          = htmlentities($row["title"]);
                $row["synopsis"]      = htmlentities($row["synopsis"]);
                $row["avatar"]          = (file_exists($SITE["level"] . "media/games/screenshots/" . $row["id"] . ".gif") === true ?
                        $SITE["fauxlvl"] . "media/games/screenshots/" . $row["id"] . ".gif" : 
                        $SITE["fauxlvl"] . "media/assets/games-icon.gif");
                    
                $template->assign_block_vars("listflash", $row);
        }
                
        public function pagination($page, $itemTotal, $itemPerPage = 25, $range = 10)        
        // function pages($base_url, $num_items, $per_page, $start_item)
        {
                global $template;
                
                $string = "";
                $pageTotal = ceil($itemTotal / $itemPerPage);
                
                // Assign pagination template
                $template->assign_block_vars("pagination", array());
                
                $rangeMin = intval(min(max($page - $range, 1), max($pageTotal - $range * 2, 1)));
                $rangeMax = intval(max(min($page + $range, $pageTotal), min(1 + $range * 2, $pageTotal)));
                
                if ($page > 1)                           { $template->assign_block_vars("pagination.row", array("page" => 1,                  "title" => "First")); }
                 
                // Display numbers for each page, and no link for current page
                for ($i = $rangeMin; $i <= $rangeMax; $i++) {
                        if (($i === $rangeMin && $rangeMin > 1) || ($i === $rangeMax && $rangeMax < $pageTotal)) { 
                                $title = "..."; 
                        } else if ($i === $page) {
                                $title = "<strong>Page " . $i . "</strong>";
                        } else {
                                $title = $i;
                        }
                        
                        $template->assign_block_vars("pagination.row", array("page" => $i, "title" => $title));
                }
                
                if ($page < $pageTotal)         { $template->assign_block_vars("pagination.row", array("page" => $pageTotal, "title" => "Last"));  }                
        }
        
        public function outputPage()
        {
                global $template;

                $template->assign_vars(array(
                        "mode"  => $this->mode,
                        "page"  => $this->page,
                        "total" => $this->listTotal,
                        "title" => $this->title,
                ));
        }
}

?>