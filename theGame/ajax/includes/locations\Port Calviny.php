<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR><BR>";
$output.="<a href='' onclick=\"locationText('sail');return false;\"><font color=white>Sail</a><BR>";
$output.="<a href='' onclick=\"locationText('jail');return false;\"><font color=white>Jail</a><BR>";
$output.="<BR>";

  $sql = "SELECT name FROM items_inventory WHERE username='$S_user' && name='Small fishing boat' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) { $output.="<a href='' onclick=\"locationText('work', 'fishing', '$record->name');return false;\"><font color=white>Fish with Small fishing boat</a><BR>"; }
   $sql = "SELECT name FROM items_inventory WHERE username='$S_user' && name='Sloop' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) { $output.="<a href='' onclick=\"locationText('work', 'fishing', '$record->name');return false;\"><font color=white>Fish with Sloop</a><BR>"; }


$output.="<BR>";

} elseif($locationshow=='LocationText'){

if($action=='sail'){

	include('textincludes/sailing.php');

}elseif($action=='jail'){

	include('textincludes/jail.php');

}else{

	$output.="You have arrived in Exrollia, but you are not the first to discover this island. These shores were first discovered by a sad warrior and his friend.<br/>";
	$output.="<br/>";
	$output.="These two wanderers were lost. They had lost all their friends in battle and had vowed to avenge them at all costs! ";
	$output.="While on their crusade they were ship-wrecked and were lucky to survive. So here they are, continuing to fight forever for Exrollia and their lost friends.<br/>";
	$output.="Beware!";
}


}
}
?>


