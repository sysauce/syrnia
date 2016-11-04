<?php

//if (!defined('GAMEPATH')) {
//    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/?hackattempt");
//	die;
//}

/*echo "The game will BRB. We need to recover some missing inventories and users.<br />
<a href=http://www.facebook.com/OfficialSyrniaPage>http://www.facebook.com/OfficialSyrniaPage</a>";
exit();
*/

global $mysqli;

if($_SERVER['HTTP_HOST'] == "dev2.syrnia.com" OR $_SERVER['HTTP_HOST'] == "www.beta.syrnia.com")
{
	$mysqli = new mysqli("localhost",  "syrniaBetaDBUser", "34nHkdm394Hds", "syrniaBeta");

}else{
	$mysqli = new mysqli("localhost",  "syrniaDBuser", "", "rpg");

}

date_default_timezone_set('Europe/Amsterdam');

//Open P Island
global $PARTYISLAND;
$PARTYISLAND='';

if( (date("d-m-Y")=="24-12-2009" && date(H)>=18 ) || date("d-m-Y")=="25-12-2009" || date("d-m-Y")=="26-12-2009"){
 	$PARTYISLAND='open';
}
if($S_user=='M2H' || $S_user=='edwin' && date("Y")==2008 ){

	$PARTYISLAND='open';
}





?>
