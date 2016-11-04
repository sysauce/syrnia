<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){


$output.="This location is just like the other cave systems: A lot of tents with archeologists in it.<BR>";
$output.="But the tent of Tep Diggins draws your attention very easily because of its size.<BR>";

$questID=9;
if(stristr($_SESSION['S_questscompleted'], "[$questID]")===false && stristr($_SESSION['S_quests'], "$questID(1)]")==''){
	$output.="<BR><BR>";
	if($level>=25 && $thievingl>=5){
		include('textincludes/quests.php');
	}else{
		$output.="Quest: <B>The kidnapped lunchbox</B><BR>";
		$output.="<u>You need a minimum combat level of 25 and thieving level 5 to start this quest.</u><BR>";
	}
}




}
}
?>