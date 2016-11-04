<?
if(defined('AZtopGame35Heyam')){

if($S_location=='Eylsian docks'){
	$sailLocations[1]['location']="Port party";
	$sailLocations[1]['goldCost']=0;
	$sailLocations[1]['timeCost']=60;
	$sailLocations[1]['disallowOwnBoats']=0;
	$sailLocations[1]['side']='any';
	$sailLocations[2]['location']="Thabis";
	$sailLocations[2]['goldCost']=1000;
	$sailLocations[2]['timeCost']=300;
	$sailLocations[2]['disallowOwnBoats']=1;
	$sailLocations[2]['onlyAllowBoat']="Canoe";	
	$sailLocations[2]['side']='any';
}else if($S_location=='Thabis'){
	$sailLocations[1]['location']="Eylsian docks";
	$sailLocations[1]['goldCost']=1000;
	$sailLocations[1]['timeCost']=300;
	$sailLocations[1]['disallowOwnBoats']=1;
	$sailLocations[1]['onlyAllowBoat']="Canoe";	
	$sailLocations[1]['side']='any';
}else if($S_location=='Port party'){
	

	//Return to where you came from
	$resultaat = mysqli_query($mysqli,"SELECT partyIslandSailLocation FROM users_junk WHERE username='$S_user' LIMIT 1");     
	while ($record = mysqli_fetch_object($resultaat))
	{
		if($record->partyIslandSailLocation){
			$sailLocations[1]['location']="$record->partyIslandSailLocation";
			$sailLocations[1]['goldCost']=0;
			$sailLocations[1]['timeCost']=60;
			$sailLocations[1]['disallowOwnBoats']=0;
			$sailLocations[1]['side']='any';
		}else{
			$sailLocations[1]['location']="Port Senyn";
			$sailLocations[1]['goldCost']=0;
			$sailLocations[1]['timeCost']=60;
			$sailLocations[1]['disallowOwnBoats']=0;
			$sailLocations[1]['side']='';
			$sailLocations[2]['location']="Crab nest";
			$sailLocations[2]['goldCost']=0;
			$sailLocations[2]['timeCost']=60;
			$sailLocations[2]['disallowOwnBoats']=0;
			$sailLocations[2]['side']='Pirate';
			$sailLocations[3]['location']="Burning beach";
			$sailLocations[3]['goldCost']=0;
			$sailLocations[3]['timeCost']=60;
			$sailLocations[3]['disallowOwnBoats']=0;
			$sailLocations[3]['side']='any';	
		}		
	}
	
}else if($S_location=='Port Senyn'){
	$sailLocations[1]['location']="Port Dazar";
	$sailLocations[1]['goldCost']=20;
	$sailLocations[1]['timeCost']=60;
	$sailLocations[1]['disallowOwnBoats']=0;
	$sailLocations[1]['side']='';
	$sailLocations[2]['location']="Port party";
	$sailLocations[2]['goldCost']=0;
	$sailLocations[2]['timeCost']=60;
	$sailLocations[2]['disallowOwnBoats']=0;
	$sailLocations[2]['side']='';
	$sailLocations[3]['location']="The Outlands";
	$sailLocations[3]['goldCost']=50;
	$sailLocations[3]['timeCost']=80;
	$sailLocations[3]['disallowOwnBoats']=0;
	$sailLocations[3]['side']='any';
}else if($S_location=='Port Dazar'){
	$sailLocations[1]['location']="Port Senyn";
	$sailLocations[1]['goldCost']=0;
	$sailLocations[1]['timeCost']=60;
	$sailLocations[1]['disallowOwnBoats']=0;
	$sailLocations[1]['side']='';
	$sailLocations[2]['location']="Xanso";
	$sailLocations[2]['goldCost']=150;
	$sailLocations[2]['timeCost']=120;
	$sailLocations[2]['disallowOwnBoats']=0;
	$sailLocations[2]['side']='';
}else if($S_location=='Xanso'){
	$sailLocations[1]['location']="Port Dazar";
	$sailLocations[1]['goldCost']=0;
	$sailLocations[1]['timeCost']=120;
	$sailLocations[1]['disallowOwnBoats']=0;
	$sailLocations[1]['side']='';
	$sailLocations[2]['location']="Heerchey docks";
	$sailLocations[2]['goldCost']=500;
	$sailLocations[2]['timeCost']=240;
	$sailLocations[2]['disallowOwnBoats']=1;
	$sailLocations[2]['side']='';
	$sailLocations[3]['location']="Burning beach";
	$sailLocations[3]['goldCost']=250;
	$sailLocations[3]['timeCost']=240;
	$sailLocations[3]['disallowOwnBoats']=0;
	$sailLocations[3]['side']='';
	$sailLocations[4]['location']="Port Calviny";
	$sailLocations[4]['goldCost']=50;
	$sailLocations[4]['timeCost']=120;
	$sailLocations[4]['disallowOwnBoats']=0;
	$sailLocations[4]['side']='';
	$sailLocations[5]['location']="Web haven";
	$sailLocations[5]['goldCost']=25;
	$sailLocations[5]['timeCost']=120;
	$sailLocations[5]['disallowOwnBoats']=0;
	$sailLocations[5]['side']='';
}else if($S_location=='Web haven'){
	$sailLocations[1]['location']="Xanso";
	$sailLocations[1]['goldCost']=25;
	$sailLocations[1]['timeCost']=120;
	$sailLocations[1]['disallowOwnBoats']=0;
	$sailLocations[1]['side']='';
}else if($S_location=='Crab nest'){
	$sailLocations[1]['location']="The Outlands";
	$sailLocations[1]['goldCost']=50;
	$sailLocations[1]['timeCost']=230;
	$sailLocations[1]['disallowOwnBoats']=0;
	$sailLocations[1]['side']='Pirate';
	$sailLocations[2]['location']="Port party";
	$sailLocations[2]['goldCost']=0;
	$sailLocations[2]['timeCost']=60;
	$sailLocations[2]['disallowOwnBoats']=0;
	$sailLocations[2]['side']='Pirate';
	$sailLocations[3]['location']="Burning beach";
	$sailLocations[3]['goldCost']=250;
	$sailLocations[3]['timeCost']=240;
	$sailLocations[3]['disallowOwnBoats']=0;
	$sailLocations[3]['side']='Pirate';
	$sailLocations[4]['location']="Port Calviny";
	$sailLocations[4]['goldCost']=50;
	$sailLocations[4]['timeCost']=120;
	$sailLocations[4]['disallowOwnBoats']=0;
	$sailLocations[4]['side']='Pirate';
	$sailLocations[5]['location']="Heerchey docks";
	$sailLocations[5]['goldCost']=500;
	$sailLocations[5]['timeCost']=240;
	$sailLocations[5]['disallowOwnBoats']=1;
	$sailLocations[5]['side']='Pirate';
}else if($S_location=='Heerchey docks'){
	$sailLocations[1]['location']="Xanso";
	$sailLocations[1]['goldCost']=0;
	$sailLocations[1]['timeCost']=240;
	$sailLocations[1]['disallowOwnBoats']=1;
	$sailLocations[1]['side']='';
	$sailLocations[2]['location']="Crab nest";
	$sailLocations[2]['goldCost']=0;
	$sailLocations[2]['timeCost']=240;
	$sailLocations[2]['disallowOwnBoats']=1;
	$sailLocations[2]['side']='Pirate';
	$sailLocations[3]['location']="Port Calviny";
	$sailLocations[3]['goldCost']=0;
	$sailLocations[3]['timeCost']=120;
	$sailLocations[3]['disallowOwnBoats']=1;
	$sailLocations[3]['side']='any';
}else if($S_location=='Burning beach'){
	$sailLocations[1]['location']="Xanso";
	$sailLocations[1]['goldCost']=0;
	$sailLocations[1]['timeCost']=240;
	$sailLocations[1]['disallowOwnBoats']=0;
	$sailLocations[1]['side']='';
	$sailLocations[2]['location']="Crab nest";
	$sailLocations[2]['goldCost']=0;
	$sailLocations[2]['timeCost']=240;
	$sailLocations[2]['disallowOwnBoats']=0;
	$sailLocations[2]['side']='Pirate';
	$sailLocations[3]['location']="Port Calviny";
	$sailLocations[3]['goldCost']=75;
	$sailLocations[3]['timeCost']=120;
	$sailLocations[3]['disallowOwnBoats']=0;
	$sailLocations[3]['side']='any';
	$sailLocations[4]['location']="Port party";
	$sailLocations[4]['goldCost']=0;
	$sailLocations[4]['timeCost']=60;
	$sailLocations[4]['disallowOwnBoats']=0;
	$sailLocations[4]['side']='any';
}else if($S_location=='Port Calviny'){
	$sailLocations[1]['location']="Xanso";
	$sailLocations[1]['goldCost']=50;
	$sailLocations[1]['timeCost']=120;
	$sailLocations[1]['disallowOwnBoats']=0;
	$sailLocations[1]['side']='';
	$sailLocations[2]['location']="Crab nest";
	$sailLocations[2]['goldCost']=50;
	$sailLocations[2]['timeCost']=120;
	$sailLocations[2]['disallowOwnBoats']=0;
	$sailLocations[2]['side']='Pirate';
	$sailLocations[3]['location']="Burning beach";
	$sailLocations[3]['goldCost']=75;
	$sailLocations[3]['timeCost']=120;
	$sailLocations[3]['disallowOwnBoats']=0;
	$sailLocations[3]['side']='any';
	$sailLocations[4]['location']="Heerchey docks";
	$sailLocations[4]['goldCost']=500;
	$sailLocations[4]['timeCost']=120;
	$sailLocations[4]['disallowOwnBoats']=1;
	$sailLocations[4]['side']='any';
} 


}
?>