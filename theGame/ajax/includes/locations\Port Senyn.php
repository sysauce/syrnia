<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR><br/>";
$output.="<a href='' onclick=\"locationText('sail');return false;\"><font color=white>Sail</a><BR>";
$output.="<a href='' onclick=\"locationText('friddik');return false;\"><font color=white>Visit John Friddik</a><BR>";
$output.="<BR>";

  $sql = "SELECT name FROM items_inventory WHERE username='$S_user' && name='Small fishing boat' LIMIT 1";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
	 $output.="<a href='' onclick=\"locationText('work', 'fishing', 'Small fishing boat');return false;\"><font color=white>Fish with Small fishing boat </a><br />";
	 }


$output.="<BR>";

}else if($locationshow=='LocationText'){

if($action=='friddik'){

	include('textincludes/friddik.php');

}elseif($action=='sail'){

	include('textincludes/sailing.php');


}else{
	$output.="Welcome to Port Senyn,<BR><BR>";
	$output.="This is where you can set your sails and throw out your nets!<br>";
	$output.="It's the biggest fishing place of Syrnia, but you need a boat to fish on the sea.<br>";
	$output.="This is not the place to fish with your rod, you can do that better at Lisim!";
}


}
}
?>