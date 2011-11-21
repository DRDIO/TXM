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
    if($SITE_USER['user_level'] != ADMIN && $profile_user['user_id'] != $SITE_USER['user_id']) message_die(GENERAL_ERROR, 'You cannot view other people\'s notes.<BR>');

    // sent unread    0
    // read                    1
    // replied            2
    // deleted to        3
    // deleted from    4
    // deleted both 5
    // draft                6
    
    // If set to mark, all incoming unread messages can be marked as read (status)
    if(isset($_POST['mark']))
    {
        foreach($_POST as $key => $value)
        {
            // First ensure they have the cb(COUNT) format
            if(strpos($key, "cb") !== FALSE)
            {
                // Then ensure they have the (incoming|outgoing)(Unread|Read|Replied)(ID) format
                // We will check their incoming and status to do less false SQLs
                if(strpos($value, "incoming") !== FALSE && strpos($value, "Unread") !== FALSE)
                {
                    preg_match('/[0-9]+/', $value, $id);
                    $sql = "
                        UPDATE " . NOTES_TABLE . " SET status = 1 WHERE id = {$id[0]} AND to_user_id = {$profile_user['user_id']} AND status = 0 AND flag_to_del = 0
                    ";
                    if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'We are unable to mark your notes as read.<BR>', $sql);
                }        
            }
        }
        
        message_die(GENERAL_MESSAGE, "Your notes have been marked as read.<BR>");
    }
    // If set to delete, all messages can be deleted (flag_to_del or flag_from_del)
    else if(isset($_POST['delete']))
    {
        foreach($_POST as $key => $value)
        {
            // First ensure they have the cb(COUNT) format
            if(strpos($key, "cb") !== FALSE)
            {
                // Then ensure they have the (incoming|outgoing)(Unread|Read|Replied)(ID) format
                // We will check their incoming and status to do less false SQLs
                if(strpos($value, "incoming") !== FALSE)
                {
                    preg_match('/[0-9]+/', $value, $id);
                    $sql = "
                        UPDATE " . NOTES_TABLE . " SET flag_to_del = 1 WHERE id = {$id[0]} AND to_user_id = {$profile_user['user_id']} AND flag_to_del = 0
                    ";
                    if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'We are unable to mark your notes as read.<BR>', $sql);
                }
                else if(strpos($value, "outgoing") !== FALSE)
                {
                    preg_match('/[0-9]+/', $value, $id);
                    $sql = "
                        UPDATE " . NOTES_TABLE . " SET flag_from_del = 1 WHERE id = {$id[0]} AND from_user_id = {$profile_user['user_id']} AND flag_from_del = 0
                    ";
                    if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'We are unable to mark your notes as read.<BR>', $sql);
                }                    
            }
        }

        message_die(GENERAL_MESSAGE, "Your notes have been deleted.<BR>");        
    }
}

include('../includes/footer.php');

?>