<?php 
/*
ผู้พัฒนา : นายอัษฎา อินต๊ะ
โทรศัพท์ : 081-595-3392
Email : mocyc@hotmail.com
http://maxsite.geniuscyber.com

ตัวคอนฟิกในการควบคุมระบบเว็บไซต์ 
*/

//หากมีการเรียกไฟล์นี้โดยตรง
if (eregi("config.in.php",$PHP_SELF)) {
    Header("Location: ../index.php");
    die();
}

//MAXSITE Version
define("_SCRIPT","MAXSITE"); 
define("_VERSION","1.10"); 

//Web Config
define("WEB_TITLE","## "._SCRIPT." "._VERSION." ##"); 
define("WEB_URL","http://localhost/maxsite1.10") ; 
define("WEB_EMAIL","xxx@xxx.com") ; 
define("TIMESTAMP",time()) ;

//Capcha ตัวหนังสือยืนยันการโพสข้อความ
define("USE_CAPCHA", true); //ใช้การป้องกันการโพสสแปม   true , false
define("CAPCHA_TYPE","2"); //รูปแบบของตัวอักษร 1 = แบบสวยงาม , 2 = แบบธรรมดา
define("CAPCHA_NUM","6"); //จำนวนตัวอักษร
define("CAPCHA_WIDTH","80"); //ขนาดความกว้าง
define("CAPCHA_HEIGHT","25"); //ขนาดความสูง

/*
CAPCHA_TYPE แบบที่ 1 ต้องเซ็ทค่าดังนี้
 กรณีที่ตัวอักษรไม่ขึ้นให้เข้าไปแก้ที่ไฟล์ capcha/CaptchaSecurityImages.php บรรทัดที่ 6 ให้ใส่ path ให้ถูกต้อง หากต้องการทราบ path ให้เปิดไฟล์ phpinfo.php เพื่อตรวจสอบ path ของเว็บไซต์ 
*/

//Calendar
define("USE_THAIYEAR", true); //แสดงผลเป็น พ.ศ. ใน calendar   true , false


//MySQL Connect
define("DB_HOST","localhost");
define("DB_NAME","maxsite");
define("DB_USERNAME","root");
define("DB_PASSWORD","");

//MySQL table
define("TB_ADMIN","web_admin");
define("TB_ADMIN_GROUP","web_groups");
define("TB_NEWS","web_news");
define("TB_NEWS_COMMENT","web_news_comment");
define("TB_NEWS_CAT","web_news_category");
define("TB_KNOWLEDGE","web_knowledge");
define("TB_KNOWLEDGE_COMMENT","web_knowledge_comment");
define("TB_KNOWLEDGE_CAT","web_knowledge_category");
define("TB_CALENDAR","web_calendar");
define("TB_WEBBOARD","web_webboard");
define("TB_WEBBOARD_COMMENT","web_webboard_comment");
define("TB_WEBBOARD_CAT","web_webboard_category");

//Permission Name
define("_NEWS","ข่าวสาร");
define("_NEWSCAT","หมวดหมู่ข่าวสาร");
define("_ADMIN","ผู้ดูแลระบบ");
define("_GROUP","ระดับผู้ดูแลระบบ");
define("_LINKS","Web Links");
define("_ARTICLE","บทความ");
define("_ARTICLECAT","หมวดหมู่บทความ");
define("_CONTACT","อีเมล์ติดต่อในเว็บไซต์");
define("_CALENDAR","ปฏิทินกิจกรรม");
define("_WEBBOARD","เว็บบอร์ด");
define("_EDITORTALK","Editor Talk");
define("_ABOUTUS","เกี่ยวกับเรา");
define("_MINEPASS","ชื่อผู้ใช้ รหัสผ่าน");

//Icon Size
define("_INEWS_W","48"); //ไอคอนข่าวสารกว้าง
define("_INEWS_H","48"); //ไอคอนข่าวสารสูง
define("_IKNOW_W","80"); //ไอคอนความรู้กว้าง
define("_IKNOW_H","60"); //ไอคอนความรู้สูง 

//Show Topic
define("_NEWS_COL","2"); //จำนวนคอลัมน์ในการแสดงข่าวสาร
define("_KNOW_COL","2"); //จำนวนคอลัมน์ในการแสดงสาระความรู้ 

//Webboard control
define("_NUM_ID","5"); //การแสดงหัวข้อโดยแสดงจำนวนกี่หลัก เช่น ตั้งค่าเป็น 5 ก็จะแสดง 00001 , 00015 เป็นต้น
define("_SHOW_BOARD_PIN","5"); //การจำนวนกระทู้ปักหมุด
define("_PERPAGE_BOARD","20"); //จำนวนกระทู้ที่แสดงหน้าบอร์ดแต่ละหมวด
define("_ENABLE_BOARD_UPLOAD",true); //ให้มีการอัพโหลดรูปได้  true , false
define("_WEBBOARD_LIMIT_UPLOAD","102400"); //ขนาดไฟล์รูปที่อัพโหลดได้ 
define("_WEBBOARD_LIMIT_PICWIDTH","500"); //ขนาดไฟล์รูปที่อัพโหลดได้ 



define("_MNAME",$_GET['name']) ; 
define("_MFILE",$_GET['file']) ; 

//ตรวจสอบ IP
if ($_SERVER['HTTP_CLIENT_IP']) { 
$IPADDRESS = $_SERVER['HTTP_CLIENT_IP'];
} elseif (ereg("[0-9]",$_SERVER["HTTP_X_FORWARDED_FOR"] )) { 
$IPADDRESS = $_SERVER["HTTP_X_FORWARDED_FOR"];
} else { 
$IPADDRESS = $_SERVER["REMOTE_ADDR"];
}
define("IPADDRESS",$IPADDRESS) ;


//ผู้ดูแลระบบไม่ผ่านสิทธิการใช้งาน
$PermissionFalse .= "<BR><BR>";
$PermissionFalse .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/notview.gif\" BORDER=\"0\"></A><BR><BR>";
$PermissionFalse .= "<FONT COLOR=\"#336600\"><B>ท่านไม่ได้รับอนุญาตให้ใช้งานส่วนนี้ได้</B></FONT><BR><BR>";
$PermissionFalse .= "<A HREF=\"?name=admin&file=main\"><B>หน้าหลักผู้ดูแลระบบ</B></A>";
$PermissionFalse .= "</CENTER>";
$PermissionFalse .= "<BR><BR>";

?>