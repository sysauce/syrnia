<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR><br/>";
$output.="<a href='' onclick=\"locationText('sail');return false;\"><font color=white>Sail</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){


if($action=='sail'){

	if($var1=='escape'){ #ESCAPE

			if(rand(1,10)<=7){ #FAIL

				$workt=time()+600;
				mysqli_query($mysqli, "UPDATE users SET work='jail', location='Skulls nose', worktime='$workt', dump2='Betraying the pirates....', dump='' WHERE username='$S_user' LIMIT 1") or die("err1");
				$S_location='Skulls nose';

				$output.="A pirate spotted you trying to escape!<BR>";
				$output.="You are sent to jail.<BR>";
				$output.="<a href='' onlick=\"updateCenterContents('move', 'Skulls nose');return false;\">Continue</a><BR><BR>";

			} else{


			$resultaat = mysqli_query($mysqli, "SELECT gold, fame FROM users WHERE username='$S_user' LIMIT 1");
			while ($record = mysqli_fetch_object($resultaat)) { $fame=$record->fame; $gold=$record->gold; if($fame > -12) { $fame = -12;} }


			$resultaat = mysqli_query($mysqli,  "SELECT username FROM items_inventory WHERE name='$var2' && type='boat'  && username='$S_user' LIMIT 1");
			$aantal = mysqli_num_rows($resultaat);
			if($aantal==1){

				$doen='done';  $timee=time();

				$workt=time()+($fame*-1)*5+60;
				$S_location='Sanfew';
				mysqli_query($mysqli, "UPDATE users SET work='jail', location='Sanfew', worktime='$workt', dump2='Ex-pirate', dump='', fame=IF(fame < 0, 0, fame), side='' WHERE username='$S_user' LIMIT 1") or die("err1");
				echo"$('statsFameText').innerHTML=0;";
				include('includes/mapData.php');

				$saql = "SELECT ID FROM sides WHERE leader='$S_user' LIMIT 1";
				$resultaaat = mysqli_query($mysqli, $saql);
				while ($record = mysqli_fetch_object($resultaaat))
				{
					mysqli_query($mysqli, "UPDATE sides SET leader='' WHERE ID=$record->ID  LIMIT 1") or die("err1");
				}


				$S_side='';
				$output.="You successfully escaped the pirate island...<BR>";
				$output.="But they are not happy with you at Remer islands either, they recognise you as ex-pirate and send you to jail.<BR>";
				$output.="If you've done your jailtime you can return to Remer islands with a clean slate.<BR>";
				$output.="<a href='' onclick=\"updateCenterContents('move', 'Sanfew');return false;\">Continue</a><BR><BR>";

				//Remove the pirate chat channel
				echo"updateCenterContents('reloadChatChannels');";


			}
			} #FAIL
	}








	include('textincludes/sailing.php');

	$output.="<BR><br />";

	if($doen<>'done'){
		$output.="<BR><BR>If you have your own boat you can try to escape the Pirate island...<BR>";
		$output.="You will betray the pirates. They won't be happy with you...<BR><BR>";
	   	$resultaat = mysqli_query($mysqli, "SELECT ID,name FROM items_inventory WHERE username='$S_user'  && type='boat' LIMIT 1");
	    while ($record = mysqli_fetch_object($resultaat))
		{
		 $output.="Use your $record->name to escape to: <a href='' onclick=\"locationText('sail', 'escape', '$record->name');return false;\">Port Senyn</a><BR>";
		}
	}
}else{
	$output.="The scenery here is of many pirate ships lined up along the harbor. The name of the town got its roots from when pirates used to bring prisoners back from successful raids.  They would chain the prisoners near crab nests, as the crabs would feast upon the tied up prisoners. ";
}


}
}
?>


