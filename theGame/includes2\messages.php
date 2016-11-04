<?
define('inMessages359539dfd', true );

$S_user=''; $S_donation='';

//GAMEURL, SERVERURL etc.
require_once("../../currentRunningVersion.php");
include_once(GAMEPATH."includes/db.inc.php");

  session_start();


$name = htmlentities(trim($name));
$topic = htmlentities(trim($topic));

echo"<html>
<HEAD><TITLE>Syrnia</TITLE>
<link type=\"text/css\" rel=\"stylesheet\" href=\"../../style$S_layout.css\">
<style type=\"text/css\">
body {
	color:#000000;
}
</style>";
?>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="PUBLIC">
<link rel="shortcut icon" href="../../favicon.ico" type="image/x-icon" />
</HEAD>
<?
echo"<BODY background=\"../../layout/layout3_BG.jpg\" alink=ff0000 link=ff0000 text=000000 vlink=ff0000><center><br />
 <Table width=95% cellpadding=5 cellspacing=0><tr bgcolor=#E2D3B2><td>";


if($S_user){
$timee=time();

if($S_donation>=4000){$messagehold=150;  $messageholdsent=25;
}elseif($S_donation>=2750){$messagehold=125;  $messageholdsent=20;
}elseif($S_donation>=1750){$messagehold=100;  $messageholdsent=15;
}elseif($S_donation>=1000){$messagehold=75;  $messageholdsent=10;
} else{$messagehold=50; $messageholdsent=5;}


$bgcolor=CDBFA1;


$klant=$S_user;


echo"<center><h1>Messages</h1>
<a href=\"../../rules.php\" onClick='enterWindow=window.open(\"../../rules.php\",\"\",
                \"width=600,height=600,top=50,left=300,scrollbars=yes\"); return false'
                onmouseover=\"window.status=''; return true;\"
                onmouseout=\"window.status=''; return true;\">Rules</a><BR><br/>";

if ($submit) { ## Delete a message
	if($MS){
		$sql = "UPDATE messages set status='$timee' WHERE ID='$MS' && username='$klant'";
	      	mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE");
	      	$status="<BR>Message deleted<BR>";
	}else if ($DELALL == '1') {
	      	$sql = "UPDATE messages SET status='127' WHERE username='$klant'";
	      	mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE");
	      	$status= "<BR>All messages have been deleted.<BR>";
	}

    if($ids && count($ids) > 0)
    {
        $idList = '';
        foreach($ids as $id)
        {
            if(is_numeric($id))
            {
                $idList = $idList . (strlen($idList) == 0 ? "" : ",") . $id;
            }
        }
        $sql = "UPDATE messages set status='$timee' WHERE ID IN ($idList) && username='$klant'";
        mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE");
        $status="<BR>Messages deleted<BR>";
    }
}



echo"<B>$status</B><HR>";
	echo"<a href='messages.php?p=messages&stuur=1$modlink'><b>Send a message</b></a><BR>";
	echo"<a href=\"../../tickets.php\">Contact the game staff, use the ticket system</a><br/><hr/><br/>";

if($stuur==1){
		if ($submit=='yess' && $tekst) {

			$jailReason="";
		   	$resultaat = mysqli_query($mysqli, "SELECT dump2 FROM users WHERE  username='$S_user' && work='jail'  LIMIT 1");
		    while ($record = mysqli_fetch_object($resultaat))
			{
				$jailReason=$record->dump2;
			}
			if($jailReason=='Misbehaviour'){
				//Jailed, not allowed to send messages
				echo"<BR><B><font color=red>Sorry, you're not allowed to send messages since you have been jailed.</font></B><BR>";

			}else{
		   $resultaaat = mysqli_query($mysqli, "SELECT username FROM users WHERE username='$sendto' LIMIT 1");
		   $aantalA = mysqli_num_rows($resultaaat);
		if($aantalA>0 && strtolower($sendto)!='m2h'){
			$sendname = htmlentities(trim($sendname));
			$tekst = htmlentities(trim($tekst));
			$topic = htmlentities(trim($topic));
			$tekst = nl2br($tekst);
			$datum = date("d-m-Y H:i");
			   $resultaaat = mysqli_query($mysqli, "SELECT username FROM messages WHERE username='$sendto' && message='$tekst' && topic='$topic' LIMIT 2");
			   $aantal = mysqli_num_rows($resultaaat);
			if($aantal<2){

				$status=0;//unread (1=read  127=deleted)
				$resultaaat = mysqli_query($mysqli, "SELECT ID FROM options WHERE username='$sendto' && (ignoreList LIKE '%,$S_user,%' || ignoreList LIKE '$S_user,%' || ignoreList LIKE '$S_user,%' || ignoreList='$S_user'  ) LIMIT 1");
			   $ignored = mysqli_num_rows($resultaaat);
				if($ignored>=1){
				 	$status=127;

				}

				$sql = "INSERT INTO messages (username, sendby, message, topic, time, status)
			  	VALUES ('$sendto', '$klant', '$tekst', '$topic', '$timee', '$status')";
				mysqli_query($mysqli,$sql) or die("error report4324426");
			 	echo"<BR><B><font color=green>Message sent to $sendto.</font></B><BR>";
			}

			$topic='';
		} else {
		 if($sendto=='M2H' OR $sendto=='m2h'){
				echo "<BR><B><font color=red>Error</font> Sending messages to M2H has been disabled. For Syrnia support, use the ticket system instead.</B><BR>";  $back=$tekst;
			}else{
		 		echo "<BR><B><font color=red>Error</font> There is no such user as ($sendto).</B><BR>";  $back=$tekst;}
		 	}
		 	}#jailed misbheaviour
		}


		echo"<B>Send a Message</b><BR>";


		echo"<form action='' method=post><table bgcolor=CDBFA1><input type=hidden name=submit value=yess>
		<tr><td>Send to:</td><td>Enter a username: <input type=text name=sendto value='$name' size=10 maxlength=20></tr><tr><td>Topic</td><td><input type=text name=topic value='$topic' size=40>
		<tr><td>Message</td><td><textarea name=tekst rows=10 cols=30>$back</textarea></tr>
		<tr><td><input type=submit value=Send> </td><td></tr>
		</form></table>";




} /*else{
	echo"<a href='messages.php?p=messages&stuur=1$modlink'><b>Send a message</b></a><BR>";
	echo"<a href=\"../../tickets.php\">Contact the game staff, use the ticket system</a><br/>";
}*/





if($lees>0){
#################
######### READ a Message
	$sql = "SELECT * FROM messages WHERE (username='$klant' && status<10 OR sendby='$klant') && ID='$lees' LIMIT 1 ";
	   $resultaat = mysqli_query($mysqli,$sql);
	       while ($record = mysqli_fetch_object($resultaat)) {

		       if($record->status==0){		             $sql = "UPDATE messages SET status=1 WHERE username='$klant' && ID='$lees' && status<10 LIMIT 1";
	      mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE"); 	       }

	$nr=$nr+1;
	$lastid=$record->ID;
	if($record->sendby==$klant){
		$stg=" To player: <b>$record->username</b><BR>";
		$replyname=$record->username;
	}else{
		$stg=" From player: <b>$record->sendby</b><BR>";
		$replyname=$record->sendby;
	}

	if($record->sendby=='<B>Syrnia</B>' OR $record->sendby=='<B>Syrnia</b>'){$stg="<font color=ff0000><b>Sent by the game</b></font><BR>";}

	if($record->sendby=='Moderators: Multi/Cheat' OR $record->sendby=='Moderators: Chat/Forum' OR $record->sendby=='Moderators: Bugs'){ $stg="<B><font color=red>Sent by game $record->sendby</font></B><BR>"; }

	$message=stripslashes($record->message);
	$topic=stripslashes($record->topic);
	echo "<BR>
	<TABLE bgcolor=CDBFA1 cellSpacing=0 cellPadding=0 border=1>
	<tr>
	<td width=500 align=center valign=center>
	$stg
	Sent on: ".date("Y-m-d H:i", $record->time)." <BR><BR>
	Topic: <B>$topic</b> <BR>
	<table width=450><tr><TD>$message
	</td></tr></table>";

	if($S_donation<2500){ #BANNER
	echo"<BR><BR><script type=\"text/javascript\"><!--
	google_ad_client = \"pub-8058836226253609\";
	google_alternate_color = \"666666\";
	google_ad_width = 234;
	google_ad_height = 60;
	google_ad_format = \"234x60_as\";
	google_ad_type = \"text_image\";
	//2006-09-28: Syrnia_messages
	google_ad_channel =\"1379661653\";
	google_color_border = \"CDBFA1\";
	google_color_bg = \"CDBFA1\";
	google_color_link = \"FF0000\";
	google_color_text = \"000000\";
	google_color_url = \"000000\";
	//--></script>
	<script type=\"text/javascript\"
	  src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\">
	</script>";
	}#BANNER

	echo"
	</tr>
	<tr>
	<td width=500 valign=center align=center>";

	if($checksend<>0){
	echo"<a href=\"messages.php?p=messages&name=$record->username&stuur=1&topic=RE: $topic$modlink\">Message $record->username</a>";
	}else{
	echo"<a href='messages.php?p=messages&MS=$record->ID&submit=yes$modlink'><img src=../../layout/delete.gif border=0></a> - / / -
	<a href=\"messages.php?p=messages$modlink&name=$replyname&stuur=1&topic=" . (strrpos($topic, "RE:") === false ? "RE: " : "") . "$topic\"> Reply</a>";
	}



	echo"</tr>
	</table><BR>";
	   }
   }#### # End Read
##############
if($page=='ticket'){
 include('../../tickets.php');
}else{
####### MESSAGE LIST
   $color='#78705E';
   if($checksend){
    	$checksend2="sendby='$klant'";
		$messagehold2=$messageholdsent;
		echo"<BR><B>Last $messagehold2 sent messages</B><BR><small><a href=\"messages.php?p=messages&checksend=0$modlink\">Check received messages</a></small>";
		echo"<table><tr bgcolor=CDBFA1><td><td>Sent to<Td>Date<td>Topic";
   }else{
    	$checksend2="(username='$klant' && status<10)";
		$messagehold2=$messagehold;
		echo"<BR><B>Last $messagehold2 received messages</B><BR><small><a href=\"messages.php?p=messages&checksend=1$modlink\">Check sent messages</a></small>";
		echo"<form name=deleteMessages action='' method='post'><table><tr bgcolor=999999><td>Delete <input type='checkbox' id='checkAll' onchange='check();' /><td>Reply<td>Sent by<Td>Date<td>Topic";
	}

   $newMessages=0;$nr=0;
   $sql = "SELECT sendby, time, topic, ID, username, status  FROM messages WHERE $checksend2 ORDER BY time DESC LIMIT $messagehold2";
   $resultaat = mysqli_query($mysqli,$sql);
      while ($record = mysqli_fetch_object($resultaat))
	  {
	      if($record->sendby=='<B>Syrnia</B>' OR $record->sendby=='<B>Syrnia</b>'){//nothing
		  }else{$nr++; }



		if($color=='#78705E'){$color='#9B896D'; }else{ $color='#78705E'; }
      $topic=stripslashes($record->topic); if($topic==''){$topic='No topic';}

		echo "<tr bgcolor='$color'>";
		if($checksend==1){ }else
        {
            echo"<Td><center><input type='checkbox' name='ids[]' value='$record->ID' /> <a href='messages.php?p=messages&MS=$record->ID&submit=yes$modlink'><img src=../../layout/delete.gif border=0></a>";
        }
		if($checksend==1)
        {
            echo"<td><a href='messages.php?p=messages&name=$record->username&stuur=1&topic=" . (strrpos($topic, "RE:") === false ? "RE: " : "") . "$topic$modlink'>Send message</a>";
        }
        else
        {
            echo"<td><a href='messages.php?p=messages&name=$record->sendby&stuur=1&topic=" . (strrpos($topic, "RE:") === false ? "RE: " : "") . "$topic$modlink'> Reply</a>";
        }

		if($record->sendby=='<B>Syrnia</B>' OR $record->sendby=='<B>Syrnia</b>'){ echo"<td><font color=ff0000><b>Sent by the game</b></font><BR>";}
		elseif($record->sendby==$klant){echo"<td>To player: <b>$record->username</b><BR></i>";
		}else{echo"<td>From player: <b>$record->sendby</b><BR>"; }



		echo"<td>".date("Y-m-d H:i", $record->time)."
		<td><a href='messages.php?p=messages&checksend=$checksend&lees=$record->ID$modlink'><B>";
		  if($record->status==0){echo"<font color=yellow><B>"; $newMessages++; }else{echo"<font color=black>";}
		echo"$topic</b></a>";
   }
   echo"</table>";

   if(!$checksend==1){
   echo"<script language=\"JavaScript\">if (window.opener && !window.opener.closed){";
	if($newMessages>0){
  	 	echo"window.opener.document.getElementById('messagesCounter').innerHTML = \"<small>($newMessages new message" . ($newMessages == 1 ? "" : "s") . ")</small>\";";
  	}else{
		echo"window.opener.document.getElementById('messagesCounter').innerHTML = '';";
	}
	echo"}</script>";
	}


   echo"<BR>
   $nr/$messagehold2 messages saved (Game messages not included)<BR>
   <BR>";


##HIDE DELETE BUTTON BY SENT MESSAGE
if($checksend!=1){
    echo "<script type=\"text/javascript\">
        function check()
        {
            value = document.getElementById('checkAll').checked;
            checkboxes = document.getElementsByName('ids[]');
            for(var i = 0; i <= checkboxes.length; i++)
            {
                checkboxes[i].checked = value
            }
        }
        </script>
        <input type=hidden name=submit value=1><input type=submit value='Delete selected messages'></form/>";
	/*echo"<form action='' method=post>
		<input type=hidden name=DELALL value=1>
      	<input type=hidden name=submit value=1> <input type=submit value='Delete ALL messages'>
		</form>";*/
}

}#Show message list



}else{ ## No session, logged out
	echo"Your session timed out: You are not logged in any more.<BR>
	<BR>
	Using IE (Internet Explorer) ?<BR>
	This error message could pop up because IE does not support cookies and sessions properly.<BR
	Use firefox for optimal gameplay.<BR>
	<script type=\"text/javascript\"><!--
	google_ad_client = \"pub-8058836226253609\";
	google_ad_width = 180;
	google_ad_height = 60;
	google_ad_format = \"180x60_as_rimg\";
	google_cpa_choice = \"CAAQ56j8zwEaCHvU9tBAqJJaKMu293M\";
	//--></script>
	<script type=\"text/javascript\" src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\">
	</script>";
}
?>
<br />
</td></tr>
</table>
<br />
</center>
</body>
</html>