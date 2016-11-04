<?
$S_user=''; $S_donation='';
//GAMEURL, SERVERURL etc.
require_once("../../currentRunningVersion.php");
include_once(GAMEPATH."includes/db.inc.php");
$timee=time();
  session_start();
if($S_user){

echo"<html>
<HEAD><TITLE>Syrnia</TITLE>
<link type=\"text/css\" rel=\"stylesheet\" href=\"../../style$S_layout.css\">
<META HTTP-EQUIV=\"CACHE-CONTROL\" CONTENT=\"PUBLIC\">
<link rel=\"shortcut icon\" href=\"../../favicon.ico\" type=\"image/x-icon\" />
</HEAD>
<style type=\"text/css\">
body {
	color:#000000;
}
</style>
<BODY background=\"../../layout/layout3_BG.jpg\" alink=ff0000 link=ff0000 text=000000 vlink=ff0000>

<center><br />
 <Table width=95% cellpadding=5 cellspacing=0><tr bgcolor=#E2D3B2><td align=center>";





 if($hideMenu<>1){ ### MENU
echo"<font face=\"Monotype Corsiva, Bookman Old Style, verdana\" color=#cc0000 size=40><B>Syrnia Options</B></font>

<table>
<tr><td><B>General options</B></td><td><B>Premium options</B></td></tr>
<tr valign=top><td>
<ul>
<li><a href=options.php?p=pass>Change password</a><br>
<li><a href=options.php?p=layout>Change layout</a><br>
<li><a href=options.php?p=chat>Chat options</a><br>
<li><a href=options.php?p=privacy>Privacy options</a><br>
<li><a href=options.php?p=dragdrop>Drag&Drop</a><br>
<li><a href=options.php?p=allies>Ally options</a><br>
</ul>
</td><td>
<ul>";

function DonatorText($text, $url, $required){
	global $S_donation;
	if($S_donation>=$required){
		echo"<li><a href=\"$url\">$text</a><br>";
	}else{
		echo"<li><strike>$text</strike><br>";
	}
}
if($S_donation<750){
 echo"<small>You have not yet unlocked any donator options, read the <a href=support.php>support page</a> for more information.</small><br />";
}
DonatorText("Change signature", "options.php?p=signature", 750);
DonatorText("Change avatar", "options.php?p=avatar", 750);
DonatorText("Change botcheck frequency", "options.php?p=botcheck", 1000);
DonatorText("Change trophy", "options.php?p=trophy", 1250);
DonatorText("Change inventory height", "options.php?p=inventoryheight", 3000);
DonatorText("Public login message options", "options.php?p=hidePublicLogin", 3000);
DonatorText("Change google searchbar", "options.php?p=googlesearch", 3500);
DonatorText("Highscore history", "options.php?p=highscore", 5000);


echo"</ul>
</td></tr>
</table>
<br />
<br />";
}## HIDE MENU


##################
if($p=='highscore' && $S_donation>=5000){

echo"<h1>Highscore history</h1>";

if(strlen($month)<=1){$month="0$month";}
if(strlen($day)<=1){$day="0$day";}
$month=htmlentities(trim($month));
$day=htmlentities(trim($day));
$year=htmlentities(trim($year));

if($day && $month && $year){

	if ($rank == username){$order=username; }
	elseif ($rank == mining){$order=mining; }
	elseif ($rank == smithing){$order=smithing;}
	elseif($rank == speed){$order=speed; }
	elseif($rank == attack){$order=attack; }
	elseif($rank == defence){$order=defence; }
	elseif($rank == strength){$order=strength; }
	elseif($rank == health){$order=health; }
	elseif($rank == speed){$order=speed; }
	elseif($rank == level){$order=level; }
	elseif($rank == woodcutting){$order=woodcutting; }
	elseif($rank == constructing){$order=constructing; }
	elseif($rank == trading){$order=trading; }
	elseif($rank == thieving){$order=thieving; }
	elseif($rank == fishing){$order=fishing; }
	elseif($rank == magic){$order=magic; }
	elseif($rank == cooking){$order=cooking; }
	elseif($rank == farming){$order=farming; }
	#elseif($rank == drinking){$order=drinking; }
	else{ $rank=speed; $order=totalskill; }
	$dateH="$year".'_'.$month.'_'.$day.'_';
	$file="../../logs/highscore/newformat/$dateH$order.php";

	if(!file_exists($file) ){
	 	echo"We're sorry, the highscore records only contain all days from 5 June 2007 to now, excluding a few days the game might have been offline.<br/><br/>";
	 	$ok=0;
	}else{
		$ok=1;
	}
}

if($ok!=1){$day=date(d);  $month=date(m);  $year=date(Y);}

echo"<form action='' method=post>
Day:<input type=text name=day size=2 value=".$day.">
Month:<input type=text name=month size=2  value=".$month.">
Year:<input type=text name=year size=4  value=".$year."><input type=submit value=show></form>";

if($ok){
#################################

echo"$day-$month-$year<BR>";


 echo"<center><B>Skill: $order</B></center><BR>
<center>
<table>
<tr><td valign=top>
<center>
<Table>
<tr><td bgcolor=#8F8570>
<table cellpadding=0 cellspacing=0 border=0>
<tr bgcolor=333333 align=center valign=center><td><a href=options.php?p=highscore&year=$year&day=$day&month=$month&rank=level><img border=0 src=../../images/level.gif alt='Combat Level'></a></td><td><a href=options.php?p=highscore&year=$year&day=$day&month=$month&rank=total><img src=../../images/totalskill.gif alt='Total Skill' border=0></a>
<tr><td><a href=options.php?p=highscore&year=$year&day=$day&month=$month&rank=smithing><img src=../../images/skills/smithing.gif border=0 alt='Smithing'></a></td>
<td><a href=options.php?p=highscore&year=$year&day=$day&month=$month&rank=speed><img src=../../images/skills/speed.gif border=0 alt='Speed'></a></td>
<tr><td><a href=options.php?p=highscore&year=$year&day=$day&month=$month&rank=attack><img src=../../images/skills/attack.gif border=0 alt='Attack'></a></td>
<td><a href=options.php?p=highscore&year=$year&day=$day&month=$month&rank=defence><img src=../../images/skills/defence.gif border=0 alt='Defence'></a></td>
<tr><td><a href=options.php?p=highscore&year=$year&day=$day&month=$month&rank=strength><img src=../../images/skills/strenght.gif border=0 alt='Strength'></a></td>
<td><a href=options.php?p=highscore&year=$year&day=$day&month=$month&rank=health><img src=../../images/skills/health.gif border=0 alt='Health'></a></td>
<tr><td><a href=options.php?p=highscore&year=$year&day=$day&month=$month&rank=woodcutting><img src=../../images/skills/woodcutting.gif alt='Woodcutting' border=0></a></td>
<td><a href=options.php?p=highscore&year=$year&day=$day&month=$month&rank=constructing><img src=../../images/skills/constructing.gif alt='Constructing' border=0></a></td>
<tr><td><a href=options.php?p=highscore&year=$year&day=$day&month=$month&rank=trading><img src=../../images/skills/trading.gif border=0 alt='Trading'></a></td>
<td><a href=options.php?p=highscore&year=$year&day=$day&month=$month&rank=thieving><img src=../../images/skills/thieving.gif border=0 alt=Thieving></a></td>
<tr><td><a href=options.php?p=highscore&year=$year&day=$day&month=$month&rank=fishing><img src=../../images/skills/fishing.gif border=0 alt=Fishing></a></td>
<td><a href=options.php?p=highscore&year=$year&day=$day&month=$month&rank=cooking><img src=../../images/skills/cooking.gif border=0 alt=Cooking></a></td>
</tr><tr><Td><a href=options.php?p=highscore&year=$year&day=$day&month=$month&rank=mining><img src=../../images/skills/mining.gif border=0 alt=Mining></a></td>
<Td><a href=options.php?p=highscore&year=$year&day=$day&month=$month&rank=magic><img src=../../images/skills/magic.gif border=0 alt=Magic></a></td>
<tr><Td><a href=options.php?p=highscore&year=$year&day=$day&month=$month&rank=farming><img src=../../images/skills/farming.gif border=0 alt=Farming></a></td>
</table>
</td></tr></table>
<td width=10>
<td valign=top>
<center>
<Table>
<tr><td bgcolor=#8F8570>";
if($order<>'totalskill' && $order<>'level'){
echo"
<Table>
<tr bgcolor=333333>
<td>Rank
<td>Username
<td>Level
<td>Experience
</tr>
";
}else{
echo"
<Table>
<tr bgcolor=333333>
<td>Rank
<td>Username
<td>Level
<td>Total exp
</tr>
";
}

	if (!$file_handle = fopen($file,"r")) { echo "Cannot open file!<br />\n"; }
	if (!$file_contents = fread($file_handle, filesize($file))) { echo "Cannot retrieve file contents. If no one has spoken since 00:00 game time this message is normal.<br />\n"; }
	fclose($file_handle);

	$lines = explode('
', $file_contents);
	$rank=0;
	foreach($lines as $line){
		$data = explode('@', $line);
		if($data[2]){
			$rank++;
			echo  "<tr>
			<td>".$rank."
			<td><a target=_blank href=\"http://www.syrnia.com/index.php?page=highscore2&high=".$data[0]."\"><font color=white>".$data[0]."</font></a>
			<td>".$data[1]."
			<td>".$data[2]."
			</tr>";
		}
	}

echo"</table></table></td></tr></table>";






#################################
}



}elseif($p=='pass'){
	######### PASS
	echo"<B>Change your password</B><BR>";

	if($change){
	if($change=== htmlentities(trim($change2))){
	$sql = "UPDATE users SET password='$change' WHERE username='$S_user' LIMIT 1";
	mysqli_query($mysqli,$sql) or die("error report this bug please  23 pc");
	echo"<B>Changed password</B><BR>";
	}else{ echo"<B>Passwords didn't match! OR you inserted illegal characters in your password, please fix this and try again.</B><BR>"; }
	}

	echo"
	<form action='' method=post>Enter new password: <input type=password name=change maxlength=20><BR>
	Repeat new password: <input type=password name=change2 maxlength=20><BR>
	<input type=submit value=Change></form>";


}elseif($p=='privacy'){
	######### PRIVACY
	echo"<b>Change your privacy setting</b><br /><br />";

	if($change && $level>=0 && $level<=10){
		$sql = "UPDATE options SET apiprivacy='$level' WHERE username='$S_user' LIMIT 1";
		mysqli_query($mysqli,$sql) or die("error report this bug please  23 pc");
		echo"<B>Changed level.</B><br />";
		$currentP=$level;
	}

	$sql = "SELECT apiprivacy FROM options WHERE username='$S_user' LIMIT 1";
   	$resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
		$currentP=$record->apiprivacy;
	}
    if($currentP == 4)
    {
        $currentP = 3;
    }
	$levels[0]="Show everything: Stats, clan, signature, avatar, join date, equipment";
	$levels[1]="Show: Stats, clan, signature, avatar, join date";
	$levels[2]="Show: Stats, clan, signature, avatar";
	$levels[3]="Show: Stats, clan";
	//$levels[4]="Show: Stats";

	echo"<br />
	<form action='' method=post><select name=level>";
	for($i=0;$levels[$i];$i++){
		echo"<option value=$i ";
		if($currentP==$i){
			echo"selected";
		}
		echo">".$levels[$i]."</option>";
	}
	echo"</select><br />
	<input type=hidden name=change value=1>
	<input type=submit value=Change></form><br />
	<small>This privacy settings affects how much information Syrnia-community websites can gather about you.</small>";


}elseif($p=='layout'){
		######### LAYOUT
echo"<B>Change your in-game layout</B><BR>";
if($change>=2 && $change<=3){
	$sql = "UPDATE stats SET layout='$change' WHERE username='$S_user' LIMIT 1";
	mysqli_query($mysqli,$sql) or die("error report this bug please  2341 lc");
	$S_layout=$change;
	echo"<script language=\"JavaScript\">
		window.opener.location=window.opener.location.href.replace('#','');
		</script>";
}
if($disableImages=='1' OR $disableImages=='2'){
 	$disableImages-=1;
	$sql = "UPDATE options SET disableImages='$disableImages' WHERE username='$S_user' LIMIT 1";
	mysqli_query($mysqli,$sql) or die("error report this bug please  2341 lc");
	echo"<script language=\"JavaScript\">
		window.opener.location=window.opener.location.href.replace('#','');
		</script>";
}
if($reduceMainImages=='1' OR $reduceMainImages=='2'){
 	$reduceMainImages-=1;
	$sql = "UPDATE options SET reduceSkillImageSizes='$reduceMainImages' WHERE username='$S_user' LIMIT 1";
	mysqli_query($mysqli,$sql) or die("error report this bug please  2341 lc");
	echo"<script language=\"JavaScript\">
		window.opener.location=window.opener.location.href.replace('#','');
		</script>";
}


echo"
<b>Layout options</b><br />
<br />

<table cellpadding=4>
<tr><td>Select layout: </td><td>
<form action='' method=post><select name=change>
<option value=2>Black layout
<option value=3>Standard red layout.
</select>
<input type=submit value=Change></form>
</td></tr>";

	$sql = "SELECT disableImages,reduceSkillImageSizes FROM options WHERE disableImages=1 && username='$S_user' LIMIT 1";
   	$resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
		if($record->disableImages==1){
			$sel1='selected';
		}
		if($record->reduceSkillImageSizes==1){
			$sel2='selected';
		}
	}
echo"
<tr valign=top><td>Images*:</td><td>
<form action='' method=post><select name=disableImages>
<option value=1>Enabled
<option value=2 $sel1>Disable
</select> <input type=submit value=Change></form><small>*This only affects the inventory items and \"work\" screen images.</small></td></tr>";

echo"
<tr><td>Reduce stat images size</td><td>
<form action='' method=post>
<select name=reduceMainImages>
<option value=1>Disabled
<option value=2 $sel2>Enabled
</select> <input type=submit value=Change></form>
</td></tr>

</table>";

}elseif($p=='dragdrop'){
		######### LAYOUT
echo"<B>Enable or disable the drag & drop inventory</B><BR>";
if($change==1 && $drop==0 or $drop==1){
 	$S_disableDragDrop=$drop;
		$sql = "UPDATE options SET disableDragDrop='$drop' WHERE username='$S_user' LIMIT 1";
		mysqli_query($mysqli,$sql) or die("error report this bug please  2341 dDD");
		echo"<script language=\"JavaScript\">
		window.opener.location=window.opener.location.href.replace('#','');
		</script>";

}
	$opt1=$opt2='';
   $sql = "SELECT disableDragDrop FROM options WHERE username='$S_user' LIMIT 1";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
		if($record->disableDragDrop==1){
			$opt2='selected';
		}else{
			$opt1='selected';
		}
	}

