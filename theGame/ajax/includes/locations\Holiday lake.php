<?
if(defined('AZtopGame35Heyam')){

global $PARTYISLAND;
if(!$PARTYISLAND && $S_mapNumber==8 && $S_user!='M2H' && $S_user!='edwin'){
	mysqli_query($mysqli, "UPDATE users SET location=(SELECT partyIslandSailLocation FROM users_junk WHERE username='$S_user' LIMIT 1) WHERE username='$S_user'") or die("error --> 1113");
	/*mysqli_query($mysqli, "UPDATE users SET location='Crab nest', work='', worktime='', dump='', dump2='',dump3='' WHERE location='$S_location' && side='Pirate'") or die("error --> 1113");
	mysqli_query($mysqli, "UPDATE users SET location='Port Senyn', work='', worktime='', dump='', dump2='',dump3='' WHERE location='$S_location' && side!='Pirate'") or die("error --> 1113");*/
	include('includes/mapData.php');
	echo"updateCenterContents('loadLayout', 1);";
	exit();
}

$xmas = isXmas();

if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR><BR>";
$output.="<a href='' onclick=\"locationText('work', 'fishing');return false;\"><font color=white>Fish</a><BR>";

if(date("Y-m-d")=='2007-10-31' OR date("Y-m-d")=='2007-10-30' ){
 	$output.="<a href='' onclick=\"fighting('$S_location');return false;\"><font color=white>Fight a halloween monster (11+)</a><BR>";
	$output.="<a href='?action=fiend'><font color=white>The skeletal fiend</a><BR>";
}else if(date("Y-m-d")=='2007-12-24' OR date("Y-m-d")=='2007-12-25' OR date("Y-m-d")=='2007-12-26' ){
 	$output.="<a href='?action=snowman'><font color=white>Build a snowman</a><BR>";
}else if(date("Y-m")=='2009-12'){
 	$output.="<a href='' onclick=\"locationText('snowwoman');return false;\"><font color=white>Build a snowwoman</a><BR>";
}else if(date("Y-m-d")=='2008-12-23' OR date("Y-m-d")=='2008-12-25' OR date("Y-m-d")=='2008-12-26' ){
 	$output.="<a href='' onclick=\"locationText('tree');return false;\"><font color=white>Build a dressed christmas tree</a><BR>";
}else if($xmas){
 	$output.="<a href='' onclick=\"locationText('stocking');return false;\"><font color=white>Make a " . getXmasStockingColour() . " stocking</a><BR>";
}


$output.="<br/>";

} elseif($locationshow=='LocationText'){

if($action=='fiend' && (date("Y-m-d")=='2007-10-31' OR date("Y-m-d")=='2007-10-30')){
	$output.="You see scary, but sad, skeletons fishing at the lake.<br/>
	Somehow it pops into your mind to ask one of these skeletons how he (or she) is feeling.<br/>
	<br/>
	The skeleton tells you he's sad that some of his bones are missing, and some of his bones are badly damaged.
	He'd love to get new bones but is afraid of the fighters currently bashing all skeletons for their bones and can't get new the parts himself.
	Can you help him?<br/>
	<br/>";

	if( itemAmount($S_user, 'Skeleton arm', 'other',  '', '')>=2 && itemAmount($S_user, 'Skeleton leg', 'other',  '', '')>=2 &&
		itemAmount($S_user, 'Skeleton body', 'other',  '', '')>=1 && itemAmount($S_user, 'Skeleton skull', 'other',  '', '')>=1 ){
		 if($give){
		  	removeItem($S_user, 'Skeleton arm', 2);
		  	removeItem($S_user, 'Skeleton leg', 2);
		  	removeItem($S_user, 'Skeleton body', 1);
		  	removeItem($S_user, 'Skeleton skull', 1);
		  	$get=rand(1,8);
		  	if($get==1){  $get="Koban mask"; $gettype="helm"; $getmuch=1;
			}elseif($get==2){  $get="Pumpkin seeds"; $gettype="seeds"; $getmuch=25;
			}elseif($get==3){  $get="Halloween pumpkin"; $gettype="cooked food"; $getmuch=2;
    		}elseif($get==4){  $get="Red gift"; $gettype="open"; $getmuch=3;
    		}elseif($get==5){  $get="Green gift"; $gettype="open"; $getmuch=10;
    		}elseif($get==6){  $get="Moldy chest"; $gettype="open"; $getmuch=2;
    		}elseif($get==7){  $get="Pumpkin"; $gettype="cooked food"; $getmuch=6;
    		}elseif($get==8){  $get="Blue gift"; $gettype="open"; $getmuch=3;
			}

		  	addItem($S_user, $get, $getmuch, $gettype, '', '', 1);

		  	$output.="You exchange your parts for a reward:<br/>";
		  	$output.="You got $getmuch $get!<br/>";
		  }else{
	 		$output.="You got all the parts the skeleton wants. Do you want to exchange the parts for a reward ?<br/>
	 		<a href=?action=fiend&give=1>Alright</a>";
	 }
	}else{
	$output.="The skeleton will reward you if you get him:<br/>
	2 Skeleton arms.<br/>
	2 Skeleton legs.<br/>
	1 Skeleton body.<br/>
	1 Skeleton skull.<br/>
	<br/>";
	}

}elseif($action=='snowman' && (date("Y-m-d")=='2007-12-24' OR date("Y-m-d")=='2007-12-25' OR date("Y-m-d")=='2007-12-26')){
	$output.="If you've got all required parts, you can build a snowman<br/>
	<br/>";

	if( itemAmount($S_user, 'Coal', '', '', '')>=1 && itemAmount($S_user, 'Carrots', '', '', '')>=1 &&
		itemAmount($S_user, 'Small snowball', '', '', '')>=1 && itemAmount($S_user, 'Big snowball', '', '', '')>=1  && itemAmount($S_user, 'Santa hat', '', '', '')>=1){
		 if($give){
		  	removeItem($S_user, 'Coal', 1);
		  	removeItem($S_user, 'Carrots', 1);
		  	removeItem($S_user, 'Small snowball', 1);
		  	removeItem($S_user, 'Big snowball', 1);
		  	removeItem($S_user, 'Santa hat', 1);
			  $get=rand(1,1);
		  	if($get==1){  $get="Snowman"; $gettype="other"; $getmuch=1;
			}

		  	addItem($S_user, $get, $getmuch, $gettype, '', '', 1);
		  	$output.="You built a snowman!<br/>";
		  }else{
	 		$output.="You got all the parts to build a snowman, want to build one ?<br/>
	 		<a href=?action=snowman&give=1>Alright</a>";
	 }
	}else{
	$output.="You need:<br/>
	1 Coal.<br/>
	1 Carrot.<br/>
	1 Small snowball.<br/>
	1 Big snowball.<br/>
	1 Santa hat.<br/>
	<br/>";
	}

}elseif($action=='snowwoman' && (date("m")=='12')){
	$output.="If you've got all required parts, you can build a snowwoman<br/><br/>";

	if( itemAmount($S_user, 'Coal', '', '', '')>=1 && itemAmount($S_user, 'Carrots', '', '', '')>=1 &&
		itemAmount($S_user, 'Small snowball', '', '', '')>=1 && itemAmount($S_user, 'Big snowball', '', '', '')>=1  && itemAmount($S_user, 'Poinsettia', '', '', '')>=1){
		 if($var1){
		  	removeItem($S_user, 'Coal', 1);
		  	removeItem($S_user, 'Carrots', 1);
		  	removeItem($S_user, 'Small snowball', 1);
		  	removeItem($S_user, 'Big snowball', 1);
		  	removeItem($S_user, 'Poinsettia', 1);
			  $get=rand(1,1);
		  	if($get==1){  $get="Snowwoman"; $gettype="other"; $getmuch=1;
			}

		  	addItem($S_user, $get, $getmuch, $gettype, '', '', 1);
		  	$output.="You built a snowwoman!<br/>";
		  }else{
	 		$output.="You got all the parts to build a snowwoman, want to build one ?<br/>";
	 		$output.="<a href='' onclick=\"locationText('snowwoman', '1');return false;\">Alright</a>";
	 }
	}else{
		$output.="You need:<br/>";
		$output.="1 Coal.<br/>";
		$output.="1 Carrot.<br/>";
		$output.="1 Small snowball.<br/>";
		$output.="1 Big snowball.<br/>";
		$output.="1 Poinsettia.<br/>";
		$output.="<br/>";
	}

}elseif($action=='tree' && (date("Y-m-d")=='2008-12-23' OR date("Y-m-d")=='2008-12-25' OR date("Y-m-d")=='2008-12-26')){
	$output.="If you've got all required parts, you can build a Dressed christmas tree<br/><br/>";



	if( itemAmount($S_user, 'Fallen star', '', '', '')>=1 && itemAmount($S_user, 'Red bauble', '', '', '')>=4 &&
		itemAmount($S_user, 'Christmas tree', '', '', '')>=1 && itemAmount($S_user, 'Tinsel', '', '', '')>=2
		){
		 if($var1){
		  	removeItem($S_user, 'Fallen star', 1, '', '', 1);
		  	removeItem($S_user, 'Red bauble', 4, '', '', 1);
		  	removeItem($S_user, 'Christmas tree', 1, '', '', 1);
		  	removeItem($S_user, 'Tinsel', 2, '', '', 1);
			$get=rand(1,1);
		  	if($get==1){  $get="Dressed christmas tree"; $gettype="other"; $getmuch=1;
			}

		  	addItem($S_user, $get, $getmuch, $gettype, '', '', 1);
		  	$output.="You built a $get!<br/>";
		  }else{
	 		$output.="You got all the parts to create a Dressed christmas tree, want to create one ?<br/>";
	 		$output.="<a href='' onclick=\"locationText('tree', '1');return false;\">Alright</a>";
	 }
	}else{
		$output.="You need:<br/>";
		$output.="1 Fallen star.<br/>";
		$output.="2 Tinsel.<br/>";
		$output.="4 Red bauble.<br/>";
		$output.="1 Christmas tree.<br/>";
		$output.="<br/>";
	}


}
else if($action=='stocking' && $xmas)
{
    $colour = getXmasStockingColour();
    $decorationColour = getXmasStockingDecorationColour($colour);
	$output.="If you've got all required parts, you can make a $colour christmas stocking<br/><br/>";

    $numSanta = itemAmount($S_user, "Santa patch", '', '', '');
    $numSnowman = itemAmount($S_user, "Snowman patch", '', '', '');
    $numRudolph = itemAmount($S_user, "Rudolph patch", '', '', '');

	if(itemAmount($S_user, "$colour christmas sock", '', '', '') >= 1 &&
        itemAmount($S_user, "Stocking decorations " . date('Y'), '', '', '') >= 5 &&
		itemAmount($S_user, "White rabbit fur", '', '', '') >= 2 &&
        ($numSanta >= 1 || $numSnowman >= 1 || $numRudolph >= 1))
    {
	    if(!$var1)
        {
	 		$output.="You have all the materials required to create a $colour christmas stocking, which one would you like to make?<br/><br/>";
	 		$output.=($numSanta >= 1 ? "<a href='' onclick=\"locationText('stocking', '1');return false;\">$colour santa christmas stocking</a><br/><br/>" : "");
	 		$output.=($numSnowman >= 1 ? "<a href='' onclick=\"locationText('stocking', '2');return false;\">$colour snowman christmas stocking</a><br/><br/>" : "");
	 		$output.=($numRudolph >= 1 ? "<a href='' onclick=\"locationText('stocking', '3');return false;\">$colour rudolph christmas stocking</a><br/><br/>" : "");
		}
        else
        {
            $continue = true;

            switch($var1)
            {
                case 1:
                    if($numSanta >= 1)
                    {
                        removeItem($S_user, "Santa patch", 1, '', '', 1);
                        $get="$colour santa christmas stocking";
                    }
                    else
                    {
                        $output .= "You have no Santa patches remaining";
                        $continue = false;
                    }
                    break;

                case 2:
                    if($numSnowman >= 1)
                    {
                        removeItem($S_user, "Snowman patch", 1, '', '', 1);
                        $get="$colour snowman christmas stocking";
                    }
                    else
                    {
                        $output .= "You have no Snowman patches remaining";
                        $continue = false;
                    }
                    break;

                case 3:
                    if($numRudolph >= 1)
                    {
                        removeItem($S_user, "Rudolph patch", 1, '', '', 1);
                        $get="$colour rudolph christmas stocking";
                    }
                    else
                    {
                        $output .= "You have no Rudolph patches remaining";
                        $continue = false;
                    }
                    break;
            }

            if($continue)
            {
                removeItem($S_user, "$colour christmas sock", 1, '', '', 1);
                removeItem($S_user, "Stocking decorations " . date('Y'), 5, '', '', 1);
                removeItem($S_user, "White rabbit fur", 2, '', '', 1);

                $gettype="other"; $getmuch=1;

                addItem($S_user, $get, $getmuch, $gettype, '', '', 1);
                $output.="You made a $get!<br/><br/><a href='' onclick=\"locationText('stocking');return false;\">Make another</a>";
            }
        }
	}else{
		$output.="You need:<br/>";
		$output.="1 $colour christmas sock.<br/>";
		$output.="1 Santa, Snowman or Rudolph patch.<br/>";
		$output.="2 White rabbit fur.<br/>";
		$output.="5 Stocking decorations " . date('Y') . ".<br/>";
		$output.="<br/>";
	}


}else{

	$output.="Welcome to Holiday lake.<br />";
	$output.="The frost on the winter lake reflects a multitude of color. It is suspected that the Christmas revelers will find a little more than they expect today.<br />";

	/*
	$output.="You spot a big sign: <BR>";
	$output.="<BR>";
	$output.="\"Thanks for all of the fish in the lake.  I used them to create all of my special orbs.  I wouldn't waste your time fishing when there's nothing left in the lake.<br /><br />Signed:  Halloween Witch</i>\"<BR>";
	$output.="<BR>";
	*/

	/*
	$output.="Welcome to Holiday lake.<BR>";
	$output.="You spot a big sign: <BR>";
	$output.="<BR>";
	$output.="\"<B>NO FISHING ALLOWED</B><BR>";
	$output.="by order of the S.S.S.R.F<BR>";
	$output.="<i>Syrnians to Save the Striped Red Fish</i>\"<BR>";
	$output.="<BR>";
	$output.="However, this sign is all bashed up..seems like we are 'allowed' to fish here again.<BR>";
	$output.="This lake contains the Striped red fish, can you catch the biggest Striped red fish?<BR>";
	$output.="<BR>";
	*/
}

}
}
?>