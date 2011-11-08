<?php 

define("ROOT", true);
define("PAGE_TITLE", "Upload Movies");
define("SECURITY", 1);
include_once("../includes/header.php");

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
final class SITE_Media_View extends SITE_Legacy
{
        const LIMIT = 2;
        const INTERVAL = 8;

        protected $idUser;
        protected $media;
        public $postVars;        
        
        public function __construct($media = "")
        {
                parent::__construct();
                
                $this->postVars = array();
                $this->idUser = $this->getUserVar("id");

                $this->media = ($media === "movie" || $media === "game") ? $media : "movie";

                if ($this->limitUploads() === true) 
                {    
                        $this->initPostVars();
                }                
        }
        
        // Limit the amount of uploads per user for a set hourly interval
        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
        protected function limitUploads()
        {
                $limit      = self::LIMIT;
                $interval   = self::INTERVAL;
                
                // Create fancy phrases for display
                $sLimit     = $this->pluralize($limit,    $this->media);
                $sInterval  = $this->pluralize($interval, "hour");
                
                // Get the total number of movies uploaded in an interval from a user                
                $sql = "
                        SELECT
                                COUNT(id) AS total,
                                TIME_FORMAT(TIMEDIFF(MIN(date) + INTERVAL " . $interval . " HOUR, NOW()), '%I') AS hours,
                                TIME_FORMAT(TIMEDIFF(MIN(date) + INTERVAL " . $interval . " HOUR, NOW()), '%i') AS minutes
                        FROM
                                " . $this->media . "s
                        WHERE
                                id_user = " . $this->idUser . " AND
                                date > NOW() - INTERVAL " . $interval . " HOUR
                ";
                
                if ($this->dbQuery($sql) === false) {
                        SITE_Log::error("We were unable to retrieve list of " . $this->media . " uploads.", $sql);
                        return false;
                } else {
                        $row   = $this->dbFetch();
                        $total = intval($row["total"]);
                        
                        // If there are more movies than allowed per limit and interval, output warning
                        if ($total >= $limit) {
                                $hours     = intval($row["hours"]);
                                $minutes   = intval($row["minutes"]);
                                
                                $sTotal    = $this->pluralize($total,   $this->media);
                                $sHours    = $this->pluralize($hours,   "hour");
                                $sMinutes  = $this->pluralize($minutes, "minute");
        
                                SITE_Log::display(
                                    "You may only upload <strong>" . $sLimit . "</strong> every <strong>" . $sInterval . "</strong>.<br />
                                            You have " . $sTotal . " with " . $sHours . " and " . $sMinutes . " remaining.",
                                    "Uh Oh! Movie Limit Reached!");  
                                                             
                                return false;
                        }
                }
                
                $this->tlSetVars(array(
                        "limit"    => $sLimit, 
                        "interval" => $sInterval));
                        
                return true;
        }
        
        protected function initPostVars()
        {        
                $this->postVars = array(
                        "file"                => "../media/temp/ms" . $this->idUser . ".swf",
                        "icon"                => "../media/temp/mi" . $this->idUser . ".gif",
                        "title"             => isset($_POST["title"])             ? stripslashes($_POST["title"])             : "",
                        "synopsis"         => isset($_POST["synopsis"])         ? stripslashes($_POST["synopsis"])         : "",
                        "commentary"     => isset($_POST["commentary"])     ? stripslashes($_POST["commentary"])     : "",
                        "keywords"         => isset($_POST["keywords"])         ? stripslashes($_POST["keywords"])         : "",
                        "id_rating"     => isset($_POST["id_rating"])     ? $_POST["id_rating"]     : "",
                        "id_type"         => isset($_POST["id_type"])         ? $_POST["id_type"]         : "",
                        "validate"         => isset($_POST["validate"])         ? $_POST["validate"]         : "",
                        "file_temp"        => isset($_POST["file_temp"])     ? $_POST["file_temp"]     : "",
                        "icon_temp"        => isset($_POST["icon_temp"])     ? $_POST["icon_temp"]     : "",
                );
                
                return true;        
        }
        
        // Takes a number and a word and combines them into a sentence (1 hour / 2 hours)
        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
        private function pluralize($number, $word)
        {
                return ($number . " " . $word . ($number !== 1 ? "s" : ""));        
        }
}

$page = new SITE_Media_View();

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 

$options = array(
    "id_rating" => array(
        "" => "Choose a rating...",
        "1" => "Childhood - Content may be suitable for ages 3 and older.",
        "2" => "Everyone - Content may be suitable for persons ages 6 and older.",
        "3" => "Teenagers - Content may be suitable for persons ages 13 and older.",
        "4" => "Mature - Content may be suitable for persons ages 17 and older.",
        "5" => "Adults Only - Content only suitable for adults ages 18 and older.",
    ),
    
    "id_type" => array(
        ""         => "Choose a category...",
        "9"     => "Action - High speed action flicks with cars, guns, and explosions.",
        "1"     => "Comedy - Various forms of humour from jokes to people exploding.",
        "2"     => "Drama - Emotional themes with a strong story.  Includes suspense.",
        "10"     => "Fantasy - This encompasses medieval and science fiction films.",        
        "5"     => "General - Any other type of film not mentioned here.",            
        "3"     => "Horror - Scary films that induce fear into the hearts of viewers.",
        "8"     => "Music - Music videos or short films centered around music.",
        "4"     => "Noir - Films that cater to the more artistic nature of humanity.",
        "6"     => "Parody- Imitation at its finest.  Often includes sprite films.",
        "7"        => "Series - An option for continuing films with a strong theme.",
    ),
);

