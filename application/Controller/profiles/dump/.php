<?

define('ROOT', true);
define('PAGE_TEMPLATE', 'index');
include('../includes/header.php');
include('includes/common.php');

// Find all groups that the member is a part of.
$groups = '';

$sql = "
    SELECT g.group_moderator, g.group_name, g.group_id 
    FROM " . GROUPS_TABLE . " g, " . USER_GROUP_TABLE . " ug 
  WHERE ug.user_id = '" . $profile_user['user_id'] . "' 
      AND g.group_id = ug.group_id 
        AND g.group_single_user <> " . TRUE . " 
        AND ug.user_pending <> ".TRUE . " 
        AND g.group_type <> '" . GROUP_HIDDEN . "'
  ORDER BY g.group_name
";

if(!$result = $db->sql_query($sql)) message_die(GENERAL_ERROR, 'Error getting group information (SQL).');

if($group_list = $db->sql_fetchrowset($result)) 
{ 
    for($j = 0; $j < count($group_list); $j++) 
    { 
        $groups .= "<A HREF='groups.php/{$group_list[$j]['group_id']}'>{$group_list[$j]['group_name']}</A>" .
            (($group_list[$j]['group_moderator'] == $profile_user['user_id']) ? ' [Moderator]' : ' [Member]') . "<BR>";
    }
}

// Gather rank titles.
$sql = "SELECT * FROM " . RANKS_TABLE . " ORDER BY rank_special, rank_min";
if (!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'Could not obtain ranks information.');
while ($row = $db->sql_fetchrow($result)) $ranksrow[] = $row;

// Calculate the number of days this user has been a member then calculate their posts per day.
$regdate = $profile_user['user_regdate'];
$memberdays = max(1, round((time() - $regdate) / 86400));
$posts_per_day = $profile_user['user_posts'] / $memberdays;

// Get the users percentage of total posts
if ($profile_user['user_posts'] != 0)
{
    $sql = "SELECT SUM(forum_posts) AS post_total FROM " . FORUMS_TABLE;
    if (!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'Could not obtain post total (SQL).');
    $row = $db->sql_fetchrow($result);
            
    $total_posts = $row['post_total'];
    $percentage = ($total_posts) ? min(100, ($profile_user['user_posts'] / $total_posts) * 100) : 0;
}
else
{
    $percentage = 0;
}

$avatar_img = '';
if ( $profile_user['user_avatar_type'] && $profile_user['user_allowavatar'] )
{
    switch( $profile_user['user_avatar_type'] )
    {
        case USER_AVATAR_UPLOAD:
            $avatar_img = ( $SITE_CONF['allow_avatar_upload'] ) ? '<img src="' . $SITE_CONF['avatar_path'] . '/' . $profile_user['user_avatar'] . '" alt="" border="0" />' : '';
            break;
        case USER_AVATAR_REMOTE:
            $avatar_img = ( $SITE_CONF['allow_avatar_remote'] ) ? '<img src="' . $profile_user['user_avatar'] . '" WIDTH=80 HEIGHT=80 BORDER=0>' : '';
            break;
        case USER_AVATAR_GALLERY:
            $avatar_img = ( $SITE_CONF['allow_avatar_local'] ) ? '<img src="' . $SITE_CONF['avatar_gallery_path'] . '/' . $profile_user['user_avatar'] . '" alt="" border="0" />' : '';
            break;
    }
}

$button_panel = '';
$poster_rank = '';
$rank_image = '';
if ( $profile_user['user_rank'] )
{
    for($i = 0; $i < count($ranksrow); $i++)
    {
        if ( $profile_user['user_rank'] == $ranksrow[$i]['rank_id'] && $ranksrow[$i]['rank_special'] )
        {
            $poster_rank = $ranksrow[$i]['rank_title'];
            $rank_image = ( $ranksrow[$i]['rank_image'] ) ? '<img src="' . $ranksrow[$i]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
        }
    }
}
else
{
    for($i = 0; $i < count($ranksrow); $i++)
    {
        if ( $profile_user['user_posts'] >= $ranksrow[$i]['rank_min'] && !$ranksrow[$i]['rank_special'] )
        {
            $poster_rank = $ranksrow[$i]['rank_title'];
            $rank_image = ( $ranksrow[$i]['rank_image'] ) ? '<img src="' . $ranksrow[$i]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
        }
    }
}

