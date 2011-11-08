<?php

require_once("../includes/legacy.php");

class SITE_Profiles_Common extends SITE_Legacy
{
        private $user;
        private $userId;        
        private $userName;
        private $userValid;
        
        protected function __construct()
        {
                parent::__construct();
                
                $this->user        = array();
                $this->userId    = 0;
                $this->userName  = "";
                $this->userValid = false;
                
                $this->_setUser();
                if ($this->_getUserProfile() === true) {
                        $this->_buildCommonPage();
                }                
        }
        
        protected function getUserId()
        {
                return $this->userId;
        }

        protected function getUserName()
        {
                return $this->userName;
        }    
        
        protected function getUser()
        {
                return $this->user;
        }                

        protected function isUserValid()
        {
                return $this->userValid;
        }
                
        private function _setUser()
        {
                $this->userName = strtolower(isset($_GET["id"]) === true ? $_GET["id"] : "");
                return true;
        }
        
        private function _getUserProfile()
        {
                global $db;
                
                if (empty($this->userName) === false) {
                        $sql = "
                                SELECT 
                                        id,
                                        link_name,
                                        nick_name,
                                        full_name,
                                        date_register,
                                        date_last,
                                        user_rank,
                                        user_posts,
                                        user_website,
                                        user_website_title,            
                                        status,
                                        user_points,
                                        respect,
                                        pi_born,
                                        pi_sex,
                                        pi_status,
                                        pi_interests,
                                        pi_about,
                                        fv_music,
                                        fv_movies,
                                        fv_games,
                                        fv_books,
                                        fv_artists,
                                        fv_quotes,
                                        deleted
                                FROM 
                                        txm_users
                                WHERE 
                                        link_name = '" . addslashes($this->userName) . "'
                        ";
                        
                        $result = $this->dbQuery($sql);
                        
                        if ($result !== false) {
                                if ($this->dbNumRows($result) === 1) {
                                        $this->user     = $this->dbFetch($result);
                                        $this->userId = intval($this->user["id"]);
                                        
                                        if (intval($this->user["deleted"]) === 0) {
                                                $this->userValid = true;
                                                return true;
                                        
                                        } else {
                                                SITE_Log::Warning("TXM Member '" . $this->userId . "' has been banned / deleted.");
                                                return false;
                                        }
        
                                } else {
                                        SITE_Log::Warning("TXM Member '" . $this->userId . "' does not exist.");
                                        return false;
                                }
                        } else {
                                SITE_Log::Error("Unable to retrieve TXM Member for ID #" . $this->userId . ".", $sql);
                                return false;
                        }                                
                } else {
                        SITE_Log::Warning("No TXM Member name provided.");
                        return false;                
                }
        }
        
        private function _buildCommonPage()
        {
                global $SITE;
                
                if ($this->isSelf() === true)
                {
                        $this->tlSetSwitch("profile_admin");
                        
                } else if($SITE["user"]["logged"] === true) {
                        $sql = "
                                SELECT 
                                        level 
                                FROM 
                                        " . FRIENDS_TABLE . "
                                WHERE 
                                        user_id_1 = " . intval($SITE["user"]["id"]) . " AND 
                                        user_id_2 = " . $this->userId . "
                        ";

                        if ($this->dbQuery() !== false) {
                                if ($this->dbNumRows() === 1) {
                                        $row = $this->dbFetch($result);
                                        $level = intval($row["level"]);
                                        
                                        if ($level < 3) {
                                                $this->tlSetSwitch("profile_promoteFriend");
                                        }
                                        
                                        if ($level > 0) {
                                                $this->tlSetSwitch("profile_demoteFriend");
                                        }
                                        
                                        $this->tlSetSwitch("profile_deleteFriend");
        
                                } else {
                                        $this->tlSetSwitch("profile_addFriend");
                                }
                        } else {
                                SITE_Log::Error("Unable to retrieve friend level for ID #" . $this->userId . ".", $sql);
                                return false;
                        }    
                }
        }
        
        protected function isSelf()
        {
                global $SITE;
                return (is_array($SITE) === true && isset($SITE["user"]) === true && isset($SITE["user"]["id"]) === true && 
                              $this->userId !== 0 && $this->userId === intval($SITE["user"]["id"]));
        }
}

?>