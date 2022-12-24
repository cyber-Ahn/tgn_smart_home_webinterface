
<?php
include ("data/lib.php");

$api_key = $_GET["api_key"];
$switch_id = $_GET["switch_id"];
$status = $_GET["status"];

function check_user($key)
{
    $back = "no";
    $fn = fopen("database/user.db","r");
    while(! feof($fn))
    {
        $result = rtrim(fgets($fn));
        $cach = explode("|", $result)[3];
        if($cach==$key)
        {
            $back="yes";
        }
    }
    fclose($fn);
    return $back;
}
//------------------------change--------------------------------
if(check_user($api_key)=="yes" && $status != "read")
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
    $pos = 0;
    $status_old = "";
    $name = "";
    for($i=0; $i < ($len-1); $i++)
    {
        $cach = $list_cach[$i];
        $cach_get = explode("|", $cach);
        if($cach_get[0] == $api_key && $cach_get[1] == $switch_id)
        {
            if($cach_get[2] != $status)
            {
                $pos = $i;
                $status_old = $cach_get[2];
                $name = $cach_get[3];
            }
        }
    }
    if($pos != 0)
    {
        if($status == "toggle")
        {
            if($status_old == "Off")
            {
                $status = "On";
            }
            elseif($status_old == "On")
            {
                $status = "Off";
            }
        }
        $resultat = array_splice($list_cach, $pos, 1,["$api_key|$switch_id|$status|$name"]);
    }
    $myfile = fopen("database/moduls.db", "w") or die("Unable to open file!");
    $len = count($list_cach);
    for($i=0; $i < ($len-1); $i++)
    {
        $wrd = $list_cach[$i];
        fwrite($myfile, "$wrd\n");
    }
    fclose($myfile);

}
//------------------------read----------------------------------
if(check_user($api_key)=="yes" && $status == "read")
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
    echo "Data:<br>";
    for($i=0; $i < ($len-1); $i++)
    {
        $cach = $list_cach[$i];
        $cach_get = explode("|", $cach);
        if($cach_get[0] == $api_key)
        {
            echo "$cach<br>";
        }
    }
}
?>