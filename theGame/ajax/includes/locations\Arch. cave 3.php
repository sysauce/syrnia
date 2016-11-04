<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){



$output.="You cannot see anything in here, there's total darkness. Will you ever be able to find your way back?<BR>";

if($S_location=='Arch. cave 3.25'){
	$output.="Below you, you feel a lot of heat and see a very bright red glow...<BR>";
	$output.="<A href='' onclick=\"updateCenterContents('move', 'Arch. cave 4.1');return false;\">Move down to the heat</a>";
}


if($S_location=='Arch. cave 3.1'){
	$output.="Above you, you see a lot of light...<BR>";
	$output.="<A href='' onclick=\"updateCenterContents('move', 'Arch. cave 2.20');return false;\">Move up to the light</a>";
}




}
}
?>