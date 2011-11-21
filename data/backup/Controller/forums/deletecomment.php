<?php 

define("ROOT", true);
require_once("../includes/header.php");

/**
 */
final class SITE_Forums_DeleteComment extends SITE_Legacy
{    
        private $userId;
        private $postId;
        private $ajax;
        
        public function __construct()
        {
                global $SITE;
                $this->userId = intval($SITE["user"]["id"]);
            
                $this->id = 0;
                $this->ajax = false;
                
                if ($this->getPost() === true) {
                        if ($this->getComment() === true) {
                                if ($this->deleteComment() === true) {
                                        $this->outputPage();
                                }
                        }
                }
        }

        protected function getPost()
        {
                if (isset($_POST["method"]) === true && $_POST["method"] === "ajax") {
                        $this->ajax = true;
                }

                if ($this->ajax === true) {
                        if (isset($_POST["id"]) === true) {
                                $this->postId = intval($_POST["id"]);
                                return true;
                        }
                } else {
                        if (isset($_GET["id"]) === true) {
                                $this->postId = intval($_GET["id"]);
                                return true;
                        }
                }
                
                return false;    
        }
                
        protected function getComment()        
        {
                $sql = "
                        SELECT
                                id
                        FROM
                                forums_topics_posts
                        WHERE
                                id = " . $this->postId . " AND
                                id_user = " . $this->userId . "
                ";

                if ($this->dbQuery($sql) === false) {
                        SITE_Log::error("We are unable to retrieve comment.", $sql);
                } else if ($this->dbNumRows() !== 1) {
                        SITE_Log::warning("Comment does not exist.");
                } else {
                        return true;
                }
                
                return false;
        }
        
        protected function deleteComment()
        {
                $sql = "
                        UPDATE
                                forums_topics_posts
                        SET
                                deleted = 1
                        WHERE
                                id = " . $this->postId . "
                ";

                if ($this->dbQuery($sql) === false) {
                        SITE_Log::error("We are unable to delete comment.", $sql);
                } else {
                        return true;
                }        
                
                return false;                                                
        }
            
        protected function outputPage()
        {
                if ($this->ajax === true) {
                        header('X-JSON: ({"success":1})');
                        exit;
                } else {
                        SITE_Log::display("Comment has been deleted");
                }
                
                return true;
        }                
}

$page = new SITE_Forums_DeleteComment();

define("PAGE_TITLE", "Delete Comment");
require_once("../includes/footer.php");

?>