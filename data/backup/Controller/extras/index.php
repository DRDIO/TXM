<?php define("ROOT", TRUE);

define("PAGE_COMMON", TRUE);
include_once("../includes/header.php");

// Grab Top 150 Respected Members
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
$sql = "
    SELECT 
        link_name,
        nick_name,
        respect
    FROM
        txm_users
    ORDER BY
        respect DESC
    LIMIT
        0, 100
";

$result = $db->sql_query($sql);
if($result === FALSE)
{
    message_die(GENERAL_ERROR, "We were unable to retrieve respect rankings.", $sql);
}    
else
{
    $row = $db->sql_fetchrow($result);
    $max = $row["respect"];
    $count = 0;
    
    do
    {
        $row["percent"] = sprintf("%01.2f", 100 * $row["respect"] / $max);    
        $row["color"] = $count++ % 2 === 0 ? "grn-alt" : "";
        $row["rank"] = $count;
        $row["width"] = floor(2.5 * $row["percent"]);
        
        array_map("html_entities", $row);
        $template->assign_block_vars("respect", $row);
    } 
    while($row = $db->sql_fetchrow($result));    
}

define("PAGE_TITLE", "Member Rankings");
include_once("../includes/footer.php");

?>