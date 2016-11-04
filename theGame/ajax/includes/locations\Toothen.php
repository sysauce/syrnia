<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR><BR>";
$output.="<a href='' onclick=\"locationText('arena');return false;\"><font color=white>The battlemage</a><BR><br/>";

/*$sql = "SELECT II.name FROM items_inventory II
    LEFT JOIN item_types T ON T.name = II.type
    LEFT JOIN items I ON I.name = II.name
    WHERE II.username='$S_user' && II.type='food' && II.name NOT LIKE '%cooked%' ORDER BY I.rank = 0 ASC, I.rank ASC, I.name ASC";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat)) { $output.="<a href='' onclick=\"locationText('work', 'cooking','$record->name');return false;\"><font color=white>Cook $record->name</a><BR>"; }*/
$output.= getRawsForCooking();

} elseif($locationshow=='LocationText'){

if($action=='arena'){
	include('textincludes/arena.php');
}else{
$output.=" The cooks of Toothen always have a tough time keeping up with the hungry pirates that visit here.  The smell of burnt food lingers throughout the town.  ";
}



}
}
?>


