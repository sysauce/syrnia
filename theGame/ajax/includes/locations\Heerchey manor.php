<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<BR>";

} elseif($locationshow=='LocationText'){


$output.="<B>Heerchey manor guard:</B> \"This is where the Heerchey family lives, but they travel a lot and that's why they are rarely here. If you want to talk to them, you better leave.\"<BR><br/>";


$questID=8;
if(stristr($_SESSION['S_questscompleted'], "[$questID]")===false && ( stristr($_SESSION['S_quests'], "$questID(1)]")<>'' OR stristr($_SESSION['S_quests'], "$questID(2)]")<>''   OR stristr($_SESSION['S_quests'], "$questID(4)]")<>''  )){
	include('textincludes/quests.php');
}
else
{
	$questID=26;
	if(stristr($_SESSION['S_questscompleted'], "[$questID]")==false && (stristr($_SESSION['S_quests'], "$questID(4)]") OR stristr($_SESSION['S_quests'], "$questID(5)]")     )){
		$output.="<BR><BR>";
		include('textincludes/quests.php');
	}
	
	if(date("Y-m-d H:i:s") > '2012-11-02 12:10:00')
	{
		include('textincludes/groupQuests.php');
	}
	
}






}
}
?>