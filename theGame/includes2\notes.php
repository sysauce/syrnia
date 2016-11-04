<?
$S_user=''; $S_donation=''; $modforum=''; $modmulti='';
//GAMEURL, SERVERURL etc.
require_once("../../currentRunningVersion.php");
include_once(GAMEPATH."includes/db.inc.php");

  session_start();



$S_username=$S_user;

if($S_username && $S_donation>=3250){


$lees=htmlentities(trim($_GET['lees']));
$delete=htmlentities(trim($_GET['del']));
$edit=htmlentities(trim($_GET['edit']));
$note=htmlentities(trim($_GET['note']));

$delall=$_POST['DELALL'];

   $resultaaat = mysqli_query($mysqli, "SELECT ID FROM notes WHERE user='$S_username'");
   $aantalnotes = mysqli_num_rows($resultaaat);

   if($delete){$aantalnotes=($aantalnotes-1);}
      if($delall){$aantalnotes='0';}

      $LENG=1500;
if($S_donation >= '4750'){$limit=40;}
elseif($S_donation >= '4250'){$limit=30;}
elseif($S_donation >= '3750'){$limit=20;}
elseif($S_donation >= '3250'){$limit=10;}
?>


<html><head><title>Notes</title>
<style>
 TABLE{
 font-size:13px;
 word-spacing:0.4px;
 }
</style>

 <script type="text/javascript"><!--
 var limit = <?php echo$LENG; ?>;
 function check() {
   if(document.f.box.value.length > limit) {
     alert('Too much data!');
     document.f.box.focus();
     return false; }
   else
     return true; }
 function update() {
   var old = document.f.counter.value;
   document.f.counter.value=document.f.box.value.length;
   if(document.f.counter.value > limit && old <= limit) {
     alert('Too much data in the text box!');
     if(document.styleSheets) {
       document.f.counter.style.fontWeight = 'bold';
       document.f.counter.style.color = '#ff0000'; } }
   else if(document.f.counter.value <= limit && old > limit
	   && document.styleSheets ) {
       document.f.counter.style.fontWeight = 'normal';
       document.f.counter.style.color = '#000000'; }
   }
 //--></script>



</head><body topmargin=0 link=ffffff alink=cfcfcf vlink=cccccc text=#ffffff bgcolor=444444 background=../../layout/bgstonedark.gif>
<center>



<h1>Notes</h1><HR><BR>
<?php if($aantalnotes<$limit){echo"<a href='notes.php?note=1'><B>Make new note</B></a><BR>";} ?>


<BR><table border=1 width=300 bgcolor=333333>
<?php echo"<TR><TD><center><B>$aantalnotes / $limit Notes</B></TD></TR>"; ?>
<?php if($aantalnotes >= $limit){echo"<TR><TD><center><B><font color=red>Your Journal is FULL!</font><BR>Delete some notes or reach a higher donation status.</TD></TR>";}?>
</TABLE>

<?php if($lees){

echo"<BR>
<TABLE border=1><TR><TD>
<TABLE width=400 border=0 cellpadding=0 cellspacing=0 bgcolor=666666>";

$sql = "SELECT subject, date, note,ID FROM notes WHERE user = '$S_username' && ID = '$lees' LIMIT 1";
        $resultaat = mysqli_query($mysqli,$sql) or die(mysqli_error());
while ($data = mysqli_fetch_object($resultaat)) {
echo"
<TR><TD><B>Subject :<TD>$data->subject</TR>
<TR><TD><B>Date :<TD>".date("Y-m-d H:i", $data->date)."</TR>
<TR><TD colspan=2><BR><B>Note:</B><BR>".nl2br($data->note)."<BR></TR>

</TABLE>
</TD></TR>
<TR bgcolor=444444><TD><center><a href='notes.php?edit=$data->ID'><img src=../../layout/edit.png border=0> Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='notes.php?del=$data->ID'><img src=../../layout/delete.gif border=0> Delete</a></TD></TR></TABLE><BR>";
}
}elseif($delete){

$query = "DELETE FROM notes WHERE ID = '$delete' && user = '$S_username' LIMIT 1";
$result = mysqli_query($mysqli,$query);

echo"<BR><table border=1 width=300 bgcolor=333333><TR><TD><center><B><font color=white>Note deleted!</TD></TR></TABLE>";
}elseif($delall){

$query = "DELETE FROM `notes` where user = '$S_username' LIMIT $limit";
$result = mysqli_query($mysqli,$query);

echo"<BR><table border=1 width=300 bgcolor=333333><TR><TD><center><B><font color=white>ALL Notes deleted!</TD></TR></TABLE>";
}

elseif($note){

$subject=htmlentities(trim($_POST['subject']));
$tekst=htmlentities(trim($_POST['box']));


if($subject=='' && $tekst=='' && $aantalnotes<$limit){
?>


<BR>
<TABLE border=1><TR><TD>
 <form action="" method=post name="f" onsubmit="return check();">
<TABLE width=400 border=0 cellpadding=0 cellspacing=0 bgcolor=666666>
<tr><td><B>Subject</B> :</td><td><input type=text name=subject value='' size=40 MAXLENGth=100>
<tr><td valign=top><B>Note :</td><td><textarea rows="14" cols="50" name="box"
 onkeyup="update();"></textarea><br>

 <script type="text/javascript" language="JavaScript1.2"><!--
    document.write('Characters typed: <input '+
        'type="text" size="3" name="counter" value=""'+
        'readonly onfocus="this.form.box.focus()"> (limit: '+
        limit+')');
    update();
 //--></script>

</tr>  <tr><td><input type=submit value=Note!> </td><td></tr>
   </form></table>





<?}elseif($subject<>'' && $tekst<>'' && $aantalnotes<$limit){

$tekst = substr ("$tekst", 0,($LENG));
$time=time();
$sql = "INSERT INTO `notes` ( `user` , `date` , `subject` , `note` )VALUES ('$S_username', '$time', '$subject', '$tekst')";
        $resultaat = mysqli_query($mysqli,$sql) or die(mysqli_error());


echo"<BR><table border=1 width=300 bgcolor=333333><TR><TD><center><B><font color=white>Note added!</TD></TR></TABLE>";}


}elseif($edit){

$subject=htmlentities(trim($_POST['subject']));
$tekst=htmlentities(trim($_POST['box']));


if($subject=='' && $tekst==''){


$sql2 = "SELECT subject,note FROM notes WHERE user = '$S_username' && ID = '$edit' LIMIT 1";
        $resultat = mysqli_query($mysqli,$sql2) or die(mysqli_error());
while ($data = mysqli_fetch_object($resultat)) {
	$sub=$data->subject;
	$tek=$data->note;
}

	?>


<BR>
<TABLE border=1><TR><TD>
 <form action="" method=post name="f" onsubmit="return check();">
<TABLE width=400 border=0 cellpadding=0 cellspacing=0 bgcolor=666666>
<tr><td><B>Subject</B> :</td><td><input type=text name=subject value='<?php echo"$sub"; ?>' size=40 MAXLENGth=100>
<tr><td valign=top><B>Note</B> :</td><td><textarea rows="10" cols="30" name="box"
 onkeyup="update();"><?php echo"$tek"; ?></textarea><br>

 <script type="text/javascript" language="JavaScript1.2"><!--
    document.write('Characters typed: <input '+
        'type="text" size="3" name="counter" value=""'+
        'readonly onfocus="this.form.box.focus()"> (limit: '+
        limit+')');
    update();
 //--></script>

</tr>  <tr><td><input type=submit value=Note!> </td><td></tr>
   </form></table>





<?}elseif($subject<>'' && $tekst<>''){

$tekst = htmlentities(trim(substr ("$tekst", 0,($LENG))));
$time=time();
$sql = " UPDATE `notes` SET `date` = '$time', `subject` = '$subject', `note` = '$tekst' WHERE `ID` = '$edit' && user = '$S_username' LIMIT 1 ;";
        $resultaat = mysqli_query($mysqli,$sql) or die(mysqli_error());


echo"<BR><table border=1 width=300 bgcolor=333333><TR><TD><center><B><font color=white>Note Updated!</TD></TR></TABLE>";}




}











 ?>


<BR>
<center><B>Currently Noted</B><BR>
<table width=400>
<tr bgcolor=333333><td><center><B>Delete<td><center><B>Last editted<Td><center><B>Subject

<?

$sql2 = "SELECT * FROM notes WHERE user = '$S_username' ORDER BY date DESC LIMIT $limit";
        $resultat = mysqli_query($mysqli,$sql2) or die(mysqli_error());
while ($data = mysqli_fetch_object($resultat)) {
if($bg==''){$bg="777777";}
echo"
<tr bgcolor='$bg'>
<Td><center><a href='notes.php?del=$data->ID'><img src=../../layout/delete.gif border=0></a>
<td>".date("Y-m-d H:i", $data->date)."
<td><a href='notes.php?lees=$data->ID'><B>$data->subject</b></a>
";
if($bg=='777777'){$bg='555555';}else{$bg='777777';}
}
?>

</table><form action='' method=post>
<input type=hidden name=DELALL value=1>
      <input type=hidden name=submit value=yes>
      <input type=submit value='Delete ALL notes'></form>
<?
}else{echo"ERROR report bug NOTES643";}