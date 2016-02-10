<?php
//หากมีการเรียกไฟล์นี้โดยตรง
if( !defined('_MAXSITE') ) die ('Invalid');

//ตรวจสอบว่ามีโมดูลหรือไม่ (โมดูล User)
function GETMODULE($name, $file){
	global $MODPATH, $MODPATHFILE;
    $modpathfile = "modules/$name/$file.php";
    if (file_exists($modpathfile)) {
	    $MODPATHFILE = $modpathfile;
	    $MODPATH = "modules/$name/";
	}else{
        die ("เสียใจด้วยครับ ไม่มีหน้าที่ท่านต้องการเข้าชม...");
	}
}

include 'includes/function.in.php';
include 'includes/array.in.php';
include 'includes/config.in.php';
include 'includes/class.mysql.php';
include 'includes/class.ban.php';
include 'includes/class.calendar.php';

$db = New DB();
