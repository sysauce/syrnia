<?php
if(($map>=2 && $map<=21 OR $map==='0') && is_numeric($map)){$map="worldmap$map"; }
elseif($map=='full'){$map='full worldmap'; }
else{$map='worldmap'; }
?><html>
<head><title>Syrnia Worldmap</title></head>
<body topmargin=0 bottommargin=0 leftmargin=0 bgcolor=4B5A7F rightmargin=0><center><img src='<?php echo"$map"; ?>.jpg' border=1 hspace=0 vspace=0><BR>

<?php
if($map=='full worldmap'){
 echo"<form action='' method=get>
 <select name=map>

 <option value=\"1\">Remer island</option>
 <option value=\"2\">Dearn island</option>
 <option value=\"3\">The Outlands</option>
 <option value=\"4\">Mezno island</option>

 <option value=\"6\">Elven island</option>
 <option value=\"7\">Skull island</option>

 <option value=\"9\">Heerchey island</option>

 <option value=\"15\">Kanzo island</option>
 <option value=\"16\">Serpenthelm island</option>
 <option value=\"17\">Exrollia</option>";
 echo"<option value=\"18\">Webbers island</option>";
 echo"<option value=\"19\">Anasco island</option>";
 echo"</select>
 <input type=submit value=Show>
 </form>";
} else{
echo"<a href=worldmap.php?map=full><font color=white>Full worldmap</a>";
}
?>
</body></html>