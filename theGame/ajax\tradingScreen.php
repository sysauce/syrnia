<?
header("Cache-Control: no-cache, must-revalidate"); 
session_start(); 
$timee=$time=time();
define('AZtopGame35Heyam', true ); 
if(!$S_user){
	echo"alert('Not logged in! [tS]')";
  	exit();
}
// Require generic functions.
require_once("../includes/db.inc.php");

if (mysqli_connect_errno())
{
    exit();
}
/////////////////////////////////////////



  	$sql = "SELECT trade, action2, accept1,accept2 FROM tradingpost WHERE username='$S_user' LIMIT 1"; 
   	$resultaat = mysqli_query($mysqli,$sql);     
    while ($record = mysqli_fetch_object($resultaat))
	{
		$trade=$record->trade;
		$action2=$record->action2;
		$accept1=$record->accept1;
		$accept2=$record->accept2;
	}

	if($stage=='Trading 1/4' OR $stage=='Trading%201%2F4'){//Must be at trading step with display

		$sql = "SELECT action FROM tradingpost WHERE action2='$S_user' LIMIT 1"; 
	   	$resultaat = mysqli_query($mysqli,$sql);     
	    while ($record = mysqli_fetch_object($resultaat))
		{
			if($record->action=='trading' OR $record->action=='request'){
				echo"locationText('tradingpost');";
				exit(); //Moves to stage 2 as another user has accepted OR user trades
			}else{
				echo"//$record->action";
			}		 
		} 	
	}else if($stage=='Trading 2/4'){

		//We only need to FULLY-refresh when other user accepted
		$sql = "SELECT accept1, accept2 FROM tradingpost WHERE username='$action2'  && location='$S_location' && trade='$trade' && action2='$S_user' && action='trading' LIMIT 1"; 
	   	$resultaat = mysqli_query($mysqli,$sql);     
	    while ($record = mysqli_fetch_object($resultaat))
		{
		 $thereIsAnotherTrader=1;
		 $accept12=$record->accept1; 
		 $accept22=$record->accept2;
		}
		
		if(!$thereIsAnotherTrader){
			echo"locationText('tradingpost');";
			exit();//Other trader left
		}
		if($accept12==1){
			echo"locationText('tradingpost');";
			exit();//Other trader accepted trade
		}
		
		if($accept1==1){
		 	exit(); // Current user has accepted..no need to update item list 			
		}
		$contents='<table>';
	  	$sql = "SELECT ID, name, much, itemupgrade, upgrademuch FROM tradingpostitems WHERE trade='$trade' && username='$S_user' order by name asc"; 
	   	$resultaat = mysqli_query($mysqli,$sql);     
	    while ($record = mysqli_fetch_object($resultaat))
		{ 
			$i++;
			$id = $record->ID;
			$upg=''; if($record->itemupgrade){ $upg="[$record->upgrademuch $record->itemupgrade]";}
			$contents.="<tr><td><a href=\\\"\\\" onclick=\\\"locationText('tradingpost', 'removeItems', $id, $('removeMuchTradeItems').value);return false;\\\"><img src=\\\"images/inventory/$record->name.gif\\\"></a></td><td>$record->name $upg<br />$record->much</td></tr>";
		}
		$contents.='</table>';
		echo"$('myTradeItems').innerHTML=\"$contents\";";
		
	
		$contents='<table>';
	  	$sql = "SELECT ID, name, much, itemupgrade, upgrademuch FROM tradingpostitems WHERE trade='$trade' && username='$action2' order by name asc"; 
	   $resultaat = mysqli_query($mysqli,$sql);     
	    while ($record = mysqli_fetch_object($resultaat))
		{ 
		 $j++;
			$upg=''; if($record->itemupgrade){ $upg="[$record->upgrademuch $record->itemupgrade]";}
			$contents.="<tr><td><img src=\\\"images/inventory/$record->name.gif\\\"></td><td>$record->name $upg<br />$record->much</td></tr>";
		}
		$contents.='</table>';
		echo"$('hisherTradeItems').innerHTML=\"$contents\";";
	
	//	if($i>$j){ $j=$i;}
	//	$height=300+$j*45;
	//	echo"$('LocationContent').height=$height;\"";
		
	}else if($stage=='Trading 3/4'){
	
		//We only need to FULLY-refresh when other user accepted OR wants to change
		$sql = "SELECT accept1, accept2 FROM tradingpost WHERE username='$action2'  && location='$S_location' && trade='$trade' && action2='$S_user' && action='trading' LIMIT 1"; 
	   	$resultaat = mysqli_query($mysqli,$sql);     
	    while ($record = mysqli_fetch_object($resultaat))
		{
		 $thereIsAnotherTrader=1;
		 $accept12=$record->accept1; 
		 $accept22=$record->accept2;
		}
		
		if($accept22==1 && $accept2==1){
			echo"locationText('tradingpost');";
			exit();//Other trader accepted the confirmation trade
		}
		if($accept1!=1 || $accept12!=1){
			echo"locationText('tradingpost');";
			exit();//Other trader wants to change trade
		}
		
 	}else{

	}



?>






