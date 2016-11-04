<?
if(defined('AZtopGame35Heyam') && $S_MODLOGIN==1 && $SENIOR_OR_SUPERVISOR==1){


echo"All lovely active users the last 15 minutes ordered by username:<br /><center>";

echo"<table>"; $nr=0;
   $sql = "SELECT username FROM users WHERE online=1 ORDER BY username asc"; 
   $resultaat = mysqli_query($mysqli, $sql);     
    while ($record = mysqli_fetch_object($resultaat)) { 
$tag='';
   $saql = "SELECT tag FROM clans WHERE username='$record->username' LIMIT 1"; 
   $resultat = mysqli_query($mysqli, $saql);     
    while ($rec = mysqli_fetch_object($resultat)) { $tag=$rec->tag; }

echo"<tr><td>$record->username <td> <i>$tag</i></td></tr>";
$nr=$nr+1;
}
echo"</table><br />$nr players are online at the moment.</center>";


}
?>
