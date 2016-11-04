<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>Harith</a><BR>";
$output.="<a href='' onclick=\"locationText('floral');return false;\"><font color=white>$S_location's House of Floral</a><BR><BR>";

/*$sql = "SELECT II.name FROM items_inventory II
    LEFT JOIN item_types T ON T.name = II.type
    LEFT JOIN items I ON I.name = II.name
    WHERE II.username='$S_user' && II.type='food' && II.name NOT LIKE '%cooked%' ORDER BY I.rank = 0 ASC, I.rank ASC, I.name ASC";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat)) { $output.="<a href='' onclick=\"locationText('work', 'cooking','$record->name');return false;\"><font color=white>Cook $record->name</a><BR>"; }*/
$output.= getRawsForCooking();

}else if($locationshow=='LocationText'){

if($action=='floral'){
	include('textincludes/floral.php');
}else{
	$output.="Hey and welcome to Harith!<BR><BR>";
	$output.="When you want your food nicely cooked, you should go to Harith.<br>";
	$output.="Harith is the town where the best cooks of Syrnia live. Maybe you will become one yourself too!<br>";
	$output.="This is the place to prove yourself a good cook!";
}

}
}
?>