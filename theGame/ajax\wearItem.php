<?
header("Cache-Control: no-cache, must-revalidate");
session_start();
$timee=$time=time();
define('AZtopGame35Heyam', true );
if(!$S_user OR (!$itemID && !$position)){
  	exit();
}
require_once("../includes/db.inc.php");
if (mysqli_connect_errno())
{
    exit();
}


include_once("includes/functions.php");
$OKToEquip=0;

function subTypeExtraLevel($name){

	$subArray[0]['name']=" pickaxe";
	$subArray[0]['level']=0;
	$subArray[1]['name']=" dagger";
	$subArray[1]['level']=0;
	$subArray[2]['name']=" hatchet";
	$subArray[2]['level']=0;
	$subArray[2]['name']=" hammer";
	$subArray[2]['level']=0;
	$subArray[3]['name']=" sabatons";
	$subArray[3]['level']=1;
	$subArray[4]['name']=" short sword";
	$subArray[4]['level']=2;
	$subArray[5]['name']=" medium helm";
	$subArray[5]['level']=2;
	$subArray[6]['name']=" scimitar";
	$subArray[6]['level']=3;
	$subArray[7]['name']=" small shield";
	$subArray[7]['level']=3;
	$subArray[8]['name']=" mace";
	$subArray[8]['level']=4;
	$subArray[9]['name']=" hands";
	$subArray[9]['level']=5;
	$subArray[10]['name']=" long sword";
	$subArray[10]['level']=6;
	$subArray[11]['name']=" medium shield";
	$subArray[11]['level']=7;
	$subArray[12]['name']=" chainmail";
	$subArray[12]['level']=8;
	$subArray[13]['name']=" legs";
	$subArray[13]['level']=9;
	$subArray[14]['name']=" large helm";
	$subArray[14]['level']=10;
	$subArray[15]['name']=" axe";
	$subArray[15]['level']=11;
	$subArray[16]['name']=" large shield";
	$subArray[16]['level']=12;
	$subArray[17]['name']=" two handed sword";
	$subArray[17]['level']=13;
	$subArray[18]['name']=" plate";
	$subArray[18]['level']=14;


	for($i=0;$subArray[$i]['name'];$i++){
		if(strpos($name, $subArray[$i]['name'])){
			return ($subArray[$i]['level']);
		}
	}
	return 999;
}

