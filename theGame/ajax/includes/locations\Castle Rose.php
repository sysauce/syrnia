<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$halloween = isHalloween();

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"locationText('keep');return false;\"><font color=white>Castle Rose Keep</a><br/>";
$output.="<a href='' onclick=\"locationText('chapel');return false;\"><font color=white>Visit the chapel</a><BR>";
$output.="<a href='' onclick=\"locationText('fountain');return false;\"><font color=white>Fountain</a><BR>";
$output.="<a href='' onclick=\"locationText('smith');return false;\"><font color=white>Smithy</a><br/>";
$output.="<a href='' onclick=\"locationText('tradingpost');return false;\"><font color=white>Trade post</a><br/>";
$output.="<a href='' onclick=\"locationText('stables');return false;\"><font color=white>Stables</a></br>";
$output.="<a href='' onclick=\"locationText('tavern');return false;\"><font color=white>Tavern</a><br/>";
$output.="<a href='' onclick=\"locationText('flowers');return false;\"><font color=white>Flower stands</a><br/>";

//if(date(jn)=='53' OR date(jn)=='13' && $S_user=='M2H'){$output.="<a href=?p=stats><font color=white>Syrnia statistics</a><BR>"; }
if($halloween)
{
 	$output.="<br/>";
 	$output.="<a href='' onclick=\"locationText('tricktreat');return false;\"><font color=white>Trick or Treat present</a><BR>";
    $output.="<a href='' onclick=\"locationText('adoptaskeletal');return false;\"><font color=white>Skeletal stables</a><BR>";
}

