<?
if(defined('AZtopGame35Heyam') && ($S_staffRights['forumMod']==1 || $S_staffRights['multiMod'] ) ) {


$time=time()+9;
$datum=strftime( "%d-%m-%Y", $time);

echo"<ul>";
echo"<li><a href=?page=$page&>Main tools</a><br />";
echo"<li><a href=?page=$page&showall=1>Show all muted, jailed and forumbanned players</a><br />";
echo"<li><a href=?page=$page&crimes=1>Check a players crimes</a><br />";
echo"<li><a href=?page=$page&forumaction=removeallposts>Remove all forumposts</a><br />";
echo"<li><a href=?page=$page&forumaction=check>View avatar and signature</a><br />";
echo"<li><a href=?page=$page&forumaction=avatars>Remove avatars</a><br />";
echo"<li><a href=?page=$page&forumaction=signature>Remove signature</a><br />";
echo"<li><a href=?page=$page&forum=1>Forum department forum</a><br />";
echo"</ul>";
echo"<hr>";

echo"<script type=\"text/javascript\">
function enableAreaByTickbox(ennableOrDisableMe){
	$(ennableOrDisableMe).disabled=!$(ennableOrDisableMe).disabled;
}
//function enableAreaByArea(ennableOrDisableMe, tickb){
//	$(ennableOrDisableMe).disabled=!$(ennableOrDisableMe).disabled;
//	$(tickb).checked=!$(tickb).checked;
//}
</script>";


if($forumaction=='removeallposts'){


    echo"<form action='' method=post>
Remove all forumposts<br />
Username: <input type=tekst name=removeallpostsby><input type=submit value=clear></form>";
echo"<br />";

$removeallpostsby = htmlentities($removeallpostsby);

if($removeallpostsby && $sure){


    $sql = "UPDATE stats SET posts=0 WHERE username='$removeallpostsby' LIMIT 1";
    mysqli_query($mysqli,$sql) or die("error report this bug please  asd1");

	 $sql = "UPDATE forummessages SET deleted=1 WHERE username='$removeallpostsby'";
      mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE");
  echo"Hidden ".mysqli_affected_rows()." replies and";
     $sql = "UPDATE forumtopics SET clan=CONCAT(clan, 'DEL') WHERE username='$removeallpostsby'";
          mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE");
  echo" ".mysqli_affected_rows()." topics.";

}else if($removeallpostsby){
    echo "Are you sure?<br /> ";
    echo "<a href='?page=$page&forumaction=removeallposts&sure=1&removeallpostsby=$removeallpostsby'>yes</a> remove all forumposts and topics by [$removeallpostsby]<br />";

}


################################
## Check avatar and signature ##
################################
}else if($forumaction=='check'){

echo"<form action='' method=post>
Check a players forum avatar and signature<br />
Username: <input type=tekst name=username><input type=submit value=check></form>";
echo"<br />";



	if($username){
	  	$resultaaat = mysqli_query($mysqli, "SELECT ID FROM users WHERE username='$username' LIMIT 1");
		$playerExcists = mysqli_num_rows($resultaaat);
	if($playerExcists==1){

		$sql = "SELECT username, signature, avatar FROM donators WHERE username='$username' LIMIT 1";
        $resultaat = mysqli_query($mysqli, $sql);
        while ($record = mysqli_fetch_object($resultaat))
        {
            echo "Signature:<hr/>$record->signature<br /><hr>Avatar (ctrl+F5 to refresh your cache if you are expecting them to change):<br/>";
            if($record->avatar){ echo "<img src=\"/images/avatars/$record->username$record->avatar\" width=96 height=96><BR>"; }
        }

	}else{
		echo"<b>ERROR: The username does not exist!</b>";
	}
	}


}else
#AVATARS
if($forumaction=='avatars'){

echo"<form action='' method=post>
Clear a players forum avatar<br />
Username: <input type=tekst name=clearavataruser><input type=submit value=clear></form>";
echo"<br />";



	if($clearavataruser){
	  	$resultaaat = mysqli_query($mysqli,  "SELECT ID FROM users WHERE username='$clearavataruser' LIMIT 1");
		$playerExcists = mysqli_num_rows($resultaaat);
	if($playerExcists==1){

		mysqli_query($mysqli, "UPDATE donators SET avatar='' WHERE username='$clearavataruser' LIMIT 1") or die("err1or --> 1232231");
		mysqli_query($mysqli, "UPDATE forummessages SET avatar='' WHERE username='$clearavataruser'") or die("err1or --> 1232231");
		echo"<b>Success: Cleared the avatar, and removed it from all forum posts.<br/>DO let the player know you removed it!</b>";

	}else{
		echo"<b>ERROR: The username does not exist!</b>";
	}
	}

}else if($forumaction=='signature'){

echo"<form action='' method=post>
Clear a players forum signature<br />
Username: <input type=tekst name=clearsignatureuser><input type=submit value=clear></form>";
echo"<br />";



	if($clearsignatureuser){
	  	$resultaaat = mysqli_query($mysqli,  "SELECT ID FROM users WHERE username='$clearsignatureuser' LIMIT 1");
		$playerExcists = mysqli_num_rows($resultaaat);
	if($playerExcists==1){

		mysqli_query($mysqli, "UPDATE donators SET signature='' WHERE username='$clearsignatureuser' LIMIT 1") or die("err1or --> 1232231");
		mysqli_query($mysqli, "UPDATE forummessages SET signature='' WHERE username='$clearsignatureuser'") or die("err1or --> 1232231");
		echo"<b>Success: Cleared the signature, and removed it from all forum posts.<br/>DO let the player know you removed it!</b>";

	}else{
		echo"<b>ERROR: The username does not exist!</b>";
	}
	}

}else
##### CRIMES
if($crimes==1){
echo"<form action='' method=post>
Player <input type=tekst name=check><input type=submit value=check> </form>";

if($check){
echo"Checking $check:<br />";

   $sql = "SELECT timer, time, action,moderator, reason FROM zmods WHERE username='$check' ORDER BY ID DESC";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {
    if($record->time>0){  $timepje = date("d-m-Y H:i", $record->time);  }else{ $timepje=''; }

    $seconds=$record->timer;
    if($seconds>3600*24){ $left=(round($seconds/(3600*24)*100)/100)." days ";
    }elseif($seconds>3600){ $left=(round($seconds/(3600)*100)/100). " hours ";
    }else{ $left=ceil(($seconds)/60)." minutes"; }

	    if($record->action!='warn'){
		 echo"$timepje - <B>$record->action for $left.</B><br />";
	    }else{
		 echo"$timepje - <B>$record->action</B><br />";
		}
		echo"Reason <u>$record->reason</u>. By mod: $record->moderator<br />
	    <br />";
    }
}

}else if($forum==1){
		$forumforum=1;
	 	include('forum.php');


#######
##### SHOWALL
}elseif($showall==1){
#MUTED PLAYERS
echo"<HR>
<B>Muted players in chat:</B><br /><table>";
   $sql = "SELECT username, chat FROM stats WHERE chat>$time order by chat asc";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {

    $seconds=$record->chat-time();
    if($seconds>3600*24){ $left=(round($seconds/(3600*24)*100)/100)." days ";
    }elseif($seconds>3600){ $left=(round($seconds/(3600)*100)/100). " hours ";
    }else{ $left=ceil(($seconds)/60)." minutes"; }

    echo"<tr><td>$record->username <td>$left left";
} echo"</table>";


#JAILED PLAYERS
echo"<HR>
<B>Jailed players:</B><br /><Table>";
   $sql = "SELECT username, worktime FROM users WHERE work='jail' && worktime>$time && dump2='Misbehaviour' order by worktime asc";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {

    $seconds=$record->worktime-time();
    if($seconds>3600*24){ $left=(round($seconds/(3600*24)*100)/100)." days ";
    }elseif($seconds>3600){ $left=(round($seconds/(3600)*100)/100). " hours ";
    }else{ $left=ceil(($seconds)/60)." minutes"; }

    echo"<tr><td>$record->username <td>$left left";
}echo"</table>";

#FORUMBANNED PLAYERS
echo"<HR>
<B>Forumbanned players:</B><br /><Table>";
   $sql = "SELECT username, forumban FROM stats WHERE forumban>$time ORDER BY forumban asc";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) {

    $seconds=$record->forumban-time();
    if($seconds>3600*24){ $left=(round($seconds/(3600*24)*100)/100)." days ";
    }elseif($seconds>3600){ $left=(round($seconds/(3600)*100)/100). " hours ";
    }else{ $left=ceil(($seconds)/60)." minutes"; }

    echo"<tr><td>$record->username <td>$left left";
} echo"</table>";

## DELETION
echo"<HR>
<B>Players pending deletion:</B><br />";
echo"Bastards freezed: (will be deleted due to inactivity)<table>";
$resultaat = mysqli_query($mysqli, "SELECT username FROM users where work='freezed' ORDER BY username asc");
    while ($rec = mysqli_fetch_object($resultaat)) {  echo"<tr><td>$rec->username<td>"; }
echo"</table><hr>";

}elseif($chatlog){

	echo"<b>Look up chat history</b>";
	echo"<form action='' method=post>
	<table>
	<tr><td>Year<td><input type=text name=yyy value=".date(Y).">
	<tr><td>Month:<td><input type=text name=mmm value=".date(n).">
	<tr><td>Day:<td><input type=text name=ddd value=".date(j).">
	<tr><td>Type:<td><select name=type>
	<option value=guide>guide
	<option value=mod>mod
	<option value=help>help
	<option value=pirate>pirate
	<option value=world>world & trade
	</select>
	<tr><td><td><input type=submit value='Check'>
	</table>
	</form>";

	if($yyy && $mmm){

		echo"<a href=mod_readchatlog.php?yyy=$yyy&mmm=$mmm&ddd=$ddd&type=$type target=_blank>Read the chatlog here</a>";
	}


} else{


	$checkPlayer=htmlentities(trim($checkPlayer));
	if($checkPlayer){
	  	$resultaaat = mysqli_query($mysqli,  "SELECT ID FROM users WHERE username='$checkPlayer' LIMIT 1");
		$playerExcists = mysqli_num_rows($resultaaat);
	}
	if($playerExcists==1){

	 	include('includes/punishment_tool_include.php');


	}else{

	 	echo"<b>Enter a players username to continue</b><br/><br />";
		if($playerExcists=='0'){
			echo"<font color=red>That player does not exist!</font><br/>";
		}
		echo"<table><form action='' method=post><input type=hidden name=punishment value=1>";
		echo"<tr><td>Username<td><input type=text name=checkPlayer value=\"$checkPlayer\"><td><input type=submit value='continue'></td></tr>";
		echo"<form action='' method=post>";
		echo"</form></table>";

	}


}









}
?>