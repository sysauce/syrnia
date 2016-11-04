<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){


$output.="<B>Archeologist:</B> \"Hey there, are you one of the new archeologists McGoogin has hired ?<BR>";
$output.="Don't tell them I told you this, but I think strange things are going on down there...<BR>";
$output.="I think McGoogin hired some new team members to replace archeologists who suddently disappeared.\"<BR>";
$output.="<BR>";
$output.="<BR>";

$questID=8;
if(stristr($_SESSION['S_questscompleted'], "[$questID]")<>'' OR stristr($_SESSION['S_quests'], "$questID(4")<>''){
	
	if($action=='move'){
	 	$to='McGoogins camp';
	 	
	//	$timee=time();
	 //	$time=90;
		//mysqli_query($mysqli,"UPDATE users SET work='move', worktime=($timee+$time), dump='$to', dump2='0' WHERE username='$S_user' LIMIT 1") or die("error --> 1113");
		echo "updateCenterContents('move', '$to');";
		
	 	//$S_location=$to;
		//mysqli_query($mysqli,"UPDATE users SET location='$to', dump='', dump2='' WHERE username='$S_user' LIMIT 1") or die("error --> 1113"); 
		//include('includes/mapData.php');
		//echo"updateCenterContents('move', '$to');";
		//echo"updateCenterContents('loadLayout', 1);";
		
	}else{
		$output.="McGoogin runs the archeological site on Heerchey island with the Heerchey family permission.<BR>";
		$output.="<a href='' onclick=\"locationText('move');return false;\">Enter the cave system</a>";
	}
}




$questID=8;
if(stristr($_SESSION['S_questscompleted'], "[$questID]")===false && stristr($_SESSION['S_quests'], "$questID(3)]")<>''){
	$output.="<BR><BR>";
	if($level>=20 && $miningl>=10){
		include('textincludes/quests.php');
	}else{
		$output.="<u>You need a minimum combat level of 20 and mining level 10 to be able to join the archeological team.</u><BR>";
	}
}




}
}
?>