echo"
<form action='' method=post>Drag & Drop:
<input type=hidden name=change value=1>
<select name=drop>
<option value=0 $opt1>Enable
<option value=1 $opt2>Disable
</select>
<BR>
<input type=submit value=Change></form>";



} elseif($p=='signature' && $S_donation>=750){

?>

 <script type="text/javascript"><!--
 var limit = 250;
 function check() {
   if(document.f.signature.value.length > limit) {
     alert('Too much data!');
     document.f.signature.focus();
     return false; }
   else
     return true; }
 function update() {
   var old = document.f.counter.value;
   document.f.counter.value=document.f.signature.value.length;
   if(document.f.counter.value > limit && old <= limit) {
     alert('Too much data in the text box!');
     if(document.styleSheets) {
       document.f.counter.style.fontWeight = 'bold';
       document.f.counter.style.color = '#ff0000'; } }
   else if(document.f.counter.value <= limit && old > limit
	   && document.styleSheets ) {
       document.f.counter.style.fontWeight = 'normal';
       document.f.counter.style.color = '#000000'; }
   }
 //--></script>

<?

echo"<B>Change your forum signature</B><BR>";
if($save){
	$signature = htmlentities(trim($signature));
	$signature = nl2br($signature);
	if(strlen($signature)<=250){
		$sql = "UPDATE donators SET signature='$signature' WHERE username='$S_user' LIMIT 1";
		mysqli_query($mysqli,$sql) or die("error report this bug please  23424 dS");
		echo"Edited signature!<BR>";
	}else{
		echo"Your signature was too long!<BR>";
	}
}
   $sql = "SELECT signature FROM donators WHERE username='$S_user'";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat)) {
$signature = str_replace ("<br />" , "", "$record->signature");
echo" <form name='f' action='' method=post><input type='hidden' name='save' value='1'> Forum signature: (max. 250 chars)<BR>
<textarea cols=35 rows=10 name=signature onkeyup='update();'>$signature</textarea><BR>";

?>

 <script type="text/javascript" language="JavaScript1.2"><!--
    document.write('Characters typed: <input '+
        'type="text" size="3" name="counter" value=""'+
        'readonly onfocus="this.form.signature.focus()"> (limit: 250)');
    update();
 //--></script>

<?

echo "<br/><input type=submit value=Edit></form>";
}



} elseif($p=='avatar' && $S_donation>=750){
echo"<B>Change your forum avatar</B><BR>";

  if($file){

    $filename  =strtolower($_FILES[file][name]);

    $sizeKB = $HTTP_POST_FILES[file][size]/1024;
    $extensie = strtolower(substr($filename, -4));

    if (strtoupper($extensie) == ".JPG" && ($_FILES['file']['type']=='image/jpeg' OR  $_FILES['file']['type']=='image/jpg'  OR  $_FILES['file']['type']=='image/pjpeg' )OR strtoupper($extensie) == ".GIF" && $_FILES['file']['type']=='image/gif'  )
    {

	 	$width = 96;
		$height = 96;

	 	// Get new dimensions
		list($width_orig, $height_orig) = getimagesize($file);
     	$ratio_orig = $width_orig/$height_orig;
     	if ($width/$height > $ratio_orig) {
		   $width = $height*$ratio_orig;
		} else {
		   $height = $width/$ratio_orig;
		}

	    if ($sizeKB >= 200 && $sizeKB>=1){
	    	echo("<B>The picture should be smaller than 200 Kb!</B><BR>");
	    }else{
	     	move_uploaded_file($file, "../../images/avatars/".($S_user)."$extensie");

	    	if($_FILES['file']['type']=='image/jpeg' || $_FILES['file']['type']=='image/pjpeg' || $_FILES['file']['type']=='image/jpg'){
				$image_p = imagecreatetruecolor($width, $height);
				$image = imagecreatefromjpeg("../../images/avatars/".($S_user)."$extensie");
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		     	imagejpeg($image_p,"../../images/avatars/".($S_user)."$extensie",98);
			//}else if($_FILES['file']['type']=='image/jpg'){
			//	$image_p = imagecreatetruecolor($width, $height);
			///	$image = imagecreatefromjpg("../../images/avatars/".($S_user)."$extensie");
			//	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		     //	imagejpg($image_p,"../../images/avatars/".($S_user)."$extensie",98);
			}else{
			 	if($width_orig>=250 || $height_orig>=250){
					$image_p = imagecreatetruecolor($width, $height);
					$image = imagecreatefromgif("../../images/avatars/".($S_user)."$extensie");
					imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		     		imagegif($image_p,"../../images/avatars/".($S_user)."$extensie");
				}
			}


			  echo "<B>Your image has been uploaded!</B><BR>";

			$sql = "UPDATE donators SET avatar='$extensie' WHERE username='$S_user' LIMIT 1";
			mysqli_query($mysqli,$sql) or die("error report this bug please  23431 dA");
			$sql = "UPDATE forummessages SET avatar='$extensie' WHERE username='$S_user'";
			mysqli_query($mysqli,$sql) or die("error report this bug please  23431 dA");
	    }
  }else{
	echo "<B>You can only upload jpg or gif images!</B><BR>";
	echo $_FILES['file']['type'];
}
echo "<br /><br />";
}

echo"Your current avatar:<BR>";
   $sql = "SELECT avatar FROM donators WHERE username='$S_user' && avatar<>'' LIMIT 1";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat)) {$ava=1; echo"<img src=\"../../images/avatars/$S_user$record->avatar?".date(i)."\"><BR>"; }
