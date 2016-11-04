<?php
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><b>City Menu</b><br />";
$output.="<br />";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><br /><br/>";
$output.="<a href='' onclick=\"locationText('sail');return false;\"><font color=white>Sail</a><BR>";
$output.="<a href='' onclick=\"locationText('smokehouse');return false;\"><font color=white>Smokehouse</a><BR>";
$output.="<a href='' onclick=\"locationText('bakery');return false;\"><font color=white>Bakery</a><BR>";
$output.="<a href='' onclick=\"locationText('showJail');return false;\"><font color=white>Jail</a><br />";

$output.="<br />";

if(finishedQuest(21)){
	$fishOutput='';
	$sql = "SELECT name FROM items_inventory WHERE username='$S_user' && name='Canoe' LIMIT 1";
	$resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
		$fishOutput.="<a href='' onclick=\"locationText('work', 'fishing', '$record->name');return false;\"><font color=white>Fish with the $record->name</a><br />";
 	}
 	//if((date(W)+date(d)+date(m))%2==0)
    if(date(z)%2 == 0)
    {
 		$output.=$fishOutput;
 	}
    else
    {
 		$output.="<small>You cannot fish here today</small><br />";
 	}
}


$output.="<br />";

} elseif($locationshow=='LocationText'){
	if($action=='showJail'){

		 	$output.="Got nothing left? you can <a href='' onclick=\"locationText('work', 'other', 'jail');return false;\">clean</a> the $S_location cells for 2 gold pieces per minute.<br /><br />";

		include('textincludes/jail.php');

	}else if($action==='bakery'){
 		$output.="Use the well, the mill and bakery to bake bread. You will need to supply your own grain though!<br/>";
	 	$output.="<a href='' onclick=\"locationText('work', 'other', 'bread');return false;\"><font color=white>Bake bread</a> - (1 grain)<BR>";
	 	if($cookingl>=100){
	 		$output.="<a href='' onclick=\"locationText('work', 'other', 'cake');return false;\"><font color=white>Bake cake</a> - (1 grain, 1 plum)<BR>";
 		}else{
		 	$output.="<i>You need level 100 cooking to bake cake here.</i><BR>";
 		}
	}else if($action=='smokehouse'){

		 if(!finishedQuest(20)){
		 	if($woodcuttingl>=30 && $constructingl>=10){
			 	$questID=20;
				if(!finishedQuest($questID) && doingQuest($questID)==false  ){
					$output.="<br /><br />";
					include('textincludes/quests.php');
				}

				if(doingQuest($questID,1)){
					$output.="<br /><a href='' onclick=\"locationText('work', 'other', 'repairSmokehouse');return false;\">Repair the smokehouse (1 wood each time)</a><br />";
				}
			}else{
				$output.="<br /><br /><i>You need woodcutting level 30 and constructing level 10 for the \"Repair the Smokehouse\" quest.</i><br />";
			}
		}else{

			$output.="Level 80 plus cooks can cook their food in the smokehouse, cooking food will cost one coal per item though!<br />";
			$output.="<br />";

			if($cookingl>=80){
			 	/*$sql = "SELECT II.name FROM items_inventory II
                    LEFT JOIN item_types T ON T.name = II.type
                    LEFT JOIN items I ON I.name = II.name
                    WHERE II.username='$S_user' && II.type='food' && II.name NOT LIKE '%cooked%' ORDER BY I.rank = 0 ASC, I.rank ASC, I.name ASC";
                $resultaat = mysqli_query($mysqli, $sql);
                while ($record = mysqli_fetch_object($resultaat)) { $output.="<a href='' onclick=\"locationText('work', 'cooking','$record->name');return false;\"><font color=white>Cook $record->name</a><BR>"; }*/
                $output.= getRawsForCooking();

                //if((date(W)+date(d)+date(m))%2==0)
                if(date(z)%2 == 0)
                {
                    $output.="<br /><small>You cannot cook Thabis fish here today</small><br />";
                }
		    }else{
		    		$output.="<i>You need level 80 cooking.</i><br />";
		    }
	    }

	}else if($action=='sail'){
		include('textincludes/sailing.php');

	}else{

		$output.="This famous port of old is now open to all Syrnians skillful enough to find the correct path through the reefs. While there is no danger from those who wish to cook the fish, signs point to dangers for anyone wishing to partake in the bountiful sea.<br />";
		$output.="<br />";

		$questID=19;
  		if(doingQuest($questID, 1)){
		 	$output.="<br /><br />";
			include('textincludes/quests.php');
		}


		$questID=21;
		if(!finishedQuest($questID) && doingQuest($questID)==false  ){
			$output.="<br /><br />";
			include('textincludes/quests.php');
		}
		if(doingQuest($questID, 1)){
		 	$output.="<br /><br />";
			include('textincludes/quests.php');
		}
	}


}
}
?>