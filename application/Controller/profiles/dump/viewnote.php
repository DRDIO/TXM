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
    
    $id = isset($_GET['id']) intval($_GET['id']) : 0;
    
    // sent unread    0
    // read                    1
    // replied            2
    // deleted to        3
    // deleted from    4
    // deleted both 5
    // draft                6
    $status_array = array('Unread', 'Read', 'Replied', 'Deleted');
        
    // Grab Incoming Notes
    $sql = "
        SELECT a.*, b.user_nick_name, b.username FROM txm_notes a, txm_users b WHERE a.type = 0 AND a.to_user_id = {$profile_user['user_id']} AND b.user_id = a.from_user_id ORDER BY a.date_sent DESC LIMIT 0, 20
    ";
    
    if (!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'We are unable to retain Upload ID in the procedure.<BR>' . $sql);

    // Parse the list into an entry
    $notes_incoming_count = 0;
    while($value = $db->sql_fetchrow($result)) 
    {
        $value['note'] = htmlentities($value['note']);
        
        $template->assign_block_vars('notes_incoming', array(
            'ID'                        => $value['id'],
            'USER_LINK'            => strtolower($value['username']),
            'USER_NAME'            => !empty($value['user_nick_name']) ? $value['user_nick_name'] : ucwords($value['username']),
            'CHAIN_ID'            => $value['chain_id'],
            'TYPE'                    => $value['type'],
            'DATE_SENT'            => (date('mdY') == date('mdY', $value['date_sent'])) ? date('\T\o\d\a\y \a\t h:i a', $value['date_sent']) : date('\O\n D, F jS \a\t h:i a', $value['date_sent']),
            'TITLE'                 => $value['title'],
            'FROM_USER_ID'     => $value['from_user_id'],
            'STATUS'                => $status_array[$value['status']],
            'NOTE'                    => (strlen($value['note']) > 160) ? substr($value['note'], 0, 160) . '...' : $value['note'],
        ));    
        
        $notes_incoming_count++;
    }

    if(!empty($notes_incoming_count)) $template->assign_block_vars('notes_incoming_show', array('COUNT' => $notes_incoming_count));
    
    // Grab Outgoing Notes
    $sql = "
        SELECT a.*, b.user_nick_name, b.username FROM txm_notes a, txm_users b WHERE a.type = 0 AND a.from_user_id = {$profile_user['user_id']} AND b.user_id = a.to_user_id ORDER BY a.date_sent DESC LIMIT 0, 10
    ";
    
    if (!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'We are unable to retain Upload ID in the procedure.<BR>' . $sql);

    // Parse the list into an entry
    $notes_outgoing_count = 0;
    while($value = $db->sql_fetchrow($result)) 
    {
        $value['note'] = htmlentities($value['note']);
        
        $template->assign_block_vars('notes_outgoing', array(
            'ID'                        => $value['id'],
            'USER_LINK'            => strtolower($value['username']),
            'USER_NAME'            => !empty($value['user_nick_name']) ? $value['user_nick_name'] : ucwords($value['username']),
            'CHAIN_ID'            => $value['chain_id'],
            'TYPE'                    => $value['type'],
            'DATE_SENT'            => (date('mdY') == date('mdY', $value['date_sent'])) ? date('\T\o\d\a\y \a\t h:i a', $value['date_sent']) : date('\O\n D, F jS \a\t h:i a', $value['date_sent']),
            'TITLE'                 => $value['title'],
            'TO_USER_ID'        => $value['to_user_id'],
            'STATUS'                => $status_array[$value['status']],
            'NOTE'                    => (strlen($value['note']) > 160) ? substr($value['note'], 0, 160) . '...' : $value['note'],
        ));    
        
        $notes_outgoing_count++;
    }
    
    if(!empty($notes_outgoing_count)) $template->assign_block_vars('notes_outgoing_show', array('COUNT' => $notes_outgoing_count));
}

include('../includes/footer.php');

?>