if($ava<1){ echo"You did not yet upload an avatar.<BR>"; }

echo"
<form action='' method=post enctype=\"multipart/form-data\">
Click on browse to select a picture.<br>
         The picture must be a <b>GIF</b> or <b>JPG</b> image, and smaller than <b>200 kB</b>.<br><br>
         <input type=file name=file>
         <br><input type=submit value=Upload>          </form> ";

############################
} elseif($p=='chat'){

 echo"<B>Chat options</B><br /><br />";

 	if($changeChannels==1){
	   $S_chatChannels="";
	   if($channel1==false){$S_chatChannels=$S_chatChannels."[1]";}
	   if($channel2==false){$S_chatChannels=$S_chatChannels."[2]"; }
	   if($channel3==false){$S_chatChannels=$S_chatChannels."[3]"; }
	   if($channel4==false){$S_chatChannels=$S_chatChannels."[4]"; }
	   if($channel5==false){$S_chatChannels=$S_chatChannels."[5]"; }
		 if($channel6==false && ($S_side=='Pirate' OR $S_staffRights['chatMod']==1)){$S_chatChannels=$S_chatChannels."[6]";}

		$sql = "UPDATE options SET chatChannels='$S_chatChannels' WHERE username='$S_user' LIMIT 1";
		mysqli_query($mysqli,$sql) or die("error report this bug please  23421 ocC");
	}



	if(is_numeric($chatHeight)){
	 	if($chatHeight>=10 && $chatHeight<=600){
	 	 if($floating!=1){$floating=0; $checkedFloat='';}else{ $checkedFloat='checked';}
			$sql = "UPDATE options SET chatHeight='$chatHeight', disableChatFloat='$floating' WHERE username='$S_user' LIMIT 1";
			mysqli_query($mysqli,$sql) or die("error report this bug please  234241 ocH");
			echo"<script language=\"JavaScript\">
			window.opener.location=window.opener.location.href.replace('#','');
			</script>";
		}else{
			echo"You entered an invalid height (10-600 only)<br />";
		}
	}
    $sql = "SELECT chatChannels, chatHeight,disableChatFloat FROM options WHERE username='$S_user' LIMIT 1";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat)) {

    if($record->disableChatFloat==1 && !$chatHeight){
		$checkedFloat='checked';
	}
	if(strstr($S_chatChannels, '[1]')==false){$cha1='checked'; }else{$cha1='';}
	if(strstr($S_chatChannels, '[2]')==false){$cha2='checked'; }else{$cha2='';}
	if(strstr($S_chatChannels, '[3]')==false){$cha3='checked'; }else{$cha3='';}
	if(strstr($S_chatChannels, '[4]')==false){$cha4='checked'; }else{$cha4='';}
	if(strstr($S_chatChannels, '[5]')==false){$cha5='checked'; }else{$cha5='';}
	if(strstr($S_chatChannels, '[6]')==false){$cha6='checked'; }else{$cha6='';}

	echo"You have enabled the following chat channels:<br />
	<form action='' method=post><input type=hidden name=changeChannels value=1><table><tr><td>";
	echo"<tr><td><input type=checkbox name=channel1 value=true $cha1> 1. Region chat</td></tr>";
	echo"<tr><td><input type=checkbox name=channel2 value=true $cha2> 2. World chat</td></tr>";
	echo"<tr><td><input type=checkbox name=channel3 value=true $cha3> 3. Clan chat</td></tr>";
	echo"<tr><td><input type=checkbox name=channel4 value=true $cha4> 4. Trade chat</td></tr>";
	echo"<tr><td><input type=checkbox name=channel5 value=true $cha5> 5. Game help</td></tr>";
	if($S_side=='Pirate' OR $S_staffRights['chatMod']==1){echo"<tr><td><input type=checkbox name=channel6 value=true $cha6> 6. Pirate chat</td></tr>"; }
	echo"<tr><td><input type=submit value=Edit></td></tr></table></form>";



	echo"<form action='' method=post>
	<table>
	<tr><td><b>Chat height:</b></td><td><input type=text size=3 name=chatHeight value=$record->chatHeight></td></tr>";
	echo"<tr><td><b>Disable floating chat:</b></td><td><input type=checkbox name=floating value=1 $checkedFloat></td></tr>";
	echo"<tr><td><a href=options.php?p=ignore&hideMenu=$hideMenu><b>Ignore option</b></a>";
	echo"<tr><td></td><td><input type=submit value=Edit></td></tr></table></form>";
    }



 } elseif($p=='ignore'){

  /* This is just a quick and simple possible implementation managing the ignore list. */
  $theIgnoreList = array();
    if(isset($_POST['ignoreList'])){  //<em>(mod)</em>moderator
    	if($S_donation>=2500){
    		$ignoreAmount=75;
		}else if($S_donation>=2500){
			$ignoreAmount=40;
		}else{
			$ignoreAmount=20;
		}
		$ignoreList= substr(htmlentities($_POST['ignoreList']), 0, $ignoreAmount*22);
		$verifiedList="";
        $theIgnoreListTEMP = explode(',', $ignoreList);

		foreach($theIgnoreListTEMP as $ignoredPlayerIndex => $ignoredPlayer){
		 	if($ignoreAmount>$ignoredPlayerIndex){
			 	$good=0;
	            $sql = "SELECT username FROM users WHERE username='$ignoredPlayer' LIMIT 1";
	          	$resultaat = mysqli_query($mysqli,$sql);
	          	while ($record = mysqli_fetch_object($resultaat))
			  	{
	           		$good=1;
	            	$verifiedList=$verifiedList."$record->username,";
	        	}
	        	if($good!=1 && $ignoredPlayer){
					echo"<font color=red>$ignoredPlayer does not exist.</font><br />";
				}
			}
        }
        $sql = "UPDATE options SET ignoreList='$verifiedList' WHERE username='$S_user' LIMIT 1";
        mysqli_query($mysqli,$sql) or die("error report this bug: chatOptions73261");

        //Reload the current ignorelist
        echo"<script language=\"JavaScript\">";
		//window.opener.ignoreList = new Array();";
       	$theIgnoreList = explode(',', $verifiedList);
		foreach($theIgnoreList as $ignoredPlayerIndex => $ignoredPlayer){
			   echo("window.opener.ignoreList[$ignoredPlayerIndex] = '$ignoredPlayer';");
		}
		echo"</script>";

    } //if


 $sql = "SELECT ignoreList FROM options WHERE username='$S_user' LIMIT 1";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat)) {

//<textarea name='ignoreList' rows=4 cols=20 id='ignoreList'>$record->ignoreList</textarea><br />

echo"<strong>Ignore list</strong><br /><br />
<a href=options.php?p=chat&hideMenu=$hideMenu><b>Back to chat options</b></a><br />
<br />
<form action='' method='post'>
  Please enter a comma seperated list of player names to ignore (no spaces between commas and names e.g. \"Joe,Steve,Harry\"):<br />
  <br />
  	<textarea name='ignoreList'  id='ignoreList' cols=22 rows=4>$record->ignoreList</textarea><br />
    <input type='submit' value='Update' /><br />
    <br />
    <small>This applies to the chat and messages, however this does not affect chat history.</small>
</form>";
  }


############################
} elseif($p=='inventoryheight' && $S_donation>=3000){

echo"<B>Change inventory height</B><BR>";
if($pix){
	if($pix>0 && $pix<=1000){
		$sql = "UPDATE stats SET inventoryheight='$pix' WHERE username='$S_user' LIMIT 1";
		mysqli_query($mysqli,$sql) or die("error report this bug please  23424231");
		echo"Changed to $pix pixels.<BR>";
		echo"<script language=\"JavaScript\">
		window.opener.location=window.opener.location.href.replace('#','');
		</script>";
	} else{echo"The value can only be within 1 and 1000."; }
}
   $sql = "SELECT inventoryheight FROM stats WHERE username='$S_user' LIMIT 1";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat)) {
echo"<form action='' method=post><input type=text name=pix value=$record->inventoryheight size=4><input type=submit value=Edit></form>";
}

