<?
if(defined('AZtopGame35Heyam')){


$gift='';
$open=$itemName;
  $sql = "SELECT much FROM items_inventory WHERE name='$itemName' && username='$S_user' && type='open'  LIMIT 1";
   $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat)) { $gift=1;  $muchOfThisItem=$record->much; }

if($gift==1){


## GIFTSSS
if($open=='Blue gift'){
	$get=rand(1,15);
	if($get==1){ $get="Amber"; $gettype="gem"; $getmuch=1;
	}elseif($get==2){  $get="Iron axe"; $gettype="hand"; $getmuch=1;
	}elseif($get==3){  $get="Wood"; $gettype="wood"; $getmuch=26;
	}elseif($get==4){  $get="Steel hatchet"; $gettype="hand"; $getmuch=1;
	}elseif($get==5){  $get="Steel pickaxe"; $gettype="hand"; $getmuch=1;
	}elseif($get==6){  $get="Cooked Trouts"; $gettype="cooked food"; $getmuch=5;
	}elseif($get==7){  $get="Bread"; $gettype="cooked food"; $getmuch=15;
	}elseif($get==8){  $get="Coal"; $gettype="ore"; $getmuch=25;
	}elseif($get==9){  $get="Iron bars"; $gettype="bars"; $getmuch=15;
	}elseif($get==10){  $get="Coal"; $gettype="ore"; $getmuch=10;
	}elseif($get==11){  $get="Green gift"; $gettype="open"; $getmuch=2;
	}elseif($get==12){  $get="Cooked Swordfish"; $gettype="cooked food"; $getmuch=1;
	}elseif($get==13){  $get="Onion seeds"; $gettype="seeds"; $getmuch=20;
	}elseif($get==14){  $get="Gold"; $gettype=""; $getmuch=50;
	}elseif($get==15){  $get="Gold"; $gettype=""; $getmuch=60;}
}elseif($open=='Red gift'){
	$get=rand(1,16);
	if($get==1){ $get="Amber"; $gettype="gem"; $getmuch=1;
	}elseif($get==2){  $get="Iron axe"; $gettype="hand"; $getmuch=1;
	}elseif($get==3){  $get="Mule"; $gettype="horse"; $getmuch=1;
	}elseif($get==4){  $get="Steel hatchet"; $gettype="hand"; $getmuch=1;
	}elseif($get==5){  $get="Steel pickaxe"; $gettype="hand"; $getmuch=1;
	}elseif($get==6){  $get="Cooked Trouts"; $gettype="cooked food"; $getmuch=25;
	}elseif($get==7){  $get="Bread"; $gettype="cooked food"; $getmuch=15;
	}elseif($get==8){  $get="Coal"; $gettype="ore"; $getmuch=25;
	}elseif($get==9){  $get="Iron bars"; $gettype="bars"; $getmuch=35;
	}elseif($get==10){  $get="Copper ore"; $gettype="ore"; $getmuch=39;
	}elseif($get==11){  $get="Wood"; $gettype="wood"; $getmuch=45;
	}elseif($get==12){  $get="Cooked Swordfish"; $gettype="cooked food"; $getmuch=1;
	}elseif($get==13){  $get="Onion seeds"; $gettype="seeds"; $getmuch=20;
	}elseif($get==14){  $get="Gold"; $gettype=""; $getmuch=50;
	}elseif($get==15){  $get="Garnet"; $gettype="gem"; $getmuch=1;
	}elseif($get==16){  $get="Locked toolbox"; $gettype="locked"; $getmuch=1;
	}
}elseif($open=='Green gift'){
	$get=rand(1,6);
	if($get==1){  $get="Radish seeds"; $gettype="seeds"; $getmuch=4;
	}elseif($get==2){  $get="Gold"; $gettype=""; $getmuch=15;
	}elseif($get==3){  $get="Gold"; $gettype=""; $getmuch=10;
	}elseif($get==4){  $get="Gold"; $gettype=""; $getmuch=25;
	}elseif($get==5){  $get="Beet seeds"; $gettype="seeds"; $getmuch=11;
	}elseif($get==6){  $get="Copper ore"; $gettype="ore"; $getmuch=9;
	}
}elseif($open=='Small chest'){
	$get=rand(1,9);
	if($get==1){ $get="Moonstone"; $gettype="gem"; $getmuch=1;
	}elseif($get==2){  $get="Grain seeds"; $gettype="seeds"; $getmuch=25;
	}elseif($get==3){  $get="Gold"; $gettype=""; $getmuch=100;
	}elseif($get==4){  $get="Tomato seeds"; $gettype="seeds"; $getmuch=20;
	}elseif($get==5){  $get="Corn seeds"; $gettype="seeds"; $getmuch=15;
	}elseif($get==6){  $get="Strawberry seeds"; $gettype="seeds"; $getmuch=10;
	}elseif($get==7){  $get="Avril"; $gettype="gem"; $getmuch=1;
	}elseif($get==8){  $get="Gold"; $gettype=""; $getmuch=223;
	}elseif($get==9){  $get="Gold"; $gettype=""; $getmuch=40;}
}elseif($open=='Small pirate chest'){
	$get=rand(1,9);
	if($get==1){ $get="Moonstone"; $gettype="gem"; $getmuch=3;
	}elseif($get==2){  $get="Grain seeds"; $gettype="seeds"; $getmuch=150;
	}elseif($get==3){  $get="Gold"; $gettype=""; $getmuch=500;
	}elseif($get==4){  $get="Tomato seeds"; $gettype="seeds"; $getmuch=100;
	}elseif($get==5){  $get="Corn seeds"; $gettype="seeds"; $getmuch=150;
	}elseif($get==6){  $get="Strawberry seeds"; $gettype="seeds"; $getmuch=200;
	}elseif($get==7){  $get="Avril"; $gettype="gem"; $getmuch=1;
	}elseif($get==8){  $get="Gold"; $gettype=""; $getmuch=1203;
	}elseif($get==9){  $get="Gold"; $gettype=""; $getmuch=2000;}
}elseif($open=='Big pirate chest'){
	$get=rand(1,9);
	if($get==1){ $get="Moonstone"; $gettype="gem"; $getmuch=3;
	}elseif($get==2){  $get="Grain seeds"; $gettype="seeds"; $getmuch=250;
	}elseif($get==3){  $get="Gold"; $gettype=""; $getmuch=1000;
	}elseif($get==4){  $get="Tomato seeds"; $gettype="seeds"; $getmuch=200;
	}elseif($get==5){  $get="Corn seeds"; $gettype="seeds"; $getmuch=250;
	}elseif($get==6){  $get="Strawberry seeds"; $gettype="seeds"; $getmuch=400;
	}elseif($get==7){  $get="Avril"; $gettype="gem"; $getmuch=2;
	}elseif($get==8){  $get="Gold"; $gettype=""; $getmuch=2203;
	}elseif($get==9){  $get="Gold"; $gettype=""; $getmuch=4000;}
}elseif($open=='Toolbox'){
	$get=rand(1,6);
	if($get==1){ $get="Bronze hammer"; $gettype="hand"; $getmuch=1;
	}elseif($get==2){  $get="Iron pickaxe"; $gettype="hand"; $getmuch=1;
	}elseif($get==3){  $get="Gold"; $gettype=""; $getmuch=10;
	}elseif($get==4){  $get="Gold"; $gettype=""; $getmuch=20;
	}elseif($get==5){  $get="Gold"; $gettype=""; $getmuch=25;
	}elseif($get==6){  $get="Gold"; $gettype="seeds"; $getmuch=rand(1,80);}
}elseif($open=='Moldy chest'){
	$get=rand(1,9);
	if($get==1){ $get="Ogre pickaxe"; $gettype="hand"; $getmuch=1;
	}elseif($get==2){  $get="Cooked Sardine"; $gettype="cooked food"; $getmuch=rand(30,50);
	}elseif($get==3){  $get="Onion"; $gettype="cooked food"; $getmuch=rand(40,60);
	}elseif($get==4){  $get="Cabbage seeds"; $gettype="seeds"; $getmuch=rand(50,110);
	}elseif($get>=5 && $get<=9){  $get="Gold"; $gettype="seeds"; $getmuch=rand(25,476);}
}elseif($open=='Ancient chest'){
	$get=rand(1,7);
	if($get==1){ $get="Elven pickaxe"; $gettype="hand"; $getmuch=1;
	}elseif($get==2){  $get="Diamond"; $gettype="gem"; $getmuch=rand(1,3);
	}elseif($get==3){  $get="Eggplant seeds"; $gettype="seeds"; $getmuch=rand(40,60);
	}elseif($get==4){  $get="Cucumber seeds"; $gettype="seeds"; $getmuch=rand(30,50);
	}elseif($get==5){  $get="Cooked Cod"; $gettype="cooked food"; $getmuch=rand(15,30);
	}elseif($get==6){  $get="Amber"; $gettype="gem"; $getmuch=rand(3,6);
	}elseif($get==7){  $get="Moonstone"; $gettype="gem"; $getmuch=rand(1,4);
	}
}elseif($open=='Wooden egg'){
	$get=rand(1,13);
	if($get==1){ $get="Diaspore"; $gettype="gem"; $getmuch=1;
	}elseif($get==2){  $get="Beryl"; $gettype="gem"; $getmuch=1;
	}elseif($get==3){  $get="Garnet"; $gettype="gem"; $getmuch=1;
	}elseif($get==4){  $get="Cucumber seeds"; $gettype="seeds"; $getmuch=rand(2,12);
	}elseif($get==5){  $get="Carrot seeds"; $gettype="seeds"; $getmuch=rand(2,50);
	}elseif($get==6){  $get="Strawberry seeds"; $gettype="seeds"; $getmuch=rand(2,25);
	}elseif($get==7){  $get="Pumpkin seeds"; $gettype="seeds"; $getmuch=rand(2,15);
	}elseif($get==8){  $get="Blue gift"; $gettype="open"; $getmuch=1;
	}elseif($get==9){  $get="Green gift"; $gettype="open"; $getmuch=rand(1,3);
	}elseif($get==10){  $get="Cucumber seeds"; $gettype="seeds"; $getmuch=rand(2,12);
	}elseif($get==11){  $get="Carrot seeds"; $gettype="seeds"; $getmuch=rand(2,50);
	}elseif($get==12){  $get="Strawberry seeds"; $gettype="seeds"; $getmuch=rand(2,25);
	}elseif($get==13){  $get="Pumpkin seeds"; $gettype="seeds"; $getmuch=rand(2,15);
	}
}elseif($open=='Christmas present'){
	$get=rand(1,100);
	if($get==1){ if(rand(1,8) == 1) { $get="Santa hat"; $gettype="helm"; $getmuch=1; } else { 
	
			$rand=rand(1,18);
			$getmuch=1;

			switch($rand)
			{
				case 1:
				case 2:
					$get="Frost hat";
					break;

				case 3:
				case 4:
					$get="Frost shield";
					break;

				case 5:
				case 6:
					$get="Frost vest";
					break;

				case 7:
				case 8:
					$get="Frost staff";
					break;

				case 9:
				case 10:
					$get="Frost legs";
					break;

				case 11:
				case 12:
					$get="Frost gloves";
					break;

				case 13:
				case 14:
					$get="Frost shoes";
					break;

				case 15:
				case 16:
					$get="Christmas creature summoning orb";
					break;

				case 17:
				case 18:
					$get="Christmas group fight summoning orb";
					break;
			}

			$resultaaat = mysqli_query($mysqli, "SELECT type FROM items WHERE name='$get' LIMIT 1");
			while ($rec = mysqli_fetch_object($resultaaat)) { $gettype=$rec->type; }
		}
	}elseif($get<10){  $get="Diaspore"; $gettype="gem"; $getmuch=1;
	}elseif($get<20){  $get="Garnet"; $gettype="gem"; $getmuch=1;
	}elseif($get<30){  $get="Onion seeds"; $gettype="seeds"; $getmuch=rand(25,50);
	}elseif($get<40){  $get="Tomato seeds"; $gettype="seeds"; $getmuch=rand(25,50);
	}elseif($get<50){  $get="Corn seeds"; $gettype="seeds"; $getmuch=rand(25,50);
	}elseif($get<60){  $get="Strawberry seeds"; $gettype="seeds"; $getmuch=rand(20,40);
	}elseif($get<70){  $get="Green pepper seeds"; $gettype="seeds"; $getmuch=rand(20,40);
	}elseif($get<80){  $get="Eggplant seeds"; $gettype="seeds"; $getmuch=rand(20,30);
	}elseif($get<90){  $get="Pumpkin seeds"; $gettype="seeds"; $getmuch=rand(15,25);
	}elseif($get<=100){  $get="Apple seeds"; $gettype="seeds"; $getmuch=rand(10,20);
	}
}elseif($open=='Webbed item'){
	$get=rand(1,12);
	if($get==1){ 		$get="Amber"; 				$gettype="gem"; $getmuch=1;
	}elseif($get==2){  	$get="Hardened spider silk"; $gettype="resource"; $getmuch=rand(1,2);
	}elseif($get==3){  	$get="Spar"; 				$gettype="gem"; $getmuch=1;
	}elseif($get==4){  	$get="Garnet"; 				$gettype="gem"; $getmuch=1;
	}elseif($get==5){  	$get="Diamond"; 			$gettype="gem"; $getmuch=1;
	}elseif($get==6){  	$get="Soft spider silk";	$gettype="resource"; $getmuch=rand(1,2);
	}elseif($get==7){  	$get="Corn seeds"; 			$gettype="seeds"; $getmuch=rand(2,15);
	}elseif($get==8){  $get="Tomato seeds"; 		$gettype="seeds"; $getmuch=rand(2,15);
	}elseif($get==9){  $get="Grain seeds"; 		$gettype="seeds"; $getmuch=rand(2,15);
	}elseif($get==10){  $get="Strawberry seeds"; 	$gettype="seeds"; $getmuch=rand(2,15);
	}else{  			$get="Gold"; $gettype="gold"; 		$getmuch=rand(5,50);}
}else if($open=='Sarcophagus'){
	$get=rand(1,6);
	if($get==1){ 		$get="Obsidian ore"; 		$gettype="ore"; 	$getmuch=1;
	}elseif($get==2){  	$get="Plum seeds"; 			$gettype="seeds"; $getmuch=rand(1,25);
	}elseif($get==3){  	$get="Orange seeds"; 		$gettype="seeds"; $getmuch=rand(1,20);
	}elseif($get==4){  	$get="Avocado seeds"; 		$gettype="seeds"; $getmuch=rand(1,20);
	}elseif($get==5){  	$get="Pineapple seeds"; 	$gettype="seeds"; 	$getmuch=rand(1,15);
	}elseif($get==6){  	$get="Amethyst"; 	$gettype="gem"; 	$getmuch=1;
	}
}

if($get && $getmuch>=1){
    if($muchOfThisItem<=1){
      	$sql = "DELETE FROM items_inventory WHERE name='$open' && username='$S_user' && type='open' LIMIT 1";
      	mysqli_query($mysqli,$sql) or die("error report this bug pleaseMESSAGE");
	}else{
	 	mysqli_query($mysqli,"UPDATE items_inventory SET much=much-1 WHERE name='$open' && username='$S_user' LIMIT 1") or die("error --> 1");
	}

	if($get=='Gold'){
		getGold($S_user, $getmuch);
	}else if($get){
	     echo"setTimeout(\"";
		 addItem($S_user, $get, $getmuch, $gettype, '', '', 1);
		 echo"\", 500);";
	}

	echo"setTimeout(\"removeItemFromContainer('playerInventory', '$open', '1');\", 500);";

	echo"messagePopup(\"You opened your $open...It contained $getmuch $get!\", \"Opening your $open\");";
}
}#GIFT
} # define
?>