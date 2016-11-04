<?
if(defined('AZtopGame35Heyam')){
### JAIL
$time=time();

$bailDiscount = false;
$halloween = isHalloween();
$xmas = isXmas();
$easter = isEaster();

$output.="In the jail you will get locked up for your crimes...I've got no reason to hang around here much longer!<br />";
$output.="<br />";

if(($halloween || $xmas || $easter))
{
    $output .= "Because it's ";
    $eventNPC = "";
    if($halloween)
    {
        $output .= "Halloween";
        $eventNPC = " Halloween witch";
    }
    else if($xmas)
    {
        $output .= "Christmas";
        $eventNPC = " Jack Frost";
    }
    else if($easter)
    {
        $output .= "Easter";
        $eventNPC = " Easter Bunny";
    }

    $output .= ", you get a 20% discount when bailing a player who has thieved" . ($xmas ? "" : " the") . "$eventNPC!<br/><br/>";
    $resultaeat = mysqli_query($mysqli, "SELECT location FROM users WHERE username='$eventNPC' LIMIT 1");
    while ($record = mysqli_fetch_object($resultaeat))
    {
        $currentLocation = $record->location;
    }

    if($currentLocation)
    {
        $resultaeat = mysqli_query($mysqli, "SELECT mapNumber FROM locationinfo WHERE locationName = '$currentLocation' LIMIT 1");
        while ($record = mysqli_fetch_object($resultaeat))
        {
            $currentIslandID=$record->mapNumber;
        }

        if($currentIslandID == $S_mapNumber)
        {
            $bailDiscount = true;
        }
    }
}

if($var1=='pay' && is_numeric($var2))
{
    $sql = "SELECT ID, username, dump, dump2,worktime FROM users WHERE ID='$var2' && work='jail' && location='$S_location' && worktime>$time LIMIT 1";
    $resultaat = mysqli_query($mysqli,$sql);
    while ($record = mysqli_fetch_object($resultaat))
    {
        $left=$record->worktime-$time;

        if(stristr($record->dump2, "Thieving the shop of ") === false)
        {
            $fee=ceil($left*1);
        }
        else
        {
            $fee=$left*1;
        }

        if($bailDiscount && $eventNPC && stristr($record->dump2, "Thieving $eventNPC at "))
        {
            $fee = ceil($fee*0.8);
        }
        if(payGold($S_user, $fee)==1)
        {
            mysqli_query($mysqli,"UPDATE users SET work='', worktime='', dump='', dump2='' WHERE ID='$var2' LIMIT 1") or die("error --> 22223");
            $output.="<B>You have paid $fee gold to free $record->username.</B><BR><BR>";
            $sql = "INSERT INTO messages (username, sendby, message, time, topic)
                VALUES ('$record->username', '<B>Syrnia</b>', '$S_user has paid $fee gold to free you from the $S_location jail.', '$timee', 'Jail')";
            mysqli_query($mysqli,$sql) or die("error report this bug please33 66 msg  $sendto', '$S_user', '$tekst', '$time', '$topic'");
        }
        else
        {
            $output.="<B>You need $fee gold to free $record->username but you haven't got enough.</b><BR><BR>";
        }
    }
}

$output.="<b>Thieves locked up:</b><br /><table>";

$left='';
$sql = "SELECT ID, username, dump, dump2,worktime FROM users WHERE work='jail' && location='$S_location' && worktime>'$time' && dump2<>'Misbehaviour'";
$resultaat = mysqli_query($mysqli,$sql);
while ($record = mysqli_fetch_object($resultaat))
{
    $left=$record->worktime-$time;

    if(stristr($record->dump2, "Thieving the shop of ") === false)
    {
        $fee=ceil($left*1);
    }
    else
    {
        $fee=$left*1;
    }

    if($bailDiscount && $eventNPC && stristr($record->dump2, "Thieving $eventNPC at "))
    {
        $fee = ceil($fee*0.8);
    }
    $output.="<tr><td>$record->username<td>Reason: $record->dump2<td>".(ceil($left/60))." minutes left." .
        "<td>" .
        "<a href='' onclick=\"locationText('$action', 'pay', '$record->ID');return false;\">Pay $fee gold bribe</a>"  .
        "</td></tr>";
}

if($left=='')
{
 	$output.="There are no thieves locked up at the moment.";
}

$output.="</table>";

}
?>