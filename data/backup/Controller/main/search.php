<?php define("ROOT", TRUE);

define("SECURITY", 0);
include_once("../includes/header.php");

$errors = array();
$postlist = array(
    "type" => isset($_POST["type"]) === TRUE ? $_POST["type"] : "",
    "search" => isset($_POST["type"]) === TRUE ? $_POST["search"] : "",
);

// To help load on the server, only allow full words
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
if(strlen($postlist["search"]) < 3)
{
    $errors[] = "Your search term must be at least three characters.";
}
// Search only supports movies and games right now
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
else if($postlist["type"] !== "movies" && $postlist["type"] !== "games")
{
    $errors[] = "Please provide a valid search method.";
}
// Look for anything containing the search phrase, even within words %search%
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
else
{
    $sql = "
        SELECT
            r.id,
            r.title,
            r.synopsis,
            r.keywords,
            u.link_name,
            u.nick_name
        FROM
            " . $postlist["type"] . " AS r INNER JOIN
            txm_users AS u ON r.id_user = u.id
        WHERE
            (title LIKE '%" . addslashes($postlist["search"]) . "%' OR
            synopsis LIKE '%" . addslashes($postlist["search"]) . "%' OR
            keywords LIKE '%" . addslashes($postlist["search"]) . "%') AND                
            deleted = 0
        ORDER BY
            date DESC
        LIMIT
            0,25
    ";
    
    $result = $db->sql_query($sql);
    if($result === FALSE)
    {
        message_die(GENERAL_ERROR, "We were unable to perform a search.", $sql);
    }
    else if($db->sql_numrows($result) > 0)
    {
        $count = 0;
        while($row = $db->sql_fetchrow($result))
        {
            $row["title_link"] = str2link($row["title"]);
            $row["title"] = htmlentities($row["title"]);
            $row["synopsis"] = htmlentities($row["synopsis"]);
            $row["keywords"] = $row["keywords"] === "" ? "none" : $row["keywords"];        
            $row["color"] = $count++ % 2 === 0 ? "blu-alt" : "";
            
            $row["avatar"] = (file_exists($SITE["level"] . "media/movies/screenshots/" . $row["id"] . ".gif") === TRUE ?
                 "movies/screenshots/" . $row["id"] : 
                 "assets/movies-icon");
            
            $template->assign_block_vars("result", $row);
        }
    }
    else
    {
        $template->assign_block_vars("empty");
    }
}

// Output errors
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
display_errors($errors);

// Create primary fields
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
$postlist = array_map("htmlentities", $postlist);    
$template->assign_vars(array(
    "type" => $postlist["type"],
    "uctype" => ucwords($postlist["type"]),
    "search" => $postlist["search"]
));

include_once("../includes/footer.php");

?>
