<?php

print_r($_GET);
die($_SERVER["REQUEST_URI"]);

/*

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
    if($SITE_USER['user_level'] != ADMIN && $profile_user['user_id'] != $SITE_USER['user_id']) message_die(GENERAL_ERROR, 'You cannot delete other people\'s notes.<BR>');

    $sql = "
        SELECT         id, title 
        FROM             " . BLOGS_UPLOADS_TABLE . " 
        WHERE         user_id = {$profile_user['user_id']} 
            AND         (category = 0 OR category = 3) 
            AND         flag_deleted = 0
        ORDER BY    date_created DESC
        LIMIT            0, 40
    ";
    
    if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'Could not obtain person blog information.', $sql);
    
    $count = 0;
    while($value = $db->sql_fetchrow($result))
    {        
        $title = stripslashes($value['title']);
        $title = (strlen($title) > 38) ? substr($title, 0, 35) . '...' : $title;
        
        $template->assign_block_vars('blogs_personal', array(
            'ID'                                => $value['id'],
            'TITLE'                            => $title,
        ));
        
        $count++;
    }
    
    if(!empty($count))
    {
        $template->assign_block_vars('blogs_personal_show', array(
            'TOTAL'    => $count,
        ));
    }
    else
    {
        $template->assign_block_vars('blogs_personal_hide', array());
    }
    
    // Show the last five blogs user wrote
        $sql = "
        SELECT         id, title, blog, views, comments, date_uploaded 
        FROM             " . BLOGS_UPLOADS_TABLE . " 
        WHERE         user_id = {$profile_user['user_id']} 
            AND         (category = 0 OR category = 3) 
            AND         flag_deleted = 0
        ORDER BY    date_created DESC
        LIMIT            0, 5
    ";
    
    if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'Could not obtain person blog information.', $sql);
    
    $count = 0;
    while($value = $db->sql_fetchrow($result))
    {        
        $template->assign_block_vars('blogs_five', array(
            'ID'                                => $value['id'],
            'TITLE'                            => stripslashes($value['title']),
            'BLOG'                            => stripslashes(html_entity_decode($value['blog'])),
            'VIEWS'                            => $value['views'],
            'COMMENTS'                    => $value['comments'],
            'DATE_UPLOADED'            => (date('mdY') == date('mdY', $value['date_uploaded'])) ? date('\T\o\d\a\y \a\t h:i a', $value['date_uploaded']) : date('\O\n D, F jS \a\t h:i a', $value['date_uploaded']),
        ));
        
        $count++;
    }
    
    if(empty($count))
    {
        $template->assign_block_vars('blogs_five_hide', array());
    }        
}

include('../includes/footer.php');
 */
?>
