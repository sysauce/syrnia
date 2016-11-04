<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){



$output.="This part of the cave does not contain any tents, unlike the other cave systems. Something seems to be wrong here.<BR>";
$output.="You see a big dark entrance, which leads you deeper in this cave.<BR>";
$output.="<BR>";
$output.="<A href='' onclick=\"updateCenterContents('move', 'Arch. cave 2.1');return false;\">Move deeper in the cave</a>";






}
}
?>