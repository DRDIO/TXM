<?php

ini_set("display_errors", "1");

define("ROOT", true);
define("PAGE_TITLE", "Movies");
define("PAGE_COMMON", true);
define("AD_APPROVED", true);
require_once("../includes/header.php");
require_once("includes/common.php");

if ($SITE_PROFILE->isSelf() === false) {
        SITE_Log::warning("You cannot edit other people's profiles.");
}

$error = FALSE;
$error_msg = '';

// username, user_timezone, user_aim, user_yim, user_msnm, user_occ, user_gtalk, user_icq, 
// pi_born, pi_sex, pi_relationship, pi_preference, pi_status, pi_interests, pi_about,
// fv_music, fv_movies, fv_games, fv_books, fv_artists, fv_quotes

// Initialize Variables
$edit_list = array(
    'user_id'                                => $SITE_USER['user_id'],
    'username'                            => $SITE_USER['username'],
    
    'cur_password'                     => !empty($_POST['user_cur_password'])             ? trim($_POST['user_cur_password'])                                                 : '', 
    'new_password'                     => !empty($_POST['user_new_password'])             ? trim($_POST['user_new_password'])                                                 : '', 
    'password_confirm'             => !empty($_POST['user_password_confirm'])     ? trim($_POST['user_password_confirm'])                                         : '',     
    'user_email'                        => !empty($_POST['user_email'])                         ? trim(strip_tags(htmlspecialchars($_POST['user_email'])))     : '',
    
    'user_timezone'                    => !empty($_POST['user_timezone'])                     ? doubleval($_POST['user_timezone'])                                                 : 0,
    
    'user_viewemail'                => isset($_POST['user_viewemail'])                     ? ($_POST['user_viewemail']                         ? 1 : 0)                         : 0,
    'user_attachsig'                => isset($_POST['user_attachsig'])                     ? ($_POST['user_attachsig']                         ? 1 : 0)                         : 0,
    'user_allow_viewonline'    => isset($_POST['user_allow_viewonline'])     ? ($_POST['user_allow_viewonline']             ? 1 : 0)                         : 0,
    'user_notify'                        => isset($_POST['user_notify'])                         ? ($_POST['user_notify']                                 ? 1 : 0)                         : 0,
    
    'user_full_name'                => !empty($_POST['user_full_name'])                 ? trim(strip_tags($_POST['user_full_name']))                                 : '',
    'user_nick_name'                => !empty($_POST['user_nick_name'])                 ? trim(strip_tags($_POST['user_nick_name']))                                 : $SITE_USER['username'],
    'user_interests'                => !empty($_POST['user_interests'])                 ? trim(strip_tags($_POST['user_interests']))                                 : '',
    'user_website_title'        => !empty($_POST['user_website_title'])         ? trim(strip_tags($_POST['user_website_title']))                         : '',
    'user_website'                    => !empty($_POST['user_website'])                     ? trim(strip_tags($_POST['user_website']))                                     : '',
    'user_website_desc'            => !empty($_POST['user_website_desc'])             ? trim(strip_tags($_POST['user_website_desc']))                         : '',
    'user_city'                            => !empty($_POST['user_city'])                             ? trim(strip_tags($_POST['user_city']))                                         : '',
    'user_from'                            => !empty($_POST['user_from'])                             ? trim(strip_tags($_POST['user_from']))                                         : '',
    'user_country'                    => !empty($_POST['user_country'])                     ? trim(strip_tags($_POST['user_country']))                                     : '',
    'user_sig'                            => !empty($_POST['user_sig'])                             ? trim($_POST['user_sig'])                                                                     : '',
    
    'user_icq'                            => !empty($_POST['user_icq'])                             ? trim(strip_tags($_POST['user_icq']))                                             : '',    
    'user_aim'                            => !empty($_POST['user_aim'])                             ? trim(strip_tags($_POST['user_aim']))                                             : '',
    'user_yim'                            => !empty($_POST['user_yim'])                             ? trim(strip_tags($_POST['user_yim']))                                             : '',
    'user_msnm'                            => !empty($_POST['user_msnm'])                             ? trim(strip_tags($_POST['user_msnm']))                                         : '',
    'user_occ'                            => !empty($_POST['user_occ'])                             ? trim(strip_tags($_POST['user_occ']))                                             : '',

    'pi_born'                                => !empty($_POST['pi_born'])                                 ? trim(strip_tags($_POST['pi_born']))                                              : '',
    'pi_sex'                                => !empty($_POST['pi_sex'])                                 ? trim(strip_tags($_POST['pi_sex']))                                              : 0,
    'pi_relationship'                => !empty($_POST['pi_relationship'])                 ? trim(strip_tags($_POST['pi_relationship']))                              : 0,
    'pi_preference'                    => !empty($_POST['pi_preference'])                     ? trim(strip_tags($_POST['pi_preference']))                                  : 0,
    'pi_status'                            => !empty($_POST['pi_status'])                             ? trim(strip_tags($_POST['pi_status']))                                          : '',
    'pi_interests'                    => !empty($_POST['pi_interests'])                     ? trim(strip_tags($_POST['pi_interests']))                                  : '',
    'pi_about'                            => !empty($_POST['pi_about'])                             ? trim(strip_tags($_POST['pi_about']))                                          : '',
        
    'fv_music'                            => !empty($_POST['fv_music'])                              ? trim(strip_tags($_POST['fv_music']))                                          : '',
    'fv_movies'                            => !empty($_POST['fv_movies'])                          ? trim(strip_tags($_POST['fv_movies']))                                          : '',
    'fv_games'                            => !empty($_POST['fv_games'])                              ? trim(strip_tags($_POST['fv_games']))                                          : '',
    'fv_books'                            => !empty($_POST['fv_books'])                              ? trim(strip_tags($_POST['fv_books']))                                          : '',
    'fv_artists'                        => !empty($_POST['fv_artists'])                          ? trim(strip_tags($_POST['fv_artists']))                                      : '',
    'fv_quotes'                            => !empty($_POST['fv_quotes'])                          ? trim(strip_tags($_POST['fv_quotes']))                                          : '',
    
    'friend_level_0'                => !empty($_POST['friend_level_0'])                  ? trim(strip_tags($_POST['friend_level_0']))                              : 'Acquaintances',
    'friend_level_1'                => !empty($_POST['friend_level_1'])                  ? trim(strip_tags($_POST['friend_level_1']))                              : 'Friends',
    'friend_level_2'                => !empty($_POST['friend_level_2'])                  ? trim(strip_tags($_POST['friend_level_2']))                              : 'Good Friends',
    'friend_level_3'                => !empty($_POST['friend_level_3'])                  ? trim(strip_tags($_POST['friend_level_3']))                              : 'Best Friends',
    
    'date_day'                            => !empty($_POST['date_day'])                              ? $_POST['date_day']                                                                              : date('d'),
    'date_month'                        => !empty($_POST['date_month'])                          ? $_POST['date_month']                                                                          : date('m'),
    'date_year'                            => !empty($_POST['date_year'])                          ? $_POST['date_year']                                                                              : date('Y'),
);
    
