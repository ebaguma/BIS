<?php
header("Content-type: image/png");
$image = imagecreatetruecolor(50, 25)
   or die("Cannot Initialize new GD image stream");
$col_transparent = imagecolorallocatealpha($image, 255, 255, 255, 127);
$col_red   = imagecolorallocate($image, 250, 250, 250);
imagefill($image, 0, 0, $col_transparent); 
imagecolortransparent ($image, $col_transparent);
$w=strlen($_REQUEST['role']) <=2 ? 20 : $w=strlen($_REQUEST['role']) == 3 ? 15 : 10; 
imagestring($image, 5, $w, 5,$_REQUEST['role'], $col_red);
imagepng($image);
imagedestroy($image);
?>