$temp_url = "privmsg.php?mode=post&amp;" . POST_USERS_URL . "=" . $profile_user['user_id'];

// Setup Contacts
$email = (!empty($profile_user['user_viewemail']) || $SITE_USER['user_level'] == ADMIN) ? "<A HREF='" . ($SITE_CONF['board_email_form'] ? "profile.php?mode=email&" . POST_USERS_URL . "={$profile_user['user_id']}" : "mailto:{$profile_user['user_email']}") . "'>Mail To Contact</A>" : "";
$www_title = $profile_user['user_website_title'] ? $profile_user['user_website_title'] : $profile_user['user_website'];
$www = $profile_user['user_website'] ? "<A HREF='{$profile_user['user_website']}' TARGET='_userwww'>{$www_title}</A>" : "";
$www .= $profile_user['user_website_title'] ? "<BR>" . $profile_user['user_website_desc'] : "";
$aim = $profile_user['user_aim'] ? "<A HREF='aim:goim?screenname={$profile_user['user_aim']}&message=Are+you+{$profile_user['username']}+from+TxMafia.COM+because+this+is+{$SITE_USER['username']}.'>{$profile_user['user_aim']}</A>" : "";
$icq = $profile_user['user_icq'] ? "<A HREF='http://wwp.icq.com/scripts/search.dll?to={$profile_user['user_icq']}'>{$profile_user['user_icq']}</A>" : "";
$msn = $profile_user['user_msnm'] ? "<A HREF='onMouseOver=trig_box(\"{$profile_user['user_msnm']}\");' onMouseOut='trig_box();'>View MSN Email</A>" : "";
$yim = $profile_user['user_yim'] ? "<A HREF='http://edit.yahoo.com/config/send_webmesg?.target={$profile_user['user_yim']}&.src=pg'>{$profile_user['user_yim']}</A>" : "";

// Create link for admins to directly edit user account
if($SITE_USER['user_level'] == ADMIN) 
{ 
    $admin_output = "
        <TABLE BORDER='0' CELLSPACING='0' CELLPADDING='2' CLASS='profile'>
            <TR><TD>Screen Name</TD><TD>{$profile_user['username']}</TD></TR>
            <TR><TD WIDTH='300'>User ID</TD><TD WIDTH='300'>{$profile_user['user_id']}</TD></TR>
            <TR><TD>IP Address</TD><TD>" . decode_ip($profile_user['user_regip']) . "</TD></TR>
            <TR><TD>Active</TD><TD>{$profile_user['user_active']}</TD></TR>
            
            <TR><TD>.</TD><TD></TD></TR>
            
            <TR><TD>Forum Level</TD><TD>{$profile_user['user_level']}</TD></TR>
            <TR><TD>Rank</TD><TD>{$profile_user['user_rank']}</TD></TR>
            <TR><TD>Points</TD><TD>{$profile_user['user_points']}</TD></TR>
            <TR><TD>Respect</TD><TD>{$profile_user['respect']}</TD></TR>
            
            <TR><TD>.</TD><TD></TD></TR>
            
            <TR><TD>Bootleg Views</TD><TD>{$profile_user['bootleg_views']}</TD></TR>
            <TR><TD>Bootleg Uploads</TD><TD>{$profile_user['bootleg_uploads']}</TD></TR>
            <TR><TD>Bootleg Comments</TD><TD>{$profile_user['bootleg_comments']}</TD></TR>
            <TR><TD>Bootleg Votes</TD><TD>{$profile_user['bootleg_votes']}</TD></TR>
            
            <TR><TD>.</TD><TD></TD></TR>
            
            <TR><TD>Forum Views</TD><TD>{$profile_user['forums_views']}</TD></TR>
            <TR><TD>Forum Topics</TD><TD>{$profile_user['forums_topics']}</TD></TR>
            <TR><TD>Forum Replies</TD><TD>{$profile_user['forums_replies']}</TD></TR>
            
            <TR><TD>.</TD><TD></TD></TR>
            
            <TR><TD>Art Views</TD><TD>{$profile_user['art_views']}</TD></TR>
            <TR><TD>Art Uploads</TD><TD>{$profile_user['art_uploads']}</TD></TR>
            <TR><TD>Art Comments</TD><TD>{$profile_user['art_comments']}</TD></TR>
            <TR><TD>Art Votes</TD><TD>{$profile_user['art_votes']}</TD></TR>
            
            <TR><TD>.</TD><TD></TD></TR>
            
            <TR><TD>Cellblock Views</TD><TD>{$profile_user['cellblock_views']}</TD></TR>
            <TR><TD>Cellblock Uploads</TD><TD>{$profile_user['cellblock_uploads']}</TD></TR>
            <TR><TD>Cellblock Votes</TD><TD>{$profile_user['cellblock_votes']}</TD></TR>
            <TR><TD>Cellblock Reviews</TD><TD>{$profile_user['cellblock_comments']}</TD></TR>
        </TABLE>
    ";

    $template->assign_vars(array( 
        'ADMIN'    => $admin_output,
    ));  
} 

