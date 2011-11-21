<?

define('ROOT', true);
include('../includes/header.php');

// Grab all the basic data (all topics except announcements) for this forum
$sql = "
    SELECT t.*, p3.post_text, u.username, u.user_id, u2.username as user2, u2.user_id as id2, p.post_username, p2.post_username AS post_username2, p2.post_time 
    FROM " . TOPICS_TABLE . " t, " . USERS_TABLE . " u, " . POSTS_TABLE . " p, " . POSTS_TABLE . " p2, " . POSTS_TEXT_TABLE . " p3, " . USERS_TABLE . " u2
    WHERE t.forum_id = 11
        AND t.topic_poster = u.user_id
        AND p.post_id = t.topic_first_post_id
        AND p2.post_id = t.topic_last_post_id
        AND u2.user_id = p2.poster_id 
        AND p.post_id = p3.post_id
        AND t.topic_type <> " . POST_ANNOUNCE . " 
        AND t.topic_type <> " . POST_STICKY . "
";

if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'Could not obtain topic information.', $sql);
while($row = $db->sql_fetchrow($result))
{
    $id = 0;
    $title = htmlentities(addslashes($row['topic_title']));
    $link = "";
    $blog = htmlentities(addslashes($row['post_text']));
    $date_uploaded = time();
    $date_created = $row['topic_time'];
    $category = 3;
    $mood = 0;
    $user_id = $row['user_id'];
    $views = 0;
    $comments = 0;
    $vote_total = 0.0;
    $vote_amount = 0;
    $privacy = 0;
    $flag_comments = 1;
    $flag_votes = 1;
    $flag_mature = 0;
    $flag_deleted = 0;
    
    $sql2 = "
        INSERT 
            INTO " . BLOGS_UPLOADS_TABLE . " 
        SET 
            title = '{$title}', 
            blog = '{$blog}', 
            date_uploaded = {$date_uploaded}, 
            date_created = {$date_created},
            category = 3,
            user_id = {$user_id}
    ";
    
    echo $sql . '<BR><BR>';
    
    if(!$db->sql_query($sql2)) die('Could not update blog.');
}

die;

include('../includes/footer.php');

?>
