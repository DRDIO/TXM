<?

define('ROOT', true);
include('../includes/header.php');

$error                 = "";
$pass_sql         = "";
$username_sql = "";

// Let's make sure the user isn't logged in while registering,
// and ensure that they were trying to register a second time
if($SITE_USER['session_logged_in'])
{
    $redirect = "register";
    message_die(GENERAL_MESSAGE, "You Appear to Already be Logged In.<BR><BR>
        <A HREF='http://die.txmafia.com?{$redirect}'>Die</A> to Log Off and Start Over.<BR>
        Or Visit Your <A HREF='http://{$SITE_USER['username']}.txmafia.com/'>Profile </A> to View and Edit.");
}

$reg_list = array(
    'member'    => isset($_POST['reg_member'])     ? str_replace('&nbsp;', '', trim(strip_tags($_POST['reg_member']))) : '',
    'pass'         => isset($_POST['reg_pass'])         ? trim($_POST['reg_pass'])                                                                                     : '',
    'email'        => isset($_POST['reg_email'])     ? htmlspecialchars(trim(strip_tags($_POST['reg_email'])))                     : '',
    'terms'        => isset($_POST['reg_terms'])     ? TRUE                                                                                                                             : FALSE,
    
    'day'             => isset($_POST['reg_day'])         ? $_POST['reg_day']                                                                                 : 0,
    'month'     => isset($_POST['reg_month'])     ? $_POST['reg_month']                                                                             : 0,
    'year'         => isset($_POST['reg_year'])         ? $_POST['reg_year']                                                                                : 0,

    'cmail'        => isset($_POST['reg_cmail'])     ? TRUE                                                                                                                             : FALSE,
);

// Check and initialize some variables if needed
if(isset($_POST['submit']))
{
    // Used to validate username and email
    include("profiles/includes/functions_user.php");
    
    if(empty($reg_list['member']))         $error .= "You must provide a username.<BR>";
    if(empty($reg_list['pass']))             $error .= "You must provide a password.<BR>";    
    if(empty($reg_list['email']))         $error .= "You must provide a valid email address.<BR>";
    if(empty($reg_list['terms']))       $error .= "You must agree to the terms of TXMDOTCOM.<BR>";

    if(checkdate($reg_list['month'], $reg_list['day'], $reg_list['year']))
    {
        echo intval(date('Y') - 13 . date('m') . date('d')) . '<BR>';
        echo intval($reg_list['year'] . $reg_list['month'] . $reg_list['day']) . '<BR>';
        
        if(intval(date('Y') - 13 . date('m') . date('d')) < intval($reg_list['year'] . $reg_list['month'] . $reg_list['day']))
        {
            $error .= "You must be over 13 to join.<BR>";
        }
    }
    else
    {
        $error .= "You must provide a valid birth date.<BR>";
    }
    
    if($reg_list['pass'] > 16)
    {
        $error .= "Password must be under 16 characters.<BR>";
        $pass = "";
    }

    // Do a ban check on this email address
    $result = validate_email($reg_list['email']);
    if($result['error']) $error .= "{$result['error_msg']}<BR>";
        
    $result = validate_username($reg_list['member']);
    if($result['error'])
    {
        $error .= "{$result['error_msg']}<BR>";
    }
    
    if(empty($error))
    {
        $sql = "SELECT MAX(user_id) AS total FROM " . USERS_TABLE;
        if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, "Could not obtain next user_id information (SQL).");
        if(!($row = $db->sql_fetchrow($result))) message_die(GENERAL_ERROR, "Could not obtain next user_id information (SQL).");

        $user_id = $row['total'] + 1;

        $sql_time         = time();
        $sql_username = str_replace("\'", "''", $reg_list['member']);    
        $sql_ip             = str_replace("\'", "''", $user_ip);
        $sql_pass         = str_replace("\'", "''", md5($reg_list['pass']));
        $sql_email         = str_replace("\'", "''", $reg_list['email']);
        
        $sql = "
            INSERT INTO " . USERS_TABLE . "    (user_id, username, user_regdate, user_regip, user_password, user_email, user_level, user_active, user_actkey)
            VALUES ($user_id, '{$sql_username}', {$sql_time}, '{$sql_ip}', '{$sql_pass}', '{$sql_email}', 0,
        ";
        
        $key_len             = 54 - (strlen($server_url));
        $key_len             = ( $key_len > 6 ) ? $key_len : 6;
        $user_actkey     = substr(gen_rand_string(true), 0, $key_len);
        $sql                  .= "0, '" . str_replace("\'", "''", $user_actkey) . "')";

        if(!($result = $db->sql_query($sql, BEGIN_TRANSACTION))) message_die(GENERAL_ERROR, "Could not insert data into users table (SQL). {$sql}");
        
        $sql = "INSERT INTO " . GROUPS_TABLE . " (group_name, group_description, group_single_user, group_moderator) VALUES ('', 'Personal User', 1, 0)";
        if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, "Could not insert data into groups table (SQL).");
        
        $group_id = $db->sql_nextid();

        $sql = "INSERT INTO " . USER_GROUP_TABLE . " (user_id, group_id, user_pending) VALUES ($user_id, $group_id, 0)";
        if(!($result = $db->sql_query($sql, END_TRANSACTION))) message_die(GENERAL_ERROR, "Could not insert data into user group table (SQL).");

        include('includes/email.php');
        $emailer = new emailer($board_config['smtp_delivery']);

        $email_headers = "From: " . $board_config['board_email'] . "\nReturn-Path: " . $board_config['board_email'] . "\n";

        $emailer->use_template('user_welcome', stripslashes($user_lang));
        $emailer->email_address($email);
        $emailer->set_subject();
        $emailer->extra_headers($email_headers);

        $emailer->assign_vars(array(
            'SITENAME'         => 'TxMafia.COM',
            'WELCOME_MSG' => sprintf($lang['Welcome_subject'], $board_config['sitename']),
            'USERNAME'         => $reg_list['member'],
            'PASSWORD'         => $reg_list['pass'],
            'EMAIL_SIG'     => str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']),
            'U_ACTIVATE'     => $server_url . '?mode=activate&' . POST_USERS_URL . '=' . $user_id . '&act_key=' . $user_actkey)
        );

        $emailer->send();
        $emailer->reset();

        $message = "Your registration has been approved. Welcome to TxMafia.<BR>
            Get started by returning to <A HREF='http://www.txmafia.com/'>The Index</A>.
            If you want movies and games, visit <A HREF='http://cellblock.txmafia.com/'>The Cellblock</A>.";
    
        message_die(GENERAL_MESSAGE, $message);
    }
} // End of if(isset($_POST['submit']))

