<?

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * //
// members.php (extras/members)                                                                                         //
// (C) July 10th, 2006 Kevin David Nuut (kevin.nuut@gmail.com)                         //
// Displays all TXM members with various sort filters                                             //
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

define('ROOT', true);
define('PAGE_TITLE', 'Sort Existing Members');
include('../includes/header.php');

// Lets Make Sure they are Logged In
if(!$SITE_USER['session_logged_in']) 
{
    include('../includes/registerlogin.php');
    include('../includes/footer.php');    
}
else
{
    include('includes/common.php');

    // Initialize the Post and Get variables
    $start = isset($_POST['start']) ? intval($_POST['start']) : (isset($_GET['mode']) ? intval($_GET['start'])     : 0);
    $mode  = isset($_POST['mode'])  ? $_POST['mode']                     : (isset($_GET['mode']) ? $_GET['mode']                     : NULL);
    
    if(isset($_POST['letter']))
    {
        $by_letter = !empty($_POST['letter']) ? $_POST['letter'] : 'all';
    }
    else if(isset($_GET['letter']))
    {
        $by_letter = !empty($_GET['letter']) ? $_GET['letter'] : 'all';
    }
    else
    {
        $by_letter = 'all';
    }
        
    if(isset($_POST['order']))
    {
        $sort_order = ($_POST['order'] == 'ASC') ? 'ASC' : 'DESC';
    }
    else if(isset($_GET['order']))
    {
        $sort_order = ($_GET['order'] == 'ASC') ? 'ASC' : 'DESC';
    }
    else
    {
        $sort_order = 'ASC';
    }
    
    // Memberlist sorting
    $mode_types_text = array(
        'Sort_Joined', 
        'Sort_Username', 
        'Sort_Location', 
        'Sort_Posts', 
        'Sort_Email',  
        'Sort_Website', 
        'Sort_Posts', 
        'Sort_Top_Ten', 
        'Sort_Points',
    );
    
    $mode_types = array(
        'joindate', 
        'username', 
        'location', 
        'posts', 
        'email', 
        'website', 
        'posts', 
        'topten', 
        'points'
    );
    
    $select_sort_mode = "<SELECT NAME='mode'>";
    for($i = 0; $i < count($mode_types_text); $i++)
    {
        $selected = ($mode == $mode_types[$i]) ? " SELECTED='selected'" : "";
        $select_sort_mode .= "<OPTION VALUE='{$mode_types[$i]}' {$selected}>{$mode_types_text[$i]}</OPTION>";
    }
    $select_sort_mode .= "</SELECT>";
    
    $select_sort_order = "<SELECT NAME='order'>";
    if($sort_order == 'ASC')
    {
        $select_sort_order .= "<OPTION VALUE='asc' SELECTED='selected'>Sort Ascending</OPTION><OPTION VALUE='desc'>Sort Descending</OPTION>";
    }
    else
    {
        $select_sort_order .= "<OPTION VALUE='asc'>Sort Ascending</OPTION><OPTION VALUE='desc' SELECTED='selected'>Sort Descending</OPTION>";
    }
    $select_sort_order .= "</SELECT>";
    
    $template->assign_vars(array(
        'L_SELECT_SORT_METHOD'     => 'Select_sort_method',
        'L_EMAIL'                             => 'Email',
        'L_WEBSITE'                         => 'Website',
        'L_FROM'                                 => 'Location',
        'L_ORDER'                             => 'Order',
        'L_SORT'                                 => 'Sort',
        'L_SUBMIT'                             => 'Sort',
        'L_AIM'                                 => 'AIM',
        'L_YIM'                                 => 'YIM',
        'L_MSNM'                                 => 'MSNM',
        'L_ICQ'                                 => 'ICQ', 
        'L_JOINED'                             => 'Joined', 
        'L_POSTS'                             => 'Posts',
        'L_POINTS'                             => 'Points',    
        'S_MODE_SELECT'                 => $select_sort_mode,
        'S_ORDER_SELECT'                 => $select_sort_order,
    ));
    
    switch($mode)
    {
        case 'joindate':
            $order_by = "user_regdate ASC LIMIT $start, " . $SITE_CONF['topics_per_page'];
            break;
        case 'username':
            $order_by = "username $sort_order LIMIT $start, " . $SITE_CONF['topics_per_page'];
            break;
        case 'location':
            $order_by = "user_from $sort_order LIMIT $start, " . $SITE_CONF['topics_per_page'];
            break;
        case 'posts':
            $order_by = "user_posts $sort_order LIMIT $start, " . $SITE_CONF['topics_per_page'];
            break;
        case 'email':
            $order_by = "user_email $sort_order LIMIT $start, " . $SITE_CONF['topics_per_page'];
            break;
        case 'website':
            $order_by = "user_website $sort_order LIMIT $start, " . $SITE_CONF['topics_per_page'];
            break;
        case 'topten':
            $order_by = "user_posts DESC LIMIT 10";
            break;
        case 'posts':
            $order_by = "user_posts $sort_order LIMIT $start," . $SITE_CONF['topics_per_page'];
            break;
        case 'points':
            $order_by = "user_points $sort_order LIMIT $start," . $SITE_CONF['topics_per_page'];
            break;
        default:
            $order_by = "user_regdate $sort_order LIMIT $start, " . $SITE_CONF['topics_per_page'];
            break;
    }
    
    //Search members by letter's mod
    $others_sql = '';
    $select_letter = '';
    for ($i = 97; $i <= 122; $i++)
    {
        $others_sql .= " AND username NOT LIKE '" . chr($i) . "%' ";
        $select_letter .= ( $by_letter == chr($i) ) ? chr($i) . '&nbsp;' : '<a href="' . "memberlist.$phpEx?letter=" . chr($i . "&amp;mode=$mode&amp;order=$sort_order&amp;start=$start") . '">' . chr($i) . '</a>&nbsp;';
    }
    $select_letter .= ( $by_letter == 'others' ) ? 'Others' . '&nbsp;' : '<a href="' . "memberlist.$phpEx?letter=others&amp;mode=$mode&amp;order=$sort_order&amp;start=$start" . '">' . 'Others' . '</a>&nbsp;';
    $select_letter .= ( $by_letter == 'all' ) ? 'All' : '<a href="' . "memberlist.$phpEx?letter=all&amp;mode=$mode&amp;order=$sort_order&amp;start=$start" . '">' . 'All' . '</a>';
    
    $template->assign_vars(array(
        'L_SORT_PER_LETTER' => 'Sort_per_letter',
        'S_LETTER_SELECT' => $select_letter,
        'S_LETTER_HIDDEN' => '<input type="hidden" name="letter" value="' . $by_letter . '">')
    );
    
    if($by_letter == 'all')
    {
        $letter_sql = "";
    }
    else if($by_letter == 'others')
    {
        $letter_sql = $others_sql;
    }
    else
    {
        $letter_sql = " AND username LIKE '$by_letter%' ";
    }
    //End mod
    
    $sql = "SELECT username, user_id, user_viewemail, user_posts, user_regdate, user_from, user_website, user_email, user_icq, user_aim, user_yim, user_msnm, user_avatar, user_avatar_type, user_allowavatar, user_points 
        FROM " . USERS_TABLE . "
        WHERE user_id <> " . ANONYMOUS . "$letter_sql
        ORDER BY $order_by";
    if( !($result = $db->sql_query($sql)) )
    {
        message_die(GENERAL_ERROR, 'Could not query users', '', __LINE__, __FILE__, $sql);
    }
    
    if ( $row = $db->sql_fetchrow($result) )
    {
        $i = 0;
        do
        {
            $username = $row['username'];
            $user_id = $row['user_id'];
    
            $from = ( !empty($row['user_from']) ) ? $row['user_from'] : '&nbsp;';
            $joined = create_date('DATE_FORMAT', $row['user_regdate'], $SITE_CONF['board_timezone']);
            $posts = ( $row['user_posts'] ) ? $row['user_posts'] : 0;
    
            $poster_avatar = '';
            if ( $row['user_avatar_type'] && $user_id != ANONYMOUS && $row['user_allowavatar'] )
            {
                switch( $row['user_avatar_type'] )
                {
                    case USER_AVATAR_UPLOAD:
                        $poster_avatar = ( $SITE_CONF['allow_avatar_upload'] ) ? '<img src="' . $SITE_CONF['avatar_path'] . '/' . $row['user_avatar'] . '" alt="" border="0" />' : '';
                        break;
                    case USER_AVATAR_REMOTE:
                        $poster_avatar = ( $SITE_CONF['allow_avatar_remote'] ) ? '<img src="' . $row['user_avatar'] . '" alt="" border="0" />' : '';
                        break;
                    case USER_AVATAR_GALLERY:
                        $poster_avatar = ( $SITE_CONF['allow_avatar_local'] ) ? '<img src="' . $SITE_CONF['avatar_gallery_path'] . '/' . $row['user_avatar'] . '" alt="" border="0" />' : '';
                        break;
                }
            }
    
            if ( !empty($row['user_viewemail']) || $SITE_USER['user_level'] == ADMIN )
            {
                $email_uri = ( $SITE_CONF['board_email_form'] ) ? "profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $user_id : 'mailto:' . $row['user_email'];
    
                $email_img = '<a href="' . $email_uri . '"><img src="' . $images['icon_email'] . '" alt="' . 'Send_email' . '" title="' . 'Send_email' . '" border="0" /></a>';
                $email = '<a href="' . $email_uri . '">' . 'Send_email' . '</a>';
            }
            else
            {
                $email_img = '&nbsp;';
                $email = '&nbsp;';
            }
    
            $temp_url = "profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$user_id";
            $profile_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_profile'] . '" alt="' . 'Read_profile' . '" title="' . 'Read_profile' . '" border="0" /></a>';
            $profile = '<a href="' . $temp_url . '">' . 'Read_profile' . '</a>';
    
            $temp_url = "privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=$user_id";
            $pm_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_pm'] . '" alt="' . 'Send_private_message' . '" title="' . 'Send_private_message' . '" border="0" /></a>';
            $pm = '<a href="' . $temp_url . '">' . 'Send_private_message' . '</a>';
    
            $www_img = ( $row['user_website'] ) ? '<a href="' . $row['user_website'] . '" target="_userwww"><img src="' . $images['icon_www'] . '" alt="' . 'Visit_website' . '" title="' . 'Visit_website' . '" border="0" /></a>' : '';
            $www = ( $row['user_website'] ) ? '<a href="' . $row['user_website'] . '" target="_userwww">' . 'Visit_website' . '</a>' : '';
    
            if ( !empty($row['user_icq']) )
            {
                $icq_status_img = '<a href="http://wwp.icq.com/' . $row['user_icq'] . '#pager"><img src="http://web.icq.com/whitepages/online?icq=' . $row['user_icq'] . '&img=5" width="18" height="18" border="0" /></a>';
                $icq_img = '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $row['user_icq'] . '"><img src="' . $images['icon_icq'] . '" alt="' . 'ICQ' . '" title="' . 'ICQ' . '" border="0" /></a>';
                $icq =  '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $row['user_icq'] . '">' . 'ICQ' . '</a>';
            }
            else
            {
                $icq_status_img = '';
                $icq_img = '';
                $icq = '';
            }
    
            $aim_img = ( $row['user_aim'] ) ? '<a href="aim:goim?screenname=' . $row['user_aim'] . '&amp;message=Hello+Are+you+there?"><img src="' . $images['icon_aim'] . '" alt="' . 'AIM' . '" title="' . 'AIM' . '" border="0" /></a>' : '';
            $aim = ( $row['user_aim'] ) ? '<a href="aim:goim?screenname=' . $row['user_aim'] . '&amp;message=Hello+Are+you+there?">' . 'AIM' . '</a>' : '';
    
            $temp_url = "profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$user_id";
            $msn_img = ( $row['user_msnm'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_msnm'] . '" alt="' . 'MSNM' . '" title="' . 'MSNM' . '" border="0" /></a>' : '';
            $msn = ( $row['user_msnm'] ) ? '<a href="' . $temp_url . '">' . 'MSNM' . '</a>' : '';
    
            $yim_img = ( $row['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $row['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="' . 'YIM' . '" title="' . 'YIM' . '" border="0" /></a>' : '';
            $yim = ( $row['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $row['user_yim'] . '&amp;.src=pg">' . 'YIM' . '</a>' : '';
    
            $temp_url = "search.$phpEx?search_author=" . urlencode($username . "&amp;showresults=posts");
            $search_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_search'] . '" alt="' . 'Search_user_posts' . '" title="' . 'Search_user_posts' . '" border="0" /></a>';
            $search = '<a href="' . $temp_url . '">' . 'Search_user_posts' . '</a>';
            $user_points = $row['user_points'];
    
            $row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
            $row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
    
            $template->assign_block_vars('memberrow', array(
                'ROW_NUMBER' => $i + ( $_GET['start'] + 1 ),
                'ROW_COLOR' => '#' . $row_color,
                'ROW_CLASS' => $row_class,
                'USERNAME' => $username,
                'FROM' => $from,
                'JOINED' => $joined,
                'POSTS' => $posts,
                'AVATAR_IMG' => $poster_avatar,
                'PROFILE_IMG' => $profile_img, 
                'PROFILE' => $profile, 
                'SEARCH_IMG' => $search_img,
                'SEARCH' => $search,
                'PM_IMG' => $pm_img,
                'PM' => $pm,
                'EMAIL_IMG' => $email_img,
                'EMAIL' => $email,
                'WWW_IMG' => $www_img,
                'WWW' => $www,
                'ICQ_STATUS_IMG' => $icq_status_img,
                'ICQ_IMG' => $icq_img, 
                'ICQ' => $icq, 
                'AIM_IMG' => $aim_img,
                'AIM' => $aim,
                'MSN_IMG' => $msn_img,
                'MSN' => $msn,
                'YIM_IMG' => $yim_img,
                'YIM' => $yim,
                'POINTS' => $user_points,
                
                'U_VIEWPROFILE' => "profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$user_id")
            );
    
            $i++;
        }
        while ( $row = $db->sql_fetchrow($result) );
    }
    
    if ( $mode != 'topten' || $SITE_CONF['topics_per_page'] < 10 )
    {
        $sql = "SELECT count(*) AS total
            FROM " . USERS_TABLE . "
            WHERE user_id <> " . ANONYMOUS . "$letter_sql";
    
        if ( !($result = $db->sql_query($sql)) )
        {
            message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
        }
    
        if ( $total = $db->sql_fetchrow($result) )
        {
            $total_members = $total['total'];
    
            // $pagination = generate_pagination("memberlist.$phpEx?mode=$mode&amp;order=$sort_order&amp;letter=$by_letter", $total_members, $SITE_CONF['topics_per_page'], $start). '&nbsp;';
        }
    }
    else
    {
        $pagination = '&nbsp;';
        $total_members = 10;
    }
    
    $template->assign_vars(array(
        'TOTAL_MEMBERS_RETURNED'     => $total_members,
        // 'PAGINATION'                             => ($total_members > 0) ? $pagination : '',
        'PAGE_NUMBER'                         => ($total_members > 0) ? 'Page ' . floor($start / $SITE_CONF['topics_per_page']) + 1 . ' of ' . ceil($total_members / $SITE_CONF['topics_per_page']) : '', 
    ));
    
    include('../includes/footer.php');
}

?>
