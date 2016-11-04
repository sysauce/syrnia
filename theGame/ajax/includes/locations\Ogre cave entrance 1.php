<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

	$output.="<center><B>City Menu</B><BR>";
	$output.="<BR>";
	$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</font></a><BR>";
	$output.="<a href='' onclick=\"updateCenterContents('move', 'The Outlands 35');return false;\"><font color=white>Get out of the cave</font></a><BR>";
	$output.="<BR>";

} elseif($locationshow=='LocationText'){

	$output.="Beware of this cave; many ogres live in here.<BR>";
	$output.="They attack any passing human.";



}
}
?>