<html><head><title>Syrnia the free online rpg game</title></head><body>
<a href=http://www.syrnia.com>Click here to go to Syrnia.com - The free online rpg</a><BR>
<?php
//GAMEURL, SERVERURL etc.
require_once ("currentRunningVersion.php");

require_once (GAMEPATH . "includes/db.inc.php");

$time = time();


echo "<h1>Users</h1>";


$seconds = time() - 1109977200;
$daysago = floor($seconds / 86400);
echo "Syrnia launched $daysago days ago.<BR>";


$sql = "SELECT ID FROM users ORDER BY ID DESC LIMIT 1";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat))
{
    $currentID = $record->ID;
}


echo "We have had a total of $currentID players (Includes deleted accounts).<br/>";


$sql = "SELECT COUNT(*) as onLine FROM users WHERE online=1";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat))
{
    echo "$record->onLine of those are online right now..";
}

include ('statfile.txt');

/*
$resultaat = mysqli_query($mysqli, "SELECT username FROM stats WHERE loggedin>($time-172800)");    
$aantalaa = mysqli_num_rows($resultaat); 
echo"($aantalaa users logged in the last 2 days)";

$resultaat = mysqli_query($mysqli, "SELECT username FROM stats WHERE loggedin>($time-604800)");    
$aantalaa = mysqli_num_rows($resultaat); 
echo" ($aantalaa users logged in the last 7 days)<BR>";


$resultaat = mysqli_query($mysqli, "SELECT username FROM users WHERE joined>($time-86400)");    
$aantalaaToday = mysqli_num_rows($resultaat); 
echo" ($aantalaaToday users joined today) ";

$resultaat = mysqli_query($mysqli, "SELECT username FROM users WHERE joined>($time-604800)");    
$aantalaa = mysqli_num_rows($resultaat); 
echo" ($aantalaa users joined the  last 7 days)<BR>";


$seconds=$totalonline;

$hoursleft=floor($seconds/3600);
if($hoursleft<0){$hoursleft=0;}
$seconds=$seconds-($hoursleft*3600);
$minleft=floor($seconds/60);
if($minleft<0){$minleft=0;}

echo"Those $active players have spend a total of $hoursleft hours and $minleft minutes playing syrnia since 11-3-2005, and got $gold gold.<BR>";




$avtotalskill=round($totalskill/$nr);
$avage=round($age/$nr);
$lastact=round(time()-($lastaction/$S_mapNumber));
$lastlog=round(time()-($lastlogin/$S_mapNumber));
$avonline=round($totalonline/$active);

$seconds=$avonline;
$hoursleft=floor($seconds/3600);
if($hoursleft<0){$hoursleft=0;}
$seconds=$seconds-($hoursleft*3600);
$minleft=floor($seconds/60);
if($minleft<0){$minleft=0;}
//echo"<B>An average user</b> has spend $hoursleft hours, $minleft minutes playing syrnia.<BR>";

$seconds=$lastlog;
$daysleft=floor($seconds/86400);
if($daysleft<0){$daysleft=0;}
$seconds=$seconds-($daysleft*86400);
$hoursleft=floor($seconds/3600);
if($hoursleft<0){$hoursleft=0;}
$seconds=$seconds-($hoursleft*3600);
$minleft=floor($seconds/60);
if($minleft<0){$minleft=0;}
//echo"Logged in $daysleft days, $hoursleft hours, $minleft minutes ago.<BR>";

$days=$avgjoin/86400;
$seconds=$avonline/$days;
$hours=floor($seconds/3600);
if($hours<0){$hours=0;}
$seconds=$seconds-($hours*3600);
$mins=floor($seconds/60);
if($mins<0){$mins=0;}




$seconds=$avgjoin;
$daysleft=floor($seconds/86400);
if($daysleft<0){$daysleft=0;}
$seconds=$seconds-($daysleft*86400);
$hoursleft=floor($seconds/3600);
if($hoursleft<0){$hoursleft=0;}
$seconds=$seconds-($hoursleft*3600);
$minleft=floor($seconds/60);
if($minleft<0){$minleft=0;}
//echo" Joined $daysleft days, $hoursleft hours, $minleft minutes ago.<BR>
// Plays $hours hours $mins minutes a day.<BR>
//Owns $avggold gold, ";# is $avage years old and
//echo" has got $avtotalskill totalskills.<BR>";




//$resultaat = $mysqli->query("SELECT COUNT(*) as totaal FROM users WHERE joined<($time) && joined>($time-86400)");    
//$totaal= $resultaat->fetch_assoc();
$aantal1=$aantalaaToday;

$resultaat = mysqli_query($mysqli, "SELECT COUNT(*) as totaal FROM users WHERE joined<($time-86400) && joined>($time-86400*2)");    
$totaal= $resultaat->fetch_assoc();
$aantal2=$totaal['totaal'];
$resultaat = mysqli_query($mysqli, "SELECT COUNT(*) as totaal  FROM users WHERE  joined<($time-86400*2) &&  joined>($time-86400*3)");    
$totaal= $resultaat->fetch_assoc();
$aantal3=$totaal['totaal'];
$resultaat = mysqli_query($mysqli, "SELECT COUNT(*)  as totaal FROM users WHERE joined<($time-86400*3) && joined>($time-86400*4)");    
$totaal= $resultaat->fetch_assoc();
$aantal4=$totaal['totaal'];
$resultaat = mysqli_query($mysqli, "SELECT COUNT(*) as totaal  FROM users WHERE joined<($time-86400*4) && joined>($time-86400*5)");    
$totaal= $resultaat->fetch_assoc();
$aantal5=$totaal['totaal'];
$resultaat = mysqli_query($mysqli, "SELECT COUNT(*) as totaal  FROM users WHERE joined<($time-86400*5) && joined>($time-86400*6)");    
$totaal= $resultaat->fetch_assoc();
$aantal6=$totaal['totaal'];
$resultaat = mysqli_query($mysqli, "SELECT COUNT(*) as totaal FROM users WHERE joined<($time-86400*6) && joined>($time-86400*7)");    
$totaal= $resultaat->fetch_assoc();
$aantal7=$totaal['totaal'];


echo"
<h1>Joins:</h1>
<Table border=1><tr valign=bottom align=center>
<td> <table bgcolor=ff0000><tr width=8 height=".($aantal7/3).">$aantal7<td></table> 
<td>  <table bgcolor=ff0000><tr width=8 height=".($aantal6/3).">$aantal6<td></table> 
<td>  <table bgcolor=ff0000><tr width=8 height=".($aantal5/3).">$aantal5<td></table> 
<td>  <table bgcolor=ff0000><tr width=8 height=".($aantal4/3).">$aantal4<td></table> 
<td>  <table bgcolor=ff0000><tr width=8 height=".($aantal3/3).">$aantal3<td></table> 
<td>  <table bgcolor=ff0000><tr width=8 height=".($aantal2/3).">$aantal2<td></table> 
<td>  <table bgcolor=ff0000><tr width=8 height=".($aantal1/3).">$aantal1<td></table> 
<tr><td> 6 days ago
<td> 5 days ago
<td> 4 days ago
<td> 3 days ago
<td> 2 days ago
<td> 1 days ago
<td> Today
</table>";

$resultaat = mysqli_query($mysqli, "SELECT  COUNT(*)  as totaal FROM users WHERE joined<($time) && joined>($time-604800)");    
$totaal= $resultaat->fetch_assoc();
$aantal1=$totaal['totaal'];
$resultaat = mysqli_query($mysqli, "SELECT  COUNT(*) as totaal  FROM users WHERE joined<($time-604800) && joined>($time-604800*2)");    
$totaal= $resultaat->fetch_assoc();
$aantal2=$totaal['totaal'];
$resultaat = mysqli_query($mysqli, "SELECT  COUNT(*) as totaal  FROM users WHERE  joined<($time-604800*2) &&  joined>($time-604800*3)");    
$totaal= $resultaat->fetch_assoc();
$aantal3=$totaal['totaal'];
$resultaat = mysqli_query($mysqli, "SELECT  COUNT(*) as totaal  FROM users WHERE joined<($time-604800*3) && joined>($time-604800*4)");    
$totaal= $resultaat->fetch_assoc();
$aantal4=$totaal['totaal'];
$resultaat = mysqli_query($mysqli, "SELECT  COUNT(*)  as totaal FROM users WHERE joined<($time-604800*4) && joined>($time-604800*5)");    
$totaal= $resultaat->fetch_assoc();
$aantal5=$totaal['totaal'];
$resultaat = mysqli_query($mysqli, "SELECT  COUNT(*)  as totaal FROM users WHERE joined<($time-604800*5) && joined>($time-604800*6)");    
$totaal= $resultaat->fetch_assoc();
$aantal6=$totaal['totaal'];
$resultaat = mysqli_query($mysqli, "SELECT  COUNT(*)  as totaal FROM users WHERE joined<($time-604800*6) && joined>($time-604800*7)");    
$totaal= $resultaat->fetch_assoc();
$aantal7=$totaal['totaal'];

echo"<Table border=1><tr valign=bottom align=center>
<td> <table bgcolor=ff0000><tr width=8 height=".($aantal7/5).">$aantal7<td></table> 
<td>  <table bgcolor=ff0000><tr width=8 height=".($aantal6/5).">$aantal6<td></table> 
<td>  <table bgcolor=ff0000><tr width=8 height=".($aantal5/5).">$aantal5<td></table> 
<td>  <table bgcolor=ff0000><tr width=8 height=".($aantal4/5).">$aantal4<td></table> 
<td>  <table bgcolor=ff0000><tr width=8 height=".($aantal3/5).">$aantal3<td></table> 
<td>  <table bgcolor=ff0000><tr width=8 height=".($aantal2/5).">$aantal2<td></table> 
<td>  <table bgcolor=ff0000><tr width=8 height=".($aantal1/5).">$aantal1<td></table> 
<tr><td> 6 weeks ago
<td> 5 weeks ago
<td> 4 weeks ago
<td> 3 weeks ago
<td> 2 weeks ago
<td> 1 week ago
<td> This week
</table>";


if($COUNTRY==111){
echo"<h3>Country's top 75</h3><Table>
<tr><Td>Rank<td>Country<td>Players<td>%";  $rank='1';
$sql = "SELECT count(country) as lolo, country  FROM users WHERE password<>'' GROUP BY country ORDER BY lolo desc LIMIT 75"; 
$resultaat = mysqli_query($mysqli,$sql);     
while ($record = mysqli_fetch_object($resultaat)) { 
$proc=round(1000*($record->lolo/$active))/10;
echo"<tr><Td>$rank<td>$record->country<Td>$record->lolo<td>$proc";  
$rank=$rank+1; }
echo"</table>";
}



echo"<h3>Top 10 active users</h3><Table>
<tr><td>Rank<td>Seconds played<td>Player<td>%";  $rank='1';
$sql = "SELECT online,  username  FROM stats ORDER BY online desc LIMIT 10"; 
$resultaat = mysqli_query($mysqli,$sql);     
while ($record = mysqli_fetch_object($resultaat)) { 
$proc=(round(($record->online/$totalonline)*10000)/10000)*100;
echo"<tr><Td>$rank<td>$record->online<Td>$record->username<td>$proc"; 
$rank=$rank+1; }
echo"</table>";



*/





?>