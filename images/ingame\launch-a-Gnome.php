<?php 
   header("Content-type: image/png"); 

##$plaatje = ImageCreate(210, 210); 
$plaatje = imagecreatefromjpeg("launch-a-gnome.jpg");

 
   $wit     = ImageColorAllocate($plaatje, 255, 255, 255); 
  $zwart = ImageColorAllocate($plaatje, 0, 0, 0);

$x=$x*30+rand(-5,10);
$y=$y*30+rand(0,1);
   ImageTTFText($plaatje, 15, 0, $x, $y, $zwart, "../../layout/fonts/verdana.ttf", "X"); 

   ImagePNG($plaatje);
   ImageDestroy($plaatje); 
?> 


