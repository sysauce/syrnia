<?php

ob_start();


?>
<center><h1>Highscore</h1><?php 

## ####
##  CLAN
######
if(defined('AZtopGame35Heyam') && $crawlerBlocker<=100){

$crawlerBlocker++;
$_SESSION["crawlerBlocker"] = $crawlerBlocker;

if($clan<>''){


if($show){
     $sql = "SELECT username, name, pw FROM clans  WHERE tag='$show' ORDER BY username asc";
    $resultaat = mysqli_query($mysqli,$sql); 
         while ($record = mysqli_fetch_object($resultaat)) { 
         if($record->pw<>''){$leader=$record->username;}
         $members=$members+1; 
          $list="$list<tr><td>$record->username"; $clan="$record->name";
         }
echo"<a href=index.php?page=highscore2&clan=1>Return to clan list.</a><h4>$clan <i>[$show]</i></h4>";
echo"$members members<Br>
Clanleader: <B>$leader</b><br />
<br />


<table>
<tr bgcolor=333333><td><B>Members:</B>
$list</table>";

}else{
echo"<a href=index.php?page=highscore>Return to highscores.</a><h4>Clan list</h4>";
echo"Contains all clans with 3 members or more.<BR>
<BR>




<table><tr><td><B>Tag<td><B>Name<td><B>Members";
        $sql = "SELECT tag, name, COUNT(`ID`) as members FROM clans  GROUP BY name ORDER BY name asc";
    $resultaat = mysqli_query($mysqli,$sql); 
         while ($record = mysqli_fetch_object($resultaat)) {
         if($record->members>=3){
        
               if($a==0){  echo"<tr>"; $a=1;}else{ echo"<tr>"; $a=0;}
      echo"<td>$record->tag<td><a href=\"index.php?page=highscore2&clan=1&show=".urlencode($record->tag)."\">$record->name</a><td>$record->members"; 
     } }
     echo"</table>";
}#clanlsit not show
}else{ ###PLAYER
$aap=DESC;

if($high && strtoupper($high)<>'M2H'){
echo"<a href=index.php?page=highscore>Return to highscores.</a><BR>";
      $sql = "SELECT level,totalskill,smithing,mining, fishing, strength, defence, attack, health, speed, trading, thieving, constructing, woodcutting, cooking, magic, farming   FROM users WHERE username='$high' LIMIT 1";
    $resultaat = mysqli_query($mysqli,$sql); 
     while ($record = mysqli_fetch_object($resultaat)) { 
$levelexp=$record->attack+$record->defence+$record->strength+$record->health;
$exp=$record->mining+$record->smithing+$record->attack+$record->defence+$record->strength+$record->speed+$record->farming+$record->health+$record->magic+$record->woodcutting+$record->constructing+$record->trading+$record->thieving+$record->fishing+$record->cooking;
$total=floor(pow($exp, 1/3.507655116));

$smithing=$record->smithing;
$smithingl=floor(pow($smithing, 1/3.507655116));
$mining=$record->mining;
$miningl=floor(pow($mining, 1/3.507655116));
$fishing=$record->fishing;
$fishingl=floor(pow($fishing, 1/3.507655116));
$strength=$record->strength;
$strengthl=floor(pow($strength, 1/3.507655116));
$defence=$record->defence;
$defencel=floor(pow($defence, 1/3.507655116));
$attack=$record->attack;
$attackl=floor(pow($attack, 1/3.507655116));
$health=$record->health;
$healthl=floor(pow($health, 1/3.507655116));
$speed=$record->speed;
$speedl=floor(pow($speed, 1/3.507655116));
$trading=$record->trading;
$tradingl=floor(pow($trading, 1/3.507655116));
$thieving=$record->thieving;
$thievingl=floor(pow($thieving, 1/3.507655116));
$constructing=$record->constructing;
$constructingl=floor(pow($constructing, 1/3.507655116));
$woodcutting=$record->woodcutting;
$woodcuttingl=floor(pow($woodcutting, 1/3.507655116));
$cooking=$record->cooking;
$cookingl=floor(pow($cooking, 1/3.507655116));
$magic=$record->magic;
$magicl=floor(pow($magic, 1/3.507655116));
$farming=$record->farming;
$farmingl=floor(pow($farming, 1/3.507655116));

$totalskill=$smithingl+$miningl+$fishingl+$strengthl+$defencel+$attackl+$healthl+$speedl+$tradingl+$thievingl+$constructingl+$woodcuttingl+$cookingl+$magicl+$farmingl;

echo"These details are up to date.<BR>
<BR>
Player: $high
<Table>
<tr bgcolor=333333><td>Skill <td>Level <td>Exp
<tr><td>Totalskills<td>$record->totalskill<td>$exp
<tr><td>Combat level<td>$record->level<td>$levelexp
<tr><Td>Smithing<td>$smithingl<Td>$smithing
<tr><td>Mining<td>$miningl<td>$mining
<tr><Td>Fishing<td>$fishingl<td>$fishing
<tr><td>Strength<td>$strengthl<Td>$strength
<Tr><Td>Defence<td>$defencel<td>$defence
<tr><Td>Attack<td>$attackl<td>$attack
<tr><td>Health<Td>$healthl<Td>$health
<tr><Td>Speed<td>$speedl<Td>$speed
<tr><Td>Trading<Td>$tradingl<Td>$trading
<tr><Td>Thieving<td>$thievingl<Td>$thieving
<tr><Td>Constructing<Td>$constructingl<Td>$constructing
<tr><td>Woodcutting<td>$woodcuttingl<Td>$woodcutting
<tr><td>Cooking<td>$cookingl<Td>$cooking
<tr><td>Magic<Td>$magicl<td>$magic
<tr><td>Farming<Td>$farmingl<Td>$farming
</table>";

}
if($levelexp==''){echo"There is no such user."; }
} else{
echo"Search a player:<BR>
<form action='' method=post><input type=text name=high><input type=submit value='Search'></form>";
}

}#PLAYER
###########
}else{
	echo "Invalid request!";
}


$output = ob_get_contents();
ob_end_clean();
$inhoud= MakeParchment("$output", "top", "left", 764-18*2, 245);
echo MakeWoodContainer($inhoud, 764, 270); 


?>