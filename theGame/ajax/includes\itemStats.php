<?php
if(defined('AZtopGame35Heyam') && $S_user){


	$armour=0;
	$aim=0;
	$power=0;
	$upgaim=0;
	$upgarmour=0;
	$upgpower=0;
	$upgtraveltime=0;
	$helmarmour=0;
	$legsarmour=0;
	$shieldarmour=0;
	$bodyarmour=0;
	$weapaim=0;
	$glovesarmour=0;
	$shoesarmour=0;
	$weappower=0;


	$shield=''; $legs='';
	$helm=''; 	$body='';
	$hand=''; 	$gloves='';
	$shoes=''; 	$horsey='';


	$sql = "SELECT name, type,upgrademuch, itemupgrade FROM items_wearing WHERE username='$userName' LIMIT 9";
	$resultaat = mysqli_query($mysqli,$sql);
	while ($record = mysqli_fetch_object($resultaat)) {

	if($record->type!='trophy'){
		if($record->itemupgrade=='Armour'){  $upgarmour=$upgarmour+$record->upgrademuch;}
		elseif($record->itemupgrade=='Aim'){$upgaim=$upgaim+$record->upgrademuch; }
		elseif($record->itemupgrade=='Power'){ $upgpower=$upgpower+$record->upgrademuch;}
		elseif($record->itemupgrade=='Travel time'){$upgtraveltime=$upgtraveltime+$record->upgrademuch; }
	}
	if($record->type=='trophy'){
		$trophy=$record->name;
	}else if($record->type=='body'){
	######### BODY
		if($record->itemupgrade){
		 	$bodyUpgrade="<img src='images/ingame/$record->itemupgrade.jpg' />";
		 	$upgbody="[$plus$record->upgrademuch $record->itemupgrade]";
		}

		if($record->name=='Koban shirt'){$bodyarmour=1;  $armour+=$bodyarmour;  $body=$record->name;  }
		elseif($record->name=='Lion vest'){$bodyarmour=3; $armour=$armour+$bodyarmour;  $body=$record->name;  }

		elseif($record->name=='Bronze chainmail'){$bodyarmour=4; $armour=$armour+$bodyarmour;  $body=$record->name;  }
		elseif($record->name=='Bronze plate'){ $bodyarmour=6; $armour=$armour+$bodyarmour;   $body=$record->name; $bodyarmour=6; }
		elseif($record->name=='Iron chainmail'){$bodyarmour=8;  $armour=$armour+$bodyarmour;  $body=$record->name; }
		elseif($record->name=='Iron plate'){ $bodyarmour=10; $armour=$armour+$bodyarmour;   $body=$record->name;  }
		elseif($record->name=='Ogre plate'){$bodyarmour=12;  $armour=$armour+$bodyarmour;  $body=$record->name; }
		elseif($record->name=='Steel chainmail'){$bodyarmour=13;  $armour=$armour+$bodyarmour;  $body=$record->name; }
		elseif($record->name=='Steel plate'){ $bodyarmour=18; $armour=$armour+$bodyarmour;   $body=$record->name;  }
		elseif($record->name=='Equites tunic'){ $bodyarmour=22; $armour=$armour+$bodyarmour;   $body=$record->name;  }

		elseif($record->name=='Rose crest plate mail'){$bodyarmour=16;  $armour=$armour+$bodyarmour;  $body=$record->name; }
		elseif($record->name=='Elven plate'){ $bodyarmour=23; $armour=$armour+$bodyarmour;   $body=$record->name;  }
		elseif($record->name=='Silver chainmail'){$bodyarmour=20;  $armour=$armour+$bodyarmour;  $body=$record->name; }
		elseif($record->name=='Silver plate'){ $bodyarmour=24; $armour=$armour+$bodyarmour;   $body=$record->name;  }
		elseif($record->name=='Saurus plate'){ $bodyarmour=28; $armour=$armour+$bodyarmour;   $body=$record->name;  }
		elseif($record->name=='Gold chainmail'){$bodyarmour=25;  $armour=$armour+$bodyarmour;  $body=$record->name; }
		elseif($record->name=='Gold plate'){ $bodyarmour=28; $armour=$armour+$bodyarmour;   $body=$record->name;  }
		elseif($record->name=='Retiarii extended manica'){ $bodyarmour=26; $armour=$armour+$bodyarmour;   $body=$record->name;  }

		elseif($record->name=='Platina chainmail'){$bodyarmour=30;  $armour=$armour+$bodyarmour;  $body=$record->name; }
		elseif($record->name=='Platina plate'){ $bodyarmour=35; $armour=$armour+$bodyarmour;   $body=$record->name;  }
		elseif($record->name=='Syriet chainmail'){$bodyarmour=40;  $armour=$armour+$bodyarmour;  $body=$record->name; }
		elseif($record->name=='Syriet plate'){ $bodyarmour=45; $armour=$armour+$bodyarmour;   $body=$record->name;  }
		elseif($record->name=='Obsidian chainmail'){$bodyarmour=50;  $armour=$armour+$bodyarmour;  $body=$record->name; }
		elseif($record->name=='Obsidian plate'){ $bodyarmour=60; $armour=$armour+$bodyarmour;   $body=$record->name;  }
		elseif($record->name=='Dragon plate'){ $bodyarmour=70; $armour=$armour+$bodyarmour;   $body=$record->name;  }
		elseif($record->name=='Puranium chainmail'){$bodyarmour=70;  $armour=$armour+$bodyarmour;  $body=$record->name; }
		elseif($record->name=='Puranium plate'){ $bodyarmour=80; $armour=$armour+$bodyarmour;   $body=$record->name;  }
		else{$bodyarmour=0;  $body=$record->name; }

	############# SHIELD
	}elseif($record->type=='shield'){
	 if($record->itemupgrade){
	 	$shieldUpgrade="<img src='images/ingame/$record->itemupgrade.jpg' />";
	 	$upgshield="[$plus$record->upgrademuch $record->itemupgrade]";
	}
	if($record->name=='Bronze small shield'){  $shieldarmour=1;  $armour=$armour+$shieldarmour; $shield=$record->name;}
	elseif($record->name=='Bronze medium shield'){$shieldarmour=2; $armour=$armour+$shieldarmour;  $shield=$record->name;}
	elseif($record->name=='Bronze large shield'){$shieldarmour=3; $armour=$armour+$shieldarmour;  $shield=$record->name;}
	elseif($record->name=='Iron small shield'){  $shieldarmour=4; $armour=$armour+$shieldarmour;  $shield=$record->name;}
	elseif($record->name=='Iron medium shield'){$shieldarmour=5; $armour=$armour+$shieldarmour;  $shield=$record->name;}
	elseif($record->name=='Iron large shield'){$shieldarmour=6; $armour=$armour+$shieldarmour; $shield=$record->name;}
	elseif($record->name=='Steel small shield'){ $shieldarmour=7; $armour=$armour+$shieldarmour; $shield=$record->name;}
	elseif($record->name=='Steel medium shield'){$shieldarmour=8; $armour=$armour+$shieldarmour; $shield=$record->name;}
	elseif($record->name=='Steel large shield'){$shieldarmour=9; $armour=$armour+$shieldarmour; $shield=$record->name;}
	elseif($record->name=='Rose crest shield'){$shieldarmour=10; $armour=$armour+$shieldarmour; $shield=$record->name;}
	elseif($record->name=='Equites shield'){$shieldarmour=12; $armour=$armour+$shieldarmour; $shield=$record->name;}

	elseif($record->name=='Silver small shield'){ $shieldarmour=10; $armour=$armour+$shieldarmour;  $shield=$record->name;}
	elseif($record->name=='Silver medium shield'){$shieldarmour=11; $armour=$armour+$shieldarmour;  $shield=$record->name;}
	elseif($record->name=='Silver large shield'){$shieldarmour=12; $armour=$armour+$shieldarmour;$shield=$record->name;}
	elseif($record->name=='Gold small shield'){ $shieldarmour=13; $armour=$armour+$shieldarmour;  $shield=$record->name;}
	elseif($record->name=='Gold medium shield'){$shieldarmour=14; $armour=$armour+$shieldarmour;  $shield=$record->name;}
	elseif($record->name=='Gold large shield'){$shieldarmour=16; $armour=$armour+$shieldarmour;  $shield=$record->name;}
	elseif($record->name=='Saurus shield'){$shieldarmour=17; $armour=$armour+$shieldarmour;  $shield=$record->name;}
	elseif($record->name=='Platina small shield'){ $shieldarmour=17; $armour=$armour+$shieldarmour; $shield=$record->name;}
	elseif($record->name=='Platina medium shield'){$shieldarmour=19; $armour=$armour+$shieldarmour;  $shield=$record->name;}
	elseif($record->name=='Platina large shield'){$shieldarmour=21; $armour=$armour+$shieldarmour;  $shield=$record->name;}
	elseif($record->name=='Syriet small shield'){ $shieldarmour=23; $armour=$armour+$shieldarmour; $shield=$record->name;}
	elseif($record->name=='Syriet medium shield'){$shieldarmour=25; $armour=$armour+$shieldarmour; $shield=$record->name;}
	elseif($record->name=='Syriet large shield'){$shieldarmour=30; $armour=$armour+$shieldarmour;  $shield=$record->name;}
	elseif($record->name=='Samnite shield'){$shieldarmour=30; $armour=$armour+$shieldarmour;  $shield=$record->name;}
	elseif($record->name=='Obsidian small shield'){ $shieldarmour=33; $armour=$armour+$shieldarmour;  $shield=$record->name;}
	elseif($record->name=='Obsidian medium shield'){$shieldarmour=38; $armour=$armour+$shieldarmour; $shield=$record->name;}
	elseif($record->name=='Obsidian large shield'){$shieldarmour=45; $armour=$armour+$shieldarmour;  $shield=$record->name;}
	elseif($record->name=='Dragon shield'){$shieldarmour=55; $armour=$armour+$shieldarmour;  $shield=$record->name;}
	elseif($record->name=='Puranium small shield'){ $shieldarmour=50; $armour=$armour+$shieldarmour;  $shield=$record->name;}
	elseif($record->name=='Puranium medium shield'){$shieldarmour=55; $armour=$armour+$shieldarmour; $shield=$record->name;}
	elseif($record->name=='Puranium large shield'){$shieldarmour=65; $armour=$armour+$shieldarmour;  $shield=$record->name;}

	else{$shieldarmour=0;  $shield=$record->name;}
	############# GLOVES
	 } elseif($record->type=='gloves'){
	if($record->itemupgrade){
	 	$glovesUpgrade="<img src='images/ingame/$record->itemupgrade.jpg' />";
	 	$upggloves="[$plus$record->upgrademuch $record->itemupgrade]";
	}

	if($record->name=='Bronze hands'){ $glovesarmour=1;  $armour=$armour+$glovesarmour;  $gloves=$record->name;}
	elseif($record->name=='Antelope hooves'){ $glovesarmour=1; $armour=$armour+$glovesarmour; $gloves=$record->name;}
	elseif($record->name=='Iron hands'){ $glovesarmour=2; $armour=$armour+$glovesarmour; $gloves=$record->name;}
	elseif($record->name=='Ogre gloves'){ $glovesarmour=4; $armour=$armour+$glovesarmour; $gloves=$record->name;}
	elseif($record->name=='Steel hands'){ $glovesarmour=4; $armour=$armour+$glovesarmour; $gloves=$record->name;}
	elseif($record->name=='Bat-hide gloves'){ $glovesarmour=5; $armour=$armour+$glovesarmour; $gloves=$record->name;}
	elseif($record->name=='Equites manica'){ $glovesarmour=7; $armour=$armour+$glovesarmour; $gloves=$record->name;}
	elseif($record->name=='Silver hands'){ $glovesarmour=6; $armour=$armour+$glovesarmour; $gloves=$record->name;}
	elseif($record->name=='Elven gloves'){ $glovesarmour=6; $armour=$armour+$glovesarmour; $gloves=$record->name;}
	elseif($record->name=='Gold hands'){ $glovesarmour=8; $armour=$armour+$glovesarmour; $gloves=$record->name;}
	elseif($record->name=='Retiarii gauntlet'){ $glovesarmour=9; $armour=$armour+$glovesarmour; $gloves=$record->name;}

	elseif($record->name=='Platina hands'){ $glovesarmour=10; $armour=$armour+$glovesarmour; $gloves=$record->name;}
	elseif($record->name=='Hoplomachi manica'){ $glovesarmour=10; $armour=$armour+$glovesarmour; $gloves=$record->name;}
	elseif($record->name=='Syriet hands'){ $glovesarmour=15; $armour=$armour+$glovesarmour; $gloves=$record->name;}
	elseif($record->name=='Obsidian hands'){ $glovesarmour=20; $armour=$armour+$glovesarmour; $gloves=$record->name;}
	elseif($record->name=='Dragon gauntlets'){ $glovesarmour=25; $armour=$armour+$glovesarmour; $gloves=$record->name;}
	elseif($record->name=='Puranium hands'){ $glovesarmour=30; $armour=$armour+$glovesarmour; $gloves=$record->name;}

	else{ $glovesarmour=0; $gloves=$record->name;}
	########### SHOES
	}elseif($record->type=='shoes'){
	if($record->itemupgrade){
	 	$shoesUpgrade="<img src='images/ingame/$record->itemupgrade.jpg' />";
	 	$upgshoes="[$plus$record->upgrademuch $record->itemupgrade]";
	}

	if($record->name=='Bronze sabatons'){ $shoesarmour=1; $armour=$armour+$shoesarmour;   $shoes=$record->name;}
	elseif($record->name=='Iron sabatons'){ $shoesarmour=3; $armour=$armour+$shoesarmour; $shoes=$record->name;}
	elseif($record->name=='Ogre boots'){ $shoesarmour=4; $armour=$armour+$shoesarmour; $shoes=$record->name;}
	elseif($record->name=='Steel sabatons'){ $shoesarmour=5; $armour=$armour+$shoesarmour; $shoes=$record->name;}
	elseif($record->name=='Silver sabatons'){ $shoesarmour=6; $armour=$armour+$shoesarmour; $shoes=$record->name;}
	elseif($record->name=='Equites sandals'){ $shoesarmour=7; $armour=$armour+$shoesarmour; $shoes=$record->name;}

	elseif($record->name=='Elven boots'){ $shoesarmour=6; $armour=$armour+$shoesarmour; $shoes=$record->name;}
	elseif($record->name=='Gold sabatons'){ $shoesarmour=10; $armour=$armour+$shoesarmour; $shoes=$record->name;}
	elseif($record->name=='Retiarii boots'){ $shoesarmour=9; $armour=$armour+$shoesarmour; $shoes=$record->name;}
	elseif($record->name=='Platina sabatons'){ $shoesarmour=12; $armour=$armour+$shoesarmour; $shoes=$record->name;}
	elseif($record->name=='Syriet sabatons'){ $shoesarmour=15; $armour=$armour+$shoesarmour; $shoes=$record->name;}
	elseif($record->name=='Obsidian sabatons'){ $shoesarmour=20; $armour=$armour+$shoesarmour; $shoes=$record->name;}
	elseif($record->name=='Dragon boots'){ $shoesarmour=25; $armour=$armour+$shoesarmour; $shoes=$record->name;}
	elseif($record->name=='Puranium sabatons'){ $shoesarmour=30; $armour=$armour+$shoesarmour; $shoes=$record->name;}

	elseif($record->name=='Leather boots'){ $shoesarmour=1; $armour=$armour+$shoesarmour; $shoes=$record->name;}
	elseif($record->name=='Cheetah boots'){ $shoesarmour=2; $armour=$armour+$shoesarmour; $shoes=$record->name;}
	elseif($record->name=='Eagle boots'){ $shoesarmour=4; $armour=$armour+$shoesarmour; $shoes=$record->name;}
	elseif($record->name=='Bat-hide boots'){ $shoesarmour=5; $armour=$armour+$shoesarmour; $shoes=$record->name;}
	else{ $shoesarmour=0; $shoes=$record->name;}
	################# HELM
	}elseif($record->type=='helm'){
	if($record->itemupgrade){
	 	$helmUpgrade="<img src='images/ingame/$record->itemupgrade.jpg' />";
	 	$upghelm="[$plus$record->upgrademuch $record->itemupgrade]";
	}
	if($record->name=='Bronze medium helm'){ $helmarmour=1;  $armour=$armour+$helmarmour;  $helm=$record->name;}
	elseif($record->name=='Bronze large helm'){$helmarmour=2;   $armour=$armour+$helmarmour; $helm=$record->name;}
	elseif($record->name=='Iron medium helm'){ $helmarmour=3; $armour=$armour+$helmarmour; $helm=$record->name;}
	elseif($record->name=='Iron large helm'){$helmarmour=4; $armour=$armour+$helmarmour; $helm=$record->name;}
	elseif($record->name=='Ogre medium helm'){$helmarmour=6; $armour=$armour+$helmarmour; $helm=$record->name;}
	elseif($record->name=='Ogre spiked helm'){$helmarmour=7; $armour=$armour+$helmarmour; $helm=$record->name;}
	elseif($record->name=='Lizard headdress'){$helmarmour=6; $armour=$armour+$helmarmour; $helm=$record->name;}
	elseif($record->name=='Steel medium helm'){ $helmarmour=6; $armour=$armour+$helmarmour; $helm=$record->name;}
	elseif($record->name=='Steel large helm'){$helmarmour=7; $armour=$armour+$helmarmour; $helm=$record->name;}
	elseif($record->name=='Centaur helm'){$helmarmour=8; $armour=$armour+$helmarmour; $helm=$record->name;}
	elseif($record->name=='Equites helm'){$helmarmour=8; $armour=$armour+$helmarmour; $helm=$record->name;}

	elseif($record->name=='Silver medium helm'){ $helmarmour=8; $armour=$armour+$helmarmour; $helm=$record->name;}
	elseif($record->name=='Silver large helm'){$helmarmour=9; $armour=$armour+$helmarmour; $helm=$record->name;}
	elseif($record->name=='Elven helmet'){$helmarmour=10; $armour=$armour+$helmarmour; $helm=$record->name;}
	elseif($record->name=='Gold medium helm'){ $helmarmour=11; $armour=$armour+$helmarmour; $helm=$record->name;}
	elseif($record->name=='Gold large helm'){$helmarmour=13; $armour=$armour+$helmarmour; $helm=$record->name;}
	elseif($record->name=='Saurus helm'){$helmarmour=13; $armour=$armour+$helmarmour; $helm=$record->name;}
	elseif($record->name=='Platina medium helm'){ $helmarmour=15; $armour=$armour+$helmarmour; $helm=$record->name;}
	elseif($record->name=='Platina large helm'){$helmarmour=18; $armour=$armour+$helmarmour; $helm=$record->name;}

	elseif($record->name=='Hoplomachi brimmed helmet'){ $helmarmour=17; $armour=$armour+$helmarmour; $helm=$record->name;}

	elseif($record->name=='Syriet medium helm'){ $helmarmour=20; $armour=$armour+$helmarmour; $helm=$record->name;}
	elseif($record->name=='Syriet large helm'){$helmarmour=25; $armour=$armour+$helmarmour; $helm=$record->name;}
	elseif($record->name=='Samnite plumed helmet'){$helmarmour=26; $armour=$armour+$helmarmour; $helm=$record->name;}

	elseif($record->name=='Obsidian medium helm'){ $helmarmour=30; $armour=$armour+$helmarmour; $helm=$record->name;}
	elseif($record->name=='Obsidian large helm'){$helmarmour=35; $armour=$armour+$helmarmour; $helm=$record->name;}

	elseif($record->name=='Dragon helm'){ $helmarmour=40; $armour=$armour+$helmarmour; $helm=$record->name;}

	elseif($record->name=='Puranium medium helm'){ $helmarmour=40; $armour=$armour+$helmarmour; $helm=$record->name;}
	elseif($record->name=='Puranium large helm'){$helmarmour=50; $armour=$armour+$helmarmour; $helm=$record->name;}

	elseif($record->name=='Elk horns'){ $helmarmour=2;  $armour=$armour+$helmarmour;  $helm=$record->name;}
	elseif($record->name=='Koban mask'){ $helmarmour=4;  $armour=$armour+$helmarmour;  $helm=$record->name;}
	elseif($record->name=='Gold crown'){$helmarmour=6; $armour=$armour+$helmarmour; $helm=$record->name;}
	elseif($record->name=='Silver crown'){$helmarmour=4; $armour=$armour+$helmarmour; $helm=$record->name;}
	elseif($record->name=='Bronze crown'){$helmarmour=2; $armour=$armour+$helmarmour; $helm=$record->name;}

	else{$helm=$record->name; $helmarmour=0; }
	######## LEGS
	}elseif($record->type=='legs'){

		if($record->itemupgrade){
		 	$legsUpgrade="<img src='images/ingame/$record->itemupgrade.jpg' />";
		 	$upglegs="[$plus$record->upgrademuch $record->itemupgrade]";
		}

		if($record->name=='Bronze legs'){ $legsarmour=2; $armour=$armour+$legsarmour;   $legs=$record->name;}
		elseif($record->name=='Wildebeest pants'){ $legsarmour=2; $armour=$armour+$legsarmour; $legs=$record->name;}
		elseif($record->name=='Iron legs'){ $legsarmour=6; $armour=$armour+$legsarmour; $legs=$record->name;}
		elseif($record->name=='Ogre legs'){ $legsarmour=8; $armour=$armour+$legsarmour; $legs=$record->name;}
		elseif($record->name=='Steel legs'){ $legsarmour=10; $armour=$armour+$legsarmour; $legs=$record->name;}
		elseif($record->name=='Silver legs'){ $legsarmour=12; $armour=$armour+$legsarmour; $legs=$record->name;}
		elseif($record->name=='Elven legs'){ $legsarmour=14; $armour=$armour+$legsarmour; $legs=$record->name;}
		elseif($record->name=='Gold legs'){ $legsarmour=17; $armour=$armour+$legsarmour; $legs=$record->name;}
		elseif($record->name=='Saurus legs'){ $legsarmour=17; $armour=$armour+$legsarmour; $legs=$record->name;}
		elseif($record->name=='Platina legs'){ $legsarmour=27; $armour=$armour+$legsarmour; $legs=$record->name;}

		elseif($record->name=='Hoplomachi leg wrappings'){ $legsarmour=24; $armour=$armour+$legsarmour; $legs=$record->name;}

		elseif($record->name=='Syriet legs'){ $legsarmour=35; $armour=$armour+$legsarmour; $legs=$record->name;}
		elseif($record->name=='Samnite legs'){ $legsarmour=33; $armour=$armour+$legsarmour; $legs=$record->name;}

		elseif($record->name=='Obsidian legs'){ $legsarmour=43; $armour=$armour+$legsarmour; $legs=$record->name;}
		elseif($record->name=='Dragon legs'){ $legsarmour=50; $armour=$armour+$legsarmour; $legs=$record->name;}
		elseif($record->name=='Puranium legs'){ $legsarmour=60; $armour=$armour+$legsarmour; $legs=$record->name;}

		else { $legsarmour=0;  $legs=$record->name;}

	}elseif($record->type=='hand'){
	############### HAND
	if($record->itemupgrade){
	 	$handUpgrade="<img src='images/ingame/$record->itemupgrade.jpg' />";
	 	$upghand="[$plus$record->upgrademuch $record->itemupgrade]";
	}
	$aim=0; $power=0;

	//-5
	if($record->name=='Bronze pickaxe'){    $weapaim=1; $weappower=1;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}
	elseif($record->name=='Bronze hatchet'){    $weapaim=1; $weappower=1;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}
	elseif($record->name=='Bronze hammer'){    $weapaim=2; $weappower=3;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}
	elseif($record->name=='Bronze dagger'){ $weapaim=2; $weappower=2;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}
	elseif($record->name=='Bronze short sword'){  $weapaim=3; $weappower=3;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}
	elseif($record->name=='Bronze scimitar'){  $weapaim=3; $weappower=4;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}
	elseif($record->name=='Bronze mace'){ $weapaim=3; $weappower=5;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}
	elseif($record->name=='Bronze long sword'){  $weapaim=4; $weappower=4;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}
	elseif($record->name=='Bronze axe'){ $weapaim=7; $weappower=5;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}
	elseif($record->name=='Bronze two handed sword'){  $weapaim=6; $weappower=7;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}

	//5
	elseif($record->name=='Valera sword'){ $weapaim=19; $weappower=15; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}

	//10
	elseif($record->name=='Ogre pickaxe'){    $weapaim=4; $weappower=4;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}
	elseif($record->name=='Ogre hatchet'){    $weapaim=4; $weappower=4;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}
	elseif($record->name=='Ogre club'){    $weapaim=15; $weappower=21;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}
	elseif($record->name=='Ogre mace'){    $weapaim=17; $weappower=17;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}

	//10
	elseif($record->name=='Iron pickaxe'){ $weapaim=2; $weappower=2; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Iron hatchet'){ $weapaim=2; $weappower=2; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Iron hammer'){    $weapaim=4; $weappower=6;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}
	elseif($record->name=='Iron dagger'){ $weapaim=8; $weappower=5; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Iron short sword'){ $weapaim=7; $weappower=6; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Iron scimitar'){ $weapaim=6; $weappower=8; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Iron mace'){ $weapaim=6; $weappower=11; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Iron long sword'){ $weapaim=11; $weappower=11; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Iron axe'){ $weapaim=16; $weappower=13; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Iron two handed sword'){ $weapaim=14; $weappower=18; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}

	//15
	elseif($record->name=='Pirate falchion'){ $weapaim=18; $weappower=14; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}

	//15
	elseif($record->name=='Rose crest sword'){ $weapaim=16; $weappower=20; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}

	//20
	elseif($record->name=='Lizard machette'){  $weapaim=5; $weappower=6;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}
	elseif($record->name=='Lizard two handed spear'){  $weapaim=25; $weappower=15;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}

	//25
	elseif($record->name=='Steel pickaxe'){ $weapaim=3; $weappower=3; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Steel hatchet'){ $weapaim=3; $weappower=3; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Steel hammer'){    $weapaim=5; $weappower=7;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}
	elseif($record->name=='Steel dagger'){ $weapaim=16; $weappower=14; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Steel short sword'){ $weapaim=16; $weappower=16; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Steel scimitar'){ $weapaim=17; $weappower=15; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Steel mace'){ $weapaim=12; $weappower=19; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Steel long sword'){ $weapaim=17; $weappower=17; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Steel axe'){ $weapaim=20; $weappower=17; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Steel two handed sword'){ $weapaim=18; $weappower=22; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}


	elseif($record->name=='Bear claw'){ $weapaim=28; $weappower=24; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}


	//30
	elseif($record->name=='Centaur axe'){ $weapaim=27; $weappower=30; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}

	//30
	elseif($record->name=='Koban pickaxe'){ $weapaim=13; $weappower=8; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Koban axe'){ $weapaim=40; $weappower=35; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}

	//35
	elseif($record->name=='Elven hatchet'){ $weapaim=5; $weappower=4; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Elven pickaxe'){ $weapaim=4; $weappower=5; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Elven two handed sword'){ $weapaim=26; $weappower=30; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}


	//40
	elseif($record->name=='Waranerus spike'){ $weapaim=60; $weappower=25; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Stemosaurus tail spike'){ $weapaim=20; $weappower=70; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Roodarus horn'){ $weapaim=56; $weappower=45; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}

	//40
	elseif($record->name=='Silver pickaxe'){ $weapaim=4; $weappower=4; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Silver hatchet'){ $weapaim=4; $weappower=4; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Silver hammer'){    $weapaim=8; $weappower=11;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}
	elseif($record->name=='Silver dagger'){ $weapaim=20; $weappower=18; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Silver short sword'){ $weapaim=20; $weappower=20; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Silver scimitar'){ $weapaim=22; $weappower=19; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Silver mace'){ 	$weapaim=15; $weappower=28; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Silver long sword'){ $weapaim=25; $weappower=25; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Silver axe'){ 	$weapaim=28; $weappower=24; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Silver two handed sword'){ $weapaim=26; $weappower=30; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}

	//50
	elseif($record->name=='Retiarii trident'){ $weapaim=40; $weappower=45; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}

	//55
	elseif($record->name=='Gold pickaxe'){ $weapaim=5; $weappower=5; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Gold hatchet'){ $weapaim=5; $weappower=5; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Gold hammer'){    $weapaim=10; $weappower=15;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}
	elseif($record->name=='Gold dagger'){ $weapaim=28; $weappower=26; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Gold short sword'){ $weapaim=30; $weappower=30; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Gold scimitar'){ $weapaim=35; $weappower=30; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Gold mace'){ $weapaim=20; $weappower=45; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Gold long sword'){ $weapaim=36; $weappower=36; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Gold axe'){ $weapaim=50; $weappower=40; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Gold two handed sword'){ $weapaim=44; $weappower=50; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}

	elseif($record->name=='Pirate cutlass'){ $weapaim=58; $weappower=48; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}

	//70

	elseif($record->name=='Pirate hook'){ $weapaim=70; $weappower=52; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}

	elseif($record->name=='Platina pickaxe'){ $weapaim=15; $weappower=15; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Platina hatchet'){ $weapaim=15; $weappower=15; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Platina hammer'){    $weapaim=16; $weappower=20;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}
	elseif($record->name=='Platina dagger'){ $weapaim=50; $weappower=42; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Platina short sword'){ $weapaim=46; $weappower=46; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Platina scimitar'){ $weapaim=52; $weappower=46; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Platina mace'){ $weapaim=25; $weappower=71; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Platina long sword'){ $weapaim=50; $weappower=50; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Platina axe'){ $weapaim=70; $weappower=50; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Platina two handed sword'){ $weapaim=55; $weappower=70; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}

	elseif($record->name=='Hoplomachi long spear'){ $weapaim=35; $weappower=65; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}

	elseif($record->name=='Keelhail golden cutlass'){ $weapaim=85; $weappower=72; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}


    //75
	elseif($record->name=='Bone hatchet'){ $weapaim=22; $weappower=22; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Bone pickaxe'){ $weapaim=22; $weappower=22; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Bone hammer'){ $weapaim=22; $weappower=22; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Bone spade'){ $weapaim=18; $weappower=18; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}

	//85
	elseif($record->name=='Syriet pickaxe'){ $weapaim=32; $weappower=35; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Syriet hatchet'){ $weapaim=35; $weappower=32; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Syriet hammer'){    $weapaim=37; $weappower=40;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}
	elseif($record->name=='Syriet dagger'){ $weapaim=65; $weappower=60; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Syriet short sword'){ $weapaim=64; $weappower=64; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Syriet scimitar'){ $weapaim=68; $weappower=66; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Syriet mace'){ $weapaim=30; $weappower=90; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Syriet long sword'){ $weapaim=70; $weappower=70; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Syriet axe'){ $weapaim=85; $weappower=70; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Syriet two handed sword'){ $weapaim=70; $weappower=85; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}

	//90
	elseif($record->name=='Samnite two handed sword'){ $weapaim=65; $weappower=75; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Slamyeord'){ $weapaim=110; $weappower=85; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}

	//100
	elseif($record->name=='Obsidian pickaxe'){ $weapaim=48; $weappower=52; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Obsidian hatchet'){ $weapaim=52; $weappower=48; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Obsidian hammer'){    $weapaim=52; $weappower=55;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}
	elseif($record->name=='Obsidian dagger'){ $weapaim=85; $weappower=80; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Obsidian short sword'){ $weapaim=85; $weappower=85; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Obsidian scimitar'){ $weapaim=89; $weappower=87; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Obsidian mace'){ $weapaim=80; $weappower=90; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Obsidian long sword'){ $weapaim=90; $weappower=90; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Obsidian axe'){ $weapaim=105; $weappower=90; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Obsidian two handed sword'){ $weapaim=90; $weappower=105; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}

	//120
	elseif($record->name=='Puranium pickaxe'){ $weapaim=60; $weappower=62; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Puranium hatchet'){ $weapaim=62; $weappower=60; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Puranium hammer'){    $weapaim=62; $weappower=65;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}
	elseif($record->name=='Puranium dagger'){ $weapaim=110; $weappower=100; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Puranium short sword'){ $weapaim=108; $weappower=108; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Puranium scimitar'){ $weapaim=112; $weappower=110; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Puranium mace'){ $weapaim=90; $weappower=130; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Puranium long sword'){ $weapaim=115; $weappower=115; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Puranium axe'){ $weapaim=130; $weappower=115; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}
	elseif($record->name=='Puranium two handed sword'){ $weapaim=115; $weappower=130; $aim+=$weapaim; $power+=$weappower; $hand=$record->name;}


	elseif($record->name=='Staff'){    $weapaim=2; $weappower=1;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}
	elseif($record->name=='Witch broomstick'){    $weapaim=2; $weappower=1;    $aim+=$weapaim; $power+=$weappower;      $hand=$record->name;}

	else{ $hand=$record->name; }
	}elseif($record->type=='horse'){ #EINDE HAND BEGIN HORSE
		$horse=$record->name;
	} # EINDE TYPES
	} #EINDE MYSQL


	$powerst=floor($power);
	$aimst=floor($aim);
	$armourst=floor($armour);
	$armour=$armourst+$upgarmour;
	$aim=$aimst+$upgaim;
	$power=$powerst+$upgpower;


	}
?>