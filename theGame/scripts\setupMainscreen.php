<?php
session_start();
$timee=$time=time();
define('AZtopGame35Heyam', true );
if(!$S_user){
	echo"alert('Not logged in!')";
  exit();
}
// Require generic functions.
require_once("../includes/db.inc.php");

if (mysqli_connect_errno())
{
    exit();
}

$refer = $_SERVER["HTTP_REFERER"];
$parts = Explode('/', $refer);

//echo"alert(\"" . $parts[count($parts) - 1] . "\");";

//Don't load any of the usual page stuff if we're in popup chat
if($parts[count($parts) - 1] != 'chat.php')
{
    //echo"alert(\"chat\");";

    ////////////
    // MESSAGES
    $resultaat = mysqli_query($mysqli, "SELECT username FROM messages WHERE username='$S_user' && status=0");
    $aantal = mysqli_num_rows($resultaat);
    if($aantal>0){
        echo"$('messagesCounter').innerHTML=\"<small>($aantal new message" . ($aantal == 1 ? "" : "s") . ")</small>\";";
    }else{
        echo"$('messagesCounter').innerHTML=\"\";";
    }

    //////////
    // EVENTS
    if($S_donation >= 2500)
    {
        $eventCounter = 0;
        $resultaat = mysqli_query($mysqli, "SELECT monster, location FROM partyfight WHERE hp > 0 AND hideInEventList = false");
        $eventCounter += mysqli_num_rows($resultaat);

        $resultaat = mysqli_query($mysqli, "SELECT monsters FROM locations WHERE
            (((monstersmuch>0 && rewarded=0 && startTime<'$timee') OR ((monstersmuch>0 && type='invasion') && startTime<'$timee'))) AND hideInEventList = false");
        $eventCounter += mysqli_num_rows($resultaat);
        if($eventCounter > 0){
            echo"$('eventCounter').innerHTML=\"<small>($eventCounter event" . ($eventCounter == 1 ? "" : "s") . ")</small>\";";
        }else{
            echo"$('eventCounter').innerHTML=\"\";";
        }
    }




    /////////////////
    /// CHAT, INVENTORY, GOOGLE SEARCH options

            $sql = "SELECT chat,googlesearch,inventoryheight FROM stats WHERE username='$S_user' LIMIT 1";
            $resultaat = mysqli_query($mysqli, $sql);
            while ($record = mysqli_fetch_object($resultaat))
            {
                 $chat=$record->chat;
                 $googlesearch=$record->googlesearch;
                 $inventoryheight=$record->inventoryheight;
            }



    if($inventoryheight>0){
        echo"$('playerInventory').height=\"$inventoryheight\";";
    }
    if($googlesearch==2){
        echo"$('googleSearchContainer').innerHTML=\"\";";
    }



    if($var1!='periodUpdate'){//Called from periodupdater
        include_once('../ajax/includes/wearstats.php');
        wearStats($S_user, 1);
    }

    include_once('../ajax/includes/levels.php');
    include_once('../ajax/includes/mapData.php');


    //Right frame stuff:
    $sql = "SELECT gold FROM users WHERE username='$S_user' LIMIT 1";
    $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat)) {   $gold=$record->gold; }


    echo"$('statsHPText').innerHTML=\"$hp\";";
    echo"$('statsMaxHPText').innerHTML=\"$maxhp\";";
    echo"$('statsGoldText').innerHTML=\"$gold\";";
    echo"$('statsTotalSkillText').innerHTML=\"$totalskill\";";
    echo"$('statsCombatLevelText').innerHTML=\"$combatL\";";
    echo"$('statsFameText').innerHTML=\"$fame\";";

    echo"$('speedLevelText').innerHTML=\"$speedl\";";
    echo"$('cookingLevelText').innerHTML=\"$cookingl\";";
    echo"$('farmingLevelText').innerHTML=\"$farmingl\";";
    echo"$('magicLevelText').innerHTML=\"$magicl\";";
    echo"$('attackLevelText').innerHTML=\"$attackl\";";
    echo"$('defenceLevelText').innerHTML=\"$defencel\";";
    echo"$('healthLevelText').innerHTML=\"$healthl\";";
    echo"if(\$('strengthLevelText')){\$('strengthLevelText').innerHTML=\"$strengthl\";}";
    echo"$('miningLevelText').innerHTML=\"$miningl\";";
    echo"$('smithingLevelText').innerHTML=\"$smithingl\";";
    echo"$('fishingLevelText').innerHTML=\"$fishingl\";";
    echo"$('woodcuttingLevelText').innerHTML=\"$woodcuttingl\";";
    echo"$('constructingLevelText').innerHTML=\"$constructingl\";";
    echo"$('tradingLevelText').innerHTML=\"$tradingl\";";
    echo"$('thievingLevelText').innerHTML=\"$thievingl\";";
}


$sql = "SELECT ignoreList FROM options WHERE username='$S_user' LIMIT 1";
$resultaat = mysqli_query($mysqli,$sql);
while ($record = mysqli_fetch_object($resultaat))
{
	$theIgnoreList = explode(',', addslashes($record->ignoreList));
	foreach($theIgnoreList as $ignoredPlayerIndex => $ignoredPlayer){
	    echo("ignoreList[$ignoredPlayerIndex] = '$ignoredPlayer';");
	}
}




?>
