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

//Syrnia bday
//	$output.="<a href='' onclick=\"locationText('work', 'woodcutting');return false;\"><font color=white>Woodcut</a><BR>";
//	$output.="<a href='' onclick=\"locationText('work', 'other');return false;\"><font color=white>Craft balloons</a><BR>";

if(date("m")=='12'){  $output.="<a href='' onclick=\"locationText('work', 'woodcutting');return false;\"><font color=white>Woodcut</a><BR>";
// }elseif(date(jn)=='53'){$output.="<a href=?work=other><font color=white>Craft balloons</a><BR>"; }
}else if(date("Y-m-d")=='2007-10-31' OR date("Y-m-d")=='2007-10-30'){
 	$output.="<a href='?fight=$S_location'><font color=white>Fight a halloween monster (8+)</a><BR>";
}


$output.="<BR>";

} elseif($locationshow=='LocationText'){

//$output.="You arrive at Celebration Forest.  All that remains is lots of tree stumps and a note from the witch.<br /><br />\"Thank you for all the wood, I can now make the ultimate broomstick for me!\"";


$output.="The festival forests do not contain much wood, and it is hard to cut.<br />";
$output.="Therefore it is only used during festivals, to play hide and seek or anything else.<br />";
$output.="In the winter a few beautiful Christmas trees can be cut here.<br/>";
$output.="<br/>";


if(date("Y-m-d")=='2007-10-31' OR date("Y-m-d")=='2007-10-30'){
	 $output.="You spot a graveyard at festival forest. No one knows where it came from..<br/>";
	 $output.="It is already swamped with treasure hunters.<br/>";
	 $output.="Dare to dig for treasure too ?<br/>";
	 $output.="<a href=?work=other>Dig using your spade</a>";
 }

}
}
?>