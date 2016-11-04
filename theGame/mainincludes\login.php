<?php
if(defined('AZtopGame35Heyam')){
	
	ob_start();
	
	if($fee==1){
		echo "<B><font color=blue>The username you've tried to login with has been freezed by the game staff.<br />You should have recieved a message/email about this.</b></font><BR>
		Want to see the F.A.Q. or contact the support ? <A href=index.php?page=faq>Click here</a>.<BR>";	
	}else{
		echo"<B><font color=blue>There is no user with that username and password combination.</b></font><BR>
		<BR>
		<A href=index.php?page=lostpw>Use the LOST PW</a> option if you are not sure about your login details.<BR>
		Want to see the F.A.Q. or contact the support ? <A href=index.php?page=faq>Click here</a>.<BR>";
		
		
$LOGIN = "<br /><form id=\"loginform\" action='login.php' method=post><div style=\"\"><span class='mainpageheader'>Login</span><br />
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

	}

	$output = ob_get_contents();
	ob_end_clean();
	$inhoud= MakeParchment("$output", "top", "left", 764-18*2, 245);
	echo MakeWoodContainer($inhoud, 764, 270); 


}
?>