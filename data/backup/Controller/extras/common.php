<?

if (!defined('IN_PHPBB')) die('Hacking attempt1');

// Things to add.  Auth Types.
if(isset($extern_cell))
{
    $pbb_root = $phpbb_root_path = 'bbs/';
    $tpl_root = '../../../extras/templates/';
    $img_root = 'http://www.txmafia.com/extras/images/';
    $fla_root = 'extras/flash/';
}
else
{
    $pbb_root = $phpbb_root_path = '../bbs/';
    $tpl_root = '../../../extras/templates/';
    $img_root = '../extras/images/';
    $fla_root = '../extras/flash/';
}    


include($pbb_root . 'extension.inc');
include($pbb_root . 'common.php');

// Start session management
$userdata = session_pagestart($user_ip, PAGE_CB_INDEX);
init_userprefs($userdata);

/*LockDown Feature.
if (!$userdata['session_logged_in'] || !in_array($userdata['user_id'],$allowlist)) {
    message_die (GENERAL_MESSAGE, "CellBlock Temporarily disabled to Update Features."); }
*/

function clean_data($var) {
    return htmlspecialchars(trim(stripslashes($var)), ENT_QUOTES);
}

$template->assign_vars(array(
    'CB_NAV' => "<B><A HREF='/'>TxMafia Index</A> :: <A HREF=''>Extras</A></B>",
    'CELLBLOCK_IM' => "../extras/images",
    'ROOT_IM' => "../images",
    )
);    
?>