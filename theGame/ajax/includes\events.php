<?php
if(defined('AZtopGame35Heyam') && $_SESSION['S_user']){


$output.="<br /><br />";


   $eventResult = mysqli_query($mysqli,"SELECT ID, monsters, monstersmuch, itemtype, invasiontime, rewarded,eventdescription,type,combination,side,dump FROM locations WHERE location='$S_location' && startTime<'$timee' LIMIT 1");
    while ($record = mysqli_fetch_object($eventResult)) { #QUERY
    $eventID=$record->ID;
    $rewarded = $record->rewarded;
if($record->type=='skillevent'){ #EVENT:INVASION
################################
#############################


	if($record->monstersmuch>0 && $record->invasiontime>$timee){
		##### SKILLEVENT IS NU EN NOG ONBESLIST

		$timeleft=ceil(($record->invasiontime-$timee)/60);
		$output.= "<B>There is a $record->dump event!</B> ($timeleft minutes left)<br />$record->eventdescription<br />";
		$output.="<a onclick=\"locationText('work', 'skillevent');return false;\" href=\"\">Help out</a> ($record->monstersmuch left)</a>";



	}elseif($record->invasiontime<>0 && $record->invasiontime<$timee && $record->monstersmuch>0){
		### SKILLEVENT WORD NU GEUPDATE; GEWONNEN DOOR DE MONSTERS


		//TODO
		$mmuch=$record->monstersmuch*rand(2,10);
		mysqli_query($mysqli,"UPDATE locations SET monstersmuch='$mmuch', invasiontime=0 WHERE location='$S_location' LIMIT 1") or die("error --> 544343");
		mysqli_query($mysqli,"UPDATE locations SET rewarded=2 WHERE location='$S_location' LIMIT 1") or die("1331LOC3312");

		$output.="The Syrnian community failed to complete the task set.<BR>";
		$output.="Click <a onclick=\"locationText('work', 'skillevent');return false;\" href=\"\">here</a> here to help to clean up the town ($record->monstersmuch left).</a>";


	}elseif($record->monstersmuch>0 && $record->invasiontime==0){
		#### SKILLEVENT WAS GELUKT VOOR DE VIJAND, KILL ZE , niks speciaals

		$output.="The $record->dump event failed, .<BR>";
		$output.="<a onclick=\"locationText('work', 'skillevent');return false;\" href=\"\">Help out</a> ($record->monstersmuch left)</a>";



	} else{
		#### SKILLEVENT IS ALLANG OVER
	$output.="The citizens of $S_location want to thank the following Syrnians for their efforts in helping the city at the last $record->dump event.<BR><Table><tr><td><B>Rank<td><B>Name<td><B>Points";
	$lim=5; if($action=='events' && $var1=='showall'){$lim=200;}

	//Moet nog rewarden
	if($rewarded==0){
	 	mysqli_query($mysqli,"UPDATE locations SET rewarded=1 WHERE location='$S_location' LIMIT 1") or die("54353535");
		$rank='1'; $limin=3;
		#### HUMANS KILDE INVASION OP TIJD! MOET DE HIGHSCORE NOG GEMAAKT?
		$saql = "SELECT username, kills, location FROM invasions WHERE location='$S_location' ORDER BY KILLS DESC LIMIT $limin";
		$resultat = mysqli_query($mysqli,$saql);
		while ($recrd = mysqli_fetch_object($resultat))
		{
			$fameplus='';

			$goldreward=round(($recrd->kills* $record->combination)/$rank); $XTR='';  $XTR2='';  $mestext="The citizens of $recrd->location wanted to thank you for your efforts in helping the city at the last $record->dump event. You received $goldreward gold for your efforts.<BR>";

			$sql = "INSERT INTO messages (username, sendby, message, time, topic)
			  VALUES ('$recrd->username', '<B>Syrnia</B>', '$mestext', '$timee', 'Event at $S_location')";
			$rank=$rank+1;
			mysqli_query($mysqli,$sql) or die("DIE");
			mysqli_query($mysqli,"UPDATE users SET gold=gold+$goldreward $XTR2 WHERE username='$recrd->username' LIMIT 1") or die("error --> 5442343");
		}

	}
	  	$saql = "SELECT username, kills FROM invasions WHERE location='$S_location' ORDER BY KILLS DESC LIMIT $lim";
	   $resultat = mysqli_query($mysqli,$saql);
	    while ($recrd = mysqli_fetch_object($resultat))
		{
		 $rank=$rank+1; $extra=''; if($rank<=3){$extra='<U>';}  $output.="<tr><Td>$rank<Td>$extra$recrd->username<td>$recrd->kills";
		}
		$output.="</table>";
		if($var1!='showall'){ $output.="<a href='' onclick=\"locationText('events', 'showall');return false;\">Show the top 100 contributors.</a>"; }
	} #SKILLEVENT


}else if($record->type=='invasion'){ #EVENT:INVASION
################################
#############################


	if($record->monstersmuch>0 && $record->invasiontime>$timee){
		##### INVASION IS NU EN NOG ONBESLIST

		$timeleft=ceil(($record->invasiontime-$timee)/60);
		$output.= "<B>".$record->monsters."s are invading the town!</B> Stop them capturing this town and join the fight.<BR>You can not work at this town until the town has been saved. If we do not manage to save the town it will be in control of the ".$record->monsters."s.<BR>There are $record->monstersmuch ".$record->monsters."s left. <a href='' onclick=\"fighting('$record->monsters');return false;\">Attack</A> ($timeleft minutes left until capture.)";

	}elseif($record->invasiontime<>0 && $record->invasiontime<$timee && $record->monstersmuch>0){
		### INVASION WORD NU GEUPDATE; GEWONNEN DOOR DE MONSTERS

		$output.="It's too late! The ".$record->monsters."s have settled in $S_location, the humans have lost this city!<br />";
		$output.="<a href='' onclick=\"fighting('$record->monsters');return false;\">Attack</A> ($record->monstersmuch left)";
		/*mysqli_query($mysqli,"UPDATE locations SET rewarded=2 WHERE location='$S_location' AND rewarded = 0 LIMIT 1") or die("1331LOC3312");

        if(mysqli_affected_rows($mysqli) == 1)
        {
            $rewarded = 2;
            $mmuch=$record->monstersmuch*rand(6,20);
            mysqli_query($mysqli,"UPDATE locations SET monstersmuch=$mmuch, invasiontime=0 WHERE location='$S_location' LIMIT 1") or die("error --> 544343");

            ## MOETEN DE PIRATES REWAREDED?
            if($record->side=='Pirate'){
                $resultaat = mysqli_query($mysqli, "SELECT ID FROM locations WHERE side='Pirate' && rewarded=0 LIMIT 1");
                $aantalOver=0;     $aantalOver = mysqli_num_rows($resultaat);

                //Is this the last pirate fight ? Then remove the sidescore, which is used for rewarding pirates
                if($aantalOver==0){
                    $resultaat = mysqli_query($mysqli, "SELECT totalinvasions, failed FROM sides WHERE location='Skulls nose' LIMIT 1");
                    $recrd = mysqli_fetch_object($resultaat);
                    $total = $recrd->totalinvasions;
                    $failed = $recrd->failed;
                    $success = $total - $failed;

                    if($success > $failed)
                    {
                        $endMessage = "The invasion is over. We successfully captured $success of the $total towns we invaded. This was a great victory!";
                    }
                    else
                    {
                        $sAEql = "SELECT leader FROM sides WHERE location='Skulls nose' && leader<>''  limit 1";
                        $resultAEt = mysqli_query($mysqli,$sAEql);
                        while ($recQ = mysqli_fetch_object($resultAEt)) {
                            mysqli_query($mysqli,"INSERT INTO messages (username, sendby, message, time, topic)
                            VALUES ('$recQ->leader', '<B>Syrnia</B>', 'Arrr matey...<br />Your pirates committed mutiny because a fight was lost....<BR>
                            You are not the pirate leader anymore.<BR>', '$timee', 'Pirate mutiny')") or die("DIE");
                            mysqli_query($mysqli,"UPDATE sides SET kicklimit='-1' WHERE location='Skulls nose' LIMIT 1") or die("54353535");

                            $endMessage = "The invasion is over. We failed to capture $failed of the $total towns we invaded. This was a terrible defeat for $recQ->leader!";
                        }
                     }
                }

                $seEql = "SELECT username FROM users WHERE side='Pirate'";
                $resulteEt = mysqli_query($mysqli,$seEql);
                while ($p = mysqli_fetch_object($resulteEt))
                {
                    $sEql = "SELECT username, sidescore FROM stats WHERE username='$p->username' LIMIT 1";
                    $resultEt = mysqli_query($mysqli,$sEql);
                    while ($rece = mysqli_fetch_object($resultEt))
                    {

                        $gold=floor(($rece->sidescore/3)*rand(6,14)/10);
                        $fame=floor(((($rece->sidescore/3)/10)*rand(8,12)/10)/2);

                        if($rece->sidescore>0){
                            $pirateMessage="Arrr matey...<BR>Here is your share of our loot at $S_location:<BR>+$gold gold.<BR><BR>For helping the pirates you got -$fame fame.<BR>";
                        }else{
                            $pirateMessage="Arrr matey...<br />We have successfully invaded $S_location, however, because you did not contribute to the invasion you receive no gold and fame.<br />";
                        }
                        if($aantalOver==0){
                            $pirateMessage.="This invasion was the last invasion we have running at the moment.<br /><br/>$endMessage";
                        }
                        mysqli_query($mysqli,"UPDATE users SET gold=gold+'$gold',  fame=fame-'$fame' WHERE username='$rece->username' LIMIT 1") or die("error --> 544343 111");
                        $sql = "INSERT INTO messages (username, sendby, message, time, topic)
                        VALUES ('$rece->username', '<B>Syrnia</B>', '$pirateMessage', '$timee', 'Pirate attack - $S_location')";
                        mysqli_query($mysqli,$sql) or die("DIE");
                    }
                }

                if($aantalOver==0){
                    mysqli_query($mysqli,"UPDATE stats SET sidescore=0") or die("1331322312");
                }
            }#########

        }*/

	}elseif($record->monstersmuch>0 && $record->invasiontime==0){
		#### INVASIONS WAS GELUKT VOOR DE VIJAND, KILL ZE , niks speciaals




		$output.="The ".$record->monsters."s have captured this city, you can attack this settlement to regain it.<BR>";
		$output.="<a href='' onclick=\"fighting('Rat');return false;\">Attack the $record->monstersmuch ".$record->monsters."s</a>";



	} else{
		#### INVASIONS IS ALLANG OVER
	$output.="The citizens of $S_location want to thank the following brave warriors for their efforts in freeing the city from the ".$record->monsters."s<BR><Table><tr><td><B>Rank<td><B>Name<td><B>Kills";
	$lim=5; if($action=='events' && $var1=='showall'){$lim=200;}

	//Moet nog rewarden
	/*if($rewarded==0){
	 	mysqli_query($mysqli,"UPDATE locations SET rewarded=1 WHERE location='$S_location' AND rewarded=0 LIMIT 1") or die("54353535");
        if(mysqli_affected_rows($mysqli) == 1)
        {
            $rank='1'; $limin=3; if($record->side=='Pirate'){ $limin=500;}
            #### HUMANS KILDE INVASION OP TIJD! MOET DE HIGHSCORE NOG GEMAAKT?
            $saql = "SELECT username, kills, location FROM invasions WHERE location='$S_location' ORDER BY KILLS DESC LIMIT $limin";
            $resultat = mysqli_query($mysqli,$saql);
            while ($recrd = mysqli_fetch_object($resultat))
            {
                $fameplus='';
                if($record->side=='Pirate'){
                    $goldreward=ceil(($recrd->kills*2)*rand(7,13)/10);  $fameplus=ceil(($recrd->kills/2)*rand(8,12)/10);  $mestext="The citizens of $recrd->location wanted to thank you for your efforts in freeing the city from the ".$record->monsters."s. You got $goldreward gold bounty for your kills.<BR>You also got +$fameplus fame for fighting the pirates.";   $XTR2=", fame=fame+$fameplus";

                }else{
                    $goldreward=round(($recrd->kills*5)/$rank); $XTR='';  $XTR2='';  $mestext="The citizens of $recrd->location wanted to thank you for your efforts in freeing the city from the ".$record->monsters."s. You got $goldreward gold bounty for your kills.<BR>";
                }
                $sql = "INSERT INTO messages (username, sendby, message, time, topic)
                  VALUES ('$recrd->username', '<B>Syrnia</B>', '$mestext', '$timee', 'Saving $S_location')";
                $rank=$rank+1;
                mysqli_query($mysqli,$sql) or die("DIE");
                mysqli_query($mysqli,"UPDATE users SET gold=gold+$goldreward $XTR2 WHERE username='$recrd->username' LIMIT 1") or die("error --> 5442343");
            }

            #### PIRATES
            if($record->side=='Pirate'){
                $resultaat = mysqli_query($mysqli, "SELECT ID FROM locations WHERE side='Pirate' && rewarded=0 LIMIT 1");
                $aantalOver=0;     $aantalOver = mysqli_num_rows($resultaat);

                mysqli_query($mysqli,"UPDATE sides SET failed=failed+1 WHERE location='Skulls nose'") or die("1331322312");

                //Is this the last pirate fight ? Then remove the sidescore, which is used for rewarding pirates
                if($aantalOver==0){
                    mysqli_query($mysqli,"UPDATE stats SET sidescore=0") or die("1331322312");

                    $resultaat = mysqli_query($mysqli, "SELECT totalinvasions, failed FROM sides WHERE location='Skulls nose' LIMIT 1");
                    $recrd = mysqli_fetch_object($resultaat);
                    $total = $recrd->totalinvasions;
                    $failed = $recrd->failed;
                    $success = $total - $failed;

                    if($success > $failed)
                    {
                        $endMessage = "The invasion is over. We successfully captured $success of the $total towns we invaded. This was a great victory!";
                    }
                    else
                    {
                        $sAEql = "SELECT leader FROM sides WHERE location='Skulls nose' && leader<>''  limit 1";
                        $resultAEt = mysqli_query($mysqli,$sAEql);
                        while ($recQ = mysqli_fetch_object($resultAEt)) {
                            mysqli_query($mysqli,"INSERT INTO messages (username, sendby, message, time, topic)
                            VALUES ('$recQ->leader', '<B>Syrnia</B>', 'Arrr matey...<br />Your pirates committed mutiny because a fight was lost....<BR>
                            You are not the pirate leader anymore.<BR>', '$timee', 'Pirate mutiny')") or die("DIE");
                            mysqli_query($mysqli,"UPDATE sides SET kicklimit='-1' WHERE location='Skulls nose' LIMIT 1") or die("54353535");

                            $endMessage = "The invasion is over. We failed to capture $failed of the $total towns we invaded. This was a terrible defeat for $recQ->leader!";
                        }
                     }
                }

                $resulteEt = mysqli_query($mysqli,"SELECT username FROM users WHERE side='Pirate'");
                while ($p = mysqli_fetch_object($resulteEt))
                {
                    $resultEt = mysqli_query($mysqli,"SELECT username, sidescore FROM stats WHERE username='$p->username' LIMIT 1");
                    while ($rece = mysqli_fetch_object($resultEt))
                    {
                        $pirateMessage="Arrr matey...<br />We have failed to invade $S_location...<br />";

                        if($aantalOver==0){
                            $pirateMessage.="This invasion was the last invasion we have running at the moment.<br /><br/>$endMessage";
                        }else{
                            $pirateMessage.="We still have one or more invasions running right now!<br />";
                        }
                        $sql = "INSERT INTO messages (username, sendby, message, time, topic)
                        VALUES ('$rece->username', '<B>Syrnia</B>', '$pirateMessage', '$timee', 'Pirate attack - $S_location')";
                        mysqli_query($mysqli,$sql) or die("DIE");
                    }
                }

            } ## PIRATE
        }

	}*/
	  	$saql = "SELECT username, kills FROM invasions WHERE location='$S_location' ORDER BY KILLS DESC LIMIT $lim";
        $resultat = mysqli_query($mysqli,$saql);
        $rank = 0;
	    while ($recrd = mysqli_fetch_object($resultat))
		{
		 $rank=$rank+1; $extra=''; if($rank<=3){$extra='<U>';}  $output.="<tr><Td>$rank<Td>$extra$recrd->username<td>$recrd->kills";
		}
		$output.="</table>";
		if($var1!='showall'){ $output.="<a href='' onclick=\"locationText('events', 'showall');return false;\">Show the top 100 warriors.</a>"; }
	} #INVASION



#################################
}elseif($record->type=='chest'){ #EVENT: CHEST

##################################
if($rewarded=='' OR $rewarded==0){ #rewarded
$output.="<BR><BR>A strange chest has been found...since nobody manages to open it the first person to open it is allowed to keep the contents of the chest.<BR>";

  	$saql = "SELECT work, dump FROM users WHERE username='$S_user' LIMIT 1";
   	$resultat = mysqli_query($mysqli,$saql);
    while ($rec = mysqli_fetch_object($resultat))
	{

	if($var1=='guessXlock'){
		$guess=$var2;
	}
	if($rec->work=='chest' && $rec->dump<($timee+1)){
		if($guess>=1 && is_numeric($guess) && $guess<=$record->invasiontime){
			if($guess==$record->combination){
				$output.="<B>The chest opened! You used the right combination!!</B><BR>";
				$output.="Inside the chest you find <font color=yellow>$record->monstersmuch $record->monsters</font>!";

				if($record->monsters=='Gold'){
					getGold($S_user, $record->monstersmuch);
				}else{
					/*	$saql = "SELECT type FROM items WHERE name='$record->monsters' LIMIT 1";
			   		$resultat = mysqli_query($mysqli,$saql);
			    	while ($rec = mysqli_fetch_object($resultat))
					{
					 	$itemType=$record->type;
					}
					*/
					addItem($S_user, $record->monsters, $record->monstersmuch, $record->itemtype, '', '', 1, '');
				}

				mysqli_query($mysqli,"UPDATE locations SET rewarded='1', itemtype='$S_user' WHERE location='$S_location' LIMIT 1") or die("35353");
			 } else{
			  	$nextGuessIn=20;
				$timeleft=$timee+$nextGuessIn;
				mysqli_query($mysqli,"UPDATE users SET thieving=thieving+4, work='chest', dump='$timeleft' WHERE username='$S_user' LIMIT 1") or die("4242");
				$levelArray=addExp($levelArray, 'thieving', 4);
				$output.="Too bad your guess '$guess' was wrong...you did gain 4 thieving exp.<BR>";
				$output.="You can guess a lock combination between 1 and $record->invasiontime...<BR>";
				$output.="You can try again in:<BR>";
				echo"setTimeout(\"locationTextCounter('eventTimer', (new Date().getTime()+$nextGuessIn*1000), '$timee', 'events');\", 1000);";
				$output.="<input type=\"text\" size=\"4\" id='eventTimer' value='$nextGuessIn' title=0>";
				// style=\"background-color: #cccccc; border: 0 solid #000000\" class=Moven
			}
		} else{
			$output.="You can guess a lock combination between 1 and $record->invasiontime...";
			$output.="<form onsubmit=\"locationText('events', 'guessXlock', $('guessCombo').value);return false;\">";
			$output.="<input type=text id=guessCombo class=input><input type=submit value=Open class=button></form>";
            echo "setTimeout(\"if($('chatMessage').value==''){\$('guessCombo').focus();}\", 500);";
		}
	} else{ # NOT GUESS
		if($rec->work!='chest'){
			if($rec->work=='' || $var1=='startGuess'){
			 	$timeSeconds=20;
			 	$timeleft=$timee+$timeSeconds;
				mysqli_query($mysqli,"UPDATE users SET work='chest', dump='$timeleft' WHERE username='$S_user' LIMIT 1") or die("4243224");
			}else{
				$timeleft=-1;
			}
		}else{
			$timeSeconds=$rec->dump-time();
		}

		if($timeleft==-1){
			$output.="Would you like to start guessing the combination?<br />";
			$output.="<a href='' onclick=\"locationText('events', 'startGuess');return false;\">Yes please!</a>";
		}else{
			$output.="You can try opening the lock in:<br />";
			echo"setTimeout(\"locationTextCounter('eventTimer', (new Date().getTime()+$timeSeconds*1000), '$timee', 'events');\", 1000);";
			$output.="<input type=\"text\" size=\"4\" id='eventTimer' value='$timeSeconds' title=0>";
		}
	}
} # MYSQL USERS
} else{
 	 $output.="<BR><BR>The last chest which was found here was successfully opened by $record->itemtype.";
}
# REWARDED


#################################
}elseif($record->type=='contest'){ #EVENT: CONTESTS, BIGGEST FISH, XMAS TREE ETC
##################################
if($record->invasiontime>time()){ ## MENSEN KUNNEN NOG SUBMITTE

$output.="The citizens of $S_location started a contest: The one to collect the best $record->monsters will be paid $record->monstersmuch gold.<BR>";
$output.="The second and thirth best entries will be paid out ".floor($record->monstersmuch/2)." and ".floor($record->monstersmuch/3)." gold.<BR>";
$output.="The contest ends in ".(ceil(($record->invasiontime-time())/3600))." hours.<BR>";
$output.="<BR>";
$output.="<form action='' method=post>";
$output.="<input type=submit value='Submit a $record->monsters' onclick=\"locationText('events', 'submitItem');return false;\"></form>";

if($action=='events' && $var1=='submitItem'){
	$resultaat = mysqli_query($mysqli, "SELECT ID FROM items_inventory WHERE username='$S_user'  && name='$record->monsters' AND itemupgrade = '' LIMIT 1");
	$aantal = mysqli_num_rows($resultaat);
	if($aantal>0){
		removeItem($S_user, $record->monsters, 1, '', '', 1);
		$aant=1;  $try=0;
		while($aant<>0 && $try<100){
			$value=rand(1,$record->combination);
		 	$resultaat = mysqli_query($mysqli, "SELECT ID FROM invasions WHERE location='$S_location' && kills='$value' LIMIT 1");
		  	$aant = mysqli_num_rows($resultaat);
		  	$try++;
		}

		$sql = "INSERT INTO invasions (eventID, username, location, kills)
		 VALUES ('$eventID', '$S_user', '$S_location', '$value')";
		mysqli_query($mysqli,$sql) or die("DIE");
		$output.="<B>Your $record->monsters was ".($value/100)." $record->dump!</B><BR>";
	}else{
		$output.="<B>You do not have any $record->monsters!</B><BR>";
	}
}

$lim=25; if($action=='events' && $var1=='showall'){$lim=100;}

$output.="<BR><table>"; $rank=0;
$saql = "SELECT username, kills FROM invasions WHERE location='$S_location' ORDER BY KILLS DESC LIMIT $lim";
   $resultat = mysqli_query($mysqli,$saql);
    while ($recrd = mysqli_fetch_object($resultat))
	{
	 $rank=$rank+1;
	 if($rank<=3){$extra='<U>';}
	 $output.="<tr><Td>$rank<Td>$extra$recrd->username<td>".($recrd->kills/100)." $record->dump";
	}
$output.="</table>";
if($var1!='showall'){ $output.="<a href='' onclick=\"locationText('events', 'showall');return false;\">Show the top 100 contestants.</a>"; }

}else{ ## BEGIN CONTEST OVER

	if($rewarded==0){
		$rank=1;
		$saql = "SELECT username, kills, location FROM invasions WHERE location='$S_location' ORDER BY KILLS DESC LIMIT 3";
		$resultat = mysqli_query($mysqli,$saql);
		while ($recrd = mysqli_fetch_object($resultat))
		{
			$goldreward=round($record->monstersmuch/$rank);
            $rank=$rank+1;
			$XTR='';  $XTR2='';  $mestext="The citizens of $recrd->location wanted to thank you for providing them a $recrd->kills $record->dump $record->monsters.<BR>They paid you $goldreward gold.<BR>";
			$sql = "INSERT INTO messages (username, sendby, message, time, topic)
			  VALUES ('$recrd->username', '<B>Syrnia</B>', '$mestext', '$timee', '$record->monsters contest')";
			mysqli_query($mysqli,$sql) or die("DIE");
			mysqli_query($mysqli,"UPDATE users SET gold=gold+$goldreward $XTR2 WHERE username='$recrd->username' LIMIT 1") or die("error --> 5442343");
		}
		mysqli_query($mysqli,"UPDATE locations SET rewarded='1', itemtype='$S_user' WHERE location='$S_location' LIMIT 1") or die("35353");
	}

	$output.="The $record->monsters contest is over.<BR>";
	$output.="The best 100 entries are displayed below.<BR>";
	$output.="The best 3 entries have been rewarded by the citizens of $S_location.<BR>";
	$output.="<BR>";
	$output.="<table>";
	$rank=0;
	$lim=5; if($action=='events' && $var1=='showall'){$lim=100;}

	$saql = "SELECT username, kills FROM invasions WHERE location='$S_location' ORDER BY KILLS DESC LIMIT $lim";
	   $resultat = mysqli_query($mysqli,$saql);
	    while ($recrd = mysqli_fetch_object($resultat))
		{
		 $rank=$rank+1;
		 if($rank<=3){$extra='<U>';}
		 $output.="<tr><Td>$rank<Td>$extra$recrd->username<td>".($recrd->kills/100)." $record->dump";
		}
	$output.="</table>  ";
	if($var1!='showall'){ $output.="<a href='' onclick=\"locationText('events', 'showall');return false;\">Show the top 100 contestants.</a>"; }
}## EINDE CONTEST OVER

##################################
}else if($record->type=='collect'){ #EVENT: CONTESTS, BIGGEST FISH, XMAS TREE ETC
##################################
if($record->monstersmuch<$record->combination){ ## MENSEN KUNNEN NOG SUBMITTE

$output.="The citizens of $S_location are collecting resources for: \"$record->monsters\"<br />";
$output.="So far $record->monstersmuch/$record->combination $record->dump has been collected<br />";
$output.="<br />";
$output.="<form action='' method=post>";
$output.="<input type=text value='0' size=3 id='donateMuch'>";
$output.="<input type=submit value='Donate $record->dump' onclick=\"locationText('events', 'submitItem', $('donateMuch').value);return false;\"></form>";

if($action=='events' && $var1=='submitItem' && is_numeric($var2) && $var2>0){
	$collectLeft=$record->combination - $record->monstersmuch;
	if($var2>$collectLeft){ $var2=$collectLeft; }
	$inventoryAmount = itemAmount($S_user, $record->dump, '', '', '');
	if($inventoryAmount>=$var2 && $var2>0){
		$collectLeft-=$var2;
		removeItem($S_user, $record->dump, $var2, '', '', 1);

		$resultaat = mysqli_query($mysqli, "SELECT ID FROM invasions WHERE location='$S_location' && username='$S_user' LIMIT 1");
	 	$aant = mysqli_num_rows($resultaat);
  		if($aant==1){
  			  $sql = "UPDATE invasions SET kills=kills+'$var2' WHERE location='$S_location' && username='$S_user' LIMIT 1";
			mysqli_query($mysqli,$sql) or die("DIE");
  		}else{
			$sql = "INSERT INTO invasions (eventID, username, location, kills)
			 VALUES ('$eventID', '$S_user', '$S_location', '$var2')";
			mysqli_query($mysqli,$sql) or die("DIE");
		}
		 $sql = "UPDATE locations SET monstersmuch=monstersmuch+'$var2' WHERE location='$S_location' && rewarded=0 LIMIT 1";
			mysqli_query($mysqli,$sql) or die("DIE");

		$output.="<B>You have contributed $var2 $record->dump!</B><BR>";
	}else{
		$output.="<B>You do not have $var2 $record->dump!</B><BR>";
	}

	$output.="<br /><b>We need $collectLeft more $record->dump.</b><br />";
}

$lim=25;
if($action=='events' && $var1=='showall'){$lim=100;}

$output.="<BR><table>"; $rank=0;
$saql = "SELECT username, kills FROM invasions WHERE location='$S_location' ORDER BY KILLS DESC LIMIT $lim";
   $resultat = mysqli_query($mysqli,$saql);
    while ($recrd = mysqli_fetch_object($resultat))
	{
	 $rank=$rank+1;
	 if($rank<=3){$extra='<U>';}
	 $output.="<tr><Td>$rank<Td>$extra$recrd->username<td>".($recrd->kills)." $record->dump";
	}
$output.="</table>";
if($var1!='showall'){ $output.="<a href='' onclick=\"locationText('events', 'showall');return false;\">Show the top 100 contestants.</a>"; }

}else{ ## BEGIN COLLECT OVER

	if($rewarded==0){
		$rank=1;
		$saql = "SELECT username, kills, location FROM invasions WHERE location='$S_location' ORDER BY KILLS DESC LIMIT 3";
		$resultat = mysqli_query($mysqli,$saql);
		while ($recrd = mysqli_fetch_object($resultat))
		{
			$mestext="The citizens of $recrd->location wanted to thank you for providing them $recrd->kills $record->dump.<br />If any reward was announced, you will receive it within 48 hours.<BR>";
			$sql = "INSERT INTO messages (username, sendby, message, time, topic)
			  VALUES ('$recrd->username', '<B>Syrnia</B>', '$mestext', '$timee', '$record->dump collection')";     $rank=$rank+1;
			mysqli_query($mysqli,$sql) or die("DIE");
		}
		mysqli_query($mysqli,"UPDATE locations SET rewarded='1' WHERE location='$S_location' LIMIT 1") or die("35353");
	}

	$output.="The $record->dump collection is over, we've collected $record->combination $record->dump.<BR>";
	$output.="The best donators are displayed below.<BR>";
	$output.="<br />";
	$output.="<table>";
	$rank=0;
	$lim=5; if($action=='events' && $var1=='showall'){$lim=100;}

	$saql = "SELECT username, kills FROM invasions WHERE location='$S_location' ORDER BY KILLS DESC LIMIT $lim";
	   $resultat = mysqli_query($mysqli,$saql);
	    while ($recrd = mysqli_fetch_object($resultat))
		{
		 $rank=$rank+1;
		 if($rank<=3){$extra='<U>';}
		 $output.="<tr><Td>$rank<Td>$extra$recrd->username<td>".($recrd->kills)." $record->dump";
		}
	$output.="</table>  ";
	if($var1!='showall'){ $output.="<a href='' onclick=\"locationText('events', 'showall');return false;\">Show the top 100 contestants.</a>"; }

}# END VAN COLLECT



} #END EVENTS
} #QUERY

$output .= checkGroupFight();

}#DEFINED & USER
?>