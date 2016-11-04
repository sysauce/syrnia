<?
if(defined('AZtopGame35Heyam')){

if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'fishing');return false;\"><font color=white>Fish</a><BR>";
$output.="<BR>";

}else if($locationshow=='LocationText'){

$output.="Welcome to Lisim, <BR><BR>";
$output.="Instead of fishing on the rough sea, you can also throw out your rod at Lisim!<br>";
$output.="Lisim lies next to a big lake, where many fish lives! When you catch some fish, you should try to cook them at Harith!<br>";
$output.="Try not to lose your patience when fishing!";

}
}
?>