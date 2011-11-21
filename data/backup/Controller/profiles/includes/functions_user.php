<?

if(!defined('ROOT')) die('Hacking attempt');

// Page specific functions
function gen_rand_string($hash) {
    $chars = array('a', 'A', 'b', 'B', 'c', 'C', 'd', 'D', 'e', 'E', 'f', 'F', 'g', 'G', 'h', 'H', 'i', 'I', 'j', 'J',  'k', 'K', 'l', 'L', 'm', 'M', 'n', 'N', 'o', 'O', 'p', 'P', 'q', 'Q', 'r', 'R', 's', 'S', 't', 'T',  'u', 'U', 'v', 'V', 'w', 'W', 'x', 'X', 'y', 'Y', 'z', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
    
    $max_chars = 25;
    $rand_str = '';
    for($i = 0; $i < 8; $i++) {
        $rand_str = ( $i == 0 ) ? $chars[rand(0, $max_chars)] : $rand_str . $chars[rand(0, $max_chars)];
    }

    return ($hash) ? md5($rand_str) : $rand_str;
}

function validate_username($username)
{
    global $db, $SITE_USER;

    $username = str_replace("\'", "''", $username);
    if(!preg_match('/^[a-zA-Z0-9]+$/i', $username))
    {
        $username = preg_replace('/[\W\s\_]/i', '', $username);
        return array('error' => true, 'error_msg' => 
            "Screen name can only contain alphanumeric characters.<BR>We suggest trying a screen name like {$username}.");
    }
        
    $sql = "SELECT username FROM " . USERS_TABLE . " WHERE LOWER(username) = '" . strtolower($username) . "'";
    if ( $result = $db->sql_query($sql) )
    {
        if ( $row = $db->sql_fetchrow($result) )
        {
            if ( ( $SITE_USER['session_logged_in'] && $row['username'] != $SITE_USER['username'] ) || !$SITE_USER['session_logged_in'] )
            {
                return array('error' => true, 'error_msg' => 'Screen name is already taken.');
            }
        }
    }

    $sql = "SELECT group_name
        FROM " . GROUPS_TABLE . " 
        WHERE LOWER(group_name) = '" . strtolower($username) . "'";
    if ( $result = $db->sql_query($sql) )
    {
        if ( $row = $db->sql_fetchrow($result) )
        {
            return array('error' => true, 'error_msg' => 'Screen name is already taken.');
        }
    }

    $sql = "SELECT disallow_username
        FROM " . DISALLOW_TABLE;
    if ( $result = $db->sql_query($sql) )
    {
        while( $row = $db->sql_fetchrow($result) )
        {
            if ( preg_match("#\b(" . str_replace("\*", ".*?", preg_quote($row['disallow_username'], '#')) . ")\b#i", $username) )
            {
                return array('error' => true, 'error_msg' => 'Screen name is not allowed.');
            }
        }
    }

    $sql = "SELECT word 
        FROM  " . WORDS_TABLE;
    if ( $result = $db->sql_query($sql) )
    {
        while( $row = $db->sql_fetchrow($result) )
        {
            if ( preg_match("#\b(" . str_replace("\*", ".*?", preg_quote($row['word'], '#')) . ")\b#i", $username) )
            {
                return array('error' => true, 'error_msg' => 'Screen name is not allowed.');
            }
        }
    }

    // Don't allow " in username.
    if ( strstr($username, '"') )
    {
        return array('error' => true, 'error_msg' => 'Screen name is invalid.');
    }

    return array('error' => false, 'error_msg' => '');
}

//
// Check to see if email address is banned
// or already present in the DB
//
function validate_email($email)
{
    global $db;

    if ( $email != '' )
    {
        if ( preg_match('/^[a-z0-9\.\-_\+]+@[a-z0-9\-_]+\.([a-z0-9\-_]+\.)*?[a-z]+$/is', $email) )
        {
            $sql = "SELECT ban_email
                FROM " . BANLIST_TABLE;
            if ( $result = $db->sql_query($sql) )
            {
                while( $row = $db->sql_fetchrow($result) )
                {
                    $match_email = str_replace('*', '.*?', $row['ban_email']);
                    if ( preg_match('/^' . $match_email . '$/is', $email) )
                    {
                        return array('error' => true, 'error_msg' => 'Email is banned.');
                    }
                }
            }

            $sql = "SELECT user_email
                FROM " . USERS_TABLE . "
                WHERE user_email = '" . str_replace("\'", "''", $email) . "'";
            if ( !($result = $db->sql_query($sql)) )
            {
                message_die(GENERAL_ERROR, "Couldn't obtain user email information.", "", __LINE__, __FILE__, $sql);
            }

            if ( $row = $db->sql_fetchrow($result) )
            {
                return array('error' => true, 'error_msg' => 'Email is taken.');
            }

            return array('error' => false, 'error_msg' => '');
        }
    }

    return array('error' => true, 'error_msg' => 'Email is invalid.');
}

//
// Does supplementary validation of optional profile fields. This expects common stuff like trim() and strip_tags()
// to have already been run. Params are passed by-ref, so we can set them to the empty string if they fail.
//
function validate_optional_fields(&$icq, &$aim, &$msnm, &$yim, &$website, &$location, &$occupation, &$interests, &$sig)
{
    $check_var_length = array('aim', 'msnm', 'yim', 'location', 'occupation', 'interests', 'sig');

    for($i = 0; $i < count($check_var_length); $i++)
    {
        if ( strlen($$check_var_length[$i]) < 2 )
        {
            $$check_var_length[$i] = '';
        }
    }

    // ICQ number has to be only numbers.
    if ( !preg_match('/^[0-9]+$/', $icq) )
    {
        $icq = '';
    }
    
    // website has to start with http://, followed by something with length at least 3 that
    // contains at least one dot.
    if ( $website != "" )
    {
        if ( !preg_match('#^http:\/\/#i', $website) )
        {
            $website = 'http://' . $website;
        }

        if ( !preg_match('#^http\\:\\/\\/[a-z0-9\-]+\.([a-z0-9\-]+\.)?[a-z]+#i', $website) )
        {
            $website = '';
        }
    }

    return;
}

?>
