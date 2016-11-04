<?
if(defined('AZtopGame35Heyam')){

if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"fighting('$S_location');return false;\"><font color=white>Fight available warriors</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

$output.="You are allowed to fight all elves on Exella plain. Elves that are booted out of town get sent to these plains, most of them get killed.<BR>";
$output.="Some who survive are still fighting...<BR>";
$output.="You will also find some other elves which train their combat at this plain.<BR>";

}
}
?>