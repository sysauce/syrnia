<?
if(defined('AZtopGame35Heyam')){

$output.="<div style=\"border: 0pt none ; overflow: auto; width: 100%; height: 400\"/>";

$realAction = $action;

//Cancel a trade OR delete a trade after completion
if($var1=='cancelTrade'){
  	$sql = "SELECT ID, username, action, action2, trade, accept1, accept2 FROM tradingpost WHERE username='$S_user'  && location='$S_location' LIMIT 1";
   	$resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
	 	$trade=$record->trade;
	}
	mysqli_query($mysqli,"UPDATE tradingpost SET action='', action2='', accept1='', accept2='', trade='' WHERE username='$S_user' LIMIT 1") or die("err2or --> trade1");
    mysqli_query($mysqli,"DELETE FROM tradingpostitems WHERE trade='$trade'") or die("error report this bug pleaseMESSAGE");
}

//Update trade time OR insert new trade
$time=time();
$resultaaat = mysqli_query($mysqli, "SELECT username FROM tradingpost WHERE location='$S_location' && username='$S_user' LIMIT 1");
$aantal = mysqli_num_rows($resultaaat);
if($aantal==1){
	mysqli_query($mysqli,"UPDATE tradingpost SET lastaction='$time' WHERE username='$S_user' && location='$S_location' LIMIT 1") or die("err2or --> trade2");
}else{
	$sql = "INSERT INTO tradingpost (username, lastaction, location)
	  VALUES ('$S_user', '$time', '$S_location')";
	mysqli_query($mysqli,$sql) or die("error report this bug please: trade Bug124");
}
mysqli_query($mysqli,"UPDATE users SET work='', worktime='', dump='', dump2='' WHERE username='$S_user' LIMIT 1") or die("err2or --> trade3");



//Accept a trade
if($var1=='acceptTrade' && $var2>0){
   $resultaat = mysqli_query($mysqli,"SELECT ID, username, action, action2 FROM tradingpost WHERE username='$S_user'  && location='$S_location' LIMIT 1");
   while ($record = mysqli_fetch_object($resultaat))
   {
   	$action=$record->action;
   }
   //The own user cant be trading already
	if($action<>'trading'){
		//Check if the other player exists and wants to trade
	   	$resultaat = mysqli_query($mysqli,"SELECT ID, username, action, action2 FROM tradingpost WHERE ID='$var2' && action='request' && location='$S_location' LIMIT 1");
	    while ($record = mysqli_fetch_object($resultaat))
		{
		    while(!is_numeric($randtrade)){
		    	$randtrade=rand(1,2147483647);
		    	$resultaaat = mysqli_query($mysqli, "SELECT ID FROM tradingpost WHERE trade='$randtrade' LIMIT 1");
				$aantal = mysqli_num_rows($resultaaat);
				if($aantal>0){
					$randtrade='';
				}
		    }
			mysqli_query($mysqli,"UPDATE tradingpost SET action='trading', action2='$record->username', trade='$randtrade' WHERE username='$S_user' && location='$S_location' LIMIT 1") or die("err2or --> trade4");
			mysqli_query($mysqli,"UPDATE tradingpost SET action='trading', action2='$S_user', trade='$randtrade' WHERE username='$record->username' && location='$S_location' LIMIT 1") or die("err2or --> trade5");
			$output.="Trade accepted...<br />";
		}
	 }
}

//Load info if the current user is main-trader
  $sql = "SELECT ID, username, action, action2, trade, accept1, accept2 FROM tradingpost WHERE username='$S_user'  && location='$S_location' LIMIT 1";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
	 $action=$record->action;
	 $action2=$record->action2;
	 $trade=$record->trade;
	 $accept1=$record->accept1;
	 $accept2=$record->accept2;
	}

//Load info if the current user is not the main-trader
  $sql = "SELECT ID, username, action, action2, trade, accept1, accept2 FROM tradingpost WHERE username='$action2'  && location='$S_location' && trade='$trade' && action2='$S_user' && action='trading' LIMIT 1";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
	 $thereIsAnotherTrader=1;
	 $accept12=$record->accept1;
	 $accept22=$record->accept2;
	}


