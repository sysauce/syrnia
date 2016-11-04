<?
if(defined('AZtopGame35Heyam')){


global $PARTYISLAND;
if(!$PARTYISLAND && $S_mapNumber==8 && $S_user!='M2H' && $S_user!='edwin'){
	mysqli_query($mysqli, "UPDATE users SET location=(SELECT partyIslandSailLocation FROM users_junk WHERE username='$S_user' LIMIT 1) WHERE username='$S_user'") or die("error --> 1113");
	/*mysqli_query($mysqli, "UPDATE users SET location='Crab nest', work='', worktime='', dump='', dump2='',dump3='' WHERE location='$S_location' && side='Pirate'") or die("error --> 1113");
	mysqli_query($mysqli, "UPDATE users SET location='Port Senyn', work='', worktime='', dump='', dump2='',dump3='' WHERE location='$S_location' && side!='Pirate'") or die("error --> 1113");*/
	include('includes/mapData.php');
	echo"updateCenterContents('loadLayout', 1);";
	exit();
}


if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR><BR>";
$output.="<a href='' onclick=\"locationText('sail');return false;\"><font color=white>Sail</a><BR>";
if(date("Y-m")=='2009-12' ){ $output.="<a href='' onclick=\"locationText('work', 'other');return false;\"><font color=white>Make snowballs</font></a><br/>"; }
if(date("-m")=='-12' ){ $output.="<a href='' onclick=\"locationText('work', 'other');return false;\"><font color=white>Search for Christmas decorations</font></a><br/>"; }
$output.="<BR>";


} elseif($locationshow=='LocationText'){

if($action=='sail'){

	include('textincludes/sailing.php');

}else{

	//HALLOWEEN
	//$output.="<b>Trick or treat?</b><br /><br />";


	$output.="Welcome to Syrnia's Celebration Island!<BR>";
	$output.="When the ship arrived at Port Party you heard loud music and saw drunk people swimming in the port, they sure know how to party!<BR>";
	$output.="<BR>";
	$output.="We all know...<U>Syrnia is the real life</u>...but now and then we need to relax and think about our fantasy life on Earth. Whenever there's a big party all players of Syrnia will gather here within several minutes. It will then be a matter of time before the music begins and pubs open. Evil or good, infamous or famous, everyone forgets their status and everyone is happy around here.<BR>";
	$output.="This island has got no valuable resouces, except for some resources which can be used for the parties. Therefore it has always been empty until people started to gather here to party.<BR>";
}


}
}
?>