$category_list = array(
    'Undeclared',
    'A Comedy',
    'An Open Drama',
    'A Horror Flick',
    'A Noir Short',
    'A Timeless Film',            
    'A Clever Parody',
    'A Great Series',    
);

$sql = "
    SELECT cell_id, title, vote_num, view_num, category, time, 
    IF(vote_num > 0,((vote_sum * 100 + quick_vote_sum) / (vote_num * 100 + quick_vote_num)), 0.00) 
        AS vote_score
    FROM " . CELLBLOCK . "
    WHERE bar=0 
        AND user_id={$profile_user['user_id']} 
    ORDER BY time DESC
";

$row = array();
if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, $sql . ' Could not obtain Index Info (SQL).');
while($value = $db->sql_fetchrow($result)) $row[] = $value;

if (count($row)) 
{
    for($i = 0; $i < count($row); $i++) 
    {
        // Post info
        $i % 2 == 0 ? $cell_back = "view_backdrop.gif" : $cell_back = "view_highlight.gif";
        
        $cell_url = "viewcell.php?cellid={$row[$i]['cell_id']}";
        $cell_time = create_date($SITE_CONF['default_dateformat'], $row[$i]['time'], $SITE_CONF['board_timezone']);
        
        if($row[$i]['category'] == 99) $row[$i]['category'] = 0;
         
        $template->assign_block_vars('view_more', array(
            'CELL_BACK'        => $cell_back,
            'CELL_TITLE'     => $row[$i]['title'],
            'CELL_LINK'     => "http://{$row[$i]['cell_id']}.txmafia.com",
            'CELL_SCORE'     => $row[$i]['vote_score'],
            'CELL_VOTES'     => $row[$i]['vote_num'],
            'CELL_VIEWS'     => $row[$i]['view_num'],
            'CELL_CATEGORY' => $row[$i]['category'] < 8 ? $category_list[$row[$i]['category']] : 'A Flash Game',
        ));
    }
} 
else
{ 
    $template->assign_block_vars('no_view_more', array());
}

$array_photo_type = array('error', 'gif', 'jpg', 'png');
$array_sex = array('Undeclared', 'Female', 'Male');

// Get Friends for the 4 levels
get_friends(0);
get_friends(1);
get_friends(2);
get_friends(3);

// Begin Display Outputs
$born = !empty($profile_user['pi_born']) ? $profile_user['pi_born'] : '';
if($born)
{
    $date['date_day'] = substr($born, 6, 2);
    $date['date_month'] = substr($born, 4, 2);
    $date['date_year'] = substr($born, 0, 4);
    
    $day_options                 = '';
    $month_options             = '';
    $year_options             = '';
    $date_day_prefix        = array('st', 'nd', 'rd');
    $date_month_prefix     = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        
    for ($i = 1; $i <= 31; $i++) 
    {
        if($i == intval($date['date_day']))
        {
            $date_prefix_i = ($i - 1) % 10;
            $day_str = ($date_prefix_i < 3 && ($i < 11 || $i > 13)) ? $i . $date_day_prefix[$date_prefix_i] : $i . 'th';
        }
    }
    
    for ($i = 1; $i <= 12; $i++) 
    {
        if($i == intval($date['date_month']))
        {
            $month_str = $date_month_prefix[$i - 1];
        }
    }
    
    for ($i = date('Y'); $i >= date('Y') - 100; $i--) 
    {
        if($i == intval($date['date_year']))
        {
            $year_str = $i;
        }
    }
    
    $born = $month_str . ' ' . $day_str . ', ' . $year_str;
}

