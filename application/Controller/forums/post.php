<?php 

define("ROOT", true);
define("SECURITY", 2);
include_once("../includes/header.php");

$errors = array();
$id_forum = isset($_GET["id"]) === TRUE ? intval($_GET["id"]) : 0;

$postlist = array(
    "title"            => isset($_POST["title"])         === TRUE ? $_POST["title"]                         : "",
    "post"            => isset($_POST["post"])             === TRUE ? $_POST["post"]                         : "",
    "id_forum"    => isset($_POST["id_forum"])    === TRUE ? intval($_POST["id_forum"]) : $id_forum,
);

if(isset($_POST["submit"]) === TRUE)
{
    if($postlist["title"] === "")
    {
        $errors[] = "Please provide a a title.";
    }
    
    if($postlist["post"] === "")
    {
        $errors[] = "Please provide a post to submit.";
    }
    
    if(sizeof($errors) === 0)
    {
        // Parse the post, strip invalid HTML, center images and objects, remove empty code
        include_once("functions/format.php");
        $postlist["post"] = format_post($postlist["post"], TRUE);

        // Lets make sure they are actually wriing something after all that parsing
        if($postlist["post"] === "")
        {
            $errors[] = "Your post has become too small after stripping HTML.";
        }        
    }    
    
    // No errors exists so let's add to database
    if(sizeof($errors) === 0)
    {
        // Create the topic entry first
        $sql = "
            INSERT INTO
                forums_topics
            SET
                id_user = " . $SITE["user"]["id"] . ",
                id_forum = " . $postlist["id_forum"] . ",
                title = '" . addslashes($postlist["title"]) . "',
                date = NOW(),
                id_user_last = " . $SITE["user"]["id"] . "
        ";
        
        $result = $db->sql_query($sql);
        if($result === FALSE)
        {
            message_die(GENERAL_ERROR, "We were unable to add topic.", $sql);
        }
        else
        {
            // Use topic id to create post row
            $id_topic = intval($db->sql_nextid());
            
            $sql = "
                INSERT INTO
                    forums_topics_posts
                SET
                    id_topic = " . $id_topic . ",
                    id_user = " . $SITE["user"]["id"] . ",
                    post = '" . addslashes($postlist["post"]) . "',
                    date = NOW(),
                    date_edit = NOW()
            ";
            
            $result = $db->sql_query($sql);
            if($result === FALSE)
            {
                message_die(GENERAL_ERROR, "We were unable to add post.", $sql);
            }
            else
            {
                // Now lets go back and update the topic row with post info
                // This speeds up common SELECTs throughout the forums
                $id_post = intval($db->sql_nextid());
                
                $sql = "
                    UPDATE
                        forums_topics
                    SET
                        id_post = " . $id_post . "
                    WHERE
                        id = " . $id_topic . "
                ";
                
                $result = $db->sql_query($sql);
                if($result === FALSE)
                {
                    message_die(GENERAL_ERROR, "We were unable to update topic.", $sql);
                }
                else
                {
                    // SUCCESS - Show them their results
                    header("location: " . $SITE["fauxlvl"] . "forums/" . $id_topic . "/" . str2link($postlist["title"]) . "/");
                }
            }
        }
    }
    
    // Display any errors that occurred
    if(sizeof($errors) !== 0)
    {
        display_errors($errors);
    }
}

$postlist = array_map("htmlentities", $postlist);
$template->assign_block_vars("post", $postlist);

// Build Forum List
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
$sql = "
    SELECT
        id,
        name
    FROM
        forums
    ORDER BY
        'order' ASC
";

$result = $db->sql_query($sql);
if($result === FALSE)
{
    message_die(GENERAL_ERROR, "We were unable to retrieve forum list.", $sql);
}
else
{
    while($row = $db->sql_fetchrow())
    {        
        $row["selected"] = intval($row["id"]) === $id_forum ? "selected=\"selected\"" : ""; 
        $template->assign_block_vars("post.forum", $row);
    }
}

define("PAGE_TITLE", "New Topic");
include_once("../includes/footer.php");

?>