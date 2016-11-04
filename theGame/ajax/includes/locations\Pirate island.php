<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>
<BR>
<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>
<a href='' onclick=\"locationText('sail);return false;\"><font color=white>Steal a boat & escape</a><BR>
<BR>";

} elseif($locationshow=='LocationText'){

if($action=='sail'){
$wt=time()+300;
mysqli_query($mysqli, "UPDATE users SET work='move', worktime=$wt, dump='Port Senyn', dump2='0' WHERE username='$S_user' LIMIT 1") or die("error --> 1113");
 $output.="You are preparing to sail to Port Senyn!<BR>
<script type=\"text/javascript\">
setTimeout(\"getMessages()\",3000);
function getMessages(){
document.location.reload();
}
</script>";
}else{
$output.="You have managed to get out of the prison...you'd better escape right away by stealing a boat at the docks!";
}

}
}
?>