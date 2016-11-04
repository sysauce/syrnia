<?php
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><b>City Menu</b><br />";
$output.="<br />";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><br />";
if(finishedQuest(22) ){ $output.="<a href='' onclick=\"locationText('work', 'woodcutting');return false;\"><font color=white>Woodcut</a><BR>"; }

$output.="<br />";

} elseif($locationshow=='LocationText'){


	$output.="The legendary forest rumored to be myth contains the highest of all prizes for those skillful enough to woodcut here. While some speak of a woodcutting beast who guards the forest, the paths in the forest appear to be safe to work.<br />";
	$output.="<br />";


	if($miningl>=30 && $constructingl>=15){
		$questID=22;
		if(!finishedQuest($questID) && doingQuest($questID)==false  ){
			$output.="<br /><br />"; 
			include('textincludes/quests.php');
		}
	}else{
		$output.="<br /><br /><i>You need mining level 30 and constructing level 15 for the \"Hidden forest\" quest.</i><br />";	
	}

}
}
?>