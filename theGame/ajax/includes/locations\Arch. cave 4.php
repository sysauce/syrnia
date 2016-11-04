<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){


$output.="This cave system is deep inside the earth. You are surprised about the light and the heat of this place. As you look around the corner the lava waterfall answers your questions.<BR>";

if($S_location=='Arch. cave 4.1')
{
	$output.="Above you, you see a dark hole in the wall.<BR>";
	$output.="<A href='' onclick=\"updateCenterContents('move', 'Arch. cave 3.25');return false;\">Enter it</a>";
}


  /*$sql = "SELECT monster FROM partyfight WHERE location='$S_location' && hp>0 LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
	 $output.="<BR>You see a very strong monster at this location, if you gather a group you might be able to kill it.<BR>";
    $output.="<a href='' onclick=\"fighting('$record->monster', 0, 1);return false;\">Fight</a> the <B>$record->monster</B><BR>";
	}*/

if($S_location=='Arch. cave 4.5')
{
    $output.="<br/>";

	if(date("H") == 0 || date("H") == 6 || date("H") == 12 || date("H") == 18)
	{
		$output.= "A break in the lava flow has allowed the lava to cool enough for you to walk over. For a short time, you are able to reach a small opening in the cave wall. " .
			"<a href='' onclick=\"updateCenterContents('move', 'Lost caves 1');return false;\">Move deeper in the cave</a><br/>";
	}
	else if(date("H") == 1 || date("H") == 7 || date("H") == 13 || date("H") == 19)
	{
		$output.="The lava has started flowing here again. It never lasts for long but you won't be able to cross for a while now.<br/>";
	}
	else if(date("H") == 23 || date("H") == 5 || date("H") == 11 || date("H") == 17)
	{
		$output.="The lava here is visibly cooling, but it is not yet solid enough to bear your weight...maybe soon.<br/>";
	}
	else
	{
		$output.="The lava has flowed here recently. The bright orange glow tells you that now is not the time to try and cross!<br/>";
	}
}

if($S_location=='Arch. cave 4.7'){


    $output.="<BR>";
    $output.="The lava is hot enough to smelt various ores into bars, it is although too hot for bronze.<BR>";
    $output.="<A href='' onclick=\"locationText('work', 'smelting','Iron bars');return false;\">Smelt iron bars</a><BR>";
    $output.="<A href='' onclick=\"locationText('work', 'smelting', 'Steel bars');return false;\">Smelt steel bars</a><BR>";
    $output.="<A href='' onclick=\"locationText('work','smelting', 'Gold bars');return false;\">Smelt gold bars</a><BR>";
    $output.="<br/>";

    if(date("w")==0 OR date("w")==6 OR date("w")==5 OR date("w")==3)
    {
        $output.="The current circumstances at this location are perfect to smelt platina.<br/>";
        $output.="In this environment it costs you 8 platina ore, 6 gold ore and 4 coal ore to create one platina bar.<br/>";
        $output.="The costs could differ if the environment changes, but it has been stable so far...<br/>";
        $output.="<A href='' onclick=\"locationText('work', 'smelting', 'Platina bars');return false;\">Smelt platina bars</a><BR>";

        $output.="<br />The conditions are even well enough for Syriet! But if this'll remain like that is even more unsure...<br />";
        $output.="<A href='' onclick=\"locationText('work', 'smelting', 'Syriet bars');return false;\">Smelt Syriet bars</a><BR>";

    }else{
        $output.="The current circumstances at this location are not good enough to smelt platina.<br/>";
        $output.="It has been better..perhaps try again later ?<br/>";
    }

}



if($S_location=='Arch. cave 4.4'){
  $sql = "SELECT monsters,itemtype,dump, monstersmuch FROM locations WHERE location='$S_location' && type='resource' && monstersmuch>0";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
	    if($record->dump=='ore'){
	    	$output.="<BR>";
	    	$output.="The rock walls contain small shining layers, this looks like a rare ore.<BR>";
	   		$output.="<A href='' onclick=\"locationText('work', 'mining', '$record->monsters', 'rare');return false;\">$record->itemtype [$record->monstersmuch left]</a><BR>";
	   }
   }
}

if($S_location=='Arch. cave 4.5'){
  $sql = "SELECT monsters,itemtype,dump, monstersmuch FROM locations WHERE location='$S_location' && type='resource' && monstersmuch>0";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
	    if($record->dump=='ore'){
	    	$output.="<BR>";
	    	$output.="The rock walls contain small shining layers, this looks like a rare ore.<BR>";
	   		$output.="<A href='' onclick=\"locationText('work', 'mining', '$record->monsters', 'rare');return false;\">$record->itemtype [$record->monstersmuch left]</a><BR>";
	   }
   }
}




