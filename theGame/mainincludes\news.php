<?php
if(defined('AZtopGame35Heyam')){

ob_start();


if(!is_numeric($npage)){$npage=0;}
$start=$npage*25;


 $resultaat = mysqli_query($mysqli, "SELECT ID FROM news");    
   $pages = ceil(mysqli_num_rows($resultaat)/25); 
  
  echo"<center><h2>Page ".($npage+1)."<br/>";
 
for($i=0;$i<$pages;$i++){
 echo" <a href=?page=$page&npage=$i>".($i+1)."</a> ";
}
echo"</h2>
<small><a href=rss.php>RSS feed</a></small><br />
</center>";

echo"<Table>";
  $sql = "SELECT titel, date, mesage FROM news ORDER BY ID DESC LIMIT $start, 25"; 
   $resultaat = mysqli_query($mysqli,$sql);     
    while ($record = mysqli_fetch_object($resultaat)) {$titel=stripslashes($record->titel);  $message=stripslashes($record->mesage); $date=$record->date; 

echo"<tr valign=top><td width=10><td><B>$date <font color=red><B>$titel</b></font>
<tr valign=top><td><td><BR>
$message<BR><BR>";
}
echo"</table>";




$output = ob_get_contents();
ob_end_clean();
$inhoud= MakeParchment("$output", "top", "left", 764-18*2, 245);
echo MakeWoodContainer($inhoud, 764, 270); 



}
?>