<?php
include ("data/lib.php");
$user_key = $_GET["user"];
$switch_id = $_GET["switch"];

if($user_key != "")
{
    $list_cach=array();
    $fn = fopen("database/moduls.db","r");
    while(! feof($fn)) 
    {
        $result = rtrim(fgets($fn));
        array_push($list_cach,"$result");
    }
    fclose($fn);
    $len = count($list_cach);
    $list_new=array();
    for($i=0; $i < ($len-1); $i++)
    {
        $cach = $list_cach[$i];
        $cach_get = explode("|", $cach);
        if($cach_get[1] != $switch_id)
        {
            array_push($list_new,"$cach");
        }
    }
    $myfile = fopen("database/moduls.db", "w") or die("Unable to open file!");
    $len = count($list_new);
    for($i=0; $i < $len; $i++)
    {
        $wrd = $list_new[$i];
        fwrite($myfile, "$wrd\n");
    }
    fclose($myfile);
    echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=main.php'><br>";
}
?>