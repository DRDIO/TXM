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
        SELECT         a.*, b.user_nick_name AS to_user_nick, b.username AS to_user_name, 
                             c.user_nick_name AS from_user_nick, c.username AS from_user_name 
        FROM             " . NOTES_TABLE . " a, txm_users b, txm_users c 
        WHERE         a.id = {$id}
            AND         (a.to_user_id = {$profile_user['user_id']} OR a.from_user_id = {$profile_user['user_id']})
            AND         a.to_user_id = b.user_id  
            AND         a.from_user_id = c.user_id
        ORDER BY    date_sent DESC
    ";
    
    if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'We are unable to retrieve note in the procedure.<BR>', $sql);
    if(!($value = $db->sql_fetchrow($result))) message_die(GENERAL_ERROR, 'No message with that ID exists.<BR>');
    
    // Give a Chain ID value to the post
    if($value['chain_id'] == 0) $value['chain_id'] = $value['id'];
        
    if($value['to_user_id'] == $profile_user['user_id'])
    {
        if($value['flag_to_del'] == 1) message_die(GENERAL_ERROR, 'You have already deleted this note.<BR>');
        $value['deleted'] = empty($value['flag_from_del']) ? '' : '& Deleted';
        
        if($value['status'] == 0)
        {
            $value['status'] = 1;
            $sql = "
                UPDATE " . NOTES_TABLE . " SET status = {$value['status']} WHERE id = {$value['id']}
            ";
            if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'We are unable to update note status in the procedure.<BR>', $sql);
        }
    
        $value['mode'] = 'Incoming Note from';
        $value['user_name'] = !empty($value['from_user_nick']) ? $value['from_user_nick'] : ucwords($value['from_user_name']);
        $value['user_link'] = strtolower($value['from_user_name']);    
        
        $template->assign_block_vars('write_note', array(
            'ID'                        => $value['id'],
            'CHAIN_ID'            => $value['chain_id'],
            'TITLE'                 => $value['title'],
            'USER_LINK'            => $value['user_link'],
            'USER_NAME'            => $value['user_name'],
            'FROM_USER_ID'     => $value['from_user_id'],
        ));        
    }
    else
    {
        if($value['flag_from_del'] == 1) message_die(GENERAL_ERROR, 'You have already deleted this note.<BR>');
        $value['deleted'] = empty($value['flag_to_del']) ? '' : '& Deleted';
        
        $value['mode'] = 'Outgoing Note to';
        $value['user_name'] = !empty($value['to_user_nick']) ? $value['to_user_nick'] : ucwords($value['to_user_name']);
        $value['user_link'] = strtolower($value['to_user_name']);                        
    }
    
    $value['note'] = htmlentities($value['note']);
    
    $template->assign_block_vars('note', array(
        'DELETED'                => $value['deleted'],
        'ID'                        => $value['id'],
        'MODE'                    => $value['mode'],
        'USER_LINK'            => $value['user_link'],
        'USER_NAME'            => $value['user_name'],
        'CHAIN_ID'            => $value['chain_id'],
        'TYPE'                    => $value['type'],
        'DATE_SENT'            => (date('mdY') == date('mdY', $value['date_sent'])) ? date('\T\o\d\a\y \a\t h:i a', $value['date_sent']) : date('\O\n D, F jS \a\t h:i a', $value['date_sent']),
        'TITLE'                 => $value['title'],
        'FROM_USER_ID'     => $value['from_user_id'],
        'FROM_USER_LINK'=> strtolower($value['from_user_name']),
        'STATUS'                => $status_array[$value['status']],
        'NOTE'                    => preg_replace('/(\S{50})/', '\1 ', $value['note']),
    ));    

    // Grab Other Notes (Could be incoming or outgoing)
    $sql = "
        SELECT         a.*, b.user_nick_name AS to_user_nick, b.username AS to_user_name, 
                             c.user_nick_name AS from_user_nick, c.username AS from_user_name 
        FROM             " . NOTES_TABLE . " a, txm_users b, txm_users c 
        WHERE         (a.id = {$value['chain_id']} || a.chain_id = {$value['chain_id']})
            AND            a.date_sent < {$value['date_sent']}
            AND         (a.to_user_id = {$profile_user['user_id']} OR a.from_user_id = {$profile_user['user_id']})
            AND         a.to_user_id = b.user_id  
            AND         a.from_user_id = c.user_id
        ORDER BY    date_sent DESC
    ";
    
    if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'We are unable to retain Upload ID in the procedure.<BR>', $sql);

    $notes_incoming_count++;
    while($value = $db->sql_fetchrow($result))
    {
        if($value['to_user_id'] == $profile_user['user_id'])
        {
            if($value['flag_to_del'] == 1) $skip == true;            
            $value['deleted'] = empty($value['flag_from_del']) ? '' : '& Deleted';
            $value['mode'] = 'Incoming Note from';
            $value['user_name'] = !empty($value['from_user_nick']) ? $value['from_user_nick'] : ucwords($value['from_user_name']);
            $value['user_link'] = strtolower($value['from_user_name']);    
        }
        else
        {
            if($value['flag_from_del'] == 1) $skip == true;    
            $value['deleted'] = empty($value['flag_to_del']) ? '' : '& Deleted';
            $value['mode'] = 'Outgoing Note to';
            $value['user_name'] = !empty($value['to_user_nick']) ? $value['to_user_nick'] : ucwords($value['to_user_name']);
            $value['user_link'] = strtolower($value['to_user_name']);                    
        }
        
        if($skip == false)
        {
            $value['note'] = htmlentities($value['note']);
            
            $template->assign_block_vars('other_notes', array(
                'DELETED'                => $value['deleted'],
                'ID'                        => $value['id'],
                'MODE'                    => $value['mode'],
                'USER_LINK'            => $value['user_link'],
                'USER_NAME'            => $value['user_name'],
                'CHAIN_ID'            => $value['chain_id'],
                'TYPE'                    => $value['type'],
                'DATE_SENT'            => (date('mdY') == date('mdY', $value['date_sent'])) ? date('\T\o\d\a\y \a\t h:i a', $value['date_sent']) : date('\O\n D, F jS \a\t h:i a', $value['date_sent']),
                'TITLE'                 => $value['title'],
                'FROM_USER_ID'     => $value['from_user_id'],
                'FROM_USER_LINK'=> strtolower($value['from_user_name']),
                'STATUS'                => $status_array[$value['status']],
                'NOTE'                    => preg_replace('/(\S{50})/', '\1 ', $value['note']),
            ));    
        
            $notes_incoming_count++;
        }
    }

    if(empty($notes_incoming_count)) message_die('No notes exist for this ID.<BR>');    
}

include('../includes/footer.php');

?>