<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"locationText('shop');return false;\"><font color=white>Elven shop</a><BR>";
$output.="<a href='' onclick=\"locationText('magic');return false;\"><font color=white>Visit Adarkmage</a><BR>";
$output.="<a href='' onclick=\"locationText('pub');return false;\"><font color=white>Huppele pub</a><BR>";
$output.="<a href='' onclick=\"locationText('casino');return false;\"><font color=white>Elven casino</a><BR>";

$output.="<BR>";

include_once('includes/levels.php');
if($cookingl>=20){
   /*$sql = "SELECT II.name FROM items_inventory II
        LEFT JOIN item_types T ON T.name = II.type
        LEFT JOIN items I ON I.name = II.name
        WHERE II.username='$S_user' && II.type='food' && II.name NOT LIKE '%cooked%' ORDER BY I.rank = 0 ASC, I.rank ASC, I.name ASC";
    $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) { $output.="<a href='' onclick=\"locationText('work', 'cooking','$record->name');return false;\"><font color=white>Cook $record->name</a><BR>"; }*/
    $output.= getRawsForCooking();
}

} elseif($locationshow=='LocationText'){


if($action=='shop'){
	$output.="Welcome to Pentezas shop.<BR>We have got some valuable stuff for sale.<BR>";
	include('textincludes/shop.php');

}elseif($action=='casino'){

  	include('textincludes/casino.php');

}elseif($action=='magic'){
##MAGIC
if($magicl>=20){


	include('textincludes/magic.php');


} else {
	$output.="You have not got enough magical powers yet, otherwise I would like to train you some magic...maybe come back later when you have trained.<BR>";
}

## EINDE MAGIC
}elseif($action=='pub'){
## PUB

$output.="Huppele warmly greets you when entering the pub: \"Welcome back to the Huppele pub!<BR> Enjoy yourself, do you want a drink?\"<BR>";
if($var1=='buy'){
 	$buy=$var2;
 	$cost=0;
	if($buy=='Beer'){$cost=2;}
	elseif($buy=='Elven cocktail'){$cost=5;}
	if($cost>0){
		if(payGold($S_user, $cost)==1){
			addItem($S_user, $buy, 1, 'cooked food', '', '', 1);
			$output.="Here's your $buy!<BR>";
		}
	}
}
$output.="<BR>Drinks:<BR>";
$output.="-<a href='' onclick=\"locationText('pub', 'buy', 'Beer');return false;\">Buy</a> a beer (2 gold)<BR>";
$output.="-<a href='' onclick=\"locationText('pub', 'buy', 'Elven cocktail');return false;\">Buy</a> a elven cocktail (5 gold)<BR>";
$output.="<BR>";


$questID=7;
if(stristr($_SESSION['S_questscompleted'], "[$questID]")===false){
	//if($var1!='quest'){
	//	$output.="You see an man drinking beer on his own..<a href='' onclick=\"locationText('pub', 'quest');return false;\">talk to him</a>.";
	//}else{
		include('textincludes/quests.php');
	//}
}


$output.="<BR><BR>";


##EINDE PUB
}else{
	$output.="This is the big, elven city of Penteza, it has lots of buildings; some of them catch your interest immediately.<BR>";
	$output.="This is the only place in Syrnia which enables you to use 3 wood to cook 4 fish, though you do need to be level 20 in the cooking skill.<BR>";
	
	$questID=26;
	if(stristr($_SESSION['S_questscompleted'], "[$questID]")==false && (stristr($_SESSION['S_quests'], "$questID(2)]") OR stristr($_SESSION['S_quests'], "$questID(3)]")     )){
		$output.="<BR><BR>";
		include('textincludes/quests.php');
	}
}


}
}
?>