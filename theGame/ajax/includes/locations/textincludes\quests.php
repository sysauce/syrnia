<?
if(defined('AZtopGame35Heyam')){


if($lootwasquestitem){
	// ### QUEST LOOT BEGIN
	// ----------------------

		//Location requirement was removed here as it wasnt included in FIGHTING.pHP drop code either
	      $resultaat = mysqli_query($mysqli,"SELECT quests.questID as questID, quests.subID as subID FROM quests JOIN questslist ON questslist.questID=quests.questID && questslist.subID=quests.subID  WHERE  give='$lootwasquestitem' && username='$S_user' && completed=0 LIMIT 1");
	    while ($record = mysqli_fetch_object($resultaat))
		{
			$questID=$record->questID;
			$subID=$record->subID;
		}


	   $resultaat = mysqli_query($mysqli,"SELECT questID, subID, kills FROM questslist WHERE questID='$questID' && subID>$subID LIMIT 1");
	    while ($recoord = mysqli_fetch_object($resultaat))
		{
	      	mysqli_query($mysqli,"DELETE FROM quests WHERE questID='$questID' && username='$S_user' LIMIT 1") or die("error report taseMESSAGE");
	 		$sqll = "INSERT INTO quests (username, questID, type, killsleft, subID)
	         VALUES ('$S_user', '$recoord->questID', '1', '$recoord->kills', '$recoord->subID')";
	      	mysqli_query($mysqli,$sqll) or die("erroraa re23port this bug.");
		}


	   	### CREATE NEW QUESTS VAR
	   	$_SESSION['S_questscompleted']=''; $_SESSION['S_quests']='';
		$resulteaaat = mysqli_query($mysqli,"SELECT completed, questID,subID FROM quests WHERE username='$S_user'");
	   	while ($reco = mysqli_fetch_object($resulteaaat)) {

			if($reco->completed==1){  $_SESSION['S_questscompleted']=$_SESSION['S_questscompleted']."[$reco->questID]";
			}else{    $_SESSION['S_quests']=$_SESSION['S_quests']."[$reco->questID($reco->subID)]";   }
	   	}

	// ### QUEST LOOT EINDE
	// ----------------------

}else{


if($fight){
 $sql = "SELECT quests.questID as questID FROM quests LEFT JOIN questslist ON questslist.questID=quests.questID && questslist.subID=quests.subID " .
    "WHERE (location='$S_location' OR location LIKE 'Arch. cave 5%') && killtype='$fight' && username='$S_user' LIMIT 1";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat)) { $questID=$record->questID;  $accept=1; }
}
if($gather){
 $sql = "SELECT quests.questID as questID FROM quests LEFT JOIN questslist ON questslist.questID=quests.questID && questslist.subID=quests.subID  WHERE location='$S_location' && gathername='$gather' && username='$S_user' && completed=0 LIMIT 1";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat)) { $questID=$record->questID;  $accept=1;}
}

if($var2=='yes'){
	$accept=1;
}else if($var2=='no'){
	$fail=1;
}


   $completed=0;
   $subID='';
#Get quest vars
      $resultaat = mysqli_query($mysqli,"SELECT quest, quests.subID as subID, location,description, completed, gatherleft, gathername, killsleft, killtype, failtekst, give, talkto, givemuch " .
          "FROM quests LEFT JOIN questslist ON questslist.questID=quests.questID && questslist.subID=quests.subID  WHERE quests.questID='$questID' && username='$S_user' LIMIT 1");
    while ($record = mysqli_fetch_object($resultaat))
	{
		$quest=$record->quest;
		 $talkto=$record->talkto; $killsleft=$record->killsleft; $killtype=$record->killtype;
		 $gatherleft=$record->gatherleft; $gathername=$record->gathername;
		 $questfailtekst=$record->failtekst; $subID=$record->subID; $questgive=$record->give;
	     $questgivemuch=$record->givemuch;     $questdescription=$record->description; $questlocation=$record->location;
		 $completed=$record->completed;
    }


