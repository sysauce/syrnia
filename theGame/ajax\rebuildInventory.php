<?
if(defined('AZtopGame35Heyam')){

if(!$S_user){
	echo"window.location=\"index.php?page=logout&error=noUser&from=cC\";";
  	exit();
}



//////////////////////////////////////
//// LOAD ALL ITEMS ONCE

    $cookedHP = 0;
    $rawHP = 0;
	$itemcreates='';
	$divjs='';
	$playerInventoryContents=$playerInventoryEvents='';
  	$sql = "SELECT II.ID, II.name, II.much, II.type, II.itemupgrade, II.upgrademuch, I.rank FROM items_inventory II
    LEFT JOIN item_types T ON T.name = II.type
    LEFT JOIN items I ON I.name = II.name
    WHERE II.username='$S_user' ORDER BY T.rank < 0 ASC, T.rank = 0 ASC, T.rank ASC, II.type ASC, I.rank, II.name ASC, II.itemupgrade ASC, II.upgrademuch ASC";
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

        if($record->type == 'cooked food')
        {
            $cookedHP += $record->rank * $record->much;
        }
        else if($record->type == 'food')
        {
            $rawHP += $record->rank * $record->much;
        }

        //$divjs .= "iDMDPI('itemI_$record->ID');";
		$itemcreates.="createItemHTML('itemI_$record->ID', '$record->name$upg', '$record->much', $upg2)+";
		$playerInventoryEvents.="disableSelection($('itemI_$record->ID'));";
	}
	if($itemcreates){
		echo"\$('playerInventory').innerHTML=$itemcreates'';$divjs";
	}else{
		echo"\$('playerInventory').innerHTML='';";
	}

    $inventoryStats = "";
    if($cookedHP > 0 || $rawHP > 0)
    {
        $inventoryStats = ($cookedHP > 0 ? "HP: " . number_format($cookedHP, 0, '.', ',') : "").
                ($cookedHP > 0 && $rawHP > 0 ? "&nbsp;&nbsp;" : "") .
                ($rawHP > 0 ? "Raw: " . number_format($rawHP, 0, '.', ','): "");
    }

	echo $playerInventoryEvents;

	echo"containerClickEvents('playerInventory');";
	echo"recreateSortable('playerInventory');";
	echo"\$('inventoryStats').innerHTML='$inventoryStats';";
	///END LOAD INVENTORY ONCE

}
?>