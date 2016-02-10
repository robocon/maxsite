<?php
session_start();

$PHP_SELF = "popup.php";
define('_MAXSITE', '1');

// โหลดคอนฟิกและไฟล์พื้นฐาน
include 'mainfile.php';

$name = input_get('name', 'index');
$file = input_get('file', 'index');
GETMODULE($name, $file);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
    <title><?=WEB_TITLE;?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="เว็บสำเร็จรูป,อัษฎา,มอไซค์ดอทคอม, maxsite">
    <meta name="description" content="เว็บไซต์สำเร็จรูป maxsite">
    <link href="style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="java.js"></script>
</head>
    <body>
    <!-- Content -->
    <?php include $MODPATHFILE;?>
    <!-- End Content -->
    </body>
</html>
