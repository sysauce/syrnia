<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>Eully</a><BR>";
$output.="<a href='' onclick=\"locationText('shop');return false;\"><font color=white>Eully market</a><BR>";
$output.="<a href='' onclick=\"locationText('tradingpost');return false;\"><font color=white>Trading post</a><BR>";
$output.="<a href='' onclick=\"locationText('auction');return false;\"><font color=white>'Cave' of trades</a><BR>";
$output.="<a href='' onclick=\"locationText('quest');return false;\"><font color=white>Bluebell</a><BR>";
$output.="<BR>";

}else if($locationshow=='LocationText'){

if($action=='shop'){
$output.="Welcome to the Eully market.<BR>Suit yourself!<BR>";

### SHOPCODE
include('textincludes/shop.php');
#####

}elseif($action=='auction'){

	include('textincludes/auction.php');

}elseif($action=='tradingpost'){

	include('textincludes/trading.php');

}elseif($action=='quest'){

	$questID=2;
	   $resultaaat = mysqli_query($mysqli,"SELECT username FROM quests WHERE questID='$questID' && completed=1 && username='$S_user' LIMIT 1");
	   $aantal = mysqli_num_rows($resultaaat);
	if($aantal==1){
		$questID=4; //Witch bluebell 2
	   	$resultaaat = mysqli_query($mysqli, "SELECT username FROM quests WHERE questID='$questID' && completed=1 && username='$S_user' LIMIT 1");
	   	$aantal = mysqli_num_rows($resultaaat);
		if($aantal==1){ $questID='stop'; }

	}


	if($questID!='stop'){
		include('textincludes/quests.php');
	}else{
	 	include('textincludes/magic.php');
	}

} else {
	$output.="Welcome to Eully!<BR><BR>";
	$output.="Do you have something you want to buy? Then you're at the right place!<br>";
	$output.="Here is the little market of Syrnia, this is where you can buy the things you want instead of buying them from the player shops.<br>";
	$output.="Have a look around, maybe you'll find something you like!";
}

}
}
?>