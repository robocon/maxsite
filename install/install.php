<?php
error_reporting(1);
ini_set('display_errors', "1");

include '../includes/function.in.php';

$host = input_post('db_hostname');
$db_name = input_post('db_name');
$db_user = input_post('db_username');
$db_pwd = input_post('db_password');

if( empty($db_name) ){
    echo 'กรุณาใส่ชื่อฐานข้อมูล <a href="javascript: window.history.back(-1)">คลิกที่นี่เพื่อกลับไปแก้ไข</a>';
    exit;
}

if( empty($db_user) ){
    echo 'กรุณาใส่ชื่อผู้ใช้ฐานข้อมูล <a href="javascript: window.history.back(-1)">คลิกที่นี่เพื่อกลับไปแก้ไข</a>';
    exit;
}

try {
    $dbh = new PDO('mysql:host='.$host.';dbname='.$db_name, $db_user, $db_pwd);
    $dbh->exec("set names utf8");
    $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}

$sql = "CREATE TABLE web_admin (
  id int(11) NOT NULL auto_increment,
  username varchar(50) NOT NULL default '',
  password varchar(50) NOT NULL default '',
  name varchar(255) NOT NULL default '',
  email varchar(100) NOT NULL default '',
  level tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY id (id),
  KEY username (username),
  KEY password (password),
  KEY level (level)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;";
// $result = mysql_query($sql);
$dbh->exec($sql);

$sql = "INSERT INTO web_admin VALUES (1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'อัษฎา อินต๊ะ', 'mocyc@hotmail.com', 1);";
// $result = mysql_query($sql);
$dbh->exec($sql);
$sql = "INSERT INTO web_admin VALUES (2, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'นาย ทดสอบ ทดลอง', 'test@test.com', 6);";
// $result = mysql_query($sql);
$dbh->exec($sql);

$sql = "CREATE TABLE web_calendar (
  id int(11) NOT NULL auto_increment,
  date_event date NOT NULL default '0000-00-00',
  subject varchar(255) NOT NULL default '',
  post_date int(20) NOT NULL default '0',
  update_date int(20) NOT NULL default '0',
  pageview int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY id (id),
  KEY date_event (date_event)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;";
// $result = mysql_query($sql);
$dbh->exec($sql);

$sql = "INSERT INTO web_calendar VALUES (1, '2007-10-12', 'ทดสอบ maxsite 1.10', 1192174158, 0, 5);";
// $result = mysql_query($sql);
$dbh->exec($sql);