//Start trade refresher
  echo"if(updatingTrade!=1){";
  echo"updatingTrade=1;";
  echo"setTimeout(\"tradingRefresher()\",3000);";
  echo"}";


########################
//No trade yet
if(!is_numeric($trade) || $trade==0){ //$action=='trading' &&



  $output.="<h2 id=tradingStage>Trading 1/4</h2><br/>";

	if($var1=='requestTrade' && $var2>0){
	  $sql = "SELECT ID, username, action, action2 FROM tradingpost WHERE ID='$var2' && location='$S_location' LIMIT 1";
	   $resultaat = mysqli_query($mysqli,$sql);
	    while ($record = mysqli_fetch_object($resultaat))
		{
		mysqli_query($mysqli,"UPDATE tradingpost SET action='request', action2='$record->username' WHERE username='$S_user' && location='$S_location' LIMIT 1") or die("err2or --> trade6");
		$output.="<b>Trade request sent to $record->username, waiting for their reply...</b><BR><BR>";
	 	}
	}

	if($action=='request' OR $tradingre>0){
	 	$output.="You are requesting a trade.....";
	}


	 $sql = "DELETE FROM tradingpost WHERE lastaction<($time-120)";
	mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE");

	$output.="<table>";
	$sql = "SELECT ID, username, action, action2 FROM tradingpost WHERE username<>'$S_user' && location='$S_location' ORDER BY username asc";
	$resultaat = mysqli_query($mysqli,$sql);
	while ($record = mysqli_fetch_object($resultaat))
	{
		$oth=1;
		if($record->action=='request' && $record->action2<>$S_user){
		 	$output.="<tr><td>$record->username <td><font color=red>$record->username is already attempting to trade someone else.</font>";
		}elseif($record->action=='request' && $record->action2==$S_user){
		  	$output.="<tr><td>$record->username <td><font color=green>wants to trade with you, <a href='' onclick=\"locationText('tradingpost', 'acceptTrade', '$record->ID');return false;\">accept</a></font>";
		}elseif($record->action=='trading'){
		 	$output.="<tr><Td>$record->username <td><font color=red>$record->username is trading with $record->action2.</font>";
		}elseif($action2==$record->username){
		 	$output.="<tr><Td>$record->username <td><font color=red>You are requesting to trade.</font>";
		}else{
		 	$output.="<tr><Td>$record->username<td> <a href='' onclick=\"locationText('tradingpost', 'requestTrade', '$record->ID');return false;\">Trade</a>.";
		}
	}
	$output.="</table>";
	if($oth==''){
	 	$output.="There are no other players to trade with.";
	}


}else{
#### EEN TRADE

if($accept2==1 && ($accept22==1 OR $thereIsAnotherTrader!=1)){
## STEP 4/4 BOTH ACCEPTED, DO ACTUAL TRADE
#############
	 $output.="<h2 id=tradingStage>Trading 4/4</h2><br/>";

	  $sql = "SELECT username, action2 FROM tradingpost WHERE trade='$trade' ORDER BY ID ASC LIMIT 1";
	   $resultaat = mysqli_query($mysqli,$sql);
	    while ($record = mysqli_fetch_object($resultaat))
		{
		 $beginuser=$record->username;
		 $otheruser=$record->action2;
		 }
	$check=1;
	if($beginuser==$S_user){ ## If this user is main-trader, transfer items


		$sql = "SELECT ID, username, name, much, type, itemupgrade, upgrademuch FROM tradingpostitems WHERE trade='$trade' && username='$beginuser' && much>0";


		$resultaat = mysqli_query($mysqli,$sql);
		while ($record = mysqli_fetch_object($resultaat))
		{
		 	$much=0;
			if($record->name=='Gold'){
			  $saql = "SELECT gold FROM users WHERE username='$beginuser' LIMIT 1";
			   $resultaaat = mysqli_query($mysqli,$saql);
			    while ($rec = mysqli_fetch_object($resultaaat)) { $much=$rec->gold;}
			} else{
			  	$saql = "SELECT much FROM items_inventory WHERE username='$beginuser' && type='$record->type' && name='$record->name' && itemupgrade='$record->itemupgrade' && upgrademuch='$record->upgrademuch' LIMIT 1";
			   	$resultaaat = mysqli_query($mysqli,$saql);
			    while ($rec = mysqli_fetch_object($resultaaat)) {  $much=$rec->much;}
			}
			if($much<$record->much){
				$check=0;
			}
		}

		//check user 2
		$sql = "SELECT ID, username, name, much, type, itemupgrade, upgrademuch FROM tradingpostitems WHERE trade='$trade' && username='$otheruser' && much>0";
		$resultaat = mysqli_query($mysqli,$sql);
		while ($record = mysqli_fetch_object($resultaat))
		{
			if($record->name=='Gold'){
			  $saql = "SELECT gold FROM users WHERE username='$otheruser' LIMIT 1";
			   $resultaaat = mysqli_query($mysqli,$saql);
			    while ($rec = mysqli_fetch_object($resultaaat)) { $much=$rec->gold;}
			} else{
			  	$saql = "SELECT much FROM items_inventory WHERE username='$otheruser' && type='$record->type' && name='$record->name' && itemupgrade='$record->itemupgrade' && upgrademuch='$record->upgrademuch' LIMIT 1";
			   	$resultaaat = mysqli_query($mysqli,$saql);
			    while ($rec = mysqli_fetch_object($resultaaat)) {  $much=$rec->much;}
			}
			if($much<$record->much){
				$check=0;
			}
		}

	} # BEGINUSER
	if($check==1){


	if($beginuser==$S_user){
	###ZLOG
	$tekst='';
	  $sql = "SELECT ID, username, name, much, type,itemupgrade, upgrademuch FROM tradingpostitems WHERE trade='$trade' ORDER BY username asc, name asc";
	   $resultaat = mysqli_query($mysqli,$sql);
	    while ($record = mysqli_fetch_object($resultaat))
		{
		$tekst="$record->username: $record->much $record->name ($record->upgrademuch $record->itemupgrade)<BR>$tekst";
		}

		if($tekst<>''){
			$readableDate= date("d-m-Y H:i");
		 $sqal = "INSERT INTO zlogs (titel, tekst)
		         VALUES ('Trading $S_user - $action2', '$tekst generated by $S_user at $readableDate, trade ID $trade time=$time')";
		      mysqli_query($mysqli,$sqal) or die("erroraa report this 2 bug 32zz");
		}
		####ZLOG


		  $sql = "SELECT ID, username, name, much, type, itemupgrade, upgrademuch FROM tradingpostitems WHERE trade='$trade'";
		   $resultaat = mysqli_query($mysqli,$sql);
		    while ($record = mysqli_fetch_object($resultaat))
			{
				if($record->username==$S_user){$ander=$action2; } else{ $ander=$S_user; }
				if($record->name=='Gold'){
					mysqli_query($mysqli,"UPDATE users SET gold=gold+'$record->much' WHERE username='$ander' LIMIT 1") or die("err2or --> G 1");
					mysqli_query($mysqli,"UPDATE users SET gold=gold-'$record->much' WHERE username='$record->username' LIMIT 1") or die("err2or -->  G2");
				}else{
				 	//...
					mysqli_query($mysqli,"UPDATE items_inventory SET much=much-'$record->much' WHERE username='$record->username' && name='$record->name' && itemupgrade='$record->itemupgrade' && upgrademuch='$record->upgrademuch' ORDER BY MUCH DESC LIMIT 1") or die("err2or --> tr dm1");
					//... delete much<=0 below!

					$resultaaaaat = mysqli_query($mysqli,"SELECT username FROM items_inventory WHERE username='$ander' && name='$record->name' && type='$record->type' && itemupgrade='$record->itemupgrade' && upgrademuch='$record->upgrademuch' LIMIT 1");
					$aantal = mysqli_num_rows($resultaaaaat);
					if($aantal==1){
						mysqli_query($mysqli,"UPDATE items_inventory SET much=much+'$record->much' WHERE username='$ander' && name='$record->name' && itemupgrade='$record->itemupgrade' && upgrademuch='$record->upgrademuch' LIMIT 1") or die("err2or --> ul1");
					}else{
					 	$sqal = "INSERT INTO items_inventory (username, name, much, type, itemupgrade, upgrademuch)
					         VALUES ('$ander', '$record->name', '$record->much', '$record->type', '$record->itemupgrade', '$record->upgrademuch')";
						mysqli_query($mysqli,$sqal) or die("erroraa report this bug 1453");
					}
				}
				$sqal = "DELETE FROM tradingpostitems WHERE ID='$record->ID' LIMIT 1";
				mysqli_query($mysqli,$sqal) or die("error report this bug pleaseMESSAGE");
			}
			mysqli_query($mysqli,"DELETE FROM items_inventory WHERE much<=0 && (username='$beginuser' OR username='$otheruser')") or die("err2or --> iibo1");




		$sql = "DELETE FROM tradingpostitems WHERE trade='$trade'";
		mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE");

		mysqli_query($mysqli,"UPDATE tradingpost SET action='', action2='', accept1='', accept2='', trade='' WHERE username='$S_user' LIMIT 1") or die("err2or --> reb1");

    	//Rebuilds inventory
		include('rebuildInventory.php');

    			$saql = "SELECT gold FROM users WHERE username='$S_user' LIMIT 1";
			$resultaaat = mysqli_query($mysqli,$saql);
			while ($rec = mysqli_fetch_object($resultaaat)) { $goldAmount=$rec->gold;}
			echo"$('statsGoldText').innerHTML=parseInt($goldAmount);";

		$output.="The trade has been successful!<BR>";
		$output.="<a href='' onclick=\"locationText('tradingpost', 'cancelTrade');return false;\">Click here to continue</a>";
	} else {## User is not main-trader

		$resultaaaaat = mysqli_query($mysqli," SELECT ID FROM tradingpostitems WHERE trade='$trade'  LIMIT 1");
		$aantal = mysqli_num_rows($resultaaaaat);
		if($aantal){
			$output.="Waiting for the other user to complete the trade...<br />
			This text is automaticly reloading when the trade is complete.<br />";
			//RELOADS
		}else{
			 //Rebuilds inventory
			include('rebuildInventory.php');

			$saql = "SELECT gold FROM users WHERE username='$S_user' LIMIT 1";
			$resultaaat = mysqli_query($mysqli,$saql);
			while ($rec = mysqli_fetch_object($resultaaat)) { $goldAmount=$rec->gold;}
			echo"$('statsGoldText').innerHTML=parseInt($goldAmount);";

			$output.="The trade has been successful!<br />";
			$output.="<a href='' onclick=\"locationText('tradingpost', 'cancelTrade');return false;\">Click here to continue</a>";
		}
	}

	}else{
	 	$sql = "DELETE FROM tradingpostitems WHERE trade='$trade'";
	    mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE");
		mysqli_query($mysqli,"UPDATE tradingpost SET action='', action2='', accept1='', accept2='', trade='' WHERE username='$S_user' LIMIT 1") or die("err2or --> step1");
    	$output.="The trade has been cancelled, one of the users changed his inventory during the trade:<br />Maybe one of you has been thieved during the trade and now does not have enough gold left to trade.<br />";
	}

}else if($accept1==1 && $accept12==1){
## STAP 3/4 CHECK THE TRADE SCREEN, ACCEPT CONFIRM
#############
 $output.="<h2 id=tradingStage>Trading 3/4</h2><br/><center>";
$output.="Both accepted, please confirm the trade below.<br /><Table width=100%><tr valign=top><Td><B>$S_user<td><B>$action2<tr valign=top><td>";

  $sql = "SELECT name, much, itemupgrade, upgrademuch FROM tradingpostitems WHERE trade='$trade' && much>0 && username='$S_user' order by name asc";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
		$upg=''; if($record->itemupgrade){ $upg="[$record->upgrademuch $record->itemupgrade]";}
		$output.="$record->much $record->name $upg<BR>";
	}

	$output.="<td>";
  	$sql = "SELECT name, much, itemupgrade, upgrademuch FROM tradingpostitems WHERE trade='$trade' && much>0 && username='$action2' order by name asc";
   	$resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
		$upg=''; if($record->itemupgrade){ $upg="[$record->upgrademuch $record->itemupgrade]";}
		$output.="$record->much $record->name $upg<BR>";
	}
	$output.="</table><BR><center>";

	if($var1=='acceptTradeConfirm'){
		mysqli_query($mysqli,"UPDATE tradingpost SET accept2=1 WHERE username='$S_user' LIMIT 1") or die("err2or --> atc1");
		$accept2=1;
	}

	if($accept2==1){
		$output.="You have accepted the trade, waiting for $action2...<br />";
		//RELOADS
	} else{
		$output.="<a href='' onclick=\"locationText('tradingpost', 'acceptTradeConfirm');return false;\">Confirm trade</a>";
		if($accept22==1){ $output.=" ($action2 has confirmed the trade.)"; }
	}

	$output.=" - <a href='' onclick=\"locationText('tradingpost', 'cancelTrade');return false;\">Cancel the trade</a>";


} else{
### STAP 2/4 - TRADE ITEMS
#############
if($thereIsAnotherTrader!=1){
	$output.="$action2 has cancelled the trade.";

	mysqli_query($mysqli,"UPDATE tradingpost SET action='', action2='', accept1='', accept2='', trade='' WHERE username='$S_user' LIMIT 1") or die("err2or --> 2.41");
	$sql = "DELETE FROM tradingpostitems WHERE username='$S_user'";
	mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE");

}else{
 $output.="<h2 id=tradingStage>Trading 2/4</h2><br/><center>";
## CANCEL

if($var1=='acceptTrade1'){
	mysqli_query($mysqli,"UPDATE tradingpost SET accept1=1 WHERE username='$S_user'  LIMIT 1") or die("err2or --> at1 1");
	$accept1=1;
}


## ADD ITEMS TO TRADE
$addno = 1;
$mucho=round($var3);
if($var1=='addItems' && $var2 && $mucho>0 && $accept12==0 && $accept1==0){
	$addno = $mucho;
	if($var2=='Gold'){
	    $sql = "SELECT gold FROM users WHERE username='$S_user' LIMIT 1";
	    $resultaat = mysqli_query($mysqli,$sql);
	    while ($record = mysqli_fetch_object($resultaat))
		{
			if($mucho>$record->gold){$mucho=$record->gold; }

			       $sqal = "SELECT name, much FROM tradingpostitems WHERE username='$S_user' && trade='$trade' && name='Gold' LIMIT 1";
			       $resultaaat = mysqli_query($mysqli,$sqal);
			       while ($rec = mysqli_fetch_object($resultaaat)) {  $muchalready=$rec->much; }

			if($muchalready){
				if(($muchalready+$mucho)>$record->gold){$mucho=$record->gold-$muchalready;}
				if($mucho>0){
					mysqli_query($mysqli,"UPDATE tradingpostitems SET much=much+'$mucho' WHERE name='Gold' && trade='$trade' && username='$S_user' LIMIT 1") or die("err2or --> muo 1");
				}
			}else{
				$sql = "INSERT INTO tradingpostitems (username, name, trade, much, type)
			  	VALUES ('$S_user', 'Gold', '$trade', '$mucho', 'gold')";
				mysqli_query($mysqli,$sql) or die("error report this bug please33 66 msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");
			}
			$output.="<b>$mucho Gold added</b>.<BR>";
		}
	}else{
	       $sql = "SELECT ID,name,much,itemupgrade,upgrademuch, type FROM items_inventory WHERE ID='$var2' && type<>'quest' && username='$S_user' LIMIT 1";
	       $resultaat = mysqli_query($mysqli,$sql);
	       while ($record = mysqli_fetch_object($resultaat))
		   {
		      	$sqal = "SELECT ID,name,much,itemupgrade,upgrademuch, type FROM tradingpostitems WHERE name='$record->name' && itemupgrade='$record->itemupgrade' && upgrademuch='$record->upgrademuch' && username='$S_user' && much>0 && trade='$trade' LIMIT 1";
		       	$resultat = mysqli_query($mysqli,$sqal);
		       	while ($rec = mysqli_fetch_object($resultat))
			   	{
					$else="no";
					if(($mucho+$rec->much)>$record->much){$mucho=$record->much-$rec->much; }
					if($mucho>0 && is_numeric($mucho)){
						mysqli_query($mysqli,"UPDATE tradingpostitems SET much=much+'$mucho' WHERE name='$record->name' && itemupgrade='$record->itemupgrade' && upgrademuch='$record->upgrademuch' && trade='$trade' && username='$S_user' && much>0 LIMIT 1") or die("err2or --> mhrn 1");
						$output.="<b>$mucho $record->name added</b>.<BR>";
					}
				}

				if($else<>'no'){
					if($mucho>$record->much){$mucho=$record->much; }
					if($mucho>0){
					$sql = "INSERT INTO tradingpostitems (username, name, trade, much, type, itemupgrade, upgrademuch)
					  VALUES ('$S_user', '$record->name', '$trade', '$mucho', '$record->type', '$record->itemupgrade', '$record->upgrademuch')";
					mysqli_query($mysqli,$sql) or die("error report this bug please33 66 msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");
					$output.="<b>$mucho $record->name added</b>.<BR>";
					}
				}
		}
	}
}


###### REMOVING
################
$remno = 1;
$removeo=$var2;
$mucho=round($var3);
if($var1=='removeItems' && $removeo && $mucho>0 && is_numeric($mucho) && $accept12==0 && $accept1==0){
	$remno = $mucho;
	$sql = "SELECT ID,name,much,itemupgrade,upgrademuch, type FROM tradingpostitems WHERE ID='$removeo' && username='$S_user'";
	$resultaat = mysqli_query($mysqli,$sql);
	while ($record = mysqli_fetch_object($resultaat))
	{
		if($mucho>=$record->much){
		 	$sql = "DELETE FROM tradingpostitems WHERE ID='$removeo' && username='$S_user'";
		     mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE");
		}else{
		 	mysqli_query($mysqli,"UPDATE tradingpostitems SET much=much-'$mucho' WHERE ID='$removeo' && username='$S_user' && much>0 LIMIT 1") or die("err2or --> mq 1");
		}
	}
}

if($var1=='changeTrade'){
	mysqli_query($mysqli,"UPDATE tradingpost SET accept1=0 WHERE username='$action2' OR username='$S_user' LIMIT 2") or die("err2or --> tp 1");
	$accept1=0;
	$accept12=0;
}

if($var1=='acceptTrade1' OR $accept1){
	  $sql = "SELECT ID, username, name, much, itemupgrade, upgrademuch FROM tradingpostitems WHERE trade='$trade'";
	   $resultaat = mysqli_query($mysqli,$sql);
	    while ($record = mysqli_fetch_object($resultaat))
		{
			$check=0;
			if($record->name=='Gold'){
				$saql = "SELECT gold FROM users WHERE username='$record->username' && gold>=$record->much LIMIT 1";
			   	$resultaaat = mysqli_query($mysqli,$saql);
			    while ($rec = mysqli_fetch_object($resultaaat)) { $check=1;}
			}else{
			  	$saql = "SELECT much FROM items_inventory WHERE username='$record->username' && much>=$record->much && name='$record->name' && itemupgrade='$record->itemupgrade' && upgrademuch='$record->upgrademuch' LIMIT 1";
			   	$resultaaat = mysqli_query($mysqli,$saql);
			    while ($rec = mysqli_fetch_object($resultaaat)) { $check=1;}
			}
			if($check!=1){
			 	$sql = "DELETE FROM tradingpostitems WHERE ID='$record->ID'";
			     mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE");
				$output.="Please check the trade screen carefully!<BR>";
			}
	}
	$output.="You have accepted the trade, waiting for $action2...";
	//RELOAD
}else{
	$output.="<a href='' onclick=\"locationText('tradingpost', 'acceptTrade1');return false;\">Accept trade</a>";
}
$output.=" - <a href='' onclick=\"locationText('tradingpost', 'cancelTrade');return false;\">Cancel the trade</a><br /><br />";
	if($accept12==1){
	 	$output.=" $action2 has accepted the trade. <a href='' onclick=\"locationText('tradingpost', 'changeTrade');return false;\">Change trade</a><br /><br/>";
	}else if($accept1==1){
		$output.= "<a href='' onclick=\"locationText('tradingpost', 'changeTrade');return false;\">Change trade</a><br/><br/>";
	}


		$contentsMy='<table>';
	  	$sql = "SELECT ID, name, much, itemupgrade, upgrademuch FROM tradingpostitems WHERE trade='$trade' && much>0 && username='$S_user' order by name asc";
	   	$resultaat = mysqli_query($mysqli,$sql);
	    while ($record = mysqli_fetch_object($resultaat))
		{
			$id = $record->ID;
			$upg=''; if($record->itemupgrade){ $upg="[$record->upgrademuch $record->itemupgrade]";}
			$contentsMy.="<tr><td><a href=\"\" onclick=\"locationText('tradingpost', 'removeItems', $id, $('removeMuchTradeItems').value);return false;\"><img src=\"images/inventory/$record->name.gif\"></a></td><td>$record->name $upg<br />$record->much</td></tr>";
		}
		$contentsMy.='</table>';

		$contentsHim='<table>';
	  	$sql = "SELECT ID, name, much, itemupgrade, upgrademuch FROM tradingpostitems WHERE trade='$trade' && much>0 && username='$action2' order by name asc";
	   $resultaat = mysqli_query($mysqli,$sql);
	    while ($record = mysqli_fetch_object($resultaat))
		{
			$upg=''; if($record->itemupgrade){ $upg="[$record->upgrademuch $record->itemupgrade]";}
			$contentsHim.="<tr><td><img src=\"images/inventory/$record->name.gif\"></td><td>$record->name $upg<br />$record->much</td></tr>";
		}
		$contentsHim.='</table>';

		### ADD
#########
if($accept12==0 && $accept1==0){
	$output.="<B>Add your items</b><BR><br/>Use the add button below or click on items from your inventory<br/>";
	$output.="<select id=addTradeItemID length=60 class=button>";


	       $sql = "SELECT gold FROM users WHERE username='$S_user' && gold>0";
	       $resultaat = mysqli_query($mysqli,$sql);
	       while ($record = mysqli_fetch_object($resultaat)) {  $output.="<option value='Gold'>Gold ($record->gold)";     }

	       $sql = "SELECT ID,name,much,itemupgrade,upgrademuch FROM items_inventory WHERE username='$S_user' && type<>'quest'  ORDER BY name asc";
	       $resultaat = mysqli_query($mysqli,$sql);
	       while ($record = mysqli_fetch_object($resultaat)) {
	$plus=''; if($record->upgrademuch>0){$plus="+"; }
	$upg=''; if($record->itemupgrade){ $upg="[$plus$record->upgrademuch $record->itemupgrade]";}
	$output.="<option value='$record->ID'>$record->name($record->much) $upg";     }
	$output.="</select><input type=text id=addMuchTradeItems value=$addno size=3 class=input><input type=submit value=Add class=button onclick=\"locationText('tradingpost', 'addItems', $('addTradeItemID').value,$('addMuchTradeItems').value);return false;\">";


### REMOVE
	#############
	$output.="<br/><br/><b>Remove your items</b><br />";
	$output.="<select id=removeTradeItemID length=60 class=button>";
	       $sql = "SELECT ID,name,much,itemupgrade,upgrademuch FROM tradingpostitems WHERE username='$S_user' && much>0 ORDER BY name asc";
	       $resultaat = mysqli_query($mysqli,$sql);
	       while ($record = mysqli_fetch_object($resultaat)) {
	$plus=''; if($record->upgrademuch>0){$plus="+"; }
	$upg=''; if($record->itemupgrade){ $upg="[$plus$record->upgrademuch $record->itemupgrade]";}
	$output.="<option value='$record->ID'>$record->name($record->much) $upg";     }
	$output.="</select><input type=text id=removeMuchTradeItems value=$remno size=3 class=input><input type=submit value=Remove class=button onclick=\"locationText('tradingpost', 'removeItems', $('removeTradeItemID').value,$('removeMuchTradeItems').value);return false;\">";
} #ACCEPT BLOK


#### Trade screen
$output.="<br /><br /><center><table>";
$output.="<tr valign=top><td width=150><B>$S_user</B><td width=10> </td><td width=150><B>$action2</B></td></tr>";
$output.="<tr valign=top><td  id='myTradeItems'>$contentsMy<td width=10> </td><td id='hisherTradeItems'>$contentsHim</td></tr>";
$output.="</table></center>";
	//RELOAD ITEMS






$output.="</center>";
} # OTHER PLAYER LEFT ?
} #TRADE STAGE 1

} # HAS-TRADE OR NO-TRADE

$action = $realAction;

$output.="</div>";

}
?>