$output.="<BR>";

} elseif($locationshow=='LocationText'){

if($action=='chapel'){
	 $output.="It's a nice little chapel by the east end of the city mainly for weddings and other services. ";
	$output.="An older man wearing priest robes approaches \"Welcome to my chapel friend, if you would wish to marry someone I would be happy to add you to our books here\"";
	include('textincludes/chapel.php');

}elseif($action=='smith'){
	$output.="The city has a very nice smithing facility that is known for their great iron and steel works and it's free to use.<BR><BR>";
	include("textincludes/smithing.php");
}elseif($action=='tradingpost'){
	include('textincludes/trading.php');
}elseif($action=='stables'){
	include('textincludes/shop.php');
}elseif($action=='keep'){
	 $output.="The ruler of Castle Rose, Lord Davamras Serpenthelm, sits before you. He looks to be the kind of leader who has seen ";
	 $output.="his share of adventures and has now settled down to rule Castle Rose, even though he doesn't seem to have the etiquette that ";
	 $output.="the others at court have.";

	$questID=15;
	if(stristr($_SESSION['S_questscompleted'], "[$questID]")==false && ( stristr($_SESSION['S_quests'], "$questID(")==false OR stristr($_SESSION['S_quests'], "$questID(3)]")     )){
		$output.="<BR><BR>";
		include('textincludes/quests.php');
	}

	$questID=16;
	if(stristr($_SESSION['S_questscompleted'], "[$questID]")==false && stristr($_SESSION['S_questscompleted'], "[15]")==true && ( stristr($_SESSION['S_quests'], "$questID(")==false OR stristr($_SESSION['S_quests'], "$questID(2)]")     )){
		$output.="<BR><BR>";
		include('textincludes/quests.php');
	}

	$questID=17;
	if(stristr($_SESSION['S_questscompleted'], "[$questID]")==false && stristr($_SESSION['S_questscompleted'], "[16]")==true ){
	 if(( stristr($_SESSION['S_quests'], "$questID(")==false OR stristr($_SESSION['S_quests'], "$questID(2)]")     )){
			 $output.="<BR><BR>";
		include('textincludes/quests.php');
		}

	}




}elseif($action=='tavern'){
	 $output.="This tavern is a very well kept and popular social spot for everyone in the city from nobles to the castle guards with ";
	 $output.="enough ale for everyone.";

	$questID=13;
	if(stristr($_SESSION['S_questscompleted'], "[$questID]")===false && ( stristr($_SESSION['S_quests'], "$questID(")==false OR stristr($_SESSION['S_quests'], "$questID(3)]")     )){
		$output.="<BR><BR>";
		include('textincludes/quests.php');
	}

 }elseif($action=='flowers'){
	$output.="The city has several of these small stands throughout and each loaded with roses. ";
	$output.="The lady working this stand welcomes you warmly <i>\"Welcome to my stand, as you may know the rose is the royal crest of ";
	$output.="Castle Rose and a symbol of nobility here, they are for sale but I'll have you know they don't come cheap.\"</i>";


$koop[1][name]="Rose";
$koop[1][type]="flower";
$koop[1][costgold]="100";

$i=1;
while($i<=1){

	if($var1=='buy' && $var2==$i){
		$output.="<BR>";
		$goldcost=$koop[$i][costgold];

	if($goldcost>0 && payGold($S_user, $goldcost)==1){
		   $type=$koop[$i][type];          $name=$koop[$i][name];

		   addItem($S_user, $name, 1, $type, '', '', 1);

		   	$output.="<B>You bought a ".$koop[$i][name]."!</B><BR>";
	   }else{
	    	$output.="<B>You have not got enough gold!</B><BR>";
		}


	}
$output.="<br/>Buy a <a href='' onclick=\"locationText('flowers', 'buy', '$i');return false;\">".$koop[$i][name]."</a> for ".$koop[$i][costgold]." gold<BR>";
   $i++;
}
$output.="<BR><HR>";



}elseif($action=='fountain'){
	$output.="In the center of the city is a large round fountain with elaborate statues of old adventurers that founded the city years earlier.";

 	$questID=14;
	if(stristr($_SESSION['S_questscompleted'], "[$questID]")===false && ( stristr($_SESSION['S_quests'], "$questID(")==false OR stristr($_SESSION['S_quests'], "$questID(1)]") OR  stristr($_SESSION['S_quests'], "$questID(2)]")     )){
		$output.="<BR><BR>";
		include('textincludes/quests.php');
	}

}elseif($action=='tricktreat'){

    $output .= trickOrTreat();

}

else if($action=='adoptaskeletal')
{
    $event= "skeletal" . date("Y");

    $aantal='a';
    $resultaat = mysqli_query($mysqli, "SELECT joined FROM users WHERE username='$S_user' LIMIT 1" );
    while ($record = mysqli_fetch_object($resultaat)) { $memberfor=ceil((time()-$record->joined)/86400); }


    if(date(jn)=='134' OR date(jn)=='144' OR date(jn)=='154'   OR date(jn)=='164' ){
        $presentGiver='the easter bunny';
    }
    elseif($xmas){
        $presentGiver='Santa';
    }
    elseif($halloween){
        $presentGiver='Halloween witch';
    }
    else
    {
        $presentGiver='Syrnia';
    }

    if($presentGiver)
    {
        if($memberfor>=2)
        {
            $resultaat = mysqli_query($mysqli,  "SELECT username FROM votes WHERE username='$S_user' && datum='$event' LIMIT 1");
            $aantal = mysqli_num_rows($resultaat);
            if($aantal==1){
                $output.="You have already bought a skeletal horse, remember? I can only give 1 skeletal horse to each person.<BR>";
                //$output.="You already visited $presentGiver, remember?<BR>";
                //$output.="Now please move away to make room for other people who want to sit on the $presentGiver's lap.<BR>";
            }
            else
            {
                if($var1=='')
                {
                    $output.="You have not bought a skeletal horse yet.<BR>";
                    $output.="It costs 5,000gp to buy a skeletal horse. Your money will allow me to buy resources I need to summon enough skeletal horses for next year.<BR>";

                    //$output.="You can collect a free gift because of Syrnias birthday.<br />";
                    //$output.="Choose wisely.<br />";
                    if(hasGold($S_user) >= 5000)
                    {
                        $output.="<a href='' onclick=\"locationText('adoptaskeletal', 'adopt');return false;\">Pay 5,000gp to buy a skeletal horse</a><BR>";
                    }
                    else
                    {
                        $output .= "You aren't carrying enough money to buy a skeletal horse.";
                    }
                }
                else if($var1=='adopt')
                {
                    if(hasGold($S_user) >= 5000)
                    {
                        payGold($S_user, 5000);
                        addItem($S_user, "Skeletal horse", 1, "horse", '', '', 1);
                        $sql = "INSERT INTO votes (datum, username, site)
                            VALUES ('$event', '$S_user', '$S_realIP')";
                        mysqli_query($mysqli, $sql) or die("erroraa report this bug");

                        $output .= "You have bought your very own skeletal horse!";
                    }
                    else
                    {
                        $output .= "You aren't carrying enough money to buy a skeletal horse.";
                    }
                }
            }
        }
        else
        {
            $output.="Only players who are registered for a few days can buy a skeletal horse.<br />";
        }
    }
    else{
        $output.="There is no spoon!";
    }
}
else{
	$output.="Now that you are inside the walls you can see the busy city with everything from a chapel on the east side to the castle keep ";
	$output.="which has a large rose crest above the main entrance.<br/>";
}




}
}
?>