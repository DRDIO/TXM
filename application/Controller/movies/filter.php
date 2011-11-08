<?php define("ROOT", TRUE);

define("PAGE_TITLE", "Movie Filters");
define("PAGE_COMMON", true);
define("AD_APPROVED", true); 
include_once("../includes/header.php");

define("LIMIT", 20);
define("RANGE", 5);
define("COLOR_ALT", "blu-alt");

$filter = new TXM_Movies_Filter();

include_once("../includes/footer.php");

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
class TXM_Movies_Filter
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
                
                // Movie Specific Modes 'comedy', 'drama', 'horror', 'noir', 'othermovies', 'parodies', 'series'
                // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *     
                case "comedy":
                    $this->title         = "Movie Types As Comedy Shorts";                
                    $this->sqlClause = "AND m.id_type = 1";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
            
                case "drama":
                    $this->title         = "Movie Types As Serious Drama";
                    $this->sqlClause = "AND m.id_type = 2";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
                
                case "horror":
                    $this->title         = "Movie Types As Horror Flicks";
                    $this->sqlClause = "AND m.id_type = 3";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
                
                case "noir":
                    $this->title         = "Movie Types As Dark Noir";
                    $this->sqlClause = "AND m.id_type = 4";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
                
                case "othermovies":
                    $this->title         = "Movie Types As Other Movies";
                    $this->sqlClause = "AND m.id_type = 5";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
            
                case "parodies":
                    $this->title         = "Movie Types As Parodies &amp; Sprites";
                    $this->sqlClause = "AND m.id_type = 6";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
                
                case "series":
                    $this->title         = "Movie Types As Continuing Series";
                    $this->sqlClause = "AND m.id_type = 7";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
            
                case "music":
                    $this->title         = "Movie Types As Music Videos";
                    $this->sqlClause = "AND m.id_type = 8";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
            
                case "action":
                    $this->title         = "Movie Types As High Octane Action";
                    $this->sqlClause = "AND m.id_type = 9";
                    $this->sqlOrder  = "ORDER BY m.score_offset DESC";
                break;
                
                case "fantasy":
                    $this->title         = "Movie Types As SciFi &amp; Fantasy";
                    $this->sqlClause = "AND m.id_type = 10";
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
                                                    
                // Default, Show all movies based on score
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
                                movies AS m INNER JOIN
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
                                movies AS m INNER JOIN
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
                        message_die(GENERAL_ERROR, "We were unable to retrieve movies.", $sql);
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
                $row["avatar"]          = (file_exists($SITE["level"] . "media/movies/screenshots/" . $row["id"] . ".gif") === true ?
                        $SITE["fauxlvl"] . "media/movies/screenshots/" . $row["id"] . ".gif" : 
                        $SITE["fauxlvl"] . "media/assets/movies-icon.gif");
                    
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