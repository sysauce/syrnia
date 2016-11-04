<?php
session_start();


require_once ("currentRunningVersion.php");
require_once (GAMEPATH . "includes/db.inc.php");


$googleadds = 0;


define('AZtopGame35Heyam', true);
$datum = date("d-m-Y H:i");
$time = time();
if ($page == 'logout')
{
    $usera = $S_user;
    $S_user = '';
    if ($player)
    {
        $usera = $player;
    }
    if ($why <> 'c')
    {
        $empty = '';
        setcookie("Syrnia", $empty, 1);
    }
}
if ($who)
{
    $S_who = $who;
    $_SESSION["S_who"] = $S_who;
}

$refera = $_SERVER['HTTP_REFERER'];
if ($refera && $S_refer == '' && stristr($refera, "http://www.syrnia.com") === false &&
    stristr($refera, "http://syrnia.com") === false)
{
    $resultaat = mysqli_query($mysqli, "SELECT refer FROM refers WHERE refer='$refera' LIMIT 1");
    $aantal = mysqli_num_rows($resultaat);
    $S_refer = $refera;
    $_SESSION["S_refer"] = $S_refer;
    if ($aantal == 1)
    {
        mysqli_query($mysqli, "UPDATE refers SET count=count+1 WHERE refer='$refera' LIMIT 1") or
            die("err2or --> 1");
    } else
    {
        $sql = "INSERT INTO refers (refer, count)
	         VALUES ('$refera', '1')";
        mysqli_query($mysqli, $sql) or die("Syrnia is not accesible at the moment, please come back in a while");
    }
} #refer


if (DEBUGMODE){
	echo "<div id=\"testWarning\" style=\"position:fixed;top: 0; background-color: black;color: red; width: 100%\" onclick=\"document.getElementById('testWarning').style.display='none'\"><b><center>YOU ARE USING THE LIVE TEST VERSION OF SYRNIA <small>(Click to close)</small></center></b></div>";
}



function MakeButton($text, $link, $width, $target = '_self', $onclick = ''){
	if($onclick){
		$onclick=" onclick=\"$onclick\"";
	}
	$but = '<table border=0 cellpadding=0 cellspacing=0 width="'.$width.'" height="21">
	<tr><td width=8 background=layout/newdesign/buttonLeft.png></td>
	<td background=layout/newdesign/buttonMid.png class="ButtonText"><a href="'.$link.'" target="'.$target.'" '.$onclick.' class="ButtonText" style="color:white;">'.$text.'</a></td>
	<td width=8 background=layout/newdesign/buttonRight.png></td></tr></table>';
	return $but;
}

function MakeParchment($inhoud, $valign, $align, $width, $height){
	$divW = $width - 14;
	$out = '<table border=0 cellpadding=0 cellspacing=0 width="'.$width.'" height="'.$height.'">
			<tr>
			<td background=layout/newdesign/parcLT.jpg width="3" height="6"></td>
			<td background=layout/newdesign/parcT.jpg></td>
			<td background=layout/newdesign/parcRT.jpg width="3"></td>
			</tr><tr>
			<td background=layout/newdesign/parcL.jpg></td>
			<td background=layout/newdesign/parcMid.jpg valign="'.$valign.'" align="center" ><div style="width:'.$divW.'px;text-align:'.$align.';">'.$inhoud.'</div></td>
			<td background=layout/newdesign/parcR.jpg></td>
			</tr><tr>
			<td background=layout/newdesign/parcLB.jpg height="6"></td>
			<td background=layout/newdesign/parcB.jpg></td>
			<td background=layout/newdesign/parcRB.jpg></td>
			</tr>
			</table>';
	return $out;
}

function MakeWoodContainer($inhoud, $width, $height){
	$out = '<table border=0 cellpadding=0 cellspacing=0 width="'.$width.'" height="'.$height.'">
	<tr>
	<td background=layout/newdesign/woodLT.jpg width="18" height="18"></td>
	<td background=layout/newdesign/woodT.jpg width="'.($width-18*2).'"></td>
	<td background=layout/newdesign/woodRT.jpg width="18"></td>
	</tr><tr>
	<td background=layout/newdesign/woodL.jpg></td>
	<td bgcolor="#1A1006" valign="middle">'.$inhoud.'</td>
	<td background=layout/newdesign/woodR.jpg></td>
	</tr><tr>
	<td background=layout/newdesign/woodLT.jpg height="18"></td>
	<td background=layout/newdesign/woodT.jpg></td>
	<td background=layout/newdesign/woodRT.jpg></td>
	</tr>
	</table>';
	return $out;
}


?>
<html lang="en">
  <HEAD>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <TITLE><?php $m = htmlentities(trim(($m)));
