<?
if(defined('AZtopGame35Heyam')){

if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>Tutorial 6</a><BR>";
$output.="<BR>";

  $sql = "SELECT name FROM items_inventory WHERE username='$S_user' && type='food' && name NOT LIKE '%cooked%'";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) { $output.="<a href='' onclick=\"locationText('work','cooking','$record->name');return false;\"><font color=white>Cook $record->name</a><BR>"; }


} elseif($locationshow=='LocationText'){

$output.="<B><font color=red>You got fish and the wood to cook it</font></B><br />";
$output.="<BR>";
$output.="To cook your shrimps you need to get wood for a fire.<BR>";
$output.="<BR>";
$output.="<B>You can move on when you've cooked shrimps.</B>";
$output.="<ol>";
$output.="<li>Equip your tinderbox to be able to light a fire.";
$output.="<li>Click 'cook shrimps' at the city menu.";
$output.="</ol>";


 $sq = "SELECT much FROM items_inventory WHERE name='Shrimps' && username='$S_user' LIMIT 1";
   $resultt = mysqli_query($mysqli, $sq);
    while ($record = mysqli_fetch_object($resultt)) {  $item=$record->much;}

    include_once('includes/levels.php');
    if($item<=0 OR $item=='' OR $cookingl>2 OR $cooking>=2){
    $output.="You have cooked shrimps, <B>well done!</B><BR>";
    $output.="To go to the next tutorial click on the map at the top right.<BR>";

    }else{
    $output.="You have to cook shrimps.<BR>"; }



}
}
?>