##########################
} elseif($p=='googlesearch' && $S_donation>=3500){

	echo"<B>Change searchbar status</B><BR>";
	if($pix==1 OR $pix==2){
	$sql = "UPDATE stats SET googlesearch='$pix' WHERE username='$S_user' LIMIT 1";
	mysqli_query($mysqli,$sql) or die("error report this bug please  23424231");
		echo"Changed!<BR>";
		echo"<script language=\"JavaScript\">
		window.opener.location=window.opener.location.href.replace('#','');
		</script>";
	}
	echo"<form action='' method=post><select name=pix><option value=1>On<option value=2>Off</select><input type=submit value=Edit></form>";


##########################
} elseif($p=='trophy' && $S_donation>=1250){

	include_once('../ajax/includes/functions.php');

	echo"<B>Change trophy</B><BR>";

	$trophy="";
   	$resultaat = mysqli_query($mysqli,"SELECT name, itemupgrade, upgrademuch FROM items_wearing WHERE username='$S_user' && type='trophy' LIMIT 1");
    while ($record = mysqli_fetch_object($resultaat))
	{
		$trophy=$record->name;
		$T_upg=$record->itemupgrade;
		$T_upgM=$record->upgrademuch;
	}
	if($trophy && $submit=='Remove'){
		$type='';
		$resultaat = mysqli_query($mysqli,"SELECT type FROM items WHERE name='$trophy' LIMIT 1");
   	 	while ($record = mysqli_fetch_object($resultaat))
		{
			$trophy_type=$record->type;
		}
		mysqli_query($mysqli,"DELETE FROM items_wearing WHERE username='$S_user' && type='trophy' LIMIT 1");
		addItem($S_user, $trophy, 1, $trophy_type, $T_upg, $T_upgM, 0);
		$trophy="";

		echo"<script language=\"JavaScript\">
		window.opener.location=window.opener.location.href.replace('#','');
		</script>";
	}else if(!$trophy && $newTrophy){//Add new trophy

		$sql = "SELECT name,much,type, itemupgrade, upgrademuch FROM items_inventory WHERE username='$S_user' && ID='$newTrophy' LIMIT 1";
	    $resultaat = mysqli_query($mysqli,$sql);
	    while ($record = mysqli_fetch_object($resultaat))
		{
			removeItem($S_user, $record->name, 1, $record->itemupgrade, $record->upgrademuch, 0);
			mysqli_query($mysqli,"INSERT INTO items_wearing (username, name, itemupgrade, upgrademuch, type) VALUES ('$S_user', '$record->name', '$record->itemupgrade', '$record->upgrademuch', 'trophy');");
			//echo"<b>Added new trophy</b>";
			echo"<script language=\"JavaScript\">
		window.opener.location=window.opener.location.href.replace('#','');
		</script>";
			$trophy=$record->name;
		}

	}
	if($trophy){
		echo"Your current trophy:<br /><img src=\"../../images/inventory/$trophy.gif\">  ";
		echo"<form action='' method=post><input type=submit name=submit value=Remove></form>";
	}else{
		echo"You aren't displaying a trophy.<br /><br />Select a trophy:<br /><form action='' method=post><select name='newTrophy' class=button>";
		$sql = "SELECT ID,name,much, itemupgrade,upgrademuch FROM items_inventory WHERE username='$S_user' ORDER BY name asc";
		$resultaat = mysqli_query($mysqli,$sql);
		while ($record = mysqli_fetch_object($resultaat))
		{
			$plus=''; if($record->upgrademuch>0){$plus="+"; }
			$upg=''; if($record->itemupgrade){ $upg="[$plus$record->upgrademuch $record->itemupgrade]";}
			echo"<option value='$record->ID'>$record->much $record->name $upg";
		}
		echo"</select>";
		echo"<input type=submit value=Change class=button></form>";

	}






##########################
} elseif($p=='hidePublicLogin' && $S_donation>=3000){

	echo"<B>Change public login message</B><br />";
	echo"This options hides or shows the public chat login message.<br /><br />";

	if($hideLogin==1 OR $hideLogin==2 OR $hideLogin==3){
		$hideLogin--;
	$sql = "UPDATE donators SET hidePublicLogin='$hideLogin' WHERE username='$S_user' LIMIT 1";
	mysqli_query($mysqli,$sql) or die("error report this bug please  23424231");
		echo"Changed!<BR>";
	}

	$sel='';
	$sql = "SELECT hidePublicLogin FROM donators WHERE username='$S_user' LIMIT 1";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat)) {
    		if($record->hidePublicLogin==1){
    			$sel="selected";
    		}else if($record->hidePublicLogin==2){
    			$sel2="selected";
    		}
    	}
	echo"<form action='' method=post><select name=hideLogin><option value=1>Always show the login message<option value=2 $sel>Hide login from the public channel only<option value=3 $sel2>Hide login from the public and the clan channel</select><input type=submit value=Save></form>";


