<?
if(defined('AZtopGame35Heyam')){

if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"fighting('$S_location');return false;\"><font color=white>Fight the ogres</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

$output.="The ogres don't like you to hang around at their city, they feel threatened and are protecting their kids.<BR>";

}
}
?>