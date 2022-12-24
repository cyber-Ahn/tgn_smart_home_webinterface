<html>
    <head>
      <link rel="stylesheet" href="css/font/source-sans-pro-v21-latin-regular.woff2" />
      <link rel="stylesheet" href="css/style.css">
      <title>TGN by cyber Ahn</title>
    </head>
</html>
<?php
include ("data/lib.php");
$username = $_POST["username"];
$password = $_POST["passwort"];
$password2 = $_POST["passwort2"];
$mail = $_POST["mail"];
if ($username != "" && $password != "" && $password2 != "" && $mail != "" && $password == $password2)
{
    $username = base64_encode($username);
    $password = base64_encode($password);
    $mail = base64_encode($mail);
    $key = generate_network_id($username);
    $myfile = fopen("database/user.db", "a") or die("Unable to open file!");
    $txt = "$username|$password|$mail|$key\n";
    fwrite($myfile, $txt);
    fclose($myfile);
    echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=main.php'><br>";
}
else
{
    echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=register.html'><br>";
}
?>