<?
if(defined('AZtopGame35Heyam') && $SENIOR_OR_SUPERVISOR==1){

	if(!is_numeric($start)){
	 	$start=0;
	}

echo"<b>Mod log</b><br/>
Messages $start - ".($start+250)." <br/>
<a href=?page=$page&start=".($start-250).">Previous 250 actions</a> -<a href=?page=$page&start=".($start+250).">Next 250 actions</a><br/>
<br/>";

echo" <table border=1>
<tr><td>ID<td>Time<td>Player<td>action<td>How long<td>Mod<td>description";

	$sqal = "SELECT ID, username, action, reason, timer, time, moderator FROM zmods" .
      ($S_user != 'M2H' && $S_user != 'Hazgod' && $S_user != 'SYRAID' && $S_user != 'Redhood' ? " WHERE action != 'Cheat log'" : "") . " ORDER BY ID Desc LIMIT $start, 250";
   $resultaaaat = mysqli_query($mysqli, $sqal);
    while ($record = mysqli_fetch_object($resultaaaat)) {
    echo" <Tr><td>$record->ID<td>".date("d-m-Y H:i", $record->time)."<td>$record->username<td>$record->action<td>";
	if($record->timer>0){
	 $seconds=$record->timer;
    if($seconds>3600*24){ $left=(round($seconds/(3600*24)*100)/100)." days ";
    }elseif($seconds>3600){ $left=(round($seconds/(3600)*100)/100). " hours ";
    }else{ $left=ceil(($seconds)/60)." minutes"; }
    echo $left;
	 }
	echo"<td>$record->moderator<td>$record->reason";
     }
echo"</table>";
echo"<a href=?page=$page&start=".($start-250).">Previous 250 actions</a> -<a href=?page=$page&start=".($start+250).">Next 250 actions</a>";

}
?>