<?php
if ($pass == '134fe')
{
    ###############################
    ## ELKE MIDNIGHT DAILY  (te vaak runnen: vage daily stats)
    ###############################

    $ip = $_SERVER['REMOTE_ADDR'];
    //GAMEURL, SERVERURL etc.
    require_once ("../currentRunningVersion.php");
    // Require the main game file.
    require_once (GAMEPATH . "includes/db.inc.php");

    $datum = date("d-m-Y H:i");
    $time = $timee = time();

    $dateH = date(Y_m_d_);


$saaql = "INSERT INTO bugreports (username, text, time, type)
	 	VALUES ('CRONJOB', 'CRONJOB DAY NEVER ENDED!', '$beginTime', 'CRON')";
    mysqli_query($mysqli, $saaql) or die("Func Item add error 2, please report !");
	$CRONJOBID=$mysqli->insert_id;
	
	
	 
	 $sql = "UPDATE api SET todayshighscorerequests=0, todaysothers=0, todaysuserlistrequests=0, todaysclanlistrequests=0, todaysprofilerequests=0, todaysauctionrequests=0";
        mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
	 

    ### AANMAKEN
    # STATISTICS
    #################
    $seconds = time() - 1109977200;
    $syrniaday = floor($seconds / 86400);

    $resultaat = mysqli_query($mysqli, "SELECT ID FROM statistics WHERE syrniaday='$syrniaday' LIMIT 1");
    $excists = mysqli_num_rows($resultaat);

    if ($excists != 1)
    {


        $resultaat = mysqli_query($mysqli, "SELECT ID FROM users WHERE joined>($time-86400)");
        $joinstoday = mysqli_num_rows($resultaat);

        $resultaat = mysqli_query($mysqli, "SELECT ID FROM users WHERE joined>($time-86400*7)");
        $joinsweek = mysqli_num_rows($resultaat);

        $resultaat = mysqli_query($mysqli, "SELECT ID FROM stats WHERE loggedin>($time-86400)");
        $loginstoday = mysqli_num_rows($resultaat);

        $resultaat = mysqli_query($mysqli, "SELECT ID FROM stats WHERE loggedin>($time-86400*2)");
        $loginslast2days = mysqli_num_rows($resultaat);

        $resultaat = mysqli_query($mysqli, "SELECT ID FROM stats WHERE loggedin>($time-86400*7)");
        $loginslast7days = mysqli_num_rows($resultaat);


        $gold = 0;
        $resultaat = mysqli_query($mysqli, "SELECT gold FROM buildings");
        while ($record = mysqli_fetch_object($resultaat))
        {
            $gold = $record->gold + $gold;
        }
        echo "$gold..";
        $resultaat = mysqli_query($mysqli, "SELECT gold FROM users");
        while ($record = mysqli_fetch_object($resultaat))
        {
            $gold = $record->gold + $gold;
        }
        echo "$gold..";
        $resultaat = mysqli_query($mysqli, "SELECT bid FROM auctions");
        while ($record = mysqli_fetch_object($resultaat))
        {
            $gold = $record->bid + $gold;
        }
        echo "Total: $gold<BR>";
        #$gold

        $items = 0;
        $resultaat = mysqli_query($mysqli, "SELECT ID FROM items_inventory");
        $items = mysqli_num_rows($resultaat);
        echo "$items..";
        $resultaat = mysqli_query($mysqli, "SELECT ID FROM items_wearing");
        $items = mysqli_num_rows($resultaat);
        echo "$items..";
        $resultaat = mysqli_query($mysqli, "SELECT ID FROM dropped_items");
        $items = $items + mysqli_num_rows($resultaat);
        echo "$items..";
        $resultaat = mysqli_query($mysqli, "SELECT ID FROM shops");
        $items = $items + mysqli_num_rows($resultaat);
        echo "$items..";
        $resultaat = mysqli_query($mysqli, "SELECT ID FROM auctions");
        $items = $items + mysqli_num_rows($resultaat);
        echo "$items..";
        $resultaat = mysqli_query($mysqli, "SELECT ID FROM houses");
        $items = $items + mysqli_num_rows($resultaat);
        echo ": Total $items<BR>";

        $resultaat = mysqli_query($mysqli, "SELECT ID FROM messages");
        $messages = mysqli_num_rows($resultaat);

        $resultaat = mysqli_query($mysqli, "SELECT totalskill FROM users");
        $totalskills = 0;
        while ($record = mysqli_fetch_object($resultaat))
        {
            $totalskills = $record->totalskill + $totalskills;
        }
        #totalskills

        $resultaat = mysqli_query($mysqli, "SELECT ID FROM clans GROUP BY name");
        $clans = mysqli_num_rows($resultaat);

        $resultaat = mysqli_query($mysqli, "SELECT ID FROM clans");
        $playersinclan = mysqli_num_rows($resultaat);

        $resultaat = mysqli_query($mysqli, "SELECT ID FROM stats where donation>0");
        $donators = mysqli_num_rows($resultaat);

        $resultaat = mysqli_query($mysqli, "SELECT donation FROM stats");
        $donations = 0;
        while ($record = mysqli_fetch_object($resultaat))
        {
            $donations = $record->donation + $donations;
        }
        #donations

        $resultaat = mysqli_query($mysqli, "SELECT ID FROM news");
        $newsitems = mysqli_num_rows($resultaat);

        $resultaat = mysqli_query($mysqli, "SELECT ID FROM questslist GROUP by quest");
        $quests = mysqli_num_rows($resultaat);

        $resultaat = mysqli_query($mysqli, "SELECT ID FROM users WHERE totalskill<50");
        $lessthan50totall = mysqli_num_rows($resultaat);

        $resultaat = mysqli_query($mysqli,
            "SELECT ID FROM users WHERE location like 'Tutorial %'");
        $attutisland = mysqli_num_rows($resultaat);

        $resultaat = mysqli_query($mysqli, "SELECT username FROM users where password like  '%]_[%'");
        $activationreq = mysqli_num_rows($resultaat);

		$resultaat = mysqli_query($mysqli, "SELECT ID FROM auctions WHERE time<'$time' ");
        $auctions = mysqli_num_rows($resultaat);


        $sql = "INSERT INTO statistics (syrniaday, joinstoday,  joinsweek, loginstoday, loginslast7days, loginslast2days, gold, 
   items, messages, totalskills, clans, playersinclan, donators, donations, 
   newsitems, quests, lessthan50totall, attutisland, activationreq, time, auctions) 
   VALUES ('$syrniaday', '$joinstoday',  '$joinsweek', '$loginstoday', '$loginslast7days', '$loginslast2days', '$gold', '$items', '$messages',
    '$totalskills', '$clans', '$playersinclan', '$donators', '$donations', '$newsitems', '$quests', '$lessthan50totall', '$attutisland', 
    '$activationreq', '$timee', '$auctions')";


        mysqli_query($mysqli, "$sql") or die("error !!!!<BR><B>$sql</B>");

        echo "New statistics in " . (time() - $timee) . "seconds<BR>";


    } #MAKEN STATISTIDCS


    //Not crucial, remove old events:
    $timeO = $timee - (3600 * 24 * 7);
    $resultaat = mysqli_query($mysqli,
        "SELECT ID,location FROM locations WHERE (monstersmuch=0 OR (rewarded=1 && type='chest')) && startTime<'$timeO'");
    while ($record = mysqli_fetch_object($resultaat))
    {
        $sql = "DELETE FROM locations WHERE ID='$record->ID' LIMIT 1";
        mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
        $sql = "DELETE FROM invasions WHERE eventID='$record->ID'";
        mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");
    }
    $timeout = $timee - 3600 * 24;
    $sql = "DELETE FROM pvp WHERE time<'$timeout'";
    mysqli_query($mysqli, $sql) or die("error report this bug pleaseMESSAGE");


    echo ".";

 	mysqli_query($mysqli, "DELETE FROM  bugreports WHERE ID='$CRONJOBID' LIMIT 1") or   die("UaCRO");


} else
{
    echo ",";
}
?>