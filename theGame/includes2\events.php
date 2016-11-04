<?
define('inEvents359539dfd', true);

$S_user=''; $S_donation='';

//GAMEURL, SERVERURL etc.
require_once("../../currentRunningVersion.php");
include_once(GAMEPATH."includes/db.inc.php");
include('../ajax/includes/functions.php');

session_start();

$name = htmlentities(trim($name));
$topic = htmlentities(trim($topic));

echo"<html>
<HEAD><TITLE>Syrnia</TITLE>
<link type=\"text/css\" rel=\"stylesheet\" href=\"../../style$S_layout.css\">
<style type=\"text/css\">
body {
	color:#000000;
}
</style>";
?>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="PUBLIC">
<link rel="shortcut icon" href="../../favicon.ico" type="image/x-icon" />
</HEAD>
<?
echo"<BODY background=\"../../layout/layout3_BG.jpg\" alink=ff0000 link=ff0000 text=000000 vlink=ff0000><center><br />";


if($S_user){
$timee=time();

$bgcolor=CDBFA1;

if($S_donation >= 2500)
{
    echo "<table bgcolor=CDBFA1 cellSpacing=0 cellPadding=0 border=1 width=95%>
        <tr valign=top align=left><td>";


    echo "<h3>Current events</h3>";

    $eventCounter = 0;
    $sqal = "SELECT monster, location FROM partyfight WHERE hp > 0 AND hideInEventList = false";
    $resultaaaat = mysqli_query($mysqli, $sqal);
    while ($record = mysqli_fetch_object($resultaaaat))
    {
        $eventCounter++;
        $invasion .= "<font color=red>There is " . (aOrAn($record->monster) ? "an " : "a ") . "$record->monster at $record->location.</font><BR>";
    }

    $sqal = "SELECT monsters, location, invasiontime, type, dump FROM locations WHERE ((monstersmuch>0 && rewarded=0 && startTime<'$timee') OR ((monstersmuch>0 && type='invasion') && startTime<'$timee')) AND hideInEventList = false";
    $resultaaaat = mysqli_query($mysqli, $sqal);
    while ($record = mysqli_fetch_object($resultaaaat))
    {
/*
        if (strstr($record->location, "Arch. cave 2") === false && strstr($record->
            location, "Arch. cave 4") === false && ($record->location <> 'Holiday lake' && $record->
            location <> 'Syrnia celebration center' or date(jn) == '53'))
        {
*/
            $eventCounter++;
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

    echo "</td></tr></table><br/><br/>";

    echo"<script language=\"JavaScript\">if (window.opener && !window.opener.closed){";
	if($eventCounter>0){
  	 	echo"window.opener.document.getElementById('eventCounter').innerHTML = \"<small>($eventCounter event" . ($eventCounter == 1 ? "" : "s") . ")</small>\";";
  	}else{
		echo"window.opener.document.getElementById('eventCounter').innerHTML = '';";
	}
	echo"}</script>";
}



}else{ ## No session, logged out
	echo"Your session timed out: You are not logged in any more.<BR>
	<BR>
	Using IE (Internet Explorer) ?<BR>
	This error message could pop up because IE does not support cookies and sessions properly.<BR
	Use firefox for optimal gameplay.<BR>
	<script type=\"text/javascript\"><!--
	google_ad_client = \"pub-8058836226253609\";
	google_ad_width = 180;
	google_ad_height = 60;
	google_ad_format = \"180x60_as_rimg\";
	google_cpa_choice = \"CAAQ56j8zwEaCHvU9tBAqJJaKMu293M\";
	//--></script>
	<script type=\"text/javascript\" src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\">
	</script>";
}
?>
<br />
</td></tr>
</table>
<br />
</center>
</body>
</html>