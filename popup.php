<?php
session_start();
$PHP_SELF = "popup.php";
require_once("mainfile.php");

GETMODULE($_GET['name'],$_GET['file']);
?>
<HTML>
<HEAD>
<TITLE><?=WEB_TITLE;?></TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="keywords" content="เว็บสำเร็จรูป,อัษฎา,มอไซค์ดอทคอม, maxsite">
<meta name="description" content="เว็บไซต์สำเร็จรูป maxsite">
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="java.js"></script>

</head>

<body  >

<!-- Content -->
<?php include ("".$MODPATHFILE."");?>
<!-- End Content -->

</body>
</html>
