<?
if(defined('AZtopGame35Heyam') && $_SESSION['S_user']){

if($S_mapNumber!=3 && $S_mapNumber!=14){


	$action=$_POST['action'];
	$var1=$_POST['var1'];
	$var2=$_POST['var2'];

	if($action=='work')
    {

		//sleep(65);
		include('includes/work.php');

	}
    else if($action=='houses')
    {

		include('includes/locations/textincludes/houses.php');
		$output=str_replace('"', '\\"', $output);
		echo"$('LocationContent').innerHTML=\"$output\";";

	}
    else if($action=='shops')
    {

		include('includes/locations/textincludes/shops.php');
		$output=str_replace('"', '\\"', $output);
		echo"$('LocationContent').innerHTML=\"$output\";";


	}
    else if($action=='clancompound')
    {

		include('includes/locations/textincludes/clanCompounds.php');
		$output=str_replace('"', '\\"', $output);
		echo"$('LocationContent').innerHTML=\"$output\";";

	}
    else if($action=='construct')
    {

		include('includes/locations/textincludes/construct.php');
		$output=str_replace('"', '\\"', $output);
		echo"$('LocationContent').innerHTML=\"$output\";";

	}
    else
    {

	 	$includeLocation=$S_location;
		if(stristr($S_location, "Arch. cave 2")){$includeLocation='Arch. cave 2';}
        else if(stristr($S_location, "Arch. cave 3")){$includeLocation='Arch. cave 3';}
        else if(stristr($S_location, "Arch. cave 4")){$includeLocation='Arch. cave 4';}
        else if(stristr($S_location, "Arch. cave 5")){$includeLocation='Arch. cave 5';}
        else if(stristr($S_location, "Lost caves ")){$includeLocation='Lost caves';}

 		include_once('includes/levels.php');

	 	if(!$action){
			$locationshow='LocationMenu';
			$output='';
			include("includes/locations/$includeLocation.php");
			if($S_mapNumber==1 OR $S_mapNumber==2 OR $S_mapNumber==4 OR $S_mapNumber==6 OR $S_mapNumber==7 OR $S_mapNumber==15  OR $S_mapNumber==16 OR $S_mapNumber==19 OR  ($S_location=='Pensax') ){



				$output.="<a href='' onclick=\"locationText('shops');return false;\"><font color=white>Player Shops</font></a><br />";
				$output.="<a href='' onclick=\"locationText('houses');return false;\"><font color=white>Player House</font></a><br />";
				$output.="<br />";

                if(array_key_exists($S_location, $_SESSION["S_clanstockhouses"]))
                {
                    $output.="<a href='' onclick=\"locationText('clancompound');return false;\"><font color=white>Clan Stockhouse</font></a><br />";
                    $output.="<br />";
                }

				if($S_location!='Pensax' OR $constructingl>=10)
				{
					//$resultaat = mysqli_query($mysqli, "SELECT username FROM items_wearing WHERE name='Bronze hammer' && username='$S_user' LIMIT 1");
					//$aantal = mysqli_num_rows($resultaat);
					//if($aantal==1){}
					$output.="<a href='' onclick=\"locationText('construct');return false;\"><font color=white>Construct</font></a><br /><br />";
				}
			}

			$output=str_replace('"', '\\"', $output);
			echo"$('centerCityContents').innerHTML=\"$output\";";

			RebuildDropList();
		echo "recreateSortable('playerInventory');";
		echo updatePlayers();

		}


		$locationshow='LocationText';
		$output='';


		include("includes/locations/$includeLocation.php");
		if(($action=='events' OR !$action)){
			include("includes/events.php");
		}
		$output=str_replace('"', '\\"', $output);

		echo"$('LocationContent').innerHTML=\"$output\";";




	}

}else{
	#PVP

	$action=$_POST['action'];
	$var1=$_POST['var1'];
	$var2=$_POST['var2'];

	if($action=='work'){

		include('includes/work.php');

	}else if($action){
		include('includes/pvp.php');
	}


}#OL

}
?>