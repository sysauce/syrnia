<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$time=time();

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"locationText('thieving');return false;\"><font color=white>Thieving guild</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

if($action=='thieving'){
	$output.="<B>Welcome to The Thieving Guild.</b><BR><BR>";

	$questID=10;
	if(stristr($_SESSION['S_questscompleted'], "[$questID]")=='' && stristr($_SESSION['S_questscompleted'], "[3]")){
	 	if($thievingl>=5 && $speedl>=15){
			include('textincludes/quests.php');
		}else{
			$output.="<i>If you come back later with thieving level 5 and speed level 15, there will be a new quest.</i><br />";
		}
		$output.="<br /><br />";
	}




	if($speedl>=6 && $thievingl>=3){
		$questID=3;
	   $resultaaat = mysqli_query($mysqli,  "SELECT username FROM quests WHERE questID='$questID' && completed=1 && username='$S_user' LIMIT 1");
	   $aantal = mysqli_num_rows($resultaaat);
	if($aantal==1){
		$output.="You are member of The Thieving Guild and can now receive jobs.<BR><BR>";

		## NOG NIET OP JOB
		$resultaaat = mysqli_query($mysqli,  "SELECT username FROM quests WHERE jobname='Thieving guild' && username='$S_user' LIMIT 1");
		   $aantal = mysqli_num_rows($resultaaat);
		if($aantal==0){

		if($var1=='job'){

		$i=0;
		while(!$thief && !$thieflocation){
		  	$i++;
		  	if($i>=100){
		  		echo "Error: no valid users online!";
		  		exit();
		  	}
			$sql = "SELECT locationName, username FROM locationinfo, users WHERE (mapNumber=1 || mapNumber=2 || mapNumber=4 || mapNumber=5 ) && users.online=1 && users.location=locationName order by rand() LIMIT 1";
		   	$resultaat = mysqli_query($mysqli, $sql);
		    while ($record = mysqli_fetch_object($resultaat)) { $thieflocation=$record->locationName; $thief=$record->username; }

		    if($thief==$S_user OR $thief=='M2H'){
				$thief='';$thieflocation='';
			}
		}
		$thiefmin=20;
		$output.="Hello $S_user, <BR>";
		$output.="Yes, you could do something for us.<BR>";

		$rand=rand(1,4);
		if($rand==1){ $output.="We are getting pretty tired of $thief, we want you to threaten them.<BR>"; }
		elseif($rand==2){ $output.="$thief has been shaming The Thieving Guild.<BR>"; }
		elseif($rand==3){ $output.="We heard $thief was talking about organising some action against a group of friendly thieves.<BR>"; }
		elseif($rand==4){ $output.="$thief has been killing some of our thieves in The Outlands.<BR>"; }

		$output.="Could you try to thieve $thief for us? At least scare $thief with a good thief attempt, that will tell $thief we're after them.<BR>";
		$output.="They were last seen at $thieflocation. You should thieve $thief within $thiefmin minutes.<BR>";
		$time=time()+$thiefmin*60;

		$sql = "INSERT INTO quests (username, jobname, type, dump, joblocation, timelimit)
		  VALUES ('$S_user', 'Thieving guild', '0', '$thief', '$thieflocation', '$time')";
		mysqli_query($mysqli, $sql) or die("error report this bug please33 66 msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

		}else{
		 	$output.="<a href='' onclick=\"locationText('thieving', 'job');return false;\">Ask the thieving guild for a job.</a>";
		}

		}else{
		## ON IT COMPLETED
		  $sql = "SELECT dump, joblocation, timelimit FROM quests WHERE username='$S_user' && completed=1 && jobname='Thieving guild' LIMIT 1";
		   $resultaat = mysqli_query($mysqli, $sql);
		    while ($record = mysqli_fetch_object($resultaat))
			{
			$timeleft=$record->timelimit; //-$timee;
			if($timeleft<0){$timeleft=0; }
			if($timeleft>1800){$timeleft=1800; }
			$newexp=round($timeleft/14)+20;

			$output.="You had $timeleft seconds left to complete this task.<br />";
			if(($timeleft/60)>15){ $output.="Wow you did that within 5 minutes, awesome!<BR>"; }
			elseif(($timeleft/60)>7){ $output.="Nice, you had a little more than half of the time left.<BR>"; }
			elseif(($timeleft/60)>3){ $output.="Right on time.<BR>"; }
			elseif(($timeleft/60)>0){ $output.="Phew...that was just in time.<BR>"; }
			else{ $output.="That took long enough...<BR>"; }
			$rand=rand(1,3);
			if($rand==1){ $output.="You have shown $record->dump that they shouldn't mess around with the thieving guild!<BR>Thanks a lot.<BR>"; }
			elseif($rand==2){ $output.="Let's see if $record->dump will now think twice before messing with the thieving guild!<BR>Thanks a lot.<BR>"; }
			elseif($rand==3){ $output.="We hope $record->dump will leave us alone now.<BR>If $record->dump keeps bothering us we will ask you to scare $record->dump once more.<BR>Thanks a lot.<BR>"; }

			$newgold=round($newexp/1.75);

			$output.="<B><font color=green>You got $newexp thieving experience.</b></font><BR>";
			$output.="<B><font color=green>The thieving guild paid you $newgold gold.</b></font><BR>";

			getGold($S_user, $newgold);
			mysqli_query($mysqli, "UPDATE users SET thieving=thieving+'$newexp' WHERE username='$S_user' LIMIT 1") or die("err2or --> 1");
			$levelArray=addExp($levelArray, 'thieving', $newexp);
			 $sql = "DELETE FROM quests WHERE username='$S_user' && jobname='Thieving guild' LIMIT 1";
			      mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
		}

		## ON IT uncompl
		  $sql = "SELECT dump, joblocation, timelimit FROM quests WHERE username='$S_user' && timelimit>$time && completed=0 && jobname='Thieving guild' LIMIT 1";
		   $resultaat = mysqli_query($mysqli, $sql);
		    while ($record = mysqli_fetch_object($resultaat))
			{
				$resultaaaat = mysqli_query($mysqli,  "SELECT username FROM users WHERE username='$record->dump' && online=1 LIMIT 1");
				$aantal = mysqli_num_rows($resultaaaat);
				if($aantal>0){
				 	$output.="You are now on a job for the thieving guild.<BR>";
					$output.="<B>Mission:</b><BR>";
					$output.="Thieve: $record->dump.<BR>";
					$output.="Last seen: $record->joblocation.<BR>";
					$output.="Time left: ".ceil(($record->timelimit-time())/60)." minutes";
				}else{
					$output.="It seems that your target has disappeared, we're cancelling this job.<BR>";
				 	$sql = "DELETE FROM quests WHERE username='$S_user' && jobname='Thieving guild' LIMIT 1";
				      mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
				}
		 }

		## FAIL uncompl
		  $sql = "SELECT timelimit FROM quests WHERE username='$S_user' && timelimit<=$time && completed=0 && jobname='Thieving guild' LIMIT 1";
		   $resultaat = mysqli_query($mysqli, $sql);
		    while ($record = mysqli_fetch_object($resultaat))
			{
			 	$output.="You failed on your last job for the thieving guild.<BR>";
				$output.="What were you doing? We feel ashamed.<BR>";
				$output.="<a href='' onclick=\"locationText('thieving', 'job');return false;\">Ask the thieving guild for a new job.</a>";
		 		$sql = "DELETE FROM quests WHERE username='$S_user' && jobname='Thieving guild' LIMIT 1";
		      	mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
		 	}
		}# wel op quest


	} else{
		include('textincludes/quests.php');
	}

	} else {
		$output.="You are not skilled enough to hang out here.<BR>";
		$output.="<BR>";
		$output.="<font color=red>You need at least level 3 thieving and level 6 speed.<BR>";
	}

} else {
$output.="Mentan contains all of the rogues and thieves that are exiled from the other islands, you can't trust anyone here - although it seems that some groups of thieves can trust each other very well.<BR>";
}

}
}
?>