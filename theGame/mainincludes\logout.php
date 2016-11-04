<?php
session_unset();
session_destroy();
#mysqli_query($mysqli,"UPDATE users SET work='', worktime='', dump='', dump2='' WHERE username='$user' LIMIT 1") or die("ert113");

ob_start();

if($error=='inactive'){

	echo"<h2>You have been logged out</h2>
	You have been logged out because of inactivity for a long while.<BR>
	Feel free to re-login.<BR>
	<BR>";

}else{




 $timee=time();
  $sql = "SELECT lastaction FROM stats WHERE username='$usera' LIMIT 1";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat)) { $lastaction=$record->lastaction;    }


if($lastaction<>'' AND $lastaction>$timee-2700){
$newtime=time()-1200;
mysqli_query($mysqli,"UPDATE stats SET online=online+($timee-$lastaction), lastaction=$newtime, lastvalid=$newtime WHERE username='$usera' LIMIT 1") or die("error --> 544343");
}

$why==htmlentities(trim($why));
if($why){
	echo"<u>You were automaticly logged of for a know reason, the error code is:<B>$why</B><br></u><BR>";
}


if($why=='No session!'){

	echo"<i><BR>The <B>$why</B> error:<BR>
	<li>If this error occurs if you have been inactive for too long, this is normal.<br /></li>
	<li>But it could also occur after logging in using Internet Explorer, it does not allow sessions to be transferred to new windows, and doesn't handle cookies properly.
	To be able to play syrnia, login and click on the <b>\"Having contant problems logging in ? Then, and only then, click here.\"</B> line after logging in.<BR>
	Although you will probably not be able to open up the messages window and other screens.<BR>
	Install Firefox or Chrome for optimal gameplay.<BR>

</li>

	<BR><BR></i>
	";

}elseif($why=='c'){
 echo"<B>You have been logged out because another player has logged in just before you did OR the person before you did not logout properly!  You will need to wait some minutes before you can login.</B><BR><BR>
<B>If there was no other player than make sure you got 'Cookies' <font color=green>enabled</font>, this is required to play Syrnia.<BR></B>
If you cannot seem to solve this problem, please contact support@syrnia.com.<BR>
I added the requirement of cookies 10 december.<BR>
<h1>How to enable cookies?</h1>";
?>
<b>Microsoft Internet Explorer 6.0+</b>
        <ul>
          <li>Select "Internet Options" from the Tools menu.
          <li>Click on the "Privacy" tab.
          <li>Click the "Default" button (or manually slide the bar down to &quot;Medium&quot;) under &quot;Settings&quot;.
          <li>Click "OK".
        </ul>
        <b>Microsoft Internet Explorer 5.x</b>
        <ul>
          <li>Select "Internet Options" from the Tools menu.
          <li>Click on the "Security" tab.
          <li>Click the "Custom Level" button.
          <li>Scroll down to the "Cookies" section.
          <li>To enable:
            <ul>
              <li>Set "Allow cookies that are stored on your computer" to "Enable".
              <li>Set "Allow per-session cookies" to "Enable".
            </ul>
          <li>Click "OK".
        </ul>
        <b>Microsoft Internet Explorer 4.x </b>
        <ul>
          <li>Select "Internet Options" from the View menu.
          <li>Click on the "Advanced" tab.
          <li>Scroll down to find &quot;Cookies&quot; within the "Security" section.
          <li>To enable:
            <ul>
              <li>Select "Always accept cookies".
            </ul>
          <li>Click "OK".
        </ul>
        <b>Netscape Communicator 4.x </b>
        <ul>
          <li>Select "Preferences" from the Edit menu.
          <li>Find the &quot;Cookies&quot; section in the &quot;Advanced&quot; category.
          <li>To enable:
            <ul>
              <li>Select "Accept all cookies" (or "Enable all cookies").
            </ul>
          <li>Click "OK".
        </ul>
        </font>
        <?php
	}



if($S_who==''){
	echo"<span class='mainpageheader'>You have logged out</span><br />
	You have been logged out successfully.<BR>
	Thanks again for playing!<BR>
	<BR>";
}else{
	 echo"If you have been logged out without reason, make sure you got cookies enabled!<BR>
	If you keep having trouble and keep getting logged out the game then please contact syrnia@syrnia.com for help.";
}





}//error



$LOGIN = "<form id=\"loginform\" action='login.php' method=post><div style=\"\"><span class='mainpageheader'>Want to relogin?</span><br />
<table cellspacing=0 cellpadding=0>
<tr><td>Username </td><td><input class=inputForm type=text name=username id='usernameInput'></td></tr>
<tr><td>Password </td><td><input class=inputForm type=password name=password></td></tr>
<tr><td></td><td><select class=selectbox id='screenwidth' name=screenwidth><option value=800>800x600<option value=1024 selected>1024x768<option value=1152>1152x864<option value=1280>1280x1024</select></td></tr>
</table>
<a href=index.php?page=lostpw><b><small>Lost password ?</small></b></a>
</div><center>". MakeButton("Login", "#", 198, "_self", "$('loginform').submit();return false;")."</center><input type=image src='/layout/newdesign/pixel.png' border='0' width='1' height='1'></form>";


echo "<center>$LOGIN</center>";
echo "<script type=\"text/javascript\">$('usernameInput').focus();";
if($_COOKIE["gamescreenwidth"]){ echo"$('screenwidth').value=".$_COOKIE["gamescreenwidth"].";"; }
echo"</script>";

//echo "<center>".MakeParchment("$LOGIN", "top", "center", 220, 250)."</center>";


	$output = ob_get_contents();
	ob_end_clean();
	$inhoud= MakeParchment("$output", "top", "left", 764-18*2, 245);
	echo MakeWoodContainer($inhoud, 764, 270);


?>