$sql = "CREATE TABLE web_groups (
  id int(11) NOT NULL auto_increment,
  name tinytext NOT NULL,
  description text NOT NULL,
  news_add tinyint(4) NOT NULL default '0',
  news_edit tinyint(4) NOT NULL default '0',
  news_del tinyint(4) NOT NULL default '0',
  newscat_add tinyint(4) NOT NULL default '0',
  newscat_edit tinyint(4) NOT NULL default '0',
  newscat_del tinyint(4) NOT NULL default '0',
  admin_add tinyint(4) NOT NULL default '0',
  admin_edit tinyint(4) NOT NULL default '0',
  admin_del tinyint(4) NOT NULL default '0',
  group_add tinyint(4) NOT NULL default '0',
  group_edit tinyint(4) NOT NULL default '0',
  group_del tinyint(4) NOT NULL default '0',
  links_add tinyint(4) NOT NULL default '0',
  links_edit tinyint(4) NOT NULL default '0',
  links_del tinyint(4) NOT NULL default '0',
  article_add tinyint(4) NOT NULL default '0',
  article_edit tinyint(4) NOT NULL default '0',
  article_del tinyint(4) NOT NULL default '0',
  articlecat_add tinyint(4) NOT NULL default '0',
  articlecat_edit tinyint(4) NOT NULL default '0',
  articlecat_del tinyint(4) NOT NULL default '0',
  contact_add tinyint(4) NOT NULL default '0',
  contact_edit tinyint(4) NOT NULL default '0',
  contact_del tinyint(4) NOT NULL default '0',
  calendar_add tinyint(4) NOT NULL default '0',
  calendar_edit tinyint(4) NOT NULL default '0',
  calendar_del tinyint(4) NOT NULL default '0',
  webboard_add tinyint(4) NOT NULL,
  webboard_edit tinyint(4) NOT NULL,
  webboard_del tinyint(4) NOT NULL,
  editortalk_edit tinyint(4) NOT NULL default '0',
  aboutus_edit tinyint(4) NOT NULL default '0',
  minepass_edit tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY id (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;";
// $result = mysql_query($sql);
$dbh->exec($sql);

$sql = "INSERT INTO web_groups VALUES (1, 'Webmaster', 'เว็บมาสเตอร์', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);";
// $result = mysql_query($sql);
$dbh->exec($sql);
$sql = "INSERT INTO web_groups VALUES (2, 'Admin', 'แอดมิน', 1, 1, 1, 1, 1, 1, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);";
// $result = mysql_query($sql);
$dbh->exec($sql);
$sql = "INSERT INTO web_groups VALUES (6, 'Demo', 'ทดสอบระบบ', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);";
// $result = mysql_query($sql);
$dbh->exec($sql);

$sql = "CREATE TABLE web_knowledge (
  id int(11) NOT NULL auto_increment,
  category varchar(10) NOT NULL default '',
  topic varchar(255) NOT NULL default '',
  headline varchar(255) NOT NULL default '',
  posted varchar(100) NOT NULL default '',
  post_date varchar(50) NOT NULL default '',
  update_date varchar(50) NOT NULL default '',
  enable_comment tinyint(1) NOT NULL default '0',
  pageview int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY id (id),
  KEY category (category)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;";
// $result = mysql_query($sql);
$dbh->exec($sql);

$sql = "INSERT INTO web_knowledge VALUES (1, '1', 'อยากรู้มั๊ยว่า Hot spot คืออะไร ?', 'นับวันเทคโนโลยีต่างๆได้เริ่มเข้ามามีบทบาทในชีวิตประจำวันมากขึ้นเรื่อยๆ รวมไปถึงเทคโนโลยี Wi-Fi ไม่ว่าจะเป็นการใช้งานตามบ้าน ที่ทำงานหรือแม้แต่ตามสถานที่ทั่วไป เช่น โรงแรม, สนามบิน , โรงพยาบาล , ศูนย์การค้า , รีสอร์ท , คอฟฟี่ช๊อป ฯลฯ', 'admin', '1192094365', '1192094365', 1, 2);";
// $result = mysql_query($sql);
$dbh->exec($sql);
$sql = "INSERT INTO web_knowledge VALUES (2, '2', ' I Hacked 127.0.0.1', 'มาดู hacker รุ่นเดอะ คุยกัน (Dangerous Hacker! The Bitchchecker Story)', 'admin', '1192094730', '1192094730', 1, 9);";
// $result = mysql_query($sql);
$dbh->exec($sql);

$sql = "CREATE TABLE web_knowledge_category (
  id int(11) NOT NULL auto_increment,
  category_name varchar(255) NOT NULL default '',
  sort int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY id (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;";
// $result = mysql_query($sql);
$dbh->exec($sql);

$sql = "INSERT INTO web_knowledge_category VALUES (1, 'ความรู้เกี่ยวกับ IT', 1);";
// $result = mysql_query($sql);
$dbh->exec($sql);
$sql = "INSERT INTO web_knowledge_category VALUES (2, 'บ้าๆบ่นๆเรื่อยเปื่อย', 2);";
// $result = mysql_query($sql);
$dbh->exec($sql);

$sql = "CREATE TABLE web_knowledge_comment (
  id int(7) NOT NULL auto_increment,
  knowledge_id int(7) NOT NULL default '0',
  name varchar(100) NOT NULL default '',
  comment text NOT NULL,
  ip varchar(50) NOT NULL default '',
  post_date varchar(50) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY id (id),
  KEY knowledge_id (knowledge_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
// $result = mysql_query($sql);
$dbh->exec($sql);

$sql = "CREATE TABLE web_news (
  id int(11) NOT NULL auto_increment,
  category varchar(10) NOT NULL default '',
  topic varchar(255) NOT NULL default '',
  headline varchar(255) NOT NULL default '',
  posted varchar(100) NOT NULL default '',
  post_date varchar(50) NOT NULL default '',
  update_date varchar(50) NOT NULL default '',
  enable_comment tinyint(1) NOT NULL default '0',
  pageview int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY id (id),
  KEY category (category)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;";
// $result = mysql_query($sql);
$dbh->exec($sql);

$sql = "INSERT INTO web_news VALUES (1, '1', 'เปิดใช้งานแล้ว Maxsite1.10', 'ก็ปรับปรุงตัวเดิมนิดหน่อย โดยเห็นมีปัญหาในเรื่องของ Spam ในความคิดเห็นนะครับ ก็เลยทำระบบป้องกันมาให้ใช้นะครับ', 'admin', '1192090382', '1192090382', 1, 7);";
// $result = mysql_query($sql);
$dbh->exec($sql);
$sql = "INSERT INTO web_news VALUES (2, '1', 'CMusedcar.com คิดจะซื้อขายรถคิดถึงเรา', 'ผมได้เปิดเว็บไซต์ใหม่อรฃีกแล้วชื่อ CMusedcar.com เว็บขายรถยนต์มือสอง ที่เน้นให้บ้านเกิดผมใช้งานคือ จ.เชียงใหม่ครับ', 'admin', '1192092248', '1192092248', 1, 9);";
// $result = mysql_query($sql);
$dbh->exec($sql);

$sql = "CREATE TABLE web_news_category (
  id int(11) NOT NULL auto_increment,
  category_name varchar(255) NOT NULL default '',
  sort int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY id (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;";
// $result = mysql_query($sql);
$dbh->exec($sql);

$sql = "INSERT INTO web_news_category VALUES (1, 'ข่าวประชาสัมพันธ์', 1);";
// $result = mysql_query($sql);
$dbh->exec($sql);
$sql = "INSERT INTO web_news_category VALUES (2, 'ข่าวสารประกวดราคา', 2);";
// $result = mysql_query($sql);
$dbh->exec($sql);

$sql = "CREATE TABLE web_news_comment (
  id int(7) NOT NULL auto_increment,
  news_id int(7) NOT NULL default '0',
  name varchar(100) NOT NULL default '',
  comment text NOT NULL,
  ip varchar(50) NOT NULL default '',
  post_date varchar(50) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY id (id),
  KEY news_id (news_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
// $result = mysql_query($sql);
$dbh->exec($sql);

$sql = "CREATE TABLE web_webboard (
  id int(11) NOT NULL auto_increment,
  category int(3) NOT NULL default '0',
  topic varchar(255) NOT NULL default '',
  detail text NOT NULL,
  picture varchar(50) NOT NULL default '',
  post_name varchar(50) NOT NULL default '',
  is_member int(7) NOT NULL default '0',
  ip_address varchar(50) NOT NULL default '',
  post_date varchar(50) NOT NULL default '',
  pin_date varchar(50) NOT NULL,
  pageview int(5) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY cat_id (category),
  KEY id (id),
  KEY post_date (post_date)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
// $result = mysql_query($sql);
$dbh->exec($sql);

$sql = "CREATE TABLE web_webboard_category (
  id int(11) NOT NULL auto_increment,
  category_name varchar(255) NOT NULL default '',
  sort int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY id (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;";
// $result = mysql_query($sql);
$dbh->exec($sql);

$sql = "INSERT INTO web_webboard_category VALUES (1, 'ห้องนั่งเล่น', 1);";
// $result = mysql_query($sql);
$dbh->exec($sql);
$sql = "INSERT INTO web_webboard_category VALUES (2, 'สอบถามปัญหาการใช้งาน maxsite', 2);";
// $result = mysql_query($sql);
$dbh->exec($sql);

$sql = "CREATE TABLE web_webboard_comment (
  id int(11) NOT NULL auto_increment,
  topic_id int(7) NOT NULL default '0',
  detail text NOT NULL,
  picture varchar(50) NOT NULL default '',
  post_name varchar(50) NOT NULL default '',
  is_member int(7) NOT NULL default '0',
  ip_address varchar(50) NOT NULL default '',
  post_date varchar(50) NOT NULL default '',
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
// $result = mysql_query($sql);
$dbh->exec($sql);

// $FileBNK = "../includes/config.in.php.bnk";
// $FileBNKOpen = @fopen($FileBNK, "r");
// $FileBNKContent = @fread($FileBNKOpen, @filesize($FileBNK));
// @fclose($FileBNKOpen);

$FileBNKContent = file_get_contents('../includes/config.in.example.php');

$web_url = input_post('web_url');
$web_email = input_post('web_email');
$use_capcha = input_post('use_capcha');
$capcha_type = input_post('capcha_type');
$capcha_num = input_post('capcha_num');

$FileBNKContent = str_replace("%DB_HOST%", $host, $FileBNKContent);
$FileBNKContent = str_replace("%DB_NAME%", $db_name, $FileBNKContent);
$FileBNKContent = str_replace("%DB_USERNAME%", $db_user, $FileBNKContent);
$FileBNKContent = str_replace("%DB_PASSWORD%", $db_pwd, $FileBNKContent);
$FileBNKContent = str_replace("%WEB_URL%", $web_url, $FileBNKContent);
$FileBNKContent = str_replace("%WEB_EMAIL%", $web_email, $FileBNKContent);
$FileBNKContent = str_replace("\"%USE_CAPCHA%\"", $use_capcha, $FileBNKContent);
$FileBNKContent = str_replace("%CAPCHA_TYPE%", $capcha_type, $FileBNKContent);
$FileBNKContent = str_replace("%CAPCHA_NUM%", $capcha_num, $FileBNKContent);

// $config_open = @fopen("../includes/config.in.php", "w");
// @fwrite($config_open, "".$FileBNKContent."");
// @fclose($config_open);

file_put_contents('../includes/config.in.php', $FileBNKContent);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MAXSITE 1.10 : : ติดตั้งโปรแกรม</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div align="center">
  <p>&nbsp;</p>
  <p><img src="../images/icon/login-welcome.gif" alt="" width="97" height="105" /><br />
    <br />
      <strong>การติดตั้ง MAXSITE 1.10 เสร็จเรียบร้อย</strong><br /><br />
      <p style="color: red; ">
          <b>หลังจากติดตั้งระบบเสร็จเรียบร้อย กรุณาลบโฟเดอร์ install ทิ้ง</b>
      </p>
	  <a href="../index.php">หน้าแรก Maxsite</a> | <a href="../index.php?name=admin">ผู้ดูแลระบบ</a>
</div>
</body>
</html>
