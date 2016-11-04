<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText('');return false;\"><font color=white>Avinin</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'woodcutting');return false;\"><font color=white>Woodcut</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

	$output.="Welcome to Avinin. Here you find that you can chop wood in the forest! The lady who kept the forest loved birds. ";
	$output.="Don't be surprised when you see them flying everywhere. There was one bird who loved the lady so much he wished his feet ";
	$output.="away so he could stay close to her. Watch for him, his name is Wadjet!";

}
}
?>