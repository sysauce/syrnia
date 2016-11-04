<?
if(defined('AZtopGame35Heyam')){

require_once("../../currentRunningVersion.php");
include_once('includes/levels.php');

$resultt = mysqli_query($mysqli, "SELECT ID FROM users WHERE username='$S_user' && (work='move' OR work='sail')  LIMIT 1");
$aana = mysqli_num_rows($resultt);
$resultt = mysqli_query($mysqli, "SELECT ID FROM locations WHERE monstersmuch>0 && (type='invasion' || type='skillevent') && location='$S_location' && startTime<'$timee' LIMIT 1");
$invasions = mysqli_num_rows($resultt);

if($invasions==1 || $aana>=1){ #### INVASION!!

	 $output .= "There is an event going on at this location, you cannot enter your stockhouse at the moment.<br/><a href='' onclick=\"locationText();return false;\">Click here to discover what is going on.</a>";

}else{

$output.="<center><h1>Clan Stockhouse</h1>";

$sql = "SELECT name, rank, tag, pw, changeranks,changenews, changeallies, kick, addStock, removeStock, manageStock, alliedclans, alliedplayers FROM clans WHERE username='$S_user' AND tag='$S_clantag' LIMIT 1";
$resultaat = mysqli_query($mysqli,$sql);
if($record = mysqli_fetch_object($resultaat))
{
    $pw=stripslashes($record->pw);
    $canAddStock=$record->addStock;
    $canRemoveStock=$record->removeStock;
    $canManageStock=$record->manageStock;

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
        $sql = "SELECT * FROM clanbuildings WHERE tag='$S_clantag' ORDER BY location ASC";
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

$sql = "SELECT * FROM clanbuildings WHERE location = '$S_location' AND tag = '$S_clantag'";
//$output .=  "$sql<br/>";
$resultset = mysqli_query($mysqli,$sql);
if($record = mysqli_fetch_object($resultset))
{
    $stockhouseID = $record->ID;
    $slots = $record->slots;
    $slotsUsed = $record->slotsUsed;
    $gp = $record->gp;
    $output .= "<div id='stockhouseSlots'>slotsUsedVar/$slots</div><br/><div id='stockhouseGP'>There is gpVar gp in this stockhouse.</div>";

    if($var1 == 'addItems')
    {
        $numberOfItems = ceil($var2);
        $itemID = $var3;
        $output .= "<h2><div id='addToCompound'>Add items to compound</div></h2>Click an item in your inventory to add it to the compound.<br/>";
        $output .= "Number of items to add: <input type='text' id='numberOfItems' value='$numberOfItems' size='3' class='input'><br/><br/>";

        if($itemID > 0)
        {
            if($numberOfItems > $slots - $slotsUsed)
            {
                $numberOfItems = $slots - $slotsUsed;
            }

            if($numberOfItems > 0)
            {
                $sql = "SELECT ID,name,much,itemupgrade,upgrademuch, type FROM items_inventory WHERE ID='$itemID' && type<>'quest' && username='$S_user' LIMIT 1";
                $resultset = mysqli_query($mysqli,$sql);
                if($itemRecord = mysqli_fetch_object($resultset))
                {
                    if($itemRecord->name == 'Elven casino lottery ticket')
                    {
                        $output .= "<b>You can't add $itemRecord->name to the stockhouse</b>.<br/>";
                    }
                    else
                    {
                        if($numberOfItems > $itemRecord->much)
                        {
                            $numberOfItems = $itemRecord->much;
                        }

                        $sql = "SELECT ID, name, much, itemupgrade, upgrademuch, type FROM clanbuildingsitems
                            WHERE name='$itemRecord->name' && itemupgrade='$itemRecord->itemupgrade' && upgrademuch='$itemRecord->upgrademuch' && clanbuildingID = '$stockhouseID' && much>0 LIMIT 1";
                        $resultset = mysqli_query($mysqli, $sql);
                        if($rec = mysqli_fetch_object($resultset))
                        {
                            $sql = "UPDATE clanbuildingsitems SET much = much + '$numberOfItems'
                                WHERE name='$itemRecord->name' && itemupgrade='$itemRecord->itemupgrade' && upgrademuch='$itemRecord->upgrademuch' && clanbuildingID = '$stockhouseID' && much>0 LIMIT 1";
                            mysqli_query($mysqli, $sql) or die("err2or --> mhrn 1");
                        }
                        else
                        {
                            $sql = "INSERT INTO clanbuildingsitems (clanbuildingID, name, much, type, itemupgrade, upgrademuch)
                                VALUES ($stockhouseID, '$itemRecord->name', '$numberOfItems', '$itemRecord->type', '$itemRecord->itemupgrade', '$itemRecord->upgrademuch')";
                            mysqli_query($mysqli,$sql) or die("error report this bug please add to clanbuildingsitems msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");
                        }

                        removeItem($S_user, $itemRecord->name, $numberOfItems, $itemRecord->itemupgrade, $itemRecord->upgrademuch, true);

                        $upg='';
                        if($itemRecord->itemupgrade)
                        {
                            $upg=" [$itemRecord->upgrademuch $itemRecord->itemupgrade]";
                        }
                        $output .= "<b>$numberOfItems $itemRecord->name$upg added</b>.<br/>";

                        # ADD CLAN CHAT MESSAGE
                        $SystemMessage = 1;
                        $chatMessage = "$S_user added $numberOfItems $itemRecord->name$upg to $S_location";
                        $channel = 3;
                        include(GAMEPATH . "scripts/chat/addchat.php");

                        $sql = "UPDATE clanbuildings SET slotsUsed = slotsUsed + $numberOfItems WHERE ID = $stockhouseID LIMIT 1";
                        mysqli_query($mysqli, $sql) or die("err2or --> mhrn 1");

                        $sql = "INSERT INTO clanbuildingslog (logtime, action, user, clanbuildingID, name, much, type, itemupgrade, upgrademuch)
                            VALUES (" . time() . ", 'addItem', '$S_user', $stockhouseID, '$itemRecord->name', '$numberOfItems', '$itemRecord->type', '$itemRecord->itemupgrade', '$itemRecord->upgrademuch')";
                        mysqli_query($mysqli,$sql) or die("error report this bug please add to clanbuildingsitems msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

                        $slotsUsed = $slotsUsed + $numberOfItems;
                    }
                }
            }
            else
            {
                $output .= "There are no free slots in the compound.";
            }
        }
    }
    else if($var1 == 'gp')
    {
        $action = $var2;
        $gpAmount = ceil($var3);
        $output .= "<h2><div id='addToCompound'>Add gp to compound</div></h2>Click an item in your inventory to add it to the compound.<br/><br/>";
        $output .= "<form onsubmit=\"locationText('clancompound', 'gp', 'withdraw', $('compoundWithdrawGold').value);return false;\">" .
            "<input type='text' class='input' id='compoundWithdrawGold' value='' size='5'> <input type=submit class=button value='" . ($S_removeStock ? "Withdraw" : "Request") . "'></form><br/><br/>";
        $output .= "<form onsubmit=\"locationText('clancompound', 'gp', 'deposit', $('compoundDepositGold').value);return false;\">" .
            "<input type='text' class='input' id='compoundDepositGold' value='' size='5'> <input type=submit class=button value='Deposit'></form><br/><br/>";

        if(is_numeric($gpAmount) && $gpAmount >= 1)
        {
            $sqla = "SELECT gold FROM users WHERE username='$S_user' LIMIT 1";
            $resultaaat = mysqli_query($mysqli,$sqla);
            while ($recorad = mysqli_fetch_object($resultaaat)) {  $gold=$recorad->gold; }

            if($action == "withdraw")
            {
                if($gpAmount > $gp)
                {
                    $gpAmount=$gp;
                }

                if($gpAmount >= 1)
                {
                    if($S_removeStock)
                    {
                        mysqli_query($mysqli,"UPDATE clanbuildings SET gp=gp-'$gpAmount' WHERE ID='$stockhouseID' LIMIT 1") or die("error2 --> 1");
                        getGold($S_user, $gpAmount);
                        $gp=$gp-$gpAmount;
                        $gold=$gold+$gpAmount;
                        echo"$('statsGoldText').innerHTML=\"$gold\";";

                        $sql = "INSERT INTO clanbuildingslog (logtime, action, user, clanbuildingID, name, much, type, itemupgrade, upgrademuch)
                            VALUES (" . time() . ", 'removeGP', '$S_user', $stockhouseID, 'Gold pieces', '$gpAmount', 'Gold', '', '')";
                        mysqli_query($mysqli,$sql) or die("error report this bug please add to clanbuildingsitems msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

                        $output .= number_format($gpAmount) . " gp removed.";

                        # ADD CLAN CHAT MESSAGE
                        $SystemMessage = 1;
                        $chatMessage = "$S_user removed " . number_format($gpAmount) . " gp from $S_location";
                        $channel = 3;
                        include(GAMEPATH . "scripts/chat/addchat.php");
                    }
                    else
                    {
                        $sql = "INSERT INTO clanbuildingsrequests (user, clanbuildingID, name, much, type, itemupgrade, upgrademuch)
                                VALUES ('$S_user', $stockhouseID, 'Gold pieces', '$gpAmount', 'Gold', '', '')";
                            mysqli_query($mysqli,$sql) or die("error report this bug please add to clanbuildingsitems msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

                        $sql = "INSERT INTO clanbuildingslog (logtime, action, user, clanbuildingID, name, much, type, itemupgrade, upgrademuch)
                                VALUES (" . time() . ", 'requestGP', '$S_user', $stockhouseID, 'Gold pieces', '$gpAmount', 'Gold', '', '')";
                            mysqli_query($mysqli,$sql) or die("error report this bug please add to clanbuildingsitems msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

                        $output .= number_format($gpAmount) . " gp requested, please wait for approval.";

                        # ADD CLAN CHAT MESSAGE
                        $SystemMessage = 1;
                        $chatMessage = "$S_user requested " . number_format($gpAmount) . " gp from $S_location";
                        $channel = 3;
                        include(GAMEPATH . "scripts/chat/addchat.php");
                    }
                }
            }
            else if($action == "deposit")
            {
                if($gpAmount > $gold)
                {
                    $gpAmount=$gold;
                }

                if($gpAmount >= 1)
                {
                    mysqli_query($mysqli,"UPDATE clanbuildings SET gp=gp+'$gpAmount' WHERE ID='$stockhouseID' LIMIT 1") or die("error2 --> 1");
                    payGold($S_user, $gpAmount);
                    $gp=$gp+$gpAmount;
                    $gold=$gold-$gpAmount;
                    echo"$('statsGoldText').innerHTML=\"$gold\";";

                    $sql = "INSERT INTO clanbuildingslog (logtime, action, user, clanbuildingID, name, much, type, itemupgrade, upgrademuch)
                            VALUES (" . time() . ", 'addGP', '$S_user', $stockhouseID, 'Gold pieces', '$gpAmount', 'Gold', '', '')";
                        mysqli_query($mysqli,$sql) or die("error report this bug please add to clanbuildingsitems msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

                    $output .= number_format($gpAmount) . " gp added.";

                    # ADD CLAN CHAT MESSAGE
                    $SystemMessage = 1;
                    $chatMessage = "$S_user added " . number_format($gpAmount) . " gp to $S_location";
                    $channel = 3;
                    include(GAMEPATH . "scripts/chat/addchat.php");
                }
            }
        }
    }
    else
    {
        if($record->underConstruction)
        {
            $output .= "This stockhouse is currently under construction. Progress:<br/><br/>";
            $sql = "SELECT * FROM clanbuildingsresources WHERE clanbuildingID = $record->ID ORDER BY required DESC";
            //echo "$sql<br/>";
            $resultset = mysqli_query($mysqli,$sql);
            if($resources = mysqli_fetch_object($resultset))
            {
                do
                {
                    $output .= "$resources->resource ($resources->added/$resources->required)" .
                        ($resources->required - $resources->added > 0 ? " <a href='' onclick=\"locationText('work','constructing','clancompound','$resources->resource');return false;\">Add to clan stockhouse</a>" : "") .
                        "<br/>";
                }while($resources = mysqli_fetch_object($resultset));
            }

            $output .= "<br/>";
        }

        if($slots > 0)
        {
            if($var1 == "type")
            {
                $type = $var2;
                $itemID = $var3;
                $numberOfItems = ceil($var4);
            }
            else if($var1 == "search")
            {
                $searchFor = trim($var2);
                $itemID = $var3;
                $numberOfItems = ceil($var4);
            }
            else
            {
                include_once('rebuildInventory.php');
            }

            $output .= "<br/><a href='' onclick=\"locationText('clancompound', 'addItems', 1, 0);return false;\">Add items to the compound</a><br /><br/>";
            $output .= "<a href='' onclick=\"locationText('clancompound', 'gp', 0, 0);return false;\">Add or " . ($S_removeStock ? "remove" : "request") . " gp</a><br /><br/>";

            if($var1 == 'removeItems')
            {
                $approvedID = $var2;

                if(!array_key_exists($approvedID, $_SESSION["S_processedRequests"]))
                {
                    $_SESSION["S_processedRequests"][$approvedID] = true;
                    $sql = "SELECT * FROM clanbuildingsrequests WHERE clanbuildingID = $stockhouseID AND ID = $approvedID AND user = '$S_user' AND approved = 1";
                    //echo "$sql<br/>";
                    $resultset = mysqli_query($mysqli,$sql);
                    if($itemRecord = mysqli_fetch_object($resultset))
                    {
                        if($itemRecord->name == "Gold pieces")
                        {
                            $gpAmount = $itemRecord->much;

                            if($gpAmount <= $gp)
                            {
                                $var3 = "confirm";
                            }
                            else
                            {
                                $requestedGP = $gpAmount;
                                $gpAmount = $gp;
                            }

                            if($var3 != "confirm")
                            {
                                $output .= "We don't have enough gp in the stockhouse to remove $requestedGP...<br/>";
                                $output .= "<a href='' onclick=\"locationText('clancompound', 'removeItems', $approvedID, 'confirm');return false;\">Remove</a> <b>$gpAmount</b> gp instead.";
                            }
                            else if($gpAmount >= 1)
                            {
                                mysqli_query($mysqli,"UPDATE clanbuildings SET gp=gp-'$gpAmount' WHERE ID='$stockhouseID' LIMIT 1") or die("error2 --> 1");
                                getGold($S_user, $gpAmount);
                                $gp=$gp-$gpAmount;
                                $gold=$gold+$gpAmount;
                                echo"$('statsGoldText').innerHTML=\"$gold\";";

                                $output .= number_format($gpAmount) . " gp removed.";

                                $sql = "INSERT INTO clanbuildingslog (logtime, action, user, clanbuildingID, name, much, type, itemupgrade, upgrademuch)
                                    VALUES (" . time() . ", 'removeGP', '$S_user', $stockhouseID, '$itemRecord->name', '$gpAmount', 'Gold', '', '')";
                                mysqli_query($mysqli,$sql) or die("error report this bug please add to clanbuildingsitems msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

                                # ADD CLAN CHAT MESSAGE
                                $SystemMessage = 1;
                                $chatMessage = "$S_user removed " . number_format($gpAmount) . " gp from $S_location (Approved)";
                                $channel = 3;
                                include(GAMEPATH . "scripts/chat/addchat.php");

                                $sql = "DELETE FROM clanbuildingsrequests WHERE clanbuildingID = $stockhouseID AND ID = $approvedID AND user = '$S_user' LIMIT 1";
                                mysqli_query($mysqli, $sql) or die("err2or --> mhrn 1");
                            }
                        }
                        else
                        {
                            $removedItems = $itemRecord->much;
                            $sql = "SELECT * FROM clanbuildingsitems WHERE clanbuildingID = $stockhouseID AND
                                name = '$itemRecord->name' AND type = '$itemRecord->type' AND itemupgrade = '$itemRecord->itemupgrade' AND upgrademuch = '$itemRecord->upgrademuch'";
                            //echo "$sql<br/>";
                            $resultset = mysqli_query($mysqli,$sql);
                            if($itemRecord = mysqli_fetch_object($resultset))
                            {
                                $upg='';
                                if($itemRecord->itemupgrade)
                                {
                                    $upg=" [$itemRecord->upgrademuch $itemRecord->itemupgrade]";
                                }

                                if($removedItems <= $itemRecord->much)
                                {
                                    $var3 = "confirm";
                                }
                                else
                                {
                                    $requestedItems = $removedItems;
                                    $removedItems = $itemRecord->much;
                                }

                                if($var3 != "confirm")
                                {
                                    $output .= "We don't have enough $itemRecord->name$upg in the stockhouse to remove $requestedItems...<br/>";
                                    $output .= "<a href='' onclick=\"locationText('clancompound', 'removeItems', $approvedID, 'confirm');return false;\">Remove</a> <b>$removedItems</b> $itemRecord->name$upg instead.";
                                }
                                else
                                {
                                    if(addItem($S_user, $itemRecord->name, $removedItems, $itemRecord->type, $itemRecord->itemupgrade, $itemRecord->upgrademuch, true))
                                    {
                                        if($itemRecord->much - $removedItems > 0)
                                        {
                                            $sql = "UPDATE clanbuildingsitems SET much = much - '$removedItems'
                                                WHERE ID='$itemRecord->ID' && clanbuildingID = '$stockhouseID' && much>0 LIMIT 1";
                                            mysqli_query($mysqli, $sql) or die("err2or --> mhrn 1");
                                        }
                                        else
                                        {
                                            $sql = "DELETE FROM clanbuildingsitems WHERE ID='$itemRecord->ID' && clanbuildingID = '$stockhouseID' LIMIT 1";
                                            mysqli_query($mysqli, $sql) or die("err2or --> mhrn 1");
                                        }

                                        $output .= "<b>$removedItems $itemRecord->name$upg removed</b>.<br/>";

                                        $sql = "UPDATE clanbuildings SET slotsUsed = slotsUsed - $removedItems WHERE ID = $stockhouseID LIMIT 1";
                                        mysqli_query($mysqli, $sql) or die("err2or --> mhrn 1");
                                        $slotsUsed = $slotsUsed - $removedItems;

                                        $sql = "INSERT INTO clanbuildingslog (logtime, action, user, clanbuildingID, name, much, type, itemupgrade, upgrademuch)
                                            VALUES (" . time() . ", 'removeItem', '$S_user', $stockhouseID, '$itemRecord->name', '$removedItems', '$itemRecord->type', '$itemRecord->itemupgrade', '$itemRecord->upgrademuch')";
                                        mysqli_query($mysqli,$sql) or die("error report this bug please add to clanbuildingsitems msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

                                        # ADD CLAN CHAT MESSAGE
                                        $SystemMessage = 1;
                                        $chatMessage = "$S_user removed $removedItems $itemRecord->name$upg from $S_location (Approved)";
                                        $channel = 3;
                                        include(GAMEPATH . "scripts/chat/addchat.php");

                                        $sql = "DELETE FROM clanbuildingsrequests WHERE clanbuildingID = $stockhouseID AND ID = $approvedID AND user = '$S_user' LIMIT 1";
                                        mysqli_query($mysqli, $sql) or die("err2or --> mhrn 1");
                                    }
                                }
                            }
                        }
                    }
                    else
                    {
                        $output .= "Approved request could not be found.";
                    }
                }
                else
                {
                    $output .= "You have already tried to remove this item.";
                }


                $output .= "<br/><br/>";
            }

            $sql = "SELECT * FROM clanbuildingsrequests WHERE clanbuildingID = $stockhouseID AND user = '$S_user' AND approved = 1 ORDER BY name ASC, itemupgrade ASC, upgrademuch ASC";
            //echo "$sql<br/>";
            $resultset = mysqli_query($mysqli,$sql);
            if($itemRecord = mysqli_fetch_object($resultset))
            {
                $output .= "<h2>Approved items waiting to be picked up</h2><div id='approvedItems' style='text-align: left;'>";
                do
                {
                    $upg='';
                    if($itemRecord->itemupgrade)
                    {
                        $upg=" [$itemRecord->upgrademuch $itemRecord->itemupgrade]";
                    }

                    $output .= "<a href='' onclick=\"$('approvedItems').style.display='none';locationText('clancompound', 'removeItems', $itemRecord->ID);return false;\">Remove</a> <b>$itemRecord->much $itemRecord->name$upg</b><br/>";
                }while($itemRecord = mysqli_fetch_object($resultset));

                $output .= "</div><br/><br/>";
            }

            $output.="<table cellpadding=10 width=100%><tr valign=top><td bgcolor=550000 width=150>";
            $output.="<form action='#' onsubmit=\"locationText('clancompound', 'search', $('searchFor').value);return false\"><input type=text size=6 id='searchFor'><input type=submit value=Search></form>";
            $output.="<br />";
            $output.="<B>Tools and weapons:</B><br />";
            $output.="<a href='' onclick=\"locationText('clancompound', 'type', 'hand');return false;\">Tools & Weapons</a><br />";
            $output.="<br />";
            $output.="<B>Armour:</B><br />";
            $output.="<a href='' onclick=\"locationText('clancompound', 'type', 'body');return false;\">Body armour</a><br />";
            $output.="<a href='' onclick=\"locationText('clancompound', 'type', 'legs');return false;\">Leg armour</a><br />";
            $output.="<a href='' onclick=\"locationText('clancompound', 'type', 'shield');return false;\">Shields</a><br />";
            $output.="<a href='' onclick=\"locationText('clancompound', 'type', 'helm');return false;\">Helms</a><br />";
            $output.="<a href='' onclick=\"locationText('clancompound', 'type', 'shoes');return false;\">Shoes</a><br />";
            $output.="<a href='' onclick=\"locationText('clancompound', 'type', 'gloves');return false;\">Gloves</a><br />";
            $output.="<br />";
            $output.="<B>Food:</B><br />";
            $output.="<a href='' onclick=\"locationText('clancompound', 'type', 'food');return false;\">Uncooked food</a><br />";
            $output.="<a href='' onclick=\"locationText('clancompound', 'type', 'cooked food');return false;\">Cooked food/Drinks</a><br />";
            $output.="<br />";
            $output.="<B>Bars and ores:</b><br />";
            $output.="<a href='' onclick=\"locationText('clancompound', 'type', 'bars');return false;\">Bars</a><br />";
            $output.="<a href='' onclick=\"locationText('clancompound', 'type', 'ore');return false;\">Ores</a><br />";
            $output.="<br />";
            $output.="<B>Boats:</B><br />";
            $output.="<a href='' onclick=\"locationText('clancompound', 'type', 'boat');return false;\">Boat</a><br />";
            $output.="<br />";
            $output.="<b>Other:</b><br />";
            $output.="<a href='' onclick=\"locationText('clancompound', 'type', 'other');return false;\">Other</a><br />";
            $output.="<td width=10><td bgcolor=440000>";

            if($type && ($type=='other' OR $type=='boat' OR $type=='ore' OR $type=='bars' OR $type=='cooked food' OR $type=='food' OR
                $type=='gloves' OR $type=='shoes' OR $type=='helm' OR $type=='shield' OR $type=='legs' OR $type=='body' OR $type=='hand'))
            {
                $queue="CBI.type='$type'";
                if($type=='other')
                {
                    $queue="CBI.type NOT IN ('boat', 'ore', 'bars', 'cooked food', 'food', 'gloves', 'shoes', 'helm', 'shield', 'legs', 'body', 'hand')";
                }

                if($itemID && $numberOfItems)
                {
                    if($itemID > 0 && $numberOfItems >= 1)
                    {
                        $sql = "SELECT ID, name, much, itemupgrade, upgrademuch, type FROM clanbuildingsitems
                            WHERE ID='$itemID' AND clanbuildingID = '$stockhouseID' && much>0 LIMIT 1";
                        $resultset = mysqli_query($mysqli, $sql);
                        if($itemRecord = mysqli_fetch_object($resultset))
                        {
                            $removedItems = $numberOfItems;
                            if($itemRecord->much < $numberOfItems)
                            {
                                $removedItems = $itemRecord->much;
                            }

                            if($removedItems >= 1)
                            {
                                $upg='';
                                if($itemRecord->itemupgrade)
                                {
                                    $upg=" [$itemRecord->upgrademuch $itemRecord->itemupgrade]";
                                }

                                if($S_removeStock)
                                {
                                    if(addItem($S_user, $itemRecord->name, $removedItems, $itemRecord->type, $itemRecord->itemupgrade, $itemRecord->upgrademuch, true))
                                    {
                                        if($itemRecord->much - $removedItems > 0)
                                        {
                                            $sql = "UPDATE clanbuildingsitems SET much = much - '$removedItems'
                                                WHERE ID='$itemID' && clanbuildingID = '$stockhouseID' && much>0 LIMIT 1";
                                            mysqli_query($mysqli, $sql) or die("err2or --> mhrn 1");
                                        }
                                        else
                                        {
                                            $sql = "DELETE FROM clanbuildingsitems WHERE ID='$itemID' && clanbuildingID = '$stockhouseID' LIMIT 1";
                                            mysqli_query($mysqli, $sql) or die("err2or --> mhrn 1");
                                        }

                                        $msg = "<b>$removedItems $itemRecord->name$upg removed</b>.<br/>";

                                        $sql = "UPDATE clanbuildings SET slotsUsed = slotsUsed - $removedItems WHERE ID = $stockhouseID LIMIT 1";
                                        mysqli_query($mysqli, $sql) or die("err2or --> mhrn 1");
                                        $slotsUsed = $slotsUsed - $removedItems;

                                        $sql = "INSERT INTO clanbuildingslog (logtime, action, user, clanbuildingID, name, much, type, itemupgrade, upgrademuch)
                                            VALUES (" . time() . ", 'removeItem', '$S_user', $stockhouseID, '$itemRecord->name', '$removedItems', '$itemRecord->type', '$itemRecord->itemupgrade', '$itemRecord->upgrademuch')";
                                        mysqli_query($mysqli,$sql) or die("error report this bug please add to clanbuildingsitems msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

                                        # ADD CLAN CHAT MESSAGE
                                        $SystemMessage = 1;
                                        $chatMessage = "$S_user removed $removedItems $itemRecord->name$upg from $S_location";
                                        $channel = 3;
                                        include(GAMEPATH . "scripts/chat/addchat.php");
                                    }
                                }
                                else
                                {
                                    $sql = "INSERT INTO clanbuildingsrequests (user, clanbuildingID, name, much, type, itemupgrade, upgrademuch)
                                            VALUES ('$S_user', $stockhouseID, '$itemRecord->name', '$removedItems', '$itemRecord->type', '$itemRecord->itemupgrade', '$itemRecord->upgrademuch')";
                                        mysqli_query($mysqli,$sql) or die("error report this bug please add to clanbuildingsitems msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

                                    $sql = "INSERT INTO clanbuildingslog (logtime, action, user, clanbuildingID, name, much, type, itemupgrade, upgrademuch)
                                            VALUES (" . time() . ", 'requestItem', '$S_user', $stockhouseID, '$itemRecord->name', '$removedItems', '$itemRecord->type', '$itemRecord->itemupgrade', '$itemRecord->upgrademuch')";
                                        mysqli_query($mysqli,$sql) or die("error report this bug please add to clanbuildingsitems msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

                                    $msg = "$removedItems $itemRecord->name$upg requested, please wait for approval.";

                                    # ADD CLAN CHAT MESSAGE
                                    $SystemMessage = 1;
                                    $chatMessage = "$S_user requested $removedItems $itemRecord->name$upg from $S_location";
                                    $channel = 3;
                                    include(GAMEPATH . "scripts/chat/addchat.php");
                                }
                            }
                            else
                            {
                                $msg = "None of this item remaining to remove.";
                            }
                        }
                    }
                }

                $output .= "<div id='compoundMiniLog' style='border: 1px solid black; margin-bottom: 5px;" . (strlen($msg) == 0 ? " display: none;" : "") . " '>$msg</div>";

                $sql = "SELECT CBI.ID, CBI.name, CBI.much, CBI.type, CBI.itemupgrade, CBI.upgrademuch FROM clanbuildingsitems CBI" .
                    " LEFT JOIN item_types T ON T.name = CBI.type" .
                    " LEFT JOIN items I ON I.name = CBI.name" .
                    " WHERE CBI.clanbuildingID = $stockhouseID AND $queue ORDER BY T.rank < 0 ASC, T.rank = 0 ASC, T.rank ASC, CBI.type ASC, I.rank, CBI.name ASC, CBI.itemupgrade ASC, CBI.upgrademuch ASC";
                $resultset = mysqli_query($mysqli, $sql);// or die("Error retreiving items from compound");
                if($itemRecord = mysqli_fetch_object($resultset))
                {
                    $output .= "<div id='removeFromCompound' style='border: 1px solid black; margin-bottom: 5px; display: none; '>" .
                        "<input type='hidden' id='compoundItemID' name='compoundItemID' value='0'>" .
                        "Number of <span id='compoundItemName'></span>&nbsp;to " . ($S_removeStock ? "remove" : "request") . ": <input type='text' id='numberOfItems' value='1' size='3' class='input'> " .
                        "<input type='button' class='button' value='" . ($S_removeStock ? "Remove" : "Request") . "'" .
                        "onclick=\"locationText('clancompound', 'type', '$type', $('compoundItemID').value, $('numberOfItems').value);return false;\">" .
                        "</div>";
                    $output .= "<div id='compoundInventory' style=\"text-align:left;width:100%; background-color:black;min-height:100px; border: 0; overflow:auto;\">";
                    $compoundInventoryContents = "";
                    $compoundItemsEvents = "";

                    do
                    {
                        if($itemRecord->upgrademuch>0)
                        {
                            $plus="+";
                        }
                        else
                        {
                            $plus='';
                        }

                        if($itemRecord->itemupgrade)
                        {
                            $upg=" [$plus$itemRecord->upgrademuch $itemRecord->itemupgrade]";
                            $upg2="'images/ingame/$itemRecord->itemupgrade.jpg'";
                        }
                        else
                        {
                            $upg=''; $upg2='null';
                        }
                        $compoundInventoryContents .= "+createItemHTML('itemC_$itemRecord->ID', '$itemRecord->name$upg', '$itemRecord->much', $upg2)";
                        //$compoundItemsEvents .= "disableSelection($('itemC_$record->ID'));";
                    }while($itemRecord = mysqli_fetch_object($resultset));

                    $output .= "</div>";

                    echo"setTimeout (\"";
                    echo"if(\$('compoundInventory')){\$('compoundInventory').innerHTML='';";

                    echo"\$('compoundInventory').innerHTML=''$compoundInventoryContents;";
                    echo"}";
                    echo"\", 200);";

                    echo"setTimeout (\"";
                    //echo"$compoundItemsEvents";
                    echo"compoundClickEvents('compoundInventory');";
                    //echo "recreateSortable('compoundInventory');";
                    //echo "recreateSortable('playerInventory');";
                    echo"\", 400);";
                    //$output .= "</table>";
                }
                else
                {
                    $output.="There are no items in this category.<br />";
                }
            }
            else
            {
                if($searchFor)
                {
                    if(strlen($searchFor) >= 3)
                    {
                        $queue="CBI.name LIKE '%$searchFor%'";

                        if($itemID && $numberOfItems)
                        {
                            if($itemID > 0 && $numberOfItems >= 1)
                            {
                                $sql = "SELECT ID, name, much, itemupgrade, upgrademuch, type FROM clanbuildingsitems
                                    WHERE ID='$itemID' AND clanbuildingID = '$stockhouseID' && much>0 LIMIT 1";
                                $resultset = mysqli_query($mysqli, $sql);
                                if($itemRecord = mysqli_fetch_object($resultset))
                                {
                                    $removedItems = $numberOfItems;
                                    if($itemRecord->much < $numberOfItems)
                                    {
                                        $removedItems = $itemRecord->much;
                                    }

                                    if($removedItems >= 1)
                                    {
                                        $upg='';
                                        if($itemRecord->itemupgrade)
                                        {
                                            $upg=" [$itemRecord->upgrademuch $itemRecord->itemupgrade]";
                                        }

                                        if($S_removeStock)
                                        {
                                            if(addItem($S_user, $itemRecord->name, $removedItems, $itemRecord->type, $itemRecord->itemupgrade, $itemRecord->upgrademuch, true))
                                            {
                                                if($itemRecord->much - $removedItems > 0)
                                                {
                                                    $sql = "UPDATE clanbuildingsitems SET much = much - '$removedItems'
                                                        WHERE ID='$itemID' && clanbuildingID = '$stockhouseID' && much>0 LIMIT 1";
                                                    mysqli_query($mysqli, $sql) or die("err2or --> mhrn 1");
                                                }
                                                else
                                                {
                                                    $sql = "DELETE FROM clanbuildingsitems WHERE ID='$itemID' && clanbuildingID = '$stockhouseID' LIMIT 1";
                                                    mysqli_query($mysqli, $sql) or die("err2or --> mhrn 1");
                                                }

                                                $msg = "<b>$removedItems $itemRecord->name$upg removed</b>.<br/>";

                                                $sql = "UPDATE clanbuildings SET slotsUsed = slotsUsed - $removedItems WHERE ID = $stockhouseID LIMIT 1";
                                                mysqli_query($mysqli, $sql) or die("err2or --> mhrn 1");
                                                $slotsUsed = $slotsUsed - $removedItems;

                                                $sql = "INSERT INTO clanbuildingslog (logtime, action, user, clanbuildingID, name, much, type, itemupgrade, upgrademuch)
                                                    VALUES (" . time() . ", 'removeItem', '$S_user', $stockhouseID, '$itemRecord->name', '$removedItems', '$itemRecord->type', '$itemRecord->itemupgrade', '$itemRecord->upgrademuch')";
                                                mysqli_query($mysqli,$sql) or die("error report this bug please add to clanbuildingsitems msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

                                                # ADD CLAN CHAT MESSAGE
                                                $SystemMessage = 1;
                                                $chatMessage = "$S_user removed $removedItems $itemRecord->name$upg from $S_location";
                                                $channel = 3;
                                                include(GAMEPATH . "scripts/chat/addchat.php");
                                            }
                                        }
                                        else
                                        {
                                            $sql = "INSERT INTO clanbuildingsrequests (user, clanbuildingID, name, much, type, itemupgrade, upgrademuch)
                                                    VALUES ('$S_user', $stockhouseID, '$itemRecord->name', '$removedItems', '$itemRecord->type', '$itemRecord->itemupgrade', '$itemRecord->upgrademuch')";
                                                mysqli_query($mysqli,$sql) or die("error report this bug please add to clanbuildingsitems msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

                                            $sql = "INSERT INTO clanbuildingslog (logtime, action, user, clanbuildingID, name, much, type, itemupgrade, upgrademuch)
                                                    VALUES (" . time() . ", 'requestItem', '$S_user', $stockhouseID, '$itemRecord->name', '$removedItems', '$itemRecord->type', '$itemRecord->itemupgrade', '$itemRecord->upgrademuch')";
                                                mysqli_query($mysqli,$sql) or die("error report this bug please add to clanbuildingsitems msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

                                            $msg = "$removedItems $itemRecord->name$upg requested, please wait for approval.";

                                            # ADD CLAN CHAT MESSAGE
                                            $SystemMessage = 1;
                                            $chatMessage = "$S_user requested $removedItems $itemRecord->name$upg from $S_location";
                                            $channel = 3;
                                            include(GAMEPATH . "scripts/chat/addchat.php");
                                        }
                                    }
                                    else
                                    {
                                        $msg = "None of this item available to remove.";
                                    }
                                }
                            }
                        }

                        $output .= "<div id='compoundMiniLog' style='border: 1px solid black; margin-bottom: 5px;" . (strlen($msg) == 0 ? " display: none;" : "") . " '>$msg</div>";

                        $sql = "SELECT CBI.ID, CBI.name, CBI.much, CBI.type, CBI.itemupgrade, CBI.upgrademuch FROM clanbuildingsitems CBI" .
                            " LEFT JOIN item_types T ON T.name = CBI.type" .
                            " LEFT JOIN items I ON I.name = CBI.name" .
                            " WHERE CBI.clanbuildingID = $stockhouseID AND $queue ORDER BY T.rank < 0 ASC, T.rank = 0 ASC, T.rank ASC, CBI.type ASC, I.rank, CBI.name ASC, CBI.itemupgrade ASC, CBI.upgrademuch ASC";
                        $resultset = mysqli_query($mysqli, $sql);// or die("Error retreiving items from compound");
                        if($itemRecord = mysqli_fetch_object($resultset))
                        {
                            $output .= "<div id='removeFromCompound' style='border: 1px solid black; margin-bottom: 5px; display: none; '>" .
                                "<input type='hidden' id='compoundItemID' name='compoundItemID' value='0'>" .
                                "Number of <span id='compoundItemName'></span> to " . ($S_removeStock ? "remove" : "request") . ": <input type='text' id='numberOfItems' value='1' size='3' class='input'> " .
                                "<input type='button' class='button' value='" . ($S_removeStock ? "Remove" : "Request") . "'" .
                                "onclick=\"locationText('clancompound', 'search', '$searchFor', $('compoundItemID').value, $('numberOfItems').value);return false;\">" .
                                "</div>";
                            $output .= "<div id='compoundInventory' style=\"text-align:left;width:100%; background-color:black;min-height:100px; border: 0; overflow:auto;\">";
                            $compoundInventoryContents = "";
                            $compoundItemsEvents = "";

                            do
                            {
                                if($itemRecord->upgrademuch>0)
                                {
                                    $plus="+";
                                }
                                else
                                {
                                    $plus='';
                                }

                                if($itemRecord->itemupgrade)
                                {
                                    $upg=" [$plus$itemRecord->upgrademuch $itemRecord->itemupgrade]";
                                    $upg2="'images/ingame/$itemRecord->itemupgrade.jpg'";
                                }
                                else
                                {
                                    $upg=''; $upg2='null';
                                }
                                $compoundInventoryContents .= "+createItemHTML('itemC_$itemRecord->ID', '$itemRecord->name$upg', '$itemRecord->much', $upg2)";
                                //$compoundItemsEvents .= "disableSelection($('itemC_$record->ID'));";
                            }while($itemRecord = mysqli_fetch_object($resultset));

                            $output .= "</div>";

                            echo"setTimeout (\"";
                            echo"if(\$('compoundInventory')){\$('compoundInventory').innerHTML='';";

                            echo"\$('compoundInventory').innerHTML=''$compoundInventoryContents;";
                            echo"}";
                            echo"\", 200);";

                            echo"setTimeout (\"";
                            //echo"$compoundItemsEvents";
                            echo"compoundClickEvents('compoundInventory');";
                            //echo "recreateSortable('compoundInventory');";
                            //echo "recreateSortable('playerInventory');";
                            echo"\", 400);";
                            //$output .= "</table>";
                        }
                        else
                        {
                            $output.="There are no items matching '$searchFor'.<br />";
                        }
                    }
                    else
                    {
                        $output.="There is a minimum of 3 characters for a search.<br />";
                    }
                }
                else if($var1 == "search")
                {
                    $output.="You haven't entered anything to search for!<br />";
                }
            }
        }
    }

    $output = str_replace("slotsUsedVar", "" . $slotsUsed, $output);
    $output = str_replace("gpVar", "" . number_format($gp), $output);
}
else
{
    $output .= "You don't have a stockhouse here.";
}


}//invasions




}
?>