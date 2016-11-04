<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR><br/>";
$output.="<a href='' onclick=\"locationText('sail');return false;\"><font color=white>Sail</a><BR>";
$output.="<BR>";

  $sql = "SELECT name FROM items_inventory WHERE username='$S_user' && name='Boat' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) { $output.="<a href='' onclick=\"locationText('work', 'fishing', 'Boat');return false;\"><font color=white>Fish with Boat </a><BR>"; }



} elseif($locationshow=='LocationText'){


if($action=='sail'){

include('textincludes/sailing.php');


}else{
    $output.="Welcome to Heerchey island. The Heerchey family owns this island and you better watch your steps: they decide whats allowed or not on here.<BR>";
}


}
}
?>