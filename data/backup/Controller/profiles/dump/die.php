<?

define('ROOT', true);
include('../includes/header.php');

if($SITE_USER['session_logged_in']) 
{
    session_end($SITE_USER['session_id'], $SITE_USER['user_id']);
}

$header = (@preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE'))) ? 'Refresh: 0; URL=' : 'Location: ';
header($header . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'http://www.txmafia.com/'));
exit;
    
?>