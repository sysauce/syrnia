<?
if(defined('AZtopGame35Heyam') && $S_staffRights['manualEditRights']==1){


echo"<form action='' method=post>
<select name=manual>
<option value=begin>Easy/Short Beginners manual
<option value=adv_begin>Advanced Beginners manual
<option value=combat>Combat
<option value=constructing>Constructing
<option value=cooking>Cooking
<option value=events>(random )Events
<option value=fame>Fame & Pirates
<option value=farming>Farming
<option value=fishing>Fishing
<option value=magic>Magic
<option value=mining>Mining
<option value=quests>Quests
<option value=smithing>Smithing
<option value=speed>Speed
<option value=thieving>Thieving
<option value=trading>Trading
<option value=woodcutting>Woodcutting

</select><input type=submit value=edit></form><hr>";

######## EDIT
if($manual=='begin' OR $manual=='adv_begin' OR $manual=='combat' OR $manual=='constructing' OR $manual=='cooking' OR $manual=='events' OR $manual=='fame' OR $manual=='farming' OR $manual=='fishing' OR $manual=='magic' 
OR $manual=='mining' OR $manual=='quests' OR $manual=='smithing' OR $manual=='speed' OR $manual=='thieving' OR $manual=='trading' OR $manual=='woodcutting' OR $manual=='other'){
########## EDIT

			################
	## CRAZY STUFF VAN FCEDITOR
	####################
echo"
		<link href=\"./editor/sample.css\" rel=\"stylesheet\" type=\"text/css\" />
		<script type=\"text/javascript\">

function FCKeditor_OnComplete( editorInstance )
{
	var oCombo = document.getElementById( 'cmbToolbars' ) ;
	oCombo.value = editorInstance.ToolbarSet.Name ;
	oCombo.style.visibility = '' ;
}

function ChangeToolbar( toolbarName )
{
	window.location.href = window.location.pathname + \"?Toolbar=\" + toolbarName ;
}

		</script>";
		#####




if($inhoudMANUAL){
	$file = "../../mainincludes/manual/$manual.php";    
	if (!$file_handle = fopen($file,"w")) { echo "Cannot open file 1 "; }   
	if (!fwrite($file_handle, $inhoudMANUAL)) { echo "Cannot write to file2"; }   
	fclose($file_handle);  
	echo"<B>Edited $manual page ! </b><BR>";  
}




echo"Edit manual: $manual:<BR><BR>";


$file = "../../mainincludes/manual/$manual.php";    
if (!$file_handle = fopen($file,"r")) { echo "Cannot open file.3"; }   
if (!$file_contents = fread($file_handle, filesize($file))) { echo "Cannot retrieve file contents.4"; } 


include("editor/fckeditor.php") ;
					
					echo"
		<form action=\"\" method=\"post\" target=\"\">
		<input type=hidden name=page value=$page>
		<input type=hidden name=manual value=$manual>
		";



$oFCKeditor = new FCKeditor('FCKeditor1') ;
$oFCKeditor->BasePath = './editor/' ;

if ( isset($_GET['Toolbar']) )
	$oFCKeditor->ToolbarSet = htmlspecialchars($_GET['Toolbar']);

$oFCKeditor->Value = $file_contents;
$oFCKeditor->Create() ;

echo"	<br>
			<input type=submit value=Edit>
		</form>";
		
		



		
		
		
} ## EDIT



}
?>