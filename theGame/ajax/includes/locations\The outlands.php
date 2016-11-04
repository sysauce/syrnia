<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>
<BR>
<a href=?><font color=white>$S_location</a><BR>
<a href=?work=fishing><font color=white>Use your net</a><BR>";

$output.="<BR>";

} elseif($locationshow=='LocationText'){


$output.="This wide and muddy river runs throughout the jungle and gets its name from all the birds and frogs in the area.<br/>";

  
   	$questID=13;
	if(stristr($_SESSION['S_questscompleted'], "[$questID]")===false && ( stristr($_SESSION['S_quests'], "$questID(2)]")     )){
		$output.="<BR><BR>"; 	
		include('quests/quests.php');
	} 
	
	$questID=15;
	if(stristr($_SESSION['S_questscompleted'], "[$questID]")===false && ( stristr($_SESSION['S_quests'], "$questID(1)]") OR stristr($_SESSION['S_quests'], "$questID(2)]")     )){
		$output.="<BR><BR>"; 	
		include('quests/quests.php');
	} 


}
}
?>