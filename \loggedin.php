<?php
session_start();
//define('AZtopGame35Heyam', true );
if ($_SESSION['S_user'])
{

    $timee = $time = time();

    //GAMEURL, SERVERURL etc.
    require_once ("currentRunningVersion.php");
    require_once (GAMEPATH . "includes/db.inc.php");
    require_once("theGame/ajax/includes/functions.php");

    echo "<html>";
    echo "<HEAD><TITLE>Syrnia</TITLE>";
    echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"style3.css\"><META HTTP-EQUIV=\"CACHE-CONTROL\" CONTENT=\"PUBLIC\">";
    echo "<link rel=\"shortcut icon\" href=\"favicon.ico\" type=\"image/x-icon\" />";
    echo "</HEAD>";
?>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-3410356-1");
pageTracker._initData();
pageTracker._trackPageview();
</script>
<?php
    echo "<BODY background=\"layout/layout3_BG.jpg\" alink=ff0000 link=ff0000 text=000000 vlink=ff0000 style='color: #000000;'>";
    echo "<center><br />";
    echo "<Table width=95% cellpadding=5 cellspacing=0><tr bgcolor=#E2D3B2><td>";


    $timee = time();

    if ($screenwidth == 1280)
    {
        $screenwidth = 1280;
        $height = 924;
    } elseif ($screenwidth == 1152)
    {
        $screenwidth = 1152;
        $height = 800;
    } elseif ($screenwidth == 1024)
    {
        $screenwidth = 1024;
        $height = 700;
    } #768
    else
    {
        $screenwidth = 800;
        $height = 550;
    } #600



    echo "<script type=\"text/javascript\">
    function openGame(){

    	return window.open(\"" .
        SERVERURL . "game.php\",\"Syrnia\", \"width=$screenwidth,height=$height,top=0,left=0,scrollbars=yes,resizable=yes\");

    }
    openGame();
</script>

<center><h3>Welcome to Syrnia</h3>";

    if ($poll)
    {
        //echo"<b><font color=red>There is a poll available!, <a href=poll.php?p=answer>answer it.</a></font></b><BR><BR>";
    }

    $datum = date("d-m-Y H:i");

    /*if($lastlogin=='' || !is_numeric($lastlogin))
    {
        $sqal = "SELECT loggedin FROM stats WHERE username='$S_user' LIMIT 1";
        echo $sqal;
        $resultaaaat = mysqli_query($mysqli, $sqal);
        while ($record = mysqli_fetch_object($resultaaaat))
        {
            $lastlogin = floor((time() - $record->loggedin) / 3600);
            echo "(" . time() . " - " . $record->loggedin . " / 3600 = $lastlogin<br />";
    	}
    }
    else
    {*/
        //$lastlogin = floor((time() - $lastlogin) / 3600);
    //}

    echo "You have logged in, the game opened in a pop-up screen. <BR>
 you can now close this window if you want to.<BR>
<BR>
If the game did not open, please enable pop-ups for syrnia.com.<BR>
You can also click <a href=\"" . SERVERURL . "game.php\" onClick='openGame();return false;'><B>here</B></a> to open the game in a popup window, or <a href=\"" . SERVERURL . "game.php\"><b>here</b></a> to open the game in this window.<br />";

		echo"<br />
You logged in $datum Syrnia time.<br />
Your last login was " . $_SESSION["lastloggedin"] . " hour(s) ago.<br />";

    if ($S_donation >= 2500)
    {
        $resultaaat = mysqli_query($mysqli, "SELECT ID FROM users WHERE online=1");
        $aantal = mysqli_num_rows($resultaaat);
        echo "<BR><BR>There are $aantal players online.<BR>";
    }

    echo "
<br />
<hr />
<br />
<center>
<table>";
    echo "<tr valign=top align=left><td width=350>";


    echo "<h3>Game notes</h3>
Please consider buying Syrnia premium points, <a href=" . GAMEURL .
        "includes2/support.php target=_blank>read more about premium points</a>,<Br>
premium points keep this game running fast and keep updates coming.<BR>
You can even help Syrnia out without purchasing anything! Read the support page for more information.<br>";

    echo "
<br /><br />
Got any (login) problems playing the game ?<BR>
Then we suggest you to try using the latest version Firefox, as it has the best performance when playing Syrnia.<br />
<br /><br /><br />";


    echo "</td><td width=350>";

    echo "<h3>Last 3 Syrnia <a href=".SERVERURL."/?page=news>news</a> topics</h3>";
    $sqal = "SELECT date, titel FROM news ORDER BY ID DESC LIMIT 3";
    $resultaaaat = mysqli_query($mysqli, $sqal);
    while ($record = mysqli_fetch_object($resultaaaat))
    {
        echo "<u>$record->titel</u> - $record->date<BR>";
    }

    echo "</tr>";


    if ($S_donation >= 2500)
    {

        echo "<tr valign=top align=left><td>";


        echo "<h3>Current events</h3>";

        $sqal = "SELECT monster, location FROM partyfight WHERE hp > 0 AND hideInEventList = false";
        $resultaaaat = mysqli_query($mysqli, $sqal);
        while ($record = mysqli_fetch_object($resultaaaat))
        {
            $invasion .= "<font color=red>There is " . (aOrAn($record->monster) ? "an " : "a ") . "$record->monster at $record->location.</font><BR>";
        }

        $sqal = "SELECT monsters, location, invasiontime, type, dump FROM locations WHERE ((monstersmuch>0 && rewarded=0 && startTime<'$timee') OR ((monstersmuch>0 && type='invasion') && startTime<'$timee')) AND hideInEventList = false";
        $resultaaaat = mysqli_query($mysqli, $sqal);
        while ($record = mysqli_fetch_object($resultaaaat))
        {

            /*if (strstr($record->location, "Arch. cave 2") === false && strstr($record->
                location, "Arch. cave 4") === false && ($record->location <> 'Holiday lake' && $record->
                location <> 'Syrnia celebration center' or date(jn) == '53'))
            {*/


                if ($record->type == 'invasion')
                {
                    $invasion .= "<font color=red>There is " . (aOrAn($record->monsters) ? "an " : "a ") . $record->monsters . " invasion at $record->location.</font><BR>";
                }else if ($record->type == 'skillevent')
                {
                    $invasion .= "<font color=red>There is " . (aOrAn($record->dump) ? "an " : "a ") . $record->dump . " event at $record->location.</font><BR>";
                } elseif ($record->type == 'chest')
                {
                    $invasion .= "<font color=red>A locked chest with $record->invasiontime combinations has been found at $record->location.</font><BR>";
                } elseif ($record->type == 'contest')
                {
                    $invasion .= "<font color=red>There is a contest at $record->location.</font><BR>";
                } elseif ($record->type == 'collect')
                {
                    $invasion .= "<font color=red>There is a collection event at $record->location.</font><BR>";
                }
            //}

        }
        if ($invasion)
        {
            echo "$invasion";
        } else
        {
            echo "There are no events at the moment.<BR>";
        }


        echo "</td><td>";


        echo "<h3>Last 10 <a href=" . GAMEURL .
            "includes2/messages.php>messages</a></h3>";

        $sqal = "SELECT sendby, topic FROM messages WHERE username='$S_user' && status<100 ORDER BY ID DESC LIMIT 10";
        $resultaaaat = mysqli_query($mysqli, $sqal);
        while ($record = mysqli_fetch_object($resultaaaat))
        {
            $messa .= "<tr><td>$record->sendby </td><td>-</td><td> <B>$record->topic</B> </td></tr>";
        }


        if ($messa)
        {
            echo "<table>";
            echo "$messa";
            echo "</table>";
        } else
        {
            echo "<i>You have no messages.</i><BR>";
        }

        echo "</td></tr>";


    }
    echo "</table></center>";

    echo "<br /><br /></td></tr></table><br />";
    echo "</center>";
    echo "</body>";
    echo "</html>";


} else
{
    echo "You are not logged in (any more).<br />
	If you just tried to re-login then there's a problem with the settings of your browser, you could try to temporary reduce the security settings to test if that helps.<br />";
}


?>