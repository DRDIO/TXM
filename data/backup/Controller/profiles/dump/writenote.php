<?

define('ROOT', true);
include('../includes/header.php');
include('includes/common.php');

    // sent unread    0
    // read                    1
    // replied            2
    // deleted to        3
    // deleted from    4
    // deleted both 5
    // draft                6
    
if(!$SITE_USER['session_logged_in']) 
{
    include('../includes/registerlogin.php');
}
else
{
    $writenote_chain_id        = isset($_POST['writenote_chain_id'])     ? $_POST['writenote_chain_id']         : 0;
    $writenote_prev_id        = isset($_POST['writenote_prev_id'])         ? $_POST['writenote_prev_id']         : 0;
    $writenote_title             = isset($_POST['writenote_title'])             ? $_POST['writenote_title']             : '';
    $writenote_note             = isset($_POST['writenote_note'])             ? $_POST['writenote_note']                 : '';
    $writenote_to_user_id = isset($_POST['writenote_to_user_id']) ? $_POST['writenote_to_user_id']    : '';
    $writenote_date_sent    = time();
    
    if(empty($writenote_title)) message_die(GENERAL_ERROR, 'You have not provided a title.<BR>');
    if(empty($writenote_note)) message_die(GENERAL_ERROR, 'You have not provided a note.<BR>');
    if(empty($writenote_to_user_id)) message_die(GENERAL_ERROR, 'You have not chosen a valid member.<BR>');
    if($writenote_to_user_id == $SITE_USER['user_id']) message_die(GENERAL_ERROR, 'You cannot write a note to yourself.<BR>');
    
    if(!empty($writenote_prev_id) && !empty($writenote_chain_id))
    {
        $sql = "
            UPDATE " . NOTES_TABLE . " SET status = 2 WHERE id = {$writenote_prev_id}
        ";
        if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'Unable to update reply status information.<BR>', $sql);
    }
    
    $sql = "SELECT user_id FROM " . USERS_TABLE . " WHERE user_id = {$writenote_to_user_id}";
    if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'Unable to retrieve members information.<BR>', $sql);
    if(!(list($writenote_to_user_id) = $db->sql_fetchrow($result))) message_die(GENERAL_ERROR, 'The requested member does not exist.<BR>');
    
    $sql = "
        INSERT INTO " . NOTES_TABLE . " (chain_id, type, date_sent, date_read, date_replied, date_deleted, title, from_user_id, to_user_id, status, note)
        VALUES ({$writenote_chain_id}, 0, {$writenote_date_sent}, 0, 0, 0, '{$writenote_title}', {$SITE_USER['user_id']}, {$writenote_to_user_id}, 0, '{$writenote_note}')
    "; 

    if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'Unable to send your note.<BR>', $sql);
    
    message_die(GENERAL_MESSAGE, 'Your note has been sent.<BR>');    
}

?>
