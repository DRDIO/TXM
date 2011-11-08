<?php 

define("ROOT", true);
define("PAGE_COMMON", true);
define("AD_APPROVED", true);
require_once("../includes/header.php");
require_once("includes/common.php");
                
final class SITE_Profiles_Index extends SITE_Profiles_Common
{
        private $userProfile = "";
        
        public function __construct()
        {
                parent::__construct();
                
                if ($this->autoTransferMedia() === true) {
                        $this->userProfile = $this->getUser();
                        
                        $this->getRankTitles();
                        $this->enhanceProfile();
                        $this->buildContacts();
                        $this->buildMovies();

                        // Get Friends for the 4 levels
                        // $this->buildFriends(intval($this->userProfile["id"]), 0);
                        // $this->buildFriends(intval($this->userProfile["id"]), 1);
                        // $this->buildFriends(intval($this->userProfile["id"]), 2);
                        // $this->buildFriends(intval($this->userProfile["id"]), 3);
                        
                        $this->outputPage();                        
                }
        }
        
        public function getProfileVar($var)
        {
                return isset($this->userProfile[$var]) === true ? $this->userProfile[$var] : "";
        }
                
        /**
         */            
        protected function autoTransferMedia()
        {                        
                $user = $this->getUserName();
                
                if (is_numeric($user) === true) {
                        $sql = "
                                SELECT
                                        id,
                                        title
                                FROM
                                        movies
                                WHERE
                                        id = " . intval($user) . "
                        ";
                    
                        if ($this->dbQuery($sql) !== false && $this->dbNumRows() > 0) {
                                $row = $this->dbFetch();
                                header("location: http://txm.com/movies/" . $row["id"] . "/" . str2link($row["title"]) . "/");
                                exit;
                        }
                        
                        $sql = "
                                SELECT
                                        id,
                                        title
                                FROM
                                        games
                                WHERE
                                        id = " . intval($user) . "
                        ";
                    
                        if ($this->dbQuery($sql) !== false && $this->dbNumRows() > 0) {
                                $row = $this->dbFetch();
                                header("location: http://txm.com/games/" . $row["id"] . "/" . str2link($row["title"]) . "/");
                                exit;
                        }                        
                } else {
                        return true;
                }
        }

        /**
         */            
        protected function getRankTitles()
        {        
                // Gather rank titles.
                $sql = "
                        SELECT 
                                * 
                        FROM 
                                " . RANKS_TABLE . " 
                        ORDER BY 
                                rank_special, rank_min
                ";
                
                if ($this->dbQuery($sql) === false) {
                        SITE_Log::error("Unable to retrieve rank titles.", $sql, false);
                
                } else {
                        $this->rankTitles = $this->dbFetchSet();                        
                }
        }
        
        /**
         */            
        protected function enhanceProfile()
        {                

        }
        
        /**
         */            
        protected function buildContacts()
        {
                global $SITE;
                
                // Setup Contacts
                /*
                $email = (!empty($this->userProfile['user_viewemail']) || intval($SITE["user"]["status"]) === LEVEL_ADMIN) ? "<A HREF='profile.php?mode=email&" . POST_USERS_URL . "={$this->userProfile["id"]}'>Mail To Contact</A>" : "";
                $www_title = $this->userProfile['user_website_title'] ? $this->userProfile['user_website_title'] : $this->userProfile['user_website'];
                $www  = $this->userProfile['user_website'] ? "<A HREF='{$this->userProfile['user_website']}' TARGET='_userwww'>{$www_title}</A>" : "";
                $www .= $this->userProfile['user_website_title'] ? "<BR>" . $this->userProfile['user_website_desc'] : "";
                $aim  = $this->userProfile['user_aim']  ? "<A HREF='aim:goim?screenname={$this->userProfile['user_aim']}&message=Are+you+{$this->userProfile["link_name"]}+from+TxMafia.COM+because+this+is+{$SITE["user"]["link_name"]}.'>{$this->userProfile['user_aim']}</A>" : "";
                $icq  = $this->userProfile['user_icq']  ? "<A HREF='http://wwp.icq.com/scripts/search.dll?to={$this->userProfile['user_icq']}'>{$this->userProfile['user_icq']}</A>" : "";
                $msn  = $this->userProfile['user_msnm'] ? "<A HREF='onMouseOver=trig_box(\"{$this->userProfile['user_msnm']}\");' onMouseOut='trig_box();'>View MSN Email</A>" : "";
                $yim  = $this->userProfile['user_yim']  ? "<A HREF='http://edit.yahoo.com/config/send_webmesg?.target={$this->userProfile['user_yim']}&.src=pg'>{$this->userProfile['user_yim']}</A>" : "";
                */
        }
        
