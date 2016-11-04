<?php
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
if(stristr($_SESSION['S_questscompleted'], "[8]")<>''){
	$output.="<a href='' onclick=\"locationText('work', 'mining', 'Iron ore');return false;\"><font color=white>Mine Iron ore</a><BR>";
}
$output.="<BR>";

} elseif($locationshow=='LocationText'){


$output.="The ancestral mountains are rich of iron ore, but can not always be mined. Since this island is property of the Heerchey family they decide what is allowed and what is not.<BR>";
$output.="<BR>";

$questID=8;
if(strstr($_SESSION['S_questscompleted'], "[8]")===false && strstr($_SESSION['S_quests'], "[8(")===false){
include('textincludes/quests.php');
}


}
}
?>