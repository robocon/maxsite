#####  เกี่ยวกับโปรแกรม #####
MAXSITE 1.10 :
เป็นระบบเว็บสำเร็จรูปอย่างง่ายๆ เพื่อเป็นพื้นฐานในการพัฒนาโปรแกรมแบบง่ายๆ โดยการแก้ไข Template แค่ไฟล์เดียว ไม่ได้มีระบบยิ่งใหญ่อะไรเหมือนพวก nuke , jumla , mambo หรือ CMS ตัวอื่นๆนะครับ เพราะบางครั้งผมคิดว่ามันเกินความจำเป็น ระบบที่ทำเลยออกจะเป็น Manual ซะมากกว่านะครับ เพราะผมทำระบบแนวๆนี้เพราะมันสามารถนำไปประยุกต์ใช้ทำเว็บได้หลากหลายกว่านะครับ

#####  ความต้องการของระบบ #####
ระบบปฏิบัติการ Windows/Linux ฯลฯ
์เว็บเซิร์ฟเวอร์เช่น Microsoft IIS, Apache ฯลฯ
ติดตั้ง PHP เวอร์ชั่น 5.4.x ขึ้นไป 
ติดตั้งฐานข้อมูล MySQL เวอร์ชัน 5.5 ขึ้นไป

#####  การติดตั้ง #####
1. อัพโหลดไฟล์ทั้งหมดลงใน Server
2. ทำการ chmod โฟล์เดอร์เหล่านี้เป็น 777 รวมถึงไฟล์ต่างๆในโฟล์เดอร์ด้วย
	aboutus
	aboutus/aboutus.html
	editortalk
	editortalk/editortalk.html
	calendardata
	includes/config.in.php
	knowledgedata
	knowledgeicon
	newsdata
	newsicon
	UserFiles
	UserFiles/File
	UserFiles/Flash
	UserFiles/Image
	webboard_upload
3. โฟล์เดอร์ UserFiles ต้องอยู่ใน root   www เท่านั้น
4. เปิดเว็บไซต์ http://เว็บของท่านที่เก็บ maxsite/install/
5. กรอกข้อมูลให้ครบถ้วน แล้วกดปุ่ม ติดตั้ง Maxsite



#####  การติดตั้งแบบ Manual #####
1. แก้ไขไฟล์ includes/config.in.php ในค่าต่างๆ
2. นำไฟล์ db.sql เข้าสู่ระบบผ่าน phpmyadmin (คิดว่าทุก server มีหมดนะ)
3. อัพโหลดไฟล์ทั้งหมดเข้า server
4. ทำการ chmod โฟล์เดอร์เหล่านี้เป็น 777 รวมถึงไฟล์ต่างๆในโฟล์เดอร์ด้วย
	aboutus
	aboutus/aboutus.html
	editortalk
	editortalk/editortalk.html
	calendardata
	knowledgedata
	knowledgeicon
	newsdata
	newsicon
	UserFiles
	UserFiles/File
	UserFiles/Flash
	UserFiles/Image
	webboard_upload

5. โฟล์เดอร์ UserFiles ต้องอยู่ใน root   www เท่านั้น
6. ทำการทดสอบโดยเข้าระบบ admin ผ่านเมนูด้านล่างสุดโดยใช้
	username : admin
	password : admin
7. สามารถเพิ่มข้อความในการแบนข้อความจากโฆษณาขายตรง และ คำหยาบ ได้โดยเพิ่มข้อความในไฟล์
	includes/class.ban.php
8. ในการเปิดใช้งาน capcha กรณีที่ตัวอักษรไม่ขึ้นให้เข้าไปแก้ที่ไฟล์ capcha/CaptchaSecurityImages.php บรรทัดที่ 6 ให้ใส่ path ให้ถูกต้อง หากต้องการทราบ path ให้เปิดไฟล์ phpinfo.php เพื่อตรวจสอบ path ของเว็บไซต์
