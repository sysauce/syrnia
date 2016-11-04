<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'woodcutting');return false;\"><font color=white>Woodcut</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

	$output.="While unable to see any spiders, one can clearly see the remains of numerous victims laid about all over the forest. Only experienced woodcutters can work here, not only by potential visits by the spiders, but also due to the silk that covers the trees.";
	




}
}
?>