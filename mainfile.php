<?php
//หากมีการเรียกไฟล์นี้โดยตรง
if (preg_match("/mainfile\.php/",$PHP_SELF)) {
    Header("Location: index.php");
    die();
}

//ตรวจสอบว่ามีโมดูลหรือไม่ (โมดูล User)
function GETMODULE($name,$file){
	global $MODPATH, $MODPATHFILE ;
	if(!$name){ $name = "index"; }
	if(!$file){ $file = "index"; }
    $modpathfile = "modules/".$name."/".$file.".php";
    if (file_exists($modpathfile)) {
	    $MODPATHFILE = $modpathfile;
	    $MODPATH = "modules/".$name."/";
	}else{
        die ("เสียใจด้วยครับ ไม่มีหน้าที่ท่านต้องการเข้าชม...");
	}
}
include 'includes/config.in.php';
include 'includes/class.mysql.php';
include 'includes/array.in.php';
include 'includes/class.ban.php';
include 'includes/class.calendar.php';
include 'includes/function.in.php';

$db = New DB();
