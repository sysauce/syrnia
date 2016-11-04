<?
if(defined('AZtopGame35Heyam')){


include_once('sailingLocations.php');

$S_side=$_SESSION['S_side'];

$to=$var1;
$boat=$var2;

if($action=='sail' && $var3=='sailing' && $to){
 	$found='';
 	for($i=1;$sailLocations[$i]['location'];$i++){
	 	if($sailLocations[$i]['location']==$to && ($sailLocations[$i]['side']==$S_side || $sailLocations[$i]['side']=='any' )){
	 	 	$found=$i;
	 	 	break;
	 	}else{

		}
	}

	if($found==''){
		 exit();
	}

	if($sailLocations[$i]['disallowOwnBoats']==1 && $boat && $sailLocations[$i]['onlyAllowBoat']!=$boat){
	 	exit();
	}


	$time=$sailLocations[$found]['timeCost'];
	$cost=$sailLocations[$found]['goldCost'];

	if($to=='The Outlands'){
	 	$to=rand(1,2);
		 if($to==1){$to='The Outlands 13'; } else{ $to='The Outlands 1'; }
	}

	if($boat){
	 	$cost=100000;
	    $resultaat = mysqli_query($mysqli, "SELECT username FROM items_inventory WHERE name='$boat' && type='boat' && username='$S_user' LIMIT 1");
	    $aantal = mysqli_num_rows($resultaat);
		if($aantal==1){
		  	if($boat=='Small fishing boat'){  $cost=0; $time=$time*0.7; }
			elseif($boat=='Sloop'){   $cost=0; $time=$time*0.50; }
			elseif($boat=='Boat'){   $cost=0; $time=$time*0.30; }
			elseif($boat=='Trawler'){   $cost=0; $time=$time*0.25; }
			elseif($boat=='Canoe'){   $cost=0; $time=$time*0.5; }
		}
	}

	$canSail=0;
	if($cost==0){
		$canSail=1;
	}else if(payGold($S_user, $cost)==1){
		$canSail=1;
	}

	if($canSail==1){
		$doen='done';  $timee=time();
		mysqli_query($mysqli,"UPDATE users SET work='move', worktime=($timee+$time), dump='$to', dump2='0' WHERE username='$S_user' LIMIT 1") or die("error --> 1113");

		$output.="The ship is preparing to sail to $to!<BR>";
		echo "updateCenterContents('move', '$to');";

		if($S_location=='Port party'){
			//mysqli_query($mysqli,"UPDATE users_junk SET partyIslandSailLocation='' WHERE username='$S_user' LIMIT 1") or die("error --> 1113");
		}else if($to=='Port party'){
			mysqli_query($mysqli,"UPDATE users_junk SET partyIslandSailLocation='$S_location' WHERE username='$S_user' LIMIT 1") or die("eror > 1113");
		}

	} else{
	 	$output.="<B>You do not have enough gold to travel with that captain.</B><BR>"; }
	}



if($doen!='done'){
	$output.="Some captains at this harbor offer you a trip to other islands, where do you want to travel to?<BR>";

	for($i=1;$sailLocations[$i]['location'];$i++){
	 	 	if($sailLocations[$i]['location']=='Port party'){
	 	 		if($PARTYISLAND=='open'){
	 	 		 	$output.="<a href='' onclick=\"locationText('sail', '".$sailLocations[$i]['location']."', '', 'sailing');return false;\">".$sailLocations[$i]['location']."</a> - free<br />";
	 	 		}
	 	 	}else if($sailLocations[$i]['location']=='The Outlands'){
				if($level>=5 OR $totalskill>=60){
				 	$output.="<a href='' onclick=\"locationText('sail', '".$sailLocations[$i]['location']."', '', 'sailing');return false;\">Sail to ".$sailLocations[$i]['location']."</a> - ".$sailLocations[$i]['goldCost']." Gold<BR>";
				}else{
				 	$output.="You need to train your combat level to level 5 or get 60 total level before you can enter the outlands.<BR>";
				}
			}else if($sailLocations[$i]['side']=='any' || $sailLocations[$i]['side']==$S_side){
				$output.=" <a href='' onclick=\"locationText('sail', '".$sailLocations[$i]['location']."', '', 'sailing');return false;\">".$sailLocations[$i]['location']."</a> - ".$sailLocations[$i]['goldCost']." Gold<BR>";
			}
			//else{
			//		$output.="DEBUG[ $S_user cant go to: ".$sailLocations[$i]['location']." because '$S_side' <-> '".$sailLocations[$i]['side']."']";
			//}
	}




	$output.="<br /><br />";
	$boatTexts='';
	$resultaat = mysqli_query($mysqli,"SELECT II.ID, II.name FROM items_inventory II LEFT JOIN items I ON I.name = II.name WHERE II.username='$S_user' && II.type='boat' ORDER BY I.rank DESC");
	while ($record = mysqli_fetch_object($resultaat))
	{
		$boatTexts='';

		for($i=1;$sailLocations[$i]['location'];$i++){
		 	if($sailLocations[$i]['disallowOwnBoats']==0 || $record->name==$sailLocations[$i]['onlyAllowBoat']){
		 	 	if($sailLocations[$i]['location']=='Port party'){
		 	 		if($PARTYISLAND=='open'){
		 	 		 	$boatTexts.="<a href='' onclick=\"locationText('sail', '".$sailLocations[$i]['location']."', '$record->name', 'sailing');return false;\">".$sailLocations[$i]['location']."</a>";
		 	 		}
		 	 	}else if($sailLocations[$i]['side']=='any' || $sailLocations[$i]['side']==$S_side){
					$boatTexts.=" <a href='' onclick=\"locationText('sail', '".$sailLocations[$i]['location']."', '$record->name', 'sailing');return false;\">".$sailLocations[$i]['location']."</a> ";
				}
		 	}
		}

		if($boatTexts){
			$output.="Use your $record->name to travel to: ";
			$output.=$boatTexts;
			$output.="<br />";
		}



	}



}






}
?>