$sex = !empty($profile_user['pi_sex']) ? $array_sex[$profile_user['pi_sex']] : 0;

// Write Notes
$template->assign_block_vars('writenote', array());

// Contacts
if ($profile_user['user_email'] || $profile_user['user_icq'] || $profile_user['user_aim'] || $profile_user['user_yim'] || $profile_user['user_msnm'] || $profile_user['user_occ']) $template->assign_block_vars('contacts', array());
// Personal Information
if ($profile_user['pi_relationship'] || $profile_user['pi_preference'] || $profile_user['pi_status'] || $profile_user['pi_interests'] || $profile_user['pi_about']) $template->assign_block_vars('personal_information', array());
// Favorites
if ($profile_user['fv_music'] || $profile_user['fv_movies'] || $profile_user['fv_games'] || $profile_user['fv_books'] || $profile_user['fv_artists'] || $profile_user['fv_quotes']) $template->assign_block_vars('favorites', array());

if(file_exists("avatars/{$profile_user['user_id']}.gif"))
{
    $avatar = "<IMG SRC='http://www.txmafia.com/profiles/avatars/{$profile_user['user_id']}.gif' ALT='{$profile_user['username']}' STYLE='border: 2px solid black'>";
}
else
{
    $avatar = "<IMG SRC='http://www.txmafia.com/profiles/randoms/1.png' ALT='{$profile_user['username']}' STYLE='border: 2px solid black'>";
}

if(file_exists("photos/{$profile_user['user_id']}.gif"))
{
    $template->assign_block_vars('member_photo', array());
    $photo = "<IMG SRC='http://www.txmafia.com/profiles/photos/{$profile_user['user_id']}.gif' ALT='{$profile_user['username']}' STYLE='border: 2px solid black'>";
}
else
{
    $photo = '';
}

$sql = "SELECT MAX(respect) AS max FROM " . USERS_TABLE;
if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'Could not obtain Index Info (SQL).');
list($respect_max) = $db->sql_fetchrow($result);

$profile_user['user_name'] = !empty($profile_user['user_nick_name']) ? $profile_user['user_nick_name'] : ucwords($profile_user['username']);
$profile_user['user_link'] = strtolower($profile_user['username']);
define('PAGE_TITLE', "{$profile_user['user_name']} ({$profile_user['user_link']})");

