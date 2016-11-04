<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>$S_location</a><BR>";
$output.="<BR>";

include_once('includes/levels.php');

if($cookingl>=50){
   /*$sql = "SELECT II.name FROM items_inventory II
        LEFT JOIN item_types T ON T.name = II.type
        LEFT JOIN items I ON I.name = II.name
        WHERE II.username='$S_user' && II.type='food' && II.name NOT LIKE '%cooked%' ORDER BY I.rank = 0 ASC, I.rank ASC, I.name ASC";
    $resultaat = mysqli_query($mysqli, $sql);
    while ($record = mysqli_fetch_object($resultaat)) { $output.="<a href='' onclick=\"locationText('work', 'cooking','$record->name');return false;\"><font color=white>Cook $record->name</a><BR>"; }*/
    $output.= getRawsForCooking();
}

} elseif($locationshow=='LocationText'){


$output.="The village of Croy was once a mining community, but like surrounding areas, the mines have gone and most of the employment opportunities,";
$output.=" although the new town of Mt. Vertor did provide some outlet. Croy itself is predominantly Religious in origin. This was mainly due to the hard times in Kanzo, ";
$output.="especially the potato famine, which has brought this town to find open fires and cook for themselves.. ";
$output.="If you listen carefully you can hear the God of Cooking sizzling his food and hearing the manly beast chop down on his kills.";



}
}
?>