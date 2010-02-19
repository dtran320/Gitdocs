<?
require_once(dirname(__FILE__) . '/../lib/utils.php');
require_once(dirname(__FILE__) . "/../config.php");

$x = postVarClean("x");
$y = postVarClean("y");
$w = postVarClean("w");
$h = postVarClean("h");

$targ_w = $targ_h = 50;
$jpeg_quality = 90;

$src = dirname(__FILE__) . '/../lib/Jcrop/demos/demo_files/flowers.jpg';
$img_r = imagecreatefromjpeg($src);
$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $targ_w, $targ_h, $w, $h);

if(imagejpeg($dst_r, $DOCUMENTS_PATH . 'c.jpg', $jpeg_quality)) {
	echo "Success";
} else {
	echo "There was an error saving.";
}


?>
