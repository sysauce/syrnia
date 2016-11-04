<?
if(defined('AZtopGame35Heyam')){

if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"fighting('$S_location');return false;\"><font color=white>Fight the outpost</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

$output.="This outpost is full of ogres..It's nice to train here.<BR>";

}
}
?>