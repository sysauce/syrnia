<?
if(defined('AZtopGame35Heyam')){


if($var1=='exchange'){
	$output.="<B>The desert battle mage</b> - Medal exchange<br /><br />";

	$exchangeItems[1]['itemID']=820;//Equites
	$exchangeItems[2]['itemID']=821;
	$exchangeItems[3]['itemID']=822;
	$exchangeItems[4]['itemID']=823;
	$exchangeItems[5]['itemID']=824;//Retiarii
	$exchangeItems[6]['itemID']=825;
	$exchangeItems[7]['itemID']=826;
	$exchangeItems[8]['itemID']=827;
	$exchangeItems[9]['itemID']=828;//Hop
	$exchangeItems[10]['itemID']=829;
	$exchangeItems[11]['itemID']=830;
	$exchangeItems[12]['itemID']=831;
	$exchangeItems[13]['itemID']=832;//Samnite
	$exchangeItems[14]['itemID']=833;
	$exchangeItems[15]['itemID']=834;
	$exchangeItems[16]['itemID']=835;

	$output.="Would you like to exchange one Desert arena medal and 1000 gold for a gladiator worthy prize?<br /><a href='' onclick=\"locationText('arena', 'exchange', 'yes');return false;\">Yes please</a><BR><BR>";

	if($var2=='yes'){
		if(hasGold($S_user)<1000){
			$output.="Sorry, you need 1000 gold!<br />";
		}else if(itemAmount($S_user, "Desert arena medal", "medal", "", "")<1  ){
			$output.="Sorry, you need a Desert arena medal!<br />";
		}else{
			$itemID=$exchangeItems[rand(1,16)]['itemID'];
			$sql = "SELECT name,type FROM items WHERE ID='$itemID' LIMIT 1";
  			$resultaat = mysqli_query($mysqli, $sql);
    		while ($record = mysqli_fetch_object($resultaat))
			{
				payGold($S_user, 1000);
	   			removeItem($S_user, "Desert arena medal", 1, '', '', 1);

	   			addItem($S_user, $record->name, 1, $record->type, '', '', 1);

				$output.="You exchanged your Desert arena medal and 1000 gold for [$record->name]!<br />";
			}
		}
	}

}else{

	$output.="<B>The desert battle mage</b><BR>";


  $sql = "SELECT time,started,ID, minLevel, maxLevel FROM arena WHERE winner='' && time>=($timee-3600) ORDER BY time asc  LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
	 	$minLevel=$record->minLevel;
		$maxLevel=$record->maxLevel;
		$arenaMatchID=$record->ID;
		$matchStartTime=$record->time;
		$started=$record->started;
	}


   	$output.="<a href='' onclick=\"locationText('arena', 'exchange');return false;\">Exchange desert arena medals for prizes</a><BR><BR>";


if($arenaMatchID){

	if($started==0 && $matchStartTime>$timee){// First next fight didn't start yet

		if($matchStartTime-900<$timee && $matchStartTime>$timee ){ //Begins within 15 minutes

			if($var1=='enter' && $combatL>=$minLevel && $combatL<=$maxLevel){ //Join
				$resultaaat = mysqli_query($mysqli,  "SELECT ID FROM items_inventory WHERE (type='open' OR type='locked') && username='$S_user' LIMIT 1");
				$aant = mysqli_num_rows($resultaaat);
				if($aant==0){
					   $resultaaat = mysqli_query($mysqli,  "SELECT ID FROM items_inventory WHERE type='cooked food' && username='$S_user' LIMIT 1");
					   $aant = mysqli_num_rows($resultaaat);

					   $resultaaat2 = mysqli_query($mysqli,  "SELECT items.type FROM items_wearing join items on items_wearing.name=items.name WHERE items_wearing.type='trophy' && items_wearing.username='$S_user' && (items.type='cooked food' OR items.type='open' OR items.type='locked') LIMIT 1");
					   $aant2 = mysqli_num_rows($resultaaat2);



					   if($aant2>0){
					   		$output.="<B>You've got a trophy on you which you are not allowed to bring to the arena. Stop trying to smuggle food ;).";
							$output.="Please get rid of the trophy and come back.<BR><BR></B>";
					   }else  if($aant==0){
							$to='Arena tent';
							$S_location=$to;
							$S_mapNumber=1;
							mysqli_query($mysqli, "UPDATE users SET location='$to', dump='', dump2='' WHERE username='$S_user' LIMIT 1") or die("error --> 1113");
							mysqli_query($mysqli, "UPDATE arena SET players=(SELECT COUNT(ID) FROM users WHERE location = 'Arena tent') WHERE time>='$timee' order by time asc LIMIT 1") or die("error --> 1113");
							include_once('includes/mapData.php');
							$output.="You are entering the arena tent!<BR>";
							echo"updateCenterContents('move', '$to');";
							echo "updateCenterContents('loadLayout', 1);";

						}else{ #FOOD
							$output.="<B>You've got cooked food with you, which is not allowed in the arena.<BR>";
							$output.="Please get rid of the food and come back.<BR><BR></B>";
						}
				}else{ #OPEN(CHEST WITH FOOD)
					$output.="<B>You've got a locked container with you which could contain food, this is not allowed in the arena.<BR>";
					$output.="Please get rid of the container and come back.<BR><BR></B>";
				}

			}


			$output.="You see a lot of people listening to a mage, you approach the scene:<BR>";
			$output.="<BR>";
			$output.="<i>I have come from an country far away and am inviting you to join the event another mage and I have organised.<BR>";
			$output.="The other mage is at another location recruiting fighters too...<BR>";
			$output.="Who of you dares to enter our battle arena?<BR>";
			$output.="We will give a nice reward to the last man or woman standing!<BR>";
			$output.="There is no risk because you will be protected by our magic; if you are about to die you will be teleported back to this place.<BR>";
			$output.="So what are you waiting for? Go inside the tent to enter the arena queue.<BR>";
			$output.="This will be the first organised fight ever!<BR>";
			$output.="</i><BR>";
			$output.="<small>-In the arena you will fight opponents from all over the world (yes, pirates and Syrnians!)<BR>";
			$output.="-When you die you will be back at this place and you will not lose your inventory.<BR>";
			$output.="-You may not take food to the arena, you can however take uncooked food and cook it inside the arena.<BR></small><BR>";

			 if($combatL>=$minLevel && $combatL<=$maxLevel){
			  $output.="Do you want to go to the arena?<BR><a href='' onclick=\"locationText('arena', 'enter');return false;\">Enter the arena tent.</a><BR>";
			  }else{
			   $output.="You can not join this fight, it's for combat levels $minLevel-$maxLevel only.<br/>";
			}

			$output.="<BR>";
			$output.="<B>The fight will start in:</B>";

			$time=$matchStartTime-$timee;


			echo"setTimeout(\"locationTextCounter('arenaCounter', (new Date().getTime()+2+$time*1000), '$timee', '$action', '', '', '');\", 1000);";
			$output.="<input type=\"text\" readonly size=\"4\" id='arenaCounter' style=\"background-color: #660000; border: 0 solid #333333; font-size : 24px;color: #ffffff;\" value='".($time+2)."' title='$timee'>";



			}else{
				$output.="You will be able to apply for a fight 15 minutes before the fight begins.<BR><BR>";
			}


		}else{
			$output.="There is a fight at the arena right now.<BR>";
			$output.="Please come back later if you want to enter the arena.<BR>";

			if($matchStartTime<($timee-1800)){ ## TE LANG??

				$output.="<BR>The current arena fight has been cancelled, the combatants took to long to kill eachother.<br />";

				mysqli_query($mysqli, "UPDATE arena SET winner='The fight took too long and had been cancelled' WHERE ID=$arenaMatchID LIMIT 1") or die("error --> 1113");

				   $sl = "SELECT username,ID,side FROM users WHERE location='%arena%'";
				   $resultat = mysqli_query($mysqli, $sl);
				    while ($rec = mysqli_fetch_object($resultat))
					{
					    if($rec->side=='Pirate'){$SPAWN='Toothen';} else{$SPAWN='Kinam';}
					   	mysqli_query($mysqli, "UPDATE users SET location='$SPAWN' WHERE ID='$rec->ID'") or die("err1or --> 1df234d1");
				  	}
					mysqli_query($mysqli, "DELETE FROM pvp WHERE location like'%arena%' ") or die("err1or --> 1d234fd1: ");


			} ## TE LANG ??

		}


	$output.="<BR><BR><B>Scheduled fights:</B><BR>";
    $remoteBattlemage = "<B>Scheduled fights:</B><BR>";
	$timeout=$timee+3600*24*7*1; //1 week
		 $sql = "SELECT time, minLevel, maxLevel FROM arena WHERE time>'$timee' && time<'$timeout' ORDER BY time asc LIMIT 25";
	   $resultaat = mysqli_query($mysqli, $sql);
	    while ($record = mysqli_fetch_object($resultaat)) {
            $output.= "At ".date("Y-m-d H:i", $record->time)." ";
            $remoteBattlemage.= "At ".date("Y-m-d H:i", $record->time)." ";
            if($record->maxLevel>0){
                $output.="Level: $record->minLevel - $record->maxLevel";
                $remoteBattlemage.="Level: $record->minLevel - $record->maxLevel";
            }
            $output.="<br />";
            $remoteBattlemage.="<br />";
        }
}else{
	$output.="There are no scheduled fights at the moment, please come back later.<BR>";
	$remoteBattlemage = "There are no scheduled fights at the moment.<BR>";
}


$output.="<BR><BR><B>Last 25 fights:</B><BR><table>";
$remoteBattlemage.="<BR><BR><B>Last 25 fights:</B><BR><table>";
  $sql = "SELECT time,players,winner, minLevel, maxLevel FROM arena WHERE winner<>'' ORDER BY time desc LIMIT 25";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
		$output.= "<tr height=40 valign=top><td>";
		$output.="<B>".date("Y-m-d H:i", $record->time)."</B></td><td>";
		$remoteBattlemage.= "<tr height=40 valign=top><td>";
		$remoteBattlemage.="<B>".date("Y-m-d H:i", $record->time)."</B></td><td>";
		if($record->minLevel && $record->maxLevel>=0){
            $output.="<b>Levels: $record->minLevel - $record->maxLevel</b><br />";
            $remoteBattlemage.="<b>Levels: $record->minLevel - $record->maxLevel</b><br />";
            }
		 $output.="$record->winner ($record->players players)";
		 $remoteBattlemage.="$record->winner ($record->players players)";

	}
$output.="</table>";
$remoteBattlemage.="</table>";

$remoteBattlemage = str_replace("'", "''", $remoteBattlemage);

mysqli_query($mysqli, "UPDATE forummessages SET message='" . $remoteBattlemage . "' WHERE ID IN (1274899, 1298825) AND username = 'Battle Mage'") or die("111111111 $much--$get aaa");
mysqli_query($mysqli, "UPDATE forumtopics SET lastreply='$time' WHERE ID IN (202287, 205946) AND username = 'Battle Mage'") or die("111111111 $much--$get aaa");

$sql = "";


}//Medal exchange or main
 }//include
?>