$template->assign_vars(array(
    // Contacts
    'EMAIL'                     => create_profile_table_sub('Email', $email),
    'AIM'                         => create_profile_table_sub('AIM', $aim),
    'ICQ'                         => create_profile_table_sub('ICQ', $icq),
    'MSN'                         => create_profile_table_sub('MSN', $msn),
    'YIM'                         => create_profile_table_sub('YIM', $yim),

    // Member Profile
    'PROFILE_ID'            => $profile_user['user_id'],
    'USERNAME'                 => $profile_user['username'],
    
    'NICKNAME'                => $profile_user['user_name'],
    'LINK'                        => 'http://' . strtolower(str_replace(' ', '', $profile_user['username'])) . '.' . $SITE_DOMAIN . '.com',
    'POSTER_RANK'         => $poster_rank,
    'LAST_VISIT'            => date('D, M jS, \a\t h:i a', $profile_user['user_lastvisit']),
    'ACTIVITY'                => wardrobe(),
    'REG_IP'                     => decode_ip($profile_user['user_regip']),
        
    // Basic Information
    'JOINED'                    => create_profile_table('Joined', date('D, M jS, Y, \a\t h:i a', $profile_user['user_regdate'])),
    'BORN'                        => create_profile_table('Born', $born),
    'SEX'                            => create_profile_table('Sex', $sex),
    'WEBSITE'                    => create_profile_table('Website', $www),
    'OCCUPATION'            => create_profile_table('Occupation', $profile_user['user_occ']),
    'SKILLS'                    => create_profile_table('Skills', $profile_user['user_interests']),

    // Txmafia Activity
    'GROUPS'                   => create_profile_table('Member Groups', $groups),
    'POSTS'                     => $profile_user['user_posts'],
    'POST_DAY'                 => number_format($posts_per_day, 2), 
    'POST_PERCENT'         => number_format($percentage, 2),

    'CELLBLOCK_COMMENTS'    => $profile_user['cellblock_comments'],
    'CELLBLOCK_VOTES'            => $profile_user['cellblock_votes'],
    'CELLBLOCK_VIEWS'            => $profile_user['cellblock_views'],
    'CELLBLOCK_UPLOADS'        => $profile_user['cellblock_uploads'],

    'ART_COMMENTS'                => $profile_user['art_comments'],
    'ART_VOTES'                        => $profile_user['art_votes'],
    'ART_VIEWS'                        => $profile_user['art_views'],
    'ART_UPLOADS'                    => $profile_user['art_uploads'],
    
    'BOOTLEG_COMMENTS'        => $profile_user['bootleg_comments'],
    'BOOTLEG_VOTES'                => $profile_user['bootleg_votes'],
    'BOOTLEG_VIEWS'                => $profile_user['bootleg_views'],
    'BOOTLEG_UPLOADS'            => $profile_user['bootleg_uploads'],
    
    'RESPECT'                            => $profile_user['respect'],
    'RESPECT_PERCENT'     => sprintf("%01.2f", 100 * intval($profile_user['respect']) / intval($respect_max)),
        
    // Personal Information
    'NAME'                        => create_profile_table('Name', $profile_user['user_full_name']),
    'PI_RELATIONSHIP'    => create_profile_table('Looking For', $profile_user['pi_relationship']),
    'PI_PREFERENCE'        => create_profile_table('Sexual Choice', $profile_user['pi_preference']),
    'PI_STATUS'                => create_profile_table('Relationship', $profile_user['pi_status']),
    'PI_INTERESTS'        => create_profile_table('Interests', $profile_user['pi_interests']), 
    'PI_ABOUT'                => create_profile_table('About Me', $profile_user['pi_about']),
    
    // Favorites
    'FV_MUSIC'                => create_profile_table('Music', $profile_user['fv_music']),
    'FV_MOVIES'                => create_profile_table('Movies', $profile_user['fv_movies']),
    'FV_GAMES'                => create_profile_table('Games', $profile_user['fv_games']),
    'FV_BOOKS'                => create_profile_table('Books', $profile_user['fv_books']),
    'FV_ARTISTS'            => create_profile_table('Artists', $profile_user['fv_artists']),
    'FV_QUOTES'                => create_profile_table('Quotes', $profile_user['fv_quotes']),
    
    // Extras
    'BUTTONS'                    => $button_panel,
    'PHOTO'                        => $photo,
    'AVATAR'                    => $avatar,
));

function create_profile_table_sub($d, $l)
{
    if (is_string($l) && !empty($l))
    {
        $l = nl2br($l);
        return "<TR><TD VALIGN='top' STYLE='color: #403214; font: bold 12px Verdana; text-align: right; width: 60px; padding-right: 24px;'>{$d}:</TD><TD CLASS='profile'  STYLE='padding-bottom: 8px;'>{$l}</TD></TR>";
    }
    else
    {
        return "";
    }
}

function create_profile_table($d, $l)
{
    if (is_string($l) && !empty($l))
    {
        $l = nl2br($l);
        return "<TR><TD VALIGN='top' CLASS='info'>{$d}:</TD><TD CLASS='profile' STYLE='padding-bottom: 8px;'>{$l}</TD></TR>";
    }
    else
    {
        return "";
    }
}
    
