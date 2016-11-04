<?php
if(defined('AZtopGame35Heyam')){
if(!$S_user){
	echo"window.location=\"index.php?page=logout&error=noUser&from=cC\";";
  	exit();
}



function changeLayout($layoutOption, $option2){

	global $S_mapNumber, $S_location, $S_user, $S_donation, $S_disableDragDrop;
	global $mysqli;
	$timee=time();
	if($layoutOption=="botCheck"){

			$sql = "SELECT botcheck, work,dump,dump2,dump3,worktime FROM users WHERE username='$S_user' LIMIT 1";
			   $resultaat = mysqli_query($mysqli, $sql);
			    while ($recB = mysqli_fetch_object($resultaat))
				{
				if(is_numeric($option2) && ($option2>=100 && $option2<=9999) || $recB->botcheck==0){
				     	if($recB->botcheck==$option2 && $recB->botcheck>0 || $recB->botcheck==0){

							if($recB->botcheck!=0){
								if($_SESSION['S_attempt']>0){
									$_SESSION['S_attempt']-=2;
								}
								mysqli_query($mysqli, "UPDATE stats SET lastvalid='$timee', lastaction='$timee' WHERE username='$S_user' LIMIT 1") or die("err1or --> 1232231");
								mysqli_query($mysqli, "UPDATE users SET botcheck='', online=1 WHERE username='$S_user' LIMIT 1") or die("err1or --> 1232231");
							}

							$var1='loadLayout';

							//PvP
							if($S_mapNumber==3 || $S_mapNumber==14){
							 	echo"$('statsHPText').innerHTML=\"$hp\";";
							 	$_SESSION['S_lastPVPupdate']=time()-3600*24;
                                $_SESSION['S_lastPVPID']=0;
								echo"if(\$('combatLog')!=null){\$('combatLog').innerHTML=\"\";\$('combatLog').title=\"$timee\";}";
								echo"setTimeout(\"pvpLog('$timee');\", 1000);";
							}

							if($recB->work=='move'){
								echo changeLayout('move', $recB->dump);
							}else if($recB->work=='fight'){
							 	$newtime=$timee+10;
							 	if($recB->dump3<$newtime){
							 		mysqli_query($mysqli, "UPDATE users SET dump3='$newtime' WHERE username='$S_user' LIMIT 1") or die("err1or --> 1232231");
								}
								//This is to prevent the botcheck from rbeking fight all
								echo"if(JSdump1=='fighting'){fighting('$recB->worktime', JSdump2);}else{fighting('$recB->worktime');}";

							}else if($recB->work=='mining' || $recB->work=='smelting' || $recB->work=='smithing' || $recB->work=='woodcutting' || $recB->work=='school' || $recB->work=='constructing' || $recB->work=='plant' || $recB->work=='pick' || $recB->work=='train' || $recB->work=='fishing' || $recB->work=='cooking' || $recB->work=='lockpicking' || $recB->work=='other'){

							 	echo changeLayout('-', '-');
								echo"$('locationTitle').innerHTML=\"$S_location\";";
								echo updatePlayers();
								include_once('locationText.php');
								if($recB->dump3 && $recB->dump3>0){
									echo "setTimeout(\"locationText('work', '$recB->work', '$recB->dump', '$recB->dump2', '$recB->dump3');\", 500);";
								}else{
									echo "setTimeout(\"locationText('work', '$recB->work', '$recB->dump', '$recB->dump2');\", 500);";
								}


							}else{
								echo changeLayout('-', '-');
								echo"$('locationTitle').innerHTML=\"$S_location\";";
								echo updatePlayers();
								include_once('locationText.php');
							}

							return;
						}else{
						 	$_SESSION['S_attempt']+=1;
						 	if($_SESSION['S_attempt']>=10){
								echo"alert('You have been logged out [bc].');";
								echo"window.location=\"".SERVERURL."/\";";
								exit();
							}
						 	echo"$('botInputField').value='';";
							echo"$('botImage').src='workimage.php?".rand(1,10000)."';";
							return;
						}
					}
			     }//mysql


		echo"if($('centerDropList')){Sortable.destroy('centerDropList');}";
		echo"if($('houseInventory')){Sortable.destroy('houseInventory');}";


		$output.="<br /><br /><br /><br /><center><table cellpadding=0 cellspacing=0 width=80%>";
		$output.="<tr><td width=13 height=13 background=layout/layout3_LB.jpg></td><td background=layout/layout3_B.jpg></td><td width=13 background=layout/layout3_RB.jpg></td></tr>";
		$output.="<tr><td background=layout/layout3_L.jpg></td><td class=inhoud valign=top align=center>";
		$output.="<table width=100%><tr><td width=10></td><td align=left valign=top id='LocationContent'>";


		$output.="<font color=white><center><br /><br /><b>Please repeat the numbers from the image to continue</b><br /><br />";
		$output.="<img id='botImage' src=workimage.php?".rand(1,10000)." /><br />";
		$output.="<br />";
		$output.="<form onsubmit=\"postBotNumber();return false;\">";
		$output.="<input type=hidden name=rand value=$rano>";
		$output.="<input type=text name=nummer id='botInputField' size=8 class=input>";
		$output.="<input type=submit value='Continue' class=button>";
		$output.="</form>";
		$output.="<br /><br />";
		$output.="</center>";

		$output.="</td><td width=10></td></tr></table>";
		$output.="<br />";
		$output.="</td><td background=layout/layout3_R.jpg></td></tr>";
		$output.="<tr><td width=13 height=13 background=layout/layout3_LO.jpg></td><td background=layout/layout3_O.jpg></td><td background=layout/layout3_RO.jpg></td></tr>";

		//make room for chat
		$output.="<tr height=210><td height=210></td><td></td><td></td></tr>";

		$output.="</table></center>";





		$output=str_replace('
	', '', $output);
		$output=str_replace('"', '\\"', $output);
		echo "$('centerContent').innerHTML=\"$output\";";
	 	echo "if($('chatMessage').value==\"\"){\$('botInputField').focus();}";
	 	return;

	}else if($layoutOption=="showPlayer"){



		$resultaat = mysqli_query($mysqli,"SELECT * FROM users WHERE location='$S_location' && username='$option2' LIMIT 1" );
		while ($record = mysqli_fetch_object($resultaat)) {$playerIsHere=1;

            $totallevels = $record->totalskill;
            $combatlevel = $record->level;
			$smithingll=floor(pow($record->smithing, 1/3.507655116));
			$miningll=floor(pow($record->mining, 1/3.507655116));
			$fishingll=floor(pow($record->fishing, 1/3.507655116));
			$strengthll=floor(pow($record->strength, 1/3.507655116));
			$defencell=floor(pow($record->defence, 1/3.507655116));
			$attackll=floor(pow($record->attack, 1/3.507655116));
			$healthll=floor(pow($record->health, 1/3.507655116));
			$speedll=floor(pow($record->speed, 1/3.507655116));
			$tradingll=floor(pow($record->trading, 1/3.507655116));
			$thievingll=floor(pow($record->thieving, 1/3.507655116));
			$constructingll=floor(pow($record->constructing, 1/3.507655116));
			$woodcuttingll=floor(pow($record->woodcutting, 1/3.507655116));
			$cookingll=floor(pow($record->cooking, 1/3.507655116));
			$magicll=floor(pow($record->magic, 1/3.507655116));
			$farmingll=floor(pow($record->farming, 1/3.507655116));

				$clan='';

			  	$sql = "SELECT name, rank, tag, pw FROM clans WHERE username='$option2' LIMIT 1";
			   	$resultaat = mysqli_query($mysqli, $sql);
			    while ($record = mysqli_fetch_object($resultaat)) {
				 	$clanname=stripslashes($record->name);
					$clanrank=stripslashes($record->rank);
					$clantag=stripslashes($record->tag);
					$clan="<Table><tr><td>Clan:<td>$clanname<tr><td>Clan tag:<Td>$clantag</table>";
				}

			$output.="<center><h1>$option2</h1>$clan";
			$output.="<hr />";

			$output.="<table><tr valign=top><td>";

			 $showmen=1; $naam=$option2;
			 //include('wearstats.php');

			if(strtoupper($option2)<>'M2H'){

				$output.="<td width=25><td>";
				$output.="<table border=1>";
				$output.="<tr><td width=100><b>Skill</td><td width=5><b>Level</b></td></tr>";
				$output.="<tr><td>Total<Td>$totallevels</td></tr>";
				$output.="<tr><td>Combat<Td>$combatlevel</td></tr>";
				$output.="<tr><td>Smithing<Td>$smithingll</td></tr>";
				$output.="<tr><td>Mining<Td>$miningll</td></tr>";
				$output.="<tr><td>Cooking<td>$cookingll</td></tr>";
				$output.="<tr><td>Fishing<td>$fishingll</td></tr>";
				$output.="<tr><td>Constructing<td>$constructingll</td></tr>";
				$output.="<tr><td>Trading<td>$tradingll</td></tr>";
				$output.="<tr><td>Thieving<td>$thievingll</td></tr>";
				$output.="<tr><td>Strength<td>$strengthll</td></tr>";
				$output.="<tr><td>Health<td>$healthll</td></tr>";
				$output.="<tr><td>Defence<td>$defencell</td></tr>";
				$output.="<tr><td>Attack<td>$attackll</td></tr>";
				$output.="<tr><td>Woodcutting<td>$woodcuttingll</td></tr>";
				$output.="<tr><td>Speed<td>$speedll</td></tr>";
				$output.="<tr><td>Magic<td>$magicll</td></tr>";
				$output.="<tr><td>Farming</td><td>$farmingll</td></tr>";
				$output.="</table><br />";

				if($S_mapNumber>=1 && $S_mapNumber!=3 && $S_mapNumber!=14 && $S_user!=$option2){
					$output.="<a href='' onclick=\"thieving('player','$option2','');return false;\">Thief $option2</a><br /><br />";
				}

			$output.="</td><td>";
			$output.="<table class=\"playerwearDisplay\" id=\"playerwearDisplay\" border=0 cellpadding=0>";
			$output.="<tr align=right valign=bottom>";
			$output.="<td width=45 height=45></td>";
			$output.="<td width=45 height=45 bgcolor=333333 id='displayPlayerHelm' height=45 background=''></td>";
			$output.="<td width=45 height=45 id='displayPlayerTrophy'></td>";
			$output.="</tr>";
			$output.="<tr align=right valign=bottom>";
			$output.="<td width=45 height=45 bgcolor=333333 id='displayPlayerShield'></td>";
			$output.="<td width=45 height=45 bgcolor=333333 id='displayPlayerBody'></td>";
			$output.="<td width=45 height=45 bgcolor=333333 id='displayPlayerHand'></td>";
			$output.="</tr>";
			$output.="<tr align=right valign=bottom>";
			$output.="<td width=45 height=45 ></td>";
			$output.="<td width=45 height=45 bgcolor=333333 id='displayPlayerLegs'></td>";
			$output.="<td width=45 height=45 bgcolor=333333 id='displayPlayerGloves'></td>";
			$output.="</tr>";
			$output.="<tr align=right valign=bottom>";
			$output.="<td width=45 height=45 bgcolor=333333 id='displayPlayerHorse'></td>";
			$output.="<td width=45 height=45 bgcolor=333333 id='displayPlayerShoes'></td>";
			$output.="<td width=45 height=45 ></td>";
			$output.="</tr>";
			$output.="</table>";
			$output.="<br />";
			$output.="<table cellpadding=0 cellspacing=0>";
			$output.="<tr><td><b>Armour:</b></td><td id='displayPlayerArmour'></td></tr>";
			$output.="<tr><td><b>Aim:</b></td><td id='displayPlayerAim'></td></tr>";
			$output.="<tr><td><b>Power:</b></td><td id='displayPlayerPower'></td></tr>";
			$output.="<tr><td><b>Travel:</b></td><td id='displayPlayerTravelTime'></td></tr>";
			$output.="</table>";

			}else{
			 	$output.="No stats found...<br />";
			}
			$output.="</td></tr></table>";
		}


		if($playerIsHere!=1){
		 	$output.="<Br>The player <B>$option2</b> is not located at $S_location anymore, therefore you cannot see their info.<BR>";
			 echo updatePlayers();
		}


		$output=str_replace('"', '\\"', $output);
	 echo "$('LocationContent').innerHTML=\"$output\";";
	 include_once('includes/wearstats.php');
	wearStats($option2, 0);
	 return;

	}else if($layoutOption=="move"){

		include('includes/move.php');

	}else if($S_mapNumber==3 || $S_mapNumber==14){
	 //PVP LAYOUT

		$output="<center><table cellpadding=0 cellspacing=0 height=100% width=98%>";

		$output.="<tr valign=top height=50><td valign=middle align=center>";

		$output.="<Table cellpadding=0 cellspacing=0 width=\"100%\">";
		$output.="<tr><td align=center width=80><img src=layout/pvp/OLskull.jpg /></td>";
		$output.="<td align=center><b><font id='locationTitle' face=\"Monotype Corsiva, Bookman Old Style, verdana\" color=#BB0000 size=5>$S_location</font></b></td>";
		$output.="<td  align=center width=80><img src=layout/pvp/OLskull.jpg /></td></tr>";
		$output.="</table>";



		$output.="</td><td width=10>";
		$output.="</td><td width=256 align=center valign=middle>";

			if($S_mapNumber==14){
 				$output.="<small>You are in an arena, you can be killed but you will NOT lose your items.</small>";
			}else{
 				$output.="<small>If you die out here, you will lose all your items!</small>";
			}



		$output.="</td></tr><tr valign=top>";


		$output.="<td align=left><div id='combatLog' class=\"pvpCombatLog\" style=\"width:100%;height:260px;overflow:auto\">";
		$output.="</div>";


		$output.="</td><td> </td>";

		$output.="<td valign=top width=256 align=center>";

		$output.="<table border=0 width=256 cellspacing=0 cellpadding=0>";
		//$output.="<tr><td bgcolor=#DFB533 width=0></td><td bgcolor=#DFB533></td><td width=0 bgcolor=#DFB533></td></tr>";
		$output.="<tr><td bgcolor=#DFB533></td><td>";
		$output.="<center><b>Players at this location:</b><br />";
		$output.="<br />";
		$output.="<div id='centerPlayerList' style=\"width:100%; height:230px; border: 0;overflow:auto\">";
		$output.="</div></center><div id='playerAmount' style=\"text-align: center;\"></div>";
		$output.="</td><td bgcolor=#DFB533></td></tr>";
		//$output.="<tr><td bgcolor=#DFB533 width=0></td><td bgcolor=#DFB533></td><td bgcolor=#DFB533></td></tr>";
		$output.="</table>";




		$output.="</td></tr><tr valign=top><td>";

		$output.="<br /><Table cellpadding=0 cellspacing=0 width=100%>";
		$output.="<tr><td width=13 height=13 background=layout/pvp/blackSier_LB.jpg></td><td background=layout/pvp/blackSier_B.jpg></td><td width=13 background=layout/pvp/blackSier_RB.jpg></td></tr>";
		$output.="<tr height=100><td background=layout/pvp/blackSier_L.jpg></td><td valign=top align=center>";
		$output.="<table width=100%>";
		$output.="<tr><td width=10></td><td align=left valign=top id='OLActions'>";
		$output.="</td><td width=10></td></tr>";
		$output.="<tr><td width=10></td><td align=left valign=top id='LocationContent'>";
		$output.="</td><td width=10></td></tr>";
		$output.="</table>";
		$output.="<br />";
		$output.="</td><td background=layout/pvp/blackSier_R.jpg></td></tr>";
		$output.="<tr><td width=13 height=13 background=layout/pvp/blackSier_LO.jpg></td><td background=layout/pvp/blackSier_O.jpg></td><td background=layout/pvp/blackSier_RO.jpg></td></tr>";
		$output.="</table></center>";



		$output.="</td><td> </td><td align=center>";


					$output.="<br /><table border=0 width=256 cellspacing=0 cellpadding=0>";
		//$output.="<tr><td bgcolor=#DFB533 width=0></td><td bgcolor=#DFB533></td><td width=0 bgcolor=#DFB533></td></tr>";
		$output.="<tr><td bgcolor=#DFB533></td><td>";
		$output.="<center><b>Dropped items:</b><br />";

		if($S_disableDragDrop==1){
			$output.="<small id='droppingAddOnButton'><a href='' onclick=\"$('droppingAddOnButton').hide();$('droppingAddOffButton').show();return false;\">Click here</a> to drop items</small>";
			$output.="<small id='droppingAddOffButton' style=\"display:none;\">You are dropping items. (Do so by clicking on items in your inventory)<br />";
			$output.="<a href='' onclick=\"$('droppingAddOnButton').show();$('droppingAddOffButton').hide();return false;\">Click here</a> to stop dropping items.</small>";
			$output.="<br /><br />";
		}

		$output.="<small>Move:</small><input type=text size=3 style=\"border : 0px solid #000000;font-size : 9px;\" value=1 id='moveMuch'></center><br/>";
		$output.="<div id='centerDropList' style=\"width:100%; height:100px; border: 0;\">";
		$output.="</div></center></td><td bgcolor=#DFB533></td></tr>";
		//$output.="<tr><td bgcolor=#DFB533 width=0></td><td bgcolor=#DFB533></td><td bgcolor=#DFB533></td></tr>";
		$output.="</table>";



		$output.="</td></tr>";

		//chat height
		//$output.="<tr height=225><td height=225></td></tr>";

		$output.="</table>";

		$output=str_replace('
		', '', $output);
		$output=str_replace('"', '\\"', $output);
		echo "$('centerContent').innerHTML=\"$output\";";
		echo "iDMO('centerDropList');";



	 	RebuildDropList();

		include_once('includes/pvp.php');

		return;


		return;

	}else{
	 //CITY LAYOUT

		$output.="<table cellpadding=0 cellspacing=0 height=100% width=100%>";
		$output.="<tr><td valign=top width=206 align=center>";

		$output.="<table border=0 width=206 cellspacing=0>";
		$output.="<tr><td bgcolor=#DFB533 width=8></td><td bgcolor=#DFB533></td><td width=8 bgcolor=#DFB533></td></tr>";
		$output.="<tr><td bgcolor=#DFB533></td><td class=inhoud id=centerCityContents>";
		$output.="</td><td bgcolor=#DFB533></td></tr>";
		$output.="<tr><td bgcolor=#DFB533 width=8></td><td bgcolor=#DFB533></td><td bgcolor=#DFB533></td></tr>";
		$output.="</table>";

		$output.="<table border=0 width=206 cellspacing=0>";
		$output.="<tr><td bgcolor=#DFB533 width=8></td><td bgcolor=#DFB533></td><td width=8 bgcolor=#DFB533></td></tr>";
		$output.="<tr><td bgcolor=#DFB533></td><td class=inhoud>";
		$output.="<center><b>Players at this location:</b><br />";
		$output.="<br />";
		$output.="<div id='centerPlayerList' style=\"width:100%; height:200px; border: 0;overflow:auto\">";
		$output.="</div></center><div id='playerAmount' style=\"text-align: center;\"></div>";
		$output.="</td><td bgcolor=#DFB533></td></tr>";
		$output.="<tr><td bgcolor=#DFB533 width=8></td><td bgcolor=#DFB533></td><td bgcolor=#DFB533></td></tr>";
		$output.="</table>";


		$output.="<table border=0 width=206 cellspacing=0>";
		$output.="<tr><td bgcolor=#DFB533 width=8></td><td bgcolor=#DFB533></td><td width=8 bgcolor=#DFB533></td></tr>";
		$output.="<tr><td bgcolor=#DFB533></td><td class=inhoud>";

		$output.="<center><b>Dropped items:</b><br />";

		if($S_disableDragDrop==1 && $S_mapNumber!=0){
			$output.="<small id='droppingAddOnButton'><a href='' onclick=\"$('droppingAddOnButton').hide();$('droppingAddOffButton').show();return false;\">Click here</a> to drop items</small>";
			$output.="<small id='droppingAddOffButton' style=\"display:none;\">You are dropping items. (Do so by clicking on items in your inventory)<br />";
			$output.="<a href='' onclick=\"$('droppingAddOnButton').show();$('droppingAddOffButton').hide();return false;\">Click here</a> to stop dropping items.</small>";
			$output.="<br /><br />";
		}

		$output.="<small>Move:</small><input type=text size=3 style=\"border : 0px solid #000000;font-size : 9px;\" value=1 id='moveMuch'></center><br/>";
		if($S_mapNumber==0){
		 	$output.="<div id='centerDropList' style=\"width:0px; height:0px; border: 0;\"></div><center><small>You can not drop items in the tutorial.</small></center><br/>";
		}else{
			$output.="<div id='centerDropList' style=\"width:100%; height:100px; border: 0;\"></div>";
		}


		$output.="</center></td><td bgcolor=#DFB533></td></tr>";
		$output.="<tr><td bgcolor=#DFB533 width=8></td><td bgcolor=#DFB533></td><td bgcolor=#DFB533></td></tr>";
		$output.="</table>";

		$output.="<td valign=top align=center>";

		$output.="<Table cellpadding=0 cellspacing=0 width=\"100%\">";
		$output.="<tr><td background=layout/layout3_Shieldleft.jpg width=44></td>";
		$output.="<td background=layout/layout3_Shieldmid.jpg height=77 align=center><b><font id='locationTitle' face=\"Monotype Corsiva, Bookman Old Style, verdana\" color=#E7C720 size=6>$S_location</font></b></td>";
		$output.="<td background=layout/layout3_Shieldright.jpg width=44></td></tr>";
		$output.="</table>";


		$output.="<Table cellpadding=0 cellspacing=0 width=100%>";
		$output.="<tr><td width=13 height=13 background=layout/layout3_LB.jpg></td><td background=layout/layout3_B.jpg></td><td width=13 background=layout/layout3_RB.jpg></td></tr>";
		$output.="<tr height=100><td background=layout/layout3_L.jpg></td><td class=inhoud valign=top align=center>";
		$output.="<table width=100%><tr><td width=10></td><td align=left valign=top id='LocationContent' height=350 >";






		$output.="</td><td width=10></td></tr></table>";
		$output.="<br />";
		$output.="</td><td background=layout/layout3_R.jpg></td></tr>";
		$output.="<tr><td width=13 height=13 background=layout/layout3_LO.jpg></td><td background=layout/layout3_O.jpg></td><td background=layout/layout3_RO.jpg></td></tr>";


		$output.="</table>";

		$output.="</td></tr>";

		//chat height
		//$output.="<tr height=225><td height=225></td></tr>";


		$output.="</table>";

		$output=str_replace('"', '\\"', $output);
		echo"$('centerContent').innerHTML=\"$output\";";
		echo "iDMO('centerDropList');";


		return;
	}

}

}
?>