<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"fighting('$S_location');return false;\"><font color=white>Attack the spiders</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

	$output.="Upon visiting here one can clearly see this is the main gathering place for the spiders. ";
    $output.="You can see the queens, hunters, and spiderlings lurking within their webs in the treetops. ";
    $output.="You can see webbed corpses hanging down from the tree branches. ";
    $output.="Brave adventurers come here only to try to get the rare silk that spiders will drop.<br />";
}
}
?>