<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>Isri</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'woodcutting');return false;\"><font color=white>Woodcut</a><BR>";
$output.="<BR>";

}else if($locationshow=='LocationText'){

$output.="In need of wood? Suit yourself!<BR>";
$output.="Grab a hatchet and collect wood, everyone can use the Isri woods.";

}
}
?>