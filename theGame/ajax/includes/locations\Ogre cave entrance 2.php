<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"updateCenterContents('move', 'Elven gate');return false;\"><font color=white>Exit the cave</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

$output.="This path gains you acces to the Elven island, it used to be blocked because of a war between ogres and elves.<BR>";



}
}
?>