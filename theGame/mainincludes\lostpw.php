<?php
$ip1= $_SERVER['REMOTE_ADDR'];

ob_start();

if($email){

$sql = "SELECT username, password, fullname, email FROM users WHERE email='$email' && password!='' LIMIT 1";
$resultaat = mysqli_query($mysqli,$sql);   $aantal='a';
while ($record = mysqli_fetch_object($resultaat)) {
if($record->password<>''){
$message="Dear $record->fullname,

A password recovery at Syrnia.com has been requested for your account. Hopefully it was you who did this.
Username: $record->username
Password: $record->password

The IP who requested the password was: $ip1
This could be a proxy though.

We hope to see you in Syrnia soon again.

Please do not reply to this email: We will not respond.
Instead use the ticket system to recieve support:
http://www.syrnia.com/tickets.php

Syrnia.com";

$headers = 'From: noreply@syrnia.com' . "\r\n" .
    'Reply-To: noreply@syrnia.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion() . "\r\n" .
    'Return-Path: <noreply@syrnia.com>\r\n';   
mail( "$record->email", "Syrnia",$message, $headers, "-f noreply@syrnia.com");


echo"Your login details have been successfully mailed to your email address.<BR>";
}else{echo"You have not yet activated your account, mail support@syrnia.com if you are having problems.";}
}
if($message==''){echo"There is no user with the email address you specified. <a href=index.php?page=lostpw>Try again</a>"; }

}elseif($userN){

$sql = "SELECT username, password, fullname, email FROM users WHERE username='$userN' && password!='' LIMIT 1";
$resultaat = mysqli_query($mysqli,$sql);   $aantal='a';
while ($record = mysqli_fetch_object($resultaat)) {
if($record->password<>''){
$message="Dear $record->fullname,

You requested a password recovery at Syrnia.com.
Username: $record->username
Password: $record->password

The IP who requested the password was: $ip1
This could be a proxy though.

We hope to see you in Syrnia soon again.

Please do not reply to this email: We will not respond.
Instead use the ticket system to recieve support:
http://www.syrnia.com/tickets.php

Syrnia";
mail( "$record->email", "Syrnia",$message,"From: support@syrnia.com" );
echo"Your login details have been successfully mailed to your email address.<BR>";
}else{echo"You have not yet activated your account, mail support@syrnia.com if you are having problems.";}
}
if($message==''){echo"There is no username which you specified. <a href=index.php?page=lostpw>Try again</a>"; }


}else{

echo"To recover your password for your account please fill in your e-mail address you used to sign up with or fill in your Syrnia username.<BR>
<form action='' method=post><table>
<tr><td>E-mail <td><input type=text name=email>
<tr><td>Username<td><input type=text name=userN>
<tr><td><td><input type=submit value=Recover></table>
</form>";
}


$output = ob_get_contents();
ob_end_clean();
$inhoud= MakeParchment("$output", "top", "left", 764-18*2, 245);
echo MakeWoodContainer($inhoud, 764, 270);



?>