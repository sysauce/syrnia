<?
if(defined('AZtopGame35Heyam')){

include_once('includes/levels.php');

$resultt = mysqli_query($mysqli, "SELECT ID FROM users WHERE username='$S_user' && (work='move' OR work='sail')  LIMIT 1");
$aana = mysqli_num_rows($resultt);
$resultt = mysqli_query($mysqli, "SELECT ID FROM locations WHERE monstersmuch>0 && (type='invasion' || type='skillevent') && location='$S_location' && startTime<'$timee' LIMIT 1");
$invasions = mysqli_num_rows($resultt);

if($aana==0 && $invasions==0){ // INVASION!!

$ID=$var2;



$safeSaveByMetal[""] = 0;
$safeSaveByMetal["Bronze"] = 0.50;
$safeSaveByMetal["Iron"] = 0.55;
$safeSaveByMetal["Steel"] = 0.60;
$safeSaveByMetal["Silver"] = 0.65;
$safeSaveByMetal["Gold"] = 0.70;
$safeSaveByMetal["Platina"] = 0.75;
$safeSaveByMetal["Syriet"] = 0.80;
$safeSaveByMetal["Obsidian"] = 0.85;
$safeSaveByMetal["Puranium"] = 0.90;
//$safeSaveByMetal["Redone"] = 95;

$safeMaxSaveByMetal[""] = 0;
$safeMaxSaveByMetal["Bronze"] = 10000;
$safeMaxSaveByMetal["Iron"] = 20000;
$safeMaxSaveByMetal["Steel"] = 30000;
$safeMaxSaveByMetal["Silver"] = 40000;
$safeMaxSaveByMetal["Gold"] = 50000;
$safeMaxSaveByMetal["Platina"] = 60000;
$safeMaxSaveByMetal["Syriet"] = 70000;
$safeMaxSaveByMetal["Obsidian"] = 80000;
$safeMaxSaveByMetal["Puranium"] = 90000;
//$safeMaxSaveByMetal["Redone"] = 100000;

$output.="<center><H1>Shops</h1>";
$timee=time();
if($var1=='buyShop'){
	// KOOP EEN SHOP

	$output.="Buy a shop!<br /><br />";

	if($var2>0)
	{
		$buyid=$var2;
		/// BUY EEN SHOP NUMMER :D

		 $resultaat = mysqli_query($mysqli, "SELECT username FROM buildings WHERE location='$S_location' && type='shop' && username='$S_user' LIMIT 1");
		    $aantal = mysqli_num_rows($resultaat);
		if($aantal==1)
		{
			$output.="You already control a shop in this area.<BR>";
		}
		else
		{
			$sql = "SELECT ID, username, slots, saleprice FROM buildings WHERE type='shop' && saleprice>0 && location='$S_location' && ID='$buyid' LIMIT 1";
			$resultaat = mysqli_query($mysqli,$sql);
			while ($record = mysqli_fetch_object($resultaat))
			{
				$saleprice=ceil($record->saleprice);

				if(payGold($S_user, $saleprice)==1)
				{
						mysqli_query($mysqli,"UPDATE users SET gold=gold+'$saleprice' WHERE username='$record->username' LIMIT 1") or die("error2 --> 1");
						mysqli_query($mysqli,"UPDATE buildings SET username='$S_user', saleprice=0, safe='', safecount = 0 WHERE ID='$buyid' && type='shop' && location='$S_location' LIMIT 1") or die("error2 --> 1");
						$output.="<B>The shop has been bought successfully for $saleprice gold, enjoy!</b><BR>";

						$resultaaXat = mysqli_query($mysqli,"SELECT gold FROM users WHERE username='$record->username' LIMIT 1");
						while ($rec = mysqli_fetch_object($resultaaXat)) { $newGold=$rec->gold; }

						$sql = "INSERT INTO messages (username, sendby, message, time, topic)
						  VALUES ('$record->username', '<B>Syrnia</b>', 'Dear $record->username,<br />$S_user has bought your shop at $S_location for $record->saleprice gold. You now have $newGold gold.', '$timee', 'Shop Sold')";
						mysqli_query($mysqli,$sql) or die("error report this bug please33 66 msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");

				}
				else
				{
					$output.="<B>You need $saleprice gold!<BR></b>";
				}
			}
		}
	}
	else
	{
	// OVERZICHTJE
		$saleprice='';
		$output.="<Table>";
		$output.="<tr bgcolor=333333><td><font color=white>Shop title<Td><font color=white>Shop owner<td><font color=white>Slots<td><font color=white>Price<td></tr>";

		$sql = "SELECT ID, titel, username, slots, saleprice FROM buildings WHERE type='shop' && location='$S_location' && saleprice>0 ORDER BY saleprice, slots desc";
		$resultaat = mysqli_query($mysqli,$sql);
	    while ($record = mysqli_fetch_object($resultaat))
		{
			$saleprice=ceil($record->saleprice);
			$output.="<tr bgcolor=666666><Td>$record->titel<td>$record->username<TD> $record->slots<td>$saleprice<td><a href='' onclick=\"locationText('shops', 'buyShop', '$record->ID');return false;\">Buy</a></tr>";
		}
		$output.="</table>";
		if($saleprice=='')
		{
			$output.="<i>There are no shops for sale here</i><BR>";
		}
	}


} elseif($var1=='viewShop' && $ID>0 && is_numeric($ID)){
#########
### EEN SHOP
#########


$buyname=$var3;
$buy=ceil($var4); //amount
if($buy>=1 && $buyname){
	 $shopowner=''; $buy=ceil($buy);
	  $sql = "SELECT username, safe, safecount, safegold, buildingclosed FROM buildings WHERE type='shop' && location='$S_location' && ID=$ID LIMIT 1";
		$resultaat = mysqli_query($mysqli,$sql);
		while ($record = mysqli_fetch_object($resultaat))
		{
			$shop_closed=$record->buildingclosed;
			$shopowner=$record->username;
			$safe = $record->safe;
			$safecount = $record->safecount;
			$safegold = $record->safegold;
		}
	if($shopowner){
	$much='';
	   $sql = "SELECT name,much,price,type, itemupgrade, upgrademuch FROM shops WHERE ID='$ID' && NR='$buyname' && much>0 LIMIT 1";
	   $resultaat = mysqli_query($mysqli,$sql);
	    while ($record = mysqli_fetch_object($resultaat))
		{
	    	$name=$record->name; $much=$record->much; $price=$record->price; $type=$record->type;  $upgrade=$record->itemupgrade; $upgrademuch=$record->upgrademuch;
		}

	if($much>0 && $price>=0 && is_numeric($price) && $shop_closed==0)
	{
		if($buy>=$much){$buy=$much; }

		$cost=$price*$buy;
		$sql = "SELECT gold FROM users WHERE username='$S_user' LIMIT 1";
		$resultaat = mysqli_query($mysqli,$sql);
		while ($record = mysqli_fetch_object($resultaat)) { $gold=$record->gold; }
		if($gold<$cost){$buy=floor($gold/$price); $cost=$buy*$price; }


		if($cost>0){
			$gold2=$gold-$cost;
			payGold($S_user, $cost);

			$maxSaving = $safeMaxSaveByMetal[$safe] * $safecount; //e.g. 10,000 * 2 for bronze safes = 20k;
			$maxSaving = $maxSaving - $safegold; //20k - the 5k already in there = 15k
			$savingPercent = $safeSaveByMetal[$safe];
			$intoSafe = floor($cost*$savingPercent);

			if($maxSaving < 0)
			{
				$maxSaving = 0;
			}

			if($intoSafe > $maxSaving)
			{
				$intoSafe = $maxSaving;
			}

			$cost = $cost - $intoSafe;

			mysqli_query($mysqli,"UPDATE buildings SET gold=gold+'$cost', safegold=safegold+'$intoSafe', shopearn=shopearn+'$cost'+'$intoSafe' WHERE ID='$ID' LIMIT 1") or die("error2 --> 1");
			if($buy<$much){
			 	mysqli_query($mysqli,"UPDATE shops SET much=much-'$buy' WHERE NR='$buyname' LIMIT 1") or die("error --> 1121211");
			}else{
				mysqli_query($mysqli,"DELETE FROM shops WHERE NR='$buyname' LIMIT 1") or die("error --> 1121211");
			}
			addItem($S_user, $name, $buy, $type, $upgrade, $upgrademuch, 1);

			$cost = $cost + $intoSafe;

			$output.="<B>Bought $buy $name for $cost gold.</b><br /><br />";

			$inventoryID=0;
			$sqlU = "SELECT ID FROM items_inventory WHERE name='$name' && itemupgrade='$upgrade' && upgrademuch='$upgrademuch' && username='$S_user' LIMIT 1";
		   	$resultaa = mysqli_query($mysqli,$sqlU);
		    while ($rec = mysqli_fetch_object($resultaa)){  $inventoryID=$rec->ID; 	 }
			if($upgrademuch!=0){
			 	if($upgrademuch>0){$plus="+"; }else{ $plus=''; }
				$upg=" [$plus$upgrademuch $upgrade]";
				$upgradeIMG="images/ingame/$upgrade.jpg";
			}else{$upg='';}


			$sql = "INSERT INTO messages (username, sendby, message, time, topic)
			  VALUES ('$shopowner', '<B>Syrnia</b>', '$S_user has bought $buy $name $upg for $cost gold from your shop at $S_location', '$timee', 'Shop')";
			mysqli_query($mysqli,$sql) or die("error report this bug please33 66 msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");
			} else {
			 	$output.="You do not have got enough gold to buy the $name.";
			}
	}
	}
}




  $sql = "SELECT username, titel, tekst, buildingclosed FROM buildings WHERE type='shop' && location='$S_location' && ID='$ID' LIMIT 1";
   $resultaat = mysqli_query($mysqli,$sql);
   while ($record = mysqli_fetch_object($resultaat)) {
    $shop_closed=$record->buildingclosed; $shopowner=$record->username;  $tit=stripslashes($record->titel); $tek=stripslashes($record->tekst);
	mysqli_query($mysqli,"UPDATE buildings SET shopviews=shopviews+1 WHERE ID='$ID' LIMIT 1") or die("error2 --> 1");
}
if(!$shopowner){ exit(); }
$tag='';
   $sql = "SELECT tag FROM clans WHERE username='$shopowner' LIMIT 1";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat)) { $tag=$record->tag;}

$tek=str_replace('
', '', $tek);
$tek = str_replace("
", "\\n", $tek);
$tek = str_replace("\n", "\\n", $tek);

if($var3=='back'){
	$output.="<a href='' onclick=\"locationText('shops', 'searchShop','$var4');return false;\">Back to shop search</a><BR>";
}else{
	if($tradingl>=10){
		$output.="<a href='' onclick=\"locationText('shops');return false;\">Back to shop overview</a> - <a href='' onclick=\"locationText('shops', 'searchShop','');return false;\">Shop search</a><br />";
	}else{
		$output.="<a href='' onclick=\"locationText('shops');return false;\">Back to shop overview</a><br />";
	}
}

if($shop_closed==1){
	$output.="<br /><B>This shop has been closed!</B><br /><br />";
}
$output.="Shop owner: $shopowner <i>$tag</i><BR><BR>";
$output.="<B>$tit</B><BR>";
$output.="$tek";
$output.="<BR><BR>";



if($thievingl>=10 && $S_user!=$shopowner && $shop_closed==0){
	$output.="<form onsubmit=\"thieving('shopGold',$ID);return false;\">";
	$output.="<input type=submit class=input value='Steal gold from this shop'>";
	$output.="</form>";
}


$output.="<table>";
$output.="<tr bgcolor=333333 valign=middle><td width=45>Item</td><Td>Stock</td><td>Price</td><td>Buy</td>";
if($thievingl>=10 && $S_user!=$shopowner){ $output.="<td>Thief</td>"; }
$output.="</tr>";
   $sql = "SELECT NR, name,much,price,  itemupgrade, upgrademuch FROM shops WHERE ID='$ID' && much>0 ORDER BY TYPE ASC, Name ASC";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
		$plus=''; if($record->upgrademuch>0){$plus="+"; }
		$upg=''; if($record->itemupgrade){ $upg="[$plus$record->upgrademuch $record->itemupgrade]";}

		if($record->itemupgrade){
			$upgradeIMG="<img src=\"images/ingame/$record->itemupgrade.jpg\" />";
		}else{
			$upgradeIMG='';
		}
		 $output.="<tr align=left valign=middle bgcolor=666666>";
		 //$output.="<td width=45 height=45 bgcolor=333333 title=\"$record->much $record->name $upg\" background='images/inventory/$record->name.gif' border=0 >$upgradeIMG</td>";
        $output.="<td align=left valign=top height=45 bgcolor=666666>";// background='images/inventory/$record->name.gif' border=0 >$upgradeIMG </td>";
        $output.="<div id='itemI_37030714' title=\"$record->name $upg\" style='width: 45px; height: 45px; margin-left:auto;margin-right:auto; background-image: url(\"images/inventory/$record->name.gif\"); cursor: default; '>$upgradeIMG</div><div style='text-align: center'>$record->name $upg</div></td>";
		 $output.="<td bgcolor=666666 align=center>$record->much</td><td bgcolor=666666 align=center>$record->price each</td><td bgcolor=666666 align=center>";
		 if($shop_closed==0){
		 	$output.="<form onsubmit=\"locationText('shops', 'viewShop', '$ID', $record->NR, $('shopBuyMuch$record->NR').value);return false;\"><input type=text id=shopBuyMuch$record->NR size=3 class=input><br /><input type=submit value=buy class=button></form></td>";
		 }else{
		 	$output.="<small>closed</small></td>";
		 }

		 if($thievingl>=10 && $S_user!=$shopowner && $shop_closed==0){
		  	$output.="<td valign=center>";
			$output.="<a id='thieve$record->NR' href='#' onclick=\"$('thieve$record->NR').style.display='none';thieving('shop',$record->NR,$ID);window.scrollTo(0,0);return false;\"><font color=#e7c720><small>Steal</small></font></a>";
			#<a href=\"?p=thief&shop=$ID&item=$record->name\">Thief</a>";
			$output.="</td>";
		}
		$output.="</tr>";

	}
$output.="</table>";

}elseif($var1=='adminShop'){
############
## SHOP ADMIN
##############

if($var2=='editInfo' && ($var3 OR $var4)){
	$edtitel = htmlentities(trim($var3));
	$edtekst = htmlentities(trim($var4));
	$edtekst= nl2br($edtekst);
	$closedtatus = htmlentities(trim($var5));
	if($closedtatus=='true'){
		$FARMQ=", farmslots='1'";
		$closedtatus=1;
	}else{
		$FARMQ="";
		$closedtatus=0;
	}

	mysqli_query($mysqli,"UPDATE buildings SET titel='$edtitel', tekst='$edtekst', buildingclosed='$closedtatus' $FARMQ WHERE username='$S_user' && type='shop' && location='$S_location'  LIMIT 1") or die("error2 --> 1");
	$output.="<B>Shop info edited</B><BR>";
}


$shopid=0;
   $sql = "SELECT ID,gold, safegold, safe, safecount, slots,saleprice, tekst, titel, farmslots, buildingclosed FROM buildings WHERE username='$S_user' && type='shop' && location='$S_location' LIMIT 1";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
    	$shopclosed = $record->buildingclosed; $farmslots=$record->farmslots; $shoptitel=stripslashes($record->titel);
		$shoptekst=str_replace("<br />", "",stripslashes($record->tekst)); $shopid=$record->ID;
		$shopgold=$record->gold;
		$safegold=$record->safegold;
		$totalgold=$shopgold+$safegold;
		$safe=$record->safe;
		$safecount=$record->safecount;
		$shopslots=$record->slots;
		$saleprice=$record->saleprice;
	}

if($shopid>0){

	if($farmslots!=$tradingl){
			mysqli_query($mysqli,"UPDATE buildings SET farmslots='$tradingl' WHERE ID='$shopid' LIMIT 1") or die("error2 --> 1");
	}

  	$sql = "DELETE FROM shops WHERE ID='$shopid' && much<1";
      mysqli_query($mysqli,$sql) or die("error report this bug 2");
     $sql = "DELETE FROM items_inventory WHERE username='$S_user' && much<1";
      mysqli_query($mysqli,$sql) or die("error report this bug 2");

$wooddest=$shopslots/2;
if($var2=='destroy'){ # DESTOROY
	$output.="You destroyed your shop and got $wooddest wood.<BR><a href='' onclick=\"locationText();return false;\">Click here to continue</a>.";
	$sql = "DELETE FROM buildings WHERE username='$S_user' && ID='$shopid' LIMIT 1";
	      mysqli_query($mysqli,$sql) or die("error report this bug 1");
	     $sql = "DELETE FROM shops WHERE ID='$shopid'";
	      mysqli_query($mysqli,$sql) or die("error report this bug 2");
	addItem($S_user, 'Wood', $wooddest, 'item', '', '', 1);

} else {


if($var2=='withdrawGold'){
	mysqli_query($mysqli,"UPDATE buildings SET gold=0, safegold=0 WHERE ID='$shopid' LIMIT 1") or die("error2 --> 1");
	getGold($S_user, $totalgold);
	$shopgold=0;
	$safegold=0;
	$totalgold=0;
}

if($var2=='sellShop' && $var3=='cancel'){
	mysqli_query($mysqli,"UPDATE buildings SET saleprice='0' WHERE ID='$shopid' LIMIT 1") or die("error2 --> 1");
	$output.="You have cancelled selling your shop.<br /><br />";
	$sellprice=0; $saleprice=0;
}else if($var2=='sellShop'){

	$sellprice=round($var3);

	$resultaat = mysqli_query($mysqli, "SELECT ID FROM shops WHERE ID='$shopid' && much>0 LIMIT 1");
	$aantal = mysqli_num_rows($resultaat);
	if($aantal<1){

	if($sellprice==''){$sellprice=-5; }
		if($sellprice>=0){

			mysqli_query($mysqli,"UPDATE buildings SET saleprice='$sellprice' WHERE ID='$shopid' LIMIT 1") or die("error2 --> 1");
			$output.="The shop has been closed and can be bought for $sellprice gold.<br /><br />";

		} else {
			$output.="Sell your shop:<BR>";
			if($safe)
			{
				$output.="<small>Any safes in this shop will be destroyed on sale.</small><br/>";
			}
			$output.="<form onsubmit=\"locationText('shops', 'adminShop', 'sellShop', $('ShopSellprice').value);return false;\">";
			$output.="Price:<input type=text id=ShopSellprice class=input><BR>";
			$output.="<input type=submit value=Sell class=button>";
			$output.="</form><br /><br />";
		}
	} else{
		$output.="You need to empty your shop before you can sell it.<br /><br />";
	}
}

if($var2 == "safes")
{
	$safeTypeByMetal[""] = 0;
	$safeTypeByMetal["Bronze"] = 1;
	$safeTypeByMetal["Iron"] = 2;
	$safeTypeByMetal["Steel"] = 3;
	$safeTypeByMetal["Silver"] = 4;
	$safeTypeByMetal["Gold"] = 5;
	$safeTypeByMetal["Platina"] = 6;
	$safeTypeByMetal["Syriet"] = 7;
	$safeTypeByMetal["Obsidian"] = 8;
	$safeTypeByMetal["Puranium"] = 9;
	//$safeTypeByMetal["Redone"] = 10;

	$safeTypeByID[0] = "";
	$safeTypeByID[1] = "Bronze";
	$safeTypeByID[2] = "Iron";
	$safeTypeByID[3] = "Steel";
	$safeTypeByID[4] = "Silver";
	$safeTypeByID[5] = "Gold";
	$safeTypeByID[6] = "Platina";
	$safeTypeByID[7] = "Syriet";
	$safeTypeByID[8] = "Obsidian";
	$safeTypeByID[9] = "Puranium";
	//$safeTypeByID[10] = "Redone";

	$safeTypeInInventory[""] = 0;
	$safeTypeInInventory["Bronze"] = 0;
	$safeTypeInInventory["Iron"] = 0;
	$safeTypeInInventory["Steel"] = 0;
	$safeTypeInInventory["Silver"] = 0;
	$safeTypeInInventory["Gold"] = 0;
	$safeTypeInInventory["Platina"] = 0;
	$safeTypeInInventory["Syriet"] = 0;
	$safeTypeInInventory["Obsidian"] = 0;
	$safeTypeInInventory["Puranium"] = 0;
	//$safeTypeInInventory["Redone"] = 0;


	$maxSafes = floor($tradingl / 10);
	if($maxSafes > 10)
	{
		$maxSafes = 10;
	}
	$bestSafe = "";
	/*if($tradingl >= 75)
	{
		$bestSafe = "red one";
	}
	else */if($tradingl >= 60)
	{
		$bestSafe = "Puranium";
	}
	else if($tradingl >= 50)
	{
		$bestSafe = "Obsidian";
	}
	else if($tradingl >= 45)
	{
		$bestSafe = "Syriet";
	}
	else if($tradingl >= 40)
	{
		$bestSafe = "Platina";
	}
	else if($tradingl >= 35)
	{
		$bestSafe = "Gold";
	}
	else if($tradingl >= 25)
	{
		$bestSafe = "Silver";
	}
	else if($tradingl >= 20)
	{
		$bestSafe = "Steel";
	}
	else if($tradingl >= 15)
	{
		$bestSafe = "Iron";
	}
	else if($tradingl >= 10)
	{
		$bestSafe = "Bronze";
	}

	$sql = "SELECT name, much, type, itemupgrade, upgrademuch FROM items_inventory WHERE username='$S_user' && type = 'safe' && itemupgrade=''";
	$resultaat = mysqli_query($mysqli,$sql);
	while ($record = mysqli_fetch_object($resultaat))
	{
		$split = explode(" ", $record->name);
		//$output .= "|" . $split[0] . "|$record->much<br/>";
		$safeTypeInInventory[$split[0]] = $record->much;
	}

	if($bestSafe)
	{
		if($var3 == "add")
		{
			if($safe)
			{
				if($safecount < $maxSafes)
				{
					if($safeTypeInInventory[$safe] > 0)
					{
						removeItem($S_user, $safe . " safe", 1, '', 0, 1);
						mysqli_query($mysqli,"UPDATE buildings SET safecount = safecount+1 WHERE ID='$shopid' LIMIT 1") or die("error2 --> 1");

						$output .= "<font color=yellow><b>You added 1 $safe safe to your shop!</b></font><br/><br/>";
						$safecount++;
					}
					else
					{
						$output .= "<font color=red>You dont have any $safe safes in your inventory!</font><br/><br/>";
					}
				}
				else
				{
					$output .= "<font color=red>You can't have any more $safe safes with your trading level.</font><br/><br/>";
				}
			}
		}
		else if($var3 == "install" && $var4)
		{
			if($safeTypeByMetal[$var4] > $safeTypeByMetal[$safe])
			{
				if($safeTypeByMetal[$var4] <= $safeTypeByMetal[$bestSafe])
				{
					if($safeTypeInInventory[$var4] > 0)
					{
						removeItem($S_user, $var4 . " safe", 1, '', 0, 1);
						mysqli_query($mysqli,"UPDATE buildings SET safe = '$var4', safecount = 1 WHERE ID='$shopid' LIMIT 1") or die("error2 --> 1");

						$output .= "<font color=yellow><b>You added 1 $var4 safe to your shop!</b></font><br/><br/>";
						$safecount = 1;
						$safe = $var4;
					}
					else
					{
						$output .= "<font color=red>You dont have any $safe safes in your inventory!</font><br/><br/>";
					}
				}
				else
				{
					$output .= "<font color=red>You can't have any more $safe safes with your trading level.</font><br/><br/>";
				}
			}
			else
			{
				$output .= "<font color=red>You can't install a $var4 safe, that would be a downgrade!</font><br/><br/>";
			}
		}
	}
}


$output.="<a href='' onclick=\"locationText('shops');return false;\">Back to shop list.</a><BR>";
$output.="<BR>";
$output.="With your trading level you can manage $tradingslots slots in your shop, your shop contains $shopslots slots.<BR>";
if($safe)
{
	$output.="You have $safecount " . ($safe ? $safe . " " : "") . "safe" . ($safecount == 1 ? "" : "s") .  ".";
	$output.=" This will protect " . floor($safeSaveByMetal[$safe]*100) . "% of purchases up to " . number_format(floor($safeMaxSaveByMetal[$safe]*$safecount)) . "gp<BR>";
}
$output.="<BR>";

if($var2=='destroya'){
	$output.="<B>Are you really sure?</b><br />";
	if($totalgold>0){ $output.="You still have $totalgold gold int your shop, this will be <B>lost</B> if you do not withdraw it!<BR>";}
	$output.="<a href='' onclick=\"locationText('shops', 'adminShop', 'destroy');return false;\">Click here if you are sure.</a><BR><br /><br />";
}
if($saleprice<=0 && $sellprice<=0){

	$output.="<Table>";
	$output.="<tr><Td><B>Gold<td><a href='' onclick=\"locationText('shops', 'adminShop', 'withdrawGold');return false;\">Withdraw the $totalgold gold from the shop.</a>" . ($safe ? "<br/>($safegold in safe" . ($safecount == 1 ? "" : "s") . ")" : "") . "<BR>";
	$output.="<tr><td><B>Items<td><a href='' onclick=\"locationText('shops', 'adminShop', 'addItems');return false;\">Add items to my shop</a><BR>";
	$output.="<a href='' onclick=\"locationText('shops', 'adminShop', 'removeItems');return false;\">Remove items from my shop</a>";
	$output.="<tr><td><B>Shop info.<td><a href='' onclick=\"locationText('shops', 'adminShop', 'editInfo');return false;\">Edit shop info.</a>";
	$questID=26;
	if(stristr($_SESSION['S_questscompleted'], "[$questID]"))
	{
		$output.="<tr><td><B>Safe<td><a href='' onclick=\"locationText('shops', 'adminShop', 'safes');return false;\">Manage safes</a>";
	}
	$output.="<tr><td><B>Options<td>";
	if($shopslots*2<=$constructingl*1000){
	 	$output.="<a href='' onclick=\"locationText('work', 'constructing', 'shopupgrade');return false;\">Upgrade shop to ".($shopslots*2)." shop slots for ".($shopslots*6). " wood.</a><BR>";
	}
	$output.="<a href='' onclick=\"locationText('shops', 'adminShop', 'destroya');return false;\">Destroy the shop('Recycle' $wooddest wood)</a>";
	$output.="</table>";

	$output.="<BR>";
	$output.="<a href='' onclick=\"locationText('shops', 'adminShop', 'sellShop');return false;\">Sell my shop</a><BR>";
	$output.="<BR>";

} else {
	if($saleprice==0 && $sellprice>=1){ $saleprice=$sellprice;}
	$output.="Your shop is now for sale for $saleprice gold, to cancel click <a href='' onclick=\"locationText('shops', 'adminShop', 'sellShop', 'cancel', 'cancel');return false;\">here</a>.";

	$output.="<BR>";
	$output.="<a href='' onclick=\"locationText('shops', 'adminShop', 'sellShop');return false;\">Change price</a><BR>";
	$output.="<BR>";
}







if($var2=='editInfo')
{
##### EDIT SHOP INFO


$shoptekst = str_replace("
", "\\n", $shoptekst);
$shoptekst = str_replace("\n", "\\n", $shoptekst);

if($shopclosed==1){
	$checkker="checked";
}else{
	$checkker="";
}

$output.="<B>Edit shop info</b><BR>";
$output.="<form onsubmit=\"locationText('shops', 'adminShop', 'editInfo', $('shopTitleEdit').value, $('shopTextEdit').value, $('shopClosedEdit').checked);return false;\">";
$output.="<table>";
$output.="<tr><td>Is closed<td><input type=checkbox id=shopClosedEdit value=\"1\" $checkker>";
if(!$checkker){
	$output.="<font color=green>Your shop is open</font>";
}else{
	$output.="<font color=red><b>Your shop is closed</b></font>";
}
$output.="<tr><td>Shop Title<td><input type=text id=shopTitleEdit value=\"$shoptitel\">";
$output.="<tr valign=top><td>Shop text<td><textarea id=shopTextEdit colls=40 rows=10>$shoptekst</textarea>";
$output.="<tr><td><td><input type=submit value='Edit' class=button></form>";
$output.="</table>";

}


else if($var2=='safes')
{
##### MANAGE SAFES

$questID=26;
if(stristr($_SESSION['S_questscompleted'], "[$questID]"))
{
	$output.="<B>Manage safes</b><br/><br/>";

	if($bestSafe)
	{
		$output .= "You currently have $safecount " . ($safe ? $safe . " " : "") . "safe" . ($safecount == 1 ? "" : "s") .  ".<br/>";
		$output .= "With your trading level you can install up to $maxSafes $bestSafe safe" . ($maxSafes == 1 ? "" : "s") .  ".<br/><br/>";

		if($safe && $safecount < $maxSafes)
		{
			$output .= "You can install " . ($maxSafes-$safecount) . " more $safe safe" . ($maxSafes-$safecount == 1 ? "" : "s") .  ".";

			if($safeTypeInInventory[$safe] > 0)
			{
				$output .= " <a href='' onclick=\"locationText('shops', 'adminShop', 'safes', 'add');return false;\">Add 1 $safe safe</a>";
			}

			$output .= "<br/><br/>";
		}

		if($safeTypeByMetal[$bestSafe] > $safeTypeByMetal[$safe])
		{
			if($safe)
			{
				$output .= "Upgrade to:<br/>";
			}
			else
			{
				$output .= "Install:<br/>";
			}

			for($i = $safeTypeByMetal[$safe]+1; $i <= $safeTypeByMetal[$bestSafe]; $i++)
			{
				if($safeTypeInInventory[$safeTypeByID[$i]] > 0)
				{
					$output .= "<a href='' onclick=\"locationText('shops', 'adminShop', 'safes', 'install', '" . $safeTypeByID[$i] . "');return false;\">$safeTypeByID[$i] safe</a><br/>";
				}
			}
		}
	}
	else
	{
		$output .= "You must be level 10 to install a safe.";
	}
}
}





else if($var2=='addItems' && $saleprice<1){
#################
$add2shop=$var3;
$add2shopprice=$var4;
$add2shopmuch=round($var5);
if($add2shop && $add2shopmuch>0 && $add2shopprice>0 && is_numeric($add2shopprice) && is_numeric($add2shopmuch)){
	## SHOP TOEVOEGEN HELEMAAL BEGIN
	#################
	$name='';
	   $sql = "SELECT name,much,type,  itemupgrade, upgrademuch FROM items_inventory WHERE username='$S_user' && ID='$add2shop'  LIMIT 1";
	   $resultaat = mysqli_query($mysqli,$sql);
	    while ($record = mysqli_fetch_object($resultaat))
		{
		 $name=$record->name;
		 $much=$record->much;
		 $type=$record->type;
		 $upgrade=$record->itemupgrade;
		 $upgrademuch=$record->upgrademuch;
		}

	if($name && $type<>'quest'){

		if($add2shopmuch>$much){$add2shopmuch=$much; }

		$slotsused=0;
		   $sql = "SELECT much FROM shops WHERE ID='$shopid'";
		   $resultaat = mysqli_query($mysqli,$sql);
		    while ($record = mysqli_fetch_object($resultaat)) { $slotsused=$slotsused+$record->much; }

		if($tradingslots<$shopslots){$shopslots=$tradingslots; }
		$slotsfree=$shopslots-$slotsused;
		if($add2shopmuch>$slotsfree){ $add2shopmuch=$slotsfree; }
		$slotsfree=$slotsfree-$add2shopmuch;

		removeItem($S_user, $name, $add2shopmuch, $upgrade, $upgrademuch, 1);

		$resultaat = mysqli_query($mysqli, "SELECT name FROM shops WHERE ID='$shopid' && name='$name' && itemupgrade='$upgrade' && upgrademuch='$upgrademuch'  LIMIT 1");
		   $aantal = mysqli_num_rows($resultaat);

		if($aantal==1){
			mysqli_query($mysqli,"UPDATE shops SET much=much+'$add2shopmuch', price='$add2shopprice' WHERE name='$name' && itemupgrade='$upgrade' && upgrademuch='$upgrademuch' && ID='$shopid' LIMIT 1") or die("error --> 142");
		} else{
		 	$sql = "INSERT INTO shops (ID, name, much, type, price, itemupgrade, upgrademuch)
		         VALUES ('$shopid', '$name', '$add2shopmuch', '$type', '$add2shopprice', '$upgrade', '$upgrademuch')";
			mysqli_query($mysqli,$sql) or die("errora11a report this bug-- ('$shopid', '$name', '$add2shopmuch', '$type', '$add2shopprice')  ");
		}

		if($upgrademuch!=0){
			 	if($upgrademuch>0){$plus="+"; }else{ $plus=''; }
				$upg=" [$plus$upgrademuch $upgrade]";
		}else{$upg='';}
		$title="$name$upg";





		if($add2shopmuch==0){
		 	$output.="<B>You cannot add the $name because your shop is full.</b>";
		} else{
			$output.="<B>$add2shopmuch $name added to the shop for $add2shopprice gold each.</b><BR>$slotsfree free shop slots left.<BR>";
		}


	}



	}
	## EINDE SHOP ITEM TOEVOEG



	$output.="<Table><tr bgcolor=333333><td><font color=white>Item<Td><font color=white>Number<td><font color=white>Price<td><font color=white>Add";
	   $sql = "SELECT ID, name, much,  itemupgrade, upgrademuch FROM items_inventory WHERE username='$S_user'  && type<>'quest' ORDER BY TYPE asc, name ASC";
	   $resultaat = mysqli_query($mysqli,$sql);
	    while ($record = mysqli_fetch_object($resultaat))
		{

		 	$plus=''; if($record->upgrademuch>0){$plus="+"; }
			$upg=''; if($record->itemupgrade){ $upg="[$plus$record->upgrademuch $record->itemupgrade]";}
			if($record->itemupgrade){
				$upgradeIMG="<img src=\"images/ingame/$record->itemupgrade.jpg\" />";
			}else{
				$upgradeIMG='';
			}

			$output.="<tr align=right>";
			$output.="<td align=left valign=top height=45 bgcolor=666666>";// background='images/inventory/$record->name.gif' border=0 >$upgradeIMG </td>";
            $output.="<div id='itemI_37030714' title=\"$record->name $upg\" style='width: 45px; height: 45px; margin-left:auto;margin-right:auto; background-image: url(\"images/inventory/$record->name.gif\"); cursor: default; '>$upgradeIMG</div><div style='text-align: center'>$record->name $upg</div></td>";

		 	$output.="<td bgcolor=666666 align=center>$record->much</td>";
			$output.="<td bgcolor=666666><input type=text id=add2shopprice$record->ID size=4 class=input></td>";
			$output.="<td bgcolor=666666><input type=text id=add2shopmuch$record->ID size=4 class=input></td>";
			$output.="<td bgcolor=666666><input type=submit value='Add to shop' class=button onclick=\"locationText('shops', 'adminShop', 'addItems', $record->ID, $('add2shopprice$record->ID').value, $('add2shopmuch$record->ID').value );return false;\" ></td></tr>";

		}
	$output.="</table>";
} ## EINDE SHOP TOEVOEG GEDOE HELEMAAL







else if($var2=='removeItems' && $saleprice<1){
	################
	$remove2shop=$var3;
$remove2shopmuch=round($var4);
	if($remove2shop && $remove2shopmuch>0 && is_numeric($remove2shopmuch) ){
		## SHOP REMOVE HELEMAAL BEGIN
		#################
		$name='';
		   $sql = "SELECT NR,name,much,type,  itemupgrade, upgrademuch FROM shops WHERE ID='$shopid' && NR='$remove2shop' LIMIT 1";
		   $resultaat = mysqli_query($mysqli,$sql);
		    while ($record = mysqli_fetch_object($resultaat)) { $NR=$record->NR; $name=$record->name; $much=$record->much; $type=$record->type;  $upgrade=$record->itemupgrade; $upgrademuch=$record->upgrademuch;}
		if($name){
			if($remove2shopmuch>=$much){$remove2shopmuch=$much; $delete=1;}
			if($delete==1){
				mysqli_query($mysqli,"DELETE FROM shops WHERE NR='$NR' LIMIT 1") or die("error --> 142");
			}else{
				mysqli_query($mysqli,"UPDATE shops SET much=much-'$remove2shopmuch' WHERE NR='$NR' LIMIT 1") or die("error --> 142");
			}
			$output.="<B>$remove2shopmuch $name removed from the shop.</b><BR>";

			addItem($S_user, $name, $remove2shopmuch, $type, $upgrade, $upgrademuch, 1);


		}
	}
	## EINDE SHOP ITEM REMOVE
	$output.="<Table><tr bgcolor=333333><td>Item<Td>Number<td>Price<td>Remove";
	   $sql = "SELECT NR, name, much, price,  itemupgrade, upgrademuch FROM shops WHERE ID='$shopid' ORDER BY type asc, name ASC";
	   $resultaat = mysqli_query($mysqli,$sql);
	    while ($record = mysqli_fetch_object($resultaat))
		{

			$plus=''; if($record->upgrademuch>0){$plus="+"; }
			$upg=''; if($record->itemupgrade){ $upg="[$plus$record->upgrademuch $record->itemupgrade]";}
			if($record->itemupgrade){
				$upgradeIMG="<img src=\"images/ingame/$record->itemupgrade.jpg\" />";
			}else{
				$upgradeIMG='';
			}

			$output.="<tr align=right>";
			//$output.="<td width=45 align=left valign=top height=45 bgcolor=333333 title=\"$record->much $record->name $upg\" background='images/inventory/$record->name.gif' border=0 >$upgradeIMG</td>";
			$output.="<td align=left valign=top height=45 bgcolor=666666>";// background='images/inventory/$record->name.gif' border=0 >$upgradeIMG </td>";
            $output.="<div id='itemI_37030714' title=\"$record->name $upg\" style='width: 45px; height: 45px; margin-left:auto;margin-right:auto; background-image: url(\"images/inventory/$record->name.gif\"); cursor: default; '>$upgradeIMG</div><div style='text-align: center'>$record->name $upg</div></td>";

			$output.="<td bgcolor=666666 align=center>$record->much";
			$output.="<td bgcolor=666666>$record->price<td bgcolor=666666><input type=text id=remove2shopmuch$record->NR value=\"$record->much\" size=4 class=input><Td bgcolor=666666 valign=center><input type=submit value='Remove from shop' class=button onclick=\"locationText('shops', 'adminShop', 'removeItems', $record->NR, $('remove2shopmuch$record->NR').value);return false;\"></tr>";

	}
	$output.="</table>";
} ## EINDE SHOP REMOVE GEDOE HELEMAAL







}


} else{ $output.="You do not control any shop in here."; }

} else{
##############
## OVERZICHT
#########

if($var1=='searchShop' && $tradingl>=10){

$q=$var2;
$shopIncludeClosed=$var3;
$searchAllLocations=$var4;

	$output.="<form onsubmit=\"locationText('shops', 'searchShop',$('shopSearchQ').value);return false;\">";
	$output.="<input type=text id=shopSearchQ class=input value='$q'>";
if($tradingl>=25)
{
	if($tradingl >= 30)
	{
		$output.="<select id=shopSearchAll class=input><option value='all'>Search only at this location</option><option value='all'" . ($searchAllLocations=='1' ? " selected='selected'" : "") . ">Search all locations in this region</option>";
		
		if($tradingl >= 50)
		{
			$output.="<option value='all'" . ($searchAllLocations=='2' ? " selected='selected'" : "") . ">Search at all locations</option>";
		}
		
		$output.="</select>";
	}
	$output.="<br/>Include closed shops? <input type='checkbox' id='shopIncludeClosed' value='1'" . ($shopIncludeClosed ? " checked='checked'" : "") . "> <input type=submit value=Search class=button onclick=\"locationText('shops', 'searchShop',$('shopSearchQ').value, $('shopIncludeClosed').checked?1:0" . ($tradingl >= 30 ? ", $('shopSearchAll').selectedIndex" : "") . ");return false;\"><br />";
}
else{
	$output.="<input type=submit value=Search class=button onclick=\"locationText('shops', 'searchShop',$('shopSearchQ').value);return false;\"></form><br />";
}



if($q){ #Q
if(strlen($q)>=3){
$output.="Your search results for \"$q\": (Max. 50 results)<BR>";
$output.="<Table><tr bgcolor=333333><td><font color=white>Item<td><font color=white>Much<td><font color=white>Title<Td><font color=white>Owner<td><font color=white>Location</tr>";
$a='';

if($tradingl>=50 && $searchAllLocations=='2')
{
 	$LOC1=", buildings.location as location "; $LOC2="";
}
else if($tradingl>=30 && $searchAllLocations=='1')
{
 	$LOC1=", buildings.location as location "; $LOC2="buildings.location IN (SELECT locationName FROM locationinfo WHERE mapNumber='$S_mapNumber') && ";
}
else
{
 	$LOC1=", buildings.location as location "; $LOC2="buildings.location='$S_location' && ";
}

if($tradingl >= 25 && !$shopIncludeClosed)
{
	$LOC2 .= "buildingclosed = 0 && ";
}

	$NR=0;
   $sql = "SELECT shops.ID as ID, shops.name as name,shops.itemupgrade as itemupgrade,shops.upgrademuch as upgrademuch, shops.much as much, buildings.titel as titel, buildings.username as username, locationinfo.mapNumber AS mapNumber $LOC1
   FROM shops, buildings, locationinfo WHERE $LOC2 buildings.ID=shops.ID && locationinfo.locationName=buildings.location && name like '%$q%' && farmslots>=1 ORDER BY name asc LIMIT 50";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
	 	$NR++;
	     $a=1;
		if($tradingl>=75){
		 	$much=$record->much;
		} elseif($record->mapNumber==$S_mapNumber && $tradingl>=45){
		 	$much=$record->much;
		}elseif(($record->location==$S_location OR $record->location=='') && $tradingl>=25){
		 	$much=$record->much;
		}else{
		 	$much='';
		}

		if($tradingl>=60){
		 	$titel=stripslashes($record->titel);
			$owner=$record->username;
		} elseif($record->mapNumber==$S_mapNumber && $tradingl>=40){
		 	$titel=stripslashes($record->titel);
			$owner=$record->username;
		} elseif(($record->location==$S_location OR $record->location=='') && $tradingl>=20){
		 	$titel=stripslashes($record->titel);
			$owner=$record->username;
		} else{
		 	$titel=''; $owner='';
		}
		if($record->titel==''){$titel='No title'; }

		if(($record->location==$S_location OR $record->location=='')){
		 	$S_locationT="<a href='' onclick=\"locationText('shops', 'viewShop', '$record->ID', 'back', '$q');window.scrollTo(0,0);return false;\">$S_location</a>";
		} else{
		 	$S_locationT=$record->location;
		}

		if($record->location==$S_location OR ($tradingl>=50 && $searchAllLocations=='2') OR ($record->mapNumber==$S_mapNumber && $tradingl>=30) OR $record->location==''){
		 	if($record->upgrademuch>0){$plus="+"; }else{ $plus=''; }
			if($record->itemupgrade){
			  	$upg="<small>[$plus$record->upgrademuch $record->itemupgrade]</small>";
			 	$upg2="<img src=\"images/ingame/$record->itemupgrade.jpg\" />";
			}else{
				$upg=''; $upg2='';
			}

		 $itemname="$record->name $upg2$upg";
			$output.="<tr bgcolor=333333>";
			$output.="<td><font color=white>$itemname</td>";
			$output.="<td><font color=white>$much</td>";
			$output.="<td><font color=white>$titel</td>";
			$output.="<Td><font color=white>$owner</td>";
			$output.="<td><font color=white>$S_locationT</td>";
			$output.="</tr>";
		}
	}

$output.="</table>";
	if($NR>=50){
		$output.="More than 50 results have been found, only the first 50 are shown. Please refine your search for more accuracy.<br />";
	}

if($a==''){$output.="There are no shops at $S_location.<BR>"; }
}else{ $output.="Your search entry should be at least 3 characters long."; }
}#Q


} else{#END OF SHOPSEARCH
	if($tradingl>=10){
	 	$output.="<a href='' onclick=\"locationText('shops', 'searchShop');return false;\">Search shops for an item</a><BR><BR>";
	}

	$sql = "SELECT ID FROM buildings WHERE username='$S_user' && type='shop' && location='$S_location'  LIMIT 1";
	$resultaat = mysqli_query($mysqli,$sql);
	while ($record = mysqli_fetch_object($resultaat))
	{
	 	$q=1;
		$output.="<a href='' onclick=\"locationText('shops', 'adminShop');return false;\">Manage my shop</a><BR><BR>";
	}

	if($q<>1){
	 	$output.="<a href='' onclick=\"locationText('shops', 'buyShop');return false;\">Buy a shop</a><BR><BR>";
	}

	$output.="<Table cellspacing=0 cellpadding=3>";
	$output.="<tr bgcolor=333333><td><font color=white>Title<Td><font color=white>Owner<td><font color=white>Slots</tr>";

	$a=''; $empty='';
	$sql = "SELECT ID, username, slots, titel FROM buildings WHERE type='shop' && location='$S_location' && saleprice<1  && farmslots>=1 ORDER BY farmslots desc";
	$resultaat = mysqli_query($mysqli,$sql);
	while ($record = mysqli_fetch_object($resultaat))
	{
	 	$a=1;
		if($record->titel==''){
		 	$titel='No title';
		} else {
		 	$titel=stripslashes($record->titel);
		}

	 	$resultaaaaat = mysqli_query($mysqli, "SELECT ID FROM shops WHERE ID='$record->ID' LIMIT 1");
		$aantaal = mysqli_num_rows($resultaaaaat);


	   $sq = "SELECT donation FROM stats WHERE username='$record->username' LIMIT 1";
	   $resultat = mysqli_query($mysqli,$sq);
	    while ($recor = mysqli_fetch_object($resultat))
		{
		 $S_donationANDERE=$recor->donation;
		}

		if($S_donationANDERE>=1250){ $b1="<B><font color=#e7c720>"; $b2="</font></B>"; }
		elseif($S_donationANDERE>=500){ $b1="<B>"; $b2="</B>"; } else{$b1=''; $b2=''; }

		if($aantaal>0){
		 	$output.="<tr bgcolor=666666><td><a href='' onclick=\"locationText('shops', 'viewShop', '$record->ID');window.scrollTo(0,0);return false;\"><font color=white>$b1$titel$b2</a><td>$record->username</a><TD> $record->slots</tr>";
		} else {
		 	//$empty="$empty<tr bgcolor=666666><td>EMPTY <a href='' onclick=\"locationText('shops', 'viewShop', '$record->ID');return false;\"><font color=white>$b1$titel$b2</a><td>$record->username</a><TD> $record->slots</tr>";
		}

	}
	//$output.="$empty";
	$output.="</table>";
	if($a==''){
	 	$output.="There are no shops at $S_location.<BR>";
	}
}#SHOPSEARCH

}



}else{
 	$output.="There is an event going on at this location, all shops are closed.<BR><a href='' onclick=\"locationText();return false;\">Click here to discover what is going on.</a>";
}



}
?>