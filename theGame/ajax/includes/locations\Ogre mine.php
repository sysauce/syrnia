<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'mining', 'Gold ore');return false;\"><font color=white>Mine gold ore</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){


$output.="The ogres have survived for a long time in this cave because of their gold mines.";
$output.=" They have always been trading their gold for resources they could not get inside their cave. But these days a lot of humans plunder the gold mines, the ogres hate the humans for it.";



}
}
?>