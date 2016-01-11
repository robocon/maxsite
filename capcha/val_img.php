<?php 
header("Content-type: image/png");
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

$code = generateCode($_GET[characters]);
$im = imagecreate($_GET[width], $_GET[height]);  
$white = ImageColorAllocate($im, 255, 255, 255); 
$black = ImageColorAllocate($im, 0, 0, 0); 
$new_string = $code; 
imagefill($im, 0, 0, $black);
imagestring($im, 4, 25, 3, $new_string, $white); 
$_SESSION["security_code"]=$new_string;
imagepng($im); 
imagedestroy($im); 
?>