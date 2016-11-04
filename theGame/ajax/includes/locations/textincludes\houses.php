<?
if(defined('AZtopGame35Heyam')){

include_once('includes/levels.php');

$resultt = mysqli_query($mysqli, "SELECT ID FROM users WHERE username='$S_user' && (work='move' OR work='sail')  LIMIT 1");
$aana = mysqli_num_rows($resultt);
$resultt = mysqli_query($mysqli, "SELECT ID FROM locations WHERE monstersmuch>0 && (type='invasion' || type='skillevent') && location='$S_location' && startTime<'$timee' LIMIT 1");
$invasions = mysqli_num_rows($resultt);

if($invasions==1 || $aana>=1){ #### INVASION!!

	 $output.="There is an event going on at this location, you cannot enter your house at the moment.<BR><a href='' onclick=\"locationText();return false;\">Click here to discover what is going on.</a>";

}else{

$output.="<center><h1>Player House</h1>";


###################
### BUY A HOUSE
###################

 $resultaat = mysqli_query($mysqli, "SELECT username FROM buildings WHERE location='$S_location' && type='house' && username='$S_user' LIMIT 1");
    $aantal = mysqli_num_rows($resultaat);
if($aantal==0){
		$output.=" You do not own a house at $S_location, you can buy one.<BR>";

		if($var1=='buy'){
			$buyid=$var2;
		}

		## BETAAL
		if($buyid>0){
			  $sql = "SELECT ID, username, slots, saleprice FROM buildings WHERE type='house' && location='$S_location' && ID=$buyid && saleprice>0 LIMIT 1";
			   $resultaat = mysqli_query($mysqli,$sql);
			   while ($record = mysqli_fetch_object($resultaat)) {
			$saleprice=ceil($record->saleprice);
			  $sqla = "SELECT gold FROM users WHERE username='$S_user' LIMIT 1";
			   $resultaaat = mysqli_query($mysqli,$sqla);
			   while ($recorad = mysqli_fetch_object($resultaaat)) {  $gold=$recorad->gold; }
			   echo"$('statsGoldText').innerHTML=\"$gold\";";
			if($saleprice>=0){
				if(payGold($S_user, $saleprice)==1){

				mysqli_query($mysqli,"UPDATE users SET gold=gold+'$saleprice' WHERE username='$record->username' LIMIT 1") or die("error2 --> 1");
				mysqli_query($mysqli,"UPDATE buildings SET username='$S_user', saleprice=0 WHERE ID='$buyid' && type='house' && location='$S_location' LIMIT 1") or die("error2 --> 1");


				$output.="<B>The house has been bought successfully for $saleprice gold, enjoy!</b><BR>";
				$sql = "INSERT INTO messages (username, sendby, message, time, topic)
				  VALUES ('$record->username', '<B>Syrnia</b>', '$S_user has bought your house at $S_location for $saleprice gold. It will take up to 15 minutes to receive the gold.', '$timee', 'House Sold')";
				mysqli_query($mysqli,$sql) or die("error report this bug please33 66 msg  $sendto', '$S_user', '$tekst', '$datum', '$topic'");
			} else{ $output.="<B>You need $saleprice gold but you have got $gold gold.<BR></b>"; }
		}
			}
		} else {
		# OVERZICHTJE
			$saleprice='';
			$output.="<Table cellpadding=4 cellspacing=0>";
			$output.="<tr bgcolor=333333><Td><font color=ffffff>House owner<td><font color=ffffff>Slots<td><font color=ffffff>Farmland<td><font color=ffffff>Price<td></tr>";

			   $sql = "SELECT ID, username, slots, saleprice, farmslots FROM buildings WHERE type='house' && location='$S_location' && saleprice>0 ORDER BY saleprice, slots desc";
			   $resultaat = mysqli_query($mysqli,$sql);
			    while ($record = mysqli_fetch_object($resultaat)) {  $saleprice=ceil($record->saleprice);
			$output.="<tr bgcolor=666666><td>$record->username<TD> $record->slots<Td>$record->farmslots<td>$saleprice<td><a href='' onclick=\"locationText('houses', 'buy', '$record->ID');return false;\">Buy</a></tr>";
			}
			$output.="</table>";
			if($saleprice==''){ $output.="<i>There are no houses for sale here</i><BR>"; }
			}

		##################
		## EINDE GEEN HOUSE
		##################
}else{
##############
## HOUSE ADMIN
##############
   $sql = "SELECT ID,gold, slots,saleprice, farmslots FROM buildings WHERE username='$S_user' && type='house' && location='$S_location' LIMIT 1";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat)) { $houseid=$record->ID; $housegold=$record->gold; $houseslots=$record->slots; $saleprice=$record->saleprice; $salepricee=$record->saleprice;  $farmslots=$record->farmslots;}



$wooddest=$houseslots/2;
if($var1=='destroy' && $housegold<=0){ # DESTOROY

		$output.="You destroyed your house and got $wooddest wood.<BR><a href='' onclick=\"locationText('houses');return false;\">Click here to continue</a>.";
	    $sql = "DELETE FROM buildings WHERE username='$S_user' && ID='$houseid' LIMIT 1";
		mysqli_query($mysqli,$sql) or die("error report this bug 1");
	    $sql = "DELETE FROM houses WHERE ID='$houseid'";
	    mysqli_query($mysqli,$sql) or die("error report this bug 2");
	    $sql = "DELETE FROM farms WHERE building='$houseid'";
	    mysqli_query($mysqli,$sql) or die("error report this bug 2");

		addItem($S_user, 'Wood', $wooddest, 'item', '', '', 1);

} else {

if($var1=='sellHouse'){
		$sellprice=$var2;
		$resultaat = mysqli_query($mysqli, "SELECT ID FROM buildings WHERE ID='$houseid' && gold=0 LIMIT 1");
		   $containsNoGold = mysqli_num_rows($resultaat);

		$resultaat = mysqli_query($mysqli, "SELECT ID FROM farms WHERE building='$houseid'  LIMIT 1");
		   $farmItems = mysqli_num_rows($resultaat);

		$resultaat = mysqli_query($mysqli, "SELECT ID FROM houses WHERE ID='$houseid' && much>0 LIMIT 1");
		   $aantalItems = mysqli_num_rows($resultaat);
		if($aantalItems<1 && $containsNoGold==1 && $farmItems==0){


			if($sellprice>=0 && is_numeric($sellprice)){
				$salepricee=$sellprice;
				mysqli_query($mysqli,"UPDATE buildings SET saleprice='$sellprice' WHERE ID='$houseid' LIMIT 1") or die("error2 --> 1");
			} else {
				$output.="Sell your house:<BR><form onsubmit=\"locationText('houses', 'sellHouse', $('houseSellPrice').value);return false;\">Price:<input type=text id=houseSellPrice class=input><BR><input type=submit value=Sell  class=button></form><br />";
			}


		} else{
			$output.="You need to empty your house before you can sell it. Withdraw all goods and money first, also make sure you have got no farm crops.<br /><br />";
		}
}

### FARM
if($var1=='farm'){ ## FARMING :)!!!

		$limit=time()-345600;
		mysqli_query($mysqli,"UPDATE farms SET dump='fail' WHERE seedstime<$limit && dump<>'fail' LIMIT 10") or die("error2 --> 1");


		if($var2=='plant')
        {
			$output.="<table>";
            $sqla = "SELECT II.ID, II.name, II.much FROM items_inventory II
                LEFT JOIN item_types T ON T.name = II.type
                LEFT JOIN items I ON I.name = II.name
                WHERE II.type='seeds' && II.username='$S_user' ORDER BY I.rank = 0 ASC, I.rank ASC, I.name ASC";
		    $resultaaat = mysqli_query($mysqli,$sqla);
		    while ($record = mysqli_fetch_object($resultaaat)) {  $aj=1;
		 	$output.="<tr><Td><form  onsubmit=\"locationText('work', 'plant', '$record->ID',$('farmForm$record->ID').value );return false;\"> <input type=text class=input id=farmForm$record->ID size=4 value='$record->much'> $record->name ($record->much seeds)</a> <input type=submit value=plant class=button ></form>"; } $output.="</table>";
			if($aj<>1){ $output.="You have got no seeds to plant.<BR>"; }
		}

		$freefarmslots=$farmslots;
		 $sqla = "SELECT seedsmuch FROM farms WHERE building='$houseid'";
		   $resultaaat = mysqli_query($mysqli,$sqla);
		   while ($record = mysqli_fetch_object($resultaaat)) {  $freefarmslots=$freefarmslots-$record->seedsmuch; }

		$output.="Your farmland is capable of holding $farmslots crops, you can seed $freefarmslots more crops.<BR>";
		if($farm<>'plant'){ $output.="<a href='' onclick=\"locationText('houses', 'farm', 'plant');return false;\">Plant seeds</a><BR>"; }
		if($farmslots<400){$output.="<a href=''  onclick=\"locationText('work', 'constructing', 'farmland', '$houseid');return false;\">Expand farmland for ".(($farmslots*2)*30)." gold with space for  ".($farmslots*2)." crops</a><BR><BR>";}


		$farmheight=17*($farmslots/17);
		$output.="<Table border=1 bgcolor=993300><tr><td><Table width=360 height=$farmheight bgcolor=C3A587 border=0><tr height=17>";
		$nummer=0;
		  $sqla = "SELECT ID, seedsmuch, seeds, seedstime, dump FROM farms WHERE building='$houseid'";
		   $resultaaat = mysqli_query($mysqli,$sqla);
		   while ($record = mysqli_fetch_object($resultaaat)) {
		$status=1;  $img=''; $time=time();
		if($record->dump<>'fail' && $record->seedstime<$time){ $status=2;  $img="<a href=''  onclick=\"locationText('work', 'pick', '$record->ID');return false;\"'><img src=images/pixel.gif width=15 height=15 border=0></a>";}
		elseif($record->dump=='fail' && $record->seedstime<$time){ $status=3; $img="<a href=''  onclick=\"locationText('work', 'pick', '$record->ID');return false;\"><img src=images/pixel.gif width=15 height=15 border=0></a>"; }

		$seedsmuch=$record->seedsmuch;
		while($seedsmuch>0){
		if($nummer==20){$output.="</tr><tr height=17>"; $nummer=0; }
		$output.="<td width=17 background='images/ingame/".$record->seeds."$status.gif'>$img";
		$seedsmuch=$seedsmuch-1;
		$nummer=$nummer+1;
		}

		}
		$output.="<tr><td><td><td><td><td><td><td><td><td><td><td><td><td><td><td><td><td></tr></table></td></tr></table>";

}else if($var1=='items'){

		$slotsused=0;
		$sql = "SELECT much FROM houses WHERE ID='$houseid'";
		$resultaat = mysqli_query($mysqli,$sql);
		while ($record = mysqli_fetch_object($resultaat))
		{
			$slotsused=$slotsused+$record->much;
		}
		$slotsfree=$houseslots-$slotsused;

		if($S_disableDragDrop==1){
		  	$output.="<center><b>Item storage:</b><br />";
			$output.="<small>Click on items below to remove them</small><br /><br />";
			$output.="<small id='houseAddOnButton'><a href='' onclick=\"$('houseAddOnButton').hide();$('houseAddOffButton').show();return false;\">Click here</a> to add items</small>";
			$output.="<small id='houseAddOffButton' style=\"display:none;\">You are adding items to the house (Do so by clicking on items in your inventory)<br />";
			$output.="<a href='' onclick=\"$('houseAddOnButton').show();$('houseAddOffButton').hide();return false;\">Click here</a> to stop adding items.</small>";
			$output.="<br /><br />";
			$output.="<small>Move: <input type=text size=3 style=\"border : 0px solid #000000;font-size : 9px;\" value=1 id='moveMuchHouse'></small><br />";
			$output.="<small id='houseSlots'>$slotsfree</small><small> free house slots left</small></center><br /><br /><div id='houseInventory' style=\"text-align:left;width:100%; background-color:black;min-height:100px; border: 0; overflow:auto;\">";
			$output.="</div>";
		}else{
		 	$output.="<center><b>Item storage:</b><br />";
			$output.="<small>Move: <input type=text size=3 style=\"border : 0px solid #000000;font-size : 9px;\" value=1 id='moveMuchHouse'></small><br />";
			$output.="<small id='houseSlots'>$slotsfree</small><small> free house slots left</small></center><br /><br /><div id='houseInventory' style=\"text-align:left;width:100%; background-color:black;min-height:100px; border: 0; overflow:auto;\">";
			$output.="</div>";
		}

//////////////////////////////////////
//// LOAD ALL  ITEMS ONCE
	$houseInventoryContents=$houseInventoryContents='';
  	//$sql = "SELECT NR, name, much, type, itemupgrade, upgrademuch FROM houses WHERE ID='$houseid' && much>0 ORDER BY type asc";


  	$sql = "SELECT H.NR, H.name, H.much, H.type, H.itemupgrade, H.upgrademuch FROM houses H
    LEFT JOIN item_types T ON T.name = H.type
    LEFT JOIN items I ON I.name = H.name
    WHERE H.ID='$houseid' ORDER BY T.rank < 0 ASC, T.rank = 0 ASC, T.rank ASC, H.type ASC, I.rank, H.name ASC, H.itemupgrade ASC, H.upgrademuch ASC";
   	$resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
	 	$imagename=str_replace(' ', '%20', $record->name);
	    if($record->upgrademuch>0){$plus="+"; }else{ $plus=''; }
		if($record->itemupgrade){
		  	$upg=" [$plus$record->upgrademuch $record->itemupgrade]";
		 	$upg2="'images/ingame/$record->itemupgrade.jpg'";
		}else{
			$upg=''; $upg2='null';
		}
		$houseInventoryContents.="+createItemHTML('itemH_$record->NR', '$record->name$upg', '$record->much', $upg2)";

		$houseItemsEvents.="disableSelection($('itemH_$record->NR'));";
	}
	///END LOAD INVENTORY ONCE
		//$houseInventoryContents=str_replace('"','\\\\\"', $houseInventoryContents);


		echo"setTimeout (\"";
		echo"if(\$('houseInventory')){\$('houseInventory').innerHTML='';";

		echo"\$('houseInventory').innerHTML=''$houseInventoryContents;";
		echo"}";
		echo"\", 200);";

		echo"setTimeout (\"";
		echo"$houseItemsEvents";
		if($S_disableDragDrop==1){
			echo"containerClickEvents('houseInventory');";
		}else{
			echo"containerClickEvents('houseInventory');";
			//echo"var container=$('houseInventory');for(var currentChild =container.firstChild;currentChild!=null;currentChild=currentChild.nextSibling){Event.observe(currentChild.id, 'mousedown', function(e){ updateLastMovedItem(Event.element(e)); });}";
		}
		echo "recreateSortable('houseInventory');";
		echo "recreateSortable('playerInventory');";
		echo"\", 400);";




}else{ ## GEEN FARM



if($var1=='withdraw'){
	$withdraw=round($var2);
}else if($var1=='deposit'){
	$deposit=round($var2);
}

if($withdraw>0 && is_numeric($withdraw)){
 	$withdraw=ceil($withdraw);
	if($withdraw>$housegold){$withdraw=$housegold; }
	mysqli_query($mysqli,"UPDATE buildings SET gold=gold-'$withdraw' WHERE ID='$houseid' && username='$S_user' LIMIT 1") or die("error2 --> 1");
	getGold($S_user, $withdraw);
	$housegold=$housegold-$withdraw;
	$gold=$gold+$withdraw;
}elseif($deposit>0 && is_numeric($deposit)){
 	$deposit=ceil($deposit);
   	$sqla = "SELECT gold FROM users WHERE username='$S_user' LIMIT 1";
   	$resultaaat = mysqli_query($mysqli,$sqla);
   	while ($recorad = mysqli_fetch_object($resultaaat))
	{
		$gold=$recorad->gold;
	}
	echo"$('statsGoldText').innerHTML=\"$gold\";";
	if($deposit>=$gold){$deposit=$gold; }
	payGold($S_user, $deposit);
	mysqli_query($mysqli,"UPDATE buildings SET gold=gold+'$deposit' WHERE ID='$houseid' LIMIT 1") or die("error2 --> 1");
	$housegold=$housegold+$deposit;
	$gold=$gold-$deposit;
}

if(!$withdraw && !$deposit && $salepricee<=0){
	 //TEMP DEBUG!
	 include_once('rebuildInventory.php');
}


if($salepricee>=1){

	$output.="Your house is now for sale for $salepricee gold, to cancel click <a href='' onclick=\"locationText('houses', 'sellHouse', 0);return false;\">here</a>.";
	$output.="<BR><a href='' onclick=\"locationText('houses', 'sellHouse');return false;\">Change the price</a><BR><BR>";
} else {

 	$output.="<table width=100%><tr valign=top><td>";

 	$output.="<b>Farming</b><br />";
 	if($farmslots==0){
		$output.="<a href='' onclick=\"locationText('work', 'constructing', 'farmland', '$houseid');return false;\">Build farmland for 750 gold with space for 25 crops</a><BR><BR>";
	} else{
		$output.="<a href='' onclick=\"locationText('houses', 'farm');return false;\">Check your farmlands</a><BR><BR>";
	}

	$output.="<b>Item storage (max. $houseslots)</b><br />";
	$output.="<a href='' onclick=\"locationText('houses', 'items');return false;\">Add or Remove items to my house</a><BR>";
	$output.="<BR>";

	$output.="<b>House</b><br />";
	if($houseslots*2<=$constructingl*1000){
	 	$output.="<a href='' onclick=\"locationText('work', 'constructing', 'houseupgrade');return false;\">Upgrade house to ".($houseslots*2)." house slots for ".($houseslots*4). " wood.</a><BR>";
	}

	$output.="<a href='' onclick=\"locationText('houses', 'sellHouse');return false;\">Sell my house</a><br />";

	if($var1=='destroya'){
	 	if($housegold<=0){
		$output.="<BR><a href='' onclick=\"locationText('houses', 'destroy');return false;\">I am sure, Destroy my house and delete all items. ('Recycle' $wooddest wood)</a><BR>";
		}else{
		$output.="<BR><b>You can not destroy your house as it's got $housegold gold in it.</b><BR>";
		}
	} else {
	 	$output.="<a href='' onclick=\"locationText('houses', 'destroya');return false;\">Destroy my house ('Recycle' $wooddest wood)</a><BR>";
	}

	$output.="</td><td align=center valign=middle>";

	$output.="The house contains $housegold gold.<br /><br />";


	$output.="Withdraw gold:<br />";
	$output.="<form onsubmit=\"locationText('houses', 'withdraw', $('houseWithdrawGold').value);return false;\"><input type=text size=5 id=houseWithdrawGold class=input><input type=submit class=button value=Withdraw></form>";
	//$output.="<td width=20><td>";
	$output.="<br />Deposit gold:<br /><form  onsubmit=\"locationText('houses', 'deposit', $('houseDepositGold').value);return false;\"><input type=text size=5 id=houseDepositGold class=input><input type=submit class=button value=Deposit></form>";

	$output.="</td></tr></table>";



}

} ##



}//destroy


}//invasions


} # EINDE BEZIT HUIS




}
?>