/* User Profile Attributes that remain hidden
user_id, user_active, username, user_session_time, user_session_page, user_lastvisit, user_regdate, user_regip, user_level, 
user_posts, user_style, user_lang, user_dateformat, user_new_privmsg, user_unread_privmsg, user_last_privmsg, 
user_emailtime, user_allowhtml, user_allowbbcode, user_allowsmile, user_allowavatar, user_allow_pm, user_allow_mass_pm,
user_notify_pm, user_popup_pm, user_rank, user_points, user_avatar, user_avatar_type, user_actkey, photo_type, avatar_type, 
bootleg_views, bootleg_uploads, bootleg_comments, bootleg_votes, cellblock_views, cellblock_uploads, cellblock_comments, 
cellblock_votes, forums_views, forums_topics, forums_replies, art_views, art_uploads, art_comments, art_votes, respect, 
user_cb_views, user_cb_uploads, user_cb_votes, user_cb_reviews, user_newpasswd, user_sig_bbcode_uid */
    
// Update Users profile in SQL.
if(isset($_POST['submit'])) 
{
    if(checkdate($edit_list['date_month'], $edit_list['date_day'], $edit_list['date_year']))
    {
        if(intval((date('Y') - 13) . date('m') . date('d')) >= intval($edit_list['date_year'] . $edit_list['date_month'] . $edit_list['date_day']))
        {
            $edit_list['pi_born'] = $edit_list['date_year'] . $edit_list['date_month'] . $edit_list['date_day'];
        }
        else
        {
            $error = TRUE;
            $error_msg .= 'You must be over 13 to be a member.<BR>';
        }
    }
    else
    {
        $error = TRUE;
        $error_msg .= 'You must provide a valid birth date.<BR>';
    }

    $edit_list['user_sig'] = str_replace('<BR>', '', $edit_list['user_sig']);
    
    if($edit_list['user_attachsig'] === 0) 
    {
        $edit_list['user_sig'] = '';
    }
    
    // Format websites to include http:// and be valid
    if($edit_list['user_website'] !== '')
    {
        if(!preg_match('#^http:\/\/#i', $edit_list['user_website']))
        {
            $edit_list['user_website'] = 'http://' . $edit_list['user_website'];
        }
    
        if (!preg_match('#^http\\:\\/\\/[a-z0-9\-]+\.([a-z0-9\-]+\.)?[a-z]+#i', $edit_list['user_website']) )
        {
            $edit_list['user_website'] = '';
        }
        else
        {
            rawurlencode($edit_list['user_website']);
        }
    }
    
    // Upload Avatar at 100 x 100 GIF
    $avatar_input = array(
        'title'                => 'avatar',
        'user_id'            => $edit_list['user_id'],
        'method'            => !empty($_POST['avatar_remote_url']) ? 'remote' : (!empty($_FILES['avatar_local']['tmp_name']) ? 'local' : ''),
        'url'                    => $_POST['avatar_remote_url'],
        'temp_name'     => $_FILES['avatar_local']['tmp_name'],
        'temp_size'        => $_FILES['avatar_local']['size'],
        'temp_error'    => $_FILES['avatar_local']['error'],
    ); 
    
    // Upload Photo at 210 x ? GIF
    $photo_input = array(
        'title'                => 'photo',
        'user_id'            => $edit_list['user_id'],
        'method'            => !empty($_POST['photo_remote_url']) ? 'remote' : (!empty($_FILES['photo_local']['tmp_name']) ? 'local' : ''),
        'url'                    => $_POST['photo_remote_url'],
        'temp_name'     => $_FILES['photo_local']['tmp_name'],
        'temp_size'        => $_FILES['photo_local']['size'],
        'temp_error'    => $_FILES['photo_local']['error'],
    ); 
    
    if(!empty($photo_input['method']) || !empty($avatar_input['method']))
    {
        include('includes/upload_image.php');
        if(!empty($avatar_input['method'])) upload_image($avatar_input, 100, 100, $error_cause);
        if(!empty($photo_input['method']))     upload_image($photo_input, 210, 0, $error_cause);        
    }
    
    $passwd_sql = '';
    
    // Confirm New Password if necessary
    if(!empty($edit_list['new_password']) && !empty($edit_list['password_confirm']))
    {
        if($edit_list['new_password'] != $edit_list['password_confirm'])
        {
            $error = TRUE;
            $error_msg .= 'Your new password and its confirmation do not match.<BR>';
        }
        else if(strlen($edit_list['new_password']) > 32)
        {
            $error = TRUE;
            $error_msg .= 'Your new password is too long.<BR>';
        }
        else
        {
            $sql = "SELECT user_password FROM " . USERS_TABLE . " WHERE user_id = {$edit_list['user_id']}";
            if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'Could not obtain user_password information.<BR>');
            $row = $db->sql_fetchrow($result);
    
            if($row['user_password'] != md5($edit_list['cur_password']))
            {
                $error = TRUE;
                $error_msg .= 'You have provided a current password which does not match.<BR>';
            }
            
            if($error === FALSE)
            {
                $edit_list['new_password'] = md5($edit_list['new_password']);
                $passwd_sql = "user_password = '{$edit_list['new_password']}', ";
            }
        }
    }
    else if ( ( empty($new_password) && !empty($password_confirm) ) || ( !empty($new_password) && empty($password_confirm) ) )
    {
        $error = TRUE;
        $error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Password_mismatch'];
    }

    // Do a ban check on this email address
    if($edit_list['user_email'] != $SITE_USER['user_email'])
    {
        include('includes/functions_user.php');
        $result = validate_email($edit_list['user_email']);
        if($result['error'])
        {
            $edit_list['user_email'] = $SITE_USER['user_email'];
            $error = TRUE;
            $error_msg .= $result['error_msg'] . '<BR>';
        }
    }

    // Prepare Signature by stripping image tags, newlines, and breaks
    if($edit_list['user_sig'] !== '')
    {
        if (strlen($edit_list['user_sig']) > $SITE_CONF['max_sig_chars'])
        {
            $error = TRUE;
            $error_msg .= 'Your signature is too long.<BR>';
        }

        $edit_list['user_sig_bbcode_uid'] = make_bbcode_uid();
        $edit_list['user_sig'] = prepare_message($edit_list['user_sig'], 1, 1, 1, $edit_list['user_sig_bbcode_uid']);
    }

    if(!$error)
    {
        if($edit_list['user_email'] != $SITE_USER['user_email'] && $SITE_CONF['require_activation'] != USER_ACTIVATION_NONE && $SITE_USER['user_level'] != ADMIN )
        {
            $user_active     = 0;
            $user_actkey     = gen_rand_string(true);
            $key_len             = 54 - ( strlen($server_url) );
            $key_len             = ( $key_len > 6 ) ? $key_len : 6;
            $user_actkey     = substr($user_actkey, 0, $key_len);

            if($SITE_USER['session_logged_in'])
            {
                session_end($SITE_USER['session_id'], $SITE_USER['user_id']);
            }
        }
        else
        {
            $user_active     = 1;
            $user_actkey     = '';
        }

        // Update SQL Table
        $sql = "
            UPDATE " . USERS_TABLE . " SET {$passwd_sql} 
                user_email = '{$edit_list['user_email']}', user_timezone = {$edit_list['user_timezone']}, user_viewemail = {$edit_list['user_viewemail']},
                user_attachsig = {$edit_list['user_attachsig']}, user_allow_viewonline = {$edit_list['user_allow_viewonline']}, user_notify = {$edit_list['user_notify']},     
                user_full_name = '{$edit_list['user_full_name']}', user_nick_name = '{$edit_list['user_nick_name']}', user_interests = '{$edit_list['user_interests']}', 
                user_website_title = '{$edit_list['user_website_title']}', user_website = '{$edit_list['user_website']}', user_website_desc = '{$edit_list['user_website_desc']}',
                user_city = '{$edit_list['user_city']}', user_from = '{$edit_list['user_from']}', user_country = '{$edit_list['user_country']}', 
                user_sig = '{$edit_list['user_sig']}', user_icq = '{$edit_list['user_icq']}', user_aim = '{$edit_list['user_aim']}', user_yim = '{$edit_list['user_yim']}',
                user_msnm = '{$edit_list['user_msnm']}', user_occ = '{$edit_list['user_occ']}', pi_born = '{$edit_list['pi_born']}', pi_sex = {$edit_list['pi_sex']}, 
                pi_relationship = {$edit_list['pi_relationship']}, pi_preference = {$edit_list['pi_preference']}, pi_status = '{$edit_list['pi_status']}', 
                pi_interests = '{$edit_list['pi_interests']}', pi_about = '{$edit_list['pi_about']}', fv_music = '{$edit_list['fv_music']}', 
                fv_movies = '{$edit_list['fv_movies']}', fv_games = '{$edit_list['fv_games']}', fv_books = '{$edit_list['fv_books']}', 
                fv_artists = '{$edit_list['fv_artists']}', fv_quotes = '{$edit_list['fv_quotes']}',
                friend_level_0 = '{$edit_list['friend_level_0']}', friend_level_1 = '{$edit_list['friend_level_1']}',
                friend_level_2 = '{$edit_list['friend_level_2']}', friend_level_3 = '{$edit_list['friend_level_3']}'
            WHERE user_id = {$edit_list['user_id']}
        ";

        if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, $sql . 'Could not Update User Tables.<BR>');
        
        $message = "
            <META HTTP-EQUIV='refresh' CONTENT='5;url=http://{$SITE_USER['username']}.{$SITE_DOMAIN}.com/'>
            Your profile has been successfully updated.<BR>
            <A HREF='http://{$SITE_USER['username']}.{$SITE_DOMAIN}.com/'>Return to your main profile.</A><BR>
        ";
            
        message_die(GENERAL_MESSAGE, $message);
    }
} // End of submit


