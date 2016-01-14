<?php
//
session_start();

function generateCode($characters) {
	/* list all possible characters, similar looking characters and vowels have been removed */
	$possible = '23456789bcdfghjkmnpqrstvwxyz';
	$code = '';
	$i = 0;
	while ($i < $characters) {
		$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
		$i++;
	}
	return $code;
}

$code = generateCode($_GET['characters']);
$_SESSION["security_code"] = $code;

header("Content-type: image/png");
$im = @imagecreate(intval($_GET['width']), intval( $_GET['height'])) or die("Cannot Initialize new GD image stream");
$white = imagecolorallocate($im, 255, 255, 255);
$black = imagecolorallocate($im, 0, 0, 0);
imagefill($im, 0, 0, $black);
imagestring($im, 4, 25, 3, $code, $white);
imagepng($im);
imagedestroy($im);
