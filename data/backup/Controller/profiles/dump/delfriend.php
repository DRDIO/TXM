<?

define('ROOT', true);
include('../includes/header.php');
include('includes/common.php');

if(!$SITE_USER['session_logged_in']) 
{
    include('../includes/registerlogin.php');
}
else
{
    $friend_id = $profile_user['user_id'];
    if($friend_id == $SITE_USER['user_id']) message_die(GENERAL_ERROR, 'You may not befriend yourself.');
    $friend_url = $SITE_LINK     = "http://" . str_replace(' ', '' , strtolower($profile_user['username'])) . ".txmafia.com/";
    
    $sql = "SELECT username FROM " . USERS_TABLE . " WHERE user_id={$friend_id}";
    
    if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'Unable to retrieve members information (SQL).');
    if(!(list($friend_name) = $db->sql_fetchrow($result))) message_die(GENERAL_ERROR, 'The requested member does not exist.');
    
    $sql = "DELETE FROM " . FRIENDS_TABLE . " WHERE user_id_1={$SITE_USER['user_id']} AND user_id_2={$friend_id}";
    if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'Unable to access friend list (SQL).');
    
    if($result === FALSE) message_die(GENERAL_MESSAGE, "You were not friends with <A HREF='{$friend_url}'>{$friend_name}</A>.<BR>Would you like to <A HREF='{$friend_url}addfriend'>add</A> {$friend_name}.<BR><BR><A HREF='{$friend_url}'>Return to {$friend_name}'s profile.</A><BR>");
    message_die(GENERAL_MESSAGE, "You have removed <A HREF='{$friend_url}'>{$friend_name}</A> from your friend's list.<BR>Would you like to <A HREF='{$friend_url}addfriend'>add</A> {$friend_name}.<BR><BR><A HREF='{$friend_url}'>Return to {$friend_name}'s profile.</A><BR>");
}

?>