<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR><br/>";
$output.="<a href='' onclick=\"locationText('sail');return false;\"><font color=white>Sail</a><BR>";
$output.="<BR>";


  $sql = "SELECT name FROM items_inventory WHERE username='$S_user' && (name='Small fishing boat' OR name='Trawler') LIMIT 2";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {
    $output.="<a href=''  onclick=\"locationText('work', 'fishing', '$record->name');return false;\"><font color=white>Fish with $record->name</a><BR>"; }






} elseif($locationshow=='LocationText'){


if($action=='sail'){

	include('textincludes/sailing.php');

}else{

	$output.="These long forgotten docks hold ancient fish long thought extinct. It's said only the best of fishers can hope to find them. ";
	$output.="While hunting these ancient fish, the best fishers have found other fish. The legend says that the presence of the God of Water Fishing is among us. ";
	$output.="It is said to be that you can see the God of All Cods fishing in the sunset on his fishing boat.<br />";
	$output.=" <br/>";
}

}
}
?>