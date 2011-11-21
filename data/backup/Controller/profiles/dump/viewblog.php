<?

define('ROOT', true);
include('../includes/header.php');
include('includes/common.php');

$topic_id = intval($_GET['vars']);

header("Location: http://{$topic_id}.forums.txmafia.com/");
exit;

include('../includes/footer.php');

?>