if($error)
{
    $edit_list['user_id'] = $SITE_USER['user_id'];
    $edit_list['username'] = htmlspecialchars($SITE_USER['username']);
    
    $edit_list['cur_password'] = '';
    $edit_list['new_password'] = '';
    $edit_list['password_confirm'] = '';
    $edit_list['user_email'] = stripslashes($edit_list['user_email']);
    
    $edit_list['user_timezone'] = stripslashes($edit_list['user_timezone']);
    
    $edit_list['user_viewemail'] = stripslashes($edit_list['user_viewemail']);
    $edit_list['user_attachsig'] = stripslashes($edit_list['user_attachsig']);
    $edit_list['user_allow_viewonline'] = stripslashes($edit_list['user_allow_viewonline']);
    $edit_list['user_notify'] = stripslashes($edit_list['user_notify']);
    
    $edit_list['user_full_name'] = stripslashes($edit_list['user_full_name']);
    $edit_list['user_nick_name'] = stripslashes($edit_list['user_nick_name']);
    $edit_list['user_interests'] = stripslashes($edit_list['user_interests']);
    $edit_list['user_website_title'] = stripslashes($edit_list['user_website_title']);
    $edit_list['user_website'] = stripslashes($edit_list['user_website']);
    $edit_list['user_website_desc'] = stripslashes($edit_list['user_website_desc']);
    $edit_list['user_city'] = stripslashes($edit_list['user_city']);
    $edit_list['user_from'] = stripslashes($edit_list['user_from']);
    $edit_list['user_country'] = stripslashes($edit_list['user_country']);
    $edit_list['user_sig'] = stripslashes($edit_list['user_sig']);
    
    if(isset($edit_list['user_sig_bbcode_uid']) && !empty($edit_list['user_sig_bbcode_uid']))
    {
        $edit_list['user_sig'] = preg_replace("/:(([a-z0-9]+:)?){$edit_list['user_sig_bbcode_uid']}\]/si", ']', $edit_list['user_sig']);
    }
    
    $edit_list['user_icq'] = stripslashes($edit_list['user_icq']);
    $edit_list['user_aim'] = htmlspecialchars(str_replace('+', ' ', stripslashes($edit_list['user_aim'])));
    $edit_list['user_yim'] = htmlspecialchars(stripslashes($edit_list['user_yim']));
    $edit_list['user_msnm'] = htmlspecialchars(stripslashes($edit_list['user_msnm']));
    $edit_list['user_occ'] = htmlspecialchars(stripslashes($edit_list['user_occ']));

    $edit_list['pi_born'] = stripslashes($edit_list['pi_born']);
    $edit_list['pi_sex'] = stripslashes($edit_list['pi_sex']);
    $edit_list['pi_relationship'] = stripslashes($edit_list['pi_relationship']);
    $edit_list['pi_preference'] = stripslashes($edit_list['pi_preference']);
    $edit_list['pi_status'] = stripslashes($edit_list['pi_status']);
    $edit_list['pi_interests'] = stripslashes($edit_list['pi_interests']);
    $edit_list['pi_about'] = stripslashes($edit_list['pi_about']);
        
    $edit_list['fv_music'] = htmlspecialchars(stripslashes($edit_list['fv_music']));
    $edit_list['fv_movies'] = htmlspecialchars(stripslashes($edit_list['fv_movies']));
    $edit_list['fv_games'] = htmlspecialchars(stripslashes($edit_list['fv_games']));
    $edit_list['fv_books'] = htmlspecialchars(stripslashes($edit_list['fv_books']));
    $edit_list['fv_artists'] = htmlspecialchars(stripslashes($edit_list['fv_artists']));
    $edit_list['fv_quotes'] = htmlspecialchars(stripslashes($edit_list['fv_quotes']));
    
    $edit_list['friend_level_0'] = htmlspecialchars(stripslashes($edit_list['friend_level_0']));
    $edit_list['friend_level_1'] = htmlspecialchars(stripslashes($edit_list['friend_level_1']));    
    $edit_list['friend_level_2'] = htmlspecialchars(stripslashes($edit_list['friend_level_2']));    
    $edit_list['friend_level_3'] = htmlspecialchars(stripslashes($edit_list['friend_level_3']));                    
}
else if(!isset($_POST['submit']))
{
    $edit_list['user_id'] = $SITE_USER['user_id'];
    $edit_list['username'] = htmlspecialchars($SITE_USER['username']);
    
    $edit_list['cur_password'] = '';
    $edit_list['new_password'] = '';
    $edit_list['password_confirm'] = '';
    $edit_list['user_email'] = $SITE_USER['user_email'];
    
    $edit_list['user_timezone'] = $SITE_USER['user_timezone'];
    
    $edit_list['user_viewemail'] = $SITE_USER['user_viewemail'];
    $edit_list['user_attachsig'] = $SITE_USER['user_attachsig'];
    $edit_list['user_allow_viewonline'] = $SITE_USER['user_allow_viewonline'];
    $edit_list['user_notify'] = $SITE_USER['user_notify'];
    
    $edit_list['user_full_name'] = htmlspecialchars($SITE_USER['user_full_name']);
    $edit_list['user_nick_name'] = htmlspecialchars($SITE_USER['user_nick_name']);
    
    if(empty($edit_list['user_nick_name']))
    {
        $edit_list['user_nick_name'] = htmlspecialchars($SITE_USER['username']);
    }
    
    $edit_list['user_interests'] = htmlspecialchars($SITE_USER['user_interests']);
    $edit_list['user_website_title'] = htmlspecialchars($SITE_USER['user_website_title']);
    $edit_list['user_website'] = htmlspecialchars($SITE_USER['user_website']);
    $edit_list['user_website_desc'] = htmlspecialchars($SITE_USER['user_website_desc']);
    $edit_list['user_city'] = htmlspecialchars($SITE_USER['user_city']);
    $edit_list['user_from'] = htmlspecialchars($SITE_USER['user_from']);
    $edit_list['user_country'] = htmlspecialchars($SITE_USER['user_country']);
    $edit_list['user_sig'] = $SITE_USER['user_sig'];
    $edit_list['user_sig_bbcode_uid'] = $SITE_USER['user_sig_bbcode_uid'];
    
    if(isset($edit_list['user_sig_bbcode_uid']) && !empty($edit_list['user_sig_bbcode_uid']))
    {
        $edit_list['user_sig'] = preg_replace("/:(([a-z0-9]+:)?){$edit_list['user_sig_bbcode_uid']}\]/si", ']', $edit_list['user_sig']);
    }    

    $edit_list['user_icq'] = $SITE_USER['user_icq'];
    $edit_list['user_aim'] = htmlspecialchars(str_replace('+', ' ', $SITE_USER['user_aim']));
    $edit_list['user_yim'] = htmlspecialchars($SITE_USER['user_yim']);
    $edit_list['user_msnm'] = htmlspecialchars($SITE_USER['user_msnm']);
    $edit_list['user_occ'] = htmlspecialchars($SITE_USER['user_occ']);

    $edit_list['pi_born'] = $SITE_USER['pi_born'];
    $edit_list['pi_sex'] = $SITE_USER['pi_sex'];
    $edit_list['pi_relationship'] = $SITE_USER['pi_relationship'];
    $edit_list['pi_preference'] = $SITE_USER['pi_preference'];
    $edit_list['pi_status'] = $SITE_USER['pi_status'];
    $edit_list['pi_interests'] = $SITE_USER['pi_interests'];
    $edit_list['pi_about'] = $SITE_USER['pi_about'];
        
    $edit_list['fv_music'] = htmlspecialchars($SITE_USER['fv_music']);
    $edit_list['fv_movies'] = htmlspecialchars($SITE_USER['fv_movies']);
    $edit_list['fv_games'] = htmlspecialchars($SITE_USER['fv_games']);
    $edit_list['fv_books'] = htmlspecialchars($SITE_USER['fv_books']);
    $edit_list['fv_artists'] = htmlspecialchars($SITE_USER['fv_artists']);
    $edit_list['fv_quotes'] = htmlspecialchars($SITE_USER['fv_quotes']);
    
    $edit_list['date_day'] = !empty($SITE_USER['pi_born']) ? substr($SITE_USER['pi_born'], 6, 2) : date('d');
    $edit_list['date_month'] = !empty($SITE_USER['pi_born']) ? substr($SITE_USER['pi_born'], 4, 2) : date('m');
    $edit_list['date_year'] = !empty($SITE_USER['pi_born']) ? substr($SITE_USER['pi_born'], 0, 4) : date('Y');
    
    $edit_list['friend_level_0'] = !empty($SITE_USER['friend_level_0']) ? htmlspecialchars($SITE_USER['friend_level_0']) : 'Acquaintances';
    $edit_list['friend_level_1'] = !empty($SITE_USER['friend_level_1']) ? htmlspecialchars($SITE_USER['friend_level_1']) : 'Friends';
    $edit_list['friend_level_2'] = !empty($SITE_USER['friend_level_2']) ? htmlspecialchars($SITE_USER['friend_level_2']) : 'Good Friends';
    $edit_list['friend_level_3'] = !empty($SITE_USER['friend_level_3']) ? htmlspecialchars($SITE_USER['friend_level_3']) : 'Best Friends';
}

