<?

define('ROOT', true);
include('../includes/header.php');

echo '<TABLE>';

$sql = "SELECT username, user_lastvisit FROM " . USERS_TABLE . " WHERE user_active <> 0 ORDER BY user_lastvisit DESC";
if (!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'Could not obtain ranks information.');
while ($value = $db->sql_fetchrow($result))
{
    if(!preg_match('/^[a-zA-Z0-9]+$/i', $value['username']))
    {
        echo '<TR><TD>' . $value['username'] . '</TD><TD>' . date('m-d-Y h:i a', $value['user_lastvisit']) . '</TD></TR>';
    }
}

echo '</TABLE>';
exit;

?>