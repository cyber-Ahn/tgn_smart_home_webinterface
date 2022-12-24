<?php
//________________________________________________________________

error_reporting(0);

//________________________________________________________________
function del_array($cach_delB,$delete)
{
$count = 0;
foreach($cach_delB as $check)
{
if($check == $delete)
{
unset($cach_delB[$count]);
}
$count++;
}
return $cach_delB;
}
//________________________________________________________________
function generate_network_id($model)
{
$first = random_string($length = 8, $characters_array = false, $mode = 0, $test_mode = false);
$secound = random_string($length = 6, $characters_array = false, $mode = 0, $test_mode = false);
$third = random_string($length = 15, $characters_array = false, $mode = 0, $test_mode = false);
$back = "$first-$secound-$third";
return $back;
}
//________________________________________________________________
function gen_zahlen($min, $max, $anz)
{
$werte = range($min, $max);
mt_srand ((double)microtime()*1000000);
for($x = 0; $x < $anz; $x++)
{
$i = mt_rand(1, count($werte))-1;
$erg[] = $werte[$i];
array_splice($werte, $i, 1);
}
return $erg;
}
//________________________________________________________________
function random_string($length, $characters_array, $mode, $test_mode)
{
    if (!$characters_array)
    {
        $characters_array = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L',
            'M', 'N', 'P', 'o', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y','Z',
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l',
            'm', 'n', 'p', 'o', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y','z',);
    }
    if (!isset($mode))
    {
        $mode = 5;
    }
    $num = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    $random = '';
    for ($i = 0; $i < $length; $i++)
    {
        if (rand(1, 10) > $mode)
        {
            $random .= $characters_array[rand(0, count($characters_array) - 1)];
        }
        else
        {
            $random .= $num[rand(0, 9)];
        }
    }
    if ($test_mode)
    {
        //----- Random Test Mode -----
        $test_array = str_split($random);
        $i = 0;
        $x = 0;
 
        foreach ($test_array as $key => $value)
        {
            if (is_numeric($value))
            {
                $i++;
            }
            else
            {
                $x++;
            }
        }
        return $random.' - '.count($test_array).' Zeichen, '.$i.' Zahle(n), '.$x.' Buchstabe(n)';
    }
    else
    {
        return $random;
    }
}
//________________________________________________________________
function unixtotime($unix)
{
$datum = date("d.m.Y",$unix);
$uhrzeit = date("H:i:s",$unix);
$out = $datum."-".$uhrzeit;
return $out;
}
//________________________________________________________________
function getdiffdate($is,$old)
{
$exp_is_a = explode("-",$is);
$exp_is_date = explode(".",$exp_is_a[0]);
$exp_is_time = explode(":",$exp_is_a[1]);
$exp_old_a = explode("-",$old);
$exp_old_date = explode(".",$exp_old_a[0]);
$exp_old_time = explode(":",$exp_old_a[1]);
$time_is = mktime($exp_is_time[0],$exp_is_time[1],0,$exp_is_date[1],$exp_is_date[0],$exp_is_date[2]);
$time_old = mktime($exp_old_time[0],$exp_old_time[1],0,$exp_old_date[1],$exp_old_date[0],$exp_old_date[2]);
$diff=$time_old-$time_is;
$x=$diff/86400;
$weeks = 0;
$days = 0;
$w = "week";
$d = "day";
$h = "hour";
$hour = 0;
$min = 0;
if($x > 6.9)
{
$weeks = $x/7;
$expw = explode(".",$weeks);
$weeks = $expw[0];
$cacha = $weeks*7;
$cachb = $x-$cacha;
$expd = explode(".",$cachb);
$days = $expd[0];
$cachc = $cacha + $days;
$cachd = $x * 24;
$cache = $cachc *24;
$cachf = $cachd -$cache;
$exph = explode(".",$cachf);
$hour = $exph[0];
$cachh = $cachf-$hour;
$cachi = $cachh * 60;
$expmi = explode(".",$cachi);
$min = $expmi[0];
}
elseif($x<7)
{
$cachz=$diff/86400;
$expd = explode(".",$cachz);
$days = $expd[0];
$cachd = $x * 24;
$cache = $days *24;
$cachf = $cachd-$cache;
$exph = explode(".",$cachf);
$hour = $exph[0];
$cachh = $cachf-$hour;
$cachi = $cachh * 60;
$expmi = explode(".",$cachi);
$min = $expmi[0];
}
$m = "min";
$months = 0;
if($weeks > 3)
{
$months = $weeks/4;
$expf = explode(".",$months);
$months = $expf[0];
$cachf = $months*4;
$weeks = $weeks-$cachf;
}
$mm = "month";
if($days > 1)
{
$d = $d."s";
}
if($weeks > 1)
{
$w = $w."s";
}
if($hour > 1)
{
$h = $h."s";
}
if($months > 1)
{
$mm = $mm."s";
}
$out_new = $months.$mm." ".$weeks.$w." ".$days.$d." ".$hour.$h." ".$min.$m;
return $out_new;
}
//__________________________________________________________
function getnewdata($adw,$olddate)
{
$expx = explode("-",$olddate);
$new_datum = date("d.m.Y", strtotime("$expx[0] + $adw week"));
$timest = "$new_datum-$expx[1]";
return $timest;
}
//__________________________________________________________
function getPage($web)
{
$html = "";
$ch = curl_init($web);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.12) Gecko/20070508 Firefox/1.5.0.12");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
$html = curl_exec($ch);
if(curl_errno($ch))
{
$html = "";
}
curl_close ($ch);
return $html;
}
//________________________________________________________________
function getBetween($content,$start,$end)
{
$a1 = strpos($content,$start);
$content = substr($content,$a1 + strlen($start));
while($a2 = strrpos($content,$end))
{
$content = substr($content,0,$a2);
}
return $content;
}
//__________________________________________________________
function sendToHost($host,$method,$path,$data,$useragent=0)
{ 
$fp = fsockopen($host, 80, $errno, $errstr, 30);
if( !$fp )
{
echo"$errstr ($errno)<br />\n";
}
else
{
fputs($fp, "$method $path HTTP/1.1\r\n"); 
fputs($fp, "Host: $host\r\n"); 
fputs($fp, "Content-type: text/xml\r\n"); 
fputs($fp, "Content-length: " . strlen($data) . "\r\n"); 
if ($useragent) 
fputs($fp, "User-Agent: MSIE\r\n"); 
fputs($fp, "Connection: close\r\n\r\n"); 
fputs($fp, $data); 
fclose($fp); 
}
}
//__________________________________________________________
function send_mail_sl($regard,$data,$uuid)
{
$addressor = "creator@caworks-sl.de";
$receiver = "$uuid@lsl.secondlife.com";
$mailtext = $data;
mail($receiver, $regard, $mailtext, "From: $addressor "); 
}
//__________________________________________________________
function rand_char($chars)
{
$n = rand(0,(strlen($chars)-1)); 
return $chars[$n];
}
//__________________________________________________________
function id_filter($web)
{
if($web == "")
{
$zeichen = "0123456789abcdef"; 
for($x=0;$x<3;$x++)
{ 
$s2 .= rand_char($zeichen);
}
for($x=0;$x<3;$x++)
{ 
$s3 .= rand_char($zeichen);
}
}
else
{
$s1 = explode("-",$web);
$s2 = substr($s1[0], 0, 3);
$s3 = substr($s1[0], 3, 3);
}
$s2 = strtr($s2, "abcdef", "ABCDEF");
$s3 = strtr($s3, "abcdef", "ABCDEF");
$s2 = strtr($s2, "0123456789", "PPPPPPMMMM");
$s2 = strtr($s2, "ABCDEF", "PPPMMM");
$s3 = strtr($s3, "ABCDEF", "123456");
return $s2."-".$s3;
}
//__________________________________________________________