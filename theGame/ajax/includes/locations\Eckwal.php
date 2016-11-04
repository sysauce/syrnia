<?
if(defined('AZtopGame35Heyam')){
if($locationshow=='LocationMenu'){

$output.="<center><B>City Menu</B><BR>";
$output.="<BR>";
$output.="<a href='' onclick=\"locationText('');return false;\"><font color=white>$S_location</a><BR><br/>";
$output.="<a href='' onclick=\"locationText('work', 'mining', 'Iron ore');return false;\"><font color=white>Mine Iron ore</a><BR>";
$output.="<a href='' onclick=\"locationText('work', 'mining', 'Coal');return false;\"><font color=white>Mine Coal</a><BR><BR>";

} elseif($locationshow=='LocationText'){


$output.="You can mine here but there is a big bird who is afraid you will hurt his eggs, you will know when you are to close to them...";


}
}
?>