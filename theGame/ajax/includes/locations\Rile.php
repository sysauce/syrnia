<?
if(defined('AZtopGame35Heyam')){
 
if($locationshow=='LocationMenu'){

	$output.="<center><B>City Menu</B><BR>";
	$output.="<BR>";
	$output.="<a href='' onclick=\"locationText();return false;\"><font color=white>Rile</a><BR>";
	$output.="<a href='' onclick=\"locationText('school');return false;\"><font color=white>School</a><BR>";
	$output.="<a href='' onclick=\"locationText('friddik');return false;\"><font color=white>Visit George Friddik</a><BR>";
	$output.="<BR>";

}else if($locationshow=='LocationText'){

	if($action=='school'){
		$output.="<B>Welcome to the school.<BR><BR>"; 
		
		if($constructingl<10){ $output.="<a href='' onclick=\"locationText('work', 'school', 'constructing');return false;\">Learn about constructing</a><BR>"; } else { $output.="You can't learn any more about constructing in here, try Unera instead.<BR>"; }
		if($tradingl<10){
		  	$output.="<a href='' onclick=\"locationText('work', 'school', 'trading');return false;\">Learn about trading</a><BR>"; 
		  } else { 
		   	$output.="You can't learn any more about trading in here, try Unera instead.<BR>"; 
		  }
	
	}elseif($action=='friddik'){
	
		include('textincludes/friddik.php');
	
	} else {
	$output.="Welcome to Rile,<BR><BR>";
	$output.="The town where you can visit the school, and learn about many things!<br>";
	$output.="Right now you can learn the Construction skill, and the Trading skill..<br>";
	$output.="This will cost you some gold.. but that's ok right?";
	}

}
}
?>