function wardrobe()
{
    $wardrobe0 = array(); // complete outfits
    $wardrobe1 = array(); // tops
    $wardrobe2 = array(); // bottoms
    $wardrobe3 = array(); // accessories
    
    array_push($wardrobe0, "a prom dress");
    array_push($wardrobe0, "a sumo suit");
    array_push($wardrobe0, "superman underoos");
    array_push($wardrobe0, "absolutely nothing");
    array_push($wardrobe0, "a tube sock");
    array_push($wardrobe0, "leather bondage");
    array_push($wardrobe0, "a sailor's uniform");
    array_push($wardrobe0, "a slinky dress");
    array_push($wardrobe0, "a wedding dress");
    array_push($wardrobe0, "a wet-suit");
    array_push($wardrobe0, "a suit of armor");
    array_push($wardrobe0, "just body paint");
    array_push($wardrobe0, "a french maid outfit");
    array_push($wardrobe0, "a nurse's uniform");
    array_push($wardrobe0, "footy pajamas");
    array_push($wardrobe0, "a jump suit");
    array_push($wardrobe0, "a space suit");
    array_push($wardrobe0, "tin foil");
    array_push($wardrobe0, "a bra and panties");
    array_push($wardrobe0, "a toga");
    
    array_push($wardrobe1, "a Mr. T t-shirt");
    array_push($wardrobe1, "a tube top");
    array_push($wardrobe1, "a push-up bra");
    array_push($wardrobe1, "a pink sweater");
    array_push($wardrobe1, "no shirt");
    array_push($wardrobe1, "nipple warmers");
    array_push($wardrobe1, "a leather jacket");
    array_push($wardrobe1, "a denim jacket");
    array_push($wardrobe1, "a t-shirt");
    array_push($wardrobe1, "a sweater");
    array_push($wardrobe1, "a Spongebob shirt");
    array_push($wardrobe1, "nipple rings");
    array_push($wardrobe1, "a live preserver");
    array_push($wardrobe1, "water wings");
    array_push($wardrobe1, "a tank top");
    array_push($wardrobe1, "a v-neck");
    array_push($wardrobe1, "a spandex shirt");
    array_push($wardrobe1, "a 'fake tie' T");
    array_push($wardrobe1, "a 'fake muscles' T");
    array_push($wardrobe1, "a TxM fanclub jacket");
    array_push($wardrobe1, "a parka");
    array_push($wardrobe1, "a bear skin");
    array_push($wardrobe1, "a fur coat");
    array_push($wardrobe1, "a silk robe");
    array_push($wardrobe1, "a fishnet top");
    array_push($wardrobe1, "a bulletproof vest");
    array_push($wardrobe1, "a stuffed wonderbra");
    array_push($wardrobe1, "duct taped dynomite");
    
    array_push($wardrobe2, "overalls");
    array_push($wardrobe2, "tighty whiteys");
    array_push($wardrobe2, "a speedo");
    array_push($wardrobe2, "bell bottoms");
    array_push($wardrobe2, "blue jeans");
    array_push($wardrobe2, "leather chaps");
    array_push($wardrobe2, "parachute pants");
    array_push($wardrobe2, "a long skirt");
    array_push($wardrobe2, "a short skirt");
    array_push($wardrobe2, "pink panties");
    array_push($wardrobe2, "no pants");
    array_push($wardrobe2, "boxer shorts");
    array_push($wardrobe2, "khakis");
    array_push($wardrobe2, "biker shorts");
    array_push($wardrobe2, "a jock strap");
    array_push($wardrobe2, "wrestling tights");
    array_push($wardrobe2, "a diaper");
    array_push($wardrobe2, "jogging pants");
    array_push($wardrobe2, "jogging shorts");
    array_push($wardrobe2, "tear away pants");
    array_push($wardrobe2, "cotton briefs");
    array_push($wardrobe2, "black pants");
    array_push($wardrobe2, "leather pants");
    array_push($wardrobe2, "shorts");
    array_push($wardrobe2, "short shorts");
    array_push($wardrobe2, "Daisy Dukes");
    array_push($wardrobe2, "a thong");
    
    array_push($wardrobe3, "bunny slippers");
    array_push($wardrobe3, "a top hat");
    array_push($wardrobe3, "a frankenstien mask");
    array_push($wardrobe3, "yellow bikini");
    array_push($wardrobe3, "tube socks");
    array_push($wardrobe3, "pantyhose");
    array_push($wardrobe3, "a beer hat");
    array_push($wardrobe3, "a powdred wig");
    array_push($wardrobe3, "an eye patch");
    array_push($wardrobe3, "handcuffs");
    array_push($wardrobe3, "a pearl necklace");
    array_push($wardrobe3, "a bandana");
    array_push($wardrobe3, "a Marge Simpson wig");
    array_push($wardrobe3, "a bald-cap");
    array_push($wardrobe3, "french perfume");
    array_push($wardrobe3, "a chastity belt");
    array_push($wardrobe3, "a tin-foil hat");
    array_push($wardrobe3, "a paper hat");
    array_push($wardrobe3, "a bike helmet");
    array_push($wardrobe3, "red lipstick");
    array_push($wardrobe3, "stilletto heels");
    array_push($wardrobe3, "a blindfold");
    array_push($wardrobe3, "a gun holster");
    array_push($wardrobe3, "a backpack");
    
    // grab one entry from each wardrobe array
    // ===========================================================================
    $suit             = $wardrobe0[rand(0, count($wardrobe0)-1)];
    $shirt             = $wardrobe1[rand(0, count($wardrobe1)-1)];
    $pants             = $wardrobe2[rand(0, count($wardrobe2)-1)];
    $accessory     = $wardrobe3[rand(0, count($wardrobe3)-1)];
    
    // Randomly decide what wardrobe groups to use, then dress the user
    // ===========================================================================
    $outfit = rand(1,500);
    
    if ($outfit > 400)             $wardrobe = $suit;
    else if ($outfit > 300) $wardrobe = $suit . " and " . $accessory;
    else if ($outfit > 200) $wardrobe = $shirt . " and " . $pants;
    else if ($outfit > 100) $wardrobe = $shirt . " and " . $accessory;
    else $wardrobe = $pants . " and " . $accessory;
    
    return $wardrobe;
}                        