        /**
         */            
        protected function buildMovies()
        {
                // Grab Ten Best of Author's Other Movies
                // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
                $sql = "
                    SELECT 
                        id,
                        title,
                        synopsis
                    FROM
                        movies
                    WHERE
                        id_user = " . intval($this->userProfile["id"]) . " AND
                        deleted = 0
                    ORDER BY 
                        date DESC
                    LIMIT
                        0, 5
                ";
                
                if ($this->dbQuery($sql) !== false) {
                        if ($this->dbNumRows() > 0) {
                                $this->tlSetSwitch("profile_movies");
                                
                                $count = 0;
                                while (($more = $this->dbFetch()) !== false) {
                                        $more["color"]             = $count++ % 2 === 0 ? "blu-alt" : "";
                                        $more["title_link"] = str2link($more["title"]);
                                        $more["title"]             = htmlentities($more["title"]);
                                        $more["synopsis"]     = htmlentities($more["synopsis"]);
                                        
                                        $avatarSrc = "media/movies/screenshots/" . $more["id"] . ".gif";                                        
                                        $more["avatar"]         = (file_exists("../" . $avatarSrc) === true ?
                                                $avatarSrc : "media/assets/movies-icon.gif");

                                        $this->tlSetBlock("profile_movies.row", $more);
                                }
                        }            
                } else {
                        SITE_Log::error("We were unable to retrieve other movies by author.", $sql);
                }            
        }    
        