foreach($edit_list AS $key => $value)
{
    $key = strtoupper($key);
    $template->assign_vars(array("{$key}" => $value));
}

$day_options                 = '';
$month_options             = '';
$year_options             = '';
$date_day_prefix        = array('st', 'nd', 'rd');
$date_month_prefix     = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

for ($i = 1; $i <= 31; $i++) 
{
    $date_prefix_i         = ($i - 1) % 10;
    $date_string             = ($date_prefix_i < 3 && ($i < 11 || $i > 13)) ? $i . $date_day_prefix[$date_prefix_i] : $i . 'th';
    $date_selected         = ($i == intval($edit_list['date_day'])) ? 'SELECTED' : '';
    $day_options           .= "<OPTION CLASS='option' VALUE='" . (($i < 10) ? '0' . $i : $i) . "' {$date_selected}>{$date_string}</OPTION>";
}

for ($i = 1; $i <= 12; $i++) 
{
    $date_selected         = ($i == intval($edit_list['date_month'])) ? 'SELECTED' : '';
    $month_options      .= "<OPTION CLASS='option' VALUE='" . (($i < 10) ? '0' . $i : $i) . "' {$date_selected}>{$date_month_prefix[$i - 1]}</OPTION>";
}

for ($i = date('Y'); $i >= intval(date('Y')) - 100; $i--) 
{
    $date_selected        = ($i == intval($edit_list['date_year'])) ? 'SELECTED' : '';
    $year_options       .= "<OPTION CLASS='option' VALUE='{$i}' {$date_selected}>{$i}</OPTION>";
}
    
