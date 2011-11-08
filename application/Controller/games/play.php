<?php define("ROOT", TRUE);

include_once("../includes/header.php");

$id = isset($_GET["id"]) ? $_GET["id"] : 0;

$sql = "
    SELECT
        g.id,
        g.width,
        g.height,
        g.title,
        u.link_name,
        u.nick_name
    FROM
        games AS g INNER JOIN
        txm_users AS u ON
        g.id_user = u.id
    WHERE
        g.id = " . intval($id) . "
";

$result = $db->sql_query($sql);
if($result === FALSE)
{
    message_die(GENERAL_ERROR, "We were unable to retrieve movie.", $sql);
}
else if($db->sql_numrows($result) !== 1)
{
    message_die(GENERAL_MESSAGE, "Movie does not exist or has been deleted.");
}

$row = $db->sql_fetchrow($result);
$row["title_link"] = str2link($row["title"]);

$divisor = min(1, 760 / $row["width"], 520 / $row["height"]);
$postlist["width"] = round($postlist["width"] * $divisor);
$postlist["height"] = round($postlist["height"] * $divisor);

$row["widthhalf"] = $row["width"];
$row["heighthalf"] = $row["height"];
$template->assign_vars($row);

define("PAGE_TITLE", "Play Game '" . htmlentities($row["title"]) . "' By " . htmlentities($row["nick_name"]));
include_once("../includes/footer.php");

?>