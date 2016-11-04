<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'fishing');return false;\"><font color=white>Net fishing</a><BR>";

$output.="<BR>";

} elseif($locationshow=='LocationText'){


$output.="This wide and muddy river runs throughout the jungle and gets its name from all the birds and frogs in the area.<br/>";

  
   	$questID=13;
	if(stristr($_SESSION['S_questscompleted'], "[$questID]")===false && ( stristr($_SESSION['S_quests'], "$questID(2)]")     )){
		$output.="<BR><BR>"; 	
		include('textincludes/quests.php');
	} 
	
	$questID=15;
	if(stristr($_SESSION['S_questscompleted'], "[$questID]")===false && ( stristr($_SESSION['S_quests'], "$questID(1)]") OR stristr($_SESSION['S_quests'], "$questID(2)]")     )){
		$output.="<BR><BR>"; 	
		include('textincludes/quests.php');
	} 


}
}
?>