$postlist = $page->postVars;

if(isset($_POST["upload"]) === TRUE)
{
    if($postlist["title"] === "")
    {
        $errors[] = "Please provide a title.";
    }
    
    if(file_exists($postlist["file"]) === FALSE)
    {
        $postlist["file_temp"] = "";
        $errors[] = "Unable to locate movie file.  Please upload again.";
    }            
    else
    {
        $temp_attr = getimagesize($postlist["file"]);
        $divisor = min(1, 778 / $temp_attr[0], 578 / $temp_attr[1]);
        
        $postlist["size"] = round(filesize($file) / 1024);
        $postlist["width"] = round($temp_attr[0] / $divisor);
        $postlist["height"] = round($temp_attr[1] / $divisor);
    }    
        
    $postlist["keywords"] = explode(" ", trim(preg_replace(array("/,/", "/[^a-z0-9 ]/", "/ +/"), array(" ","", " "), strtolower($postlist["keywords"]))), 10);
    array_pop($postlist["keywords"]);
    $postlist["keywords"] = implode(" ", $postlist["keywords"]);
    
    if($postlist["id_rating"] === "" || array_key_exists($postlist["id_rating"], $options["id_rating"]) === FALSE)
    {
        $errors[] = "Please provide a valid rating.";            
    }
    
    if($postlist["id_type"] === "" || array_key_exists($postlist["id_type"], $options["id_type"]) === FALSE)
    {
        $errors[] = "Please provide a valid movie type.";
    }

    if(file_exists($postlist["icon"]) === FALSE)
    {
        $postlist["temp_icon"] = "";
    }
    
    if($postlist["validate"] === "" || strtolower($SITE["user"]["captcha"]) !== strtolower($postlist["validate"]))
    {
        $errors[] = "Please retype the six letters provided for validation.";
    }

    if(sizeof($errors) === 0)
    {
        // Start SQL Upload
        $sql = "
            INSERT INTO 
                movies
            SET
                id_user = " . $SITE["user"]["id"] . ",
                title = '" . str_replace("'", "\'", $postlist["title"]) . "',
                synopsis = '" . str_replace("'", "\'", $postlist["synopsis"]) . "',
                commentary = '" . str_replace("'", "\'", $postlist["commentary"]) . "',
                keywords = '" . str_replace("'", "\'", $postlist["keywords"]) . "',
                id_rating = " . intval($postlist["id_rating"]) . ",
                id_type = " . intval($postlist["id_type"]) . ",            
                size = " . intval($postlist["size"]) . ",            
                width = " . intval($postlist["width"]) . ",            
                height = " . intval($postlist["height"]) . ",            
                date = NOW()
        ";
        
        $result = $db->sql_query($sql);
        if($result === FALSE)
        {
            message_die(GENERAL_ERROR, "We were unable to upload your movie.", $sql);
        }
        
        $postlist["id"] = intval($db->sql_nextid());
        
        if(rename($postlist["file"], "../media/movies/" . $postlist["id"] . ".swf") === FALSE)
        {
            $errors[] = "We were unable to upload your movie. Please try again.";
        }
        else if(file_exists($postlist["icon"]) === TRUE)
        {
            rename($postlist["icon"], "../media/movies/screenshots/" . $postlist["id"] . ".gif");
            header("location: " . $SITE["fauxlvl"] . "movies/" . $postlist["id"] . "/" . str2link($postlist["title"]) . "/");
        }
    }
    
    if(sizeof($errors) !== 0)
    {
        $count = 0;
        $template->assign_block_vars("errors", array());
        foreach($errors as $value)
        {
            $template->assign_block_vars("errors.row", array(
                "color" => $count++ % 2 === 0 ? "err-alt" : "",
                "text" => $value,
            ));
        }
    }
}

if(sizeof($errors) !== 0 || isset($_POST["upload"]) === FALSE)
{
    // Make sure they don't break the HTML with their tom foolry
    $postlist = array_map("htmlentities", $postlist);
    
    $template->assign_block_vars("upload", $postlist);
            
    // START Setup OPTIONS arrays for Ratings and Categories (99 is NULL)
    foreach($options as $name => $array)
    {
        ${"options_" . $name} = "";
        foreach($array as $key => $value)
        {
            ${"options_" . $name} .= "<option value=\"" . $key . "\"" . ($postlist[$name] == $key ? " selected=\"selected\"" : "") . ">" . $value . "</option>";
        }
        $template->assign_vars(array("options_" . $name => ${"options_" . $name}));
    }
}

include_once("../includes/footer.php");

?>