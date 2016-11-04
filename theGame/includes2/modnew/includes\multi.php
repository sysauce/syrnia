<?
if(defined('AZtopGame35Heyam') && ($S_staffRights['multiMod']==1 || $S_staffRights['leadmod']==1) ){



echo"<B>Multi Hunter $S_user</B><BR>
<a href=?page=multi&multi=ban>Ban IP</a><BR>
<a href=?page=multi&forum=1>Multi department forum</a><BR>
<br />
<a href=?page=multi&multi=ipfile1>User (php) IP file</a><BR>
<a href=?page=multi&multi=ipfile2>Weekly (phph) IP file</a><BR>
<a href=?page=multi&multi=searchByIp>Search users by IP</a><BR>
<a href=?page=multi&multi=check>Search a specific users details</a><BR>
<a href=?page=multi&multi=tradelogs>Trade logs</a><BR>
<a href=?page=multi&multi=stockhouses>Check stockhouses</a><br />
<a href=?page=multi&multi=top>Top online avg.</a><BR>
<a href=?page=multi&multi=longest>Longest online since last login</a><BR>
<a href=?page=multi&multi=signups>Signups in the last 30 days</a><BR>
<a href=?page=multi&multi=freez>Freeze user: empty pass.</a><BR>
<a href=?page=multi&multi=changeEmail>change Email</a><BR>
<a href=?page=multi&multi=changeName>change username</a><BR>


<BR>
<Hr>";

if($multi=='changeName'){


function testname($testname){

	if(strlen($testname)<3 || strlen($testname)>20){
		return "The username length must be between 3-20 characters.";
	}else if (stristr ($testname, "M2H") OR stristr ($testname, "Admin") OR stristr ($testname, "Crew") OR stristr ($testname, "Moderator") OR stristr ($testname, "party pablo")){
		return "The username contains an reseverd keyword.";
	}else if (stristr ($testname, "(Mod)") OR stristr ($testname, "Mr. Addy") OR stristr ($testname, "fuck")){
		return "The username contains an reseverd keyword.";
	}else if (stristr ($testname, "  ")){
		return "You are not allowed to use two spaces next to eachother";
	}else if (substr($testname, 0, 1)==' ' OR substr($testname, -1, 1)==' '){
		return "You are not allowed to use a space at the begin (or at the end) of a username.";
	}else if(!ereg("^[' _A-Za-z0-9]+$",$testname)){ //"^[a-zA-Z0-9]"
		return "The username contains invalid characters, you can only use 0-9, A-Z and max. 3 spaces.";
	}else if(substr_count($testname, ' ')>3){
		return "The name may only contain 3 spaces at max.";
	}else if(substr_count($testname, ' ')>3){
		return "The name may only contain 3 of the '_' character at max.";
	}else if (substr($testname, 0, 1)=='_' OR substr($testname, -1, 1)=='_'){
		return "You are not allowed to use a '_' character at the begin (or at the end) of a username.";
	}else if(substr_count($testname, '0')+substr_count($testname, '1')+substr_count($testname, '2')+substr_count($testname, '3')+substr_count($testname, '4')+substr_count($testname, '5')+substr_count($testname, '6')+substr_count($testname, '7')+substr_count($testname, '8')+substr_count($testname, '9')>4){
		return "The username may not contain more than 4 numbers";
	}else if($testname!=htmlentities(trim($testname))){
		return "(error) The username contains invalid characters, you can only use 0-9, A-Z and max. 3 spaces.";
	}else{
		return "OK";
	}

}


	echo"<b>Change name:</b><br />

<i>\"Policy is one time change. We change if overtly offensive or if privacy issue (if they used real name, or ex is stalking them as it has happened before) a name change shouldnt be used to hide a user though..as it can be easily found anyway.\"</i><br /><br />

<form action=''method=post>
Current name:<br />
<input type=text name=oldname><br/>
<br />
New name:<br /><input type=text name=newname><br/>
<input type=submit value=Rename>
</form><br/>";

### NAME CHANGE
if($newname && $oldname && $newname!=$oldname && $newname!=$S_user && $oldname!=$S_user){
##LAST CONTROLE: 15-08-2008


   $resultaaat = mysqli_query($mysqli, "SELECT ID FROM users WHERE username='$oldname' LIMIT 1");
   $aantal = mysqli_num_rows($resultaaat);
     if($aantal==1){

			   $aantal=0;
			   	$sql = "SELECT username FROM users WHERE username='$newname' LIMIT 1";
				$resultaat = mysqli_query($mysqli,$sql);
				while ($record = mysqli_fetch_object($resultaat)) {
				 	/////if($record->username==$newname){
						$aantal=1;
					/////}
				 }

    			 if($aantal==0){
    			 	if(testname($newname)=='OK'){


					mysqli_query($mysqli, "UPDATE auctions SET seller='$newname' WHERE seller='$oldname'") or die("2erro1r --> 54ad4343");
					mysqli_query($mysqli, "UPDATE auctions SET bidder='$newname' WHERE bidder='$oldname'") or die("2erro2r --> 544sa343");
					mysqli_query($mysqli, "UPDATE auctions SET seller='$newname' WHERE seller='$oldname'") or die("2erro3r --> 544sa343");
					mysqli_query($mysqli, "UPDATE bugreports SET username='$newname' WHERE username='$oldname'") or die("16er4ror --> 544sda343");
					mysqli_query($mysqli, "UPDATE buildings SET username='$newname' WHERE username='$oldname'") or die("16er5ror --> 544sda343");
					mysqli_query($mysqli, "UPDATE clannews SET username='$newname' WHERE username='$oldname'") or die("4err6or --> 5443243");
					mysqli_query($mysqli, "UPDATE clans SET username='$newname' WHERE username='$oldname' LIMIT 1") or die("5err7or --> 5434343");
					mysqli_query($mysqli, "UPDATE donations SET username='$newname' WHERE username='$oldname' ") or die("6er8ror --> 5434343");
					mysqli_query($mysqli, "UPDATE donations SET donatedby='$newname' WHERE donatedby='$oldname'") or die("6e9rror --> 5434343");
					mysqli_query($mysqli, "UPDATE donations SET username='$newname' WHERE username='$oldname' ") or die("6err10or --> 5434343");
					mysqli_query($mysqli, "UPDATE donators SET username='$newname' WHERE username='$oldname' ") or die("6err10or --> 5434343");


					mysqli_query($mysqli, "UPDATE forummessages SET username='$newname' WHERE username='$oldname'") or die("7err11or --> 544ds343");
					mysqli_query($mysqli, "UPDATE forumtopics SET username='$newname' WHERE username='$oldname'") or die("8err12or --> 54d4a343");

					mysqli_query($mysqli, "UPDATE invasions SET username='$newname' WHERE username='$oldname'") or die("8erro13r --> 54d4a343");
					mysqli_query($mysqli, "UPDATE ips SET username='$newname' WHERE username='$oldname'") or die("10err14or --> 5443zxc43");
					mysqli_query($mysqli, "UPDATE items_inventory SET username='$newname' WHERE username='$oldname'") or die("in15v --> 544cxz343");
					mysqli_query($mysqli, "UPDATE items_wearing SET username='$newname' WHERE username='$oldname'") or die("wea16r --> 544cxz343");
					mysqli_query($mysqli, "UPDATE items_dropped SET droppedBy='$newname' WHERE droppedBy='$oldname'") or die("dro17pped --> 544cxz343");

					mysqli_query($mysqli, "UPDATE messages SET username='$newname' WHERE username='$oldname'") or die("12er1t8ror --> 54as4343");
					mysqli_query($mysqli, "UPDATE messages SET sendby='$newname' WHERE sendby='$oldname'") or die("13errosr --> 544fsd343");
					mysqli_query($mysqli, "UPDATE notes SET user='$newname' WHERE user='$oldname'") or die("13errror --> 54434sfd3");
					mysqli_query($mysqli, "UPDATE options SET username='$newname' WHERE username='$oldname'") or die("3erqror --> 54ad4343");

					mysqli_query($mysqli, "UPDATE quests SET username='$newname' WHERE username='$oldname'") or die("14erropr --> 54434sf3");
					mysqli_query($mysqli, "UPDATE stats SET username='$newname' WHERE username='$oldname' LIMIT 1") or die("1eroror --> fs544343");
					mysqli_query($mysqli, "UPDATE users SET username='$newname' WHERE username='$oldname'  LIMIT 1") or die("15erronr --> f544343");
					mysqli_query($mysqli, "UPDATE users_junk SET username='$newname' WHERE username='$oldname'  LIMIT 1") or die("15merror --> f544343");
					mysqli_query($mysqli, "UPDATE users_junk SET marriedTo='$newname' WHERE marriedTo='$oldname'  LIMIT 1") or die("15merror --> f544343");

					mysqli_query($mysqli, "UPDATE reports SET abuser='$newname' WHERE abuser='$oldname'  ") or die("15errlor --> f544343");
					mysqli_query($mysqli, "UPDATE reports SET reportedBy='$newname' WHERE reportedBy='$oldname' ") or die("15errkor --> f544343");
					mysqli_query($mysqli, "UPDATE sides SET leader='$newname' WHERE leader='$oldname' ") or die("15errjor --> f544343");
					mysqli_query($mysqli, "UPDATE staffrights SET username='$newname' WHERE username='$oldname'  LIMIT 1") or die("15eriror --> f544343");

					mysqli_query($mysqli, "UPDATE ticketmessages SET author='$newname' WHERE author='$oldname'  ") or die("15eHrror --> f544343");
					mysqli_query($mysqli, "UPDATE tickettopics SET author='$newname' WHERE author='$oldname' ") or die("15errHor --> f544343");
					mysqli_query($mysqli, "UPDATE tradingpost SET username='$newname' WHERE username='$oldname' ") or die("15errfor --> f544343");
					mysqli_query($mysqli, "UPDATE tradingpostitems SET username='$newname' WHERE username='$oldname'  ") or die("15eError --> f544343");
					mysqli_query($mysqli, "UPDATE votes SET username='$newname' WHERE username='$oldname'") or die("15errDor --> f544343");

					mysqli_query($mysqli, "UPDATE zmods SET username='$newname' WHERE username='$oldname'") or die("15erroCr --> f544343");
					mysqli_query($mysqli, "UPDATE zmods SET moderator='$newname' WHERE moderator='$oldname'") or die("15errBor --> f544343");

					mysqli_query($mysqli, "UPDATE votes SET username='$newname' WHERE username='$oldname'") or die("15erAror --> 544s343");

					modlog($newname,'renamed', "$oldname was renamed to $newname", '', $timee, $S_user, $S_realIP );

					echo"<B>$oldname was renamed to $newname!</B><BR>";
					}else{
						echo"Error with the new name:".testname($newname)."<br/>";
					}
				}else{
					echo"New name is already taken!<br/>";
				}

		}else{
			echo"There is no such current name!<br/>";
		}
}



}else
#######
# change Email
if($multi=='changeEmail'){

if($changeUser && $changeEmailTo){
	mysqli_query($mysqli, "UPDATE users SET email='$changeEmailTo' WHERE username='$changeUser' LIMIT 1") or die("error --> 544343");
	echo"User [$changeUser] email changed to: [$changeEmailTo]<br/>";
}
 echo"This feature works very easy..however do make sure that an email change is legimate! (The original account can not have logged in the past few days, etc.)<br/>
 <table><form action='' method=post>
 <tr><td>Username <td><input type=text name=changeUser>
 <tr><td>Change email to <td><input type=text name=changeEmailTo>
 <tr><td><td><input type=submit value=change>
 </table></form>";


}else if($multi=='searchByIp'){


	 echo"<b>Search users by IP</b><br />
	 <form action='' method=post>
	IP: <input type=text name=IPsearch size=15><input type=submit value='Search'</form>";

	if($IPsearch){
	 echo"<b>Shows max. 100 results:</b><br />
	 <table><tr><td>Username</b></td><td>Times</td><td>Last login</td></tr>";
		$resultaat = mysqli_query($mysqli, "SELECT username, count, lastlogin FROM ips where IP='$IPsearch' order by lastlogin desc LIMIT 100");
    	while ($rec = mysqli_fetch_object($resultaat))
		{
		 	echo"<tr><td>$rec->username</td><td>$rec->count times</td><td>".date("Y-m-d H:i", $rec->lastlogin)."</td></tr>";
		}
		echo"</table>";

	}

}else if($forum==1){
		$multiforum=1;
	 	include('forum.php');


#######
# FREEZ
}elseif($multi=='freez'){

echo"Freeze<form action='' method=post><input type=text name=Freezenamer value=''><BR>
Reason: <input type=text name=freezeReason size=100><input type=submit value='freeze'></form>";

if($Freezenamer && $freezeReason){
           $resultaat = mysqli_query($mysqli, "SELECT email FROM users where username='$Freezenamer'LIMIT 1");
    while ($rec = mysqli_fetch_object($resultaat)) {   $a=1;
 $message="Dear '$Freezenamer',

 You have been frozen in Syrnia.
 This is a BAN because of misbehaviour.
 This frozen account will be deleted in several months.
 Here's a short reason:
 \"$freezeReason\"

 Please do not reply to this email: We will not respond.
 Instead use the ticket system to recieve support:
 http://www.syrnia.com/tickets.php

 You are not allowed to play Syrnia anymore unless Syrnia staff would unfreeze your account.";
mail( "$rec->email", "Syrnia",$message,"From: support@syrnia.com" );

 $sqal = "INSERT INTO zmods (username, action, reason, timer, time, moderator, moderatorIP)
         VALUES ('$Freezenamer', 'freezed', '$freezeReason', '0', '$timee', '$S_user', '$S_realIP')";
      mysqli_query($mysqli, $sqal) or die("error2aa report this bug $sqal");
      $ban=time()+3600*5;
mysqli_query($mysqli, "UPDATE users SET work='freezed', password='', dump='', dump2='', worktime='', online=0 where username='$Freezenamer' LIMIT 1") or die("error --> 544343");
mysqli_query($mysqli, "UPDATE stats SET chat='$ban', forumban='$ban' where username='$Freezenamer' LIMIT 1") or die("error --> 544343");
mysqli_query($mysqli, "UPDATE buildings SET buildingclosed=1, farmslots=0 where type='shop' && username='$Freezenamer'") or die("error --> 544343");



echo"Freezed $Freezenamer.<BR>";
			   }  if($a<>1){echo"<B>THAT NAME DOES NOT EXIST!</B>";}

}

###############################
echo"<br/><br/><B>UN</B>Freeze <form action='' method=post><input type=text name=UNFreezenamer value=''><BR>
Reason: <input type=text name=UNfreezeReason size=100><input type=submit value='UNfreeze'></form>";
    if($UNFreezenamer && $UNfreezeReason){
           $resultaat = mysqli_query($mysqli, "SELECT email FROM users where username='$UNFreezenamer'LIMIT 1");
    while ($rec = mysqli_fetch_object($resultaat)) {   $a=1;
    $randpass=rand(11111,99999);
 $message="Dear '$UNFreezenamer',

 You have been unfrozen in Syrnia.
 Here's a short reason:
 $UNfreezeReason

 Your new password is: $randpass

You can play Syrnia again.";
mail( "$rec->email", "Syrnia",$message,"From: support@syrnia.com" );


 $sqal = "INSERT INTO zmods (username, action, reason, timer, time, moderator, moderatorIP)
         VALUES ('$UNFreezenamer', 'unfreezed', '$UNfreezeReason', '0', '$timee', '$S_user', '$S_realIP')";
      mysqli_query($mysqli, $sqal) or die("error2aa report this bug $sqal");
mysqli_query($mysqli, "UPDATE users SET work='', password='$randpass', dump='', dump2='', worktime='', online=0 where username='$UNFreezenamer' LIMIT 1") or die("error --> 544343");
mysqli_query($mysqli, "UPDATE stats SET chat=0, forumban=0 where username='$UNFreezenamer' LIMIT 1") or die("error --> 544343");
echo"<B>UN</B>Freezed $UNFreezenamer<BR>";
			   }  if($a<>1){echo"<B>THAT NAME DOES NOT EXIST!</B>";}

}



echo"<BR><BR>Players freezed: (will be deleted due to inactivity)
<i>Chat->Check a players crimes, for the reasons</i><hr>";
$resultaat = mysqli_query($mysqli, "SELECT username FROM users where work='freezed' order by username asc");
    while ($rec = mysqli_fetch_object($resultaat)) {  echo"$rec->username<BR>"; }


 ###############################
}elseif($multi=='ban'){

if($banIP){
 	if($banreason){
	if($duur=='min'){$timer=$timer*60;
	}elseif($duur=='hour'){$timer=$timer*60*60;
	}else{ $timer=$timer*60*60*24; }
	$for=ceil(($timer/3600)/24)." days";
	 $timer=$timee+$timer;

	if($duur=='forever'){$timer=0; $for="ever";}

	$sqal = "INSERT INTO banned_ips (bannedip, bannedtime, banreason, banuntill)
	  VALUES ('$banIP', '$timee', '$banreason', '$timer')";
	mysqli_query($mysqli, $sqal) or die("error2aa report this bug $sqal");

//	 $sqal = "INSERT INTO modlogs (moderator, username, action, message, time)
//		VALUES ('$SHowner', '', 'Banned IP', 'Banned ip: $banIP for $for [Reason: $banreason] ', '$time')";
//	 mysqli_query($mysqli, $sqal) or die("error2aa report this bug $sqal");

	echo"<B>Banned ip!</B><BR/>";
	}else{
	echo"<B>IP NOT BANNED: You need to enter a proper description!</B><BR/>";
	}
}

 echo"You can ban a REALlife IP from logging in the game (also bans from registration).<br/>
 You will need to freeze accounts manually though, this does not affect any account.<br/>
 You must be pretty sure about it when you do this.<br/>
 <U>It is very important that you write a clear description, as I am considering to share this IP ban list among all my games/websites!</U>.<BR/>
 Note: The ban reason is displayed to the user, please supply a clear and professional reason.<br/>
 <br/>
 <form action='' method=post>
 IP: <input type=text name=banIP><br/>
 Ban how long ?  <input type=text name=timer value=1 size=3><select name=duur><option value=forever>Forever<option value=min>Minutes<option value=hour>Hours<option value=days>Days</select><br/>
 Reason: <input type=text name=banreason size=70><br/>
 <input type=submit value=ban></form>
 <br/>";

if($showBans){
 	if($remove){
 	  $resultaat = mysqli_query($mysqli, "SELECT bannedip,banuntill, banreason FROM banned_ips where ID='$remove' LIMIT 1");
	while ($rec = mysqli_fetch_object($resultaat)) {
	                   $togo=ceil($rec->banuntill-$timee)/3600;
	                   if($rec->banuntill==0){$togo="FOREVER!";}
		 //	$sqal = "INSERT INTO modlogs (moderator, username, action, message, time)
		//	VALUES ('$SHowner', '', 'Removed IP ban', 'Removed ban on IP: $rec->bannedip (had $togo hours to go, and had reason: $rec->banreason)', '$time')";
	 	//	mysqli_query($mysqli, $sqal) or die("error2aa report this bug $sqal");
	 		mysqli_query($mysqli, "UPDATE banned_ips SET banuntill='$timee' WHERE ID='$remove' LIMIT 1") or die("err2or --> 1");
	         echo"<b>Removed ban</b><br/>";
	 		}
	}
 echo"<table>";
	 $resultaat = mysqli_query($mysqli, "SELECT ID, bannedip, bannedtime, banreason, banuntill FROM banned_ips where banuntill=0 OR banuntill>$timee order by bannedtime desc");
	while ($rec = mysqli_fetch_object($resultaat)) {
	echo"<tr><td>$rec->bannedip banned at ".date("Y-m-d H:i", $rec->bannedtime);
	if($rec->banuntill==0){echo"<td>Banned forever";
	}else{ echo"<td>Banned until ".date("Y-m-d H:i", $rec->banuntill); }
	echo"<td><i>$rec->banreason</i><td><small><a href=?page=multi&multi=ban&showBans=1&remove=$rec->ID>remove</a></small>";

	 } echo"</table>";

}else{
	echo"<a href=?page=multi&multi=ban&showBans=1>Show all current bans</a><br/>";
}



#######
# TOP ONLINE
}elseif($multi=='top'){
echo"Top 100 <BR>";
$resultaaaat = mysqli_query($mysqli, "SELECT username, online FROM stats order by online desc LIMIT 250");
    while ($record = mysqli_fetch_object($resultaaaat)) { $hours=round($record->online/3600);
$resultaat = mysqli_query($mysqli, "SELECT joined FROM users where username='$record->username' LIMIT 1");
    while ($rec = mysqli_fetch_object($resultaat)) {
$dagen=round((time()-$rec->joined)/86400);
$avg=round($hours/$dagen);
if(strlen($avg)==1){$avg="0$avg"; }
$txt="$avg hours a day -$record->username- ($hours total hours, $dagen days playing)<BR>$txt";}
 }

$array = explode("<BR>", $txt);
array_multisort($array, SORT_DESC, $array);
$aantal3 = count($array);
$i=0;
while($i < $aantal3){
echo"$array[$i]<BR>";
$i=$i+1;
}

#######
# TOP ONLINE
}elseif($multi=='longest'){
echo"Longest online<BR>";
$resultaaaat = mysqli_query($mysqli, "SELECT S.username, S.loggedin FROM stats S LEFT JOIN users U ON S.username = U.username WHERE U.online = 1 ORDER BY S.loggedin ASC LIMIT 5");
    while ($record = mysqli_fetch_object($resultaaaat))
    {
        $lastonline = date("d-m-Y H:i", $record->loggedin);
        echo "$record->username - $lastonline<BR>";
    }

/*$array = explode("<BR>", $txt);
array_multisort($array, SORT_DESC, $array);
$aantal3 = count($array);
$i=0;
while($i < $aantal3){
echo"$array[$i]<BR>";
$i=$i+1;
}*/


#######
# SIGNUPS IN THE LAST 30 DAYS
}elseif($multi=='signups'){
echo"Signups in the last 30 days<br/><br/>";
$resultaaaat = mysqli_query($mysqli, "SELECT username, joined FROM users WHERE joined > " . (time() - (30*24*60*60)) . " ORDER BY joined DESC");
    while ($record = mysqli_fetch_object($resultaaaat))
    {
        $joined = date("d-m-Y H:i", $record->joined);
        echo "$record->username - $joined<BR>";
    }

/*$array = explode("<BR>", $txt);
array_multisort($array, SORT_DESC, $array);
$aantal3 = count($array);
$i=0;
while($i < $aantal3){
echo"$array[$i]<BR>";
$i=$i+1;
}*/


#####################
### COOKIES
}elseif($multi=='cookies'){
 /*
if($cookiewarn==1){
$resultaaaat = mysqli_query($mysqli, "SELECT username, count FROM ips WHERE cookie<>'' GROUP BY username ORDER BY COUNT desc");
    while ($record = mysqli_fetch_object($resultaaaat)) { $S_user=$record->username;
echo"-$S_user was cookieing. ($record->count logins)<BR>";
$tekst="Dear player $S_user,<BR>
<BR>
This is a warning that we have noticed you trying to login with 2 or more accounts at once in the past.<BR>
Please do not try it again.<BR>
No further action is taken yet, but we are watching you.<BR>
If you are sure you are playing fair, do not be afraid.<BR>
Message the Moderators; Multis/Cheaters department for more information.<BR>
Reminder of the rules:<BR>
-Only 1 account for 1 person, multi accounts are NOT allowed.<BR>
-Only 1 online account per computer.<BR>
<u>Always logout using the logout button.</u><BR>
<BR>
Moderators: Multis/Cheaters<BR>";

$saaql = "INSERT INTO messages (username, sendby, message, datum, topic)
 VALUES ('$S_user', 'Moderators: Multis/Cheaters', '$tekst', '$datum', 'Warning')";
mysqli_query($mysqli, $saaql) or die("EROR");
}
mysqli_query($mysqli, "UPDATE ips SET cookie=''") or die("error --> 544343");

echo"<B>Warned all users:<BR>
<i>$tekst</i><BR>
All cookie logs have been emptied now.<BR>";
}

echo"<table>";
   $saql = "SELECT username, IP, cookie  FROM ips WHERE cookie<>'' ORDER BY count desc, cookie desc ";
    $resultaaat = mysqli_query($mysqli, $saql);
     while ($recoord = mysqli_fetch_object($resultaaat)) {
echo"<tr valign=top><td>$recoord->username<BR>$recoord->cookie";
}
echo"</table>
<a href=?page=multi&multi=cookies&cookiewarn=1>Warn & empty</a>";

*/

############################
}elseif($multi=='ipfile1'){ ## IP FILE


echo"<form action='' method=post>
Player <input type=text name=player><input type=submit></form>";

if($player){
include("../../../logs/logins/$player.php");
}

#<iframe src=http://www.syrnia.com/logs/logins/ width=100% height=500></iframe>";

############################
}elseif($multi=='ipfile2'){ ## IP FILE 2

echo"<form action='' method=post>
Year <input type=text name=jaar value=".date(Y).">Week nr. <input type=text name=week value=".date(W)."><input type=submit></form>";

if($jaar && $week){
 echo"../../../logs/loginallbyweek/week".$jaar."_$week.php";
include("../../../logs/loginallbyweek/week".$jaar."_$week.php");
}
############################
}elseif($multi=='check'){ ## SEARCH PLAYER

echo"<form action='' method=post>
Player: <input type=text name=check>
OR: email: <input type=text name=checkEmail><input type=submit value=check> </form>";

if($check OR $checkEmail){

if($checkEmail){
 $search="email='$checkEmail'";
 }else{
 $search="username='$check'";
}
$resultaaaat = mysqli_query($mysqli, "SELECT gold,fullname, country, age, email, username, gender, joined, password, location, online FROM users  WHERE $search LIMIT 1");
    while ($record = mysqli_fetch_object($resultaaaat)) {
    	$check=$record->username;
    	$found=1;
     $resultt = mysqli_query($mysqli, "SELECT donation, online,loggedin FROM stats  WHERE username='$record->username'  LIMIT 1");
    while ($rec = mysqli_fetch_object($resultt)) { $don=$rec->donation; $played=floor($rec->online/3600); $lastonline = date("d-m-Y H:i", $rec->loggedin); }

    echo"<table>
    <tr><td>Username	<Td>$record->username
    <tr><td>Location	<Td>$record->location
    <tr><td>Premium		<td>"; if($don>0){ echo"<font color=greeN><b>YES $don</b></font>";}else{ echo"Has not donated";}
	echo"<tr><td>Fullname: 	<Td>$record->fullname<BR>
     <tr><td>Gender: 	<Td>$record->gender<BR>
     <tr><td>Email: 	<Td>$record->email<BR>
     <tr><td>Age: 	<Td>$record->age<BR>
     <tr><td>Joined: 	<Td>".(floor((time()-$record->joined)/86400))." days ago<BR>
     <tr><td>Last online at:</td><td> $lastonline<BR>
     <tr><td>Currently online:</td><td>" . ($record->online ? "Yes" : "No") . "<BR>
	 <tr><td>Online time: 	<Td>$played hours<BR>
     <tr><td>Hours per day	<td>".($played/(floor((time()-$record->joined)/86400)))."
     <tr><td>Country: 	<Td>$record->country   <BR>
     <tr><td>Gold: 	<Td>$record->gold (only gold on character, not houses etc.)<BR>
     </table><Hr>";

   if($record->password==''){
		echo"Password is empty; is freezed.<br/>";
	}else{
	    $share=''; $resultaat = mysqli_query($mysqli, "SELECT username FROM users  WHERE password='$record->password' && username<>'$check'");
	    while ($rec = mysqli_fetch_object($resultaat)) {
	         $share=$share.", $rec->username";
	     }
	      if($share){
		   echo"Shares the same password with:<br />
		  $share";
		  }
	}
     echo"<hr>";


    echo"<BR><B>IP shares</B> (only uses the last 0.5 year of logins)<br>";
   	   echo"<table>";
   	   $timeout=$timee-3600*24*178;
$resultaaaat = mysqli_query($mysqli, "SELECT ip, count FROM ips  WHERE username='$check' && lastlogin>$timeout");
    while ($record = mysqli_fetch_object($resultaaaat))
	{
        $resultaaat = mysqli_query($mysqli, "SELECT username, count FROM ips  WHERE username!='$check' && ip='$record->ip' && lastlogin>$timeout");
    	while ($rec = mysqli_fetch_object($resultaaat))
		{
		 	echo"<tr><Td>$check<Td>&<td>$rec->username <td>share $record->ip<td> [$check used it $record->count times, $rec->username $rec->count times]";
		}
    }
    echo"</table>";

	}





    if($found!=1){
    	echo"<b>Username not found, did you mean...</b><br />";
    	if($checkEmail){
 			$search="email LIKE '%$checkEmail%'";
 		}else{
 			$search="username LIKE'%$check%'";
			}
$resultaaaat = mysqli_query($mysqli, "SELECT email, username FROM users  WHERE $search LIMIT 10");
    while ($record = mysqli_fetch_object($resultaaaat)) {
    	echo"$record->username - $record->email <br />";

    	}
    }
    echo "<br />";

}

############################
}elseif($multi=='tradelogs'){ ## TRADE

echo"<form action='' method=post>
Player: <input type=text name=trade><input type=submit value=check></form>";

if($trade){
$resultaaaat = mysqli_query($mysqli, "SELECT titel, tekst FROM zlogs WHERE titel LIKE 'Trading $trade - %' OR titel LIKE 'Trading % - $trade' ORDER BY ID DESC ");
    while ($record = mysqli_fetch_object($resultaaaat)) {
    echo"<B>$record->titel</B><BR>
    $record->tekst<BR>
    <BR>";    }
}

}else if($multi=='stockhouses'){

    echo "<form action='' method='post'>";

    echo "Clan tag: <input type='text' name='clantag' value='$clantag' size=15> &nbsp;
        <input type=submit class='button' value='Search'>";

    echo "</form>";

    if(true || $clantag)
    {
        echo "<style>
                table.stockhouseLog
                {
                    border-collapse:collapse;
                    text-align: left;
                }
                table.stockhouseLog th,td
                {
                    border-bottom: 1px solid white;
                    padding: 2px 5px 2px 5px;
                }
                table.stockhouseLog tr:hover
                {
                    background-color: #111;
                    color: #FFF;
                }
            </style>";

        $sql = "SELECT * FROM clanbuildings WHERE tag='$clantag' ORDER BY location ASC";
        $resultset = mysqli_query($mysqli,$sql);
        $haveClan = false;
        if(!$clantag || $record = mysqli_fetch_object($resultset))
        {
            if($clantag)
            {
                $haveClan = true;
            }

            if($haveClan)
            {
                $stockhouseDropdown = "<option value=''>All stockhouses</option>";
                do
                {
                    $stockhouseDropdown .= "<option value='$record->ID'" . ($filterStockhouseID == $record->ID ? " selected='selected'" : "") . ">$record->location</option>";
                }while($record = mysqli_fetch_object($resultset));
            }

            echo "<form action='' method='post'><input type='hidden' name='clantag' value='$clantag'>";

            echo ($haveClan ? "<select name='filterStockhouseID'>$stockhouseDropdown</select> &nbsp;" : "") .
                "Person: <input type='text' name='filterUsername' value='$filterUsername' size=15> <br/>
                Item: <select name='filterMatch'>
                <option value='1'" . ($filterMatch == 1 ? " selected='selected'" : "") . ">Starts</option>
                <option value='2'" . ($filterMatch == 2 ? " selected='selected'" : "") . ">Equals</option>
                <option value='3'" . ($filterMatch == 3 ? " selected='selected'" : "") . ">Contains</option>
                </select>
                <input type='text' name='filterItem' value='$filterItem' size=15> &nbsp;
                Action: <select name='filterType'>
                <option value=''>All</option>
                <option value='1'" . ($filterType == 1 ? " selected='selected'" : "") . ">Add item</option>
                <option value='2'" . ($filterType == 2 ? " selected='selected'" : "") . ">Remove item</option>
                <option value='6'" . ($filterType == 5 ? " selected='selected'" : "") . ">Add gp</option>
                <option value='7'" . ($filterType == 5 ? " selected='selected'" : "") . ">Remove gp</option>" .
                //"<option value='3'" . ($filterType == 3 ? " selected='selected'" : "") . ">Request</option>" .
                "<option value='4'" . ($filterType == 4 ? " selected='selected'" : "") . ">Approve</option>
                <option value='5'" . ($filterType == 5 ? " selected='selected'" : "") . ">Decline</option>
                </select><input type=submit class='button' value='Search'>";

            echo "</form>";

            $filter = false;

            $filters = " AND action != 'requestItem'";
            if($haveClan)
            {
                $urlCriteria = "&amp;clantag=$clantag";
            }

            if($filterStockhouseID)
            {
                $filters .= " AND clanbuildingID = '$filterStockhouseID'";
                $urlCriteria .= "&amp;filterStockhouseID=$filterStockhouseID";
            }

            if($filterUsername)
            {
                $filters .= " AND user = '$filterUsername'";
                $urlCriteria .= "&amp;filterUsername=$filterUsername";
                $filter = true;
            }

            if($filterItem)
            {
                if(strtolower($filterItem) == "gp")
                {
                    $filterItem = "Gold pieces";
                }

                switch($filterMatch)
                {
                    case 2:
                        $urlCriteria .= "&amp;filterMatch=$filterMatch";
                        $filters .= " AND name = '$filterItem'";
                        break;

                    case 3:
                        $urlCriteria .= "&amp;filterMatch=$filterMatch";
                        $filters .= " AND name LIKE '%$filterItem%'";
                        break;

                    default:
                        $filters .= " AND name LIKE '$filterItem%'";
                        break;
                }

                $urlCriteria .= "&amp;filterItem=$filterItem";

                $filter = true;
            }

            if($filterType)
            {
                switch($filterType)
                {
                    case 1:
                        $typeSQL = "addItem";
                        break;

                    case 2:
                        $typeSQL = "removeItem";
                        break;

                    /*case 3:
                        $typeSQL = "requestItem";
                        break;*/

                    case 4:
                        $typeSQL = "approveRequest";
                        break;

                    case 5:
                        $typeSQL = "declineRequest";
                        break;

                    case 6:
                        $typeSQL = "addGP";
                        break;

                    case 7:
                        $typeSQL = "removeGP";
                        break;
                }

                if($typeSQL)
                {
                    $filters .= " AND action = '$typeSQL'";
                    $urlCriteria .= "&amp;filterType=$filterType";
                }
            }

            if($filter)
            {
                if($filterItem)
                {
                    if(strtolower($filterItem) == "gold pieces" || strtolower($filterItem) == "gp")
                    {
                        $sql = "SELECT location, gp FROM clanbuildings WHERE tag = '$clantag' ORDER BY location ASC";
                        //echo "$sql<br/><br/>";

                        $resultset = mysqli_query($mysqli,$sql);
                        if($record = mysqli_fetch_object($resultset))
                        {
                            do
                            {
                                echo number_format($record->gp) . " gp at $record->location<br/>";
                            }while($record = mysqli_fetch_object($resultset));
                        }
                        else
                        {
                            echo "No $filterItem in the stockhouses.<br/><br/>";
                        }
                    }
                    else
                    {
                        switch($filterMatch)
                        {
                            case 2:
                                $itemFilters .= " AND name = '$filterItem'";
                                break;

                            case 3:
                                $itemFilters .= " AND name LIKE '%$filterItem%'";
                                break;

                            default:
                                $itemFilters .= " AND name LIKE '$filterItem%'";
                                break;
                        }

                        if($filterStockhouseID)
                        {
                            $itemFilters .= " AND clanbuildingID = '$filterStockhouseID'";
                        }

                        $sql = "SELECT CBI.*, CB.location FROM clanbuildingsitems CBI JOIN clanbuildings CB ON CB.ID = CBI.clanbuildingID WHERE tag = '$clantag'$itemFilters ORDER BY location ASC, name ASC, itemupgrade ASC, upgrademuch ASC";
                        //echo "$sql<br/><br/>";

                        $resultset = mysqli_query($mysqli,$sql);
                        if($record = mysqli_fetch_object($resultset))
                        {
                            do
                            {
                                $upg='';
                                if($record->itemupgrade)
                                {
                                    $upg=" [$record->upgrademuch $record->itemupgrade]";
                                }

                                echo "$record->much $record->name$upg at $record->location<br/>";
                            }while($record = mysqli_fetch_object($resultset));
                        }
                        else
                        {
                            echo "No $filterItem in the stockhouses.<br/><br/>";
                        }
                    }
                }
                $selectSQL = "COUNT(CBL.ID) AS totalItems";
                $sql = "SELECT $selectSQL FROM clanbuildingslog CBL JOIN clanbuildings CB ON CB.ID = CBL.clanbuildingID WHERE " .
                    ($haveClan ? "tag = '$clantag'" : "1=1") . "$filters ORDER BY logtime DESC";
                //echo "$sql<br/><br/>";

                $totalItems = 0;
                $resultset = mysqli_query($mysqli,$sql);
                if($record = mysqli_fetch_object($resultset))
                {
                    $totalItems = $record->totalItems;
                }

                if($totalItems > 0)
                {
                    $paginationControls = "";
                    if(!$startAt)
                    {
                        $startAt = 0;
                    }
                    $maxPerPage = 50;
                    $count = 0;
                    $totalPages = 0;
                    $currentPage = 0;
                    $count = $totalItems;

                    while($count > 0)
                    {
                        $totalPages++;
                        $count -= $maxPerPage;
                    }
                    if($totalPages > 1)
                    {
                        if($startAt > $totalPages * $maxPerPage)
                        {
                            $startAt = ($startAt - $maxPerPage);
                            if($startAt < 0)
                            {
                                $startAt = 0;
                            }
                        }
                        if($startAt > $maxPerPage - 1)
                        {
                            $paginationControls .= "<a href='?page=$page&multi=stockhouses$urlCriteria&amp;startAt=" . ($startAt - $maxPerPage) . "'> &lt; </a> &nbsp; ";
                        }
                        $currentPage = ($startAt + $maxPerPage) / $maxPerPage;

                        for($i = 1; $i <= $totalPages; $i++)
                        {
                            if($i == $currentPage)
                            {
                                $paginationControls .= "<b>$i</b> &nbsp; ";
                            }
                            else if($i <= 5 || ($i >= $currentPage - 2 && $i <= $currentPage + 2) || i > $totalPages - 5 || $totalPages <= 20)
                            {
                                $paginationControls .= "<a href='?page=$page&multi=stockhouses$urlCriteria&amp;startAt=" . ($i * $maxPerPage - ($maxPerPage)) . "$urlCriteria'>$i</a> &nbsp; ";
                            }
                            else if($i == 6 || $i == $totalPages - 5 && $totalPages - 5 > 13 && strpos($paginationControls, " ... ", strlen($paginationControls) - 5) === 0)
                            {
                                $paginationControls .= " ... ";
                            }
                        }
                        if($startAt < $totalPages * $maxPerPage - $maxPerPage)
                        {
                            $paginationControls .= "<a href='?page=$page&multi=stockhouses$urlCriteria&amp;startAt=" . ($startAt + $maxPerPage) . "'> &gt; </a>";
                        }
                    }
                    if($totalPages > 1)
                    {
                        $paginationControls .= "<br />";
                    }
                    else
                    {
                        $paginationControls = "";
                    }

                    echo "$paginationControls";

                    $selectSQL = "CBL.*, CB.location";
                    $sql = "SELECT $selectSQL FROM clanbuildingslog CBL JOIN clanbuildings CB ON CB.ID = CBL.clanbuildingID WHERE " .
                        ($haveClan ? "tag = '$clantag'" : "1=1") . "$filters ORDER BY logtime DESC LIMIT $startAt, $maxPerPage";
                    //echo "$sql<br/><br/>";

                    $resultset = mysqli_query($mysqli,$sql);
                    if($record = mysqli_fetch_object($resultset))
                    {
                        echo "<br/><table class='stockhouseLog'><tr>
                            <th>Date</th>
                            <th>Player</th>
                            <th>Action</th>
                            <th>Location</th>
                            <th>Amount</th>
                            <th>Item</th>
                            <th></th>
                            </tr>";
                        do
                        {
                            $action = "";
                            switch($record->action)
                            {
                                case "addItem":
                                    $action = "Added";
                                    break;

                                case "removeItem":
                                    $action = "Removed";
                                    break;

                                case "requestItem":
                                    $typeSQL = "Requested";
                                    break;

                                case "approveRequest":
                                    $action = "Approved";
                                    break;

                                case "declineRequest":
                                    $action = "Declined";
                                    break;

                                case "addGP":
                                    $action = "Added gp";
                                    break;

                                case "removeGP":
                                    $action = "Removed GP";
                                    break;

                                case "requestGP":
                                    $action = "Requested gp";
                                    break;
                            }

                            $upg='';
                            if($record->itemupgrade)
                            {
                                $upg=" [$record->upgrademuch $record->itemupgrade]";
                            }

                            $for="";
                            if($record->forUser)
                            {
                                $for = "for $record->forUser";
                            }

                            echo "<tr>
                                <td>" . date("Y-m-d H:i:s", $record->logtime) . "</td>
                                <td>$record->user</td>
                                <td>$action</td>
                                <td>$record->location</td>
                                <td>$record->much</td>
                                <td>$record->name$upg</td>
                                <td>$for</td>
                                </tr>";
                        }while($record = mysqli_fetch_object($resultset));
                        echo "</table><br/><br/>";
                    }
                }
                else
                {
                    echo "No logs matched your search.";
                }
            }
            else
            {
                echo "You must enter a player or item to search for.";
            }
        }
        else
        {
            echo "Incorrect tag or the clan [$clantag] has no stockhouse.";
        }
    }

}## EINDE MULTI TOOLS










}
?>