<?
//หากมีการเรียกไฟล์นี้โดยตรง
if (eregi("config.in.php",$PHP_SELF)) {
    Header("Location: ../index.php");
    die();
}

###### Function Check คำโฆษณา #######
// function check ข้อความว่าโฆษณามาหรือปล่าว
function checkban($message) {
$ban = array(
	"โอกาศในการสร้างรายได้",
	"ล-ด-น้ำ-ห-นั-ก",
	"เริ่มต้นหุ่นดีด้วยวิธีง่ายๆ",
	"ล-ด-น้ำ-ห-นั-ก-เ-กิ-น",
	"อยากเปลี่ยนชีวิตให้ดีขึ้น",
	"งานเสริม คีย์ข้อมูลที่บ้านผ่าน เน็ท",
	"หุ่นดี เพรียว สมใจ ใน 4 สัปดาห์",
	"PART TIME WORK…URGENT !!",
	"ทำงานจากที่บ้าน","งาน Part time",
	"Part Time / Full Time",
	"โครงการทวีคูณรายได้",
	"รายได้เสริม ธุรกิจ Part Time 5,000 บาท ต่อ สัปดาห์",
	"งาน Part-Time โดยใช้สื่อ Internet",
	"ด่วน! สนใจต้องการมีรายได้พิเศษ Full Time - Part Time",
	"หารายได้จากการอ่านโฆษณาในเน๊ตเว็บไทย สมัครฟรี และมีรายได้สูงกว่าเว็บอื่นๆ",
	"สวยเพรียว หุ่นกระชับ",
	"หารายได้จากการอ่าน e-mail งานนี้สมัครฟรี",
	"www.propaidemail.com เป็นเว็บไซต์รับจ้างโฆษณางานทาง",
	"ขอเชิญอ่านดูก่อนครับถึงยังไงเราๆทุกท่านก็คงเช็คเมล์ทุกวันอยู่แล้ว",
	"รูปร่างดีภายใน",
	"รายได้พิเศษ",
	"ถ้าคนรอบข้างคุณทักว่า “อ้วน” คุณจะรู้สึกอย่าง",
	"Herbalife ผลิตภัณฑ์เพื่อสุขภาพและการลดน้ำหนัก",
	"รายได้จากการอ่าน email",
	"ธุรกิจจากที่บ้าน",
	"รายได้จากการอ่านอีเมล์",
	"รายได้เสริมนอกเวลา",
	"ไม่แน่จริงอย่าคลิ๊ก http://",
	"ตบนมให้โต",
	"ธุรกิจนอกเวลา",
	"ถึงเวลารึยังที่คุณจะหันมาใส่ใจสุขภาพและรูปร่างของตัวคุณเอง",
	"ด่วน !!! รายได้พิเศษ Part-time ทำที่บ้านได้ใช้Internet ทำงาน",
	"งาน par time ทำงานจากที่บ้าน",
	"จากไขมัน...เป็น...เพรียว",
	"สำหรับผู้ที่มองหาวิธีการลดน้ำหนักอย่างปลอดภัย",
	"ผอมแล้วไม่กลับมาอ้วนอีก",
	"รับประกันคืนเงินใน 30 วัน",
	"1 กิโล เท่ากับ 7 กิโล..อันตรายที่คุณอาจยังไม่ทราบ",
	"พร้อมผู้เชี่ยวชาญด้านโภชนาการให้คำแนะนำตลอดเวลา",
	"ธุรกิจส่วนตัวควบคู่กับงานประจำ",
	"www.siamwellnessplus.com/rich",
	"1-2 ชั่วโมงต่อวัน โดยใช้สื่อ Internet",
	"รับสมัครผู้ที่ต้องการรายได้เพิ่ม",
	"รับคู่มือรายได้พิเศษฟรี click",
	"รายได้พิเศษ กับการแบ่งเวลาวันละนิด",
	"มีเวลาว่าง แล้วอยากได้",
	"รายได้เสริมนอกพิเศษ",
	"http://www.fast2slim.com/nice",
	"ลดน้ำหนัก3-10 กิโลกรัม",
	"รับรองผลภายใน 1 เดือน",
	"ผลิตภัณฑ์จากธรรมชาติ",
	"ลดความอ้วน",	
	"ไม่ต้องอดอาหาร",
	"ผิวพรรณดูดีขึ้น",
	"www.fast2slim.com/fast",
	"http://www.ProPaideMail.com/pages/index.php?refid=jack99",
	"การร้องขอการจ่ายค่าตอบแทน",
	"ธุรกิจเสริมรายได้หลังเลิกงาน",
	"0 ต่อสัปดาห์",
	"www.propaidemail.com",
	"ผอมได้ง่ายๆ",
	"อ่านอีเมล์ก็ได้เงิน",
	"หารายได้ง่ายๆทางอีเมล์",
	"รายได้ง่ายๆ",
	"ถ้าคุณส่องกระจกแล้วรู้สึกว่า",
	"รายได้ขึ้นอยู่กับการเรียนรู้",
	"http://www.how2rich.com",
	"อีกนับแสนคนที่มีรายได้เสริม",
	"ผ-ล-ข้-า-ง-เ-คี-ย-ง","ป-ล-อ-ด-ภั-ย-แ-ล-ะ-ไ-ด้-ผ-ล",
	"http://website.ntserver.at",
	"สอดคล้องกับสิ่งแพทย์แนะนำ",
	"อิสระภาพทางเวลา",
	"ไม่กระทบงานประจำ",
	"www.how2rich.com/pim",
	"ได้เงินจากการเล่นเน็ท",
	"http://www.cashfiesta.com",
	"รับออกแบบสื่อสิ่งพิมพ์โฆษณา",
	"herbalife",
	"สั่งซื้อสินค้าโทร",
	"เวลาว่างสร้างรายได้เสริม",
	"thaiwellness.cjb.net",
	"ชิมฟรีก่อนซื้อ",
	"คุณจะมีรายได้",
	"http://www.hotmail4u.anglican.at",
	"http://www.thaiadpoint.com/tap6/html/register.php?ref_id= 107751",
	"เล่นเน็ตได้ตังค์",
	"เล่น net ได้ตังค์",
	"cd2004.kickme.to",
	"http://www.clicknmoney.com",
	"ธุรกิจเสริมหลังเลิกงาน",
	"http://www.earnmoney2day.com/th/luck",
	"http://www.pantipmarket.com/fashion/topic/F1725640.html",
	"cd2004.kickme.to",
	"Work@Home",
	"www.slim2you.com",
	"www.newdiet4u.com",
	"www.newbiz4you.com",
	"ได้เงินง่ายๆกับการคลิ๊กแบนเนอร์ และอ่านอีเมล์",
	"www.allyousubmitters.com",
	"www.fantasticashmails.com",
	"www.amazingcashmails.com",
	"รายได้พิเศษเฉลี่ย",
	"www.siamwellnessplus.com",
	"รายได้เสริมในเวลาว่าง ไม่รบกวนเวลางาน",
	"เล่นเน็ตอย่างฉลาด",
	"เปลี่ยนความรู้สึกเบื่องาน",
	"โปรแกรมลดน้ำหนักที่ต้นเหตุ",
	"ทำงานผ่าน internet",
	"มาหุ่นเพรียวสวย",
	"เปิดเน็ตไว้เฉยๆ ได้ตังค์",
	"ดูแลสุขภาพและรูปร่าง",
	"ทำงานเดือนเดียวก็ได้แล้วครับ",
	"ง่ายๆรายได้ดีด้วย",
	"กล้าที่จะแตกต่าง..กล้าที่จะร่ำรวย",
	"PART-TIME หลังเลิกงาน",
	"email.deep.at",
	"ถ้าการถูกล่ามโซ่ติดกับโต๊ะทำงาน",
	"panel.amiga500.at",
	"www.cashfiesta.com",
	"รวยทางลัด",
	"good.battle.at",
	"earnmoney2day",
	"good.battle.at",
	"myicon.ismyidol.com",
	"bizness.american.at",
	"dreamcome2.com02.com",
	"hbb4u.com",
	"viagra",
	"businessinter.com",
	"chasecreditcarda.info",
	"chasecreditcardb.info",
	"chasecredit"
) ;

	/// หากว่าพบข้อความโฆษณา
	for($i=0;$i<count($ban);$i++) {
		if(eregi($ban[$i],$message)) {
		// หากว่าเป็นการโพสโฆษณามั่วกำหนดค่าให้สามารถเช็คได้คือ ban
		$how = "ban" ;
		}
	}
	if($how == "ban") { // ถ้าโฆษณามั่วๆผิดบอร์ด
		echo "<script language='javascript'>" ;
		echo "alert('!!!! ความคิดเห็นของท่านเข้าข่ายการโฆษณาชวนเชื่อ กรุณาอย่าโฆษณาครับ ขอบคุณครับ !!!!')" ;
		echo "</script>" ;
		echo "<script language='javascript'>javascript:history.go(-1)</script>";
		exit() ;
	}
}


