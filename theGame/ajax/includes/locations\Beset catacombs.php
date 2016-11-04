<?
if(defined('AZtopGame35Heyam')){

if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"fighting('$S_location');return false;\"><font color=white>Fight</a><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"updateCenterContents('move', 'Beset');return false\"><font color=white>Return to Beset</a><br />";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

		$output.="Warriors from long ago sought to protect Anasco from horrible, unspeakable evil in this town.<br />";
	$output.="<br />";
	
	$questID=19;
	if(!finishedQuest($questID) && doingQuest($questID)==false  ){
		$output.="<br /><br />"; 
		if($action!='q'){
			$output.="You see an ancient warrior gathering his battle equipment. <a href='' onclick=\"locationText('q');return false;\">Go up to him.</a>";
		}else{		
			include('textincludes/quests.php');
		}
	}else if(doingQuest($questID, 2)){
		$output.="<br /><br />"; 
		include('textincludes/quests.php');
	}
	
}
}
?>