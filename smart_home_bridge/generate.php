<?php
include ("data/lib.php");
$user_key = $_POST["one"];
$name = $_POST["name_mod"];
$mod_id = generate_network_id("switch");
$mod_id = explode("-", $mod_id)[1];
$status = "Off";
if($name != "")
{
    $save = "$user_key|$mod_id|$status|$name\n";
    $myfile = fopen("database/moduls.db", "a") or die("Unable to open file!");
    fwrite($myfile, $save);
    fclose($myfile);
    echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=main.php'><br>";
}
else
{
    echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=main.php'><br>";
}
?>