<?
if(defined('AZtopGame35Heyam')){


$output="";

$output.="<CENTER><h3>Email Confirmation</h3></center>";

if($username && $code){
 $sql = "SELECT password FROM users WHERE username='$username' && password LIKE '%]_[%' LIMIT 1";
  $resultaat = mysqli_query($mysqli,$sql);
   $aantalip = mysqli_num_rows($resultaat);
if($aantalip>0){


$resultaat = mysqli_query($mysqli,"SELECT password FROM users WHERE username='$username' LIMIT 1");
    while ($record = mysqli_fetch_object($resultaat)) { $password=$record->password;}

    $code2 = substr ("$password", 0, 4);
    if($code==$code2){

				 $pass = substr ("$password", 4, 3);
				 $password = substr ("$password", 7);
				 if($pass==']_['){


				mysqli_query($mysqli,"UPDATE users SET password='$password' WHERE username='$username' LIMIT 1") or die("error --> 1");


				include_once("mainfunctions.php");
                $result = LoginUser($username);
                if(!$result){
                    echo "<strong>Unknown login error!</strong>";
                }



				          $output.="You have activated your account, welcome to <b>Syrnia</b>!<BR>
				We hope you will have a lot of fun playing, we are all doing our best to make this game fun.<BR>
				<a href=game.php>Start playing!</a>";

$output.="<script type=\"text/javascript\">
<!--
window.location = \"game.php\"
//-->
</script>";


				}else{
					$output.="You have already activated your account.<BR>
					Want to see the F.A.Q. or contact the support ? <A href=index.php?page=faq>Click here</a>.<BR><br>";
				}

		}else{
				$output.="Your activation code was incorrect!<RB>
				Want to see the F.A.Q. or contact the support ? <A href=index.php?page=faq>Click here</a>.<BR><br>";
		}


}else{
	$output.="There is no user with that e-mail address, <u>please confirm you have copied the link correct</u>.<BR>
	You have probably already activated, please try logging in. If that doesn't work request a <a href=?page=lostpw>\"LOST PASSWORD\"</a>, you'll be able toplay Syrnia immidiatelly using the info in the LOST PW email you'll recieve.<Br/>
	Want to see the F.A.Q. or contact the support ? <A href=index.php?page=faq>Click here</a>.<BR><br>";
}




}else{

	$output.="The activation link you used is not correct. <u>Make sure you've copied the full link from the activation e-mail</u> to this window.<br/>
	Want to see the F.A.Q. or contact the support ? <A href=index.php?page=faq>Click here</a>.<BR><BR>";

}


$inhoud= MakeParchment("$output", "top", "left", 764-18*2, 245);
echo MakeWoodContainer($inhoud, 764, 270);


}
?>