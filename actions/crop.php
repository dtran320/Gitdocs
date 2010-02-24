<?
require_once(dirname(__FILE__) . '/../lib/utils.php');
require_once(dirname(__FILE__) . "/../config.php");

$action = postVarClean('action');
$u_id = postVarClean('u_id');

$AVATARS_PATH = 'images/pix/';
$big_filename = dirname(__FILE__) . '/../' . $AVATARS_PATH . $u_id . '_big.jpg';
$small_filename = dirname(__FILE__) . '/../' . $AVATARS_PATH . $u_id . '_small.jpg';

//TODO: 
// file size
// file type (convert to jpg from png, etc)
// use success/failure msgs 

if ($action == 'upload') {
	if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $big_filename)) {
		copy($big_filename, dirname(__FILE__) . '/../' . $AVATARS_PATH . $u_id . '_big2.jpg');
		if (file_exists($small_filename)) {
			unlink($small_filename);
		}
		crop_image(0, 0, 100, 100, $big_filename, $small_filename);
		echo 'Pic upload success';
	} else{
	  echo "There was an error uploading the file, please try again!";
	}

} else if ($action == 'crop') {
	$x = postVarClean('x');
	$y = postVarClean('y');
	$w = postVarClean('w');
	$h = postVarClean('h');
	crop_image($x, $y, $w, $h, $big_filename, $small_filename);
} 

function crop_image($x, $y, $w, $h, $big_filename, $small_filename) {
	$targ_w = $targ_h = 50;
	$jpeg_quality = 90;

	$img_r = imagecreatefromjpeg($big_filename);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $targ_w, $targ_h, $w, $h);

	$success = imagejpeg($dst_r, $small_filename, $jpeg_quality);

	imagedestroy($img_r);
	imagedestroy($dst_r);
	if ($success) {
		echo 'Success';
	} else {
		echo 'Error';
	}
}

?>
