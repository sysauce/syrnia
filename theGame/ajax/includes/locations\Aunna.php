<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href=''  onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"locationText('shop');return false;\"><font color=white>Food store</a><BR>";
$output.="<a href='' onclick=\"locationText('smith');return false;\"><font color=white>Smith</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

if($action=='shop'){
	$output.="<B>Amka:</b> Good good, thanks for taking a look at my shop.<BR>";
	include('textincludes/shop.php');

}elseif($action=='smith'){

	$output.="Select something to smith<BR><BR>";
	include('textincludes/smithing.php');

}else{
	$output.="<B>Amka:</b> Welcome adventurer!<BR>";
	$output.="You should stop by my shop to buy some delicious food in case you are planning to enter the dangerous woods....<BR>";
	$output.="...if you are a miner, then please go away to make room for other customers!";
}


}
}
?>