if(!empty($error))
{
    // If an error occured we need to stripslashes on returned data
    $error                                = "<B>Registration Error</B><BR>" . $error;
    $reg_list['member']     = stripslashes($reg_list['member']);
    $reg_list['pass']         = stripslashes($reg_list['pass']);    
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
    $date_selected         = ($i == $reg_list['day']) ? 'SELECTED' : '';
    $day_options           .= "<OPTION VALUE='" . (($i < 10) ? '0' . $i : $i) . "' {$date_selected}>{$date_string}</OPTION>";
}

for ($i = 1; $i <= 12; $i++) 
{
    $date_selected         = ($i == $reg_list['month']) ? 'SELECTED' : '';
    $month_options      .= "<OPTION VALUE='" . (($i < 10) ? '0' . $i : $i) . "' {$date_selected}>{$date_month_prefix[$i - 1]}</OPTION>";
}

for ($i = date('Y'); $i >= 1905; $i--) 
{
    $date_selected        = ($i == $reg_list['year']) ? 'SELECTED' : '';
    $year_options       .= "<OPTION VALUE='{$i}' {$date_selected}>{$i}</OPTION>";
}
    
$template->assign_vars(array(
    'SH_MEMBER'                    => $reg_list['member'],
    'SH_EMAIL'                    => $reg_list['email'],
    'SH_PASS'                        => $reg_list['pass'],
    'SH_DAY'                        => $day_options,
    'SH_MONTH'                    => $month_options,
    'SH_YEAR'                        => $year_options,
    'SH_TERMS_CHECKED'    => ($reg_list['terms'] == TRUE)     ? "CHECKED" : "",
    'SH_CMAIL_CHECKED'    => ($reg_list['cmail'] == TRUE)     ? "CHECKED" : "",    
    'ERROR'                             => $error,
));

define('PAGE_TITLE', "Express Register");
include('../includes/header.php');

?>
