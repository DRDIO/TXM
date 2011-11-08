<?php 

define("ROOT", true);
define("SECURITY", 1);
include_once("../includes/header.php");

final class SITE_Forums_Reply extends SITE_Legacy
{
        private $post;
        public $pageTitle;
        
        public function __construct()
        {
                // parent::__construct();
                $this->post = array(
                        "id_topic" => "",
                        "post"          => "",
                        "title"      => "",
                        "forum"      => "",
                );
                
                $this->process();
        }
        
        protected function process()
        {
                if ($this->getPost() === true) {
                        if (isset($_POST["submit"]) === true) {
                                if ($this->post["post"] === "") {
                                        $this->setError("Please provide a post to submit.");
                                        return false;
                                } else {
                                        // Parse the post, strip invalid HTML, center images and objects, remove empty code
                                        include_once("functions/format.php");
                                        $this->post["post"] = format_post($this->post["post"]);
                                
                                        // Lets make sure they are actually wriing something after all that parsing
                                        if ($this->post["post"] === "") {
                                                $this->setError("Your post has become too small after stripping HTML.");
                                                return false;
                                        } else {
                                                return $this->updateSql();
                                        }
                                }
                        }
                                                
                        if (isset($_POST["submit"]) === false || $this->getErrorCount() > 0) {
                                $this->post = array_map("htmlentities", $this->post);
                                $this->tlSetBlock("post", $this->post);                                                                                                
                        }
                }
        }
                                                
        protected function updateSQL()
        {
                global $SITE;
                
                $sql = "
                        INSERT INTO
                                forums_topics_posts
                        SET
                                id_topic = " . $this->post["id_topic"] . ",
                                id_user = " . $SITE["user"]["id"] . ",
                                post = '" . addslashes($this->post["post"]) . "',
                                date = NOW(),
                                date_edit = NOW()
                ";
                
                if ($this->dbQuery($sql) === false) {
                        SITE_Log::error("We were unable to add your comment.", $sql);
                } else {                                                
                        $sql = "
                                UPDATE
                                        forums_topics
                                SET
                                        replies = replies + 1
                                WHERE
                                        id = " . $this->post["id_topic"] . "
                        ";
                        
                        if ($this->dbQuery($sql) === false) {
                                SITE_Log::warning("We were unable to update forum count.", $sql, false);
                        } else {
                                // SUCCESS - Show them their results
                                $id_post = intval($this->dbNextId());                        
                                header("location: " . $SITE["fauxlvl"] . "forums/" . $this->post["id_topic"] . "/" . str2link($this->post["title"]) . "/" . $id_post . "/");
                                return true;
                        }
                }
        }
        
        protected function getPost()
        {
                $this->post = array(
                        "id_topic"    => intval(isset($_POST["id_topic"]) === true ? $_POST["id_topic"] : (isset($_GET["id"]) === true ? $_GET["id"] : 0)),
                        "post"            => isset($_POST["post"]) === true ? $_POST["post"] : "",
                );
                
                if ($this->post["id_topic"] === 0) {
                        SITE_Log::display("No topic was provided.", "Oops!");
                        return false;
                } else {
                        $sql = "
                                SELECT
                                        t.title,
                                        f.name AS forum,
                                        t.deleted
                                FROM
                                        forums_topics AS t INNER JOIN
                                        forums AS f ON t.id_forum = f.id
                                WHERE
                                        t.id = " . $this->post["id_topic"] . "
                        ";
                        
                        if ($this->dbQuery($sql) === false) {
                                SITE_Log::error("We are unable to retrieve topic.", $sql);
                                return false;                                
                        } else if ($this->dbNumRows() !== 1) {
                                SITE_Log::warning("Topic '" . $this->post["id_topic"] . "' does not exist.");
                                return false;
                        } else {
                                // Grab title of topic and forum for display
                                $row = $this->dbFetch();
                                
                                if (intval($row["deleted"]) !== 0) {                
                                        SITE_Log::display("Topic '" . $row["title"] . "' has been deleted.", "Oops!");                            
                                        return false;
                                } else {
                                        $this->pageTitle = "Comment On '" . htmlentities($this->post["title"]) . "'";
                                    
                                        $this->post["title"] = $row["title"];
                                        $this->post["forum"] = $row["forum"];
                                        return true;
                                }
                        }
                }                
        }    
        
        public function getPageTitle()
        {
                return $pageTitle;
        }            
}

$page = new SITE_Forums_Reply();

define("PAGE_TITLE", $page->pageTitle);

include_once("../includes/footer.php");

?>