        /**
         */            
        protected function outputPage()
        {        
                global $SITE;
                
                // Calculate the number of days this user has been a member then calculate their posts per day.
                $regdate              = strtotime($this->userProfile["date_register"]);
                $memberdays    = max(1, round((time() - $regdate) / 86400));
                $posts_per_day = $this->userProfile['user_posts'] / $memberdays;
                $percentage    = 0; // Get percentage of posts users has submitted
                
                $this->userProfile["avatar"] = (file_exists($SITE["level"] . "media/profiles/avatars/" . $this->userProfile["id"] . ".gif") === TRUE ?
                     "profiles/avatars/" . $this->userProfile["id"] : "assets/movies-icon");                 
                
                $button_panel = '';
                $poster_rank = '';
                $rank_image = '';
                if ( $this->userProfile['user_rank'] )
                {
                    for($i = 0; $i < count($this->rankTitles); $i++)
                    {
                        if ( $this->userProfile['user_rank'] == $this->rankTitles[$i]['rank_id'] && $this->rankTitles[$i]['rank_special'] )
                        {
                            $poster_rank = $this->rankTitles[$i]['rank_title'];
                            $rank_image = ( $this->rankTitles[$i]['rank_image'] ) ? '<img src="' . $this->rankTitles[$i]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
                        }
                    }
                }
                else
                {
                    for($i = 0; $i < count($this->rankTitles); $i++)
                    {
                        if ( $this->userProfile['user_posts'] >= $this->rankTitles[$i]['rank_min'] && !$this->rankTitles[$i]['rank_special'] )
                        {
                            $poster_rank = $this->rankTitles[$i]['rank_title'];
                            $rank_image = ( $this->rankTitles[$i]['rank_image'] ) ? '<img src="' . $this->rankTitles[$i]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
                        }
                    }
                }
                
                $temp_url = "privmsg.php?mode=post&amp;" . POST_USERS_URL . "=" . $this->userProfile["id"];
                        
                // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
                
                $array_photo_type = array('error', 'gif', 'jpg', 'png');
                $array_sex = array('Undeclared', 'Female', 'Male');
                                    
                // Begin Display Outputs
                $born = !empty($this->userProfile['pi_born']) ? $this->userProfile['pi_born'] : '';
                if($born)
                {
                    $date['date_day'] = substr($born, 6, 2);
                    $date['date_month'] = substr($born, 4, 2);
                    $date['date_year'] = substr($born, 0, 4);
                    
                    $day_options                 = '';
                    $month_options             = '';
                    $year_options             = '';
                    $date_day_prefix        = array('st', 'nd', 'rd');
                    $date_month_prefix     = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                        
                    for ($i = 1; $i <= 31; $i++) 
                    {
                        if($i == intval($date['date_day']))
                        {
                            $date_prefix_i = ($i - 1) % 10;
                            $day_str = ($date_prefix_i < 3 && ($i < 11 || $i > 13)) ? $i . $date_day_prefix[$date_prefix_i] : $i . 'th';
                        }
                    }
                    
                    for ($i = 1; $i <= 12; $i++) 
                    {
                        if($i == intval($date['date_month']))
                        {
                            $month_str = $date_month_prefix[$i - 1];
                        }
                    }
                    
                    for ($i = date('Y'); $i >= date('Y') - 100; $i--) 
                    {
                        if($i == intval($date['date_year']))
                        {
                            $year_str = $i;
                        }
                    }
                    
                    $born = $month_str . ' ' . $day_str . ', ' . $year_str;
                }
                
                $sex = !empty($this->userProfile['pi_sex']) ? $array_sex[$this->userProfile['pi_sex']] : 0;
                
                // Write Notes
                $this->tlSetBlock('writenote', array());
                
                // Personal Information
                if ($this->userProfile['pi_status'] || $this->userProfile['pi_interests'] || $this->userProfile['pi_about']) {
                        $this->tlSetBlock('personal_information', array());
                }
                
                // Favorites
                if ($this->userProfile['fv_music'] || $this->userProfile['fv_movies'] || $this->userProfile['fv_games'] || $this->userProfile['fv_books'] || $this->userProfile['fv_artists'] || $this->userProfile['fv_quotes']) { 
                        $this->tlSetBlock('favorites', array());
                }

                $photoSrc = "media/profiles/photos/" . $this->getUserId() . ".gif";
                if(file_exists("../" . $photoSrc) !== false)
                {
                    $this->tlSetBlock("profile_photo", array("image" => $photoSrc));
                }
                
                $avatarSrc = "media/profiles/avatars/" . $this->getUserId() . ".gif";
                $this->userProfile["avatar"] = (file_exists("../" . $avatarSrc) === true ?
                        $avatarSrc : "media/assets/movies-icon.gif");
                
                $sql = "SELECT MAX(respect) AS max FROM " . USERS_TABLE;
                
                if ($this->dbQuery($sql) !== false) {                
                        if ($this->dbNumRows() > 0) {
                                $row = $this->dbFetch();
                                $respextMax = $row["max"];
                        }
                } else {
                        SITE_Log::error("Unable to obtain respect max.", $sql, false);
                }
                
                
                $this->tlSetVars(array(
                    // Contacts
                    /*
                    'EMAIL'                     => $this->createProfileTableSub('Email', $email),
                    'AIM'                         => $this->createProfileTableSub('AIM', $aim),
                    'ICQ'                         => $this->createProfileTableSub('ICQ', $icq),
                    'MSN'                         => $this->createProfileTableSub('MSN', $msn),
                    'YIM'                         => $this->createProfileTableSub('YIM', $yim),
                */
                
                    // Member Profile
                    'PROFILE_ID'            => $this->userProfile["id"],
                    "link_name"             => $this->userProfile["link_name"],
                    "nick_name"                => $this->userProfile["nick_name"],
                    "avatar"                    => $this->userProfile["avatar"],
                
                    'LAST_VISIT'                => date("D, M jS, Y, \a\t h:i a", strtotime($this->userProfile["date_last"])),
                        
                    // Basic Information
                    'JOINED'                        => $this->createProfileTable("Joined", date("D, M jS, Y, \a\t h:i a", strtotime($this->userProfile["date_register"]))),
                    'BORN'                            => $this->createProfileTable('Born', $born),
                    'SEX'                                => $this->createProfileTable('Sex', $sex),
                    'WEBSITE'                        => $this->createProfileTable('Website', $this->userProfile["user_website"]),
                    // Txmafia Activity
                    'POSTS'                         => $this->userProfile['user_posts'],
                    'POST_DAY'                     => number_format($posts_per_day, 2), 
                    'POST_PERCENT'             => number_format($percentage, 2),
                    
                    'RESPECT'                            => $this->userProfile['respect'],
                    'RESPECT_PERCENT'     => sprintf("%01.2f", 100 * intval($this->userProfile['respect']) / intval($respextMax)),
                        
                    // Personal Information
                    'NAME'                        => $this->createProfileTable('Name', $this->userProfile['full_name']),
                    'PI_STATUS'                => $this->createProfileTable('Relationship', $this->userProfile['pi_status']),
                    'PI_INTERESTS'        => $this->createProfileTable('Interests', $this->userProfile['pi_interests']), 
                    'PI_ABOUT'                => $this->createProfileTable('About Me', $this->userProfile['pi_about']),
                    
                    // Favorites
                    'FV_MUSIC'                => $this->createProfileTable('Music', $this->userProfile['fv_music']),
                    'FV_MOVIES'                => $this->createProfileTable('Movies', $this->userProfile['fv_movies']),
                    'FV_GAMES'                => $this->createProfileTable('Games', $this->userProfile['fv_games']),
                    'FV_BOOKS'                => $this->createProfileTable('Books', $this->userProfile['fv_books']),
                    'FV_ARTISTS'            => $this->createProfileTable('Artists', $this->userProfile['fv_artists']),
                    'FV_QUOTES'                => $this->createProfileTable('Quotes', $this->userProfile['fv_quotes']),
                    
                    // Extras
                    'BUTTONS'                    => $button_panel,
                    'AVATAR'                    => $this->userProfile["avatar"],
                ));
        }
                
