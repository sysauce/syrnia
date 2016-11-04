<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"locationText('work','woodcutting');return false;\"><font color=white>Woodcut</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

$output.="Not all woodcutters are capable enough to woodcut the ancient Elven forest, are you ?<BR>";

}
}
?>