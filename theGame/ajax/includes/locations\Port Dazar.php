<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><br />";
$output.="<br />";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><br /><br/>";
$output.="<a href='' onclick=\"locationText('sail');return false;\"><font color=white>Sail</a><br />";
$output.="<br />";



  $sql = "SELECT name FROM items_inventory WHERE username='$S_user' && name='Sloop' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
	 $output.="<a href='' onclick=\"locationText('work', 'fishing', '$record->name');return false;\"><font color=white>Fish with $record->name</a><br />";
	 }
$output.="<br />";

}else if($locationshow=='LocationText'){




if($action=='sail'){

	include('textincludes/sailing.php');

}else{
	$output.="Welcome to Port Dazar,<BR>";
	$output.="this port has been made centuries ago to manage the trading between all of the islands, but now this Island only attracts coal miners and fighters.<BR>";
}


}
}
?>