        /**
         */            
        protected function createProfileTableSub($key, $value)
        {
                return "<tr><td align=\"left\">" . $key . ":</td><td align=\"left\">" . nl2br($value) . "</td></tr>";
        }
        
        /**
         */            
        protected function createProfileTable($key, $value)
        {
                return "<tr><td valign=\"top\" class=\"info\">" . $key . ":</td><td class=\"profile\" STYLE=\"padding-bottom: 8px;\">" . nl2br($value) . "</td></tr>";
        }
                    
        /**
         */            
        protected function dressWardrobe()
        {
                $wardrobe0 = array(); // complete outfits
                $wardrobe1 = array(); // tops
                $wardrobe2 = array(); // bottoms
                $wardrobe3 = array(); // accessories
                
                array_push($wardrobe0, "a prom dress");
                array_push($wardrobe0, "a sumo suit");
                array_push($wardrobe0, "superman underoos");
                array_push($wardrobe0, "absolutely nothing");
                array_push($wardrobe0, "a tube sock");
                array_push($wardrobe0, "leather bondage");
                array_push($wardrobe0, "a sailor's uniform");
                array_push($wardrobe0, "a slinky dress");
                array_push($wardrobe0, "a wedding dress");
                array_push($wardrobe0, "a wet-suit");
                array_push($wardrobe0, "a suit of armor");
                array_push($wardrobe0, "just body paint");
                array_push($wardrobe0, "a french maid outfit");
                array_push($wardrobe0, "a nurse's uniform");
                array_push($wardrobe0, "footy pajamas");
                array_push($wardrobe0, "a jump suit");
                array_push($wardrobe0, "a space suit");
                array_push($wardrobe0, "tin foil");
                array_push($wardrobe0, "a bra and panties");
                array_push($wardrobe0, "a toga");
                
                array_push($wardrobe1, "a Mr. T t-shirt");
                array_push($wardrobe1, "a tube top");
                array_push($wardrobe1, "a push-up bra");
                array_push($wardrobe1, "a pink sweater");
                array_push($wardrobe1, "no shirt");
                array_push($wardrobe1, "nipple warmers");
                array_push($wardrobe1, "a leather jacket");
                array_push($wardrobe1, "a denim jacket");
                array_push($wardrobe1, "a t-shirt");
                array_push($wardrobe1, "a sweater");
                array_push($wardrobe1, "a Spongebob shirt");
                array_push($wardrobe1, "nipple rings");
                array_push($wardrobe1, "a live preserver");
                array_push($wardrobe1, "water wings");
                array_push($wardrobe1, "a tank top");
                array_push($wardrobe1, "a v-neck");
                array_push($wardrobe1, "a spandex shirt");
                array_push($wardrobe1, "a 'fake tie' T");
                array_push($wardrobe1, "a 'fake muscles' T");
                array_push($wardrobe1, "a TxM fanclub jacket");
                array_push($wardrobe1, "a parka");
                array_push($wardrobe1, "a bear skin");
                array_push($wardrobe1, "a fur coat");
                array_push($wardrobe1, "a silk robe");
                array_push($wardrobe1, "a fishnet top");
                array_push($wardrobe1, "a bulletproof vest");
                array_push($wardrobe1, "a stuffed wonderbra");
                array_push($wardrobe1, "duct taped dynomite");
                
                array_push($wardrobe2, "overalls");
                array_push($wardrobe2, "tighty whiteys");
                array_push($wardrobe2, "a speedo");
                array_push($wardrobe2, "bell bottoms");
                array_push($wardrobe2, "blue jeans");
                array_push($wardrobe2, "leather chaps");
                array_push($wardrobe2, "parachute pants");
                array_push($wardrobe2, "a long skirt");
                array_push($wardrobe2, "a short skirt");
                array_push($wardrobe2, "pink panties");
                array_push($wardrobe2, "no pants");
                array_push($wardrobe2, "boxer shorts");
                array_push($wardrobe2, "khakis");
                array_push($wardrobe2, "biker shorts");
                array_push($wardrobe2, "a jock strap");
                array_push($wardrobe2, "wrestling tights");
                array_push($wardrobe2, "a diaper");
                array_push($wardrobe2, "jogging pants");
                array_push($wardrobe2, "jogging shorts");
                array_push($wardrobe2, "tear away pants");
                array_push($wardrobe2, "cotton briefs");
                array_push($wardrobe2, "black pants");
                array_push($wardrobe2, "leather pants");
                array_push($wardrobe2, "shorts");
                array_push($wardrobe2, "short shorts");
                array_push($wardrobe2, "Daisy Dukes");
                array_push($wardrobe2, "a thong");
                
                array_push($wardrobe3, "bunny slippers");
                array_push($wardrobe3, "a top hat");
                array_push($wardrobe3, "a frankenstien mask");
                array_push($wardrobe3, "yellow bikini");
                array_push($wardrobe3, "tube socks");
                array_push($wardrobe3, "pantyhose");
                array_push($wardrobe3, "a beer hat");
                array_push($wardrobe3, "a powdred wig");
                array_push($wardrobe3, "an eye patch");
                array_push($wardrobe3, "handcuffs");
                array_push($wardrobe3, "a pearl necklace");
                array_push($wardrobe3, "a bandana");
            
                array_push($wardrobe3, "a Marge Simpson wig");
                array_push($wardrobe3, "a bald-cap");
                array_push($wardrobe3, "french perfume");
                array_push($wardrobe3, "a chastity belt");
                array_push($wardrobe3, "a tin-foil hat");
                array_push($wardrobe3, "a paper hat");
                array_push($wardrobe3, "a bike helmet");
                array_push($wardrobe3, "red lipstick");
                array_push($wardrobe3, "stilletto heels");
                array_push($wardrobe3, "a blindfold");
                array_push($wardrobe3, "a gun holster");
                array_push($wardrobe3, "a backpack");
                        
                // grab one entry from each wardrobe array
                // ===========================================================================
                $suit             = $wardrobe0[rand(0, count($wardrobe0)-1)];
                $shirt             = $wardrobe1[rand(0, count($wardrobe1)-1)];
                $pants             = $wardrobe2[rand(0, count($wardrobe2)-1)];
                $accessory     = $wardrobe3[rand(0, count($wardrobe3)-1)];
                
                // Randomly decide what wardrobe groups to use, then dress the user
                // ===========================================================================
                $outfit = rand(1,500);
                
                if ($outfit > 400)             $wardrobe = $suit;
                else if ($outfit > 300) $wardrobe = $suit  . " and " . $accessory;
                else if ($outfit > 200) $wardrobe = $shirt . " and " . $pants;
                else if ($outfit > 100) $wardrobe = $shirt . " and " . $accessory;
                else $wardrobe = $pants . " and " . $accessory;
                
                return $wardrobe;
        }                        
                
