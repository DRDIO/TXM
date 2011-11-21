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
    if($SITE_USER['user_level'] != ADMIN && $profile_user['user_id'] != $SITE_USER['user_id']) message_die(GENERAL_ERROR, 'You cannot delete other people\'s notes.<BR>');
    
    // Grab individual note
    $id = isset($_GET['vars']) ? intval($_GET['vars']) : 0;
    
    // sent unread    0
    // read                    1
    // replied            2
    // deleted to        3
    // deleted from    4
    // deleted both 5
    // draft                6
    $status_array = array('Unread', 'Read', 'Replied', 'Deleted');
            
    // Grab Specific Note (Could be incoming or outgoing)
    $sql = "
        SELECT         id, status, from_user_id, to_user_id, flag_to_del, flag_from_del
        FROM             " . NOTES_TABLE . "
        WHERE         id = {$id}
            AND         (to_user_id = {$profile_user['user_id']} OR from_user_id = {$profile_user['user_id']})
    ";
    
    if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'We are unable to retrieve note in the procedure.<BR>', $sql);
    if(!($value = $db->sql_fetchrow($result))) message_die(GENERAL_ERROR, 'No message with that ID exists.<BR>');
    
    if($value['to_user_id'] == $profile_user['user_id'])
    {
        if($value['flag_to_del'] == 1) message_die(GENERAL_ERROR, 'You have already deleted this note.<BR>');
        $value['flag_to_del'] = 1;
    }
    else if($value['from_user_id'] == $profile_user['user_id'])
    {
        if($value['flag_from_del'] == 1) message_die(GENERAL_ERROR, 'You have already deleted this note.<BR>');
        $value['flag_from_del'] = 1;
    }
    else
    {
        message_die('You cannot delete other people\'s notes.<BR>');
    }
    
    $sql = "
        UPDATE " . NOTES_TABLE . " SET flag_to_del = {$value['flag_to_del']}, flag_from_del = {$value['flag_from_del']} WHERE id = {$id}
    ";

    if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'We are unable to delete note in the procedure.<BR>', $sql);

    message_die(GENERAL_ERROR, 'Your note has been successfully deleted.<BR>');            
}

include('../includes/footer.php');

?>