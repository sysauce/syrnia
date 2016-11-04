<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'woodcutting');return false;\"><font color=white>Woodcut</a><BR>";
$output.="<BR>";

}else if($locationshow=='LocationText'){

$output.="The animals have long abandoned this forest making it safe for travel. You see some spiders crawling off in search of their next meal, but fortunately they do not spot you. The trees here are mostly healthy except the growing number that have been covered with webs.";

}
}
?>