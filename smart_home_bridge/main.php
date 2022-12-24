<?php
include ("..data/lib.php");
$username = $_POST["username"];
$passwort = $_POST["password"];
$cookie = $_COOKIE["tgnifttt"];
if($cookie != "")
{
    $cookie = base64_decode($cookie);
    $exp_cok = explode("|",$cookie);
    $username = base64_decode($exp_cok[0]);
    $passwort = base64_decode($exp_cok[1]);
}
if($username != "" && $passwort != "")
{
    $username = base64_encode($username);
    $passwort = base64_encode($passwort);
    $list_cach=array();
    $fn = fopen("database/user.db","r");
    while(! feof($fn)) 
    {
        $result = rtrim(fgets($fn));
        array_push($list_cach,"$result");
    }
    fclose($fn);
    $len = count($list_cach);
    $pos = 0;
    for($i=0; $i < ($len-1); $i++)
    {
        $cach = $list_cach[$i];
        $cach_get = explode("|", $cach);
        if($cach_get[0]==$username && $cach_get[1] == $passwort)
        {
            $time_set = time()+(3600*12);
            $datax = base64_encode("$username|$passwort");
            setcookie("tgnifttt",$datax,$time_set);
            echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=member.php?one=$cach_get[3]'><br>";
        }
    }
}
?>
<html>
    <head>
        <link rel="stylesheet" href="css/font/source-sans-pro-v21-latin-regular.woff2" />
        <link rel="stylesheet" href="css/style.css">
        <title>TGN by cyber Ahn</title>
    </head>
    <div align="center">
    <form action="main.php" method="post">
        <br><br>
        <input type="text" size="20" maxlength="40" value="Name" name="username">
        <br><br>
        <input type="password" size="20" maxlength="40" value="**********" name="password">
        <br><br>
        <input type="submit" value="Login">
        <a href=register.html>Register</a>
    </form>
    </div>
</html>