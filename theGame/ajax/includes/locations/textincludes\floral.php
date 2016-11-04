<?
if(defined('AZtopGame35Heyam')){
$shopname='';


if($S_location=='Harith'){
	$shopname="Remers House of Floral"; $id_side=2; #Elven Gate
}elseif($S_location=='Elven gate'){
	$id_side=2; #Elven Gate
	$shopname='The Elven Floral Boutique';
}elseif($S_location=='Khaya'){
	$id_side=2; #Elven Gate
	$shopname='Anascos House of Floral';
}

if($shopname){

if($var1=='sell'){
	$addprod=round($var2);
	$prodid=$var3;
}

################################
############################### ADD
if($addprod>0 && $prodid && is_numeric($addprod)){### ADD
$saql = "SELECT name, score FROM sidesstock WHERE ID='$prodid' && sideid='$id_side' LIMIT 1";
    $resultaaat = mysqli_query($mysqli,$saql);
     while ($record = mysqli_fetch_object($resultaaat)) { $name=$record->name;  $score=$record->score;}

$saql = "SELECT ID, much FROM items_inventory WHERE name='$name' && username='$S_user' && itemupgrade='' LIMIT 1";
    $resultaaat = mysqli_query($mysqli,$saql);
     while ($record = mysqli_fetch_object($resultaaat)) {$inventoryID=$record->ID; $much=$record->much;}
if($addprod>$much){$addprod=$much; }

if($addprod>0 && $much){$goldm=$addprod*$score;
getGold($S_user, $goldm);
removeItem($S_user, $name, $addprod, '', '', 1);

mysqli_query($mysqli,"UPDATE sidesstock SET much=much+'$addprod' WHERE name='$name' && sideid='$id_side' LIMIT 1") or die("e33333333rr22or --> 1 $much--$get aaa");
$output.="You got $goldm gold for your $addprod $name.<BR>";

}########################EINDE ADD
}elseif($var1=='buy' && is_numeric($var2) && $var2>0){

      $sql = "SELECT gold from users where username='$S_user' LIMIT 1";
      $resultaat = mysqli_query($mysqli,$sql);
      while ($record = mysqli_fetch_object($resultaat)) {$gold=$record->gold;}

    $saql = "SELECT ID,name, much, score, type,worklink FROM sidesstock WHERE sideid='$id_side' && ID='$var2' LIMIT 1";
    $resultaaat = mysqli_query($mysqli,$saql);
     while ($record = mysqli_fetch_object($resultaaat)) {
     if($record->much>=10){
         if($gold>=($record->score*10)){
	         $price=$record->score*10;

	         $towho=$var3;
	         $messa=$var4;
			 if($towho && $messa){
	         	   $saaql = "SELECT username FROM users WHERE username='$towho' LIMIT 1";
    $resultaaaat = mysqli_query($mysqli,$saaql);
     while ($rec = mysqli_fetch_object($resultaaaat)) {
	     $send=1;
         if($record->name == 'Christmas cactus')
         {
            $BO="Bouquette of Christmas cacti";
         }
         else if($record->name == 'Canna lucifer')
         {
            $BO="Bouquette of Canna lucifer";
         }
         else
         {
            $BO="Bouquette of ".$record->name."s";
         }
	              mysqli_query($mysqli,"UPDATE sidesstock SET much=much-'10' WHERE name='$record->name' && sideid='$id_side' LIMIT 1") or die("err1or --> 1232231");
	             payGold($S_user, $price);

	             addItem($rec->username, $BO, 1, 'bouquette', '', '', 0);


        if($record->worklink=='Wedding'){
				$layout1='<table width=450><tr valign=top><td background=../../layout/weddingbg.jpg><font color=black>';
				$layout2='</table>';
        }elseif($record->worklink=='Love'){
				$layout1='<table width=450><tr valign=top><td background=../../layout/lovebg.jpg><font color=white>';
				$layout2='</table>';
	   }elseif($record->worklink=='Thanks'){
				$layout1='<table width=450><tr valign=top><td background=../../layout/thanksbg.jpg><font color=black>';
				$layout2='</table>';
		   }elseif($record->worklink=='Birthday'){
				$layout1='<table width=450><tr valign=top><td background=../../layout/birthdaybg.jpg><font color=black>';
				$layout2='</table>';
		     }elseif($record->worklink=='Congratulations'){
				$layout1='<table width=450><tr valign=top><td background=../../layout/congratulationsbg.jpg><font color=black>';
				$layout2='</table>';
		   }elseif($record->worklink=='Get well'){
				$layout1='<table width=450><tr valign=top><td background=../../layout/getwellbg.jpg><font color=black>';
				$layout2='</table>';
		   }elseif($record->worklink=='Friendship'){
				$layout1='<table width=450><tr valign=top><td background=../../layout/friendship.jpg><font color=black>';
				$layout2='</table>';
		   }elseif($record->worklink=='Appologies'){
				$layout1='<table width=450><tr valign=top><td background=../../layout/appologies.jpg><font color=black>';
				$layout2='</table>';
		   }elseif($record->worklink=='Condolence'){
				$layout1='<table width=450><tr valign=top><td background=../../layout/condolence.jpg><font color=white>';
				$layout2='</table>';
			}elseif($record->worklink=='Threat'){
				$layout1='<table width=450><tr valign=top><td background=../../layout/threat.jpg><font color=white>';
				$layout2='</table>';
			}elseif($record->worklink=='Best wishes'){
				$layout1='<table width=450><tr valign=top><td background=../../layout/bestwishes.jpg><font color=black><b>';
				$layout2='</b></font></td></tr></table>';
		   }elseif($record->worklink=='Good luck'){
				$layout1='<table width=450><tr valign=top><td background=../../layout/goodluckbg.jpg><font color=black><b>';
				$layout2='</b></font></td></tr></table>';
		   }

        $messa = htmlentities(trim($messa)); $messa = nl2br($messa);
        $tekst="$layout1 <i>An employee of $shopname delivered you a $BO.<BR>
        It was sent by $S_user. The bouquette had a message attached:</i><BR><BR>
        $messa <BR>
        <BR>$layout2";
$datum = date("d-m-Y H:i"); $timee=time();
$sql = "INSERT INTO messages (username, sendby, message, datum, topic, time)
  VALUES ('$towho', '<B>Syrnia</B>', '$tekst', '$datum', '$shopname', '$timee')";
mysqli_query($mysqli,$sql) or die("error report this bug please  ('$towho', '<B>Syrnia</B>', '$tekst', '$datum', '$shopname', '$timee') ");



        $output.="Your $BO has been successfully delivered to $towho!<BR>";
        $output.="Thanks for buying at $shopname!<BR>";
	         }
         }
	         if($send<>1){
                 if($record->name == 'Christmas cactus')
                 {
                    $BO="Bouquette of Christmas cacti";
                 }
                 else
                 {
                    $BO="Bouquette of ".$record->name."s";
                 }
		             $output.="<img src=\"../../images/inventory/$BO.gif\" border=1> Buying a $record->name bouquette for $price gold.<BR>";
    $output.="For occasion: $record->worklink.<BR>";
    if($towho){ if($messa) { $output.="<Font color=red>There is no such username!</font><BR>"; } else { $output.="<Font color=red>You must enter a message!</font><BR>"; } }
    $output.="<form onsubmit=\"locationText('floral', 'buy', '$var2', $('flowerTo').value, $('flowerMessage').value);return false;\" value='Deliver my bouquette'><table>";
    $output.="<tr><td>To: <td>   <input type=text id='flowerTo' value='$towho'>";
    $output.="<tr valign=top><td>Message: <Td><textarea id='flowerMessage' rows=10 cols=25>$messa</textarea>";
    $output.="<tr><td><Td><input type=submit value='Send bouquette'></table></form>";
    }
    }else{ $output.="<b>You do not have enough money!</b><br />"; }
     } else{ $output.="<b>There are not enough $record->name available (any more)!</b><br />";}
     }
 }
####EINDE BUY
############# OVERVIEW
$output.="<Table width=98% bgcolor='' border=0>";
$output.="<tr bgcolor=333333><tr><td><td><B>Flowers</B><Td><B>Sell flower<td><B>Current<td><B>Bouquettes<td><B>Occasion";
$saql = "SELECT ID,name, much, score, type,worklink FROM sidesstock WHERE sideid='$id_side' order by name asc";
    $resultaaat = mysqli_query($mysqli,$saql);
     while ($record = mysqli_fetch_object($resultaaat))
	 {
         if($record->name == 'Christmas cactus')
         {
            $BO="Bouquette of Christmas cacti";
         }
         else
         {
            $BO="Bouquette of ".$record->name."s";
         }
	$output.="<tr><td width=45><img src=\"images/inventory/$record->name.gif\" border=1><Td>$record->name<td>";
	$output.="<form onsubmit=\"locationText('floral', 'sell', $('addFlower$record->ID').value,'$record->ID');return false;\"><input type=text size=1 id='addFlower$record->ID' class=input><input type=submit value='Sell (".($record->score)." gp)' class=button></form>";
	$output.="<td width=20><center>$record->much<td>".(floor($record->much/10))." <a href='' onclick=\"locationText('floral', 'buy', '$record->ID');return false;\">$BO</a> (".($record->score*10)."gp)<td>$record->worklink";
	}
$output.="</table>";
";</center>";
#################

}}?>