include('../includes/footer.php');

function get_friends($level)
{
    global $db, $profile_user, $template;
    
    // Friends - START
    $sql = "SELECT count(*) AS total FROM " . FRIENDS_TABLE . " WHERE level={$level} AND user_id_1={$profile_user['user_id']}";
    if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, $sql . '<BR><BR>Error grabbing friends count (SQL).<BR>');
    $friends_exist = $db->sql_fetchrow($result);
    
    // Determine if user has any friends
    if(!empty($friends_exist[0]))
    {
        $template->assign_block_vars('friends_exist_' . $level, array(
            'FRIENDS_SHOWN' => min(12, $friends_exist['total']),
            'FRIENDS_TOTAL' => $friends_exist['total'],
            'FRIENDS_LEVEL' => $profile_user['friend_level_' . $level],
        ));
    
        // If so, grab a list of friends
        $sql = "SELECT u.avatar_type, u.user_id, u.username, f.level FROM " . USERS_TABLE . " u, " . FRIENDS_TABLE . " f
            WHERE u.user_id=f.user_id_2 AND f.user_id_1={$profile_user['user_id']} AND f.level={$level} ORDER BY RAND() LIMIT 12";
        
        if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, $sql . '<BR><BR>Error grabbing friends list (SQL).<BR>');
        while($friends = $db->sql_fetchrow($result))
        {
            $friends_url = str_replace(' ', '', strtolower($friends['username']));
            if(file_exists("avatars/{$friends['user_id']}.gif"))
            {
                $friends_avatar = "<IMG SRC='http://www.txmafia.com/profiles/avatars/{$friends['user_id']}.gif' ALT='{$friends['username']}' WIDTH='50' HEIGHT='50' STYLE='border: 2px solid black'>";
            }
            else
            {
                $friends_avatar = "<IMG SRC='http://www.txmafia.com/profiles/randoms/1.png' ALT='{$friends['username']}' WIDTH='50' HEIGHT='50' STYLE='border: 2px solid black'>";
            }
            
            $template->assign_block_vars('friends_' . $level, array(
                'ID'         => $friends['user_id'],
                'NAME'      => $friends_url,
                'LEVEL'  => $friends['level'],
                'AVATAR' => $friends_avatar,
            ));
        }
    }
}

?>