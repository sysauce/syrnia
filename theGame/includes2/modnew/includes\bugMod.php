<?
if(defined('AZtopGame35Heyam') && $S_staffRights['bugsMod']==1){


$time=time();


echo"<ul>";
echo"<li><a href=?page=$page&forum=1>Bug department forum</a><br />";
echo"<li><a href=?page=$page&action=deaths>Check deaths</a><br />";
echo"<li><a href=?page=$page&action=pickup>Check pickups/drops/deaths</a><br />";
echo"<li><a href=?page=$page&action=changeitems>Add items</a><br />";
echo"<li><a href=?page=$page&action=removeinventory>Change items in inventory</a><br />";
echo"<li><a href=?page=$page&action=stockhouses>Check stockhouses</a><br />";
echo"<li><a href=?page=$page&action=partyisland>Check party island sail location</a><br />";


echo"</ul>";
echo"<hr>";

echo"<script type=\"text/javascript\">
function enableAreaByTickbox(ennableOrDisableMe){
	$(ennableOrDisableMe).disabled=!$(ennableOrDisableMe).disabled;
}
//function enableAreaByArea(ennableOrDisableMe, tickb){
//	$(ennableOrDisableMe).disabled=!$(ennableOrDisableMe).disabled;
//	$(tickb).checked=!$(tickb).checked;
//}
</script>";




if($action=='deaths'){

	echo"<form action='' method=post>
	Username: <input type=text name=userDeath><input type=submit value=check>
	</form><hr />";

	if($userDeath){

		$swql = "SELECT tekst FROM zlogs WHERE titel LIKE 'Fight death $userDeath%' order by ID desc";
	    $resultat = mysqli_query($mysqli, $swql);
	    while ($rec = mysqli_fetch_object($resultat))
	    {
	    	echo"<b>$userDeath Died</b><br />";
	    	echo nl2br(htmlentities($rec->tekst))."<hr />";
    	}
	}

}else if($action=='pickup'){

	echo "This log is purged now and then, we can't save infinite data.";
	echo "But it should always contain at least the last month, and at moment of introduction even 6 months+.<br />";

	echo "<table><form action='' method=post>";
	echo "<tr><td><b>Username</b></td><td><input type=text  name=dropUser></tr>";
	echo "<tr><td><b>Location</b></td><td><input type=text  name=location></tr>";
	echo "<tr><td></td><td><input type=submit value=edit></tr>";
	echo"</form></table>";

	if(	strlen($dropUser)>=3 || strlen($location)>=3	){
		if($dropUser && $location){
			$searchFilter="(titel LIKE 'Fight death $dropUser%' OR titel='Drop $dropUser' OR titel='Pickup $dropUser') && tekst like '%$location%'";
		}else if($dropUser){
			$searchFilter="(titel LIKE 'Fight death $dropUser%' OR titel='Drop $dropUser' OR titel='Pickup $dropUser')";
		}else{
			$searchFilter="(titel LIKE 'Fight death %' OR titel LIKE 'Drop %' OR titel LIKE 'Pickup %') && tekst like '%$location%'";
		}
		echo"<table border=1>";
		$sql = "SELECT titel, tekst,time FROM zlogs WHERE $searchFilter ORDER BY ID DESC LIMIT 500";
		$resultaat = mysqli_query($mysqli, $sql);
		while ($record = mysqli_fetch_object($resultaat))
		{
			$date = date("d-m-Y H:i", $record->time);
			echo"<tr valign=top><td>$date<br /><b>$record->titel</b></td><td><small>".htmlentities($record->tekst)."</small></td></tr>";
		}
		echo"</table><small>Max 250 results, most recent first</small>";

	}

}else if($action=='changeitems'){


$itemUpgrade[0]['type']='Aim';
$itemUpgrade[0]['much']=1;
$itemUpgrade[1]['type']='Aim';
$itemUpgrade[1]['much']=2;
$itemUpgrade[2]['type']='Aim';
$itemUpgrade[2]['much']=3;
$itemUpgrade[3]['type']='Armour';
$itemUpgrade[3]['much']=1;
$itemUpgrade[4]['type']='Armour';
$itemUpgrade[4]['much']=2;
$itemUpgrade[5]['type']='Armour';
$itemUpgrade[5]['much']=3;
$itemUpgrade[6]['type']='Durability';
$itemUpgrade[6]['much']=0;
$itemUpgrade[7]['type']='Durability';
$itemUpgrade[7]['much']=1;
$itemUpgrade[8]['type']='Durability';
$itemUpgrade[8]['much']=2;
$itemUpgrade[9]['type']='Durability';
$itemUpgrade[9]['much']=3;
$itemUpgrade[10]['type']='Durability';
$itemUpgrade[10]['much']=4;
$itemUpgrade[11]['type']='Power';
$itemUpgrade[11]['much']=1;
$itemUpgrade[12]['type']='Power';
$itemUpgrade[12]['much']=2;
$itemUpgrade[13]['type']='Power';
$itemUpgrade[13]['much']=3;

$itemUpgrade[14]['type']='Travel time';
$itemUpgrade[14]['much']=-1;
$itemUpgrade[15]['type']='Travel time';
$itemUpgrade[15]['much']=-2;
$itemUpgrade[16]['type']='Travel time';
$itemUpgrade[16]['much']=-3;
$itemUpgrade[17]['type']='Travel time';
$itemUpgrade[17]['much']=-4;
$itemUpgrade[18]['type']='Travel time';
$itemUpgrade[18]['much']=-5;
$itemUpgrade[19]['type']='Travel time';
$itemUpgrade[19]['much']=-6;

///Add item
if($additem==1){
	$resultaat = mysqli_query($mysqli,  "SELECT username FROM users WHERE username='$useradditem'  LIMIT 1");
  	$aantal = mysqli_num_rows($resultaat);
	if($aantal>0 && is_numeric($muchadditem) && $muchadditem>0 && $nameadditem){
		if($nameadditem=="gold"){
			getGold($useradditem, $muchadditem);
			modlog($useradditem,'bug-additem', "added $muchadditem gold to $useradditem", 0, $timee, $S_user, $Sreal_IP, 0 );
			echo"<font color=green>Gold added!</font><BR>";
		}else{
			$itemtype='';
			$sqal = "SELECT type, name FROM items WHERE name='$nameadditem' LIMIT 1";
		   $resultaaaat = mysqli_query($mysqli, $sqal);
		    while ($record = mysqli_fetch_object($resultaaaat)) {$itemtype=$record->type; $itemname=$record->name; }

		    $upgrade = $upgradeMuch = '';
		    if(selectItemUpgrade!=-1){
				$upgrade = $itemUpgrade[$selectItemUpgrade]['type'];
		    	$upgradeMuch = $itemUpgrade[$selectItemUpgrade]['much'];
		    }
			if($itemtype && $itemname){
				$whatHappened = "Added item to $useradditem (" . trim("$muchadditem $itemname $upgrade $upgradeMuch") . ")";
				echo$whatHappened;
				addItem($useradditem, $itemname, $muchadditem, $itemtype, $upgrade, $upgradeMuch, 0);
				modlog($useradditem,'bug-additem', $whatHappened, 0, $timee, $S_user, $Sreal_IP, 0 );
				echo" <font color=green>Item added!</font><BR>";
			}else{
				echo"<font color=red><B>WRONG ITEM NAME, NO ITEM ADDED</B></font><br />";
			}
		}

	}else{
		echo"<font color=red>ERROR: No such username?</font><br />";
	}
}


echo"<B>Add item/gold</b>:
<Table><tr><td>
<form action='' method=post>
<input type=hidden name=additem value=1>
<Tr><td>Username<td><input type=text name=useradditem>
<tr><td>Item name (OR \"gold\" for cash)<td><input type=text name=nameadditem>
<tr><td>Upgrade </td><td> <select name='selectItemUpgrade'><option value=-1></option>";

for($i=0;$itemUpgrade[$i]['type'];$i++){
	echo"<option value=$i>".$itemUpgrade[$i]['much']." ".$itemUpgrade[$i]['type']."</option>";
}
echo"</select></td></tr>
<tr><td>How much ?<td><input type=text name=muchadditem>
<tr><td><td><input type=submit></table>
</form><BR><BR><HR>";

}else if($action=='removeinventory'){

echo"<B>Change items in inventory</b>:
<Table><tr><td>
<form action='' method=post>
<Tr><td>Username<td><input type=text name=username>
<tr><td><td><input type=submit></table>
</form><BR><BR><HR>";

if($username){
	$resultaat = mysqli_query($mysqli,  "SELECT username FROM users WHERE username='$username'  LIMIT 1");
  	$aantal = mysqli_num_rows($resultaat);
 	if($aantal!=1){
 		echo"No such username!";
 	}else{

	 	if(is_numeric($itemID) && is_numeric($amount)){

			$sqal = "SELECT ID, name, much, itemupgrade, upgrademuch FROM items_inventory WHERE username='$username' && ID='$itemID' LIMIT 1";
		   	$resultaaaat = mysqli_query($mysqli, $sqal);
		    while ($record = mysqli_fetch_object($resultaaaat))
			{
				$oldItem="$record->much $record->name [ $record->itemupgrade $record->upgrademuch ]";
			}
			$whatHappened = "Changed amount. New amount= $amount for item: ($oldItem)";
			if($amount<=0){
				mysqli_query($mysqli,  "DELETE FROM items_inventory WHERE username='$username' && ID='$itemID' LIMIT 1");
			}else{
				mysqli_query($mysqli,  "UPDATE items_inventory SET much='$amount' WHERE username='$username' && ID='$itemID' LIMIT 1");
			}
			echo"<font color=green>$whatHappened</font><br />";
			modlog($username,'bug-inventory', $whatHappened, 0, $timee, $S_user, $Sreal_IP, 0 );
	 	}

	 	echo"<table border=1>";
		$sqal = "SELECT ID, name, much, itemupgrade, upgrademuch FROM items_inventory WHERE username='$username' ORDER BY name ASC";
	   	$resultaaaat = mysqli_query($mysqli, $sqal);
	    while ($record = mysqli_fetch_object($resultaaaat))
		{
			echo"<tr><td><form action='' method=post><input type=hidden name=username value='$username'><input type=hidden name=itemID value='$record->ID'><input type=text size=2 name=amount value='$record->much'><input type=submit value=change></form></td><td><img border=0 src=\"http://www.syrnia.com/images/inventory/".$record->name.".gif\" /></td><td>$record->name [ $record->itemupgrade  $record->upgrademuch]</tr>";
		}
		echo"</table>";
	}
}

	echo"<B>Equipment</b>:
<Table><tr><td>
<form action='' method=post>
<Tr><td>Username<td><input type=text name=usernameEquipment>
<tr><td><td><input type=submit></table>
</form><BR><BR><HR>";

if($usernameEquipment){
	$resultaat = mysqli_query($mysqli,  "SELECT username FROM users WHERE username='$usernameEquipment'  LIMIT 1");
  	$aantal = mysqli_num_rows($resultaat);
 	if($aantal!=1){
 		echo"No such username!";
 	}else{

	 	if(is_numeric($itemID)){

			$sqal = "SELECT ID, name, much, itemupgrade, upgrademuch FROM items_wearing WHERE username='$usernameEquipment' && ID='$itemID' LIMIT 1";
		   	$resultaaaat = mysqli_query($mysqli, $sqal);
		    while ($record = mysqli_fetch_object($resultaaaat))
			{
				$oldItem="$record->much $record->name [ $record->itemupgrade $record->upgrademuch ]";
			}
			$whatHappened = "Removed equipped item: ($oldItem)";
			mysqli_query($mysqli,  "DELETE FROM items_wearing WHERE username='$username' && ID='$itemID' LIMIT 1");

			echo"<font color=green>$whatHappened</font><br />";
			modlog($usernameEquipment,'bug-inventory', $whatHappened, 0, $timee, $S_user, $Sreal_IP, 0 );
	 	}

	 	echo"<table border=1>";
		$sqal = "SELECT ID, name,  itemupgrade, upgrademuch FROM items_wearing WHERE username='$usernameEquipment' ORDER BY name ASC";
	   	$resultaaaat = mysqli_query($mysqli, $sqal);
	    while ($record = mysqli_fetch_object($resultaaaat))
		{
			echo"<tr><td><form action='' method=post><input type=hidden name=usernameEquipment value='$usernameEquipment'><input type=hidden name=itemID value='$record->ID'><input type=submit value=remove></form></td><td><img border=0 src=\"http://www.syrnia.com/images/inventory/".$record->name.".gif\" /></td><td>$record->name [ $record->itemupgrade  $record->upgrademuch]</tr>";
		}
		echo"</table>";
	}
}

}else if($action=='stockhouses'){

    echo "<form action='' method='post'>";

    echo "Clan tag: <input type='text' name='clantag' value='$clantag' size=15> &nbsp;
        <input type=submit class='button' value='Search'>";

    echo "</form>";

    if($clantag)
    {
        echo "<style>
                table.stockhouseLog
                {
                    border-collapse:collapse;
                    text-align: left;
                }
                table.stockhouseLog th,td
                {
                    border-bottom: 1px solid white;
                    padding: 2px 5px 2px 5px;
                }
                table.stockhouseLog tr:hover
                {
                    background-color: #111;
                    color: #FFF;
                }
            </style>";

        $sql = "SELECT * FROM clanbuildings WHERE tag='$clantag' ORDER BY location ASC";
        $resultset = mysqli_query($mysqli,$sql);
        if($record = mysqli_fetch_object($resultset))
        {
            $stockhouseDropdown = "<option value=''>All stockhouses</option>";
            do
            {
                $stockhouseDropdown .= "<option value='$record->ID'" . ($filterStockhouseID == $record->ID ? " selected='selected'" : "") . ">$record->location</option>";
            }while($record = mysqli_fetch_object($resultset));

            echo "<form action='' method='post'><input type='hidden' name='clantag' value='$clantag'>";

            echo "<select name='filterStockhouseID'>$stockhouseDropdown</select> &nbsp;
                Person: <input type='text' name='filterUsername' value='$filterUsername' size=15> <br/>
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

            $filter = false;

            $filters = " AND action != 'requestItem'";
            $urlCriteria = "&amp;clantag=$clantag";
            if($filterStockhouseID)
            {
                $filters .= " AND clanbuildingID = '$filterStockhouseID'";
                $urlCriteria .= "&amp;filterStockhouseID=$filterStockhouseID";
            }

            if($filterUsername)
            {
                $filters .= " AND user = '$filterUsername'";
                $urlCriteria .= "&amp;filterUsername=$filterUsername";
                $filter = true;
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

                $filter = true;
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

            if($filter)
            {
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
                            $paginationControls .= "<a href='?page=$page&action=stockhouses$urlCriteria&amp;startAt=" . ($startAt - $maxPerPage) . "'> &lt; </a> &nbsp; ";
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
                                $paginationControls .= "<a href='?page=$page&action=stockhouses$urlCriteria&amp;startAt=" . ($i * $maxPerPage - ($maxPerPage)) . "$urlCriteria'>$i</a> &nbsp; ";
                            }
                            else if($i == 6 || $i == $totalPages - 5 && $totalPages - 5 > 13 && strpos($paginationControls, " ... ", strlen($paginationControls) - 5) === 0)
                            {
                                $paginationControls .= " ... ";
                            }
                        }
                        if($startAt < $totalPages * $maxPerPage - $maxPerPage)
                        {
                            $paginationControls .= "<a href='?page=$page&action=stockhouses$urlCriteria&amp;startAt=" . ($startAt + $maxPerPage) . "'> &gt; </a>";
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
                                    $typeSQL = "Requested";
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
                }
                else
                {
                    echo "No logs matched your search.";
                }
            }
            else
            {
                echo "You must enter a player or item to search for.";
            }
        }
        else
        {
            echo "Incorrect tag or the clan [$clantag] has no stockhouse.";
        }
    }

}else if($action=='partyisland'){

echo"<B>Enter names to check sail location</b> (comma seperated):
<Table><tr><td>
<form action='' method=post>
<Tr><td>Usernames <td><input type=text name=usernames>
<tr><td><td><input type=submit></table>
</form><BR><HR>";

if($usernames){
    $split = split(",", $usernames);
    $usernames = "";
    for($i = 0; $i < count($split); $i++)
    {
        $usernames .= ($i == 0 ? "" : ",") . "'" . trim($split[$i]) . "'";
    }
    $sql = "SELECT username, partyIslandSailLocation FROM users_junk WHERE username IN ($usernames)";
	$resultaat = mysqli_query($mysqli,  $sql);
  	$aantal = mysqli_num_rows($resultaat);
 	if($aantal <= 0){
 		echo"Error!";
 	}else{

	 	echo"<table border=1>";
		$resultaat = mysqli_query($mysqli,  "SELECT username, partyIslandSailLocation FROM users_junk WHERE username IN ($usernames)");
	    while($record = mysqli_fetch_object($resultaat))
		{
			echo"<tr><td>$record->username</td><td>$record->partyIslandSailLocation</td></tr>";
		}
		echo"</table>";
	}
}
}

else{

	$bugforum=1;
	include('forum.php');

}









}
?>