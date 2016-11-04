<?php
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><b>City Menu</b><br />";
$output.="<br />";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><br />";
$output.="<a href='' onclick=\"locationText('school');return false;\"><font color=white>University</a><BR>";
$output.="<a href='' onclick=\"locationText('tradingpost');return false;\"><font color=white>Trading post</a><BR>";
$output.="<a href='' onclick=\"locationText('magic');return false;\"><font color=white>Practice magic</a><BR>";

$output.="<br />";



}elseif($action=='school'){
 
	$output.="<B>Welcome to the $location university.<BR><BR>"; 
	if($constructingl<75 && $constructingl>=50){ $output.="<a href='' onclick=\"locationText('work', 'school', 'constructing');return false;\">Learn about constructing</a><BR>";
	}elseif($constructingl<50){ $output.="You are not yet experienced enough to learn constructing at this university.<BR>"; 
	} else { $output.="You can't learn any more about constructing in here.<BR>"; }
	
	if($tradingl<75 && $tradingl>=50){ $output.="<a href='' onclick=\"locationText('work', 'school', 'trading');return false;\">Learn about trading</a><BR>"; 
	}elseif($tradingl<50){ $output.="You are not yet experienced enough to learn about trading at this university.<BR>"; 
	} else { $output.="You can't learn any more about trading in here.<BR>"; }

}elseif($action=='magic'){ # MAGIC
#########################

	if($magicl>=35){
	 	include('textincludes/magic.php');
	} else {
		$output.="You have not got enough magical powers yet to practise magic here.<BR>";
	}

}elseif($action=='tradingpost'){
 
 	if($tradingl>=25){
		include('textincludes/trading.php');
	}else{
		$output.="You need trading level 25 to trade here.<br />";
	}
	
} elseif($locationshow=='LocationText'){


	$output.="The wise and powerful mages used to be frequent guests in this town, protecting those honing their trading/construction skills from the evils of the world.<br />";
	$output.="<br />";


}
}
?>