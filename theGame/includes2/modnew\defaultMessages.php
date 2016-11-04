<?

$S_user=''; $S_staffRights=''; $S_MODLOGIN='';

 
require_once("../../includes/db.inc.php");
include_once('../../../currentRunningVersion.php');

if (mysqli_connect_errno())
{
    exit();
}
 
  session_start();    
  $timee=time(); $time=time();
define('AZtopGame35Heyam', true ); 
$datum = date("d-m-Y H:i");



if($S_user && is_array($S_staffRights)){ ## USER EN MODD

if($S_MODLOGIN){


echo"
<html>
<HEAD><TITLE>Syrnia</TITLE>
<style type=\"text/css\">
      TABLE{
      font-size:13px;
      word-spacing:0.4px;
       font-family: verdana ;
      }
      body {
      font-family: verdana ;
        word-spacing:0.4px;
      font-size:13px;
      }
    </style>   
   	<script src=\"".GAMEURL."scriptaculous-js-1.8.3/lib/prototype.js\" type=\"text/javascript\"></script>
	<script src=\"".GAMEURL."scriptaculous-js-1.8.3/src/scriptaculous.js\" type=\"text/javascript\"></script>
</HEAD><body topmargin=0 leftmargin=0 rightmargin=0 bottommargin=0 link=red alink=red vlink=red bgcolor=black>";

echo"<script type=\"text/javascript\">
function useMessage(textName){
	var tekst=$(textName).innerHTML;
	if (window.opener && !window.opener.closed){
	 if(window.opener.document.getElementById('pReason').disabled){
		window.opener.document.getElementById('pReason').disabled=false;
		window.opener.document.getElementById('messageReason').checked=true;		
	}
	 window.opener.document.getElementById('pReason').value = $(textName).value;
	 window.close();
	 }
}

</script>";


//echo"<table>";
$i=0;
//topic hardcoded in mod forum too!
$sql = "SELECT message FROM forummessages WHERE topic='88659' ORDER BY ID ASC";
$resultaat = mysqli_query($mysqli, $sql);
while ($record = mysqli_fetch_object($resultaat))
{
 	$i++;
	$message=stripslashes($record->message);
	$message=str_replace('<br />', '',$message);
	//if(strpos($message  , '<small>' )){
	//	$message=strstr($message, "swear", true);		
	//}
	
	echo"<a href='' onclick='useMessage(\"messageNR$i\");return false;'>Use the message below</a><br/>
	<textarea rows=6 cols=42 id='messageNR$i'>$message</textarea><br />";
}
//echo"</table>";


}


}## USER EN MOD

?>