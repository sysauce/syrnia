<?
if(defined('AZtopGame35Heyam')){

$halloween = isHalloween();
$xmas = isXmas();
$easter = isEaster();

	include_once('levels.php');

	function RunDurabilityCheck($itemName, $travelTime, $days){
		global $S_user;
		$randI=rand(1, $days*24*3600);
		if($randI<=$travelTime){
			//$status = removeDurability($itemName, $S_user);
			//if($status==2){
            if(removeDurability($itemName, $S_user))
            {
				$msg= "<br />Your $itemName was broken. It was unrepairable and removed from your inventory.<br /><br />";
			}
            else
            {
				$msg= "<br />Your $itemName was damaged, the durability bonus is reduced by one.<br /><br />";
			}
			echo"messagePopup('<B>$msg</B>', 'Damaged item..');";
		}
	}

	$move=$option2;
	$from=$S_location;

		$resultaat = mysqli_query($mysqli, "SELECT lastvalid FROM stats WHERE username='$S_user' LIMIT 1" );
    	while ($record = mysqli_fetch_object($resultaat)) {  $lastBotValidTime=$record->lastvalid;  }

   		$resultaat = mysqli_query($mysqli,"SELECT location, work, dump, dump2,dump3, worktime FROM users WHERE username='$S_user' LIMIT 1" );
    	while ($record = mysqli_fetch_object($resultaat))
		{
	 		$work=$record->work;
	 		$S_location=$record->location;
	 		$worktime=$record->worktime;
	 		$dump=$record->dump;
	 		$dump2=$record->dump2;
	 		$dump3=$record->dump3;
	 	}



		if($move=='cancel'){
			mysqli_query($mysqli,"UPDATE users SET work='', worktime='', dump='', dump2='' WHERE username='$S_user' && work='move' LIMIT 1") or die("ert113");
			$var1='loadLayout';

			echo changeLayout('-', '-');
			echo"$('locationTitle').innerHTML=\"$S_location\";";
			echo updatePlayers();
			include_once('locationText.php');

			return;
		}

		$resultaat = mysqli_query($mysqli, "SELECT name FROM items_wearing WHERE type='horse' && username='$S_user' LIMIT 1" );
    	while ($record = mysqli_fetch_object($resultaat)) {
		 	$horse=$record->name;
		}

		//Special travel checks
		if($from=='Elven gate' && $move=='Penteza'){
			if(itemAmount($S_user, 'Elven gate pass', 'key', '', '')<1){
				exit();
			}
		}else if($from=='Rose gates' && $move=='Castle Rose'){
			if(itemAmount($S_user, 'Rose gate pass', 'key', '', '')<1){
				exit();
			}
		}

		if($from=='Beset catacombs' || $move=='Beset catacombs'){
			if(!finishedQuest(18)){
				exit();
			}
		}

		### NEW TRAVEL ?
		if($move!='' && $work!='move'){
			$movetimesec='';
			if($dump && $dump2>=0 && $dump2<>'' && $worktime && $move<>'m2h' && $work=='move'){
				$movetimesec=$worktime-$timee;
				if($movetimesec<1){$movetimesec=1;}
				$movetimeexp=$dump2;

			} else{

			$bareTravelTime=0;
			$locationExists=0;

			//Exception
			if(stristr ($S_location, "Arch. cave 3")){
				if($S_location=='Arch. cave 3.25' && $move=='Arch. cave 4.1'){
				 	$bareTravelTime=240;
				}elseif($S_location=='Arch. cave 3.1' && $move=='Arch. cave 2.20'){
				 	$bareTravelTime=240;
				}else{
					$bareTravelTime=180;
					$move=$S_location;
					while($move==$S_location){
						$move=rand(1,25);
						$move="Arch. cave 3.$move";
					}
				}
			    $locationExists=1;
    		}
            else if(stristr($move, "Lost caves") && $S_location == 'Heerchey manor')
            {
                $bareTravelTime = 0;

                if(groupQuestActive($move, false))
                {
                    $locationExists=1;
                    $bypassAttack = 1;
                    mysqli_query($mysqli,"UPDATE users_junk SET partyIslandSailLocation='$S_location' WHERE username='$S_user' LIMIT 1") or die("eror > 1113");
                }
            }
            else if(stristr($move, "Lost caves") && $S_location == 'Arch. cave 4.5')
            {
                $bareTravelTime = 0;

                if(date("H") == 0 || date("H") == 6 || date("H") == 12 || date("H") == 18)
                {
                    $bareTravelTime = 120;
                    $locationExists=1;
                    mysqli_query($mysqli,"UPDATE users_junk SET partyIslandSailLocation='' WHERE username='$S_user' LIMIT 1") or die("eror > 1113");
                }
                else
                {
                    exit();
                }
            }
            else if(stristr($S_location, "Lost caves") && $move == 'Heerchey manor')
            {
                $bareTravelTime = 0;

                $resultaat = mysqli_query($mysqli, "SELECT username FROM users_junk WHERE partyIslandSailLocation='Heerchey manor' AND username='$S_user' LIMIT 1");
                $allowEscort = mysqli_num_rows($resultaat) === 1;

                if($allowEscort)
                {
                    $locationExists=1;
                    $bypassAttack = 1;
                    mysqli_query($mysqli,"UPDATE users_junk SET partyIslandSailLocation='' WHERE username='$S_user' LIMIT 1") or die("eror > 1113");
                }
            }
            else if(stristr($S_location, "Lost caves"))
            {
                $resultaat = mysqli_query($mysqli, "SELECT username FROM users_junk WHERE partyIslandSailLocation='Heerchey manor' AND username='$S_user' LIMIT 1");
                $canMove = mysqli_num_rows($resultaat) == 0;

                if(!$canMove)
                {
                    exit();
                }

                if($S_location=='Lost caves 1' && $move == 'Arch. cave 4.5')
                {
                    $bareTravelTime = 120;
                    $locationExists=1;
				}
                else if($S_location == 'Lost caves 10' && $move == 'Arch. cave 5.1')
                {
                    $bareTravelTime = 120;

                    if(groupQuestActive($S_location, false))
                    {
                        exit();
                    }
                }
                else
                {
                    $bareTravelTime = 180;
                    $nFrom = explode(" ", $S_location);
                    $nFrom = $nFrom[2];

                    $nTo = explode(" ", $move);
                    $nTo = $nTo[2];

                    if($nFrom > $nTo)
                    {
                        if($nFrom - $nTo != 1)
                        {
                            exit();
                        }
                    }
                    else if(groupQuestActive($S_location, false))
                    {
                        exit();
                    }
                    else if($nTo - $nFrom != 1)
                    {
                        exit();
                    }
                }
                $locationExists=1;
            }
            else
            {
				$sql = "SELECT moveToArray, mapNumber FROM locationinfo WHERE locationName = '$S_location' LIMIT 1 ";
				$resultaat = mysqli_query($mysqli, $sql);
				while ($record = mysqli_fetch_object($resultaat))
				{
				 	//This code is a move code, and in mapData.php
					$S_mapNumber=$record->mapNumber;
					$moveToArrayData = explode ("|", $record->moveToArray);
					for($i=0;$moveToArrayData[$i];$i++){
						$moveToCoords = explode ("#", $moveToArrayData[$i]);
						if($moveToCoords[4]==$move){
							$bareTravelTime=$moveToCoords[5];
							$locationExists=1;
						}
					}
				}

				if($S_mapNumber==0){//Tutorial island
					if($move=='Tutorial 3'){
						$copper=0;	$tin=0;
					   	$resultt = mysqli_query($mysqli, "SELECT much FROM items_inventory WHERE name='Copper ore' && username='$S_user' LIMIT 1");
					    while ($record = mysqli_fetch_object($resultt)) {  $copper=$record->much;	}
					   	$resultt = mysqli_query($mysqli, "SELECT much FROM items_inventory WHERE name='Tin ore' && username='$S_user' LIMIT 1");
					    while ($record = mysqli_fetch_object($resultt)) {  $tin=$record->much;		}
        				if($tin<1 OR $copper<1){
        					echo"messagePopup(\"You are not yet ready to move on to the next tutorial, please complete your current task first.\", \"Moving\");";
								exit();
        				}
					}else if($move=='Tutorial 4' && $smithing<7){
						echo"messagePopup(\"You are not yet ready to move on to the next tutorial, please complete your current task first.\", \"Moving\");";
							exit();
					}else if($move=='Tutorial 5' && $fishing<=1){
						echo"messagePopup(\"You are not yet ready to move on to the next tutorial, please complete your current task first.\", \"Moving\");";
							exit();
					}else if($move=='Tutorial 6' && $woodcutting<=1){
						echo"messagePopup(\"You are not yet ready to move on to the next tutorial, please complete your current task first.\", \"Moving\");";
							exit();
					}else if($move=='Tutorial 7' && $cooking<=1){
						echo"messagePopup(\"You are not yet ready to move on to the next tutorial, please complete your current task first.\", \"Moving\");";
							exit();
					}

				}
			}



			if($locationExists!=1){//hackattempt
				exit();
			}


			if($bareTravelTime>0){ # free travel (OL, ARENA) ?
				$movetimesec=$bareTravelTime;

				if($horse=='Beginners horse'){ 	$movetimesecHORSE=$movetimesec*0.40;  $sterf=rand(1,250);}
				elseif($horse=='Mule'){ 		$movetimesecHORSE=$movetimesec*0.30;  $sterf=rand(1,200);}
				elseif($horse=='Brown horse'){	$movetimesecHORSE=$movetimesec*0.20;  $sterf=rand(1,2000);}
				elseif($horse=='White horse'){ 	$movetimesecHORSE=$movetimesec*0.19;  $sterf=rand(1,3000);}
				elseif($horse=='Reindeer'){ 	$movetimesecHORSE=$movetimesec*0.18;  $sterf=rand(1,6000);}
				elseif($horse=='Skeletal horse'){ 	$movetimesecHORSE=$movetimesec*0.18;  $sterf=rand(1,6000);}

				if($horse){
					 if($sterf==1){
						/*$sql = "INSERT INTO messages (username, sendby, message, time, topic)
					  	VALUES ('$S_user', '<B>Syrnia</b>', 'Your $horse has died on the travel between $S_location and $move.', '$timee', 'Your $horse')";
						mysqli_query($mysqli, $sql) or die("error report234 this bug please33 66 msg  $sendto', '$S_user', '$tekst', '$timee', '$topic'");*/
						mysqli_query($mysqli, "DELETE FROM items_wearing WHERE username='$S_user' && name='$horse' LIMIT 1") or die("error --> 1113");
						echo"unwearItem('horse');";
						echo"messagePopup('Your $horse has died!', 'Travelling');";

						$horse='';
					}else{
						$movetimesec=$movetimesecHORSE;
					}
				}


				$sql = "SELECT upgrademuch FROM items_wearing WHERE itemupgrade='Travel time' && type!='Trophy' && username='$S_user' LIMIT 7";
				$resultaat = mysqli_query($mysqli, $sql);
				while ($record = mysqli_fetch_object($resultaat)) {
				 	$upgradeTimeBonus+=($record->upgrademuch); // its saved as -2 etc.
				}


				$movetimesec2=$movetimesec+$upgradeTimeBonus;
				$movetimeexp=0;
				$movetimeexp=floor($movetimesec2/2.0);

				$SPE=$speedl/2; if($SPE>99){$SPE=99;}
				$movetimesec=ceil($movetimesec*(1-(($SPE)/100)));

				$movetimesec+=$upgradeTimeBonus;


				if($horse==''){

				   	$sql = "SELECT name FROM items_wearing WHERE type<>'trophy'  && username='$S_user'";
				   	$resultaat = mysqli_query($mysqli, $sql);
					while (($record = mysqli_fetch_object($resultaat)) && $movetimesec > 9) {
				    	//Boots
						if($record->name=='Leather boots'){$movetimesec*=0.80; 	RunDurabilityCheck($record->name, $movetimesec, 20); }
				    	elseif($record->name=='Bat-hide boots'){$movetimesec*=0.75;  RunDurabilityCheck($record->name, $movetimesec, 30);}
				    	elseif($record->name=='Eagle boots'){$movetimesec*=0.70;  RunDurabilityCheck($record->name, $movetimesec, 30); }
				    	elseif($record->name=='Cheetah boots'){$movetimesec*=0.75; RunDurabilityCheck($record->name, $movetimesec, 25);}

						//Legs
						elseif($record->name=='Wildebeest pants'){$movetimesec*=0.95; RunDurabilityCheck($record->name, $movetimesec, 25);}

				    	//Body
						elseif($record->name=='Lion vest'){$movetimesec*=0.95; RunDurabilityCheck($record->name, $movetimesec, 25);}

				    	//Gloves
						elseif($record->name=='Antelope hooves'){$movetimesec*=0.95; RunDurabilityCheck($record->name, $movetimesec, 25);}

				    	//Head
						elseif($record->name=='Elk horns'){$movetimesec*=0.95; RunDurabilityCheck($record->name, $movetimesec, 25);}

				    	//Hand
						elseif($record->name=='Witch broomstick'){$movetimesec*=0.90; RunDurabilityCheck($record->name, $movetimesec, 50);}

					}

				}else {
				 	$movetimeexp=0;
				}
				$movetimesec=ceil($movetimesec);
				if($movetimesec<10){$movetimesec=10;}
				if($movetimeexp<10 && $horse==''){$movetimeexp=10;}
				$movetime=time()+$movetimesec;

			} else {
			 	$movetime=time()-5;
				$movetimeexp=0;
				$work='move';
			}
			if($horse){
				$travelType=1;
			}else if($sail){
				$travelType=2;
			}else{
				$travelType=0; //Foot
			}

            $blockMove = "";
            if(strpos($move, "esert arena ") == 1 || strpos($move, "utlands") == 1)
            {
                $blockMove = " AND location NOT IN ('Sanfew', 'Crab nest', 'Kinam', 'Toothen')";
            }

			mysqli_query($mysqli, "UPDATE users SET work='move', worktime='$movetime', dump='$move', dump2='$movetimeexp', dump3='$travelType' WHERE username='$S_user' $blockMove LIMIT 1") or die("error --> 1113");
			}
		}else{
			$movetime=$worktime;
			$movetimesec=ceil($movetime-$timee);
			$movetimeexp=$dump2;
			$move=$dump;
			if($dump3==1){
				$horse=1;
			}else if($dump3==2){
				$sail=1;
			}
		}

	if($movetimeexp<0 OR $movetimeexp==''){$movetimeexp=0;}
	$movelocation=$move;

	if(($work=='move' && ($timee+1)>=$movetime) ){



	//FLOWERS
	if($movetimeexp>0 && $horse==''){

		############## begint met 6/99 op level 1. level 20=6/80    eindigt met 6/50 op level 50
		$max=150-$speedl;
		if($max<50){$max=50;}
		$flower=rand(1,$max);
		$get='';
		$getType='flower';
		if($flower==1 && ($S_location=='Isri' OR $S_location=='Sanfew' OR $S_location=='Lisim')){ $much=rand(1,4); $get="White Remer";  }
		elseif($flower==2 && ($S_location=='Rile' OR $S_location=='Nabb mines' OR $move=='Nabb mines' OR $move=='Rile')){ $much=rand(1,5); $get="Rose";  }
		elseif($flower==3){ $much=rand(1,1); $get="Carnation";  }
		elseif($flower==4 && ($S_location=='Peteza' OR $S_location=='Penteza forest' OR $S_location=='Elven gate')){ $much=rand(1,4); $get="Elven flower";  }
		elseif($flower==5 && ($S_location=='Xanso' OR $S_location=='Mentan' OR $S_location=='Berian')){ $much=rand(1,4); $get="Meznolian";  }
		elseif($flower==6){ $much=rand(1,1); $get="Tulip";  }
		elseif($flower==7){ $much=rand(1,1); $get="Purple rha";  }
		elseif($flower==8){ $much=rand(1,1); $get="Lady sunshine";  }
		elseif($flower==9 && ($S_location=='Ogre lake' OR $S_location=='Ogre camp')){ $much=rand(1,4); $get="Silver widow";  }
		elseif($flower==10 && rand(1,1000)==1){$much=1; $get='Four leaf clover';}
		elseif($flower==11 && ($S_mapNumber==11 OR $S_mapNumber==5)){ $much=rand(1,2); $get="Skull Rose";  }
		elseif($flower==12 && ($S_mapNumber==15)){ $much=rand(1,2); $get="Matricaria";  }
		elseif($flower==13 && ($S_mapNumber==19)){ $much=rand(1,1); $get="Plumeria";  }

		elseif($flower==49 && $easter){ $much=rand(1,1); $get="Pulsatilla";  }

		elseif($flower==48 && $halloween){ $much=rand(1,1); if(rand(1,2) == 1) { $get="Canna lucifer"; } }
		elseif($flower==49 && $halloween){ $much=rand(1,1); if(rand(1,2) == 1) { $get="Witches foxglove"; } }

		elseif($flower==48 && $xmas){ $much=rand(1,1); if(rand(1,2) == 1) { $get="Christmas cactus"; } }
		elseif($flower==49 && $xmas){ $much=rand(1,1); if(rand(1,2) == 1) { $get="Poinsettia"; } }
		elseif($flower==50 && $xmas){ $much=rand(1,1); $get="White rabbit fur"; $getType = "other"; }


		####################

		if($get){
		 	addItem($S_user, $get, $much, $getType, '', '', 1);
			echo"messagePopup('<B>You found <font color=yellow><B>$much $get</B></font> while walking!</B>', 'Interesting...');";
		}
	}//FLOWERS



	//Easter EGGS
	if(!$get && $easter){

		$roughMoveTime=$movetimeexp*2;
		if($roughMoveTime>=400){ $roughMoveTime=400; }
        //$roughMoveTime = 400;

        $resultaeat = mysqli_query($mysqli, "SELECT location FROM users WHERE username=' Easter Bunny' LIMIT 1");
        while ($record = mysqli_fetch_object($resultaeat))
        {
            $currentLocation = $record->location;
        }

        if($currentLocation)
        {
            $resultaeat = mysqli_query($mysqli, "SELECT mapNumber FROM locationinfo WHERE locationName = '$currentLocation' LIMIT 1");
            while ($record = mysqli_fetch_object($resultaeat))
            {
                $currentIslandID=$record->mapNumber;
            }
        }
		//12 hour format
		/*if(date("H")=="00"){ 		$map1=1;  $map2=7;
		}else if(date("H")=="01"){	$map1=2;  $map2=16;
		}else if(date("H")=="02"){	$map1=4;  $map2=5;
		}else if(date("H")=="03"){	$map1=9;  $map2=6;
		}else if(date("H")=="04"){	$map1=17;  $map2=15;
		}else if(date("H")=="05"){	$map1=17;  $map2=4;
		}else if(date("H")=="06"){	$map1=1;  $map2=16;
		}else if(date("H")=="07"){	$map1=6;  $map2=2;
		}else if(date("H")=="08"){	$map1=9;  $map2=5;
		}else if(date("H")=="09"){	$map1=4;  $map2=7;
		}else if(date("H")=="10"){	$map1=15;  $map2=2;
		}else if(date("H")=="11"){	$map1=17;  $map2=1;
		}else if(date("H")=="12"){ 	$map1=16;  $map2=16;
		}*/

		//if($map1==$S_mapNumber || $map2==$S_mapNumber){
		if($currentIslandID == $S_mapNumber){
			if(rand(1,(400/$roughMoveTime))==1 && $roughMoveTime>5 && $horse==''){ #1 egg per kwartier
				$egg=rand(1,100);
				$get='';
                if($egg<=1){ $type='cooked food';      $get="Bronze easter egg";  }
				elseif($egg<=2){ $type='cooked food'; 	$get="Silver easter egg";  }
				elseif($egg<=3){ $type='cooked food'; 	$get="Gold easter egg";  }
				elseif($egg<=25){ $type='cooked food'; 	$get="White easter egg";  }
				elseif($egg<=50){ $type='cooked food'; 	$get="Black easter egg";  }
				elseif($egg<=55){ $type='cooked food';  $get="Green easter egg";  }
				elseif($egg<=70){ $type='cooked food';  $get="Pink easter egg";  }
				elseif($egg<=75){ $type='cooked food';  $get="Yellow easter egg";  }
				elseif($egg<=80){ $type='cooked food';  $get="Red easter egg";  }
				elseif($egg<=85){ $type='cooked food';  $get="Blue easter egg";  }
				elseif($egg<=90){ $type='cooked food';  $get="Purple easter egg";  }
				elseif($egg<=99){ $type='cooked food';  $get="Orange easter egg";  }
				elseif($egg<=100){ $type='locked'; 		$get="Locked wooden egg";  }

				if($get && $type){
				 	$much=1;
				 	addItem($S_user, $get, $much, $type, '', '', 1);
					echo"messagePopup('<B>You found <font color=yellow><B>$much $get</B></font> while walking!</B>', 'Interesting...');";
				}
			}//Egg
		}//Right map

	}//Easter eggs


	//Find fallen stars
	if(($S_user=='edwin' || date("Y-m-d")=='2008-12-25') && $S_mapNumber==8){

		$roughMoveTime=$movetimeexp*2;
		if($roughMoveTime>=800){ $roughMoveTime=800;	}

			if(rand(1,(900/$roughMoveTime))==1 && $roughMoveTime>5 && $horse==''){ #1 egg per kwartier
				$type='rare'; 	$get="Fallen star";

				if($get && $type){
				 	$much=1;
				 	addItem($S_user, $get, $much, $type, '', '', 1);
					echo"messagePopup('<B>You found a <font color=yellow><B>$get</B></font> while walking!</B>', 'Interesting...');";
				}
			}
	}


		include_once('includes/locations/textincludes/sailingLocations.php');
		$found=0;
		for($i=1;$sailLocations[$i]['location'];$i++){
		 	if($sailLocations[$i]['location']==$move){
		 	 	$found=$i;
		 	 	break;
		 	}
		}
		if($found!=0 OR $move=='The Outlands 1' OR $move=='The Outlands 13'){
			$sail=1;
		}

		//$S_location=$movelocation;
        $movetimeexp = bonusExp("speed", $movetimeexp);

        $blockMove = "";
        if(strpos($movelocation, "esert arena ") == 1 || strpos($movelocation, "utlands") == 1)
        {
            $blockMove = " AND location NOT IN ('Sanfew', 'Crab nest', 'Kinam', 'Toothen')";
        }

		mysqli_query($mysqli,"UPDATE users SET location='$movelocation', speed=speed+'$movetimeexp', work='', worktime='', dump='', dump2='', dump3='' WHERE username='$S_user' $blockMove LIMIT 1") or die("error --> 123K5 MOVIE POVIE NO EXP");
		if($movetimeexp>0){
			$levelArray=addExp($levelArray, 'speed', $movetimeexp);
		}
		$previousMapNumber=$S_mapNumber;
		include_once('includes/mapData.php');
		if($previousMapNumber==3 || $S_mapNumber==14){//previous was PvP, reload HP as damage could have been dealt right when leaving
			echo"$('statsHPText').innerHTML=\"$hp\";";
		}
		//THIS IS ALSO AT BOTCHECK CODE!
		if($S_mapNumber==3 || $S_mapNumber==14){
		 	echo"$('statsHPText').innerHTML=\"$hp\";";
		 	$_SESSION['S_lastPVPupdate']=$timee-3600*24;
            $_SESSION['S_lastPVPID']=0;
			echo"if(\$('combatLog')!=null){\$('combatLog').innerHTML=\"\";\$('combatLog').title=\"$timee\";}";
			echo"setTimeout(\"pvpLog('$timee');\", 1000);";
		}

		//RANDOM ATTACKS
     	if(stristr($movelocation, "Arch. cave 2.")!=''){    	$attackLocation="Arch. cave 2";
     	}elseif(stristr($movelocation, "Arch. cave 3.")<>''){   $attackLocation="Arch. cave 3";
     	}elseif(stristr($movelocation, "Arch. cave 4.")<>''){   $attackLocation="Arch. cave 4";
     	}elseif(stristr($movelocation, "Arch. cave 5.")<>''){   $attackLocation="Arch. cave 5";
     	}elseif(stristr($movelocation, "Lost caves")<>''){   $attackLocation="Lost caves";
		}elseif($S_mapNumber=='17' && $movelocation!='Xanso' && $movelocation!='Crab nest' && $movelocation!='Heerchey docks'){   $attackLocation="Exrollia";
		}elseif($movelocation=="Rose mines" OR $movelocation=="Jungles edge" OR $movelocation=="Thick jungle"){   $attackLocation="Jungles edge";
		}else{$attackLocation='';}

		if($attackLocation && $sail!=1 && !$bypassAttack){
            $and = "";
            if($attackLocation == "Arch. cave 5" && rand(1, 7) > 1)
            {
                $and = " AND name <> 'Obsidian scaled gaman'";
            }
            $resultaat = mysqli_query($mysqli, "SELECT name,hp FROM monsters WHERE locations like '%,$attackLocation,%'$and ORDER BY rand() LIMIT 1" );
            while ($record = mysqli_fetch_object($resultaat))
			{
				$fight=$record->name;   $hpmob=floor($record->hp*1.1+3);
				mysqli_query($mysqli,"UPDATE users SET work='fight', worktime='$record->name',
				dump='$hpmob', dump2='<td><td><center><B>A $record->name attacked you!</B></Center><br />', dump3='20' WHERE username='$S_user' LIMIT 1") or die("err22or --> 1 TRAVEL FIGHT");
			}
			echo "fighting('$record->name');";
			return;
		}else{

			echo changeLayout('-', '-');
			echo"$('locationTitle').innerHTML=\"$S_location\";";
			echo updatePlayers();
			include_once('locationText.php');

			return;
		}

	}else{ //Travel is not done yet, display the counter

		include_once('includes/locations/textincludes/sailingLocations.php');

		$found=0;
		for($i=1;$sailLocations[$i]['location'];$i++){
		 	if($sailLocations[$i]['location']==$move){
		 	 	$found=$i;
		 	 	break;
		 	}
		}
		if($found!=0 OR $move=='The Outlands 1' OR $move=='The Outlands 13'){
			$sail=1;
		}


		echo"if($('centerDropList')){Sortable.destroy('centerDropList');}";
		echo"if($('houseInventory')){Sortable.destroy('houseInventory');}";



		$output.="<center><Table cellpadding=0 class=\"inhoud\" cellspacing=0 width=100%>
		<tr><td width=13 height=13 background=layout/layout3_LB.jpg></td><td background=layout/layout3_B.jpg></td><td width=13 background=layout/layout3_RB.jpg></td></tr>
		<tr height=100><td background=layout/layout3_L.jpg></td><td CLASS=\"inhoud\" valign=top align=center>
		<table width=100%><tr><td width=10></td><td align=left valign=top>";

		if(stristr($move, "Arch. cave 3.")<>''){
		 	$move='...unknown...';
		}

		$output.="<center><h2><font face=\"Monotype Corsiva, Bookman Old Style, verdana\" color=#E7C720 size=6>" . ($sail ? "Sailing" : "Moving") . " to $move.</font></h2>";


		$output.="<center><input type=\"text\" size=\"4\" value=0 id=\"moveCounter\" readonly class=\"counter\"><br />";




		/*
		$hour=date(G);
		if($hour>=21 OR $hour<=3){$image='night';} #21-3 night      6
		elseif($hour<=4 OR $hour>=21){$image='night';} #4-9 morning  6
		else{ $image='day'; } #10-20 day   10
		*/

		if($sail!=1){
			if($S_mapNumber==5 || $S_mapNumber==10 || $S_mapNumber==11 || $S_mapNumber==12 || $S_mapNumber==13 || $S_mapNumber==20 || $S_mapNumber==21){
 				$output.="<img src='images/work/moving_cave.jpg' border=1><br /><br />";
			}else{
				if( (date("d-m-")=="24-12-") || date("d-m-")=="25-12-" || date("d-m-")=="26-12-"){
					$output.="<img src='images/work/speedWINTER.jpg' border=1><br /><br />";
				}else{
					$output.="<img src='images/work/moving_land.jpg' border=1><br /><br />";
				}
			}
		}

		if($sail==1){
			$output.="<img src='images/work/sailing.jpg' border=1><br /><br />";
		 	$output.="Sailing to $move takes you $movetimesec seconds";
		 	$output.=", you are sailing and will not gain any speed experience.<br />";
		} elseif($horse){
			if($horse==1){
				$hText="a horse";
			}else{
				$hText="a $horse";
			}
		 	$output.="Moving to $move takes you $movetimesec seconds";
		 	$output.=" you will gain no experience because you are using $hText.<br />";
		 	$output.="Your speed level determines how long moving takes.<br />";
		} else {
		 	$output.="Moving to $move takes you $movetimesec Seconds";
		 	$output.=" and you will gain $movetimeexp Experience in speed.<br />";
		 	$output.="Your speed level determines how long moving takes.<br />";
			$output.="But there are also other things which affect the travel time, for example boots and horses.<br />";
			$output.="Speed level: ".$levelArray['speed']['level']." (".$levelArray['speed']['exp']." exp, ".$levelArray['speed']['nextLevel']." for next level).<br />";
		 	$output.="<br />";
		}

		$output.="<a href='' onclick=\"updateCenterContents('move', 'cancel');return false;\">Cancel the travel</a>";
		$output.="<br />";
		$output.="<br />";

		$output.="</td><td width=10></td></tr>";
		$output.="</table>";
		$output.="<br />";
		$output.="</td><td background=layout/layout3_R.jpg></td></tr>";
		$output.="<tr><td width=13 height=13 background=layout/layout3_LO.jpg></td><td background=layout/layout3_O.jpg></td><td background=layout/layout3_RO.jpg></td></tr>";


		$output.="</table>";


		$output=str_replace('
		', '', $output);
		$output=str_replace('"', '\\"', $output);
		echo"if($('moveCounter')==null){";
		echo "$('centerContent').innerHTML=\"$output\";";
		echo"$('moveCounter').value=".($movetimesec).";";
		echo"countDown('moveCounter', (new Date().getTime()+($movetimesec)*1000), 'move', \"$move\");";
		echo"}";
			return;
		} // DISPLAY, as travel is not done yet




} # define
?>