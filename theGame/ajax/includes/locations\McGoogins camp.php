<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){


	if($action=='move'){
	 	$to='McGoogins site';
	 	
	 	//$timee=time();
	 	//$time=90;
		//mysqli_query($mysqli,"UPDATE users SET work='move', worktime=($timee+$time), dump='$to', dump2='0' WHERE username='$S_user' LIMIT 1") or die("error --> 1113");
		echo "updateCenterContents('move', '$to');";
		
		//mysqli_query($mysqli,"UPDATE users SET location='$to', dump='', dump2='' WHERE username='$S_user' LIMIT 1") or die("error --> 1113"); 
		//include('includes/mapData.php');
		//echo"updateCenterContents('loadLayout', 1);";
		
	}else{
		$output.="This part of the archeological cave has got a lot of tents in it.<BR>";
		$output.="This is McGoogins main camp for his archeological digging.<BR>";
		$output.="There is still some daylight visible here from the cave entrance.<BR>";
		$output.="<br />";
		$output.="<a href='' onclick=\"locationText('move');return false;\">Leave the cave</a>";
	}





}
}
?>