function unwearItemAndAddItem($type, $exception){
	global $S_user, $mysqli;

	$sql = "SELECT ID, name, itemupgrade, upgrademuch FROM items_wearing WHERE type='$type' && username='$S_user' LIMIT 1";
   	$resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
	 	$itemID=$record->ID;
	 	$itemName=$record->name;
	 	$itemupgrade=$record->itemupgrade;
	 	$upgrademuch=$record->upgrademuch;

	    if($record->upgrademuch>0){$plus="+"; }else{ $plus=''; }
		if($record->itemupgrade){
		  	$upg=" [$plus$record->upgrademuch $record->itemupgrade]";
		 	$upg2=", 'images/ingame/$record->itemupgrade.jpg'";
		}else{
			$upg=''; $upg2='';
		}
		$title="$record->name$upg";

    }
    if(!$title){
		return;
	}
	if($exception && !stristr($title, $exception)){
		return;
	}

	addItem($S_user, $itemName, 1, $type, $itemupgrade, $upgrademuch, 1);
	mysqli_query($mysqli, "DELETE FROM items_wearing WHERE ID='$itemID' LIMIT 1") or die("error --> 1 unwear");

}




	$wearTypesAccepted['hand']=1;
	$wearTypesAccepted['shoes']=1;
	$wearTypesAccepted['helm']=1;
	$wearTypesAccepted['body']=1;
	$wearTypesAccepted['shield']=1;
	$wearTypesAccepted['legs']=1;
	$wearTypesAccepted['horse']=1;
	$wearTypesAccepted['gloves']=1;


	if($position){ //unwear item
		   	unwearItemAndAddItem($position, '');

			include_once('includes/wearstats.php');
			wearStats($S_user, 1);
			exit();
	}//unwear item

	$wearType='';

   	$sql = "SELECT type, name, itemupgrade, upgrademuch,much FROM items_inventory WHERE ID='$itemID' && username='$S_user' LIMIT 1";
   	$resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat))
	{
	  	$wearType=$record->type;
	  	$wear=$record->name;
	  	$itemMuch=$record->much;
	  	$itemUpgrade=$record->itemupgrade;
	  	$itemUpgradeMuch=$record->upgrademuch;

	  	if($record->upgrademuch>0){$plus="+"; }else{ $plus=''; }
	  	if($record->itemupgrade){
			$upg=" [$plus$record->upgrademuch $record->itemupgrade]";
		}else{
			$upg='';
		}
	  	$titleInInventory="$record->name$upg";
  	}


  	if($wearTypesAccepted[$wearType]==1){

		include('includes/levels.php');
		$neededatt=0;
		$neededmin=0;
		$neededwood=0;
		$neededcooking=0;
		$neededsmithing=0;
        $neededconstructing=0;
		$neededdef=0;
		$neededcombat=0;
		$neededfishing=0;
		$neededthieving=0;

		if($wear=='Rod'){
			$neededfishing=5;
		}elseif($wear=='Cheetah boots' || $wear=='Wildebeest pants' || $wear=='Lion vest' || $wear=='Antelope hooves' ||$wear=='Elk horns'){
			## Speed set
			$neededspeed=35;

		}elseif($wear=='Witch broomstick'){
			## Speed set
			$neededspeed=40;

		}else if(stristr($wear, 'pickaxe')){
		### PICKAXES
			if(stristr($wear, 'Bronze')){
				$neededmin=-5;
			}
            elseif(stristr($wear, 'Iron ')){
				$neededmin=10;
			}
            elseif(stristr($wear, 'Steel ')){
				$neededmin=25;
			}
            elseif(stristr($wear, 'Koban ')){
				$neededmin=30;
			}
            elseif(stristr($wear, 'Silver ')){
				$neededmin=40;
			}
            elseif(stristr($wear, 'Elven ')){
				$neededmin=35;
			}
            elseif(stristr($wear, 'Gold ')){
				$neededmin=55;
			}
            elseif(stristr($wear, 'Platina ')){
				$neededmin=70;
			}
            elseif(stristr($wear, 'Bone ')){
				$neededmin=75;
			}
            elseif(stristr($wear, 'Syriet ')){
				$neededmin=85;
			}
            elseif(stristr($wear, 'Obsidian ')){
				$neededmin=100;
			}
            elseif(stristr($wear, 'Puranium ')){
				$neededmin=120;
			}
		}elseif(stristr($wear, 'hatchet') OR stristr($wear, 'machette')){
		## HATCHETS
			if(stristr($wear, 'Bronze')){
				$neededwood=-5;
			}
            elseif(stristr($wear, 'Iron ')){
				$neededwood=10;
			}
            elseif(stristr($wear, 'Steel ')){
				$neededwood=25;
			}
            elseif(stristr($wear, 'Lizard ')){
				$neededwood=20;
			}
            elseif(stristr($wear, 'Koban ')){
				$neededwood=30;
			}
            elseif(stristr($wear, 'Silver ')){
				$neededwood=40;
			}
            elseif(stristr($wear, 'Elven ')){
				$neededwood=35;
			}
            elseif(stristr($wear, 'Gold ')){
				$neededwood=55;
			}
            elseif(stristr($wear, 'Platina ')){
				$neededwood=70;
			}
            elseif(stristr($wear, 'Bone ')){
				$neededwood=75;
			}
            elseif(stristr($wear, 'Syriet ')){
				$neededwood=85;
			}
            elseif(stristr($wear, 'Obsidian ')){
				$neededwood=100;
			}
            elseif(stristr($wear, 'Puranium ')){
				$neededwood=120;
			}

			//centaur 0 -> 35 -> 30 ?
			//saurus 0 -> 45
			//Rose 0 -> 15
		}else if(stristr($wear, ' cauldron')){
		###$pan
			if(stristr($wear, 'Bronze')){
				$neededcooking=-5;
			}
            elseif(stristr($wear, 'Iron ')){
				$neededcooking=10;
			}
            elseif(stristr($wear, 'Steel ')){
				$neededcooking=25;
			}
            elseif(stristr($wear, 'Silver ')){
				$neededcooking=40;
			}
            elseif(stristr($wear, 'Gold ')){
				$neededcooking=55;
			}
            elseif(stristr($wear, 'Witch ')){
				$neededcooking=60;
			}
            elseif(stristr($wear, 'Platina ')){
				$neededcooking=70;
			}
            elseif(stristr($wear, 'Bone ')){
				$neededcooking=75;
			}
            elseif(stristr($wear, 'Syriet ')){
				$neededcooking=85;
			}
            elseif(stristr($wear, 'Obsidian ')){
				$neededcooking=100;
			}
            elseif(stristr($wear, 'Puranium ')){
				$neededcooking=120;
			}
		}else if(stristr($wear, ' hammer')){
		###hammer
			if(stristr($wear, 'Bronze')){
				$OKToEquip=1;
			}
            elseif(stristr($wear, 'Iron ')){
				if($smithingl>=10 || $constructingl>=10){
					$OKToEquip=1;
				}else{
					$neededsmithing=10;
					$neededconstructing=10;
				}
			}
            elseif(stristr($wear, 'Steel ')){
				if($smithingl>=25 || $constructingl>=25){
					$OKToEquip=1;
				}else{
					$neededsmithing=25;
					$neededconstructing=25;
				}
			}
            elseif(stristr($wear, 'Silver ')){
				if($smithingl>=40 || $constructingl>=40){
					$OKToEquip=1;
				}else{
					$neededsmithing=40;
					$neededconstructing=40;
				}
			}
            elseif(stristr($wear, 'Gold ')){
				if($smithingl>=55 || $constructingl>=55){
					$OKToEquip=1;
				}else{
					$neededsmithing=55;
					$neededconstructing=55;
				}
			}
            elseif(stristr($wear, 'Platina ')){
				if($smithingl>=70 || $constructingl>=70){
					$OKToEquip=1;
				}else{
					$neededsmithing=70;
					$neededconstructing=70;
				}
			}
            elseif(stristr($wear, 'Bone ')){
				if($smithingl>=75 || $constructingl>=75){
					$OKToEquip=1;
				}else{
					$neededsmithing=75;
					$neededconstructing=75;
				}
			}
            elseif(stristr($wear, 'Syriet ')){
				if($smithingl>=85 || $constructingl>=85){
					$OKToEquip=1;
				}else{
					$neededsmithing=85;
					$neededconstructing=85;
				}
			}
            elseif(stristr($wear, 'Obsidian ')){
				if($smithingl>=100 || $constructingl>=100){
					$OKToEquip=1;
				}else{
					$neededsmithing=100;
					$neededconstructing=100;
				}
			}
            elseif(stristr($wear, 'Puranium ')){
				if($smithingl>=120 || $constructingl>=120){
					$OKToEquip=1;
				}else{
					$neededsmithing=120;
					$neededconstructing=120;
				}
			}
		} elseif(stristr($wear, 'Bronze ')){
			if(stristr($wearType, 'hand')){$neededatt=-5+subTypeExtraLevel($wear);
			} else{$neededdef=-5+subTypeExtraLevel($wear);}
		} elseif(stristr($wear, 'Valera ')){
			if(stristr($wearType, 'hand')){$neededatt=5;
			} else{$neededdef=5;}
		} elseif(stristr($wear, 'Iron ')){
			if(stristr($wearType, 'hand')){$neededatt=10+subTypeExtraLevel($wear);
			} else{$neededdef=10+subTypeExtraLevel($wear);}
		} elseif(stristr($wear, 'Ogre ')){
			if(stristr($wearType, 'hand')){$neededatt=10;
			} else{$neededdef=10;}
		} elseif(stristr($wear, 'Rose crest ')==true){
			if(stristr($wearType, 'hand')){$neededatt=15;
			} else{$neededdef=15;}
		} elseif(stristr($wear, 'Pirate')){
			if(stristr($wearType, 'hand'))
            {
                if(stristr($wear, 'falchion'))
                {
                    $neededatt=15;
                }
                else if(stristr($wear, 'cutlass'))
                {
                    $neededatt=60;
                }
                else if(stristr($wear, 'hook'))
                {
                    $neededatt=70;
                }
			}
            else
            {$neededdef=15;}
		} elseif($wear == 'Keelhail golden cutlass'){
			if(stristr($wearType, 'hand'))
            {
                $neededatt=85;
			}
            else
            {$neededdef=55;}
		} elseif(stristr($wear, 'Steel ')){
			if(stristr($wearType, 'hand')){$neededatt=25+subTypeExtraLevel($wear);
			} else{$neededdef=25+subTypeExtraLevel($wear);}
		} elseif(stristr($wear, 'Lizard ')){
			if(stristr($wearType, 'hand')){$neededatt=20;
			} else{$neededdef=20;}
		} elseif(stristr($wear, 'Bat-hide ')){
			if(stristr($wearType, 'hand')){$neededatt=25;
			} else{$neededdef=25;}
		} elseif(stristr($wear, 'Bear ')){
			if(stristr($wearType, 'hand')){$neededatt=25;
			} else{$neededdef=25;}
		} elseif(stristr($wear, 'Koban ')){
			if(stristr($wearType, 'hand')){$neededatt=30;
			} else{$neededdef=0;}
		} elseif(stristr($wear, 'Centaur ')){
			if(stristr($wearType, 'hand')){$neededatt=30;
			} else{$neededdef=30;}
		} elseif(stristr($wear, 'Equites ')){
			if(stristr($wearType, 'hand')){$neededcombat=30;
			} else{$neededcombat=30;}
		} elseif(stristr($wear, 'Elven ') && $wear!='Elven shoes'){
			if(stristr($wearType, 'hand')){$neededatt=35;
			} else{ $neededdef=35;}
		} elseif(stristr($wear, 'Silver ')){
			if(stristr($wearType, 'hand')){$neededatt=40+subTypeExtraLevel($wear);
			} else{$neededdef=40+subTypeExtraLevel($wear);}
		} elseif(stristr($wear, 'Saurus ') && stristr($wear, 'Stemosaurus ')==false){
			if(stristr($wearType, 'hand')){$neededatt=40;
			} else{$neededdef=40;}
		} elseif(stristr($wear, 'Roodarus ') OR  stristr($wear, 'Waranerus ') OR  stristr($wear, 'Stemosaurus ') ){
			if(stristr($wearType, 'hand')){$neededatt=45;
			} else{$neededdef=45;}
		} elseif(stristr($wear, 'Gold ')){
			if(stristr($wearType, 'hand')){$neededatt=55+subTypeExtraLevel($wear);
			} else{$neededdef=55+subTypeExtraLevel($wear);}
		} elseif(stristr($wear, 'Retiarii ')){
			if(stristr($wearType, 'hand')){$neededcombat=50;
			} else{$neededcombat=50;}


		} elseif(stristr($wear, 'Platina ')){
			if(stristr($wearType, 'hand')){$neededatt=70+subTypeExtraLevel($wear);
			} else{$neededdef=70+subTypeExtraLevel($wear);}
		} elseif(stristr($wear, 'Hoplomachi ')){
			if(stristr($wearType, 'hand')){$neededcombat=70;
			} else{$neededcombat=70;}
		} elseif(stristr($wear, 'Syriet ')){
			if(stristr($wearType, 'hand')){$neededatt=85+subTypeExtraLevel($wear);
			} else{$neededdef=85+subTypeExtraLevel($wear);}
		} elseif(stristr($wear, 'Samnite ')){
			if(stristr($wearType, 'hand')){$neededcombat=90;
			} else{$neededcombat=90;}
		} elseif(stristr($wear, 'Obsidian ')){
			if(stristr($wearType, 'hand')){$neededatt=100+subTypeExtraLevel($wear);
			} else{$neededdef=100+subTypeExtraLevel($wear);}
		} elseif(stristr($wear, 'Dragon ')){
			if(stristr($wearType, 'hand')){$neededatt=115;
			} else{$neededdef=115;}
		} elseif(stristr($wear, 'Puranium ')){
			if(stristr($wearType, 'hand')){$neededatt=120+(subTypeExtraLevel($wear)*2);
			} else{$neededdef=120+(subTypeExtraLevel($wear)*2);}
		} else if($wear=='Slamyeord'){
		      $neededcombat = 90;
		}else if(stristr($wear, 'Bone')){
		###$pan
			if(stristr($wear, ' lockpick')){
				$neededthieving=40;
            }
			else if(stristr($wear, ' tinderbox')){
				$neededcooking=75;
            }
			else if(stristr($wear, ' fishing rod')){
				$neededfishing=75;
            }
        }

		## EXCEPTIONS
		if(stristr($wear, 'crown')){$neededdef=1; }

		##


		if(($cookingl>=$neededcooking && $speedl>=$neededspeed && $smithingl>=$neededsmithing && $miningl>=$neededmin && $constructingl >= $neededconstructing &&
            $woodcuttingl>=$neededwood && $attackl>=$neededatt && $defencel>=$neededdef && $combatL>=$neededcombat && $fishingl>=$neededfishing && $thievingl>=$neededthieving) || $OKToEquip==1){
			//TODO - FIXME the wear=0 command doesnt properly work with limit 1, why ?


			echo"setTimeout(\"";

			unwearItemAndAddItem($wearType, '');

			if(stristr($wear, 'two hand')){
			 	unwearItemAndAddItem('shield', '');
			}else if($wearType=='shield'){
			 	unwearItemAndAddItem('hand', 'two hand');
			}

			removeItem($S_user, $wear, 1, $itemUpgrade, $itemUpgradeMuch, 1);

			$saaql = "INSERT INTO items_wearing (username,  type, name, itemupgrade, upgrademuch)
	 		VALUES ('$S_user', '$wearType', '$wear', '$itemUpgrade', '$itemUpgradeMuch')";
			mysqli_query($mysqli,$saaql) or die("Wear remove error 2, please report !");

			echo"\", 500);";

			include_once('includes/wearstats.php');
			wearStats($S_user, 1);


		} else {
		 	echo"messagePopup('";

			if($neededmin>$miningl){echo"You can not equip your $wear because you need level $neededmin mining to wear it."; }
			elseif($neededspeed>$speedl){echo"You can not equip your $wear because you need level $neededspeed speed to wear it."; }
			elseif($neededcooking>$cookingl){echo"You can not equip your $wear because you need level $neededcooking cooking to wear it."; }
			elseif($neededsmithing>$smithingl && $neededconstructing>$constructingl){echo"You can not equip your $wear because you need level $neededsmithing smithing or $neededconstructing constructing to wear it."; }
			elseif($neededsmithing>$smithingl){echo"You can not equip your $wear because you need level $neededsmithing smithing to wear it."; }
			elseif($neededwood>$woodcuttingl){echo"You can not equip your $wear because you need level $neededwood woodcutting to wear it."; }
			elseif($neededatt>$attackl){echo"You can not equip your $wear because you need level $neededatt attack to wear it."; }
			elseif($neededdef>$defencel){echo"You can not equip your $wear because you need level $neededdef defence to wear it."; }
			elseif($neededcombat>$combatL){echo"You can not equip your $wear because you need combat level $neededcombat to wear it."; }
			elseif($neededfishing>$fishingl){echo"You can not equip your $wear because you need fishing level $neededfishing to wear it."; }
			elseif($neededthieving>$thievingl){echo"You can not equip your $wear because you need thieving level $neededthieving to wear it."; }
			else{ echo"unknown equip error";}
			echo"', 'Equipping your $wear ');";
		}



	}



?>