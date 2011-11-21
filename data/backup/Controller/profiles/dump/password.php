<?

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * //
// FILE: safehouse/password.php   
// CREATOR: Kevin Nuut 02/02/05                                                    
// OVERVIEW: Allows user to retrieve password.                                        
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * //
define('TXMAFIA', true);
include('includes/common.php');

// Page specific functions
function gen_rand_string($hash)
{
    $chars = array('a', 'A', 'b', 'B', 'c', 'C', 'd', 'D', 'e', 'E', 'f', 'F', 'g', 'G', 'h', 'H', 'i', 'I', 'j', 'J',  'k', 'K', 'l', 'L', 'm', 'M', 'n', 'N', 'o', 'O', 'p', 'P', 'q', 'Q', 'r', 'R', 's', 'S', 't', 'T',  'u', 'U', 'v', 'V', 'w', 'W', 'x', 'X', 'y', 'Y', 'z', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
    
    $max_chars = 25;
    $rand_str = '';
    for($i = 0; $i < 8; $i++)
    {
        $rand_str = ($i == 0) ? $chars[rand(0, $max_chars)] : $rand_str . $chars[rand(0, $max_chars)];
    }

    return ($hash) ? md5($rand_str) : $rand_str;
}

// Set page ID for session management
$userdata = session_pagestart($user_ip, PAGE_PROFILE);
init_userprefs($userdata);

// Default Email Variables
$script_name = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path']));
$script_name = ($script_name != '') ? $script_name . '/profile.php' : 'profile.php';
$server_name = trim($board_config['server_name']);
$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) . '/' : '/';
$server_url = $server_protocol . $server_name . $server_port . $script_name;

// If Username and Pass are Submitted and Not Logged In
if(!$userdata['session_logged_in'])
{
    if(isset($_POST['submit']))
    {
        $username = (!empty($_POST['username'])) ? trim(strip_tags($_POST['username'])) : '';
        $email = (!empty($_POST['email'])) ? trim(strip_tags(htmlspecialchars($_POST['email']))) : '';
    
        $sql = "
            SELECT user_id, username, user_email, user_active, user_lang 
            FROM " . USERS_TABLE . " WHERE user_email = '" . str_replace("\'", "''", $email) . "' 
            AND username = '" . str_replace("\'", "''", $username) . "'";
            
        if($result = $db->sql_query($sql))
        {
            if($row = $db->sql_fetchrow($result))
            {
                if(!$row['user_active']) message_die(GENERAL_MESSAGE, "User has been Banned or Deactivated.<BR>"); 
    
                $username             = $row['username'];
                $user_id                 = $row['user_id'];
    
                $user_actkey         = gen_rand_string(true);
                $key_len                 = 54 - strlen($server_url);
                $key_len                 = ($key_len > 6) ? $key_len : 6;
                $user_actkey         = substr($user_actkey, 0, $key_len);
                $user_password     = gen_rand_string(false);
                
                $sql = 
                    "UPDATE " . USERS_TABLE . " SET user_newpasswd = '" . md5($user_password) . "', user_actkey = '$user_actkey'  
                    WHERE user_id = " . $row['user_id'];
                    
                if(!$db->sql_query($sql)) message_die(GENERAL_ERROR, "Could not Update New Password Information. (SQL)<BR>");
    
                include("{$TXMDIRS['root']}includes/email.php");
                $emailer = new emailer($board_config['smtp_delivery']);
    
                $email_headers = "From: TxMafia.COM <support@txmafia.com>\nReply-to: TxMafia.COM <support@txmafia.com>\nReturn-Path: TxMafia.COM <support@txmafia.com>\n";
    
                $emailer->use_template('user_activate_passwd', $row['user_lang']);
                $emailer->email_address($row['user_email']);
                $emailer->set_subject();
                $emailer->extra_headers($email_headers);
    
                $emailer->assign_vars(array(
                    'SITENAME'         => $board_config['sitename'], 
                    'USERNAME'         => $username,
                    'PASSWORD'         => $user_password,
                    'EMAIL_SIG'     => str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']), 
                    'U_ACTIVATE'     => $server_url . '?mode=activate&' . POST_USERS_URL . '=' . $user_id . '&act_key=' . $user_actkey)
                );
                
                $emailer->send();
                $emailer->reset();
    
                $template->assign_vars(array(
                    'META' => "<META HTTP-EQUIV='refresh' CONTENT='3;url={$TXMDIRS['index']}'>",
                ));
        
                message_die(GENERAL_MESSAGE, "Password has been Updated and Emailed to the Account Specified.<BR>");
            }
            else
            {
                message_die(GENERAL_MESSAGE, "TxMafia has no User with that Email Address.<BR><BR>
                    Click <A HREF='{$TXMDIRS['safehouse']}password.php'>Here</A> to try again.");
            }
        }
        else
        {
            message_die(GENERAL_ERROR, "Could not Obtain User Information for Password Retrieval. (SQL)<BR>");
        }
    }
    else
    {
        $username = '';
        $email = '';
    }
    
    // Output Basic Page Request
    $template->set_filenames(array('body' => 'password.tpl'));
    
    $template->assign_vars(array(
        'USERNAME'                     => $username,
        'EMAIL'                         => $email,
        'L_SEND_PASSWORD'     => $lang['Send_password'], 
        'L_ITEMS_REQUIRED'     => $lang['Items_required'],
        'L_EMAIL_ADDRESS'     => $lang['Email_address'],
        'L_SUBMIT'                     => $lang['Submit'],
        'L_RESET'                     => $lang['Reset'],
        'S_PROFILE_ACTION'     => "{$TXMDIRS['safehouse']}password.php",
    ));
    
    $page_title = ':: Retrieve Password';
    include("../includes/header.php");    
    $template->pparse('body');
    include("../includes/footer.php");    
}
else
{
    $redirect = "{$TXMDIRS['safehouse']}password.php";
    message_die(GENERAL_MESSAGE, "You Appear to Already be Logged In.<BR><BR>
        <A HREF='{$TXMDIRS['safehouse']}die.php?redirect={$redirect}'>Die</A> to Log Off and Start Over.<BR>
        Or Visit Your <A HREF='http://{$userdata['username']}.txmafia.com/'>Safehouse </A> to View and Edit Profile.");
}

?>