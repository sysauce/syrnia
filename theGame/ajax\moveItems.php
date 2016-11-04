<?
header("Cache-Control: no-cache, must-revalidate");
session_start();
$timee=$time=time();
define('AZtopGame35Heyam', true );
if(!$S_user){
	echo"window.location=\"index.php?page=logout&error=noUser&from=cC\";";
  	exit();
}
//require_once("../../currentRunningVersion.php");

require_once("../includes/db.inc.php");


if (mysqli_connect_errno())
{
    exit();
}


//Are we allowed to use house/shop etc.? We cant use it when moving or when in jail, etc.
$sql = "SELECT work FROM users WHERE username='$S_user' LIMIT 1";
$resultaat = mysqli_query($mysqli,$sql);
while ($record = mysqli_fetch_object($resultaat))
{
 	if($record->work=='jail' || $record->work=='move'){
		exit();
	}
}



//$itemID=str_replace('item_', '', $itemID);
//$itemID=substr($itemID, 6); // (cut off the itemX_)

if(!is_numeric($itemID) || !$to || !$from || !is_numeric($move))
{
	exit();
}
$move=round($move);

require_once("includes/functions.php");

if($from=='centerDropList' && $to=='playerInventory'){

    $transfer = true;
    if(strpos($S_location, "The Outlands ") == 0)
    {
        //Check that the person is actually still in the OL and has not been killed
        $sql = "SELECT location FROM users WHERE username = '$S_user' LIMIT 1";
        $resultaaaat = mysqli_query($mysqli, $sql);
        while ($record = mysqli_fetch_object($resultaaaat))
        {
            if($record->location != $S_location)
            {
                $transfer = false;
            }
        }
    }

    if($transfer)
    {
        if($lg == 1)  //Is mouse over the centreDropList when picking up items
        {
            if(mysqli_num_rows(mysqli_query($mysqli,  "SELECT ID FROM zmods WHERE action = 'Cheat log' AND username='$S_user' AND time > " . (time() - (3600 * 24 * 1)) .
                " AND reason LIKE 'Auto item pick up%' AND reason NOT LIKE '%Outland%'")) == 0)
            {
                $cheatLogQuery = "'Cheat log', 'Auto item pick up used by $S_user at $S_location.<br/><br/>" . $_SERVER['HTTP_USER_AGENT'] .
                    "', 'Cheating $S_user - m3', '" . time() . "', '0'";

                $sql = "INSERT INTO messages (username, sendby, message, topic, time, status)
                    VALUES ('Hazgod', $cheatLogQuery), ('SYRAID', $cheatLogQuery), ('Redhood', $cheatLogQuery)";
                mysqli_query($mysqli, $sql) or die("error report4324426");

                /*$sql = "INSERT INTO messages (username, sendby, message, topic, time, status)
                    VALUES ('SYRAID', $cheatLogQuery), ('Redhood', $cheatLogQuery)";
                mysqli_query($mysqli, $sql) or die("error report4324426");*/

                $sqal = "INSERT INTO zmods (username, action, reason, timer, time, moderator, moderatorIP, reportID)
                    VALUES ('$S_user', 'Cheat log', 'Auto item pick up used at $S_location', '0', '" . time() . "', 'The Game', '', '0')";
                mysqli_query($mysqli, $sqal) or die("error2aa report this bug $sqal");
            }
        }
        //PICK UP items from the ground
        $sqal = "SELECT type,much,name, itemupgrade,upgrademuch FROM items_dropped WHERE location='$S_location' && ID='$itemID' && (type!='quest' || droppedBy='$S_user') LIMIT 1";
        $resultaaaat = mysqli_query($mysqli, $sqal);
        while ($record = mysqli_fetch_object($resultaaaat))
        {
        if($move>=$record->much){
            $move=$record->much;
            $delete=1;
        }

        if($delete==1){
            mysqli_query($mysqli, "DELETE FROM items_dropped WHERE ID='$itemID' LIMIT 1") or die(mail('support@syrnia.com', 'Syrnia Error (finding invis. items)', $mysqli->error));
        }else{
            mysqli_query($mysqli, "UPDATE items_dropped SET much=much-'$move' WHERE ID='$itemID' LIMIT 1") or die(mail('support@syrnia.com', 'Syrnia Error (finding invis. items)', $mysqli->error));
        }

        addItem($S_user, $record->name, $move, $record->type, $record->itemupgrade, $record->upgrademuch, 0);

            $sqll = "INSERT INTO zlogs (titel, tekst, time)
             VALUES ('Pickup $S_user', '$S_user picked up $move $record->name [$record->upgrademuch $record->itemupgrade ] at $S_location on $timee', '$timee')";
          mysqli_query($mysqli, $sqll) or die(mail('support@syrnia.com', 'Syrnia Error (finding invis. items)', $mysqli->error));

        $inventoryID=0;
        $resulta = mysqli_query($mysqli,"SELECT ID FROM items_inventory WHERE username='$S_user' && name='$record->name' && itemupgrade='$record->itemupgrade' && upgrademuch='$record->upgrademuch' LIMIT 1");
        while ($rec = mysqli_fetch_object($resulta)){  $inventoryID=$rec->ID; 	 }
        echo $inventoryID;
        }//sql
    }
}else if($from=='playerInventory' && $to=='centerDropList'){

	//DROP items to the ground
  	$sql = "SELECT name, ID,much, type, itemupgrade as itemupgrade, upgrademuch FROM items_inventory WHERE  ID='$itemID' && username='$S_user' LIMIT 1";
   	$resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat))
	{

		if($move>=$record->much){
			$move=$record->much;
			mysqli_query($mysqli,"DELETE FROM items_inventory WHERE ID='$itemID' LIMIT 1") or die(mail('support@syrnia.com', 'Syrnia Error (finding invis. items)', $mysqli->error));
		}else{
			mysqli_query($mysqli,"UPDATE items_inventory SET much=much-'$move' WHERE ID='$itemID' LIMIT 1") or die(mail('support@syrnia.com', 'Syrnia Error (finding invis. items)', $mysqli->error));
		}

		$inventoryID=0;
		if($record->type=='quest'){
			$sqlU = "SELECT ID FROM items_dropped WHERE droppedBy='$S_user' && name='$record->name' && itemupgrade='$record->itemupgrade' && upgrademuch='$record->upgrademuch' &&  location='$S_location'  LIMIT 1";
	   		$resulta = mysqli_query($mysqli,$sqlU);
	   		while ($rec = mysqli_fetch_object($resulta)){  $inventoryID=$rec->ID; 	 }
	    }else{
			$sqlU = "SELECT ID FROM items_dropped WHERE name='$record->name' && itemupgrade='$record->itemupgrade' && upgrademuch='$record->upgrademuch' &&  location='$S_location'  LIMIT 1";
	   		$resulta = mysqli_query($mysqli,$sqlU);
	   		while ($rec = mysqli_fetch_object($resulta)){  $inventoryID=$rec->ID; 	 }
		}

		if($inventoryID!=0){
			mysqli_query($mysqli,"UPDATE items_dropped SET much=much+'$move', droptime='$timee' WHERE ID='$inventoryID'  LIMIT 1") or die(mail('support@syrnia.com', 'Syrnia Error (finding invis. items)', $mysqli->error));
		} else{
	 		$sqll = "INSERT INTO items_dropped (droppedBy, name, much, type, droptime, location, itemupgrade, upgrademuch)
	         VALUES ('$S_user', '$record->name', '$move', '$record->type', '$timee', '$S_location', '$record->itemupgrade', '$record->upgrademuch')";
	      	mysqli_query($mysqli,$sqll) or die(mail('support@syrnia.com', 'Syrnia Error (finding invis. items)', $mysqli->error));
	      	$inventoryID=mysqli_insert_id($mysqli);
		}

	 	$sqll = "INSERT INTO zlogs (titel, tekst, time) VALUES ('Drop $S_user', '$S_user dropped $move $record->name [$record->upgrademuch $record->itemugrade] at $S_location on $timee', '$timee')";
	    mysqli_query($mysqli,$sqll) or die(mail('support@syrnia.com', 'Syrnia Error (finding invis. items)', $mysqli->error));


	    echo $inventoryID;

    }//sql

}else if($from=='playerInventory' && $to=='houseInventory'){
## HOUSE TOEVOEGEN

	$houseid=0;
	$sql = "SELECT ID,slots FROM buildings WHERE type='house' && username='$S_user' && location='$S_location' LIMIT 1";
	$resultaat = mysqli_query($mysqli,$sql);
	while ($record = mysqli_fetch_object($resultaat))
	{
	 	$houseslots=$record->slots;
	 	$houseid=$record->ID;
	}

	if($houseid==0){
		echo"&&&messagePopup(\"You have no house at this location!\", \"House item transfer error\");";
		exit();
	}

	$name='';
	$add2housemuch=$move;

	//Check house space
	$slotsused=0;
	$sql = "SELECT much FROM houses WHERE ID='$houseid'";
	$resultaat = mysqli_query($mysqli,$sql);
	while ($record = mysqli_fetch_object($resultaat))
	{
		$slotsused=$slotsused+$record->much;
	}
	$slotsfree=$houseslots-$slotsused;
	if($add2housemuch>$slotsfree){
	 	$add2housemuch=$slotsfree;
	}

	//Check actual inventory amount
	$inventoryMuch=0;

	$sql = "SELECT name,much,type,  itemupgrade, upgrademuch FROM items_inventory WHERE username='$S_user' && ID='$itemID' LIMIT 1";
   	$resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
	  $name=$record->name;
	  $inventoryMuch=$record->much;
	  $type=$record->type;
	  $upgrade=$record->itemupgrade;
	  $upgrademuch=$record->upgrademuch;
	}

	if($add2housemuch>=$inventoryMuch){
	 	$add2housemuch=$inventoryMuch;
	 	$delete=1;
	}

	if($slotsfree<=0){
		$add2housemuch=0;
	 	echo"&&&messagePopup(\"You could not transfer your item(s) because your house has no free slots left!\", \"Can not transfer to house\");";
	 	exit();
	}else if($add2housemuch<1 || $inventoryMuch==0){
	 	$add2housemuch=0;
	 	echo"&&&messagePopup(\"The move quantitity must be one or more! (It is most likely that you do not have the item that you tried to transfer)\", \"House item transfer error\");";
	 	exit();
	}


