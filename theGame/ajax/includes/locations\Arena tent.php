<?
if(defined('AZtopGame35Heyam')){

if($var1=='leave')
{
	if($S_side == 'Pirate')
	{
		$SPAWN='Toothen';
	}
	else
	{
		$SPAWN='Kinam';
	}

	$S_location = $SPAWN;
	mysqli_query($mysqli, "UPDATE users SET location='$SPAWN' WHERE ID='$S_userID' LIMIT 1") or die("error --> exiting arena");
	mysqli_query($mysqli, "UPDATE arena SET players=(SELECT COUNT(ID) FROM users WHERE location = 'Arena tent') WHERE time>='$timee' order by time asc LIMIT 1") or die("error --> 1113");
	echo "updateCenterContents('loadLayout', 1);";
	include_once('includes/mapData.php');
}
else if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

	$arena='Desert arena';

  $sql = "SELECT time,started,ID,players FROM arena WHERE winner='' ORDER BY time asc LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
	{ // Collect arena data for first next un-fought arena fight
		 $IDAR=$record->ID;
		 $timeAR=$record->time;
		 $started=$record->started;
		 $players=$record->players;
	 }
    $arenastarts=$timeAR-$timee+15; //+X  to make it start X sec AFTER scheduled time to stop players from joining at same time

    if($arenastarts<1){

	    if($started==0){
		   if($players>2){ ## PLAY (otherwise delay)

			    mysqli_query($mysqli, "UPDATE arena SET started=1 WHERE ID='$IDAR' LIMIT 1") or die("error --> 544343");

			    $sql = "SELECT ID FROM users WHERE location='Arena tent'";
			   	$resultaat = mysqli_query($mysqli, $sql);
			    while ($record = mysqli_fetch_object($resultaat))
				{
				 	$rand=rand(1,20);
			    	mysqli_query($mysqli, "UPDATE users SET location='$arena $rand' WHERE ID='$record->ID' LIMIT 1") or die("error --> 544343");
				}

		    }else{

			 	$newtime=$timee+900;
				 mysqli_query($mysqli, "UPDATE arena SET time='$newtime' WHERE ID='$IDAR' LIMIT 1") or die("error --> 544343");
		    	$output.="Fight delayed, not enough people. <BR>";

			}             ## DELAY FIGHT!
	    }   ## MOET STARTE




		include_once('includes/mapData.php');
		$_SESSION['S_lastPVPupdate']=$timee-3600;
		$_SESSION['S_lastPVPID']=0;

		echo"if(\$('combatLog')!=null){\$('combatLog').innerHTML=\"\";\$('combatLog').title=\"$timee\";}";
		echo"setTimeout(\"pvpLog('$timee');\", 2500);";

		$output.="Going to $arena<br />";
		echo "updateCenterContents('move', 'Arena');";
		echo "updateCenterContents('loadLayout', 1);";
		$movePlayer=1;

    }

    if(!$movePlayer==1){
		$time=$arenastarts;
		$output.="You are now in the arena tent waiting for the mages to teleport you to the desert arena.<BR>";
		$output.="Do you want to leave the arena?<BR><a href='' onclick=\"locationText('Arena tent', 'leave');return false;\">Leave the arena tent.</a><BR>";

		$output.="<b>Time left:</b> ";

		echo"setTimeout(\"locationTextCounter('arenaCounter2', (new Date().getTime()+$arenastarts*1000), '$timee', '$action', '', '', '');\", 1000);";
		$output.="<input type=\"text\" readonly size=\"4\" id='arenaCounter2' style=\"background-color: #660000; border: 0 solid #333333; font-size : 24px;color: #ffffff;\" value='".($time+2)."' title='$timee'>";
	}else{
		echo"setTimeout(\"locationTextCounter('arenaCounter2', (new Date().getTime()+($arenastarts-15)*1000), '$timee', '$action', '', '', '');\", 1000);";
	}




}
}
?>