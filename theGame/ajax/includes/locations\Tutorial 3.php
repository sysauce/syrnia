<?
if(defined('AZtopGame35Heyam')){

if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>Tutorial 3</a><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText('smith');return false;\"><font color=white>Smith</a><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText('work', 'smelting', 'Bronze bars');return false;\"><font color=white>Smelt Bronze Bars</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

if($action=='smith'){
$output.="Select something to smith<BR><BR>";

include("textincludes/smithing.php");


} else {
$output.="<B><font color=red>33% Of the tutorial is finished!</font></B><br /><br />";
$output.="<B>We're going to teach you next skill; smithing</B><BR>";
$output.="You smith using a hammer and anvil.";
$output.="<BR>";
$output.="<B>You can move on after smithing at least 1 item.</B>";
$output.="<ol>";
$output.="<li>Click on 'Smelt bronze bar' in the CITY MENU.";
$output.="<li>If you've created a bronze bar; Equip your hammer to prepare to smith.";
$output.="<li>Click on 'Smith' in the CITY MENU";
$output.="<li>Click on 'Smith bronze item' -> 'Smith bronze dagger'";
$output.="<li>Select an item to create and wait until its done, then return to this page.";
$output.="</ol>";

	//include_once('levels.php');
    if($smithing>=7){ //smelting+smithing exp
    	$output.="You have created an item, well done!</B><BR>";
    	$output.="To go to the next tutorial click on the map at the top right.<BR>";

    }else{
    $output.="You got to smelt your ores and smith an item to continue.<BR>"; }


}

}
}
?>