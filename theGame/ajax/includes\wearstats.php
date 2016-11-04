<?
if(defined('AZtopGame35Heyam') && $S_user){

function wearStats($userName, $updateStats){

	global $mysqli, $S_user;

	$trophy='';
	include('itemStats.php');

	if($updateStats && $S_user==$userName){

		if($S_aim==''){ $_SESSION['S_aim']=$aim;    		}else{ $S_aim=$aim; }
		if($S_power==''){ $_SESSION['S_power']=$power; 		}else{ $S_power=$power; }
		if($S_armour==''){ $_SESSION['S_armour']=$armour;   }else{ $S_armour=$armour; }

		$whatDisplay='display';
	}else{
		$whatDisplay='displayPlayer';
	}

		if($shield==''){ $shield="No shield"; }
		if($legs==''){ $legs="No legs"; }
		if($helm==''){ $helm="No helm"; }
		if($body==''){ $body="No bodyarmour"; }
		if($hand==''){ $hand="No weapon"; }
		if($gloves==''){ $gloves="No gloves"; }
		if($shoes==''){ $shoes="No sabatons"; }
		if($horse==''){$horse="No horse";}

		if($weapaim==''){$weapaim=0; }
		if($weappower==''){$weappower=0; }

	if($trophy){
		echo"$('".$whatDisplay."Trophy').innerHTML=\"\";";
		echo"$('".$whatDisplay."Trophy').title=\"$trophy\";";
		echo"$('".$whatDisplay."Trophy').style.background=\"url('images/inventory/$trophy.gif')\";";
	}else{
		echo"$('".$whatDisplay."Trophy').innerHTML=\"\";";
		echo"$('".$whatDisplay."Trophy').title=\"No trophy\";";
		echo"$('".$whatDisplay."Trophy').style.background=\"\";";
	}

	echo"$('".$whatDisplay."Helm').innerHTML=\"$helmarmour $helmUpgrade\";";
	echo"$('".$whatDisplay."Helm').title=\"$helm $upghelm\";";
	echo"$('".$whatDisplay."Helm').style.background=\"url('images/inventory/$helm.gif')\";";
	echo"$('".$whatDisplay."Shield').innerHTML=\"$shieldarmour $shieldUpgrade\";";
	echo"$('".$whatDisplay."Shield').title=\"$shield $upgshield\";";
	echo"$('".$whatDisplay."Shield').style.backgroundImage=\"url('images/inventory/$shield.gif')\";";
	echo"$('".$whatDisplay."Body').innerHTML=\"$bodyarmour $bodyUpgrade\";";
	echo"$('".$whatDisplay."Body').title=\"$body $upgbody\";";
	echo"$('".$whatDisplay."Body').style.backgroundImage=\"url('images/inventory/$body.gif')\";";
	echo"$('".$whatDisplay."Hand').innerHTML=\"$weapaim/$weappower $handUpgrade\";";
	echo"$('".$whatDisplay."Hand').title=\"$hand $upghand\";";
	echo"$('".$whatDisplay."Hand').style.backgroundImage=\"url('images/inventory/$hand.gif')\";";
	echo"$('".$whatDisplay."Legs').innerHTML=\"$legsarmour $legsUpgrade\";";
	echo"$('".$whatDisplay."Legs').title=\"$legs $upglegs\";";
	echo"$('".$whatDisplay."Legs').style.backgroundImage=\"url('images/inventory/$legs.gif')\";";
	echo"$('".$whatDisplay."Gloves').innerHTML=\"$glovesarmour $glovesUpgrade\";";
	echo"$('".$whatDisplay."Gloves').title=\"$gloves $upggloves\";";
	echo"$('".$whatDisplay."Gloves').style.backgroundImage=\"url('images/inventory/$gloves.gif')\";";

	echo"$('".$whatDisplay."Horse').title=\"$horse $upghorse\";";
	echo"$('".$whatDisplay."Horse').style.background=\"url('images/inventory/$horse.gif')\";";
	echo"$('".$whatDisplay."Shoes').innerHTML=\"$shoesarmour  $shoesUpgrade\";";
	echo"$('".$whatDisplay."Shoes').title=\"$shoes $upgshoes\";";
	echo"$('".$whatDisplay."Shoes').style.backgroundImage=\"url('images/inventory/$shoes.gif')\";";


	echo"$('".$whatDisplay."Armour').innerHTML=\"$armourst + $upgarmour\";";
	echo"$('".$whatDisplay."Aim').innerHTML=\"$aimst + $upgaim\";";
	echo"$('".$whatDisplay."Power').innerHTML=\"$powerst + $upgpower\";	";
	echo"$('".$whatDisplay."TravelTime').innerHTML=\"$upgtraveltime\";";



	}//function





}//hacker
?>