##########################
} elseif($p=='botcheck' && $S_donation>=1000){

	echo"<B>Change  botcheck frequency</B><br />";
	echo"To aid when fighting you can undo the reduced botcheck frequency. This only affects the botcheck during fighting.<br /><br />";

	if($changeInterval==900 || $changeInterval==1000 || ($changeInterval==1200 && $S_donation>=10000)){
		$sql = "UPDATE donators SET botcheckinterval='$changeInterval' WHERE username='$S_user' LIMIT 1";
		mysqli_query($mysqli,$sql) or die("error report this bug please  23424231");
		echo"Changed interval!<BR>";
        $_SESSION['S_botcheckinterval'] = $changeInterval;
	}

	$sel='';
	$sql = "SELECT botcheckinterval FROM donators WHERE username='$S_user' LIMIT 1";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat)) {
    		if($record->botcheckinterval==1000){
    			$sel="selected";
    		}else if($record->botcheckinterval==1200){
    			$sel2="selected";
    		}
    	}
	echo"<form action='' method=post><select name=changeInterval><option value=900>+/-15 minutes<option value=1000 $sel>+/-17 minutes";
	if($S_donation>=10000){
		echo"<option value=1200 $sel2>+/-20 minutes";
	}

	echo"</select><input type=submit value=Save></form>";

