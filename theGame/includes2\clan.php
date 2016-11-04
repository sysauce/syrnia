<?
$S_user='';
  session_start();

  //GAMEURL, SERVERURL etc.
require_once("../../currentRunningVersion.php");
include_once(GAMEPATH."includes/db.inc.php");
include_once(GAMEPATH."ajax/includes/functions.php");

if($S_user){
$time=time();
define('AZgaatEU', true );//for clan includes?
define('AZtopGame35Heyam', true);//for chat
$datum = date("d-m-Y H:i");
echo"<html>
<head>
<title>Syrnia - Clan pages</title>
<style>
 TABLE{
 font-size:12px;
 word-spacing:0.4px;
 }
 TABLE th,td{
 font-size:12px;
 }
body {
    font-family: verdana ;
            font-size:12px;
}
.stockhouseLog table
{
    border-collapse:collapse;
    text-align: left;
}
.stockhouseLog th
{
    border-bottom: 1px solid white;
    padding: 2px 5px 2px 5px;
}
.stockhouseLog td
{
    border-bottom: 1px solid white;
    padding: 2px 5px 2px 5px;
}
.stockhouseLog tr:hover
{
    background-color: #000;
}

.innerTable
{
    border: 1px solid black;
    border-collapse: collapse;
}

.innerTable td
{
    border: 1px solid black !important;
    border-collapse: collapse;
    padding: 2px 5px 2px 5px;
}

.innerTable tr
{
    border: 1px solid black !important;
    border-collapse: collapse;
    padding: 2px 5px 2px 5px;
}

.innerTable th
{
    border: 1px solid black !important;
    border-collapse: collapse;
    padding: 2px 5px 2px 5px;
}
</style>
</head><BODY bgcolor=343434 background=../../layout/bgstoneextradark.gif  alink=ff0000 text=ffffff link=ff0000 vlink=ff0000 topmargin=0 leftmargin=0 rightmargin=0 bottommarin=0>";

if(stristr($S_location, 'Tutorial')){
	echo"<br/><br/><br/><center><h3>Please complete the tutorial to gain access to clan tools.</h3><br/>
	<b>You will be able to join a clan after completing the tutorial.</b.<br/></center><br/>";
}else{

$pw=''; $name=''; $tag=''; $rank='';
    $sql = "SELECT name, rank, tag, pw, changeranks,changenews, changeallies, kick, addStock, removeStock, manageStock, alliedclans, alliedplayers FROM clans WHERE username='$S_user' LIMIT 1";
    $resultaat = mysqli_query($mysqli,$sql);
    if($record = mysqli_fetch_object($resultaat))
    {
        $changeclanranks=$record->changeranks;
        $changeclannews=$record->changenews;
        $canchangeallies=$record->changeallies;
        $canKick=$record->kick;
        $canAddStock=$record->addStock;
        $canRemoveStock=$record->removeStock;
        $canManageStock=$record->manageStock;
        $clanname=$record->name;
        $clantag=$record->tag;
        $S_clantag=$record->tag;
        $clanpw=$record->pw;
        $name=stripslashes($record->name);
        $rank=stripslashes($record->rank);
        $tag=stripslashes($record->tag);
        $pw=stripslashes($record->pw);
        $alliedclans = $record->alliedclans;
        $alliedplayers = $record->alliedplayers;

        $S_addStock = $canAddStock || $pw;
        $_SESSION["S_addStock"] = $S_addStock;

        $S_removeStock = $canRemoveStock || $pw;
        $_SESSION["S_removeStock"] = $S_removeStock;

        $S_manageStock = $canManageStock || $record->pw;
        $_SESSION["S_manageStock"] = $S_manageStock;

        $S_clanalliedclans = strtolower($record->alliedclans);
        $_SESSION["S_clanalliedclans"] = $S_clanalliedclans;

        $S_clanalliedplayers = strtolower($record->alliedplayers);
        $_SESSION["S_clanalliedplayers"] = $S_clanalliedplayers;

        $S_alliedclans = explode(",", $S_playeralliedclans . (strlen($S_playeralliedclans) > 0 ? "," : "") . $S_clanalliedclans);
        $_SESSION["S_alliedclans"] = $S_alliedclans;

        $S_alliedplayers = explode(",", $S_playeralliedplayers . (strlen($S_playeralliedplayers) > 0 ? "," : "") . $S_clanalliedplayers);
        $_SESSION["S_alliedplayers"] = $S_alliedplayers;

        $S_clanstockhouses = array();
        if($S_addStock)
        {
            $sql = "SELECT * FROM clanbuildings WHERE tag='$clantag' ORDER BY location ASC";
            $resultset = mysqli_query($mysqli,$sql);
            if($record = mysqli_fetch_object($resultset))
            {
                do
                {
                    $S_clanstockhouses[$record->location] = true;
                }while($record = mysqli_fetch_object($resultset));
            }
        }
        $_SESSION["S_clanstockhouses"] = $S_clanstockhouses;

        $S_processedRequests = array();
        $_SESSION["S_processedRequests"]= $S_processedRequests;
    }
    else
    {
        $S_clantag = "";
        $_SESSION["S_clantag"]= $S_clantag;

        $S_clanstockhouses = array();
        $_SESSION["S_clanstockhouses"] = $S_clanstockhouses;

        $S_addStock = false;
        $_SESSION["S_addStock"] = $S_addStock;

        $S_removeStock = false;
        $_SESSION["S_removeStock"] = $S_removeStock;

        $S_manageStock = false;
        $_SESSION["S_manageStock"] = $S_manageStock;
    }

if($name){ ################# IN A CLAN
echo"<Table width=100% height=38 cellpadding=0 cellspacing=0>
<tr valign=middle align=center background=../../layout/bgstone.gif>
<td ><a href=clan.php?><img src=../../layout/clan_news.gif  border=0></a></td>
<td><a href=clan.php?p=forum><img src=../../layout/clan_forum.gif  border=0></a></td>
<td><a href=clan.php?p=members border=0><img src=../../layout/clan_members.gif  border=0></a></td>
<td><a href=clan.php?p=options border=0><img src=../../layout/clan_options.gif  border=0></a></td>";
if($clanpw||$canKick){ echo" <td><a href=clan.php?p=admin><img src=../../layout/clan_admin.gif  border=0></a></td>"; }
echo"</table><BR><center>";

if($p=='members'){ #### MEMBERS

	# ADMIN UPDATE
	if($changenews==''){$changenews=0;}
    if($changeranks==''){$changeranks=0;}
    if($changeforum==''){$changeforum=0;}
    if($changeallies==''){$changeallies=0;}
    if($kick==''){$kick=0;}
    if($addStock==''){$addStock=0;}
    if($removeStock==''){$removeStock=0;}
    if($manageStock==''){$manageStock=0;}
    if($manageStock)
    {
        $removeStock = 1;
    }
    if($removeStock)
    {
        $addStock = 1;
    }
	if($clanrankchange && $clanrankchange!='Clanleader' && $clanidchange>0 && $pw){
	if($changenews==1 OR $changenews==0){    if($changeranks==1 OR $changeranks==0){  if($changeforum==1 OR $changeforum==0){ if($changeallies==1 OR $changeallies==0){
	$clanrankchange=htmlentities(trim($clanrankchange));
    $sqla = "UPDATE clans SET rank='$clanrankchange', changenews=$changenews, changeranks=$changeranks, changeforum=$changeforum, changeallies=$changeallies,
        kick=$kick, addStock=$addStock, removeStock=$removeStock, manageStock=$manageStock WHERE ID='$clanidchange' && name='$clanname' LIMIT 1";

    mysqli_query($mysqli,$sqla) or die("err2or --> rank='$clanrankchange', changenews=$changenews, changeranks=$changeranks");
	echo"<B>Clan properties updated.</b><BR>";
	}}}} }## HELPER UPDATE
	if($clanrankchange && $clanidchange>0 && $changeclanranks==1){
	 $clanrankchange=htmlentities(trim($clanrankchange));
	mysqli_query($mysqli,"UPDATE clans SET rank='$clanrankchange' WHERE ID='$clanidchange' && name='$clanname' LIMIT 1") or die("err2or --> ran");
	echo"<B>Clanrank updated.</b><BR>";
	}

	echo"Clan members:<table border=0><tr><td><td bgcolor=999999>Username<td bgcolor=999999>Clan rank";
	if($pw)
    {
        echo "<Td bgcolor=999999>Change clanrank<Td bgcolor=999999>News<Td bgcolor=999999>Ranks<Td bgcolor=999999>Forum mod<Td bgcolor=999999>Allies<Td bgcolor=999999>Kick
            <Td bgcolor=999999>Add stock<Td bgcolor=999999>Take stock<Td bgcolor=999999>Manage stock"; }
	$nr=1;
	  $sql = "SELECT ID, pw, username, rank, changenews, changeranks, changeforum, changeallies, kick, addStock, removeStock, manageStock FROM clans WHERE name='$clanname' ORDER BY pw desc, RANK ASC";
	   $resultaat = mysqli_query($mysqli,$sql);
	    while ($record = mysqli_fetch_object($resultaat)) { $ranker=stripslashes($record->rank);

	$onn=''; $timeout=time()-1800;
	  $sqla = "SELECT loggedin FROM stats WHERE username='$record->username' ";
	   $resultaaat = mysqli_query($mysqli,$sqla);
	    while ($rec = mysqli_fetch_object($resultaaat)) {

	      $sqlaa = "SELECT location,online FROM users WHERE username='$record->username' LIMIT 1";
	   $resultaaaat = mysqli_query($mysqli,$sqlaa);
	    while ($reco = mysqli_fetch_object($resultaaaat)) { $oni=$reco->online; $clanloc=$reco->location; }

	if($oni>0){$onn='<font color=green>';  $laston='';}else{ $onn='<font color=red>';  $laston="<BR>Last login ".(floor(($time-$rec->loggedin)/86400))." day(s) ago";;}
	}

		echo"<tr><Td>$nr<Td>$onn $record->username</font><BR><small>$clanloc$laston</small><td>$ranker";

	if($pw OR $changeclanranks){ ## ADMIN
    $ch1 = ($record->changenews == 1 ? "checked" : "");
    $ch2 = ($record->changeranks == 1 ? "checked" : "");
    $ch3 = ($record->changeforum == 1 ? "checked" : "");
    $ch4 = ($record->changeallies == 1 ? "checked" : "");
    $ch5 = ($record->kick== 1 ? "checked" : "");
    $ch6 = ($record->addStock == 1 ? "checked" : "");
    $ch7 = ($record->removeStock == 1 ? "checked" : "");
    $ch8 = ($record->manageStock == 1 ? "checked" : "");

	 echo"<td><form action='' method=post>
	 <input type=text name=clanrankchange value=\"$ranker\"><input type=hidden name=clanidchange value=$record->ID>";
	 if($record->pw=='' && $pw){
	 echo"<td align=center><input type=checkbox name=changenews value=1 $ch1>
	 <td align=center><input type=checkbox name=changeranks value=1 $ch2>
	 <td align=center><input type=checkbox name=changeforum value=1 $ch3>
	 <td align=center><input type=checkbox name=changeallies value=1 $ch4>
	 <td align=center><input type=checkbox name=kick value=1 $ch5>
	 <td align=center><input type=checkbox name=addStock value=1 $ch6>
	 <td align=center><input type=checkbox name=removeStock value=1 $ch7>
	 <td align=center><input type=checkbox name=manageStock value=1 $ch8>";

     } else{ echo"<td><td><td><td><td><td><td><td>"; }

	 echo"<td>
	 <input type=submit value=Edit></form></td></tr>";}


	$nr++;}
	echo"</table>";
}elseif($p=='forum'){ ## FORUM
include('clanforum.php');
}elseif($p=='options'){ ## OPTIONS

if($S_manageStock == 1)
{
    echo "<b>Stockhouses</b><br/><br/>";

    if(!$viewLogs)
    {
        if($approveID > 0 || $declineID > 0 || $cancelApprovalID > 0)
        {
            $sql = "SELECT CBR.*, CB.location FROM clanbuildingsrequests CBR JOIN clanbuildings CB ON CB.ID = CBR.clanbuildingID WHERE tag = '$clantag' AND CBR.ID = ";
            if($approveID > 0)
            {
                $sql .= $approveID . " AND CBR.approved = 0";
            }
            else if($declineID > 0)
            {
                $sql .= $declineID;
            }
            else if($cancelApprovalID > 0)
            {
                $sql .= $cancelApprovalID;
            }
            //echo "$sql<br/>";
            $resultset = mysqli_query($mysqli,$sql);
            if($itemRecord = mysqli_fetch_object($resultset))
            {
                $upg='';
                if($itemRecord->itemupgrade)
                {
                    $upg=" [$itemRecord->upgrademuch $itemRecord->itemupgrade]";
                }

                //Approve, decline or cancel an approval
                if($approveID > 0)
                {
                    if(is_numeric($approveAmount) && $approveAmount >= 1)
                    {
                        $approveAmount = ceil($approveAmount);
                        $sql = "UPDATE clanbuildingsrequests SET much = '$approveAmount', approved = 1 WHERE ID = $approveID";
                        mysqli_query($mysqli, $sql) or die("Stockhouse approval error, please report this bug");

                        echo "You have approved <b>$approveAmount $itemRecord->name$upg</b> for <b>$itemRecord->user</b> at <b>$itemRecord->location</b>.<br/><br/>";

                        $sql = "INSERT INTO clanbuildingslog (logtime, action, user, forUser, clanbuildingID, name, much, type, itemupgrade, upgrademuch)
                            VALUES (" . time() . ", 'approveRequest', '$S_user', '$itemRecord->user', $itemRecord->clanbuildingID, '$itemRecord->name', '$approveAmount', '$itemRecord->type', '$itemRecord->itemupgrade', '$itemRecord->upgrademuch')";
                        mysqli_query($mysqli,$sql) or die("error report this bug please approval log clanbuildingsitems msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

                        # ADD CLAN CHAT MESSAGE
                        /*$SystemMessage = 1;
                        $chatMessage = "$S_user has approved $itemRecord->much $itemRecord->name$upg for $itemRecord->user at $itemRecord->location";
                        $channel = 3;
                        include (GAMEPATH . "/scripts/chat/addchat.php");*/
                        mysqli_query($mysqli,"INSERT INTO messages (username, sendby, message, time, topic)
                            VALUES ('$itemRecord->user', '<B>$name</B>', '$S_user has approved $approveAmount $itemRecord->name$upg for you at $itemRecord->location', '" . time() . "', 'Item approval')") or die("DIE");
                    }
                    else
                    {
                        echo "\"$approveAmount\" is not a valid amount to approve<br/><br/>";
                    }
                }
                else
                {
                    $deleteRequestID = $declineID > 0 ? $declineID : $cancelApprovalID;
                    $sql = "DELETE FROM clanbuildingsrequests WHERE ID = $deleteRequestID";
                    mysqli_query($mysqli, $sql) or die("Stockhouse decline error, please report this bug");

                    echo "You have declined <b>$itemRecord->much $itemRecord->name$upg</b> for <b>$itemRecord->user</b> at <b>$itemRecord->location</b>.<br/><br/>";

                    $sql = "INSERT INTO clanbuildingslog (logtime, action, user, forUser, clanbuildingID, name, much, type, itemupgrade, upgrademuch)
                        VALUES (" . time() . ", 'declineRequest', '$S_user', '$itemRecord->user', $itemRecord->clanbuildingID, '$itemRecord->name', '$itemRecord->much', '$itemRecord->type', '$itemRecord->itemupgrade', '$itemRecord->upgrademuch')";
                    mysqli_query($mysqli,$sql) or die("error report this bug please approval log clanbuildingsitems msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

                    # ADD CLAN CHAT MESSAGE
                    /*$SystemMessage = 1;
                    $chatMessage = "$S_user has declined $itemRecord->much $itemRecord->name$upg for $itemRecord->user at $itemRecord->location!";
                    $channel = 3;
                    include (GAMEPATH . "/scripts/chat/addchat.php");*/
                    mysqli_query($mysqli,"INSERT INTO messages (username, sendby, message, time, topic)
                        VALUES ('$itemRecord->user', '<B>$name</B>', '$S_user has declined $approveAmount $itemRecord->name$upg for you at $itemRecord->location', '" . time() . "', 'Item approval')") or die("DIE");
                }
            }
            else
            {
                echo "Request could not be found" . ($approveID > 0 ? " (or someone else approved already)" : "") . "<br/><br/>";
            }
        }

        echo "<div style='margin-left: 50px; text-align: left;'>";

        $sql = "SELECT CBR.*, CB.location FROM clanbuildingsrequests CBR JOIN clanbuildings CB ON CB.ID = CBR.clanbuildingID WHERE tag = '$clantag'
            ORDER BY approved ASC, user ASC, name ASC, itemupgrade ASC, upgrademuch ASC";
        //echo "$sql<br/>";
        $resultset = mysqli_query($mysqli,$sql);
        if($itemRecord = mysqli_fetch_object($resultset))
        {
            $requestedItems = "";
            $numApproved = 0;

            $currentRequestingApproved = null;
            $currentRequestingUser = "";
            do
            {

                if($currentRequestingApproved == null || $itemRecord->approved != $currentRequestingApproved)
                {
                    if($currentRequestingUser != "")
                    {
                        $requestedItems .= "<br/><br/>";
                    }
                    $currentRequestingUser = "";
                    $currentRequestingApproved = $itemRecord->approved;

                    if($currentRequestingApproved)
                    {
                        $requestedItems .= "<script type=\"text/javascript\">
                            function toggleDiv(divID)
                            {
                            document.getElementById(divID).style.display = (document.getElementById(divID).style.display == 'none' ? 'block' : 'none');
                            return false;
                            }
                            </script>".
                            "<a id='approveToggle' href='' onclick=\"toggleDiv('approvedItems'); return false;\">Toggle approved items (numApproved)</a>".
                            "<div id='approvedItems' style='display: none;'><br/>";
                        $requestedItems .= "<b>Approved items:</b>";
                    }
                    else
                    {
                        $requestedItems .= "<b>Requested items:</b>";
                    }
                }

                if($currentRequestingApproved)
                {
                    $numApproved = $numApproved + 1;
                }

                if($itemRecord->user != $currentRequestingUser)
                {
                    $currentRequestingUser = $itemRecord->user;
                    $requestedItems .= "<br/><br/><b>$itemRecord->user " . ($currentRequestingApproved ? "has had the following requests approved" : "has requested the following items") . ":</b><br/>";
                }

                $upg='';
                if($itemRecord->itemupgrade)
                {
                    $upg=" [$itemRecord->upgrademuch $itemRecord->itemupgrade]";
                }

                $requestedItems .= "&nbsp;&nbsp;&nbsp;&nbsp;<form id='approve$itemRecord->ID' action='clan.php?p=options&approveID=$itemRecord->ID' method='post'>" .
                    ($currentRequestingApproved ? "<a href='clan.php?p=options&amp;cancelApprovalID=$itemRecord->ID' border=0>Cancel approval</a> &nbsp; " :
                    "<a href=\"javascript: document.getElementById('approve$itemRecord->ID').submit();\" border=0>Approve</a> &nbsp;" .
                    "<a href='clan.php?p=options&amp;declineID=$itemRecord->ID' border=0>Decline</a> &nbsp; ") .
                    "<b>" . ($currentRequestingApproved ? "$itemRecord->much" : "<input type='text' name='approveAmount' value='$itemRecord->much' size=4>") . " $itemRecord->name$upg</b> from <b>$itemRecord->location</b></form>";
            }while($itemRecord = mysqli_fetch_object($resultset));

            if($currentRequestingApproved)
            {
                $requestedItems .= "</div>";
            }
            $requestedItems .= "<br/><br/>";

            $requestedItems = str_replace("numApproved", $numApproved . " approved item" . ($numApproved == 1 ? "" : "s"), $requestedItems);

            echo "$requestedItems";
        }
    }

    $islands = array();
    $islands[19] = "Anasco";
    $islands[2] = "Dearn";
    $islands[6] = "Elven";
    $islands[17] = "Exrollia";
    $islands[15] = "Kanzo";
    $islands[4] = "Mezno";
    $islands[1] = "Remer";
    $islands[16] = "Serpenthelm";
    $islands[7] = "Skull";

    if($stockhouseID)
    {
        $sql = "SELECT * FROM clanbuildings WHERE ID = $stockhouseID AND tag = '$clantag'";
        //echo "$sql<br/>";
        $resultset = mysqli_query($mysqli,$sql);
        if($record = mysqli_fetch_object($resultset))
        {
            echo "$record->location stockhouse ($record->slotsUsed/$record->slots)<br/>There is " . number_format($record->gp) . " gp in this stockhouse.<br/><br/>";
            if($record->underConstruction)
            {
                echo "This stockhouse is currently under construction. Progress:<br/><br/>";
                $sql = "SELECT * FROM clanbuildingsresources WHERE clanbuildingID = $stockhouseID ORDER BY required DESC";
                //echo "$sql<br/>";
                $resultset = mysqli_query($mysqli,$sql);
                if($resources = mysqli_fetch_object($resultset))
                {
                    do
                    {
                        echo "$resources->resource (" . number_format($resources->added) . "/" . number_format($resources->required) . ")<br/>";
                    }while($resources = mysqli_fetch_object($resultset));
                }
            }
            else if($pw)
            {
                $newSlots = 0;
                $requiredResourceSQL = "";
                switch($record->slots)
                {
                    case 50000:
                        $newSlots = 100000;
                        $requiredResourceSQL = "INSERT INTO clanbuildingsresources (clanbuildingID, resource, required, added)
                            VALUES ('$record->ID', 'Wood', '20000', '0'),
                            ('$record->ID', 'Rocks', '1000', '0'),
                            ('$record->ID', 'Iron bars', '500', '0')";
                        break;

                    case 100000:
                        $newSlots = 150000;
                        $requiredResourceSQL = "INSERT INTO clanbuildingsresources (clanbuildingID, resource, required, added)
                            VALUES ('$record->ID', 'Wood', '20000', '0'),
                            ('$record->ID', 'Rocks', '1500', '0'),
                            ('$record->ID', 'Iron bars', '1000', '0')";
                        break;

                    case 150000:
                        $newSlots = 250000;
                        $requiredResourceSQL = "INSERT INTO clanbuildingsresources (clanbuildingID, resource, required, added)
                            VALUES ('$record->ID', 'Wood', '40000', '0'),
                            ('$record->ID', 'Rocks', '2000', '0'),
                            ('$record->ID', 'Steel bars', '2000', '0'),
                            ('$record->ID', 'Bat hide', '1000', '0')";
                        break;

                    case 250000:
                        $newSlots = 500000;
                        $requiredResourceSQL = "INSERT INTO clanbuildingsresources (clanbuildingID, resource, required, added)
                            VALUES ('$record->ID', 'Wood', '100000', '0'),
                            ('$record->ID', 'Rocks', '5000', '0'),
                            ('$record->ID', 'Steel bars', '10000', '0'),
                            ('$record->ID', 'Bat hide', '2000', '0')";
                        break;

                    case 500000:
                        $newSlots = 750000;
                        $requiredResourceSQL = "INSERT INTO clanbuildingsresources (clanbuildingID, resource, required, added)
                            VALUES ('$record->ID', 'Wood', '100000', '0'),
                            ('$record->ID', 'Rocks', '5000', '0'),
                            ('$record->ID', 'Silver bars', '10000', '0'),
                            ('$record->ID', 'Bat hide', '2000', '0')";
                        break;

                    case 750000:
                        $newSlots = 1000000;
                        $requiredResourceSQL = "INSERT INTO clanbuildingsresources (clanbuildingID, resource, required, added)
                            VALUES ('$record->ID', 'Wood', '100000', '0'),
                            ('$record->ID', 'Rocks', '5000', '0'),
                            ('$record->ID', 'Gold bars', '1000', '0'),
                            ('$record->ID', 'Bat hide', '2000', '0')";
                        break;
                }

                if($newSlots > 0)
                {
                    if($upgrade)
                    {
                        if($confirm)
                        {
                            if(hasGold($S_user) >= $newSlots)
                            {
                                if(payGoldNoEcho($S_user, $newSlots))
                                {
                                    $sql = "UPDATE clanbuildings SET underConstruction = true WHERE ID = $record->ID";
                                    mysqli_query($mysqli,$sql) or die("erroraa report this bug");

                                    mysqli_query($mysqli, $requiredResourceSQL) or die("Stockhouse requirement error, please report this bug");

                                    echo "You have bought land for stockhouse expansion at $record->location. Click <a href='clan.php?p=options&amp;stockhouseID=$record->ID'>here</a> to see the building progress.";

                                    # ADD CLAN CHAT MESSAGE
                                    $SystemMessage = 1;
                                    $chatMessage = "$S_user has bought some more land to improve our stockhouse at $record->location!";
                                    $channel = 3;
                                    include (GAMEPATH . "/scripts/chat/addchat.php");
                                }
                            }
                            else
                            {
                                echo "You don't have enough gold to buy land. Get some gold and <a href='clan.php?p=options&amp;stockhouseID=$record->ID&amp;upgrade=1&amp;confirm=1' border=0>try again</a>";
                            }
                        }
                        else
                        {
                            echo "Buying more land to allow stockhouse expansion will cost you " . number_format($newSlots) .
                                " gp.<br/>Your stockhouse can then be expanded to " . number_format($newSlots) . " slots.<br/>";
                            echo "Are you sure you want to buy more land at at $record->location?<br/><br/>";
                            echo "<a href='clan.php?p=options&amp;stockhouseID=$record->ID&amp;upgrade=1&amp;confirm=1' border=0>Yes, I want to buy land at $record->location</a>";
                        }
                    }
                    else
                    {
                        echo "Buying more land will allow your stockhouse to be expanded to " . number_format($newSlots) .
                            " slots will cost " . number_format($newSlots) . " gp. <a href='clan.php?p=options&amp;stockhouseID=$record->ID&amp;upgrade=1'>Upgrade</a>";
                    }
                }
                else
                {
                    echo "This stockhouse can't be upgraded at the moment.";
                }
            }
        }
        else
        {
            echo "There was a problem creating the stockhouse.";
        }
    }
    else if($map)
    {
        if($loc)
        {
            $sql = "SELECT ID FROM clanbuildings WHERE mapNumber = $map AND tag = '$clantag'";
            //echo "$sql<br/>";
            $resultset = mysqli_query($mysqli,$sql);
            if(mysqli_num_rows($resultset) == 0)
            {
                $sql = "SELECT locationID, mapNumber, locationName FROM locationinfo WHERE locationID = $loc ORDER BY locationName ASC";
                $resultset = mysqli_query($mysqli,$sql);
                //echo "$sql<br/>";
                if($record = mysqli_fetch_object($resultset))
                {
                    if($confirm)
                    {
                        if(hasGold($S_user) >= 50000)
                        {
                            if(payGoldNoEcho($S_user, 50000))
                            {
                                $sql = "INSERT INTO clanbuildings (tag, mapNumber, location, slots, slotsUsed, underConstruction)
                                    VALUES ('$clantag', '$map', '$record->locationName', '0', '0', true)";
                                mysqli_query($mysqli,$sql) or die("erroraa report this bug");

                                $sql = "SELECT ID, location FROM clanbuildings WHERE mapNumber = $map AND tag = '$clantag'";
                                //echo "$sql<br/>";
                                $resultset = mysqli_query($mysqli,$sql);
                                if($record = mysqli_fetch_object($resultset))
                                {
                                    $sql = "INSERT INTO clanbuildingsresources (clanbuildingID, resource, required, added)
                                        VALUES ('$record->ID', 'Wood', '20000', '0'), ('$record->ID', 'Rocks', '500', '0')";
                                    //echo "$sql<br/>";
                                    mysqli_query($mysqli,$sql) or die("Stockhouse requirement error, please report this bug");

                                    echo "You have bought land for a stockhouse at $record->location. Click <a href='clan.php?p=options&amp;stockhouseID=$record->ID'>here</a> to see the building progress.";

                                    $S_clanstockhouses[$record->location] = true;
                                    $_SESSION["S_clanstockhouses"] = $S_clanstockhouses;

                                    # ADD CLAN CHAT MESSAGE
                                    $SystemMessage = 1;
                                    $chatMessage = "$S_user has bought some land to build a new clan stockhouse at $record->location!";
                                    $channel = 3;
                                    include (GAMEPATH . "/scripts/chat/addchat.php");
                                }
                                else
                                {
                                    echo "There was a problem creating the stockhouse.";
                                }
                            }
                        }
                        else
                        {
                            echo "You don't have enough gold to buy land. Get some gold and <a href='clan.php?p=options&amp;map=$map&amp;loc=$record->locationID&amp;confirm=1' border=0>try again</a>";
                        }
                    }
                    else
                    {
                        echo "Buying land for a new stockhouse will cost you 50,000 gp.<br/>";
                        echo "Are you sure you want to build a new stock house at $record->locationName on $islands[$map]?<br/><br/>";
                        echo "<a href='clan.php?p=options&amp;map=$map&amp;loc=$record->locationID&amp;confirm=1' border=0>Yes, I want to buy land at $record->locationName</a>";
                    }
                }
            }
            else
            {
                echo "You already have stockhouse on $islands[$map]";
            }
        }
        else
        {
            $sql = "SELECT locationID, locationName FROM locationinfo WHERE mapNumber = $map" . ($map == 17 ? " AND locationName = 'Pensax'" : "") . " ORDER BY locationName ASC";
            $resultset = mysqli_query($mysqli,$sql);
            if($record = mysqli_fetch_object($resultset))
            {
                echo "Select location on $islands[$map] to build a new stockhouse:<br/><br/>";

                do
                {
                    echo "<a href='clan.php?p=options&amp;map=$map&amp;loc=$record->locationID' border=0>$record->locationName</a><br/>";
                }while($record = mysqli_fetch_object($resultset));
            }
        }
    }
    else
    {
        $sql = "SELECT * FROM clanbuildings WHERE tag='$clantag' ORDER BY location ASC";
        $resultset = mysqli_query($mysqli,$sql);
        if($record = mysqli_fetch_object($resultset))
        {
            if(!$viewLogs)
            {
                echo "<b>$clanname [$clantag] stockhouses:</b><br/><br/>";
            }

            $stockhouseDropdown = "<option value=''>All stockhouses</option>";
            do
            {
                $stockhouseDropdown .= "<option value='$record->ID'" . ($filterStockhouseID == $record->ID ? " selected='selected'" : "") . ">$record->location</option>";

                if(!$viewLogs)
                {
                    echo "<a href='clan.php?p=options&amp;stockhouseID=$record->ID'>$record->location ($record->slotsUsed/$record->slots)</a>
                        (<a href='clan.php?p=options&amp;viewLogs=1&amp;filterStockhouseID=$record->ID'>View logs</a>)<br/>";
                }
                unset($islands[$record->mapNumber]);
            }while($record = mysqli_fetch_object($resultset));

            if(!$viewLogs)
            {
                echo "<br/><br/>";
            }

            if($viewLogs)
            {
                echo "<form action='clan.php?p=options&amp;viewLogs=1' method='post'>";

                echo "<select name='filterStockhouseID'>$stockhouseDropdown</select> &nbsp;
                    Person: <input type='text' name='filterUsername' value='$filterUsername' size=15> &nbsp;
                    Item: <select name='filterMatch'>
                    <option value='1'" . ($filterMatch == 1 ? " selected='selected'" : "") . ">Starts</option>
                    <option value='2'" . ($filterMatch == 2 ? " selected='selected'" : "") . ">Equals</option>
                    <option value='3'" . ($filterMatch == 3 ? " selected='selected'" : "") . ">Contains</option>
                    </select>
                    <input type='text' name='filterItem' value='$filterItem' size=15> &nbsp;
                    Action: <select name='filterType'>
                    <option value=''>All</option>
                    <option value='1'" . ($filterType == 1 ? " selected='selected'" : "") . ">Add item</option>
                    <option value='2'" . ($filterType == 2 ? " selected='selected'" : "") . ">Remove item</option>
                    <option value='6'" . ($filterType == 5 ? " selected='selected'" : "") . ">Add gp</option>
                    <option value='7'" . ($filterType == 5 ? " selected='selected'" : "") . ">Remove gp</option>" .
                    //"<option value='3'" . ($filterType == 3 ? " selected='selected'" : "") . ">Request</option>" .
                    "<option value='4'" . ($filterType == 4 ? " selected='selected'" : "") . ">Approve</option>
                    <option value='5'" . ($filterType == 5 ? " selected='selected'" : "") . ">Decline</option>
                    </select><input type=submit class='button' value='Search'>";

                echo "</form>";

                $filters = " AND action != 'requestItem'";
                $urlCriteria = "";
                if($filterStockhouseID)
                {
                    $filters .= " AND clanbuildingID = '$filterStockhouseID'";
                    $urlCriteria .= "&amp;filterStockhouseID=$filterStockhouseID";
                }

                if($filterUsername)
                {
                    $filters .= " AND user = '$filterUsername'";
                    $urlCriteria .= "&amp;filterUsername=$filterUsername";
                }

                if($filterItem)
                {
                    if(strtolower($filterItem) == "gp")
                    {
                        $filterItem = "Gold pieces";
                    }

                    switch($filterMatch)
                    {
                        case 2:
                            $urlCriteria .= "&amp;filterMatch=$filterMatch";
                            $filters .= " AND name = '$filterItem'";
                            break;

                        case 3:
                            $urlCriteria .= "&amp;filterMatch=$filterMatch";
                            $filters .= " AND name LIKE '%$filterItem%'";
                            break;

                        default:
                            $filters .= " AND name LIKE '$filterItem%'";
                            break;
                    }

                    $urlCriteria .= "&amp;filterItem=$filterItem";
                }

                if($filterType)
                {
                    switch($filterType)
                    {
                        case 1:
                            $typeSQL = "addItem";
                            break;

                        case 2:
                            $typeSQL = "removeItem";
                            break;

                        /*case 3:
                            $typeSQL = "requestItem";
                            break;*/

                        case 4:
                            $typeSQL = "approveRequest";
                            break;

                        case 5:
                            $typeSQL = "declineRequest";
                            break;

                        case 6:
                            $typeSQL = "addGP";
                            break;

                        case 7:
                            $typeSQL = "removeGP";
                            break;
                    }

                    if($typeSQL)
                    {
                        $filters .= " AND action = '$typeSQL'";
                        $urlCriteria .= "&amp;filterType=$filterType";
                    }
                }

                if($filterItem)
                {
                    if(strtolower($filterItem) == "gold pieces" || strtolower($filterItem) == "gp")
                    {
                        $sql = "SELECT location, gp FROM clanbuildings WHERE tag = '$clantag' ORDER BY location ASC";
                        //echo "$sql<br/><br/>";

                        $resultset = mysqli_query($mysqli,$sql);
                        if($record = mysqli_fetch_object($resultset))
                        {
                            do
                            {
                                echo number_format($record->gp) . " gp at $record->location<br/>";
                            }while($record = mysqli_fetch_object($resultset));
                        }
                        else
                        {
                            echo "No $filterItem in the stockhouses.<br/><br/>";
                        }
                    }
                    else
                    {
                        switch($filterMatch)
                        {
                            case 2:
                                $itemFilters .= " AND name = '$filterItem'";
                                break;

                            case 3:
                                $itemFilters .= " AND name LIKE '%$filterItem%'";
                                break;

                            default:
                                $itemFilters .= " AND name LIKE '$filterItem%'";
                                break;
                        }

                        if($filterStockhouseID)
                        {
                            $itemFilters .= " AND clanbuildingID = '$filterStockhouseID'";
                        }

                        $sql = "SELECT CBI.*, CB.location FROM clanbuildingsitems CBI JOIN clanbuildings CB ON CB.ID = CBI.clanbuildingID WHERE tag = '$clantag'$itemFilters ORDER BY location ASC, name ASC, itemupgrade ASC, upgrademuch ASC";
                        //echo "$sql<br/><br/>";

                        $resultset = mysqli_query($mysqli,$sql);
                        if($record = mysqli_fetch_object($resultset))
                        {
                            do
                            {
                                $upg='';
                                if($record->itemupgrade)
                                {
                                    $upg=" [$record->upgrademuch $record->itemupgrade]";
                                }

                                echo "$record->much $record->name$upg at $record->location<br/>";
                            }while($record = mysqli_fetch_object($resultset));
                        }
                        else
                        {
                            echo "No $filterItem in the stockhouses.<br/><br/>";
                        }
                    }
                }

                $selectSQL = "COUNT(CBL.ID) AS totalItems";
                $sql = "SELECT $selectSQL FROM clanbuildingslog CBL JOIN clanbuildings CB ON CB.ID = CBL.clanbuildingID WHERE tag = '$clantag'$filters ORDER BY logtime DESC";
                //echo "$sql<br/><br/>";

                $totalItems = 0;
                $resultset = mysqli_query($mysqli,$sql);
                if($record = mysqli_fetch_object($resultset))
                {
                    $totalItems = $record->totalItems;
                }

                if($totalItems > 0)
                {
                    $paginationControls = "";
                    if(!$startAt)
                    {
                        $startAt = 0;
                    }
                    $maxPerPage = 50;
                    $count = 0;
                    $totalPages = 0;
                    $currentPage = 0;
                    $count = $totalItems;

                    while($count > 0)
                    {
                        $totalPages++;
                        $count -= $maxPerPage;
                    }
                    if($totalPages > 1)
                    {
                        if($startAt > $totalPages * $maxPerPage)
                        {
                            $startAt = ($startAt - $maxPerPage);
                            if($startAt < 0)
                            {
                                $startAt = 0;
                            }
                        }
                        if($startAt > $maxPerPage - 1)
                        {
                            $paginationControls .= "<a href='clan.php?p=options&amp;viewLogs=1$urlCriteria&amp;startAt=" . ($startAt - $maxPerPage) . "'> &lt; </a> &nbsp; ";
                        }
                        $currentPage = ($startAt + $maxPerPage) / $maxPerPage;

                        for($i = 1; $i <= $totalPages; $i++)
                        {
                            if($i == $currentPage)
                            {
                                $paginationControls .= "<b>$i</b> &nbsp; ";
                            }
                            else if($i <= 5 || ($i >= $currentPage - 2 && $i <= $currentPage + 2) || i > $totalPages - 5 || $totalPages <= 20)
                            {
                                $paginationControls .= "<a href='clan.php?p=options&amp;viewLogs=1$urlCriteria&amp;startAt=" . ($i * $maxPerPage - ($maxPerPage)) . "$urlCriteria'>$i</a> &nbsp; ";
                            }
                            else if($i == 6 || $i == $totalPages - 5 && $totalPages - 5 > 13 && strpos($paginationControls, " ... ", strlen($paginationControls) - 5) === 0)
                            {
                                $paginationControls .= " ... ";
                            }
                        }
                        if($startAt < $totalPages * $maxPerPage - $maxPerPage)
                        {
                            $paginationControls .= "<a href='clan.php?p=options&amp;viewLogs=1$urlCriteria&amp;startAt=" . ($startAt + $maxPerPage) . "'> &gt; </a>";
                        }
                    }
                    if($totalPages > 1)
                    {
                        $paginationControls .= "<br />";
                    }
                    else
                    {
                        $paginationControls = "";
                    }

                    echo "$paginationControls";

                    $selectSQL = "CBL.*, CB.location";
                    $sql = "SELECT $selectSQL FROM clanbuildingslog CBL JOIN clanbuildings CB ON CB.ID = CBL.clanbuildingID WHERE tag = '$clantag'$filters ORDER BY logtime DESC LIMIT $startAt, $maxPerPage";
                    //echo "$sql<br/><br/>";

                    $resultset = mysqli_query($mysqli,$sql);
                    if($record = mysqli_fetch_object($resultset))
                    {
                        echo "<br/><table class='stockhouseLog'><tr>
                            <th>Date</th>
                            <th>Player</th>
                            <th>Action</th>
                            <th>Location</th>
                            <th>Amount</th>
                            <th>Item</th>
                            <th></th>
                            </tr>";
                        do
                        {
                            $action = "";
                            switch($record->action)
                            {
                                case "addItem":
                                    $action = "Added";
                                    break;

                                case "removeItem":
                                    $action = "Removed";
                                    break;

                                case "requestItem":
                                    $action = "Requested";
                                    break;

                                case "approveRequest":
                                    $action = "Approved";
                                    break;

                                case "declineRequest":
                                    $action = "Declined";
                                    break;

                                case "addGP":
                                    $action = "Added gp";
                                    break;

                                case "removeGP":
                                    $action = "Removed GP";
                                    break;

                                case "requestGP":
                                    $action = "Requested gp";
                                    break;
                            }

                            $upg='';
                            if($record->itemupgrade)
                            {
                                $upg=" [$record->upgrademuch $record->itemupgrade]";
                            }

                            $for="";
                            if($record->forUser)
                            {
                                $for = "for $record->forUser";
                            }

                            echo "<tr>
                                <td>" . date("Y-m-d H:i:s", $record->logtime) . "</td>
                                <td>$record->user</td>
                                <td>$action</td>
                                <td>$record->location</td>
                                <td>$record->much</td>
                                <td>$record->name$upg</td>
                                <td>$for</td>
                                </tr>";
                        }while($record = mysqli_fetch_object($resultset));
                        echo "</table><br/><br/>";
                    }

                    echo "$paginationControls";
                }
                else
                {
                    echo "No logs matched your search.";
                }
            }
            else
            {
                echo "<a href='clan.php?p=options&amp;viewLogs=1'>View all logs</a>";
            }
        }
        else
        {
            echo "$clanname [$clantag] currently have no stockhouses.";
        }

        if($pw && !$viewLogs)
        {
            echo "<br/><br/>Islands available for a new stockhouse:<br/><br/>";

            foreach($islands as $key => $value)
            {
                echo "<a href='clan.php?p=options&amp;map=$key' border=0>$value</a><br/>";
            }
        }
    }

    echo "</div><hr/>";
}


if(!$viewLogs)
{
if($pw OR $changeclannews==1)
{
    echo"<b>Clan news</b><BR>";
    if($clanaddnews){
    $clanaddnews=htmlentities(trim($clanaddnews));
    $clanaddtitle=htmlentities(trim($clanaddtitle));
    $clanaddnews = nl2br($clanaddnews);
         $sqll = "INSERT INTO clannews (datum, username, clan, text, title)
             VALUES ('$datum', '$S_user', '$clanname', '$clanaddnews', '$clanaddtitle')";
          mysqli_query($mysqli,$sqll) or die("erroraa report this bug");
    echo"Clan news added!<BR>";
    }
    echo"<form action='' method=post><table><tr valign=top><td>News title<td><input type=text name=clanaddtitle><tr valign=top><td>News item<Td><textarea name=clanaddnews rows=6 cols=50></textarea><tr><td><Td><input type=submit value=Add></table></form><HR>";
    }

    if($pw OR $canchangeallies)
    {
        if($editallies){
            $sqll = "UPDATE clans SET alliedclans = '" . $editalliedclans . "', alliedplayers = '" . $editalliedplayers . "' WHERE name = '$clanname';";
            mysqli_query($mysqli,$sqll) or die("error updating allies report this bug");
            echo"Clan allies updated!<BR>";

            $alliedclans = $editalliedclans;
            $alliedplayers = $editalliedplayers;

            $S_clanalliedclans = strtolower($alliedclans);
            $_SESSION["S_clanalliedclans"]= $S_clanalliedclans;

            $S_clanalliedplayers = strtolower($alliedplayers);
            $_SESSION["S_clanalliedplayers"]= $S_clanalliedplayers;

            //Update the allies for clan + player
            $S_alliedclans = explode(",", $_SESSION["S_playeralliedclans"] . (strlen($_SESSION["S_playeralliedclans"]) > 0 ? "," : "") . $S_clanalliedclans);
            $_SESSION["S_alliedclans"]= $S_alliedclans;

            $S_alliedplayers = explode(",", $_SESSION["S_playeralliedplayers"] . (strlen($_SESSION["S_playeralliedplayers"]) > 0 ? "," : "") . $S_clanalliedplayers);
            $_SESSION["S_alliedplayers"]= $S_alliedplayers;
        }
        echo"<form action='' method=post><input type=hidden name=editallies value=1>
            <table>
            <tr valign=top><td colspan='2'>Enter clan tags or player names separated by a ,</td></tr>
            <tr valign=top><td>Clan tags</td><td><textarea name=editalliedclans rows=3 cols=50>$alliedclans</textarea></td></tr>
            <tr valign=top><td>Players</td><td><textarea name=editalliedplayers rows=3 cols=50>$alliedplayers</textarea></td></tr>
        <tr><td></td><td><input type=submit value=Update></td></tr></table></form><HR>";
    }

    if($pw==''){
    if($leave){
        if($ok==2){
          $sql = "SELECT username FROM clans WHERE pw<>'' && name='$clanname' LIMIT 1";
           $resultaat = mysqli_query($mysqli,$sql);
            while ($record = mysqli_fetch_object($resultaat)) { $clanadmin=$record->username; }

        $mess="$S_user has left your clan.";
        $sql = "INSERT INTO messages (username, sendby, message, time, topic)
          VALUES ('$clanadmin', '<B>Syrnia</B>', '$mess ', '$time', 'Clan')";
        mysqli_query($mysqli,$sql) or die("error report this bug please33 66 msg");

        # ADD CLAN CHAT MESSAGE
        $SystemMessage = 1;
        $chatMessage = "$S_user has left the clan";
        $channel = 3;
        include (GAMEPATH . "/scripts/chat/addchat.php");
        ### EINDE CLAN CHAT MESSAGE

          $sql = "DELETE FROM clans WHERE username='$S_user'";
          mysqli_query($mysqli,$sql) or die("error report this bug please 1 MESSAGE ");
          $S_clantag='';

        echo"You have left the clan.<BR>
        <a href=clan.php>Click here to continue.</a><BR><BR>";
        }else{
          echo"Are you sure? <a href=clan.php?p=options&leave=igotenoughofthisclan&ok=2>Yes i want to leave this clan.</a><BR>";
        }
    }else{ # leave
        echo"<a href=clan.php?p=options&leave=igotenoughofthisclan>Leave this clan</a>";
    }

    } else { # pw
    if($leave){
    if($ok==4){
          $sql = "DELETE FROM clans WHERE name='$clanname'";
          mysqli_query($mysqli,$sql) or die("error report this bug please2MESSAGE");
          $sql = "DELETE FROM forummessages WHERE clan='$clanname'";
          mysqli_query($mysqli,$sql) or die("error report this bug please3MESSAGE");
          $sql = "DELETE FROM forumtopics WHERE clan='$clanname'";
          mysqli_query($mysqli,$sql) or die("error report this bug please4MESSAGE");
          $sql = "DELETE FROM forumcats WHERE clan='$clanname'";
          mysqli_query($mysqli,$sql) or die("error report this bug please5MESSAGE");
          $sql = "DELETE FROM clannews WHERE clan='$clanname'";
          mysqli_query($mysqli,$sql) or die("error report this bug please6MESSAGE");
          $sql = "DELETE FROM clanbuildingsitems WHERE clanbuildingID IN (SELECT ID FROM clanbuildings WHERE tag = '$clantag')";
          mysqli_query($mysqli,$sql) or die("error report this bug please7MESSAGE");
          $sql = "DELETE FROM clanbuildingslog WHERE clanbuildingID IN (SELECT ID FROM clanbuildings WHERE tag = '$clantag')";
          mysqli_query($mysqli,$sql) or die("error report this bug please8MESSAGE");
          $sql = "DELETE FROM clanbuildingsrequests WHERE clanbuildingID IN (SELECT ID FROM clanbuildings WHERE tag = '$clantag')";
          mysqli_query($mysqli,$sql) or die("error report this bug please9MESSAGE");
          $sql = "DELETE FROM clanbuildingsresources WHERE clanbuildingID IN (SELECT ID FROM clanbuildings WHERE tag = '$clantag')";
          mysqli_query($mysqli,$sql) or die("error report this bug please10MESSAGE");
          $sql = "DELETE FROM clanbuildings WHERE tag = '$clantag'";
          mysqli_query($mysqli,$sql) or die("error report this bug please11MESSAGE");
    $S_clantag='';
    echo"You have deleted the clan.<BR>
    <a href=clan.php>Click here to continue.</a><BR><BR>";
    }else{ echo"Are you sure? <a href=clan.php?p=options&leave=igotenoughofthisclan&ok=4>Yes I want to DELETE this clan.</a><BR>";}
    }else{ # leave
    echo"<a href=clan.php?p=options&leave=igotenoughofthisclan>Delete this clan (clan members will be removed too, as well as stockhouses)</a>";
    }
    } # Clanleader
}

} elseif($p=='admin' && ($pw || $canKick)){ ###### ADMIN

    if($pw)
    {
        echo"<B>Clan name</b><BR>";
        if(strlen($clannamechange)>=5){
            $clannamechange=substr($clannamechange, 0, 40);

            $clannamechange=htmlentities(trim($clannamechange));
            $test=$clannamechange;
            $pos1 = stristr ($test, "'");
            $pos2 = stristr ($test, '"');
            $pos3 = stristr ($test, ">");
            $pos4 = stristr ($test, ":");
            $pos5 = stristr ($test, ";");
            $pos6 = stristr ($test, "&");
            $pos7 = stristr ($test, "<");
            if($pos1 OR $pos2 OR $pos3 OR $pos4 OR $pos5 OR  $pos6 OR $pos7 OR stristr ($test, "\\") OR  stristr ($test, "/") OR $clannamechange<>(htmlentities(trim($clannamechange)))  ){
                echo "<b>Your clan name may not contain illegal characters such as: \" ' < > : ; & </b><BR>";
            }else{
            $pos1 = stristr ($clannamechange, "M2H");
            $pos2 = stristr ($clannamechange, "Admin");
            $pos3 = stristr ($clannamechange, "Crew");
            $pos4 = stristr ($clannamechange, "moderator");
            if($pos1 === false && $pos2 === false && $pos3 === false && $pos4 === false){
            $sql = "SELECT name FROM clans WHERE name='$clannamechange'";
            $resultaat = mysqli_query($mysqli,$sql);
            $aantaluser = mysqli_num_rows($resultaat);
            if ($aantaluser == 0 && strlen($clannamechange)>=5) {
                mysqli_query($mysqli,"UPDATE clans SET name='$clannamechange' WHERE name='$clanname'") or die("err2or --> 1");
                mysqli_query($mysqli,"UPDATE clannews SET clan='$clannamechange' WHERE clan='$clanname'") or die("err2or --> 1");
                mysqli_query($mysqli,"UPDATE forumcats SET clan='$clannamechange' WHERE clan='$clanname'") or die("err2or --> 1");
                mysqli_query($mysqli,"UPDATE forummessages SET clan='$clannamechange' WHERE clan='$clanname'") or die("err2or --> 1");
                mysqli_query($mysqli,"UPDATE forumtopics SET clan='$clannamechange' WHERE clan='$clanname'") or die("err2or --> 1");
                echo"Clan name changed!<BR>"; $name=$clannamechange;
            } else { echo"That clan name has already been taken.<BR>"; }
            }
            }
        }
        echo"<form action='' method=post><input type=text name=clannamechange value=\"$name\"><input type=submit value=Edit></form>";

        echo"<hr><B>Clan tag</b><BR>";
        if($clantagchange){
        $clantagchange=substr($clantagchange, 0, 5);
        $clantagchange=htmlentities(trim($clantagchange));
        $test=$clantagchange;
        $pos1 = stristr ($test, "'");
        $pos2 = stristr ($test, '"');
        $pos3 = stristr ($test, ">");
        $pos4 = stristr ($test, ":");
        $pos5 = stristr ($test, ";");
        $pos6 = stristr ($test, "&");
        $pos7 = stristr ($test, "<");
        if($pos1 OR $pos2 OR $pos3 OR $pos4 OR $pos5 OR  $pos6 OR $pos7 OR stristr ($test, "\\") OR  stristr ($test, "/") OR strlen($clantagchange>5) && strlen($clantagchange<=1) OR $clantagchange<>(htmlentities(trim($clantagchange)))  ){ echo "<b>Your clan tag may not contain illegal characters as: \" ' < > : ; & <BR>
        And you clan tag should be shorter than 6 characters.</b><BR>";
        }else{
        $pos1 = stristr ($clantagchange, "M2H");
        $pos2 = stristr ($clantagchange, "Admin");
        $pos3 = stristr ($clantagchange, "Crew");
        if($pos1 === false && $pos2 === false && $pos3 === false){

        $sql = "SELECT tag FROM clans WHERE tag='$clantagchange'";
        $resultaat = mysqli_query($mysqli,$sql);
        $aantaluser = mysqli_num_rows($resultaat);
        if ($aantaluser == 0) {
        mysqli_query($mysqli,"UPDATE clans SET tag='$clantagchange' WHERE name='$clanname'") or die("err2or --> 1");
        mysqli_query($mysqli,"UPDATE clanbuildings SET tag='$clantagchange' WHERE tag='$clantag'") or die("err2or --> 1");
        echo"Clan tag changed!<BR>"; $tag=$clantagchange;
        }else{ echo"That clan tag is already taken.<BR>"; }
        }
        }
        }
        echo"<form action='' method=post><input type=text name=clantagchange value=\"$tag\"><input type=submit value=Edit></form>";



        echo"<hr><B>Clan password</b><BR>";
        if($clanPWchange && $clanPWchange==htmlentities(trim($clanPWchange))){
            $clanPWchange=htmlentities(trim($clanPWchange));

            if(strlen($clanPWchange)<4 OR stristr ($clanPWchange, "\\") OR  stristr ($clanPWchange, "/") ){
            echo "<b>Your clan PW must be at least 4 characters.</b><BR>";
            }else{
            mysqli_query($mysqli,"UPDATE clans SET pw='$clanPWchange' WHERE username='$S_user' && name='$clanname' LIMIT 1") or die("X err2or --> 1");
            echo"Clan password updated!<BR>";
            }
        }
        echo"<form action='' method=post><input type=password name=clanPWchange value=\"XXXXX\"><input type=submit value=Edit></form>";
    }

    if($pw || $canKick)
    {
        echo"<hr><B>Kick a member</b><BR>";
        if($kick){

        $sql = "SELECT username FROM clans WHERE ID='$kick' LIMIT 1";
        $resultaat = mysqli_query($mysqli,$sql);
            while ($record = mysqli_fetch_object($resultaat)) { $clankick=$record->username; }
            $mess="The clanleader of $name has kicked you out of the clan.";
            $sql = "INSERT INTO messages (username, sendby, message, time, topic)
            VALUES ('$clankick', '<B>Syrnia</B>', '$mess ', '$time', 'Clan')";
            mysqli_query($mysqli,$sql) or die("error report this bug please33 66 msg");

            $sql = "DELETE FROM clans WHERE ID='$kick' && username<>'$S_user' && name='$clanname'";
                mysqli_query($mysqli,$sql) or die("error report this bug please7MESSAGE");
            echo"Kicked!<BR>";

            # ADD CLAN CHAT MESSAGE
            $SystemMessage = 1;
            $chatMessage = "$clankick has been kicked from the clan";
            $channel = 3;
            include (GAMEPATH . "/scripts/chat/addchat.php");
            ### EINDE CLAN CHAT MESSAGE
        }
        echo"<form action='' method=post><select name=kick>";
        $sql = "SELECT ID,username FROM clans WHERE name='$clanname' && username<>'$S_user' && pw = '' ORDER BY username asc ";
        $resultaat = mysqli_query($mysqli,$sql);
            while ($record = mysqli_fetch_object($resultaat)) { $namee=stripslashes($record->username);  echo"<option value=\"$record->ID\">$namee"; }
        echo"</select><input type=submit value=Kick></form>";
    }

    if($pw)
    {
        echo"<hr><B>Give clanleadership to another member</b><BR>";
        if($SURE){
        if($giveover){
            $clankick='';
            $sql = "SELECT username FROM clans WHERE ID='$giveover' && name='$clanname' LIMIT 1";
            $resultaat = mysqli_query($mysqli,$sql);
            while ($record = mysqli_fetch_object($resultaat)) { $clankick=$record->username; }
            if($clankick){
                echo"<BR>You gave clanleadership to $clankick.<BR><a href=clan.php>Click here to continue</a><BR><BR>";
                mysqli_query($mysqli,"UPDATE clans SET pw='' WHERE username='$S_user' LIMIT 1") or die("err2or --> 1");
                mysqli_query($mysqli,"UPDATE clans SET pw='$clanpw' WHERE username='$clankick' LIMIT 1") or die("err2or --> 1");

                $mess="You have gained clanleadership of the $name clan. $S_user has stopped as clanleader, you took over their place.";
                $sql = "INSERT INTO messages (username, sendby, message, time, topic)
                    VALUES ('$clankick', '<B>Syrnia</B>', '$mess ', '$time', 'Clan')";
                mysqli_query($mysqli,$sql) or die("error report this bug please33 66 msg");
            }
        }else{
        echo"<form action='' method=post><input type=hidden name=SURE value=yes><select name=giveover>";
            $sql = "SELECT ID,username FROM clans WHERE name='$clanname' && username<>'$S_user' ORDER BY username asc ";
            $resultaat = mysqli_query($mysqli,$sql);
            while ($record = mysqli_fetch_object($resultaat)) { $namee=stripslashes($record->username);  echo"<option value=\"$record->ID\">$namee"; }
            echo"</select><input type=submit value=Ok></form>";

        }
        }else{
        echo"<a href=clan.php?p=admin&SURE=yes>Pass clan leadership to someone else</a>";
        }
    }





} else {
if($pw && $delpost>0 OR $changeclannews==1 && $delpost>0 ){
     $sql = "DELETE FROM clannews WHERE ID='$delpost' && clan='$clanname'";
      mysqli_query($mysqli,$sql) or die("error report this bug pleaNEWS");
}
$lastid=1;
  $sql = "SELECT ID, title, text, datum, username FROM clannews WHERE clan='$clanname' ORDER BY ID desc LIMIT 500";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat)) { $poster=$record->username; $lastid=$record->ID; $title=stripslashes($record->title); $text=stripslashes($record->text);
echo"<Table bgcolor=666666 border=1 width=90%>
<tr><Td>";
if($pw OR $changeclannews==1){ echo"<a href=clan.php?delpost=$record->ID>Delete</a>"; }
echo"$record->datum <B>$title</b> by <i>$poster</i><hr> $text </table>"; }

      $sql = "DELETE FROM clannews WHERE ID<$lastid && clan='$clanname'";
      mysqli_query($mysqli,$sql) or die("error report");


}


} else { ############## NO CLAN
if($_POST['newclan']=='yes'){ # NEW CLAN

$pos1 = strpos ($clantag, "M2H");
$pos2 = strpos ($clantag, "Admin");
$pos3 = strpos ($clantag, "Crew");
if($pos1 === false && $pos2 === false && $pos3 === false){

    $resultaat = mysqli_query($mysqli,"SELECT name FROM clans WHERE name='$clanname'");
   $aantalclans = mysqli_num_rows($resultaat);

    $resultaat = mysqli_query($mysqli,"SELECT tag FROM clans WHERE tag='$clantag'");
   $aantaltag = mysqli_num_rows($resultaat);

if ($aantalclans>0) {
$uitvoer = "Sorry the clan name $clanfull has already been taken.<BR>";
} else {
$clanfullen =strlen($clanname);
$clanlen =strlen($clantag);
$clanpw='wot';
$clanpwlen =strlen($clanpw);
$clanfullen=htmlentities(trim($clanfullen));
$clanlen=htmlentities(trim($clanlen));
$test=$clanname;
$pos1 = stristr ($test, "'");
$pos2 = stristr ($test, '"');
$pos3 = stristr ($test, ">");
$pos4 = stristr ($test, ":");
$pos5 = stristr ($test, ";");
$pos6 = stristr ($test, "&");
$pos7 = stristr ($test, "<");

$test=$clantag;
$pos12 = stristr ($test, "'");
$pos22 = stristr ($test, '"');
$pos32 = stristr ($test, ">");
$pos42 = stristr ($test, ":");
$pos52 = stristr ($test, ";");
$pos62 = stristr ($test, "&");
$pos72 = stristr ($test, "<");

$test=$clanpw;
$pos13 = stristr ($test, "'");
$pos23 = stristr ($test, '"');
$pos33 = stristr ($test, ">");
$pos43 = stristr ($test, ":");
$pos53 = stristr ($test, ";");
$pos63 = stristr ($test, "&");
$pos73 = stristr ($test, "<");

if ($clanfullen<3) { $uitvoer = "<b>Sorry your clan name must contain at least 3 characters.</b><BR><BR>"; }
elseif($aantaltag>0){ $uitvoer = "<b>Sorry your clan tag has already been taken</b><BR><BR>";}
elseif ($clanlen < 2) { $uitvoer = "<b>Sorry your clan short tag must contain at least 2 characters.</b><BR><BR>"; }
elseif ($clanpwlen < 3) { $uitvoer = "<b>Sorry your clan password must contain at least 3 characters. ($clanpw) </b><BR><BR>"; }
elseif($pos1 OR $pos2 OR $pos3 OR $pos4 OR $pos5 OR  $pos6 OR $pos7 OR $clanname<>(htmlentities(trim($clanname))) OR stristr ($clanname, "\\") OR  stristr ($clanname, "/") ){ $uitvoer = "<b>Your clan name may not contain illegal characters such as: \" ' < > : ; & </b><BR><BR>"; }
elseif($pos12 OR $pos22 OR $pos32 OR $pos42 OR $pos52 OR  $pos62 OR $pos72  OR $clantag<>(htmlentities(trim($clantag))) OR stristr ($clantag, "\\") OR  stristr ($clantag, "/") ){ $uitvoer = "<b>Your clan tag may not contain illegal characters such as: \" ' < > : ; & </b><BR><BR>"; }
elseif($pos13 OR $pos23 OR $pos33 OR $pos43 OR $pos53 OR  $pos63 OR $pos73  OR $clanpw<>(htmlentities(trim($clanpw)))  OR stristr ($clanpw, "\\") OR  stristr ($clanpw, "/") ) { $uitvoer = "<b>Your clan password may not contain illegal characters such as: \" ' < > : ; & </b><BR><BR>"; }
else { $uitvoer="OK"; }

if ($uitvoer == "OK" && strlen($clanname)>=5){
     $sqll = "INSERT INTO clans (username, name, tag, rank, pw, alliedclans, alliedplayers)
         VALUES ('$S_user', '$clanname', '$clantag', 'Clanleader', '$clanpw', '', '')";
      mysqli_query($mysqli,$sqll) or die("erroraa report this bug");
	$new='no';
	echo "<b><CENTER><BR><BR>Your clan $clan has been created!</b><BR><a href=clan.php>Click here to continue</a><BR>";
}else{
	$uitvoer="The clans name must be at least 5 characters long and cannot contain illegal characters such as: \" ' < > : ; & .<br />";
}
}
}else { echo"<B>Your clan name or tag may not contain any misleading content as 'M2H, Admin' etc.</b><BR>";}

} # EINDE NEW CLAN
if ($joinclan == 'yes') { ## JOIN CLAN
 $sql = "SELECT name FROM clans WHERE name='$clanname'";
  $resultaat = mysqli_query($mysqli,$sql);
   $aantaluser = mysqli_num_rows($resultaat);
if ($aantaluser == 0) {
$uitvoer = "<B>Sorry, there is no such clan as '$clanname'.</b><BR>";
} else {

 $sql = "SELECT name FROM clans WHERE name='$clanname' && pw='$clanpw' && pw<>'' LIMIT 1";
  $resultaat = mysqli_query($mysqli,$sql);
   $pw = mysqli_num_rows($resultaat);
if ($pw > 0){
	   $sql = "SELECT name, tag, alliedclans, alliedplayers FROM clans WHERE name='$clanname'";
	    $resultaat = mysqli_query($mysqli,$sql);
	    while ($record = mysqli_fetch_object($resultaat))
        {
            $clanname=$record->name; $clantag=$record->tag;
            $alliedclans = $record->alliedclans;
            $alliedplayers = $record->alliedplayers;

            $S_clanalliedclans = strtolower($record->alliedclans);
            $_SESSION["S_clanalliedclans"]= $S_clanalliedclans;

            $S_clanalliedplayers = strtolower($record->alliedplayers);
            $_SESSION["S_clanalliedplayers"]= $S_clanalliedplayers;

            $S_alliedclans = explode(",", $S_playeralliedclans . (strlen($S_playeralliedclans) > 0 ? "," : "") . $S_clanalliedclans);
            $_SESSION["S_alliedclans"]= $S_alliedclans;

            $S_alliedplayers = explode(",", $S_playeralliedplayers . (strlen($S_playeralliedplayers) > 0 ? "," : "") . $S_clanalliedplayers);
            $_SESSION["S_alliedplayers"]= $S_alliedplayers;
        }
	    $sqll = "INSERT INTO clans (username, name, tag, rank, alliedclans, alliedplayers)
	         VALUES ('$S_user', '$clanname', '$clantag', 'New member', '$alliedclans', '$alliedplayers')";
	    mysqli_query($mysqli,$sqll) or die("erroraa report this bug");
	$new='no';
	echo"<CENTER><BR><BR>You have joined the $clanfull clan successfully.<BR><a href=clan.php>Click here to continue</a><BR>";

	$sql = "SELECT username FROM clans WHERE pw<>'' && name='$clanname' LIMIT 1";
	$resultaat = mysqli_query($mysqli,$sql);
	while ($record = mysqli_fetch_object($resultaat)) { $clanadmin=$record->username; }

	$mess="$S_user has joined your clan.";
	$sql = "INSERT INTO messages (username, sendby, message, time, topic)
	  VALUES ('$clanadmin', '<B>Syrnia</B>', '$mess ', '$time', 'Clan')";
	mysqli_query($mysqli,$sql) or die("error report this bug please33 66 msg");

	$S_clantag=$clantag;

	# ADD CLAN CHAT MESSAGE
    $SystemMessage = 1;
    $chatMessage = "$S_user has joined the clan";
    $channel = 3;
    include (GAMEPATH . "/scripts/chat/addchat.php");
    ### EINDE CLAN CHAT MESSAGE

}else{
	$uitvoer ="<B>Wrong password.</b><BR>";
	if($S_wrongClanPass<1){
		$S_wrongClanPass=1;
	}
	$S_wrongClanPass++;
	 $_SESSION["S_wrongClanPass"] = $S_wrongClanPass;

	 if($S_wrongClanPass>10){
	 	$S_user='';
	 }
} #pw=0
} # wel such clan
} # JOIN clan






if($new<>'no'){
echo "<CENTER><h3>Clan</h3>$uitvoer<BR>You are not member of any clan yet.<BR><BR>You can either start your own clan or join an existing clan.<BR>
<BR>
<HR>
<b>Create a new clan:</b><BR>";

  $sql = "SELECT online  FROM stats WHERE username='$S_user' LIMIT 1";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat)) { $online=$record->online;  }

if($online>(3600*24)){

	echo"<form action='' method=post>
	<input type=hidden name=newclan value=yes>
	<table>
	<tr><td>Enter the clan name <td><input type=text name=clanname size=20  maxlength=40></tr>
	<tr><td>Enter the clan short tag <td><input type=text name=clantag size=5 maxlength=5></tr>
	<tr> <td><input type=submit value=Create></tr></table></form>";

}else{
	 echo"Sorry, you are not allowed to create a new clan yet.<br/>
	You need to play Syrnia a few more hours.<br/>
	Maybe join an existing clan and learn more about the game first ?<br/>";
}
echo"<HR>

<b>Join a clan:</b><BR>
<form action='' method=post>
<input type=hidden name=joinclan value=yes>
<table>
<tr><td>Enter the clan name <td><input type=text name=clanname size=20  maxlength=40></tr>
<tr><td>Enter the clan password <td><input type=text name=clanpw size=20 maxlength=40></tr>
<tr> <td><input type=submit value=Join></tr></table></form><HR>

";



}
}## EINDE NO CLAN
}# Newbie at tutorial..cant join clan yet
} # user
?>
</body>
</html>