<?php

ob_start();


$REALIP=$_SERVER['REMOTE_ADDR'];
$QueryG = mysqli_query($mysqli,"SELECT banreason, banuntill FROM banned_ips WHERE bannedip='$REALIP' && (banuntill>'$timee' OR banuntill=0) LIMIT 1");
while ($recrd = mysqli_fetch_object($QueryG)) {  $reason=$recrd->banreason; $banuntill=$recrd->banuntill; }

if(DEBUGMODE){
	echo "<br /><b>You can not register a new account on this test game.<br />";
	echo"Please visit www.Syrnia.com to play.<br />";

}else if($reason){

 echo"Your IP address has been banned, you are not allowed to use Syrnia.<br/>
 The following reason was entered when banning your IP:<br/>
 <i>$reason</i><br/>
 <br/>
 ";

if($banuntill!=0){
		echo"This ban will be removed in ".ceil(($banuntill-$timee)/3600)." hours.If there are any problems you can use the ticket system to contact us.
	 You can of course try to use a proxy, but this is not allowed, it will never make your situation any better.<br/>
	 Instead please try to contact us OR wait until the ban is automatically removed.<br/>";
	}else{
	echo"This ban is permanent, unless the staff decides otherwise. If there are any problems you can use the ticket system to contact us.<br/>
	 You can of course try to use a proxy, but this is not allowed, it will never make your situation any better.<br/>
	 Please be wise and contact us instead.<br/>";
	 }


}else{ ## Not allowed to register

echo"<table cellpadding=0 width=100% cellspacing=0>
<tr valign=top><td width=200 align=left>

<B>Is it safe to join?</B> <br />
<ul>
<li><small>This game is <b>free</B></small></li>
<li><small>We will not send you any email except for game related subjects (Signup, inactivity, password reminder).</small></li>
<li><small>..so feel free to join!</small></li>
</ul>

<br />
<B>When / How can I play ?</B> <br />
<ol>
<li><small>Sign-up at this page</small></li>
<li><small>Activate your account via e-mail</small></li>
<li><small>After activation login at Syrnia.com</small></li>
</ol>

</td><td width=3></td><td width=1 bgcolor=#000000><img src=images/pixel.gif></td><td width=3></td><td valign=top align=center>


<span class='mainpageheader'>Sign up for free</span><br />
<br />
<img src=layout/newdesign/RegisterImage.jpg /><br />

";



if(defined('AZtopGame35Heyam')){

if($reg){

if($email==$email2){

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



$pos1 = stristr ($email, "@");
$pos2 = stristr ($email, ".");
$pos3 = stristr ($email, " ");
if($pos1 && $pos2 && $pos3===false){



if(testname($username)=='OK' && $password==htmlentities(trim($password))){



if($akk=='yes' OR $akk=='YES'){
if($username AND $email AND $password){

if($password==$password2){
   $resultaat = mysqli_query($mysqli, "SELECT username FROM users WHERE username='$username' OR email='$email'");
   $aantal = mysqli_num_rows($resultaat);

if($aantal<1 && $username<>'admin' && $username<>'moderator' && $username<>'Captain Keelhail' && $username<>'Battle Mage'){

$username=htmlentities(trim(stripslashes($username)));
$password=htmlentities(trim(stripslashes($password)));
$email=htmlentities(trim($email));



$gold=25;
if($S_who=='toprpgamesEO'){$gold=250;}
 $timee=time();

 $randnum=rand(1000,9999);


 $sql = "INSERT INTO users (username, gold, location, password, email,  joined)
         VALUES ('$username', '$gold', 'Tutorial 1', '$randnum]_[$password', '$email', '$timee')";
      mysqli_query($mysqli,$sql) or die("error report this bug please ->userlist 11");
       $sql = "INSERT INTO users_junk (username)
         VALUES ('$username')";
      mysqli_query($mysqli,$sql) or die("error report this bug please ->userlist 11");
$last=time()+3600;
 $sql = "INSERT INTO stats (username, refer, referlink, lastvalid)
         VALUES ('$username','$S_who', '$S_refer', '$last')";
      mysqli_query($mysqli,$sql) or die("error report this bug please ->userlist 11");

 $sql = "INSERT INTO  donators (username)
         VALUES ('$username')";
      mysqli_query($mysqli,$sql) or die("error report this bug please ->userlist 11");

 $sql = "INSERT INTO options (username)
      VALUES ('$username')";
     mysqli_query($mysqli,$sql) or die("error report this bug please ->userlis 22t");


$message="Dear '$username',

To complete your registration at the online game Syrnia.com please click the following link:
http://www.syrnia.com/index.php?page=C&username=".str_replace(" ", '%20', $username)."&code=$randnum
After clicking you can start playing Syrnia right away!

If the above link does not work copy and paste the following link into your internet browser (Remove the '[' and ']' ! ).
[www.syrnia.com/index.php?page=confirm&username=$username&code=$randnum]
If this also doesn't work please check if you copied the full link. A very common problem is that the computer only copies half of the link, so we advise you to manually type over the full link if you got problems. If this still doesnt work please forward this email to support@syrnia.com.

We hope you will have a lot of fun playing Syrnia.

Thanks for joining,

Syrnias staff

Please do not reply to this email: We will not respond.
Instead use the ticket system to recieve support:
http://www.syrnia.com/tickets.php

-------------------------------
You recieved this e-mail because this e-mail address was used to sign up.
You will NOT recieve mailings from us.";

$headers = 'From: noreply@syrnia.com' . "\r\n" .
    'Reply-To: noreply@syrnia.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion() . "\r\n" .
    'Return-Path: <noreply@syrnia.com>\r\n';
mail( "$email", "Syrnia",$message, $headers, "-f noreply@syrnia.com");


###INGaME STUFF (uit confirm)
  $mess="Welcome to <b>Syrnia</b>.<BR>
We hope you will have a lot of fun playing Syrnia, we are all doing our best to make this game fun.<BR>
We suggest you to read the manual which can be found on the mainpage to learn how to play, everything is described here.<BR>
<a href=http://www.syrnia.com/index.php?page=manual&m=begin target=_blank>Click here for the manual</a><BR>
<BR>
Also to give you a goal, you can check the highscores for any skills to see how good you are compared to other players:<BR>
<a href=http://www.syrnia.com/index.php?page=highscore target=_blank>Click here for the highscore</a><BR>
<BR>
<i>Have fun!</i><BR>";
$time=time();
$sql = "INSERT INTO messages (username, sendby, message, time, topic)
  VALUES ('$username', '<B>Syrnia</B>', '$mess ', '$time', 'Welcome to Syrnia!')";
mysqli_query($mysqli,$sql) or die("error report this bug please33 66 msg");

 $sqll = "INSERT INTO items_wearing (username, name,  type)
         VALUES ('$username', 'Bronze short sword', 'hand')";
      mysqli_query($mysqli,$sqll) or die("erroraa report this bug 1");

       $sqll = "INSERT INTO items_wearing (username, name,  type)
         VALUES ('$username', 'Bronze hands', 'gloves' )";
      mysqli_query($mysqli,$sqll) or die("erroraa report this bug2");
	$sqll = "INSERT INTO items_wearing (username, name,  type)
         VALUES ('$username', 'Bronze sabatons', 'shoes' )";
      mysqli_query($mysqli,$sqll) or die("erroraa report this bug2");

             $sqll = "INSERT INTO items_wearing (username, name,  type)
         VALUES ('$username', 'Bronze small shield', 'shield')";
      mysqli_query($mysqli,$sqll) or die("erroraa report this bug3");

          $sqll = "INSERT INTO items_wearing (username, name,  type)
         VALUES ('$username', 'Bronze medium helm', 'helm')";
      mysqli_query($mysqli,$sqll) or die("erroraa report this bug3");


 $sqll = "INSERT INTO items_wearing (username, name, type)
         VALUES ('$username', 'Beginners horse',  'horse')";
      mysqli_query($mysqli,$sqll) or die("erroraa report this bug4");



 $sqll = "INSERT INTO items_inventory (username, name, much, type)
         VALUES ('$username', 'Bronze pickaxe', '1', 'hand')";
      mysqli_query($mysqli,$sqll) or die("erroraa report this bug5");
 $sqll = "INSERT INTO items_inventory (username, name, much, type)
         VALUES ('$username', 'Bronze hammer', '1', 'hand')";
      mysqli_query($mysqli,$sqll) or die("erroraa report this bug5");
 $sqll = "INSERT INTO items_inventory (username, name, much, type)
         VALUES ('$username', 'Net', '1', 'hand')";
      mysqli_query($mysqli,$sqll) or die("erroraa report this bug6");
 $sqll = "INSERT INTO items_inventory (username, name, much, type)
         VALUES ('$username', 'Tinderbox', '1', 'hand')";
      mysqli_query($mysqli,$sqll) or die("erroraa report this bug8");
 $sqll = "INSERT INTO items_inventory (username, name, much, type)
         VALUES ('$username', 'Bronze hatchet', '1', 'hand')";
      mysqli_query($mysqli,$sqll) or die("erroraa report this bug7");
 $sqll = "INSERT INTO items_inventory (username, name, much, type)
         VALUES ('$username', 'Cooked Shrimps', '5', 'cooked food')";
      mysqli_query($mysqli,$sqll) or die("erroraa report this bug9");

      $timee=time()+3600*2;
mysqli_query($mysqli,"UPDATE stats SET lastvalid='$timee' WHERE username='$username' LIMIT 1") or die("error --> 1");
##



mysqli_query($mysqli,"UPDATE refers SET joins=joins+1 WHERE refer='$S_refer' LIMIT 1") or die("err2or --> 1");



echo"<h5><B>Thank you for registering, you will need to activate your account.<BR>
You can find the activation link in the email , which you will recieve within 10 minutes on your email address: $email.<BR>
If you click on the link in your email you will be able to play Syrnia right away!<BR>
<BR>
Make sure your (spam)filter does not block this e-mail which is sent from support@syrnia.com.</h5></B></I>

<script src=\"http://www.google-analytics.com/urchin.js\" type=\"text/javascript\">
</script>
<script type=\"text/javascript\">
_uacct = \"UA-729998-1\";
urchinTracker();
</script>

";


?>
<!-- Google Code for SyrniaSignup Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1063314009;
var google_conversion_language = "en_GB";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "signup";
var google_conversion_value = 0;
if (0.08) {
  google_conversion_value = 0.08;
}
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1063314009/?value=0.08&amp;label=signup&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<?php

$reg='ok';

$ip1= $_SERVER['REMOTE_ADDR'];
   $resultaat = mysqli_query($mysqli, "SELECT IP FROM ips WHERE ip='$ip1' && count>1 LIMIT 1");
   $aantal = mysqli_num_rows($resultaat);
if($aantal==1){ echo"<br><B>We have noticed another user has logged in on Syrnia from this computer, we will keep an eye open for possible multi accounting.</b><BR><br />"; }

} else { echo"<B><font color=blue>Username or email address allready taken.</b></font><BR><br />"; }
} else { echo"<B><font color=blue>The passwords you entered where not the same, please try again.</b></font><br /><br />"; }
}else { echo"<B><font color=blue>You did not fill in everything, please do so.</b></font><BR><br />"; }
} else { echo"<B><font color=blue>You may only play Syrnia when you accept and follow the rules.</b></font><BR><br />"; }
} else { echo"<B><font color=blue>Please change your username:".testname($username)."</b></font><BR><br />"; }
} else { echo"<B><font color=blue>Please fill in a correct email address.</b></font><BR><br />"; }
} else { echo"<B><font color=blue>The email addresses do not match, please correct it.</b></font><BR><br />"; }
}



####################
if($reg<>'ok'){

echo"You will need to register to be able to play Syrnia.<BR>
Syrnia is free and we do not send mailings.<BR> ";
#####Register dingen
?>
<BR>
<Table cellpadding=0 border=0 cellspacing=1>
<form method=post id='RegForm' action='?page=register&done=1'>
<input type=hidden name=reg value=1>
<tr valign=top><td><B>Do you accept the rules?</b><br />
If so, type 'yes'.

<td>
	<input type="text" name="akk" value='no' size="3" maxlength="3"></td><td width="10"> </td><td> <a href="rules.php" onClick='enterWindow=window.open("rules.php","",
                "width=600,height=600,top=5,left=5,scrollbars=yes"); return false'
                onmouseover="window.status=''; return true;"
                onmouseout="window.status=''; return true;"> Read all rules here</a><BR></td>
<tr valign="top"><td height=5>
<tr valign="top" ><td>Desired <b>username</b>:<td><input type="text" name="username" value='<?php echo"$username"; ?>' size="15" maxlength="15"></td><td width="10"> </td><td><small>This name will be used in the game</small>
<tr valign="top"><td height=5>
<tr valign="top"><td>Desired <b>password</b>: <Td>  <input type="password" name="password" size="15" maxlength="20">
<tr valign="top"><td>Repeat your password: <Td>  <input type="password" name="password2" size="15" maxlength="20">
<tr valign="top"><td height=5>
<tr valign="top"><td>Your <b>e-mail address</b>: <BR><small><td> <input type="text" name="email" value='<?php echo"$email"; ?>' size="20" maxlength="70">
<tr valign="top"><td>Repeat your e-mail address: <td> <input type="text" name="email2" value='<?php echo"$email2"; ?>' size="20" maxlength="70"><BR><BR>

</table>
<? echo MakeButton("Register", "?page=register&done=1", 198, "_self", "$('RegForm').submit();return false;")."<input type=submit style=\"display: none;\">";

?>
<br />
</form>


<?php
}

}
echo"</td></tr></table>";




}#IP BAN

$output = ob_get_contents();
ob_end_clean();
$inhoud= MakeParchment("$output", "top", "left", 764-18*2, 245);
echo MakeWoodContainer($inhoud, 764, 270);


?>
