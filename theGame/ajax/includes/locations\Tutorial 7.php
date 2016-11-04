<?
if(defined('AZtopGame35Heyam')){

if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>Tutorial 7</a><BR>";
$output.="<BR>";



} elseif($locationshow=='LocationText'){

$output.="<B><font color=red>Combat</font></B><br />";
$output.="<BR>";
$output.="You are probably eager to fight, however we will not allow you to fight on the tutorial island since you could die and lose all your items.<BR>";
$output.="You could start fighting in Syrnia right away after completing this tutorial. If you want to fight in Syrnia remember these things:<BR>";
$output.="<ul>";
$output.="<li>Be prepared: Make sure you have <b>cooked</b> food with you to heal yourself.";
$output.="<li>Make sure you have a good set of armour and a weapon (and equip it!).";
$output.="<li>To start fighting go to Valera and fight the Rats at the training grounds.";
$output.="<li>Deposit your valuables in your House so you cannot lose them.";
$output.="</ul>";
$output.="<BR>";
$output.="You can not fight other players on the main islands, you can only fight them in 'The Outlands', which is a huge PvP island.<BR>";
$output.="<BR>";


    $output.="Go to next tutorial by clicking on the map at the top right.<br />";



}
}
?>