<?
require_once(dirname(__FILE__) . '/../lib/utils.php');
require_once(dirname(__FILE__) . "/../config.php");

$action = postVarClean('action');
$u_id = postVarClean('u_id') != "" ? postVarClean('u_id') : getVarClean('u_id');


$big_filename = dirname(__FILE__) . '/../' . $AVATARS_PATH . $u_id . '_big.jpg';
$small_filename = dirname(__FILE) . '/../' . $AVATARS_PATH . $u_id . '_small.jpg';

//TODO: 
// file size
// file type (convert to jpg?)
// use success/failure msgs 

if ($action == 'upload') {
	if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $big_filename)) {
		copy($big_filename, dirname(__FILE__) . '/../' . $AVATARS_PATH . $u_id . '_big2.jpg');
		if (file_exists($small_filename)) {
			unlink($small_filename);
		}
		echo 'Pic upload success';
	} else{
	  echo "There was an error uploading the file, please try again!";
	}

} else if ($action == 'crop') {
	$x = postVarClean('x');
	$y = postVarClean('y');
	$w = postVarClean('w');
	$h = postVarClean('h');

	$targ_w = $targ_h = 50;
	$jpeg_quality = 90;

	$img_r = imagecreatefromjpeg($big_filename);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $targ_w, $targ_h, $w, $h);

	if(imagejpeg($dst_r, $small_filename, $jpeg_quality)) {
		echo 'Success';
	} else {
		echo 'There was an error saving.';
	}

	imagedestroy($img_r);
	imagedestroy($dst_r);
} else {

/*
	$type = getVarClean('type');
	$a = getVarClean('a');
	if ($type == 'cropped') {
		$filename = $small_filename;
	} else if ($a == 'a'){
		$filename = $bigg;
	} else {
		$filename = $big_filename;
	}
	if(file_exists($filename)) {
		$img = imagecreatefromjpeg($filename);		
	} else {
		$img = imagecreatefromjpeg('../images/default.jpg');
	}	
	
	
	header('Content-type: image/jpeg');
//	header('Expires: Thu, 01 Dec 1994 16:00:00 GMT');
//	header('Cache-Control: no-cache, no-store');
//	header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT'); 

	imagejpeg($img);
	imagedestroy($img);
*/
}


?>
