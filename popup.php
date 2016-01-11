<?
session_start();
require_once("mainfile.php");
$PHP_SELF = "popup.php";
GETMODULE($_GET[name],$_GET[file]);

?>
<HTML>
<HEAD>
<TITLE><?=WEB_TITLE;?></TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<meta name="keywords" content="เว็บสำเร็จรูป,อัษฎา,มอไซค์ดอทคอม, maxsite">
<meta name="description" content="เว็บไซต์สำเร็จรูป maxsite">
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="java.js"></script>

</head>

<body  >

<!-- Content -->
<?include ("".$MODPATHFILE."");?>
<!-- End Content -->

</body>
</html>