############################
} elseif($p=='allies'){

 echo"<B>Ally options</B><br /><br />";

        if($editallies){
        $sqll = "UPDATE users_junk SET alliedclans = '" . $editalliedclans . "', alliedplayers = '" . $editalliedplayers . "' WHERE username = '$S_user';";
        mysqli_query($mysqli,$sqll) or die("error updating allies report this bug");
        echo"Allies updated!<BR>";

        $S_playeralliedclans = strtolower($editalliedclans);
        $_SESSION["S_playeralliedclans"] = $S_playeralliedclans;

        $S_playeralliedplayers = strtolower($editalliedplayers);
        $_SESSION["S_playeralliedplayers"] = $S_playeralliedplayers;

        $S_alliedclans = explode(",", $S_playeralliedclans . (strlen($S_playeralliedclans) > 0 ? "," : "") . $_SESSION["S_clanalliedclans"]);
        $_SESSION["S_alliedclans"] = $S_alliedclans;

        $S_alliedplayers = explode(",", $S_playeralliedplayers . (strlen($S_playeralliedplayers) > 0 ? "," : "") . $_SESSION["S_clanalliedplayers"]);
        $_SESSION["S_alliedplayers"] = $S_alliedplayers;
    }
    echo"<form action='' method=post><input type=hidden name=editallies value=1>
        <table>
        <tr valign=top><td colspan='2'>Enter clan tags or player names separated by a ,</td></tr>
        <tr valign=top><td>Clan tags</td><td><textarea name=editalliedclans rows=3 cols=50>" . $_SESSION["S_playeralliedclans"] . "</textarea></td></tr>
        <tr valign=top><td>Players</td><td><textarea name=editalliedplayers rows=3 cols=50>" . $_SESSION["S_playeralliedplayers"] . "</textarea></td></tr>
    <tr><td></td><td><input type=submit value=Update></td></tr></table></form><HR>";

}

echo"</td></tr></table><br />
</center>
</body>
</html>";
}
?>