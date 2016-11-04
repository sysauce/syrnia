<?
if(defined('AZtopGame35Heyam')){



$output.="Welcome to the chapel, would you like to use a chapel service?<br/>";

	 $resultaat = mysqli_query($mysqli, "SELECT marriedTo FROM users_junk WHERE username='$S_user' LIMIT 1");
    while ($record = mysqli_fetch_object($resultaat)) { $marriedTo=$record->marriedTo; }

    $output.="<br/><a href='' onclick=\"locationText('$action', 'pray');return false;\">Pray</a><br>";

    if($marriedTo!=''){
		$output.="<a href='' onclick=\"locationText('chapel', 'divorce');return false;\">Divorce $marriedTo</a><br>";
	}else{
		$output.="<a href='' onclick=\"locationText('chapel', 'propose');return false;\">Propose to someone</a><br>";
	}
	$output.="<a href='' onclick=\"locationText('chapel', 'books');return false;\">Check the books</a> about current married couples<br>";
	$output.="<br/>";


    if($var1=='pray'){
		$output.="You pray at the chapel and feel relieved.<br/>";
	    $rand=rand(1,3);

	    if($rand==1){  $output.="You feel like someone has taken notice of your prayers..<br/>";
	     }elseif($rand==2){ $output.="This has greatly encouraged you.<br/>";
		 }else{ $output.="The prayer has given you insight in your current situation.<br/>";
		 }

	}elseif($var1=='books'){

	 $output.="There are tons of books here, with all information about marriages.<br/>";
	 $output.="What name are you looking for ?<br/>";
	 $output.="<form onsubmit=\"locationText('chapel', 'books', $('checkBooksName').value);return false;\">";
	 $output.="<input type=text id=checkBooksName><input type=submit value=check>";
	 $output.="</form><br/>";

	 if($var2){
	  $output.="<br/>";
	  $output.="<br/>";
	  $ismarried="9";
	    $resultaat = mysqli_query($mysqli, "SELECT marriedTo FROM users_junk WHERE username='$var2' LIMIT 1");
	   		 while ($record = mysqli_fetch_object($resultaat)) {
	   		    $ismarried=$record->marriedTo;
	   		  }


	   		if($ismarried==9){
				  $output.="There is no such player!<br>";
			}elseif($ismarried==''){
			 	$output.="It took you a while, but searching for that specific name in all these books you didn't find any record about him or her being currently married. Interesting.";
	        }else{
			 	$output.="It took you a while, but searching for that specific name in all these books you found out he/she is currently married to <b>$ismarried</b>. What a pity :(<br>";
			}
	  }

	}elseif($marriedTo!='' && $var1=='divorce'){

		if($var2==1){
			$output.="You have divorced.<br/>";
		 	$output.="$marriedTo has been sent a notification, you might want to send him/her a personal message too?<br />";

		 	$sql = "INSERT INTO messages (username, sendby, message, time, topic)
		  	VALUES ('$marriedTo', '<B>Syrnia</b>', 'We\'re sorry to tell you, but $S_user has divorced you.', '$timee', 'Divorce')";
			mysqli_query($mysqli, $sql) or die("error report234 this bug please33 66 msg [$sql]");
			mysqli_query($mysqli, "UPDATE users_junk SET marriedTo='' WHERE username='$S_user' LIMIT 1") or die("error --> 1113 X234");
	        mysqli_query($mysqli, "UPDATE users_junk SET marriedTo='' WHERE username='$marriedTo' LIMIT 1") or die("error --> 1113 X234");

		}else{
		 	$output.="Do you want to divorce $marriedTo ?<br/>";
			$output.="<a href='' onclick=\"locationText('chapel', 'divorce', 1);return false;\">Yes</a> -  <a href='' onclick=\"locationText('chapel');return false;\">No, nevermind</a>";
		}

	}elseif($var1=='propose'){
	 if($marriedTo!=''){$output.="You have married $marriedTo!";}else{

   		if($var3=='cancel'){
			mysqli_query($mysqli, "UPDATE users SET work='', dump='' WHERE work<>'stop' && username='$S_user' LIMIT 1") or die("error --> 1113");
		}
	   	$proposeTo=$var2;
	 	if($proposeTo && $proposeTo!=$S_user){
	 	 $resultaat = mysqli_query($mysqli, "SELECT username FROM users WHERE username='$proposeTo' && online>=1 LIMIT 1");
	   		 while ($record = mysqli_fetch_object($resultaat)) {

	   		  	$resultat = mysqli_query($mysqli, "SELECT work, dump FROM users WHERE username='$S_user'LIMIT 1");
	   		 	while ($rec = mysqli_fetch_object($resultat)) {
				  if($rec->work=='propose'){$proposed=1;
				    if($rec->dump==''){ $output.="We're sorry; your proposal has been rejected.<br/>"; $proposed="rejected";}
				    else{ $output.="Your proposal is still pending..<br/>";}
					  }
				}
			if($proposed<>1 && $proposed<>'rejected'){
				 if(payGold($S_user, 250)==1){
				  	$output.="You have paid 250 gold for this proposal.<br/>";
				 	mysqli_query($mysqli, "UPDATE users SET work='propose', dump='$proposeTo' WHERE work<>'stop' && username='$S_user' LIMIT 1") or die("error --> 1113");
				 }else{
				  	$proposed="goldproblems";
				}
			 }


				if($proposed<>'rejected' && $proposed<>'goldproblems'){
				   $output.="You are proposing to $proposeTo.<br/>";
				   $output.="Make sure he/she comes to the chapel too so he/she can answer your proposal.<br/>";
				   $output.="You are awaiting an answer..<br/>";
				   $output.="<a href='' onclick=\"locationText('chapel', 'propose', '$proposeTo');return false;\">Has he/she answered yet?</a><br/>";
				   $output.="<br>";
				   $output.="<a href='' onclick=\"locationText('chapel', 'propose', '', 'cancel');return false;\">Cancel the proposal</a><br/>";
			   }elseif($proposed=='goldproblems'){  $output.="You can not propose because you have not got enough gold.<br/>";
			    }else{
			    mysqli_query($mysqli, "UPDATE users SET work=''WHERE work<>'stop' && username='$S_user' LIMIT 1") or die("error --> 1113");
			}
		   }
		}else{
		 	$output.="Would you like to propose to someone here at the chapel ?<br />";
			$output.="Using this service will cost you 250 gold.<br/>";
		 	$output.="<form onsubmit=\"locationText('chapel', 'propose', $('proposeToName').value);return false;\">";
		 	$output.="<select id=proposeToName>";
		 	$resultaat = mysqli_query($mysqli, "SELECT username FROM users WHERE location='$S_location' && online>=1 && username!='$S_user' order by username asc");
	   		while ($record = mysqli_fetch_object($resultaat))
			{
		 		$output.="<option value=\"$record->username\">$record->username";
		 	}
			$output.="</select>";
		 	$output.="<input type=submit value='propose'>";
			 $output.="</form>";
	   }
	 }#married
	} #service propose



    if($marriedTo==''){
	    $resultaat = mysqli_query($mysqli, "SELECT username FROM users WHERE work='propose' && dump='$S_user' LIMIT 2");
	   		 while ($record = mysqli_fetch_object($resultaat)) {
	   		  	if($var1 == 'marry' && $var2==$record->username){
					$output.="You have married $record->username!<br/>";
				   	mysqli_query($mysqli, "UPDATE users_junk SET marriedTo='$S_user'WHERE username='$record->username' LIMIT 1") or die("error --> 1113");
	               	mysqli_query($mysqli, "UPDATE users_junk SET marriedTo='$record->username'WHERE username='$S_user' LIMIT 1") or die("error --> 1113");
	             	mysqli_query($mysqli, "UPDATE users SET work='', dump='' WHERE username='$record->username' && work='propose' LIMIT 1") or die("error --> 1113 X234");

				}elseif($var1 == 'decline' && $var2==$record->username){

				    $output.="You have declined the proposal of $record->username<br/>";
				    mysqli_query($mysqli, "UPDATE users SET dump='' WHERE username='$record->username' && work='propose' LIMIT 1") or die("error --> 1113");

				   }else{
	   		   		$output.="$record->username is proposing to you, do you wish to marry him/her ?<br/>";
					$output.="<a href='' onclick=\"locationText('chapel', 'marry', '$record->username');return false;\" >Yes</a> - <a href='' onclick=\"locationText('chapel', 'decline', '$record->username');return false;\">No</a>";
				}
	   		  }

	}




	}
?>