###### Function Ban คำหยาบ #######
function banword($message=""){
	//คำที่แบน
	$wordban = array(
		"ashole",
		"a s h o l e",
		"a.s.h.o.l.e",
		"bitch",
		"b i t c h",
		"b.i.t.c.h",
		"shit",
		"s h i t",
		"s.h.i.t",
		"fuck",
		"dick",
		"f u c k",
		"d i c k",
		"f.u.c.k",
		"d.i.c.k",
		"มึง",
		"มึ ง",
		"ควย",
		"ค ว ย",
		"ค.ว.ย",
		"เฮี้ย",
		"ชาติหมา",
		"ชาดหมา",
		"ช า ด ห ม า",
		"ช.า.ด.ห.ม.า",
		"ช า ติ ห ม า",
		"ช.า.ติ.ห.ม.า",
		"สัดหมา",
		"เย็ด",
		"หี",
		"เย็ด",
		"จิ๋ม",
		"ปิ๊"
	);
	//สัญลักษณ์เมื่อคำๆนั้นถูกแบน
	$banchange = "<font color=red>***</font>";
	$message = nl2br($message);
	for ($i=0 ; $i<count($wordban) ; $i++) {
		$message = eregi_replace($wordban[$i],$banchange,$message);
	}
	return stripslashes($message);
}
?>