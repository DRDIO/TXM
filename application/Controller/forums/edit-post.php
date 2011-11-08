<?php define("ROOT", TRUE);

include_once("../includes/header.php");
define("SECURITY", LEVEL_SPECIAL);

$errors = array();
$id = isset($_GET["id"]) === TRUE ? intval($_GET["id"]) : 0;

$postlist = array(
    "title"            => isset($_POST["title"])            === TRUE ? $_POST["title"]                        : "",
    "post"            => isset($_POST["post"])             === TRUE ? $_POST["post"]                         : "",
    "id_forum"    => isset($_POST["id_forum"])    === TRUE ? intval($_POST["id_forum"]) : 0,
);

if(isset($_POST["submit"]) === TRUE)
{    
    if($postlist["title"] === "")
    {
        $errors[] = "Please provide a title.";
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
        $sql = "
            SELECT
                p.id,
                p.id_user
            FROM
                forums_topics AS t INNER JOIN
                forums_topics_posts AS p ON t.id_post = p.id
            WHERE
                t.id = " . $id . "
        ";
        
        $result = $db->sql_query($sql);
        if($result === FALSE)
        {
            message_die(GENERAL_ERROR, "We were unable to select topic.", $sql);
        }
        else if($db->sql_numrows() !== 1)
        {
            message_die(GENERAL_MESSAGE, "Topic Post does not exist or has been deleted.", $sql);
        }
        else
        {
            $row = $db->sql_fetchrow();
            if($SITE["user"]["status"] < LEVEL_MOD && $SITE["user"]["id"] !== intval($row["id_user"]))
            {
                message_die(GENERAL_MESSAGE, "You do not have permission to edit this topic.", $sql);
            }
            else
            {            
                $id_post = intval($row["id"]);
                    
                // Create the topic entry first
                $sql = "
                    UPDATE
                        forums_topics
                    SET
                        id_forum = " . $postlist["id_forum"] . ",
                        title = '" . str_replace("'", "\'", $postlist["title"]) . "'
                    WHERE
                        id = " . $id . "            
                ";
                
                $result = $db->sql_query($sql);
                if($result === FALSE)
                {
                    message_die(GENERAL_ERROR, "We were unable to update topic.", $sql);
                }
                else
                {
                    if(isset($_POST["delete"]) === TRUE)
                    {
                        $sql = "
                            UPDATE
                                forums_topics
                            SET
                                deleted = 1
                            WHERE
                                id = " . $id . "            
                        ";
                    }
                    else
                    {                                    
                        $sql = "
                            UPDATE
                                forums_topics_posts
                            SET
                                post = '" . str_replace("'", "\'", $postlist["post"]) . "',
                                date_edit = NOW()
                            WHERE
                                id = " . $id_post . "
                        ";
                    }
                        
                    $result = $db->sql_query($sql);
                    if($result === FALSE)
                    {
                        message_die(GENERAL_ERROR, "We were unable to add post.", $sql);
                    }
                    else
                    {
                        // SUCCESS - Show them their results
                        header("location: " . $SITE["fauxlvl"] . "forums/" . $id . "/" . str2link($postlist["title"]) . "/");                    
                    }
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
// Grab Data for Post Editing
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
else
{
    $sql = "
        SELECT
            t.title,
            t.id_forum,
            p.post,
            p.id_user
        FROM
            forums_topics AS t INNER JOIN
            forums_topics_posts AS p ON t.id_post = p.id
        WHERE
            t.id = " . $id . " AND
            t.deleted = 0 AND
            p.deleted = 0
    ";
    
    $result = $db->sql_query($sql);
    if($result === FALSE)
    {
        message_die(GENERAL_ERROR, "We were unable to select topic.", $sql);
    }
    else if($db->sql_numrows() !== 1)
    {
        message_die(GENERAL_MESSAGE, "Topic Post does not exist or has been deleted.", $sql);
    }
    else
    {
        $row = $db->sql_fetchrow();
        if($SITE["user"]["status"] < LEVEL_MOD && $SITE["user"]["id"] !== intval($row["id_user"]))
        {
            message_die(GENERAL_MESSAGE, "You do not have permission to edit this topic.", $sql);
        }
        else
        {
            
            // Update postlist with database values
            $postlist["title"]         = $row["title"];
            $postlist["post"]         = preg_replace("/<object.+?data=\"(.+?)\".+?\/object>/i", "<img src=\"http://www.txm.com/media/assets/flash-dummy.gif\" width=\"425\" height=\"350\" data=\"$1\" />", $row["post"]);
            $postlist["id_forum"] = intval($row["id_forum"]);
        }
    }
}

// Format Elements for Display
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
foreach($postlist as $key => $value)
{
    $postlist[$key] = htmlentities($value, ENT_QUOTES, "ISO-8859-15", FALSE);
}

$template->assign_block_vars("post", $postlist);
$template->assign_block_vars("post.post_edit", array());

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
        $row["selected"] = intval($row["id"]) === $postlist["id_forum"] ? "selected=\"selected\"" : ""; 
        $template->assign_block_vars("post.forum", $row);
    }
}

define("TEMPLATE", "post");
define("PAGE_TITLE", "Edit Topic '" . $postlist["topic"] . "'");
include_once("../includes/footer.php");

?>