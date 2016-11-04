<?php
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><b>City Menu</b><br />";
$output.="<br />";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><br />";
$output.="<br />";
$output.="<a href='' onclick=\"locationText('smith');return false;\"><font color=white>Smith</a><BR>";
$output.="<br />";
if(finishedQuest(18) ){ $output.="<a href='' onclick=\"updateCenterContents('move', 'Beset catacombs');return false\"><font color=white>Enter the catacombs</a><br />"; }
$output.="<a href='' onclick=\"locationText('work', 'smelting', 'Obsidian bars');return false;\"><font color=white>Smelt Obsidian bars</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'smelting', 'Syriet bars');return false;\"><font color=white>Smelt Syriet bars</a><BR>";

$output.="<br />";

} elseif($locationshow=='LocationText'){


if($action=='smith'){
	$output.="Select something to smith<BR><BR>";

	include("textincludes/smithing.php");

}else{

	$output.="Warriors from long ago sought to protect Anasco from horrible, unspeakable evil in this town. They were supported by smiths using an extremely hot forge melting all metals but syriet and obsidian.<br />";
	$output.="<br />";

	if($miningl>=30){
		$questID=18;
		if(!finishedQuest($questID) && doingQuest($questID)==false  ){
			$output.="<br /><br />";
			include('textincludes/quests.php');
		}
		if(doingQuest($questID, 1)){
			$output.="<br /><br />";
			$output.="<a href='' onclick=\"locationText('work', 'other', 'stoneclear');return false;\"><font color=white>Mine stone blocks to clear the tomb</a><BR>";
		}
	}else{
		$output.="<br /><br /><i>You need mining level 30 for the \"Clear the tomb\" quest.</i><br />";
	}

	$questID=22;
	if(doingQuest($questID, 1)){
		$output.="<br /><br />";
		include('textincludes/quests.php');
	}else if(doingQuest($questID, 2)){
		$output.="<br /><br />";
		include('textincludes/quests.php');
	}else if(doingQuest($questID, 3)){
		$accept=1;
		$output.="<br /><br />";
		include('textincludes/quests.php');
	}
}


}
}
?>