if($subID==''){$subID=-1; }
if(($S_location==$questlocation OR (!(stristr($S_location, 'Arch. cave 5') === false && !stristr($questlocation, 'Arch. cave 5') === false))) && $completed==0 OR $subID==-1){

		   $resultaat = mysqli_query($mysqli,"SELECT * FROM questslist WHERE questID='$questID' && (location='$S_location' OR location LIKE 'Arch. cave 5%') && subID>=$subID ORDER BY subID ASC LIMIT 1");
		    while ($record = mysqli_fetch_object($resultaat)) {
			
			if($subID == -1)
			{
				$quest=$record->quest;
				$questgive=$record->give;
				$questgivemuch=$record->givemuch;
				$questfailtekst=$record->failtekst;
			}
		if($accept){	### QUEST ACCEPTED
		$aantal=1;
		if($questgive && $questgivemuch>0){ # CHECK IF ITEMS GEGEVEN MOETEN
		if($questgive=='gold'){
		    	$aantal = mysqli_num_rows(mysqli_query($mysqli, "SELECT username FROM users WHERE gold>='$questgivemuch' && username='$S_user' LIMIT 1"));
		    }else{
		   		$aantal = mysqli_num_rows(mysqli_query($mysqli, "SELECT much FROM items_inventory WHERE name='$questgive' && much>=$questgivemuch && username='$S_user'  LIMIT 1"));
		   }
		}

		if($killsleft>0){  # CHECK IF ER GEKILLT MOET EN GEDAAN IS
			if($fight==$killtype && $fight){
				mysqli_query($mysqli,"UPDATE quests SET killsleft=killsleft-1 WHERE questID='$questID' && username='$S_user' LIMIT 1") or die("err2or --> A1");
				$killsleft--;
			}
			if($killsleft>=1){ $aantal=0;  }
		}


		if($gatherleft>0){  # CHECK IF ER GEKILLT MOET EN GEDAAN IS
			if($gather==$gathername && $gather){ mysqli_query($mysqli,"UPDATE quests SET gatherleft=gatherleft-1 WHERE questID='$questID' && username='$S_user' LIMIT 1") or die("err2or --> A1");
			$gatherleft--;
			}
			if($gatherleft>=1){
				$aantal=0;
			}else{
				$check=2;  //stop work, if any
			}
		}


		if($aantal==1){
		## FINISH QUEST DEEL

			if($questgive && $questgivemuch>0){
				if($questgive=='gold'){
					payGold($S_user, $questgivemuch);
				}else{
					removeItem($S_user, $questgive, $questgivemuch, '', '', 1);
				}
			}

			#NEW ACCEPT OF FINISH
			$output.= parseQuestText($record->succestekst, $action)."<br/>";

			 $resultaat = mysqli_query($mysqli,"SELECT * FROM questslist WHERE questID='$questID' && subID>$record->subID order by subID asc LIMIT 1");
			    while ($recoord = mysqli_fetch_object($resultaat))
				{

					$completed='no';
				    mysqli_query($mysqli,"DELETE FROM quests WHERE questID='$questID' && username='$S_user' LIMIT 1") or die("error report taseMESSAGE");
				    $tekst2=addslashes($recoord->tekst);
				    $succestekst=addslashes($recoord->succestekst);
				    $failtekst=addslashes($recoord->failtekst);
				 	$sqll = "INSERT INTO quests (username, questID, type,  killsleft, gatherleft, subID)
				         VALUES ('$S_user', '$recoord->questID', '1', '$recoord->kills', '$recoord->gathermuch', '$recoord->subID')";
				    mysqli_query($mysqli,$sqll) or die("erroraa re23port this bug    ");
				}

			if($completed<>'no'){  ## QUEST COMPLETED !


		mysqli_query($mysqli,"UPDATE quests SET completed=1 WHERE username='$S_user' && questID='$questID' LIMIT 1") or die("err2or --> C1");


					$resultaat = mysqli_query($mysqli,"SELECT rewardname, rewardmuch, rewardtype FROM questrewards WHERE questID='$questID'");
					while ($recoord = mysqli_fetch_object($resultaat))
					{
						 if($recoord->rewardtype<>'skill' && $recoord->rewardname<>'gold'){ #ITEM REWARD
						      addItem($S_user, $recoord->rewardname, $recoord->rewardmuch, $recoord->rewardtype, '', '', 1);
								$output.="<i><font color=yellow>You got $recoord->rewardmuch $recoord->rewardname.</i></font><BR>";
						 }else{
							 if($recoord->rewardname<>'gold'){$expp='experience'; $levelArray=addExp($levelArray, $recoord->rewardname, $recoord->rewardmuch); } else { $expp=''; }
						$output.="<i><font color=green>You got $recoord->rewardmuch $recoord->rewardname $expp.</i></font><BR>";
						mysqli_query($mysqli,"UPDATE users SET $recoord->rewardname=$recoord->rewardname+ $recoord->rewardmuch  WHERE username='$S_user' LIMIT 1") or die("err2or --> E1");
					 }
					}

					$output.="<font color=blue>You have completed the \"$quest\" quest!</font><BR>";
					$check=2; //Stop work, if any
			} #GEEN COMPLETED YET

			$_SESSION['S_questscompleted']=''; $_SESSION['S_quests']='';
			   ### CREATE NEW QUESTS VAR
			   $resulteaaat = mysqli_query($mysqli,"SELECT completed, questID,subID FROM quests WHERE username='$S_user'");
			   while ($reco = mysqli_fetch_object($resulteaaat))
			   {
					if($reco->completed==1){
					 	 $_SESSION['S_questscompleted']=$_SESSION['S_questscompleted']."[$reco->questID]";
					}else{
					 	$_SESSION['S_quests']=$_SESSION['S_quests']."[$reco->questID($reco->subID)]";
					}
			   }

		} else { # FAILED: de resources nog niet binnen dus ook geen completed check
				$output.=  parseQuestText($questfailtekst, $action)."<br />";
		}

		## DECLINE/ABORT TEKST: geen accept maar fail geklikt, lol
		} elseif($fail){
			$output.=  parseQuestText($record->failtekst, $action)."<br />";

		} else{ ## GEEN ACCEPT OF DECLINE: Introductie tekst
			$output.=  parseQuestText($record->tekst, $action)."<br />";
		}

		}
}else{ # HIJ ZIT OP OUDE QUEST LOCATIE...temporary maar even geen quest text neerzetten he


	/*if($BACKY){
		if($S_location==$questlocation){$output.="You have already completed the \"$quest\" quest.<BR>"; }
		elseif($completed!=1){$output.="You are already on the \"$quest\" quest, use this hint for your next objective:<BR><i>$questdescription</i><BR>"; }
		elseif($S_mapNumber==3){ $output.="There is no interesting thing at this location."; }
	}*/

}

}#geen lootwasquestitem

//Reset for next quest
$accept=0;
$fail=0;
$var2='';

}#DEFINE


?>