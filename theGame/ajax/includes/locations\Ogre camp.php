<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"locationText('jail');return false;\"><font color=white>Jail</a><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText('smith');return false;\"><font color=white>Smith</a><BR>";
$output.="<BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

if($action=='jail'){
	include('textincludes/jail.php');
}elseif($action=='smith'){

	$output.="Select something to smith<BR><BR>";

	include("textincludes/smithing.php");

} else {
$output.="This ogre camp has some anvils you may find useful.<BR>";
$output.="The ogres also have a jail here.<BR>";
}

}
}
?>