<?
if(defined('AZtopGame35Heyam') && ($SENIOR_OR_SUPERVISOR==1 || $S_staffRights['multiMod'])){


$time=time()+9;
$datum=strftime( "%d-%m-%Y", $time);






if(true){

	echo"<b>Look up a players messages</b>";
	echo"<form action='' method=post>
	<table>
	<tr><td>Message sent by:<td><input type=text name=fromP>
	<tr valign=top><td>Message received by:<br /><small>Optional</small><td><input type=text name=toP>
	<tr><td><td><input type=submit value='Check'>
	</table>
	</form>";




	if($fromP){
		 $resultaaat = mysqli_query($mysqli,  "SELECT ID FROM users WHERE username='$toP' OR username='$fromP' LIMIT 2");
	   	$aantal = mysqli_num_rows($resultaaat);
		if($aantal<=0 || ($aantal==1 && $toP )  ){
		 	echo"<b>One of the player names you've entered does not exist.</b><br/>";
		}else{
		 $color='';
		 if($toP){
		 	$filter1="username='$toP' && ";
		 }
			modlog('','messagelookup', "Checked messages sent by $fromP (optional: and received by [$toP])", '', $timee, $S_user, $S_realIP, 0);
  			 echo"<B>All messages from $fromP (optional: and to [$toP])<br />
			   <table border=0 cellpadding=3>";
			   $sql = "SELECT sendby, time, topic, ID, message, username, status  FROM messages WHERE $filter1 sendby='$fromP' ORDER BY ID DESC LIMIT 150";
			   $resultaat = mysqli_query($mysqli, $sql);
			      while ($record = mysqli_fetch_object($resultaat)) {
			      $topic=stripslashes($record->topic); if($topic==''){$topic='No topic';}

					echo "<tr bgcolor='#B19A68'><td>From player: <b>$record->sendby</b> To player: <b>$record->username</b>";
					echo "<tr bgcolor='#B19A68'><td>Date: ".date("Y-m-d H:i", $record->time);
					echo "<tr bgcolor='#B19A68'><td>Topic: <B>$topic</b>";
					if($record->status>=127){echo "<tr bgcolor='#B19A68'><td>$record->username has <font color=red>deleted</font> this message"; }
					echo "<tr bgcolor='#EFD6AD'><td>$record->message";
					echo "<tr bgcolor='' height=30><td>";
					}
				  echo"</table>";




		}
	}else if($toP OR $fromP){
		 echo"<b>You need to enter a sender.</b><br/>";

	}

}









}
?>