if ($page == 'registration')
{
    $titel = "Online rpg, free signup/registration";
} elseif ($page == 'about')
{
    $titel = "RPG game features";
} elseif ($page == 'manual')
{
    $titel = "Skills, levels and experience are described in the Manual $m";
} else
{
    $titel = "Free online rpg Syrnia - The multiplayer adventure world";
}
echo $titel;
?> - Mobile version</TITLE>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <meta name="verify-v1" content="KyaIuGcleyipbmZV3KYJkL0a0g5Bq+dYSV6HW6T/WEM=" />
	<META NAME="company"  CONTENT="M2H">
    <META NAME="ROBOTS" CONTENT="INDEX,FOLLOW">
    <META http-equiv=Content-Type content="text/html; charset=utf-8">
    <META NAME="Description" CONTENT="Free online RPG game Syrnia multiplayer. Many skills involved and tons of items, weapons, armour, quests, adventures and monsters. Text based browsergame free forever.">
    <META NAME="KeyWords" CONTENT="Syrnia, free, online, mmporg, rpg, textbased, text, based, multiplayer, game, skills, levels, adventure, quests, items, weapons, armour, quests, adventures, monsters">
    <META NAME="revisit-after" CONTENT="14 days">
    <style type="text/css">
	body {
		margin: 0px;
		font-family: Georgia, sans-serif;
		color: black;
		font-size: 12px;
		background-color: #0D0D0D;
	}
	table {
		font-family: Georgia, sans-serif;
		color: black;
		font-size: 12px;
	}

	A:link 		{color: #000000; }
	A:visited 	{color: #000000; }
	A:active 	{color: #000000; }
	A:hover 	{color: #000000; }

	.ButtonText {
		font-size: small;
		font-weight: bold;
		color: white;
		text-align: center;
		text-decoration: none;
	}
	.footerText{
		font-size: small;
		color: white;
	}

	input[type=text] {
		width: 100px;
		background-color: #F6EEE1;
	}
	input[type=password] {
		width: 100px;
		background-color: #F6EEE1;
	}
	input[type=select] {
		width: 100px;
		background-color: #F6EEE1;
	}
	input[type=option] {
		width: 100px;
		background-color: #F6EEE1;
	}
	.selectbox {
		background-color: #F6EEE1;
		width: 100px;
	}
	.mainpageheader {
		color: #600707;
		font-weight: bold;
		font-size: medium;
	}
	form { margin: 0; padding: 0 }

	</style>
	<script src="<?php echo GAMEURL; ?>scriptaculous-js-1.8.3/lib/prototype.js" type="text/javascript"></script>
	<?
	 //<script src="scriptaculous-js-1.8.3/src/scriptaculous.js" type="text/javascript"></script>
	?>
	</head>
    <script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-3410356-1");
pageTracker._initData();
pageTracker._trackPageview();
</script>
  <body topmargin=0 leftmargin=0 rightmargin=0 bottommarin=0>
  <center>
<div style="background-color: #DBC091;"><center>This is the mobile version of Syrnia, <a href="index.php?alwaysDesktop=1?">click here</a> to view the desktop version</div> </center><br />
  <table border=0 cellpadding=0 cellspacing=1 width="100%" height="100%">
<tr valign=top><td bgcolor="#0D0D0D" align="right"><img src="layout/newdesign/pixel.png" border="0" width="1" height="1" />
<?
/*
<div style="height:206px;"></div>


$inhoud='<script type="text/javascript"><!--
google_ad_client = "pub-8058836226253609";
// SyrniaFrontLeftVertical 120x600, gemaakt 5-8-09
google_ad_slot = "4154927445";
google_ad_width = 120;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>';
if($page){
	echo MakeWoodContainer($inhoud, 120+18*2, 600+18*2);
} */
?>

</td><td align="center">



<a href="http://www.Syrnia.com" title="Free online RPG game"><img alt="Syrnia the free online RPG game" src="layout/newdesign/SyrniaLogo.png" border="0" /></a><br />

<table width="764">
<tr align="center"><td>
	<?php echo MakeButton("Home", "?", 120, ""); ?>
</td><td>
	<?php echo MakeButton("Game Tour", "?page=gametour", 120, ""); ?>
</td><td>
	<?php echo MakeButton("News", "?page=news", 120, ""); ?>
</td><td>
	<?php echo MakeButton("Forum", "?page=forum", 120, ""); ?>
</td><td>
	<?php echo MakeButton("Manual", "?page=manual", 120, ""); ?>
</td><td>
	<?php echo MakeButton("Highscore", "?page=highscore", 120, ""); ?>
</td>
</tr></table>
<div style="height:6px;"></div>

<?

$inhoud='
<script type="text/javascript"><!--
google_ad_client = "pub-8058836226253609";
google_alternate_color = "DEC598";
google_ad_width = 728;
google_ad_height = 90;
google_ad_format = "728x90_as";
google_ad_type = "text_image";
google_ad_channel ="2371201346";
google_color_border = "DEC598";
google_color_bg = "DEC598";
google_color_link = "9D1919";
google_color_text = "000000";
google_color_url = "000000";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>';
echo MakeWoodContainer($inhoud, 764, 136); ?>




<br />



<?php
if ($page == 'gametour' or $page == 'faq' or $page == 'register' or $page ==
    'lostpw')
{
    include (GAMEFOLDER . "mainincludes/$page.php");
} elseif ($page == 'C' or $page == 'confirm')
{
    include (GAMEFOLDER . "mainincludes/confirm.php");
} elseif ($page == 'news')
{
    include (GAMEFOLDER . 'mainincludes/news.php');
} elseif ($page == 'highscore')
{
    include (GAMEFOLDER . 'mainincludes/highscore.php');
} elseif ($page == 'loggedin' && $S_user)
{
    include (GAMEFOLDER . 'mainincludes/loggedin.php');
} elseif ($page == 'highscoreT')
{
    include (GAMEFOLDER . 'mainincludes/highscoreT.php');
} elseif ($page == 'highscore2')
{
    include (GAMEFOLDER . 'mainincludes/highscore2.php');
} elseif ($page == 'manual')
{
    include (GAMEFOLDER . 'mainincludes/manual.php');
} elseif ($page == 'logout')
{
    include (GAMEFOLDER . 'mainincludes/logout.php');

    if ($usera && $why <> 'c')
    {
        mysqli_query($mysqli, "UPDATE users SET online=0 WHERE username='$usera' LIMIT 1") or
            die("Syrnia is not accesible at the moment, please come back in a while  --> 544343");
        mysqli_query($mysqli, "UPDATE staffrights SET isOnline=0 WHERE username='$usera' LIMIT 1") or
            die("Error  --> 2346");
    }

} elseif ($page == 'vote' && ($vote == 'topwebgames' or $vote == 'apexwebgaming' or
$vote == 'toprpggames'))
{


    $datum = date("dmY");
    $giftname = 'Green gift';
    $giftmuch = rand(2, 3);
    $gifttype = 'open';
    $uid = str_replace("?user=", '', "$uid");
    $uid = str_replace("?uid=", '', "$uid");
    if ($uid == '')
    {
        $uid = $user;
    }
    if ($uid == '' && $pass)
    {
        $uid = $pass;
    }

    if ($uid)
    {
        $resultaat = mysqli_query($mysqli, "SELECT ID FROM votes WHERE datum='$datum' && username='$uid' && site='$vote' LIMIT 1");
        $aantal = mysqli_num_rows($resultaat);
        if ($aantal == 0)
        {

            echo "You have successfully voted";
            $sql = "INSERT INTO votes (username, datum, site)
         VALUES ('$uid', '$datum', '$vote')";
            mysqli_query($mysqli, $sql) or die("erroraa report this bug");

            $resultaaat = mysqli_query($mysqli,
                "SELECT username FROM items_inventory WHERE name='$giftname' && username='$uid' LIMIT 1");
            $aantal = mysqli_num_rows($resultaaat);
            if ($aantal == 1)
            {
                mysqli_query($mysqli, "UPDATE items_inventory SET much=much+'$giftmuch' WHERE name='$giftname' && username='$uid' LIMIT 1") or
                    die("err2or --> 1");
            } else
            {
                $sqll = "INSERT INTO items_inventory (username, name, much, type)
         VALUES ('$uid', '$giftname', '$giftmuch', '$gifttype')";
                mysqli_query($mysqli, $sqll) or die("erroraa report this bug");
            }

        } else
        {
            echo "You already voted and got reward for voting on that site today.";
        }
    }
} elseif ($page == 'forum'){

	include (GAMEFOLDER . 'mainincludes/forum.php');


} elseif ($page == 'login')
{
    echo "<center>";
    include (GAMEFOLDER . 'mainincludes/login.php');
} else
{
    include (GAMEFOLDER . 'mainincludes/index.php');
}

?>




<a href="http://www.M2H.nl" title="M2H Game Studio"><img alt="M2H Game Studio" src="layout/newdesign/M2HLogo.png" border="0" /></a><br />
<span class=footerText>&copy; <?php echo date(Y); ?> M2H - <a href="index.php?alwaysDesktop=1" style="color:white;">Desktop version</a></span><br />

<script type="text/javascript"><!--
google_ad_client = "pub-8058836226253609";
/* 728x15, gemaakt 12-5-10, Syrnia smallbreed onderin */
google_ad_slot = "1961684333";
google_ad_width = 728;
google_ad_height = 15;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>


</td><td bgcolor="#0D0D0D"><img src="layout/newdesign/pixel.png" border="0" width="1" height="1" />
<?
// <img src="layout/newdesign/pixel.png" border="0" width="156" height="1" /><div style="height:206px;"></div>
?></td></tr>
</table>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-729998-1";
urchinTracker();
</script>
</center>
</body>
</html>