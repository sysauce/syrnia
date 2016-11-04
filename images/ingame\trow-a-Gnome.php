<?php 
   header("Content-type: image/png"); 

##$plaatje = ImageCreate(210, 210); 
$plaatje = imagecreatefromjpeg("trow-a-gnome.jpg");

 
   $wit     = ImageColorAllocate($plaatje, 255, 255, 255); 
  $zwart = ImageColorAllocate($plaatje, 0, 0, 0);

   ImageTTFText($plaatje, 18, 0, $x, 140, $zwart, "../../layout/fonts/verdana.ttf", "X"); 

   ImagePNG($plaatje);
   ImageDestroy($plaatje); 
?> 