$template->assign_vars(array(
    'USER_VIEWEMAIL_YES'                => $edit_list['user_viewemail'] == 1                 ? 'CHECKED' : '',
    'USER_VIEWEMAIL_NO'                    => $edit_list['user_viewemail'] == 0                 ? 'CHECKED' : '',
    'USER_ATTACHSIG_YES'                => $edit_list['user_attachsig'] == 1                 ? 'CHECKED' : '',
    'USER_ATTACHSIG_NO'                    => $edit_list['user_attachsig'] == 0                 ? 'CHECKED' : '',
    'USER_ALLOW_VIEWONLINE_YES'    => $edit_list['user_allow_viewonline'] == 1 ? 'CHECKED' : '',
    'USER_ALLOW_VIEWONLINE_NO'    => $edit_list['user_allow_viewonline'] == 0 ? 'CHECKED' : '',
    'USER_NOTIFY_YES'                        => $edit_list['user_notify'] == 1                     ? 'CHECKED' : '',
    'USER_NOTIFY_NO'                        => $edit_list['user_notify'] == 0                     ? 'CHECKED' : '',
    'PI_SEX_MALE'                                => $edit_list['pi_sex'] == 2                                 ? 'CHECKED' : '',
    'PI_SEX_FEMALE'                            => $edit_list['pi_sex'] == 1                                 ? 'CHECKED' : '',
    'PI_SEX_NONE'                                => $edit_list['pi_sex'] == 0                                 ? 'CHECKED' : '',
    'DATE_DAY_OPTIONS'                    => $day_options,
    'DATE_MONTH_OPTIONS'                => $month_options,
    'DATE_YEAR_OPTIONS'                    => $year_options,    
    'ERROR'                                            => $error == TRUE ? "<FIELDSET><LEGEND>Errors</LEGEND>{$error_msg}</FIELDSET>" : '',
));

