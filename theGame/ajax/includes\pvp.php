<?
if(defined('AZtopGame35Heyam') && $S_user){
$output='';
include_once('levels.php');

$time=$timee=time();

$sql = "SELECT location, dump3 FROM users WHERE username='$S_user' LIMIT 1";
$resultaat = mysqli_query($mysqli,$sql);
while ($record = mysqli_fetch_object($resultaat))
{
   $S_location=$record->location;
   $dump3NEXT=$record->dump3;
}

if(!strstr($S_location, 'The Outlands') && !strstr($S_location, 'Desert arena')){
	$sql = "SELECT mapNumber FROM locationinfo WHERE locationName='$S_location' LIMIT 1";
	$resultaat = mysqli_query($mysqli,$sql);
	while ($record = mysqli_fetch_object($resultaat))
	{
	 	$S_mapNumber=$record->mapNumber;
	}
}

if($S_mapNumber==14){
	$ARENA=1;
}

if($S_mapNumber!=3 && $S_mapNumber!=14){ //Not in pvp area
 	include('mapData.php');
 	include_once('rebuildInventory.php');
	echo"updateCenterContents('loadLayout', 1);";
	echo"$('statsHPText').innerHTML=\"$hp\";";
	if($S_mapNumber==3){echo"if(\$('lastMovedItem')){\$('lastMovedItem').remove();}";}
	include_once('wearstats.php');
	wearStats($S_user, 1);
	exit();
}

 	function updatePVPlog($lastTime){

	 	 global $mysqli, $S_location;

	 	if(!$lastTime){
	 	 	$lastTime=$timee-3600;
		}

        if(!isset($_SESSION['S_lastPVPID']))
        {
            $_SESSION['S_lastPVPID']=0;
        }

		echo updatePlayers();
        //echo "setTimeout(\"pvpPlayers();\", 500);";
        echo "setTimeout(\"pvpPlayers();\", 1000);";
        //echo "setTimeout(\"pvpPlayers();\", 1500);";

		$pvpTime=$lastTime;
	 	//$sql = "SELECT time, text FROM pvp WHERE location='$S_location' && time>'$pvpTime' ORDER BY ID DESC LIMIT 25";
	 	$sql = "SELECT ID, time, text FROM pvp WHERE location='$S_location'" . ($_SESSION['S_lastPVPID'] > 0 ? " AND ID > " . $_SESSION['S_lastPVPID'] : "") . " ORDER BY ID DESC LIMIT 25";
		$resultaat = mysqli_query($mysqli,$sql);
		while ($record = mysqli_fetch_object($resultaat))
		{
            if($record->ID > $_SESSION['S_lastPVPID'])
            {
                $_SESSION['S_lastPVPID'] = $record->ID;
            }

            $combatLog.=date("Y-m-d H:i:s", $record->time)." $record->text<br/>";
		}

		if($combatLog){
			$combatLog=str_replace('"','\"', $combatLog);
			echo"\$('combatLog').innerHTML=\"$combatLog\"+$('combatLog').innerHTML;";

			if(strstr($combatLog, " killed ")){
				RebuildDropList();
				echo "recreateSortable('playerInventory');";
			}
		}


		return time();
	}


if($var2=='player'){

	include('player.php');

}else if($var2=='log'){

	$_SESSION['S_lastPVPupdate']=updatePVPlog($_SESSION['S_lastPVPupdate']);

}else if($var2=='players'){

	echo updatePlayers();

}else if($action=='smith'){

	include('locations/textincludes/smithing.php');

}else if($var2=='work'){

	include('work.php');

}else if($var2=='attack'){

 	$attacking=$attackname=$var3; //user ID

#### VECHTEN
if($attacking && $attacking!=$S_user && $dump3NEXT<=$time){
	$text=''; $dood=''; $checker=0;
	$sql = "SELECT hp, strength, attack, defence, health, side FROM users WHERE username='$attacking' && location='$S_location' LIMIT 1";
	$resultaat = mysqli_query($mysqli,$sql);
	while ($record = mysqli_fetch_object($resultaat))
	{
		$otherside=$record->side;
		$checker=1;
		$enemyhealthl=floor(pow($record->health, 1/3.507655116));
		$enemyattackl=floor(pow($record->attack, 1/3.507655116));
		$enemydefencel=floor(pow($record->defence, 1/3.507655116));
		$enemystrengthl=floor(pow($record->strength, 1/3.507655116));
		$enemylevel=floor($enemyattackl/3+$enemydefencel/3+$enemystrengthl/3+$enemyhealthl/5);
		$enemyhp=$record->hp;
		$enemymaxhp=floor($enemyhealthl*1.1+3);

		$userName="$attackname";
		include('itemStats.php');
		$enemypower=$power;
		$enemyaim=$aim;
		$enemyarmour=$armour;
	}
	if($enemyhp<1){
		//It's already dead (by another players kill), and now being respawned
		echo updatePlayers();
		exit();
	}
	if($checker!=1){
	 	echo updatePlayers();
	 	exit();
	}

	### ATTACK CODE
	$monster=0;
	$youstrlevel=$strengthl;
	$youpower=$S_power;
	$youattackl=$attackl;
	$youaim=$S_aim;
	$hisdef=$enemydefencel;
	$hisarmour=$enemyarmour;

	## ECHTA CODE, VARS HIERBOVE
	$strengthdam=floor(($youstrlevel+$youpower)*0.35)+1; #max damage
	$attackdam=floor(($youattackl+$youaim)*0.35)+1;       #damage attack level
	$attstrratio=($attackdam/2)/$strengthdam*100; #(normally = 50%)
	if($attstrratio>100){$attstrratio=100;}
	$hitbelow=rand(0,$attstrratio);
	$hitup=rand($attstrratio,100);
	$hitpercent=rand($hitbelow,$hitup);
	$hit=round($strengthdam*($hitpercent/100));
	$enemydefhit=($hisdef+$hisarmour*0.6)*0.35;
	$enemyattdefratio=($enemydefhit/2)/$attackdam*100;
	if($enemyattdefratio>100){$enemyattdefratio=100;}
	$blockbelow=rand(($enemyattdefratio/10),$enemyattdefratio);
	$blockup=rand($enemyattdefratio,100);
	$blockpercent=100-rand($blockbelow,$blockup);
	$hit=round($hit*($blockpercent/100));
	### ATTACK CODE ## HP HIERONDER
	### ATTACK CODE
	# aim : attack =1:1
	# power:str =1:1
	# defence:armour=1:1.66
	$enemyhp=$enemyhp-$hit;
	if($enemyhp<1){$enemyhp=0; }
	mysqli_query($mysqli,"UPDATE users SET hp='$enemyhp' WHERE username='$attacking' LIMIT 1") or die("err1or --> --31");


	$text="<u>$S_user</u>($level) attacked $attackname, and did $hit damage. $attackname had $enemyhp HP left.<br />";
	$logLocation=$S_location;
	if($enemyhp<1){

			$enemyhp=0;
			if($otherside=='Pirate'){$SPAWN='Crab nest';} else{$SPAWN='Sanfew';}
			if($ARENA){
			 	if($otherside=='Pirate'){
				  	$SPAWN='Toothen';
				} else{
				 	$SPAWN='Kinam';
				}
			}
			mysqli_query($mysqli,"UPDATE users SET location='$SPAWN', hp='$enemymaxhp' WHERE username='$attacking' LIMIT 1") or die("err1or --> 1231aaaaa11");
			$droptime=time();
			$dood="$S_user killed $attackname<br />";
			mysqli_query($mysqli,"UPDATE stats SET playerkills=playerkills+1 WHERE username='$S_user' LIMIT 1") or die("err2o22   ");
			mysqli_query($mysqli,"UPDATE stats SET playerdeaths=playerdeaths+1 WHERE username='$attackname' LIMIT 1") or die("err2o22   ");
			if($ARENA==''){####### GEEN ARENA

				 if($attackname!='M2H'){
				 	mysqli_query($mysqli,"DELETE FROM items_inventory  WHERE username='$attackname' && type='quest'") or die("err1or --> kwe 1dfd1");
					mysqli_query($mysqli,"DELETE FROM quests WHERE username='$attackname' && completed=0") or die("error report this bug pleaseMESSAGE");

					$droppedItems='';
	   				$resulta23at = mysqli_query($mysqli,"SELECT name, itemupgrade, upgrademuch,type FROM items_wearing WHERE username='$attackname' AND itemupgrade != 'Protection'");
	    			while ($rec0 = mysqli_fetch_object($resulta23at))
					{
						$itemType=$rec0->type;
						if($itemType=='trophy'){//Resolve REAL type
							$resultaat3 = mysqli_query($mysqli,"SELECT type FROM items WHERE name='$rec0->name' LIMIT 1");
			    			while ($rec3 = mysqli_fetch_object($resultaat3))
							{
								$itemType=$rec3->type;
							}

                            //Only need to check item type is quest for the trophy slot as none of the others are equipable.
                            //Query duplicated so normal items don't need to check type every time
                            if($itemType!='quest')
                            {
                                $droppedItems .= " 1 $rec0->name [$rec0->upgrademuch $rec0->itemupgrade] ";
                                $sql = "INSERT INTO items_dropped (much, location, droptime, droppedBy, name, type,itemupgrade, upgrademuch)
                                 VALUES ('1','$S_location', '$droptime', '$attackname', '$rec0->name', '$itemType',  '$rec0->itemupgrade', '$rec0->upgrademuch')";
                                mysqli_query($mysqli,$sql) or die("DIE");
                            }
						}
                        else
                        {
                            $droppedItems .= " 1 $rec0->name [$rec0->upgrademuch $rec0->itemupgrade] ";
                            $sql = "INSERT INTO items_dropped (much, location, droptime, droppedBy, name, type,itemupgrade, upgrademuch)
                             VALUES ('1','$S_location', '$droptime', '$attackname', '$rec0->name', '$itemType',  '$rec0->itemupgrade', '$rec0->upgrademuch')";
                            mysqli_query($mysqli,$sql) or die("DIE");
                        }
					}

					//Magic protection orb
					/*$saveItems=0;
	                $resulta23at = mysqli_query($mysqli, "SELECT name, itemupgrade, ID, upgrademuch FROM items_inventory WHERE username='$attackname' && itemupgrade='protection' ORDER BY upgrademuch DESC LIMIT 1");
	                while ($rec0 = mysqli_fetch_object($resulta23at))
	                {
	                	$saveItems=$rec0->upgrademuch;
	                	removeItem($attackname, $rec0->name, 1, $rec0->itemupgrade, $rec0->itemupgrademuch, 0);
	               	}*/

                    $resulta23at = mysqli_query($mysqli, "SELECT ID, much,name, itemupgrade, upgrademuch,type FROM items_inventory WHERE username='$attackname' AND itemupgrade != 'Protection'");// ORDER BY RAND()");
                    while ($rec0 = mysqli_fetch_object($resulta23at))
                    {
                    	if($saveItems>0){
                    		$saveItems--;
                    	}else{
                            $droppedItems .= " $rec0->much $rec0->name [$rec0->upgrademuch $rec0->itemupgrade] ";
                            $sql = "INSERT INTO items_dropped (much, location, droptime, droppedBy, name, type, itemupgrade, upgrademuch)
					 VALUES ('$rec0->much','$S_location', '$droptime', '$attackname', '$rec0->name','$rec0->type',  '$rec0->itemupgrade', '$rec0->upgrademuch')";
                            mysqli_query($mysqli, $sql) or die("DIE");

                        	$sql = "DELETE FROM items_inventory WHERE ID='$rec0->ID' LIMIT 1";
                       		mysqli_query($mysqli, $sql) or die("error report this bug please h63");
                   		}
					}


				     	$sql = "DELETE FROM items_wearing WHERE username='$attackname' AND itemupgrade != 'Protection'";
				     	 mysqli_query($mysqli,$sql) or die("error report this bug please h63");
		 			}

		 			$tekst="$S_user killed $attackname in PvP at $S_location ($S_user struck first)<br />DROPPED_ITEMS:{ $droppedItems }";
		            $sqal = "INSERT INTO zlogs (titel, tekst, time)
			         VALUES ('Fight death $attackname - $S_user', '$tekst', $timee)";
		            mysqli_query($mysqli, $sqal) or die("erroraa report this bug g32");

			}else{ # WEL IN ARENA
			 		$resultaaat = mysqli_query($mysqli, "SELECT ID FROM users WHERE location like 'Desert arena%' LIMIT 2");
				   $aantal = mysqli_num_rows($resultaaat);
				   if($aantal<=1){
					     $winner=$S_user;
						 $nr=0;
						 //	$sql = "SELECT ID,side FROM users WHERE username='$S_user'";
					   		//$resultaat = mysqli_query($mysqli,$sql);
					    	//while ($record = mysqli_fetch_object($resultaat))
							//{
							 	$nr++;
						    	if($S_side=='Pirate'){$SPAWN='Toothen';} else{$SPAWN='Kinam';}
						   		mysqli_query($mysqli,"UPDATE users SET location='$SPAWN' WHERE username='$S_user'") or die("err1or --> 1df234d1");
					      	//}

						$nr=5;
					    $exp=$nr*10;
						$exp2=$exp*4;
					   	mysqli_query($mysqli,"UPDATE arena SET winner='$winner won and got a Desert arena medal and $exp2 combat experience' WHERE winner='' && time<$timee order by time asc LIMIT 1") or die("err1or --> 1d243fd1");
					   	mysqli_query($mysqli,"UPDATE users SET attack=attack+$exp, defence=defence+$exp, strength=strength+$exp, health=health+$exp WHERE username='$winner' LIMIT 1") or die("err1or --> 1d234fd1:  UPDATE users SET attack=attack+$exp, defence=defence+$exp, strength=strength+$exp, health=health+$exp WHERE username='$winner' LIMIT 1");
					   	mysqli_query($mysqli,"DELETE FROM pvp WHERE location like'Desert arena%' ") or die("err1or --> 1d234fd1: ");

					   	include_once('functions.php');
						addItem($winner, 'Desert arena medal', 1, 'medal', '', '', 1);



				   }

			} #############
			$sql = "INSERT INTO messages (username, sendby, message, time, topic)
			  VALUES ('$attackname', '<B>Syrnia</b>', '$S_user killed you at $S_location.', '$timee', 'You died')";
			mysqli_query($mysqli,$sql) or die("error report");



	} else {
	## ENEMY KE

	### ATTACK CODE
	$monster=0;
	$youstrlevel=$enemystrengthl;
	$youpower=$enemypower;
	$youattackl=$enemyattackl;
	$youaim=$enemyaim;
	$hisdef=$defencel;
	$hisarmour=$S_armour;
	## ECHTA CODE, VARS HIERBOVE
	$strengthdam=floor(($youstrlevel+$youpower)*0.35)+1; #max damage
	$attackdam=floor(($youattackl+$youaim)*0.35)+1;       #damage attack level
	$attstrratio=($attackdam/2)/$strengthdam*100; #(normally = 50%)
	if($attstrratio>100){$attstrratio=100;}
	$hitbelow=rand(0,$attstrratio);
	$hitup=rand($attstrratio,100);
	$hitpercent=rand($hitbelow,$hitup);
	$hit=round($strengthdam*($hitpercent/100));
	$enemydefhit=($hisdef+$hisarmour*0.6)*0.35;
	$enemyattdefratio=($enemydefhit/2)/$attackdam*100;
	if($enemyattdefratio>100){$enemyattdefratio=100;}
	$blockbelow=rand(($enemyattdefratio/10),$enemyattdefratio);
	$blockup=rand($enemyattdefratio,100);
	$blockpercent=100-rand($blockbelow,$blockup);
	$enemyhit=round($hit*($blockpercent/100));

	$hp=$hp-$enemyhit;
	if($hp<1){ $hp=0; }
	$timeN=time()+2;
	mysqli_query($mysqli,"UPDATE users SET hp=$hp, dump3='$timeN' WHERE username='$S_user' LIMIT 1") or die("err1or --> 123ffffff111");
	$text="<i>$attackname</i>($enemylevel) did $enemyhit damage to $S_user. $S_user had $hp HP left.<br />$text";
	$logLocation=$S_location;
	if($hp<1){

		if($S_side=='Pirate'){$SPAWN='Crab nest';} else{$SPAWN='Sanfew';}
		if($ARENA){
		 	if($S_side=='Pirate'){$SPAWN='Toothen';} else{$SPAWN='Kinam';}
		}
		mysqli_query($mysqli,"UPDATE users SET location='$SPAWN', hp='$maxhp' WHERE username='$S_user' LIMIT 1") or die("err1or --> 123111");
		$hp=0;
		$dood="$attackname killed $S_user<br />";
		mysqli_query($mysqli,"UPDATE stats SET playerkills=playerkills+1 WHERE username='$attackname' LIMIT 1") or die("err2o22   ");
		mysqli_query($mysqli,"UPDATE stats SET playerdeaths=playerdeaths+1 WHERE username='$S_user' LIMIT 1") or die("err2o22   ");
		$droptime=time();
		if($ARENA==''){

		 	if($S_user!='M2H'){
				mysqli_query($mysqli,"DELETE FROM items_inventory WHERE username='$S_user' && type='quest' AND itemupgrade != 'Protection'") or die("err1or --> kew2 1dfd1");

				$droppedItems='';
   				$resulta23at = mysqli_query($mysqli,"SELECT name, itemupgrade, upgrademuch,type FROM items_wearing WHERE username='$S_user' AND itemupgrade != 'Protection'");
		    	while ($rec0 = mysqli_fetch_object($resulta23at))
				{
					$itemType=$rec0->type;
					if($itemType=='trophy'){//Resolve REAL type
						$resultaat3 = mysqli_query($mysqli,"SELECT type FROM items WHERE name='$rec0->name' LIMIT 1");
		    			while ($rec3 = mysqli_fetch_object($resultaat3))
						{
							$itemType=$rec3->type;
						}
					}
					$droppedItems .= " 1 $rec0->name [$rec0->upgrademuch $rec0->itemupgrade] ";
				 	$sql = "INSERT INTO items_dropped (much, location, droptime, droppedBy, name, type,itemupgrade, upgrademuch)
					 VALUES ('1','$S_location', '$droptime', '$attackname', '$rec0->name', '$itemType',  '$rec0->itemupgrade', '$rec0->upgrademuch')";
					mysqli_query($mysqli,$sql) or die("DIE");
				}

				//Magic protection orb
				$saveItems=0;
                /*$resulta23at = mysqli_query($mysqli, "SELECT name,ID, upgrademuch,itemupgrade FROM items_inventory WHERE username='$S_user' && itemupgrade='protection' ORDER BY upgrademuch DESC LIMIT 1");
                while ($rec0 = mysqli_fetch_object($resulta23at))
                {
                	$saveItems=$rec0->upgrademuch;
                	removeItem($S_user, $rec0->name, 1, $rec0->itemupgrade, $rec0->itemupgrademuch, 0);
               	}*/


                $resulta23at = mysqli_query($mysqli, "SELECT ID, much,name, itemupgrade, upgrademuch,type FROM items_inventory WHERE username='$S_user' AND itemupgrade != 'Protection'");// ORDER BY RAND()");
                while ($rec0 = mysqli_fetch_object($resulta23at))
                {
                	if($saveItems>0){
                		$saveItems--;
                	}else{
                        $droppedItems .= " $rec0->much $rec0->name [$rec0->upgrademuch $rec0->itemupgrade] ";
                        $sql = "INSERT INTO items_dropped (much, location, droptime, droppedBy, name, type, itemupgrade, upgrademuch)
				 VALUES ('$rec0->much','$S_location', '$droptime', '$S_user', '$rec0->name','$rec0->type',  '$rec0->itemupgrade', '$rec0->upgrademuch')";
                        mysqli_query($mysqli, $sql) or die("DIE");

                    	$sql = "DELETE FROM items_inventory WHERE ID='$rec0->ID' LIMIT 1";
                   		mysqli_query($mysqli, $sql) or die("error report this bug please h63");
               		}
				}

					$sql = "DELETE FROM items_wearing WHERE username='$S_user' AND itemupgrade != 'Protection'";
					 mysqli_query($mysqli,$sql) or die("error report this bug please h63");
			}


			 $tekst="$attackname killed $S_user in PvP at $S_location ($S_user struck first)<br />DROPPED_ITEMS:{ $droppedItems }";
	            $sqal = "INSERT INTO zlogs (titel, tekst, time)
		         VALUES ('Fight death $S_user - $attackname', '$tekst', $timee)";
	            mysqli_query($mysqli, $sqal) or die("erroraa report this bug g32");

		}else{ ## WEL IN ARENA
			$resultaaat = mysqli_query($mysqli, "SELECT ID FROM users WHERE location like 'Desert arena%' LIMIT 2");
		   	$aantal = mysqli_num_rows($resultaaat);
		   	if($aantal<=1){
			    $winner=$attackname;
				$nr=0;
				$sql = "SELECT ID,side FROM users WHERE username='$attackname'";
			   	$resultaat = mysqli_query($mysqli,$sql);
			    while ($record = mysqli_fetch_object($resultaat))
				{
				 	$nr++;
				    if($record->side=='Pirate'){$SPAWN='Toothen';} else{$SPAWN='Kinam';}
				   	mysqli_query($mysqli,"UPDATE users SET location='$SPAWN' WHERE ID='$record->ID'") or die("err1or --> 1dsdfd1");
			    }
			    $nr=5;
			    $exp=$nr*10;
				$exp2=$exp*4;
			   	mysqli_query($mysqli,"UPDATE arena SET winner='$winner won and got a Desert arena medal and $exp2 combat experience' WHERE winner='' && time<$timee order by time asc LIMIT 1") or die("err1or --> 1d24ds3fd1");
			   	mysqli_query($mysqli,"UPDATE users SET attack=attack+'$exp', defence=defence+'$exp', strength=strength+'$exp', health=health+'$exp' WHERE username='$winner' LIMIT 1") or die("err1or --> 1df xd1 x");
			   	include_once('functions.php');
				addItem($winner, 'Desert arena medal', 1, 'medal', '', '', 0);
		   	}
		}

        $sql = "INSERT INTO messages (username, sendby, message, time, topic)
			  VALUES ('$S_user', '<B>Syrnia</b>', 'You died attacking $attackname at $S_location.', '$timee', 'You died')";
			mysqli_query($mysqli,$sql) or die("error report");

		$S_location=$SPAWN;
		$sql = "SELECT mapNumber FROM locationinfo WHERE locationName='$S_location' LIMIT 1";
		$resultaat = mysqli_query($mysqli,$sql);
		while ($record = mysqli_fetch_object($resultaat))
		{
		   $S_mapNumber=$record->mapNumber;
		}

	}else{
		echo"$('statsHPText').innerHTML=\"$hp\";";
	}
	} ## ENEMY HP OVER?

	echo updatePlayers();

	$sql = "INSERT INTO pvp (time, text, location)
	  VALUES ('$timee', '$text', '$logLocation')";
	mysqli_query($mysqli,$sql) or die("erro");

	if($dood!=''){
		$sql = "INSERT INTO pvp (time, text, location)
		  VALUES ('$timee', '$dood', '$logLocation')";
		mysqli_query($mysqli,$sql) or die("erro");
	}
}####### EIND VECHTEN

if($hp<=0){
 	//Ouch, "I" died in my own attack
	include('mapData.php');
	include_once('rebuildInventory.php');
	echo"updateCenterContents('loadLayout', 1);";
	echo"$('statsHPText').innerHTML=\"$maxhp\";";
	if($S_mapNumber==3){echo"if(lastMovedItem){lastMovedItem.remove();}";}
	include_once('wearstats.php');
	wearStats($S_user, 1);
	exit();
}


$_SESSION['S_lastPVPupdate']=updatePVPlog($_SESSION['S_lastPVPupdate']);

}else{


	if($S_location=='The Outlands 1'){
	 	$pvpOutput.="This location contains some tin rocks.<br /><a href='' onclick=\"locationText('work', 'mining', 'Tin ore');return false;\">Mine tin</a><br /><br />";
	}
	if(($S_location=='The Outlands 1'  OR $S_location=='The Outlands 13')){
		if($_SESSION['S_side']=='Pirate'){ $to='Crab nest';} else{$to='Port Senyn';}
		if($var2=='sailaway'){
			$S_location=$to;
			mysqli_query($mysqli,"UPDATE users SET location='$to', dump='', dump2='' WHERE username='$S_user' LIMIT 1") or die("error --> 1113");
			$pvpOutput.="You are entering the ship!<br />";
			echo"$('statsHPText').innerHTML=\"$hp\";";
			include('includes/mapData.php');
			echo"updateCenterContents('loadLayout', 1);";

			//echo"updateCenterContents('move', '$to');";
		} else{
		 	$pvpOutput.="Theres a $side ship near shore..you can call it to return to $to.<br /><a href='' onclick=\"updateCenterContentsExtended('pvp', 'sailaway');return false;\">Leave</a>";
		}
	}elseif($S_location=='The Outlands 3'){
	 	$pvpOutput.="An ancient fire enables you to smelt bronze here.<br /><a href='' onclick=\"locationText('work', 'smelting', 'Bronze bars');return false;\">Smelt Bronze Bars</a><br />";
	}elseif($S_location=='The Outlands 4'){
	 	$pvpOutput.="This location contains some copper rocks.<br /><a href='' onclick=\"locationText('work', 'mining', 'Copper ore');return false;\">Mine copper</a>";
	}elseif($S_location=='The Outlands 16'){
	 	$pvpOutput.="You find a strange cave with some sort of oven in it...<br />You can cook here, and don't need a tinderbox or wood.<br /><br />";
	   	/*$sql = "SELECT name FROM items_inventory WHERE username='$S_user' && type='food' && name NOT LIKE '%cooked%'";
	   	$resultaat = mysqli_query($mysqli,$sql);
	    while ($record = mysqli_fetch_object($resultaat))
		{
		 $pvpOutput.="<a href='' onclick=\"locationText('work', 'cooking', '$record->name');return false;\">Cook $record->name</a><br />";
		}*/

        $pvpOutput.= getRawsForCooking();
	}elseif($S_location=='The Outlands 17'){
	 	$pvpOutput.="This is a perfect spot to net or rod fish.<br /><a href='' onclick=\"locationText('work', 'fishing');return false;\">Fish</a>";
	}elseif($S_location=='The Outlands 18'){
	 	$pvpOutput.="This is a perfect spot to net or rod fish.<br /><a href='' onclick=\"locationText('work', 'fishing');return false;\">Fish</a>";
	}elseif($S_location=='The Outlands 21'){
	 	$pvpOutput.="Even though there aren't many green trees in here you found some tree bark which you can cut. <br /><a href='' onclick=\"locationText('work', 'woodcutting');return false;\">Woodcut</a>";
	}elseif($S_location=='The Outlands 29'){
	 	$pvpOutput.="When you enter the location you see some abandoned anvils..<br />";
		//$pvpOutput.="<a href='' onclick=\"updateCenterContentsExtended('pvp', 'smith');return false;\">Smith here</a>";
		$pvpOutput.="<a href='' onclick=\"locationText('smith');return false;\">Smith here</a>";

	}elseif($S_location=='The Outlands 34'){
	 	$pvpOutput.="This is a perfect spot to net or rod fish.<br /><a href='' onclick=\"locationText('work', 'fishing');return false;\">Fish</a>";
	}elseif($S_location=='The Outlands 35'){
	 	$pvpOutput.="You find an interesting cave...<a href='' onclick=\"updateCenterContents('move', 'Ogre cave entrance 1');return false;\"><font color=white>enter the cave</a><br />";
	}elseif($S_location=='The Outlands 37'){
	 	$pvpOutput.="You find a strange place with some sort of stove...<br />You can cook here without needing any wood or a tinderbox.<br /><br />";
	   	/*$sql = "SELECT name FROM items_inventory WHERE username='$S_user' && type='food' && name NOT LIKE '%cooked%'";
	   	$resultaat = mysqli_query($mysqli,$sql);
	    while ($record = mysqli_fetch_object($resultaat))
		{
		 $pvpOutput.="<a href='' onclick=\"locationText('work', 'cooking', '$record->name');return false;\">Cook $record->name</a><br />";
		}*/

        $pvpOutput.= getRawsForCooking();
	}elseif($S_location=='The Outlands 42'){

	 	$pvpOutput.="An ancient fire enables you to smelt bronze and iron bars here.<br /><a href='' onclick=\"locationText('work', 'smelting', 'Bronze bars');return false;\">Smelt bronze bars</a>";
		$pvpOutput.="<br /><a href='' onclick=\"locationText('work', 'smelting', 'Iron bars');return false;\">Smelt Iron Bars</a>";

	}elseif($S_location=='The Outlands 44'){

	 	$pvpOutput.="This location contains some tin rocks.<br />";
		//$pvpOutput.="<a href='' onclick=\"locationText('work', 'mining', 'Tin ore');return false;\">Mine tin</a>";
		$pvpOutput.="<a href='' onclick=\"locationText('work', 'mining', 'Tin ore');return false;\">Mine tin</a>";

	}elseif($S_location=='The Outlands 49'){
	 	$pvpOutput.="This location contains the very valuable Syriet ore, are you skilled enough to mine it yet?<br /><a href='' onclick=\"locationText('work', 'mining', 'Syriet ore');return false;\">Mine Syriet</a>";

	}elseif($S_location=='The Outlands 52'){
	 	$pvpOutput.="Even though there aren't many green trees in here you found some tree bark which you can cut if you are skilled enough. <br /><a href='' onclick=\"locationText('work', 'woodcutting');return false;\">Woodcut</a>";
	}elseif($S_location=='The Outlands 54'){

	 	$pvpOutput.="This location contains some copper rocks.<br /><a href='' onclick=\"locationText('work', 'mining', 'Copper ore');return false;\">Mine copper</a>";

	}elseif($S_location=='The Outlands 59'){

	 	$pvpOutput.="An ancient fire enables you to smelt iron and steel bars here.<br /><a href='' onclick=\"locationText('work', 'smelting', 'Iron bars');return false;\">Smelt iron bars</a>";
		$pvpOutput.="<br /><a href='' onclick=\"locationText('work', 'smelting', 'Steel bars');return false;\">Smelt steel bars</a>";

	}elseif($S_location=='The Outlands 62'){

		  $sql = "SELECT name FROM items_inventory WHERE username='$S_user' && name='Boat' LIMIT 1";
	   	$resultaat = mysqli_query($mysqli,$sql);
	    while ($record = mysqli_fetch_object($resultaat))
		{
		 $pvpOutput.="<a href='' onclick=\"locationText('work', 'fishing', 'Boat');return false;\"><font color=white>Fish with Boat </a><br />";
		}
	}elseif($S_location=='The Outlands 66'){
	 	$pvpOutput.="This location contains the very valuable Obsidian ore, are you skilled enough to mine it yet?<br /><a href='' onclick=\"locationText('work', 'mining', 'Obsidian ore');return false;\">Mine Obsidian</a>";

	}elseif($S_location=='The Outlands 78'){
	 	$pvpOutput.="This location contains the very valuable Platina ore, are you skilled enough to mine it yet?<br /><a href='' onclick=\"locationText('work', 'mining', 'Platina ore');return false;\">Mine platina</a>";
	}elseif($S_location=='The Outlands 79'){
	 	$pvpOutput.="This location contains some iron ore rocks.<br /><a href='' onclick=\"locationText('work', 'mining', 'Iron ore');return false;\">Mine iron ore</a>";
	}elseif($S_location=='The Outlands 89'){
	 	$pvpOutput.="Even though there aren't many green trees in here you found some tree bark which you can cut. <br /><a href='' onclick=\"locationText('work', 'woodcutting');return false;\">Woodcut</a>";
	}elseif($S_location=='The Outlands 92'){
	 	$pvpOutput.="When you enter the location you see some abandoned anvils..<br />";
	 	$pvpOutput.="<a href='' onclick=\"locationText('smith');return false;\">Smith here</a>";
	}elseif($S_location=='The Outlands 96'){
	 	$pvpOutput.="This location contains some coal rocks.<br /><a href='' onclick=\"locationText('work', 'mining', 'Coal');return false;\">Mine coal</a>";


	}

    //Removed BM cooking on RAID's request as it has been ruining the battlemage
    /*else if($S_location=='Desert arena 1'){
	 	$pvpOutput.="There is an source of immense heat, you can cook here without a tinderbox or wood.<br />";
	   $sql = "SELECT name FROM items_inventory WHERE username='$S_user' && type='food' && name NOT LIKE '%cooked%'";
	   $resultaat = mysqli_query($mysqli,$sql);
	    while ($record = mysqli_fetch_object($resultaat)) { $pvpOutput.="<a href='' onclick=\"locationText('work', 'cooking', '$record->name');return false;\">Cook $record->name</a><br />"; }
	}else if($S_location=='Desert arena 3'){
	 	$pvpOutput.="There is an source of immense heat, you can cook here without a tinderbox or wood.<br />";
	   	$sql = "SELECT name FROM items_inventory WHERE username='$S_user' && type='food' && name NOT LIKE '%cooked%'";
	   	$resultaat = mysqli_query($mysqli,$sql);
	    while ($record = mysqli_fetch_object($resultaat)) { $pvpOutput.="<a href='' onclick=\"locationText('work', 'cooking', '$record->name');return false;\">Cook $record->name</a><br />"; }
	}*/


	if($S_location=='The Outlands 82'){
	 	$questID=1;
	 	//$var1=$var3;
		//$var2=$var4;
		include('locations/textincludes/quests.php');
	}else if($S_location=='The Outlands 56'){
		$questID=3;
	   	$resultaaat = mysqli_query($mysqli, "SELECT username FROM quests WHERE questID='$questID' && username='$S_user' LIMIT 1");
	   	$aantal = mysqli_num_rows($resultaaat);
		if($aantal==1){
		 	//$var1=$var3;
		 	//$var2=$var4;
		 	include('locations/textincludes/quests.php');
		}
	}else if($S_location=='The Outlands 96'){
		$questID=6;
	   $resultaaat = mysqli_query($mysqli, "SELECT username FROM quests WHERE questID='$questID' && completed=0 && subID=1 && username='$S_user' LIMIT 1");
	   $aantal = mysqli_num_rows($resultaaat);
		if($aantal==1){
		 	$pvpOutput.="<br /><br />You finally find the cave of the monster which the knight has been talking about...<br /><a href='' onclick=\"fighting('Bunyip');return false;\">Fight the monster</a>";
		}
	}

}

	if($pvpOutput){
		$pvpOutput=str_replace('"','\"', $pvpOutput);
		echo"\$('OLActions').innerHTML=\"$pvpOutput\";";
	}
	if($output){
		$output=str_replace('"','\"', $output);
		echo"\$('LocationContent').innerHTML=\"$output\";";
	}


}//hacker

?>