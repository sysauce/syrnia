<?
session_start();
if($S_user && $S_staffRights['chatMod']==1 && $S_MODLOGIN){ ## USER EN MODD

include_once('../../../currentRunningVersion.php');
if(!$mysqli){
	include_once(GAMEPATH."includes/db.inc.php");
}

$time=$timee=time();
$year=$yyy;
$month=$mmm;
$day=$ddd;

if(strlen($month)<=1){$month="0$month";}
if(strlen($day)<=1){$day="0$day";}
if($type=='whisper'){ $type2=strtolower($type2); }

if($type=='region'){
	$filename=CHATLOGPATH."chatlogs/$type/".$type2."_".$year."_"."$month"."_"."$day.php";
}else if($type=='whisper'){
	$filename=CHATLOGPATH."chatlogs/$type/$year"."_"."$month"."_"."$day/".$type2."_$year"."_"."$month"."_"."$day.php";
}else{
	$filename=CHATLOGPATH."chatlogs/$type/$year"."_"."$month"."_"."$day.php";
}




if(file_exists($filename)){
if( is_numeric($year) && is_numeric($month) && is_numeric($day) && $type){


	$ip1= $_SERVER['REMOTE_ADDR'];
		 $sqal = "INSERT INTO zmods (username, action, reason, timer, time, moderator, moderatorIP)
         VALUES ('', 'checked chatlog $type ($type2) of $day-$month-$year (dmy)', '', '', '$time', '$S_user', '$S_realIP')";
      mysqli_query($mysqli, $sqal) or die("error2aa report this bug $sqal");


	// $file = $FULLPATH."chatlogs/".date("Y_m_d").".php";
	 if (!$file_handle = fopen($filename,"r")) { echo "Error open<br/>"; }
	 if (!$file_contents = fread($file_handle, filesize($filename))) { echo "Error reading.<br/>"; }
	 $file_contents=stripslashes($file_contents);
	 fclose($file_handle);
	 echo nl2br($file_contents);


}else{
	echo"Chatlog does not exist!";
}
}else{
	echo"Chatlog does not exist!";
}


}
?>