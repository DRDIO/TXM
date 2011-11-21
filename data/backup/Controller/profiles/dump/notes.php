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
    
    // Grab individual note
    
    // Get page for incoming and outgoing
    if(isset($_GET['vars'])) list($mode, $page) = split('/', $_GET['vars']);
    $incoming_start = ($mode == 'incoming') ? 10 * ($page - 1) : 0;
    $outgoing_start = ($mode == 'outgoing') ? 10 * ($page - 1) : 0;
    if(empty($page)) $page = 1;
    
    // sent unread    0
    // read                    1
    // replied            2
    // draft                6
    $status_array = array('Unread', 'Read', 'Replied', 'Unknown', 'Unknown', 'Unknown', 'Draft');
    
    if($mode != 'outgoing')
    {    
        // Grab Incoming Notes
        $sql = "SELECT COUNT(*) AS count FROM " . NOTES_TABLE . " WHERE flag_to_del = 0 AND type = 0 AND to_user_id = {$profile_user['user_id']}";
        if (!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'We are unable to retain Upload ID in the procedure.<BR>' . $sql);
        list($incoming_total) = $db->sql_fetchrow($result); 
        
        $sql = "
            SELECT a.*, b.user_nick_name, b.username FROM " . NOTES_TABLE . " a, txm_users b WHERE a.flag_to_del = 0 AND a.type = 0 AND a.to_user_id = {$profile_user['user_id']} AND b.user_id = a.from_user_id ORDER BY a.date_sent DESC LIMIT {$incoming_start}, 10
        ";
        
        if (!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'We are unable to retain Upload ID in the procedure.<BR>' . $sql);
        
        // Parse the list into an entry
        $notes_incoming_count = 0;
        while($value = $db->sql_fetchrow($result)) 
        {
            $value['note'] = htmlentities($value['note']);
                
            $template->assign_block_vars('notes_incoming', array(
                'COUNT'                    => $notes_incoming_count,
                'ROW_COLOR'            => $notes_incoming_count % 2,
                'FROM_DEL'            => empty($value['flag_from_del']) ? '' : 'Deleted',
                'ID'                        => $value['id'],
                'USER_LINK'            => strtolower($value['username']),
                'USER_NAME'            => !empty($value['user_nick_name']) ? $value['user_nick_name'] : ucwords($value['username']),
                'CHAIN_ID'            => $value['chain_id'],
                'TYPE'                    => $value['type'],
                'DATE_SENT'            => (date('mdY') == date('mdY', $value['date_sent'])) ? date('\T\o\d\a\y \a\t h:i A', $value['date_sent']) : date('d, F jS \a\t h:i A', $value['date_sent']),
                'TITLE'                 => $value['title'],
                'FROM_USER_ID'     => $value['from_user_id'],
                'STATUS'                => $status_array[$value['status']],
                'NOTE'                    => preg_replace('/(\S{50})/', '\1 ', (strlen($value['note']) > 120) ? substr($value['note'], 0, 120) . '...' : $value['note']),
            ));    
            
            $notes_incoming_count++;
        }
    
        if(!empty($notes_incoming_count))
        {
            $template->assign_block_vars('notes_incoming_show', array(
                'RANGE'    => (10 * ($page - 1) + 1) . " to " . (10 * ($page - 1) + ($notes_incoming_count < 10 ? $notes_incoming_count : 10)),
                'TOTAL'    => $incoming_total,
                'PAGE'    => pages('notes/incoming', $incoming_total, 10, 10 * ($page - 1)),
            ));
        }
    }
    
    if($mode != 'incoming')
    {    
        // Grab Outgoing Notes
        $sql = "SELECT COUNT(*) AS count FROM " . NOTES_TABLE . " WHERE flag_from_del = 0 AND type = 0 AND from_user_id = {$profile_user['user_id']}";
        if (!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'We are unable to retain Upload ID in the procedure.<BR>' . $sql);
        list($outgoing_total) = $db->sql_fetchrow($result); 
        
        $sql = "
            SELECT a.*, b.user_nick_name, b.username FROM " . NOTES_TABLE . " a, txm_users b WHERE a.flag_from_del = 0 AND a.type = 0 AND a.from_user_id = {$profile_user['user_id']} AND b.user_id = a.to_user_id ORDER BY a.date_sent DESC LIMIT {$outgoing_start}, 10
        ";
        
        if (!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'We are unable to retain Upload ID in the procedure.<BR>' . $sql);
    
        // Parse the list into an entry
        $notes_outgoing_count = 0;
        while($value = $db->sql_fetchrow($result)) 
        {
            $value['note'] = htmlentities($value['note']);
            
            $template->assign_block_vars('notes_outgoing', array(
                'COUNT'                    => $notes_outgoing_count,
                'TO_DEL'                => empty($value['flag_to_del']) ? '' : 'Deleted',
                'ID'                        => $value['id'],
                'USER_LINK'            => strtolower($value['username']),
                'USER_NAME'            => !empty($value['user_nick_name']) ? $value['user_nick_name'] : ucwords($value['username']),
                'CHAIN_ID'            => $value['chain_id'],
                'TYPE'                    => $value['type'],
                'DATE_SENT'            => (date('mdY') == date('mdY', $value['date_sent'])) ? date('\T\o\d\a\y \a\t h:i A', $value['date_sent']) : date('d, F jS \a\t h:i A', $value['date_sent']),
                'TITLE'                 => $value['title'],
                'TO_USER_ID'        => $value['to_user_id'],
                'STATUS'                => $status_array[$value['status']],
                'NOTE'                    => preg_replace('/(\S{50})/', '\1 ', (strlen($value['note']) > 120) ? substr($value['note'], 0, 120) . '...' : $value['note']),
            ));    
            
            $notes_outgoing_count++;
        }
        
        if(!empty($notes_outgoing_count))
        {
            $template->assign_block_vars('notes_outgoing_show', array(
                'TOTAL'    => $outgoing_total,
                'RANGE'    => (10 * ($page - 1) + 1) . " to " . (10 * ($page - 1) + ($notes_outgoing_count < 10 ? $notes_outgoing_count : 10)),
                'PAGE'    => pages('notes/outgoing', $outgoing_total, 10, 10 * ($page - 1)),
            ));
        }
    }
}

if(empty($notes_incoming_count) && empty($notes_outgoing_count)) $template->assign_block_vars('notes_none', array());

$template->assign_vars(array(
    'COUNT_INCOMING'    => $notes_incoming_count,
    'COUNT_OUTGOING'    => $notes_outgoing_count,
));    

include('../includes/footer.php');

?>