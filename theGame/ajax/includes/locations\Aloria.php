<?php
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";

if(stristr($_SESSION['S_questscompleted'], "[12]")){
 	$output.="<a href='' onclick=\"locationText('work', 'woodcutting');return false;\"><font color=white>Woodcut</a><BR>";
	}

$output.="<BR>";

} elseif($locationshow=='LocationText'){


	$output.="An ever stretching forest of tall, slim trees of various species. Although the leaves are not truly golden, the intensely ";
	$output.="bright sun leads them to shine brightly, which is how the forest developed its name. ";
	$output.="It's been said that the Prince of Nature sleeps in a big oak tree deep within the Elite Forest.<br />";
	$output.="<br />";

	$questID='12';
	if(stristr($_SESSION['S_questscompleted'], "[$questID]")===false && ( stristr($_SESSION['S_quests'], "$questID(")==''  OR  stristr($_SESSION['S_quests'], "$questID(2)]")<>'' )){
		$output.="<BR><BR>";
		include('textincludes/quests.php');
	}



}
}
?>