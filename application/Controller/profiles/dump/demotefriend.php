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
    
    if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'Unable to retrieve members information.', $sql);
    if(!(list($friend_name) = $db->sql_fetchrow($result))) message_die(GENERAL_ERROR, 'The requested member does not exist.');
    
    $sql = "SELECT level FROM " . FRIENDS_TABLE . " WHERE user_id_1={$SITE_USER['user_id']} AND user_id_2={$friend_id}";
    if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'Unable to access friend list.', $sql);
    
    $message_promote = ($row['level'] <= 3) ? "Would you like to <A HREF='{$friend_url}promotefriend'>promote</A> {$friend_name} to " . strtolower($SITE_USER['friend_level_' . ($row['level'])]) . ".<BR>"     : '';
    $message_demote = ($row['level'] > 1) ? "Would you like to <A HREF='{$friend_url}demotefriend'>demote</A> {$friend_name} to " . strtolower($SITE_USER['friend_level_' . ($row['level'] - 2)]) . ".<BR>" : 
        "Would you like to <A HREF='{$friend_url}delfriend'>remove</A> {$friend_name}.<BR>";
    
    $row = $db->sql_fetchrow($result);
    
    if(!isset($row['level'])) message_die(GENERAL_ERROR, "You must first befriend <A HREF='{$friend_url}'>{$friend_name}</A>.<BR>Would you like to <A HREF='{$friend_url}addfriend'>add</A> {$friend_name}.<BR><BR><A HREF='{$friend_url}'>Return to {$friend_name}'s profile.</A><BR>");
    if($row['level'] == 0) message_die(GENERAL_ERROR, "Your friendship with <A HREF='{$friend_url}'>{$friend_name}</A> is already fully demoted.<BR>{$message_promote}{$message_demote}<BR><A HREF='{$friend_url}'>Return to {$friend_name}'s profile.</A><BR>");
    
    $sql = "UPDATE " . FRIENDS_TABLE . " SET level=level-1 WHERE user_id_1={$SITE_USER['user_id']} AND user_id_2={$friend_id}";
    if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'Unable to retrieve members information.', $sql);
    
    message_die(GENERAL_MESSAGE, "You have demoted your friendship with <A HREF='{$friend_url}'>{$friend_name}</A> to " . strtolower($SITE_USER['friend_level_' . ($row['level'] - 1)]) . ".<BR>{$message_promote}{$message_demote}<BR><A HREF='{$friend_url}'>Return to {$friend_name}'s profile.</A><BR>");
}

?>
