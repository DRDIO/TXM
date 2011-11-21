<?php define("ROOT", TRUE);

define("PAGE_TITLE", "Upload Games");
include_once("../includes/header.php");

if($SITE["user"]["logged"] == 0)
{
    message_die(GENERAL_MESSAGE, "You must be logged in to upload.");
}

// Only let people post once per hour
$sql= "
    SELECT 
        id
    FROM
        games
    WHERE
        id_user = " . $SITE["user"]["id"] . " AND
        date > NOW() - INTERVAL 1 HOUR
";

$result = $db->sql_query($sql);
if($result === FALSE)
{
    message_die(GENERAL_ERROR, "We were unable to retrieve last upload time.", $sql);
}
if(0) // else if($db->sql_numrows($result) > 0)
{
    message_die(GENERAL_MESSAGE, "You may only upload one game per hour.", $sql);
}

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
        "11"    => "Action - Shooter games that include adventure and are fast paced.",
        "15"    => "Classic - Side scrolling action similiar to old Super Nintendo games.",    
        "12"    => "Fighter - Head to head fighting and realtime battle situations.",
        "14"    => "Party - Music samplers, pinball, multiplayer puzzles.",
        "17"    => "Puzzle - Includes board games, casino, cards, puzzles, and trivia.",
        "18"    => "Racing - All games that deal with speed, cars, planes, or boats.",
        "16"    => "RPG - Turnbased and strategy entwined with a strong story and path.",
        "20"    => "Sports - Any game that is sport themed or involves competition.",
        "19"    => "Tutor - Reserved for tutorials and self help interactive games.",
        "13"    => "Other - Any other type of game not mentioned here.",        
    ),
);

$postlist = array(
    "file"                => "../media/temp/gs" . $SITE["user"]["id"] . ".swf",
    "icon"                => "../media/temp/gi" . $SITE["user"]["id"] . ".gif",
    "title"             => isset($_POST["title"])             ? $_POST["title"]             : "",
    "synopsis"         => isset($_POST["synopsis"])         ? $_POST["synopsis"]         : "",
    "commentary"     => isset($_POST["commentary"])     ? $_POST["commentary"]     : "",
    "keywords"         => isset($_POST["keywords"])         ? $_POST["keywords"]         : "",
    "id_rating"     => isset($_POST["id_rating"])     ? $_POST["id_rating"]     : "",
    "id_type"         => isset($_POST["id_type"])         ? $_POST["id_type"]         : "",
    "validate"         => isset($_POST["validate"])         ? $_POST["validate"]         : "",
    "file_temp"        => isset($_POST["file_temp"])     ? $_POST["file_temp"]     : "",
    "icon_temp"        => isset($_POST["icon_temp"])     ? $_POST["icon_temp"]     : "",
);

$errors = array();

if(isset($_POST["upload"]) === TRUE)
{
    if($postlist["title"] === "")
    {
        $errors[] = "Please provide a title.";
    }
    
    if(file_exists($postlist["file"]) === FALSE)
    {
        $postlist["file_temp"] = "";
        $errors[] = "Unable to locate game file.  Please upload again.";
    }            
    else
    {
        $temp_attr = getimagesize($postlist["file"]);        
        $postlist["size"] = round(filesize($postlist["file"]) / 1024);
        $postlist["width"] = round($temp_attr[0]);
        $postlist["height"] = round($temp_attr[1]);
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
        $errors[] = "Please provide a valid game type.";
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
                games
            SET
                id_user = " . $SITE["user"]["id"] . ",
                title = '" . str_replace("'", "\'", $postlist["title"]) . "',
                synopsis = '" . str_replace("'", "\'", $postlist["synopsis"]) . "',
                commentary = '" . str_replace("'", "\'", $postlist["commentary"]) . "',
                keywords = '" . str_replace("'", "\'", $postlist["synopsis"]) . "',
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
            message_die(GENERAL_ERROR, "We were unable to upload your game.", $sql);
        }
        
        $postlist["id"] = intval($db->sql_nextid());
        
        if(rename($postlist["file"], "../media/games/" . $postlist["id"] . ".swf") === FALSE)
        {
            $errors[] = "We were unable to upload your game. Please try again.";
        }
        else if(file_exists($postlist["icon"]) === TRUE)
        {
            rename($postlist["icon"], "../media/games/screenshots/" . $postlist["id"] . ".gif");
            header("location: " . $SITE["fauxlvl"] . "games/" . $postlist["id"] . "/" . str2link($postlist["title"]) . "/");
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