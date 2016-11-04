<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

	$output.="<center><B>City Menu</B><BR>";
	$output.="<br />";
	$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
	$output.="<br />";
	$output.="<a href='' onclick=\"locationText('work', 'woodcutting');return false;\"><font color=white>Woodcut</a><BR>";
	$output.="<a href='' onclick=\"locationText('school');return false;\"><font color=white>University</a><BR>";
	$output.="<a href='' onclick=\"locationText('jail');return false;\"><font color=white>Jail</a><BR>";
	$output.="<a href='' onclick=\"locationText('shop');return false;\"><font color=white>Stables</a><BR>";
	$output.="<BR>";

}else if($locationshow=='LocationText'){

	if($action=='school'){
		$output.="<B>Welcome to the Unera university.</b><BR><BR>";

		if($constructingl<10){
			$output.="You do not have the required constructing level 10 to enter the university.<br>";
		}elseif($constructingl>=10 && $constructingl<25){
	 		$output.="<a href=''  onclick=\"locationText('work', 'school', 'constructing');return false;\">Learn about constructing</a><BR>";
		} else {
			$output.="You can't learn any more about constructing in here.<BR>";
		}
	if($tradingl<10){
		$output.="You do not have the required trading level 10 to enter the university.<br>";
	}elseif($tradingl>=10 && $tradingl<25){
		$output.="<a href=''  onclick=\"locationText('work', 'school', 'trading');return false;\">Learn about trading</a><BR>";
	 } else {
	  	$output.="You can't learn any more about trading in here.<BR>";
	}

	}elseif($action=='shop'){

	$output.="Welcome to the Unera stables, these brown horses are the fastest on this island!<BR><BR>";
	include('textincludes/shop.php');


	}elseif($action=='jail'){

	include('textincludes/jail.php');

	}else{
	$output.="Unera University has been teaching the top traders and constructors for years.<BR>";
	$output.="Since they have a good reputation, only the best are allowed.<BR>";
	$output.="Unera also contains a jail which holds all the thieves of this island.<BR>";
	$output.="Experienced woodcutters can woodcut at the old Unera forest.<BR>";

	$questID=11;
	if(stristr($_SESSION['S_questscompleted'], "[$questID]")===false && (stristr($_SESSION['S_quests'], "$questID(1")<>'' OR  stristr($_SESSION['S_quests'], "$questID(3")<>''  OR  stristr($_SESSION['S_quests'], "$questID(4")<>'' )&& $level>=10 && $woodcuttingl>=10){
		$output.="<BR><BR>";
		include('textincludes/quests.php');
	}




	}

}
}
?>