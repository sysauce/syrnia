<?
if(defined('AZtopGame35Heyam')){

if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"fighting('Deep Lemo woods');return false;\"><font color=white>Enter the deep woods</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

$output.="Only a very few adventurers dare to enter the deep woods...and do you?<BR>";

}
}
?>