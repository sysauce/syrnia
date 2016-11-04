<?
if(defined('AZtopGame35Heyam')){

if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<a href='' onclick=\"fighting('$S_location');return false;\"><font color=white>Fight giants</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){

$output.="The elves have settled on a very good island, this place seems perfect...except for the giants.<BR>";
$output.="The giants live in the caves of Exella mountain, the elves have a hard battle in keeping the giants under control.<BR>";

	$questID=7;
   $resultaaat = mysqli_query($mysqli,  "SELECT username FROM quests JOIN questslist ON quests.questID=questslist.questID WHERE quests.questID='$questID' && completed=0 && location='$S_location' && username='$S_user' LIMIT 1");
   $aantal = mysqli_num_rows($resultaaat);
	if($aantal==1){
	 	$output.="You can see the cave which the man at the pub told you about.<BR>";
		$output.="Do you want to fight the Canlo giant..if it's there? <a href='' onclick=\"fighting('Canlo giant');return false;\">Fight it</a>";
	}


}
}
?>