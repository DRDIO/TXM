<?php define("ROOT", TRUE);

ini_set("display_errors", "1");

define("ROOT", true);
define("PAGE_TITLE", "Movies");
define("PAGE_COMMON", true);
define("AD_APPROVED", true);
require_once("../includes/header.php");
require_once("includes/common.php");

if ($SITE_PROFILE->isSelf() === false) {
        SITE_Log::warning("You cannot edit other people's profiles.");
}

$errors = array();

// Initialize Variables
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
$postlist = array(
    "id"                        => $SITE_USER["id"],
    "nick_name"            => isset($_POST["nick_name"])     === TRUE ? $_POST["nick_name"]         : "",
    "full_name"            => isset($_POST["full_name"])     === TRUE ? $_POST["full_name"]         : "",
    "gender"                => isset($_POST["gender"])             === TRUE ? $_POST["gender"]             : "",
    "occupation"        => isset($_POST["occupation"])     === TRUE ? $_POST["occupation"]     : "",
    "city"                    => isset($_POST["city"])                 === TRUE ? $_POST["city"]                 : "",
    "region"                => isset($_POST["region"])             === TRUE ? $_POST["region"]             : "",
    "country"                => isset($_POST["country"])         === TRUE ? $_POST["country"]             : "",
    "zip_code"            => isset($_POST["zip_code"])         === TRUE ? $_POST["zip_code"]         : "",
    "avatar_link"        => isset($_POST["avatar_link"]) === TRUE ? $_POST["avatar_link"]     : "",
    "photo_link"        => isset($_POST["photo_link"])     === TRUE ? $_POST["photo_link"]     : "",
    "validate"            => isset($_POST["validate"])         === TRUE ? $_POST["validate"]         : "",
);
    
if(isset($_POST["submit"]) === TRUE)
{
    // Validate CAPTCHA
    // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
    if($postlist["validate"] === "" || strtolower($SITE["user"]["captcha"]) !== strtolower($postlist["validate"]))
    {
        $errors[] = "Please retype the six letters provided for validation.";
    }
    
    // Validate Birth Date
    // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
    if(checkdate(intval($postlist["date_m"]), intval($postlist["date_d"]), intval($postlist["date_y"])) === FALSE)
    {
        $errors[] = "Please provide a valid birth date.";
    }
    else if(intval(date("Ymd")) - 130000 < intval($postlist["date_y"] . $postlist["date_m"] . $postlist["date_d"]))
    {
        $errors[] = "You must be at least 13 years old.";
    }
    else
    {
        $postlist["date_birth"] = $postlist["date_y"] . "-" . $postlist["date_m"] . "-" . $postlist["date_d"] . " 00:00:00";
        unset($postlist["date_y"], $postlist["date_m"], $postlist["date_y"]);
    }
}

include_once("../includes/footer.php");

?>