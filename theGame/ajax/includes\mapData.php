<?
if(defined('AZtopGame35Heyam')){

 	$sql = "SELECT location FROM users WHERE username='$S_user' LIMIT 1";
	$resultaat = mysqli_query($mysqli, $sql);
	while ($record = mysqli_fetch_object($resultaat))
	{
	 	$S_location=$record->location;
	}

if(stristr ($S_location, "Arch. cave 3")){
 	$S_mapNumber=12;
	$mapArea[$S_location][0]['location']='Arch. cave 3';
	$mapArea[$S_location][0]['x1']=0;  $mapArea[$S_location][0]['x2']=160;
	$mapArea[$S_location][0]['y1']=0; $mapArea[$S_location][0]['y2']=160;
	$locationExists=1;
	$locationImage="mapdark.gif";
}
else if(stristr ($S_location, "Lost caves"))
{
 	$S_mapNumber=20;
    if($S_location == 'Lost caves 1')
    {
        $mapArea[$S_location][0]['location']='Lost caves 2';
        $mapArea[$S_location][0]['x1']=0;  $mapArea[$S_location][0]['x2']=160;
        $mapArea[$S_location][0]['y1']=0;  $mapArea[$S_location][0]['y2']=80;
    }
    else if($S_location == 'Lost caves 10')
    {
        $mapArea[$S_location][0]['location']='Lost caves 9';
        $mapArea[$S_location][0]['x1']=0;  $mapArea[$S_location][0]['x2']=160;
        $mapArea[$S_location][0]['y1']=81; $mapArea[$S_location][0]['y2']=160;
    }
    else
    {
        $n = explode(" ", $S_location);
        $n = $n[2];
        $mapArea[$S_location][0]['location']='Lost caves ' . ($n-1);
        $mapArea[$S_location][0]['x1']=0;  $mapArea[$S_location][0]['x2']=160;
        $mapArea[$S_location][0]['y1']=100; $mapArea[$S_location][0]['y2']=160;

        $mapArea[$S_location][1]['location']='Lost caves ' . ($n+1);
        $mapArea[$S_location][1]['x1']=0;  $mapArea[$S_location][1]['x2']=160;
        $mapArea[$S_location][1]['y1']=0;  $mapArea[$S_location][1]['y2']=60;
    }
	$locationExists=1;
	$locationImage="mapfog.gif";
}
else{

	$sql = "SELECT moveToArray, mapNumber FROM locationinfo WHERE locationName = '$S_location' LIMIT 1 ";
	$resultaat = mysqli_query($mysqli, $sql);
	while ($record = mysqli_fetch_object($resultaat))
	{
	 	//This code is a move code, and in mapData.php
		$locationImage="$S_location.jpg";
		if($S_mapNumber!=$record->mapNumber){
			$S_mapNumber=$record->mapNumber;
			if($S_mapNumber==3 || $S_mapNumber==14){
				echo"setTimeout(\"pvpLog($timee);\", 1000);";
			}
		}
		$moveToArrayData = explode ("|", $record->moveToArray);
		for($i=0;$moveToArrayData[$i];$i++){
			$moveToCoords = explode ("#", $moveToArrayData[$i]);

			$mapArea[$S_location][$i]['location']=$moveToCoords[4];
			$mapArea[$S_location][$i]['travelTime']=$moveToCoords[5];

			$mapArea[$S_location][$i]['x1']=$moveToCoords[0];  $mapArea[$S_location][$i]['x2']=$moveToCoords[2];
			$mapArea[$S_location][$i]['y1']=$moveToCoords[1]; $mapArea[$S_location][$i]['y2']=$moveToCoords[3];

		}

	}
}

if($S_mapNumber=='11'){$locationImage="mapfog.gif";}
if($S_mapNumber=='12'){$locationImage="mapdark.gif";}
if($S_mapNumber=='14'){$locationImage="$S_location.gif";}
if($S_mapNumber=='3' || $S_mapNumber=='4'){$locationImage="$S_location.gif";}
if($S_mapNumber=='20'){$locationImage="mapfog.gif";}


//Build click list
$area="";
for($i=0;$mapArea[$S_location][$i];$i++){
	$area.="<area shape=\"rect\" coords=\"".$mapArea[$S_location][$i]['x1'].",".$mapArea[$S_location][$i]['y1'].",".$mapArea[$S_location][$i]['x2'].",".$mapArea[$S_location][$i]['y2']."\" href=\"\" onclick=\"updateCenterContents('move', '".$mapArea[$S_location][$i]['location']."');return false;\">";
}

 $uniqueLocationName=str_replace(' ', 'X', $S_location);
$mapecho='';
//$mapecho="<map name=\"Map$uniqueLocationName\">$area</map>";
//$uniqueLocationName
$mapecho.="<img src='images/map/$locationImage' alt='Click to travel' width=160 height=160 border=0 usemap=\"#movemap\" /><br /><a href=\"images/worldmap.php\" onClick='enterWindow=window.open(\"images/worldmap.php?map=$S_mapNumber\",\"\",\"width=860,height=650,top=5,left=5,scrollbars=yes\"); return false'><img src=layout/viewworldmap.gif border=0></a>";

$mapecho=str_replace('"', '\"', $mapecho);
echo"$('mapContents').innerHTML=\"$mapecho\";
";
$area=str_replace('"', '\"', $area);
echo"$('moveMap').innerHTML=\"$area\";
";

}
?>