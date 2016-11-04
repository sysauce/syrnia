<?

if(defined('AZtopGame35Heyam')){


## CHECK

include('levels.php');

$IS_A_DRINK=0;

$eat=$itemName;

/*$position=strrpos($itemName, " [");
if($position>0){
	$eat=substr($itemName, 0, $position);
}
else
{
	$eat=$itemName;
}*/

$checkk=1;

if($eat=='Cooked Shrimps'){ $heal=2; }
elseif($eat=='Cooked Frog'){  $heal=2; }
elseif($eat=='Bread'){ $heal=3; $S_drunk=0; }

elseif($eat=='Cooked Piranha'){ $heal=3; }
elseif($eat=='Cooked Catfish'){  $heal=5; }
elseif($eat=='Cooked Giant catfish'){ $heal=10; }
elseif($eat=='Cooked Trouts'){ $heal=7; }
elseif($eat=='Cooked Cod'){ $heal=7; }
elseif($eat=='Cooked Sardine'){ $heal=4; }
elseif($eat=='Cooked Herring'){ $heal=5; }
elseif($eat=='Cooked Queen spider meat'){ $heal=6; }
elseif($eat=='Cooked Mackerel'){ $heal=6; }
elseif($eat=='Cooked Swordfish'){ $heal=14; }
elseif($eat=='Cooked Shark'){ $heal=20; }
elseif($eat=='Cooked Tuna'){ $heal=10; }
elseif($eat=='Cooked Lobster'){ $heal=12; }
elseif($eat=='Cooked Bass'){ $heal=13; }
elseif($eat=='Cooked Pike'){ $heal=8; }
elseif($eat=='Cooked Salmon'){ $heal=9; }
elseif($eat=='Birthday cake'){ $heal=10; }
elseif($eat=='Cake'){ $heal=21; }

elseif($eat=='Cooked Saurus meat'){ $heal=16; }
elseif($eat=='Cooked Platina dragon meat'){ $heal=18; }
elseif($eat=='Cooked Syriet dragon meat'){ $heal=21; }
elseif($eat=='Cooked Obsidian dragon meat'){ $heal=25; }

elseif($eat=='Cooked Parrotfish'){ 	$heal=22; }
elseif($eat=='Cooked Eel'){ 	$heal=24; }
elseif($eat=='Cooked Snapper'){ 	$heal=26; }
elseif($eat=='Cooked Crab'){ 	$heal=28; }
elseif($eat=='Cooked Grouper'){ 	$heal=30; }

elseif($eat=='Radishes'){ $heal=1; }
elseif($eat=='Beet'){ $heal=1; }
elseif($eat=='Carrots'){ $heal=2; }
elseif($eat=='Cabbage'){ $heal=3; }
elseif($eat=='Onion'){ $heal=4; }
elseif($eat=='Tomato'){ $heal=5; }
elseif($eat=='Corn'){ $heal=6; }
elseif($eat=='Strawberry'){ $heal=7; }
elseif($eat=='Green pepper'){ $heal=8; }
elseif($eat=='Spinach'){ $heal=9; }
elseif($eat=='Eggplant'){ $heal=10; }
elseif($eat=='Cucumber'){ $heal=11; }
elseif($eat=='Pumpkin'){ $heal=12; }

elseif($eat=='Apple'){ $heal=13; }
elseif($eat=='Pear'){ $heal=14; }
elseif($eat=='Broccoli'){ $heal=15; }
elseif($eat=='Peach'){ $heal=16; }
elseif($eat=='Orange'){ $heal=17; }
elseif($eat=='Plum'){ $heal=18; }
elseif($eat=='Avocado'){ $heal=19; }
elseif($eat=='Pineapple'){ $heal=20; }
elseif($eat=='Watermelon'){ $heal=21; }
elseif($eat=='Vervefruit'){ $heal=22; }
elseif($eat=='Fruit of life'){$heal=30; }

elseif($eat=='Halloween pumpkin'){  $heal=5; }
elseif($eat=='Beer'){  $heal=0; $drunkplus=30; $IS_A_DRINK=1; }
elseif($eat=='Elven cocktail'){  $heal=1; $drunkplus=60; $IS_A_DRINK=1;  }
elseif($eat=='Keg of rum'){  $heal=1; $drunkplus=600; $IS_A_DRINK=1;  }
elseif($eat=='Red easter egg'){  $heal=5; }
elseif($eat=='Green easter egg'){  $heal=9; }
elseif($eat=='Blue easter egg'){  $heal=13; }
elseif($eat=='Yellow easter egg'){  $heal=17; }
elseif($eat=='Pink easter egg'){ $heal=20; }
elseif($eat=='Black easter egg'){  $heal=20; }
elseif($eat=='White easter egg'){  $heal=20; }
elseif($eat=='Orange easter egg'){  $heal=23; }
elseif($eat=='Purple easter egg'){ $heal=26; }
elseif($eat=='Bronze easter egg'){ $heal=30; }
elseif($eat=='Silver easter egg'){ $heal=35; }
elseif($eat=='Gold easter egg'){ $heal=40; }

elseif($eat=='Zombie brain'){ $heal=rand(-5,20); }

else{
	$checkk=0;
}

## END CHECK
if($checkk==1){


	if($var2!='F' && $var2!='X'){
		reportError($S_user, "invalid food usage($var2) by ".$S_user );
		exit();
	}



  $sql = "SELECT much, name FROM items_inventory WHERE name='$eat' && username='$S_user' LIMIT 1";
   $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
	{

	if($drunkplus){
		if($S_drunk>$timee){
				$S_drunk=$S_drunk+$drunkplus;
		} else {
		 	$S_drunk=time()+$drunkplus;
			$_SESSION["S_drunk"] = $S_drunk;
		}
	}
	$newhp=$hp+$heal;
	if($newhp>$maxhp){
	 	$newhp=$maxhp;
	}else if($newhp<1){
		$newhp=1;
		$heal=$hp-$newhp;
	}
	$hp=$newhp;


	echo"$('statsHPText').innerHTML=\"$hp\";";
	echo"$('statsMaxHPText').innerHTML=\"$maxhp\";";
	echo"setTimeout(\"";
	removeItem($S_user, $eat, 1, '', '', 1);
	echo"\", 500);";

	$perchp=($hp/$maxhp)*100;
	echo'if($(\'fightingHPText\')!=null){$(\'fightHPbar\').width='.$perchp.';$(\'fightingHPText\').innerHTML="'.$hp.'";$(\'fightingMaxHPText\').innerHTML="'.$maxhp.'";removeItemFromContainer(\'fightingFoodTop\', \''.$eat.'\', 1, 1);removeItemFromContainer(\'fightingFoodBottom\', \''.$eat.'\', 1, 1);}';

	  $sqll = "SELECT work, dump2 FROM users WHERE username='$S_user' LIMIT 1";
	   $resultalat = mysqli_query($mysqli,$sqll);
	    while ($record = mysqli_fetch_object($resultalat)) {   $worko=$record->work; $dump2=$record->dump2; }

	if($IS_A_DRINK==1){
		if($heal>0){
	 		$textContent="$S_user drank $eat and gained $heal HP";
	 	}else{
	 		$textContent="$S_user drank $eat and lost $heal HP";
	 	}
	}else{
		if($heal>0){
	 		$textContent="$S_user ate $eat and gained $heal HP";
	 	}else{
	 		$textContent="$S_user ate $eat and lost $heal HP";
	 	}
	}

	if($worko=='fight'){
		$dumpie="<tr><td align=right>$newhp/$maxhp <img src=images/heart.gif /></td><td><i>$textContent</i></td><td></td></tr>";
		//echo"if(\$('fightingLog')){\$('fightingLog').innerHTML=$dumpie+$('fightingLog').innerHTML;}";
	    mysqli_query($mysqli,"UPDATE users SET dump2='$dumpie $dump2' WHERE username='$S_user' LIMIT 1") or die("error --c> 1");
	}




		echo"if(!$('fightingFoodTop')){";
		if($IS_A_DRINK==1){
			if($heal>0){
				echo"messagePopup(\"You drank a $eat and gained $heal HP\", \"$eat\");";
			}else{
		 		echo"messagePopup(\"You drank a $eat and lost $heal HP!\", \"$eat\");";
		 	}
		}else{
			if($heal>0){
		 		echo"messagePopup(\"You ate a $eat and gained $heal HP\", \"$eat\");";
		 	}else{
		 		echo"messagePopup(\"You ate a $eat and lost $heal HP!\", \"$eat\");";
		 	}
		}
	 	echo"}else{";
	 	//Fighting
	 	echo"var trTemp =Builder.node('tr',
		 		[
		 		Builder.node('td', {align: 'right'},
				 	[
				 	'$newhp/$maxhp', Builder.node('img', {src: 'images/heart.gif'})
		 	 		]),
			  	Builder.node('td',
				  	[
		  			Builder.node('i',
				  		[
				  		'$textContent'
				  		])
					]),
			  	Builder.node('td')
			  	]);  $('fightLogTop').insert({ after: trTemp });  ";
	 	echo"}";

	 //trTemp.innerHTML=\"$trContents\";


      	mysqli_query($mysqli,"UPDATE users SET hp='$newhp' WHERE username='$S_user' LIMIT 1") or die("error -a-> 1");


    }


} #checkk
} # define
?>