echo $error_msg;

include('../includes/footer.php');

function make_bbcode_uid(){
    // Unique ID for this message..

    $uid = md5(mt_rand());
    $uid = substr($uid, 0, BBCODE_UID_LEN);

    return $uid;
}

function prepare_message($message, $html_on, $bbcode_on, $smile_on, $bbcode_uid = 0)
{
    global $board_config;
    global $html_entities_match, $html_entities_replace;
    global $code_entities_match, $code_entities_replace;

    //
    // Clean up the message
    //
    $message = trim($message);

    if ( $html_on )
    {
        $allowed_html_tags = split(',', $board_config['allow_html_tags']);

        $end_html = 0;
        $start_html = 1;
        $tmp_message = '';
        $message = ' ' . $message . ' ';

        while ( $start_html = strpos($message, '<', $start_html) )
        {
            $tmp_message .= preg_replace($html_entities_match, $html_entities_replace, substr($message, $end_html + 1, ( $start_html - $end_html - 1 )));

            if ( $end_html = strpos($message, '>', $start_html) )
            {
                $length = $end_html - $start_html + 1;
                $hold_string = substr($message, $start_html, $length);

                if ( ( $unclosed_open = strrpos(' ' . $hold_string, '<') ) != 1 )
                {
                    $tmp_message .= preg_replace($html_entities_match, $html_entities_replace, substr($hold_string, 0, $unclosed_open - 1));
                    $hold_string = substr($hold_string, $unclosed_open - 1);
                }

                $tagallowed = false;
                for($i = 0; $i < sizeof($allowed_html_tags); $i++)
                {
                    $match_tag = trim($allowed_html_tags[$i]);
                    if ( preg_match('/^<\/?' . $match_tag . '(?!(\s*)style(\s*)\\=)/i', $hold_string) )
                    {
                        $tagallowed = true;
                    }
                }

                $tmp_message .= ( $length && !$tagallowed ) ? preg_replace($html_entities_match, $html_entities_replace, $hold_string) : $hold_string;

                $start_html += $length;
            }
            else
            {
                $tmp_message .= preg_replace($html_entities_match, $html_entities_replace, substr($message, $start_html, strlen($message)));

                $start_html = strlen($message);
                $end_html = $start_html;
            }
        }

        if ( $end_html != strlen($message) && $tmp_message != '' )
        {
            $tmp_message .= preg_replace($html_entities_match, $html_entities_replace, substr($message, $end_html + 1));
        }

        $message = ( $tmp_message != '' ) ? trim($tmp_message) : trim($message);
    }
    else
    {
        $message = preg_replace($html_entities_match, $html_entities_replace, $message);
    }

    if( $bbcode_on && $bbcode_uid != '' )
    {
        $message = bbencode_first_pass($message, $bbcode_uid);
    }

    return $message;
}

?>