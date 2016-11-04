<?php
if(defined('AZtopGame35Heyam')){




$REGCONTENT = "<div style=\"height:216px;\"><span class='mainpageheader'>Join now</span><br /><br />
<a href=?page=register><img src=layout/newdesign/frontpageFishing.jpg border=0></a><br /></div><center>". MakeButton("Join now", "?page=register", 198, "")."</center>";

if(1 || rand(0,2)!=0){
	$REGCONTENT = "<div style=\"height:216px;\">
	<script type=\"text/javascript\"><!--
	google_ad_client = \"ca-pub-8058836226253609\";
	/* SyrniaVierkantHome */
	google_ad_slot = \"8422168844\";
	google_ad_width = 200;
	google_ad_height = 200;
	//-->
	</script>
	<script type=\"text/javascript\"
	src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\">
	</script>
	<br /></div><center>". MakeButton("Join now", "?page=register", 198, "")."</center>";
}


$GAMETOUR = "<div style=\"height:216px;\"><center><span class='mainpageheader'>Welcome to Syrnia!</span></center><br />
Syrnia is a browserbased multiplayer game set in a Medieval age.
<ul>
<li>Hundreds of items, monsters and locations</li>
<li>Freedom to choose your own path</li>
<li>Player vs Player combat</li>
<li>15 skills</li>
<li>Highscores</li>
<li>Free to play</li>
</ul></div><center>". MakeButton("Game tour", "?page=gametour", 198, "")."</center>";


$LOGIN = "<form id=\"loginform\" action='login.php' method=post><div style=\"height:216px;\"><span class='mainpageheader'>Login</span>
<img src=layout/newdesign/treasure.jpg border=0 />

<table cellspacing=0 cellpadding=0>
<tr><td>Username </td><td><input class=inputForm type=text name=username id='usernameInput'></td></tr>
<tr><td>Password </td><td><input class=inputForm type=password name=password></td></tr>
<tr><td></td><td><select class=selectbox id='screenwidth' name=screenwidth><option value=800>800x600<option value=1024 selected>1024x768<option value=1152>1152x864<option value=1280>1280x1024</select></td></tr>
</table>
<a href=index.php?page=lostpw><b><small>Lost password ?</small></b></a>
</div><center>". MakeButton("Login", "#", 198, "_self", "$('loginform').submit();return false;")."</center><input type=image src='/layout/newdesign/pixel.png' border='0' width='1' height='1'></form>";







$inhoud= '<table width=100%><tr><td  align="center">
			'.MakeParchment("$REGCONTENT", "top", "center", 220, 250).'
		</td><td align="center">'. MakeParchment("$GAMETOUR", "top", "left", 240, 250).'
		</td><td align="center">'. MakeParchment("$LOGIN", "top", "center", 220, 250).'
		</td></tr></table>';
echo MakeWoodContainer($inhoud, 764, 270);

echo "<script type=\"text/javascript\">
$('usernameInput').focus();";
if($_COOKIE["gamescreenwidth"]){ echo"$('screenwidth').value=".$_COOKIE["gamescreenwidth"].";"; }
echo"</script>";





}
?>