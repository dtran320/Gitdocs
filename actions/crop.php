<?
require_once(dirname(__FILE__) . '/../lib/utils.php');
require_once(dirname(__FILE__) . "/../config.php");

$action = postVarClean('action');
$u_id = postVarClean('u_id') != "" ? postVarClean('u_id') : getVarClean('u_id');


$big_filename = $DOCUMENTS_PATH . $u_id . '_big.jpg';
$small_filename = $DOCUMENTS_PATH . $u_id . '_small.jpg';

//TODO: 
// file size
// file type
// use success/failure msgs 

if ($action == 'upload') {
	if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $big_filename)) {
		unlink($small_filename);
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

	$big_filename = $DOCUMENTS_PATH . $u_id . '.jpg';
	if(imagejpeg($dst_r, $small_filename, $jpeg_quality)) {
		echo 'Success';
	} else {
		echo 'There was an error saving.';
	}
} else {
	$type = getVarClean('type');
	$filename = $big_filename;
	if (file_exists($filename)) {
		$img = imagecreatefromjpeg($filename);		
		header('Content-type: image/jpeg');
		imagejpeg($img);
		imagedestroy($img);
	}
}


?>
