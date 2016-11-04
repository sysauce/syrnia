<?
if(defined('AZtopGame35Heyam')){

if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>Tutorial 2</a><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText('inter');return false;\"><font color=white>Learn about the Interface</a><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText('work', 'mining', 'Tin ore');return false;\"><font color=white>Mine Tin ore</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'mining', 'Copper ore');return false;\"><font color=white>Mine Copper ore</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

if($action=='inter'){

$output.="I'm glad you are eager to learn, when beginning a new game you just need to learn a bit about it..this can be boring...";
$output.="but It will make you enjoy the game even more in the end.<BR>";
$output.="<BR>";
$output.="The interface is ordered like this:<BR>";
$output.="<BR>";
$output.="<br>";
$output.="<img src=images/manual/newbie.jpg>";
$output.="<BR>";
$output.="<BR>";
$output.="Return to the main text by clicking on the <i>Tutorial 2</i> link at the City menu (top left).";

} else {
$output.="<B><font color=red>There we are!</font></B><br />";
$output.="You have just travelled to this new location. Travelling costs little time and can gain you speed experience, however you cannot gain experience when using a horse ";
$output.="(You have probably got your horse 'equipped', you can check this at the left).<BR>";
$output.="<BR>";
$output.="<B>We're going to teach you your first skill; mining</B><BR>";
$output.="You mine using a pickaxe, you can only mine if there's an ore available at the current location.<BR>";
$output.="There is copper and tin available at this location.<BR>";
$output.="<BR>";



	$copper=0;
	$tin=0;
 	$sq = "SELECT much FROM items_inventory WHERE name='Copper ore' && username='$S_user' LIMIT 1";
   	$resultt = mysqli_query($mysqli, $sq);
    while ($record = mysqli_fetch_object($resultt)) {  $copper=$record->much;	}
  	$sq = "SELECT much FROM items_inventory WHERE name='Tin ore' && username='$S_user' LIMIT 1";
   	$resultt = mysqli_query($mysqli, $sq);
    while ($record = mysqli_fetch_object($resultt)) {  $tin=$record->much;		}

    if($tin>=1 && $copper>=1){

    	$output.="You have got $tin Tin ore, and $copper copper ore, <B>well done!</B><BR>";
    	$output.="To go to the next tutorial click on the map at the top right.<BR>";

    }else{
		$output.="You can move on after mining at least <b>1 tin</b> and <b>1 copper</b> (You've' got $tin Tin, $copper Copper);<br />";
		$output.="Once you have completed this task click on \"Tutorial 2\" in the city menu to bring you back to this page.</B>";
		$output.="<ol>";
		$output.="<li>Equip your pickaxe by clicking on it in your inventory.";
		$output.="<li>Click Mine Tin ore and mine 1 tin ore. (You might need to refresh your inventory to see your up to date inventory with the ores in it.).";
		$output.="<li>Click Mine copper ore and mine 1 copper ore.";
		$output.="</ol>";
		$output.="If you want you can also learn about the interface using the link at the City Menu.<BR>";
	}


}

}
}
?>