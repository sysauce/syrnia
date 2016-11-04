<?
if(defined('AZtopGame35Heyam')){

if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>Tutorial 5</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'woodcutting');return false;\"><font color=white>Woodcut</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

$output.="<B><font color=red>You got fish..but how to cook it?</font></B><br />";
$output.="<BR>";
$output.="To cook your shrimps you need to get wood for a fire.";
$output.="<BR>";
$output.="<B>You can move on when you've got at least 1 log.</B>";
$output.="<ol>";
$output.="<li>Equip your hatchet by clicking on it in your inventory at the top left.";
$output.="<li>Click Woodcut at the city menu.";
$output.="</ol>";


 $sq = "SELECT much FROM items_inventory WHERE name='Wood' && username='$S_user' LIMIT 1";
   $resultt = mysqli_query($mysqli, $sq);     $item=0;
    while ($record = mysqli_fetch_object($resultt)) {  $item=$record->much;}


    if($item>=1){
	    $output.="You have got the logs, <B>well done!</B><BR>";
	    $output.="To go to the next tutorial click on the map at the top right.<BR>";

    }else{
    $output.="You have got $item/1 logs.<BR>"; }



}
}
?>