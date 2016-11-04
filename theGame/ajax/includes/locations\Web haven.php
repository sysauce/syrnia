<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR><br/>";
$output.="<a href='' onclick=\"locationText('sail');return false;\"><font color=white>Sail</a><BR>";
$output.="<a href='' onclick=\"locationText('tradingpost');return false;\"><font color=white>Trading post</a><BR>";
$output.="<a href='' onclick=\"locationText('showJail');return false;\"><font color=white>Jail</a><br />";
$output.="<br />";
$output.="<a href='' onclick=\"locationText('work', 'fishing');return false;\"><font color=white>Fish</a><BR>";
$output.="<br />";
$output.="<a href='' onclick=\"locationText('smith');return false;\"><font color=white>Smith</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'smelting', 'Bronze bars');return false;\"><font color=white>Smelt Bronze Bars</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'smelting', 'Iron bars');return false;\"><font color=white>Smelt Iron Bars</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'smelting', 'Steel bars');return false;\"><font color=white>Smelt Steel Bars</a><BR>";
$output.="<br />";

/*$sql = "SELECT II.name FROM items_inventory II
    LEFT JOIN item_types T ON T.name = II.type
    LEFT JOIN items I ON I.name = II.name
    WHERE II.username='$S_user' && II.type='food' && II.name NOT LIKE '%cooked%' ORDER BY I.rank = 0 ASC, I.rank ASC, I.name ASC";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat)) { $output.="<a href='' onclick=\"locationText('work', 'cooking','$record->name');return false;\"><font color=white>Cook $record->name</a><BR>"; }*/
$output.= getRawsForCooking();

}else if($locationshow=='LocationText'){


if($action=='tradingpost'){

	include('textincludes/trading.php');

}elseif($action=='sail'){

include('textincludes/sailing.php');

}else if($action=='showJail'){

	include('textincludes/jail.php');

}else if($action=='smith'){

	$output.="Select something to smith<BR><BR>";
	include("textincludes/smithing.php");

}else{
	$output.="This is the only part of the island not under danger by the spiders. The threat of spider infestation is high though which is why the town is always under heavy guard.<br /><br />";
    $output.="Visitors only come to this island to hunt spiders so they may get the valuable web from them. They help protect this port so they may also receive spider silk as well. When properly used, spider web can help make an item stronger since their web is stronger than steel.";
}

}
}
?>