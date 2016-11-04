<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"updateCenterContents('move', 'Ogre cave entrance 2');return false;\"><font color=white>Enter the ogre cave</a><BR>";
$output.="<a href='' onclick=\"locationText('gate');return false;\"><font color=white>Speak to the Elven gate guards.</a><BR>";
$output.="<a href='' onclick=\"locationText('floral');return false;\"><font color=white>Elven floral boutique</a><BR>";
$output.="<a href='' onclick=\"locationText('jail');return false;\"><font color=white>Jail</font></a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

if($action=='floral'){
	include('textincludes/floral.php');
}elseif($action=='jail'){
	include('textincludes/jail.php');
}elseif($action=='gate'){


	if($var1=='buy'){
		if(payGold($S_user, 5000)==1){
		 	addItem($S_user, 'Elven gate pass', 1, 'key', '', '', 1);
			$output.="You have bought an Elven gate pass.<BR><BR>"; $pass=0;
		} else{
		 	$output.="You do not have enough gold to buy the Elven gate pass!<BR><BR>";
		}
	}

	    $resultaat = mysqli_query($mysqli,  "SELECT username FROM items_inventory WHERE name='Elven gate pass' && username='$S_user' LIMIT 1");
	    $aantal = mysqli_num_rows($resultaat);
	if($aantal==1){

		$output.="Elven gate guard: <i>\"Ok human your gate pass is valid, you can go through.\"</i><BR>";
		$output.="<a href='' onclick=\"updateCenterContents('move', 'Penteza');return false\">Go to Penteza</a>";


	} else {

	$output.="Elven gate guard: <i>\"HALT, because you are not of our kind you need an Elven gate pass to enter!<BR>You can buy an Elven gate pass for 5000 gold.\"</i><BR>";
	$output.="<a href='' onclick=\"locationText('gate', 'buy');return false;\">Buy</a> Elven gate pass for 5000 gold";

	}

}else{
$output.="This is the only way to get to the Elven city, the dangerous sea and its cliffs makes it impossible to sail to the island. To enter the Elven city Penteza you must get through the big Elven gate. It seems like the Elves has got their island under control very well.";

/*
############ TEMP!
$output.="<BR>";
if($chest==1){

if(rand(1,5)==1){  $koop[1][name]="Kanzo teleport orb";
}else{ $koop[1][name]="Penteza teleport orb"; }

$koop[1][type]="magical";
$needKey="Big pirate key";

			$output.="<BR>";
   $resultaat = mysqli_query($mysqli,  "SELECT ID FROM items_inventory WHERE username='$S_user' && name='$needKey' && much>0 LIMIT 1");
   $aantal = mysqli_num_rows($resultaat);

   if($aantal==1){
         $type=$koop[1][type];
		 $name=$koop[1][name];

		 removeItem($S_user, $needKey, 1, '', '', 1);


         $saaql = "INSERT INTO inventory (username, much, type, name)
 VALUES ('$S_user', 1, '$type', '$name')";
mysqli_query($mysqli, $saaql) or die("ER-OR chesty");
   $output.="<B>You open the chest and recieve: <font color=yellow>".$koop[1][name]."</font>!</B><BR>";
   }else{   $output.="<B>You have not got any key which fits!</B><BR>";      }

}else{
    $output.="<BR>
    	<B>Some mysterious chests have been found.</B> <br>
		Built from an undestroyable metal andprotected by magic, the only way to open these seem to be the usual way...<Br/><br />
      <A href=\"?chest=1\">Try to fit your keys on the chest</a><BR>";
   }
############ TEMP!
*/


}


}
}
?>