if($name && $houseid && $add2housemuch>=1){

	$slotsfree=$slotsfree-$add2housemuch;

    //TODO: Make this transactional!
	if($delete==1){
		mysqli_query($mysqli,"DELETE FROM items_inventory WHERE ID='$itemID' LIMIT 1") or die(mail('support@syrnia.com', 'Syrnia Error (finding invis. items)', $mysqli->error));
	}else{
		mysqli_query($mysqli,"UPDATE items_inventory SET much=much-'$add2housemuch' WHERE ID='$itemID' LIMIT 1") or die(mail('support@syrnia.com', 'Syrnia Error (finding invis. items)', $mysqli->error));
	}

	$resultaat = mysqli_query($mysqli, "SELECT name FROM houses WHERE ID='$houseid' && much>0 && name='$name' && itemupgrade='$upgrade' && upgrademuch='$upgrademuch' LIMIT 1");
	$aantal = mysqli_num_rows($resultaat);
	if($aantal==1){
		mysqli_query($mysqli,"UPDATE houses SET much=much+'$add2housemuch' WHERE ID='$houseid' && much>0 && name='$name' && itemupgrade='$upgrade' && upgrademuch='$upgrademuch' LIMIT 1") or die(mail('support@syrnia.com', 'Syrnia Error (finding invis. items)', $mysqli->error));
	} else{
	 	$sql = "INSERT INTO houses (ID, name, much, type, itemupgrade, upgrademuch)
	         VALUES ('$houseid', '$name', '$add2housemuch', '$type', '$upgrade', '$upgrademuch')";

	      mysqli_query($mysqli,$sql) or die(mail('support@syrnia.com', 'Syrnia Error (finding invis. items)', $mysqli->error));
	}

	$inventoryID=0;
	$sqlU = "SELECT NR FROM houses WHERE ID='$houseid' && name='$name' && itemupgrade='$upgrade' && upgrademuch='$upgrademuch'   LIMIT 1";
   	$resulta = mysqli_query($mysqli,$sqlU);
    while ($rec = mysqli_fetch_object($resulta)){  $inventoryID=$rec->NR; 	 }
	echo $inventoryID;
	echo"&&&$('houseSlots').innerHTML=\"$slotsfree\";";
	if($move>$add2housemuch){
	 	$toomuch=$move-$add2housemuch;
		echo"setTimeout (\"";
		echo"removeItemFromContainerByID('houseInventory', 'itemH_$inventoryID', $toomuch, 0);";

		$imagename=str_replace(' ', '%20', $name);
	    if($upgrademuch>0){$plus="+"; }else{ $plus=''; }
		if($upgrade){
		  	$upg=" [$plus$upgrademuch $upgrade]";
		 	$upg2="'images/ingame/$upgrade.jpg'";
		}else{
			$upg=''; $upg2='null';
		}
		echo"addItemToContainer('playerInventory', 'itemI_$itemID', '$name$upg', $toomuch, $upg2);";
		echo"\", 250);";
	}
}

}else if($from=='houseInventory' && $to=='playerInventory'){
## HOUSE REMOVE HELEMAAL BEGIN

	$remove2housemuch=$move;
	$houseid=0;
	$sql = "SELECT ID,slots FROM buildings WHERE type='house' && username='$S_user' && location='$S_location' LIMIT 1";
	$resultaat = mysqli_query($mysqli,$sql);
	while ($record = mysqli_fetch_object($resultaat))
	{
	 $houseslots=$record->slots;
	 $houseid=$record->ID;
	}
	if($houseid==0){
		echo"&&&messagePopup(\"You have no house at this location!\", \"House item transfer error\");";
		exit();
	}

	$name='';
   	$sql = "SELECT NR, name,much,type, itemupgrade, upgrademuch FROM houses WHERE ID='$houseid' && NR='$itemID' LIMIT 1";
   	$resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
	 	$NR=$record->NR;
		$name=$record->name;
		$much=$record->much;
		$type=$record->type;
		$upgrade=$record->itemupgrade;
		$upgrademuch=$record->upgrademuch;
	}

	if($name && $remove2housemuch>=1 && is_numeric($remove2housemuch)){


		if($remove2housemuch>=$much){
			$remove2housemuch=$much;
			mysqli_query($mysqli,"DELETE FROM houses WHERE NR='$NR' LIMIT 1") or die(mail('support@syrnia.com', 'Syrnia Error (finding invis. items)', $mysqli->error));
		}else{
			mysqli_query($mysqli,"UPDATE houses SET much=much-'$remove2housemuch' WHERE NR='$NR' LIMIT 1") or die(mail('support@syrnia.com', 'Syrnia Error (finding invis. items)', $mysqli->error));
		}


		$slotsused=0;
		$sql = "SELECT much FROM houses WHERE ID='$houseid'";
		$resultaat = mysqli_query($mysqli,$sql);
		while ($record = mysqli_fetch_object($resultaat))
		{
			$slotsused=$slotsused+$record->much;
		}
		$slotsfree=$houseslots-$slotsused;



		$newID = addItem($S_user, $name, $remove2housemuch, $type, $upgrade, $upgrademuch, 0);

		echo $newID;
		echo"&&&$('houseSlots').innerHTML=\"$slotsfree\";";
	}
}

?>