<?
if(defined('AZtopGame35Heyam') && $S_user){




$time=time();
$output.="Welcome to the Cave of trades!<br />";
$output.="Got a rare item you want to sell? You'll get the most gold by selling it here!<br />";
$output.="We charge a small 5% fee if you successfully sell an item.<br />";
$output.="If we are successfully running our Cave of trades we will expand to more locations in the world of Syrnia.<br />";
$output.="<i>- Ogre Trendus</i><br />";
$output.="<br />";



$output.="<br /><center>";
$output.="<a href='' onclick=\"locationText('auction');return false;\">Show auctions</a> - <a href='' onclick=\"locationText('auction', 'addauction');return false;\">Add an auction</a> -  <a href='' onclick=\"locationText('auction', 'show');return false;\">Show my auctions and bids</a></center><br />";

if($var1=='type'){
	$type=$var2;
}
if($var3=='order'){
	$order=$var4;
}
if($var1=='bid'){
 	$newid=$var2;
	$newbid=$var3;
}

if($newbid>0 && is_numeric($newbid) && $newid>0){##### NEWBID
#######################
	$saql = "SELECT gold FROM users WHERE username='$S_user' LIMIT 1";
	$resultaaat = mysqli_query($mysqli,$saql);
	while ($record = mysqli_fetch_object($resultaaat)) { $gold=$record->gold; }

	$saql = "SELECT much, name, bidder, bid FROM auctions WHERE ID='$newid' && seller!='$S_user' && time>$timee LIMIT 1";
	$resultaaat = mysqli_query($mysqli,$saql);
	while ($record = mysqli_fetch_object($resultaaat))
	{
		$currentbid=$record->bid;
		$resultaaaat = mysqli_query($mysqli,"SELECT ID FROM auctions WHERE bidder='$S_user'");
		$aantal = mysqli_num_rows($resultaaaat);   $maxbids=ceil($tradingl/5)+2;
		if($aantal<$maxbids){
		if($newbid>=ceil($currentbid*1.01)){
		if($gold>=$newbid){
			payGold($S_user, $newbid);

			if($record->bidder){
				mysqli_query($mysqli,"UPDATE users SET gold=gold+'$record->bid'  WHERE username='$record->bidder' LIMIT 1") or die("UPd' a");
				$resultaaXat = mysqli_query($mysqli,"SELECT gold FROM users WHERE username='$record->bidder' LIMIT 1");
				while ($rec = mysqli_fetch_object($resultaaXat)) { $newGold=$rec->gold; }
				$saaql = "INSERT INTO messages (username, sendby, message, topic, time)
				  VALUES ('$record->bidder', '<B>Syrnia</B>', 'An Cave of trades runner tells you:<br />
				  <i>Someone has placed a higher bid on the $record->much $record->name you bid for.<br />
				  Here\'s your gold!</i><br />
				  You got your bid of $record->bid gold back. You now have $newGold gold. It can take up to 15 minutes for the gold to appear.<br />', 'Cave of trades', '$time')";     		mysqli_query($mysqli,$saaql) or die("D  1IE 2");

			}

			$goldleft=$gold-$newbid;
			echo"$('statsGoldText').innerHTML=\"$goldleft\";";
			mysqli_query($mysqli,"UPDATE auctions SET bid='$newbid', bidder='$S_user'  WHERE ID=$newid LIMIT 1") or die("Ua B");
			$tekst="You successfully bid $newbid gold for the $record->much $record->name.<br />";
		}else{$tekst="You do not have enough gold to bid $newbid. You only have $gold gold.<br />";}
		}else{$tekst="You should bid at least 1% more than the current bid ($currentbid), at least bid: ".ceil($currentbid*1.01).".<br />";}
		}else{$tekst="You have already bid on $aantal items, with your trading level you can bid on $maxbids auctions at once.<br />";}

		$output.="<table cellpadding=10 width=100%><tr valign=top><td bgcolor=550000 height=20><B><center>$tekst</table>";
	}## AUCTION MYSQL
}# NEWBID
##########################

$maxStartPrice=ceil((pow($tradingl, 3.2)+400)/500)*500;
//5: 1000
//10: 2000
//25: 30500
//50: 274000
//100: 2512500


if($var1=='addauction'){
##### ADD AUCTION
	$resultaaat = mysqli_query($mysqli,"SELECT ID FROM auctions WHERE seller='$S_user'");
	$aantalAuctions = mysqli_num_rows($resultaaat);
	$maxbids=ceil($tradingl/5)+1;

	$additem=$var2;
	$addmuch=$var3;
	$addprice=$var4;
	$addtime=$var5;

	if($additem>0 && $addmuch>0 && is_numeric($addmuch) && is_numeric($addprice) && $addprice>0 && ($addtime==6 OR $addtime==12 OR $addtime==24 OR $addtime==48)){
	 if($aantalAuctions<$maxbids){

		if($addprice<=$maxStartPrice){
			$saql = "SELECT ID, name, much, type, itemupgrade, upgrademuch FROM items_inventory WHERE username='$S_user' && type<>'quest' && ID='$additem' LIMIT 1";
		    $resultaaat = mysqli_query($mysqli,$saql);
		    while ($record = mysqli_fetch_object($resultaaat))
			{
			   	if($addmuch>=$record->much){$addmuch=$record->much;}
			    if($S_donation>0){$don=1;}else{$don=0;}   $aucttime=time()+3600*$addtime;

				$sql = "INSERT INTO auctions (seller, bid, type, name, much, itemupgrade, upgrademuch, time, donator, pickupLocation)
		  		VALUES ('$S_user', '$addprice', '$record->type', '$record->name', '$addmuch', '$record->itemupgrade', '$record->upgrademuch', '$aucttime', '$don', '$S_location')";
				mysqli_query($mysqli,$sql) or die("D1221IE  $sql");

				removeItem($S_user, $record->name, $addmuch, $record->itemupgrade, $record->upgrademuch, 1);
				$tekst="Your auction has been added";
		     	$aantalAuctions++;
			}
		}else{
		 	$tekst="The minimum bid price cannot be more than $maxStartPrice gold, please add the item again.<br />";
		}
     }else{
	  	$tekst="You cannot add any more auctions, you are have $aantalAuctions/$maxbids running.<br />";
	}
    if($output==''){
	  	$tekst="Error; you do not have that item, doh!<br />";
	}
    $output.="<table cellpadding=10 width=100%><tr valign=top><td bgcolor=5500005 height=20><B><center>$tekst</table>";

	}else{
		$output.="<table cellpadding=10 width=100%><tr valign=top><td bgcolor=5500005 height=20><B><center>$tekst</table>";

	}
		$output.="<table cellpadding=10 width=100%><tr valign=top><td bgcolor=550000 width=150>You have got $aantalAuctions/$maxbids auctions at the moment.<br />";
		$output.="<br /><small>Because of your trading level you can set the minimum bid to max. $maxStartPrice gold. Increase your trading level to increase the minimum bid amount.</small><br />";
		$output.="<td width=10><td bgcolor=440000><br /><font color=white><B>Add an auction</B><br /><br />";
	if($aantalAuctions<$maxbids){
		$output.="<br /><br />";
		$output.="";
		$output.="<form action='#' onsubmit=\"locationText('auction', 'addauction', $(auctionAddItem).value, $(auctionAddMuch).value,  $(auctionAddPrice).value, $(auctionAddTime).value  );return false;\"><table><tr><td>Item<td><select id=auctionAddItem><option value='' selected>";
		     $saql = "SELECT ID, name, much, itemupgrade, upgrademuch FROM items_inventory WHERE username='$S_user' && type<>'quest' && type<>'quest item' order by name asc";
	    $resultaaat = mysqli_query($mysqli,$saql);
	     while ($record = mysqli_fetch_object($resultaaat)) {
	          $plus=''; if($record->upgrademuch>0){$plus="+"; } $upg=''; if($record->itemupgrade){ $upg="[$plus$record->upgrademuch $record->itemupgrade]";}
	 $output.="<option value=$record->ID>$record->name $upg";}
		$output.="</select>";
		$output.="<tr><td>Quantity<td><input type=text id=auctionAddMuch>";
		$output.="<tr><td>Starting price<td><input type=text id=auctionAddPrice>";
		$output.="<tr><td>Time<td><select id=auctionAddTime><option value=6>6 Hours<option value=12>12 Hours<option value=24>24 Hours<option value=48>48 Hours</select>";
		$output.="<tr><td><td><input type=submit value=Add>";
		$output.="</table></form>";
}else{
	$output.="You cannot add any more auctions.<br />";
	$output.="With your trading level you can have $maxbids auctions at the same time.<br />";
	$output.="<br />";

	$saql = "SELECT pickupLocation, name FROM auctions WHERE seller='$S_user' && bidder='' && time<'$timee'";
    $resultaaat = mysqli_query($mysqli,$saql);
    while ($record = mysqli_fetch_object($resultaaat))
	{
		$output.="Your <b>$record->name</b> auction expired, you can pickup the item at <b>$record->pickupLocation</b> to be able to add new auctions.<br />";
	}
}


} elseif($var1=='show'){
########## SHOW

$resultaaat = mysqli_query($mysqli,"SELECT ID FROM auctions WHERE seller='$S_user'");
$aantal = mysqli_num_rows($resultaaat);   $maxbids=ceil($tradingl/5)+1;

$resultaaat = mysqli_query($mysqli,"SELECT ID FROM auctions WHERE bidder='$S_user'");
$aantal2 = mysqli_num_rows($resultaaat);   $maxbids2=ceil($tradingl/5)+2;


		$output.="<table cellpadding=10 width=100%><tr valign=top><td bgcolor=550000 width=150><br />";
		$output.="<A href='' onclick=\"locationText('auction', 'show', 'auctions');return false;\">Show auctions</a><br />";
		$output.="<A href='' onclick=\"locationText('auction', 'show', 'bids');return false;\">Show bids</a><br />";
		$output.="<br />";
		$output.="You have got $aantal/$maxbids auctions at the moment.<br />";
		$output.="You bid on $aantal2/$maxbids2 items at the moment.<br />	";
		$output.="<td width=10><td bgcolor=440000><br /><font color=white>";

		if($var2!='bids'){
				$output.="<b>Your auctions:</b><br /><br />";
				$output.="<table><tr><td><B>Item</B><td><B>Bid by</B><td><b>Current bid</B><td><B>Time left</B><td><B>Location</B>";
		 	$sql = "SELECT ID, name, much, bid, time, pickupLocation, seller,type, itemupgrade, upgrademuch, bidder FROM auctions WHERE seller='$S_user' ORder by time ASC";
	   		$resultaat = mysqli_query($mysqli,$sql);
	    	while ($record = mysqli_fetch_object($resultaat))
			{
				$timeleft=ceil(($record->time-time())/3600);

				if($timeleft<=0){
					if($record->bidder=='') //Item was not sold, seller can pick it up
					{
						if($record->pickupLocation==$S_location)
						{
							$aantal = $aantal-1;
							addItem($S_user, $record->name, $record->much, $record->type, $record->itemupgrade, $record->upgrademuch, 1);
							if($record->itemupgrade){
								$upg="($record->upgrademuch $record->itemupgrade)";
							}else{
								$upg='';
							}
							$collects.="<font color=yellow>You collected your $record->name $upg!</font><br />";
							mysqli_query($mysqli,"DELETE from auctions WHERE ID='$record->ID' LIMIT 1") or die("Ua");
						}
						else
						{
							$collectsRemote.="Your <b>$record->name $upg</b> auction expired, you can pickup the item at <b>$record->pickupLocation</b>.<br />";
						}
					}
				}else{
					$output.="<tr bgcolor=440000 align=center valign=middle>";
			        $plus=''; if($record->upgrademuch>0){$plus="+"; } $upg=''; if($record->itemupgrade){ $upg="[$plus$record->upgrademuch $record->itemupgrade]";}
			    	$output.="<td><center><a title=\"$record->much $record->name $upg\"><img src='images/inventory/$record->name.gif' border=0 name=\"$record->much $record->name $upg\"></a><br /><font color=white>$record->much $record->name $upg<td><font color=white>$record->bidder";
			    	$output.="<td><font color=white>$record->bid gold<td>$timeleft hour(s)<td>$record->pickupLocation";
	    		}
			}
	    	$output.="</table><br/><br/>$collects $collectsRemote";
	    		if($aantal == 0){ $output.="<i>You do not run any auctions.</i><br />"; }
			}


	    	if($var2=='bids'){
				$timeleft='';
				$output.="<b>Your running bids:</b><br /><br />";
				$output.="<table><tr><td><B>Item</B><td><B>Sold by</B><td><b>Current bid</B><td><B>Time left</B>";
					 $sql = "SELECT name, much, bid, time, seller, itemupgrade, upgrademuch FROM auctions WHERE bidder='$S_user' ORder by time ASC";
			   $resultaat = mysqli_query($mysqli,$sql);
			    while ($record = mysqli_fetch_object($resultaat))
				{
					$timeleft=ceil(($record->time-time())/3600);
					$output.="<tr bgcolor=550000 align=center valign=middle>";
				    $plus=''; if($record->upgrademuch>0){$plus="+"; } $upg=''; if($record->itemupgrade){ $upg="[$plus$record->upgrademuch $record->itemupgrade]";}
				    $output.="<td><center><a title=\"$record->much $record->name $upg\"><img src='images/inventory/$record->name.gif' border=0 name=\"$record->much $record->name $upg\"></a><br /><font color=white>$record->much  $record->name $upg<td><font color=white>$record->seller";
				    $output.="<td><font color=white>$record->bid gold<td>$timeleft hour(s)";
			    }
	    		$output.="</table>";
	    	if($aantal2 == 0){
			 	$output.="<i>You have no running bids.</i><br />";
			}
			}





}  else{


$output.="<table cellpadding=10 width=100%><tr valign=top><td bgcolor=550000 width=150>";
$output.="<form action='#' onsubmit=\"locationText('auction', 'search', $('searchAuction').value);return false\"><input type=text size=6 id='searchAuction'><input type=submit value=search></form>";
$output.="<br />";
$output.="<B>Tools and weapons:</B><br />";
$output.="<a href='' onclick=\"locationText('auction', 'type', 'hand');return false;\">Tools & Weapons</a><br />";
$output.="<br />";
$output.="<B>Armour:</B><br />";
$output.="<a href='' onclick=\"locationText('auction', 'type', 'body');return false;\">Body armour</a><br />";
$output.="<a href='' onclick=\"locationText('auction', 'type', 'legs');return false;\">Leg armour</a><br />";
$output.="<a href='' onclick=\"locationText('auction', 'type', 'shield');return false;\">Shields</a><br />";
$output.="<a href='' onclick=\"locationText('auction', 'type', 'helm');return false;\">Helms</a><br />";
$output.="<a href='' onclick=\"locationText('auction', 'type', 'shoes');return false;\">Shoes</a><br />";
$output.="<a href='' onclick=\"locationText('auction', 'type', 'gloves');return false;\">Gloves</a><br />";
$output.="<br />";
$output.="<B>Food:</B><br />";
$output.="<a href='' onclick=\"locationText('auction', 'type', 'food');return false;\">Uncooked food</a><br />";
$output.="<a href='' onclick=\"locationText('auction', 'type', 'cooked food');return false;\">Cooked food/Drinks</a><br />";
$output.="<br />";
$output.="<B>Bars and ores:</b><br />";
$output.="<a href='' onclick=\"locationText('auction', 'type', 'bars');return false;\">Bars</a><br />";
$output.="<a href='' onclick=\"locationText('auction', 'type', 'ore');return false;\">Ores</a><br />";
$output.="<br />";
$output.="<B>Boats:</B><br />";
$output.="<a href='' onclick=\"locationText('auction', 'type', 'boat');return false;\">Boat</a><br />";
$output.="<br />";
$output.="<b>Other:</b><br />";
$output.="<a href='' onclick=\"locationText('auction', 'type', 'other');return false;\">Other</a><br />";
$output.="<td width=10><td bgcolor=440000>";



 if($type && ($type=='other' OR $type=='boat' OR $type=='ore' OR $type=='bars' OR $type=='cooked food' OR $type=='food' OR $type=='gloves' OR $type=='shoes' OR $type=='helm' OR $type=='shield' OR $type=='legs' OR $type=='body' OR $type=='hand')){
                                $Queue="type='$type'";
	if($type=='other'){ $Queue="type<>'boat' && type<>'ore' && type<>'bars' && type<>'cooked food' && type<>'food' && type<>'gloves' && type<>'shoes' && type<>'helm' && type<>'shield' && type<>'legs' && type<>'body' && type<>'hand'"; }

	if($order=='bid' OR $order=='seller' OR $order=='name'){ $order=$order; } else{$order='time'; }

	$output.="<table><tr><td><a href='' onclick=\"locationText('auction', 'type', '$type', 'order', 'name');return false;\"><B>Item</B></a><td><a href='' onclick=\"locationText('auction',  'type', '$type','order', 'seller');return false;\"><B>Sold by</B></a>";
	$output.="<td><a href='' onclick=\"locationText('auction',  'type', '$type','order', 'bid');return false;\"><b>Current bid</B></a><td><a href='' onclick=\"locationText('auction',  'type', '$type');return false;\"><B>Time left</B></a>";

	 $sEql = "SELECT ID, name, type,  much, bid, time, seller, donator, itemupgrade, time, upgrademuch FROM auctions WHERE $Queue order by $order asc";
   $resultaEat = mysqli_query($mysqli,$sEql);
    while ($record = mysqli_fetch_object($resultaEat))
	{

    if($record->time>$timee){

	    $timeleft=ceil(($record->time-time())/3600);
		if($record->donator==1){$output.="<tr align=center valign=middle bgcolor=550000>"; }else{$output.="<tr align=center valign=middle>"; }
	    $plus='';
		if($record->upgrademuch>0){$plus="+"; }
		$upg='';
		if($record->itemupgrade){ $upg="[$plus$record->upgrademuch $record->itemupgrade]";}

		$output.="<td><center><a title=\"$record->much $record->name $upg\"><img src='images/inventory/$record->name.gif' border=0 name=\"$record->much $record->name $upg\"></a><br />";
		$output.="<font color=white>$record->much ";
		if($record->donator==1){
		 	$output.="<b>$record->name</b>";
		}else{
			$output.="$record->name";
		}
		$output.="<small>$upg</small><td><font color=white>$record->seller";
	    $output.="<td><font color=white>$record->bid gold<td>$timeleft hour(s)<td bgcolor=440000>";

		if($record->seller!=$S_user){
		 	$output.="<form action='#' onsubmit=\"locationText('auction',  'bid', $record->ID, $('auctionBid$record->ID').value );window.scrollTo(0,0);return false;\"><input type=text id=auctionBid$record->ID class=input size=4 value=".ceil($record->bid*1.01).">";
			$output.="<input type=submit value=Bid class=button ></form>";
		}

    }else{ ## TIMED
    	$thereWasAnOldItem=1;
	    } ## TIMED
    }
	    $output.="</table>";
	    if($timeleft==''){ $output.="There are no auctions in this category.<br />"; }


	    if($thereWasAnOldItem==1){//olditem


	        //BEGIN THIS CODE IS ALSO IN 15 MIN CRON AND AT CAVE OF TRADES AUCTION CODE!
    $swql = "SELECT ID, name, much, type, bid, time, seller, bidder, donator,itemupgrade, time, upgrademuch,pickupLocation FROM auctions WHERE time<='$timee' && messaged!=1";
    $resultat = mysqli_query($mysqli, $swql);
    while ($rec = mysqli_fetch_object($resultat))
    {
        $plus = '';
        if ($rec->upgrademuch > 0)
        {
            $plus = "+";
        }
        $upg = '';
        if ($rec->itemupgrade)
        {
            $upg = "[$plus$rec->upgrademuch $rec->itemupgrade]";
        }
        if ($rec->bidder)
        {
            mysqli_query($mysqli, "DELETE from auctions WHERE ID='$rec->ID' LIMIT 1") or die("UaG56");

			$naarwie = $rec->bidder;
            mysqli_query($mysqli,
                "INSERT INTO messages (username, sendby, message, topic, time)
			 	VALUES ('$rec->bidder', '<B>Syrnia</B>', 'An Cave of trades runner tells you:<br />
			  <i>You have bid $rec->bid gold for $rec->much $rec->name $upg from $rec->seller and won the auction!<br />
			  Here it is...</i><br />
			  You got the item you bid for!<br /> ',  'Cave of trades', '$timee')") or
                die("D  1IE 2");

            if($upg==''){//Only use items without upgrade
            	mysqli_query($mysqli, "UPDATE items SET amountSold=amountSold+'$rec->much', soldFor=soldFor+'$rec->bid', marketprice=soldFor/amountSold  WHERE name='$rec->name' LIMIT 1") or die("UaGArt");
            }

			$getgold = round($rec->bid * 0.95);
            mysqli_query($mysqli, "UPDATE users SET gold=gold+'$getgold'  WHERE username='$rec->seller' LIMIT 1") or die("UaGArt");
            $resultaaXat = mysqli_query($mysqli,"SELECT gold FROM users WHERE username='$rec->seller' LIMIT 1");
			while ($recG = mysqli_fetch_object($resultaaXat)) { $newGold=$recG->gold; }

            mysqli_query($mysqli,
                "INSERT INTO messages (username, sendby, message, topic, time)
				  VALUES ('$rec->seller', '<B>Syrnia</B>', 'An Cave of trades runner tells you:<br />
				  <i>Dear $rec->seller,<br />Your $rec->much $rec->name $upg has been sold at your auction.<br />
				  $rec->bidder won the auction with a bid of $rec->bid gold.<br />
				  You get $getgold gold because a 5% fee goes to the Caves of trades. You now have $newGold gold.<br />
				  It will take up to 15 minutes for the gold to appear.</i><br />
				  <br /> ', 'Cave of trades', '$time')") or die("D  1IE 2");


            $resultaat = mysqli_query($mysqli,
                "SELECT username FROM items_inventory WHERE name='$rec->name' && itemupgrade='$rec->itemupgrade' && upgrademuch='$rec->upgrademuch' && username='$naarwie' LIMIT 1");
            $aantal = mysqli_num_rows($resultaat);
            if ($aantal == 1)
            {
                mysqli_query($mysqli, "UPDATE items_inventory SET much=much+'$rec->much' WHERE name='$rec->name' && itemupgrade='$rec->itemupgrade' && upgrademuch='$rec->upgrademuch' && username='$naarwie' LIMIT 1");
            } else
            {
                $sql = "INSERT INTO items_inventory (username, name, much, type, itemupgrade, upgrademuch)
					         VALUES ('$naarwie', '$rec->name', '$rec->much', '$rec->type', '$rec->itemupgrade', '$rec->upgrademuch')";
                mysqli_query($mysqli, $sql) or die("erroraa report this bug");
            }


        } else
        {

            mysqli_query($mysqli, "UPDATE auctions SET messaged=1 WHERE ID='$rec->ID' LIMIT 1") or die("UaH78");

            $saaql = "INSERT INTO messages (username, sendby, message, topic, time)
				  VALUES ('$rec->seller', '<B>Syrnia</B>', 'An Cave of trades runner tells you:<br />
				  <i>Your $rec->much $rec->name $upg has not been sold at your auction.<br />
				  There was no bidder, you can collect your item at $rec->pickupLocation.<br /></i><br />
				  <br /> ', 'Cave of trades', '$time')";
            mysqli_query($mysqli, $saaql) or die("D  1IE 2");
        }


    }
    //END THIS CODE IS ALSO IN 15 MIN CRON!

		}//olditem

}else{
  	if($var1=='search'){

		$output.="<table><tr><td><B>Item</B><td><B>Sold by</B>";
		$output.="<td><b>Current bid</B><td><B>Time left</B>";

		 $sEql = "SELECT ID, name, type,  much, bid, time, seller, donator, itemupgrade, time, upgrademuch FROM auctions WHERE name like '%$var2%' order by time desc";
	   $resultaEat = mysqli_query($mysqli,$sEql);
	    while ($record = mysqli_fetch_object($resultaEat))
		{

	    if($record->time>$timee){

		    $timeleft=ceil(($record->time-time())/3600);
			if($record->donator==1){$output.="<tr align=center valign=middle bgcolor=550000>"; }else{$output.="<tr align=center valign=middle>"; }
		    $plus='';
			if($record->upgrademuch>0){$plus="+"; }
			$upg='';
			if($record->itemupgrade){ $upg="[$plus$record->upgrademuch $record->itemupgrade]";}

			$output.="<td><center><a title=\"$record->much $record->name $upg\"><img src='images/inventory/$record->name.gif' border=0 name=\"$record->much $record->name $upg\"></a><br />";
			$output.="<font color=white>$record->much ";
			if($record->donator==1){
			 	$output.="<b>$record->name</b>";
			}else{
				$output.="$record->name";
			}
			$output.="<small>$upg</small><td><font color=white>$record->seller";
		    $output.="<td><font color=white>$record->bid gold<td>$timeleft hour(s)<td bgcolor=440000>";

			if($record->seller!=$S_user){
			 	$output.="<form action='#' onsubmit=\"locationText('auction',  'bid', $record->ID, $('auctionBid$record->ID').value );window.scrollTo(0,0);return false;\"><input type=text id=auctionBid$record->ID class=input size=4 value=".ceil($record->bid*1.01).">";
				$output.="<input type=submit value=Bid class=button ></form>";
			}

	    }
		}
		$output.="</table>";
		    if($timeleft==''){ $output.="No auctions were found.<br />"; }
	}else{
		$output.="<font color=white>Select a category at the left.</font>";
	}
}
}

$output.="</table>";




}
?>