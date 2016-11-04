<?
if(defined('AZtopGame35Heyam')){

if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>Tutorial 4</a><BR>";
$output.="<a href='' onclick=\"locationText('work','fishing');return false;\"><font color=white>Fish</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

$output.="<B><font color=red>You finished the mining and smithing part, next is fishing.</font></B><br />";
$output.="<BR>";
$output.="You fish using a net, rod or boat, you can start fishing shrimps with your net.<BR>";
$output.="<BR>";
$output.="<B>You can move on when you've caught at least 1 shrimp.</B>";
$output.="<ol>";
$output.="<li>Equip your net by clicking on it in your inventory at the top left.";
$output.="<li>Click FISH at the city menu.";
$output.="</ol>";


 $sq = "SELECT much FROM items_inventory WHERE name='Shrimps' && username='$S_user' LIMIT 1";
   $resultt = mysqli_query($mysqli, $sq);      $shrimp=0;
    while ($record = mysqli_fetch_object($resultt)) {  $shrimp=$record->much;}


    if($shrimp>=1){
    $output.="You have got the shrimps, <B>well done!</B><BR>";
    $output.="To go to the next tutorial click on the map at the top right.<BR>";


    }else{
    $output.="You have got $shrimp/1 shrimps.<BR>"; }



}
}
?>