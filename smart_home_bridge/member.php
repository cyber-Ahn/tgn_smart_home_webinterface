<html>
    <head>
        <link rel="stylesheet" href="css/font/source-sans-pro-v21-latin-regular.woff2" />
        <link rel="stylesheet" href="css/style.css">
        <title>TGN by cyber Ahn</title>
    </head>
</html>
<?php
include ("..data/lib.php");
$user_key = $_GET["one"];
$change_id = $_GET["id"];

if($change_id != "")
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
     $change_name = "";
     $change_st = "Off";
     for($i=0; $i < ($len-1); $i++)
     {
         $cach = $list_cach[$i];
         $cach_get = explode("|", $cach);
         if($cach_get[0] == $user_key && $cach_get[1] == $change_id)
         {
            $pos = $i;
            $change_name = $cach_get[3];
            if($cach_get[2]=="Off")
            {
                $change_st = "On";
            }
         }
     }
     if($pos != 0)
     {
         $resultat = array_splice($list_cach, $pos, 1,["$user_key|$change_id|$change_st|$change_name"]);
     }
     $myfile = fopen("database/moduls.db", "w") or die("Unable to open file!");
     $len = count($list_cach);
     for($i=0; $i < ($len-1); $i++)
     {
         $wrd = $list_cach[$i];
         fwrite($myfile, "$wrd\n");
     }
     fclose($myfile);
     $change_id = "";
}
if($user_key != "")
{
    $list_cach=array();
    $fn = fopen("database/user.db","r");
    while(! feof($fn)) 
    {
        $result = rtrim(fgets($fn));
        array_push($list_cach,"$result");
    }
    fclose($fn);
    $len = count($list_cach);
    $user = "";
    $mail = "";
    for($i=0; $i < ($len-1); $i++)
    {
        $cach = $list_cach[$i];
        $cach_get = explode("|", $cach);
        if( $cach_get[3] == $user_key)
        {
            $user = base64_decode($cach_get[0]);
            $mail = base64_decode($cach_get[2]);
            echo "<div align='center'>$user &nbsp&nbsp&nbsp&nbsp $mail &nbsp&nbsp&nbsp&nbsp&nbsp $user_key<br>";
        }
    }
    echo"<br>
    <form action='logout.php' method='post'>
        <input type='submit' value='Logout'>
    </form>
    ";
    $list_cach=array();
    $list_my = array();
    $fn = fopen("database/moduls.db","r");
    while(! feof($fn)) 
    {
        $result = rtrim(fgets($fn));
        array_push($list_cach,"$result");
    }
    fclose($fn);
    $len = count($list_cach);
    for($i=0; $i < ($len-1); $i++)
    {
        $cach = $list_cach[$i];
        $cach_get = explode("|", $cach);
        if($cach_get[0] == $user_key)
        {
            array_push($list_my,"$cach");
        }
    }
    $len = count($list_my);
    for($i=0; $i < $len; $i++)
    {
        $my_dat = $list_my[$i];
        $my_ex = explode("|",$my_dat);
        $my_id = $my_ex[1];
        $my_st = $my_ex[2];
        $my_name = $my_ex[3];
        $img = "data/images/off.png";
        if($my_st == "On")
        {
            $img = "data/images/on.png";
        }
        echo "
        <a href='member.php?one=$user_key&id=$my_id'>
            <div id='main'>
                <img src='data/images/switch.png'>
                <span style='margin-left:10%'>ID: $my_id<span>
                <span style='margin-left:10%'>Name: $my_name<span>
                <img style='margin-left:10%'src='$img'>
                <a href='delete.php?user=$user_key&switch=$my_id'><img id='dn' style='margin-left:10%' src='data/images/delete.png' alt='alternativer_text' /></a>
            </div>
        </a>";
    }
}
if($user_key == "")
{
    echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=main.php'><br>";
}

echo"
<br> <br>
<form action='generate.php' method='post'>
    <input type='text' size='24' maxlength='50'name='name_mod'>
    <input type='hidden' name='one' value='$user_key' />
    <input type='submit' value='New Modul'>
</form>
<br> <br>";
echo "<META HTTP-EQUIV=REFRESH CONTENT='10; URL=member.php'><br>";
?>