if($S_location=='Arch. cave 4.2'){

if($action=='tempa'){

$output.="<hr>";
$output.="So, they think I died down here? I already wondered why they didn't search for me..<BR>";
$output.="I do pretty well down here, there is enough water in the dampy cave systems and I kill the dinosaur for the meat their and precious scales and hides.<BR>";
$output.="Crafting a lot of scales and hide I learned how to create very powerfull Saurus armour, I began learning crafting hide using the bat hides.<BR>";
$output.="<BR>";
$output.="Have you got some hides and scales? I can process them into some armour for you.<BR>";
$output.="<BR>";

$koop[1][name]="Bat-hide boots";
$koop[1][type]="shoes";
$koop[1][cost1]="Bat hide";
$koop[1][cost1much]="10";
$koop[1][cost2]="";
$koop[1][cost2much]="";
$koop[1][costgold]="750";

$koop[2][name]="Bat-hide gloves";
$koop[2][type]="gloves";
$koop[2][cost1]="Bat hide";
$koop[2][cost1much]="8";
$koop[2][cost2]="";
$koop[2][cost2much]="";
$koop[2][costgold]="500";

$koop[3][name]="Saurus helm";
$koop[3][type]="helm";
$koop[3][cost1]="Saurus scale";
$koop[3][cost1much]="3";
$koop[3][cost2]="Saurus hide";
$koop[3][cost2much]="3";
$koop[3][costgold]="3000";

$koop[4][name]="Saurus shield";
$koop[4][type]="shield";
$koop[4][cost1]="Saurus scale";
$koop[4][cost1much]="6";
$koop[4][cost2]="Saurus hide";
$koop[4][cost2much]="4";
$koop[4][costgold]="3500";

$koop[5][name]="Saurus legs";
$koop[5][type]="legs";
$koop[5][cost1]="Saurus scale";
$koop[5][cost1much]="5";
$koop[5][cost2]="Saurus hide";
$koop[5][cost2much]="6";
$koop[5][costgold]="4000";

$koop[6][name]="Saurus plate";
$koop[6][type]="body";
$koop[6][cost1]="Saurus scale";
$koop[6][cost1much]="8";
$koop[6][cost2]="Saurus hide";
$koop[6][cost2much]="6";
$koop[6][costgold]="5000";

$i=1;
while($i<=6){

	if($var1=='buy' && $i==$var2){
			$output.="<BR>";

			$need1=$koop[$i][cost1];
			$need1much=$koop[$i][cost1much];
			$need2=$koop[$i][cost2];
			$need2much=$koop[$i][cost2much];
			$goldcost=$koop[$i][costgold];

   $resultaat = mysqli_query($mysqli,  "SELECT ID FROM users WHERE username='$S_user' && gold>=$goldcost");
   $aantal = mysqli_num_rows($resultaat);

   $resultaat = mysqli_query($mysqli,  "SELECT ID FROM items_inventory WHERE name='$need1' && much>='$need1much' && username='$S_user' LIMIT 1");
   $aantal2 = mysqli_num_rows($resultaat);

   $aantal3=1;
   if($need2){
   $resultaat = mysqli_query($mysqli,  "SELECT ID FROM items_inventory WHERE name='$need2' && much>='$need2much' && username='$S_user' LIMIT 1");
   $aantal3 = mysqli_num_rows($resultaat);     }

   if($aantal==1 && $aantal2==1 && $aantal3==1 && $goldcost>0){

   		payGold($S_user, $goldcost);
   		removeItem($S_user, $need1, $need1much, '', '', 1);
         if($need2){
	        removeItem($S_user, $need2, $need2much, '', '', 1);
     	}

         $type=$koop[$i][type];          $name=$koop[$i][name];
         addItem($S_user, $name, 1, $type, '', '', 1);


   $output.="<B>You exchanged some resources for a ".$koop[$i][name]."!</B><BR>";
   }else{
    	$output.="<B>You have not got enough resources to exchange.</B><BR>";
    }


					$output.="<BR>";
	}

$output.="Exchange ".$koop[$i][costgold]." gold, ".$koop[$i][cost1much]."  ".$koop[$i][cost1];
if($koop[$i][cost2much]){  $output.=", ".$koop[$i][cost2much]."  ".$koop[$i][cost2]; }
$output.=" for a <a href='' onclick=\"locationText('tempa', 'buy', '$i');return false;\">".$koop[$i][name]."</a><BR>";
   $i++;
}
$output.="<BR><HR>";


}else{
    $output.="<BR>Archeologist Tempa has got a tent here,   <A href='' onclick=\"locationText('tempa');return false;\">Talk to tempa</a><BR>";
   }


}






}
}
?>