        /**
         */            
        protected function buildFriends($id, $level)
        {            
                $id    = intval($id);
                $level = intval($id);
                    
                $sql = "
                        SELECT 
                                count(*) AS total 
                        FROM 
                                " . FRIENDS_TABLE . " 
                        WHERE 
                                level = " . $level . " AND 
                                user_id_1 = " . $id . "
                ";
                
                if ($this->dbQuery($sql) !== false) {
                        if ($this->dbNumRows() > 0) {
                                $friendGroup = $this->dbFetch();
                                $friendGroup["shown"] = min(12, $friendGroup["total"]);
                                $friendGroup["level"] = $level;
                                
                                $this->tlSetBlock("friends_exist_" . $level, $friendGroup);
                                
                                // If so, grab a list of friends
                                $sql = "
                                        SELECT 
                                                u.id, 
                                                u.link_name, 
                                                f.level 
                                        FROM 
                                                " . USERS_TABLE . " u INNER JOIN 
                                                " . FRIENDS_TABLE . " f ON
                                                        u.user_id = f.user_id_2
                                        WHERE 
                                                f.level = " . $level . " AND
                                                f.user_id_1 = " . $id . "
                                        ORDER BY RAND() 
                                        LIMIT 12
                                "; 
                                                
                                
                                if ($this->dbQuery($sql) !== false) {
                                        while ($friends = $this->dbFetch($result)) {
                                                $profileSrc = "media/profiles/avatars/" . $friends["id"] . ".gif";
                                                $friends["avatar"] = (file_exists("../" . $profileSrc) === true ?
                                                        $profileSrc : "media/assets/movies-icon.gif");    
                                                
                                                $this->tlSetBlock("friends_" . $level, $friends);                                                
                                        }
                                } else {
                                        SITE_Log::error("Unable to retrieve friend details.", $sql, false);
                                }
                        }
                } else {
                        SITE_Log::error("Unable to retrieve friends.", $sql, false);
                }                    
        }
}

$page = new SITE_Profiles_Index();
define("PAGE_TITLE", $page->getProfileVar("nick_name") . " " . $page->getProfileVar("link_name") . ".txm.com");
                                
include("../includes/footer.php");

?>