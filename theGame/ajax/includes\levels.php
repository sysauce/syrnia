<?php
if(defined('AZtopGame35Heyam')){
if(!$S_user){
	exit();
}

    
   $sql = "SELECT smithing,mining,fishing,cooking,strength,attack,defence,health,hp,speed,trading,thieving,constructing,woodcutting,cooking,magic,farming,fame,level,totalskill FROM users WHERE username='$S_user' LIMIT 1"; 
   $resultaat = mysqli_query($mysqli, $sql);     
    while ($record = mysqli_fetch_object($resultaat)) { 


$smithing=$record->smithing;
$smithingl=floor(pow($smithing, 1/3.507655116));
$smithingexpneeded=ceil(exp( 3.507655116001 * log($smithingl+1) ))-$smithing;

$skills= array('mining','smithing','constructing','fishing','cooking','farming','thieving',
				'magic','speed','strength','defence','attack','health','trading','woodcutting');


for($i=0;$skills[$i];$i++){
	$exp=$record->$skills[$i];
	$level=floor(pow($exp, 1/3.507655116));
	$levelArray[$skills[$i]]['exp']=$exp;
	$levelArray[$skills[$i]]['level']=$level;
	$levelArray[$skills[$i]]['nextLevel']=ceil(exp( 3.507655116 * log($level+1) ))-$exp;
}

$totalskill=0;
for($i=0;$skills[$i];$i++){	
	$totalskill+=$levelArray[$skills[$i]]['level'];
}



$level=floor($levelArray['attack']['level']/3+$levelArray['defence']['level']/3+$levelArray['strength']['level']/3+$levelArray['health']['level']/5);
$combatL=$level;//Used at arena.php

$maxhp=floor($levelArray['health']['level']*1.1+3);
$hp=$record->hp;

$fame=$record->fame;

//24-feb 2008
//Changed "3.507655116001" to "3.507655116" (in the expneededs only)

$mining=$record->mining;
$miningl=floor(pow($mining, 1/3.507655116));
$miningexpneeded=ceil(exp( 3.507655116 * log($miningl+1) ))-$mining;
$fishing=$record->fishing;
$fishingl=floor(pow($fishing, 1/3.507655116));
$fishingexpneeded=ceil(exp( 3.507655116 * log($fishingl+1) ))-$fishing;
$strength=$record->strength;
$strengthl=floor(pow($strength, 1/3.507655116));
$strengthexpneeded=ceil(exp( 3.507655116 * log($strengthl+1) ))-$strength;
$defence=$record->defence;
$defencel=floor(pow($defence, 1/3.507655116));
$defenceexpneeded=ceil(exp( 3.507655116 * log($defencel+1) ))-$defence;
$attack=$record->attack;
$attackl=floor(pow($attack, 1/3.507655116));
$attackexpneeded=ceil(exp( 3.507655116 * log($attackl+1) ))-$attack;
$health=$record->health;
$healthl=floor(pow($health, 1/3.507655116));
$healthexpneeded=ceil(exp( 3.507655116 * log($healthl+1) ))-$health;
$speed=$record->speed;
$speedl=floor(pow($speed, 1/3.507655116));
$speedexpneeded=ceil(exp( 3.507655116 * log($speedl+1) ))-$speed;
$trading=$record->trading;
$tradingl=floor(pow($trading, 1/3.507655116));
$tradingexpneeded=ceil(exp( 3.507655116 * log($tradingl+1) ))-$trading;
$tradingslots=10+($tradingl*5)+floor(pow($tradingl, 2.7));
$thieving=$record->thieving;
$thievingl=floor(pow($thieving, 1/3.507655116));
$thievingexpneeded=ceil(exp( 3.507655116 * log($thievingl+1) ))-$thieving;
$constructing=$record->constructing;
$constructingl=floor(pow($constructing, 1/3.507655116));
$constructingexpneeded=ceil(exp( 3.507655116 * log($constructingl+1) ))-$constructing;
$woodcutting=$record->woodcutting;
$woodcuttingl=floor(pow($woodcutting, 1/3.507655116));
$woodcuttingexpneeded=ceil(exp( 3.507655116 * log($woodcuttingl+1) ))-$woodcutting;
$cooking=$record->cooking;
$cookingl=floor(pow($cooking, 1/3.507655116));
$cookingexpneeded=ceil(exp( 3.507655116 * log($cookingl+1) ))-$cooking;
$magic=$record->magic;
$magicl=floor(pow($magic, 1/3.507655116));
$magicexpneeded=ceil(exp( 3.507655116 * log($magicl+1) ))-$magic;
$farming=$record->farming;
$farmingl=floor(pow($farming, 1/3.507655116));
$farmingexpneeded=ceil(exp( 3.507655116 * log($farmingl+1) ))-$farming;






	if($record->totalskill!=$totalskill OR $level!=$record->level){  
		mysqli_query($mysqli, "UPDATE users SET totalskill='$totalskill', level='$level' WHERE username='$S_user' LIMIT 1") or die("error --> LEVEL TOTAL");  
 	}
}




}
?>