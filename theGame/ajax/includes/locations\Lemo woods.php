<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'woodcutting');return false;\"><font color=white>Woodcut</a><BR>";
$output.="<a href='' onclick=\"fighting('Lemo woods');return false;\"><font color=white>Enter the woods</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

	$output.="It looks like this wood contains many different aggressive creatures, watch your step!<BR>";
	$output.="If you're careful you can try woodcutting at Lemo Woods, only experienced woodcutters can cut here, though.<BR>";

	$questID=11;
	if(stristr($_SESSION['S_questscompleted'], "[$questID]")===false && stristr($_SESSION['S_quests'], "$questID")=='' && $level>=10 && $woodcuttingl>=10){
		$output.="<br /><BR>";
		include('textincludes/quests.php');
	}



}
}
?>