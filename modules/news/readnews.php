<script type="text/javascript">
function showemotion() {
	emotion1.style.display = 'none';
	emotion2.style.display = '';
}
function closeemotion() {
	emotion1.style.display = '';
	emotion2.style.display = 'none';
}

function emoticon(theSmilie) {
	document.form2.COMMENT.value += ' ' + theSmilie + ' ';
	document.form2.COMMENT.focus();
}
</script>
<table width=720 border="0">
	<tbody>
		<tr>
			<td width="10" valign="top"><img src="images/fader.gif" border="0"></td>
				<td width="710" valign="top"><img src="images/topfader.gif" border="0"><br>
					<!-- News -->
					&nbsp;&nbsp;<img src="images/menu/textmenu_news.gif" border="0"><br><br>
					<table width="700" align="center" border="0">
						<?php
						$id = input_get('id');

						//แสดงข่าวสาร/ประชาสัมพันธ์
						$sql = "SELECT a.*, b.`id` AS `category_id`, b.`category_name`
						FROM `web_news` AS a
						LEFT JOIN `web_news_category` AS b ON b.`id` = a.`category`
						WHERE a.`id` = :id";
						$item = $msdb->fetch($sql, [':id' => $id]);
						if(!$item['id']){
							echo "<br><br><br><br><center><img src=\"images/icon/notview.gif\" border=\"0\" ><br><br><b>ไม่มีรายการข่าวสาร/ประชาสัมพันธ์นี้</b></CENTER><br><br><br><br>";
						}else{
							$content = file_get_contents('newsdata/'.$item['post_date'].'.txt');
							$Detail = stripslashes(FixQuotes($content));

							//ทำการเพิ่มจำนวนคนเข้าชม
							$view = intval($item['pageview']) + 1;
							$test = $msdb->update("UPDATE `web_news` SET `pageview` = '$view' WHERE `id` = '$id'");
							?>
							<tr>
								<td>
									<b><font color="#990000"><?=$item['category_name'];?><br><?=$item['topic'];?></FONT></b><br>
										<?= ThaiTimeConvert($item['post_date'],"1","");?>
										<?php
										if( isset($_SESSION['admin_user']) ){
											//Admin Login Show Icon
											?>
											<a href="?name=admin&file=news&op=news_edit&id=<?php echo $item['id'];?>"><img src="images/admin/edit.gif" border="0" alt="แก้ไข" ></a>
											<a href="javascript:Confirm('?name=admin&file=news&op=news_del&id=<?php echo $item['id'];?>&prefix=<?php echo $item['post_date'];?>','คุณมั่นใจในการลบหัวข้อนี้ ?');"><img src="images/admin/trash.gif"  border="0" alt="ลบ" ></a>
											<?php
										}
										?>
									<br><br>
								</td>
							</tr>
							<tr>
								<td height="1" class="dotline"></td>
							</tr>
							<tr>
								<td>
									<br>
									<?=$Detail;?>
									<br>
									<br>
									เข้าชม : <?=$item['pageview'];?>
									<br>
									<br>
								</td>
							</tr>
							<tr>
								<td height="1" class="dotline"></td>
							</tr>
							<?php
							//แสดงข่าวสาร/ประชาสัมพันธ์ 5 อันดับล่าสุดของหมวดหมู่
							$news = $msdb->fetchAll("SELECT * FROM `web_news` WHERE `category` = :category_id ORDER BY `id` DESC LIMIT 5",[':category_id' => $item['category_id']]);
							if( count($news) > 0 ){
							?>
							<tr>
								<td>
									<br>
									<b><font color="#990000"><?=$item['category_name'];?> 5 อันดับล่าสุด</b></FONT><br><br>
									<?php
									foreach( $news as $key => $new){
									?>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/icon/suggest.gif" border="0" align="absmiddle">
										<b><a href="?name=news&file=readnews&id=<?=$new['id'];?>" target="_blank"><?=$new['topic'];?></A></b>
										<?php echo ThaiTimeConvert($new['post_date'],"","");?><br>
									<?php
									}
									?>
								</td>
							</tr>
						<?php
							} // End count latest news
						}
						?>
					</table>
					<br>
					<br>
					<?php
					if($item['enable_comment']){

						$sql = "SELECT * FROM `web_news_comment` WHERE `news_id` = :news_id ORDER BY `id` ASC";
						$comments = $msdb->fetchAll($sql, [':news_id' => $item['id']]);
						$count=0;
						foreach( $comments as $key => $comment ){
							$count++;
							?>
							<table cellspacing=5 width="480" border="0" align="center" class="tablecomment">
								<tr>
									<td><b><font color="#990000">ความคิดเห็นที่ <?=$count;?></FONT></b>
										<?php
										if( isset($_SESSION['admin_user']) ){
											?>
											<a href="?name=news&file=delete_comment&id=<?=$id;?>&comment=<?=$comment['id'];?>" onclick="return confirmDelete();">
												<img src="images/admin/trash.gif" align="absmiddle" alt="Delete" />
											</a>
											<?php
										}
										?>
										<br><?= ThaiTimeConvert($comment['post_date'],"1","1");?>
									</td>
								</tr>
								<tr>
									<td height="1" class="dotline"></td>
								</tr>
								<tr>
									<td><?=(CHANGE_EMOTICON(BBCODE($comment['comment'])));?></td>
								</tr>
								<tr>
									<td height="1" class="dotline"></td>
								</tr>
								<tr>
									<td><b><font color="#990000">โดย : </FONT></b> <?=$comment['name'];?> &nbsp;&nbsp; <font color="#990000"><b>ไอพี : </b></FONT><?=$comment['ip'];?>
									</td>
								</tr>
							</table>
							<br>
						<?php
						}
						?>
						<script type="text/javascript">
							function confirmDelete(){
								var v = confirm('ยืนยันที่จะลบ?');
								if( v === false ){
									return false;
								}
							}
						</script>
						<!-- Enable Comment -->
						<table width=500 border="0" align="center">
							<tbody>
								<tr>
									<td width="10" valign="top"><img src="images/fader.gif" border="0"></td>
									<td width="490" valign="top"><img src="images/topfader.gif" border="0"><br>
										<img src="images/menu/textmenu_comment.gif" border="0"><br>
										<form name="form2" method=POST action="?name=news&file=comment&id=<?=$id;?>">
											<table cellspacing=5 width=450 border="0" align="center">
												<tr>
													<td width="80" align="right"><b>ชื่อ/Email : </b></td>
													<td><input type="text" name="NAME" style="width:300"></td>
												</tr>
												<?php
												if(USE_CAPCHA){
													?>
													<tr>
														<td width="80" align="right">
															<?php if(CAPCHA_TYPE == 1){
																echo "<img src=\"capcha/CaptchaSecurityImages.php?width=".CAPCHA_WIDTH."&height=".CAPCHA_HEIGHT."&characters=".CAPCHA_NUM."\" width=\"".CAPCHA_WIDTH."\" height=\"".CAPCHA_HEIGHT."\" align=\"absmiddle\" />";
															}else if(CAPCHA_TYPE == 2){
																echo "<img src=\"capcha/val_img.php?width=".CAPCHA_WIDTH."&height=".CAPCHA_HEIGHT."&characters=".CAPCHA_NUM."\" width=\"".CAPCHA_WIDTH."\" height=\"".CAPCHA_HEIGHT."\" align=\"absmiddle\" />";
															};?>
														</td>
														<td><input name="security_code" type="text" id="security_code" size="20" maxlength="6" style="width:80" > ใส่รหัสที่ท่านเห็นลงในช่องนี้ </td>
													</tr>
													<?php
												}
												?>
												<tr>
													<td width=80 align=right><b>ไอคอน : </b></td>
													<td>
														<div id="emotion1">
															<table width="100%"  border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td class="tahoma_blue"><a href="javascript:showemotion();">ใช้ไอคอน</a><br>
																	</td>
																</tr>
															</table>
														</div>
														<div id="emotion2" style="display: none;">
															<table width="100%"  border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td class="tahoma_blue">
																		<a href="javascript:emoticon(':emo1:');"><img src="images/emotion/angel_smile.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo2:');"><img src="images/emotion/angry_smile.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo3:');"><img src="images/emotion/broken_heart.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo4:');"><img src="images/emotion/cake.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo5:');"><img src="images/emotion/confused_smile.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo6:');"><img src="images/emotion/cry_smile.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo7:');"><img src="images/emotion/devil_smile.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo8:');"><img src="images/emotion/embaressed_smile.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo9:');"><img src="images/emotion/envelope.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo10:');"><img src="images/emotion/heart.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo11:');"><img src="images/emotion/kiss.gif" border="0"></a>&nbsp; <br>
																		<a href="javascript:emoticon(':emo12:');"><img src="images/emotion/lightbulb.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo13:');"><img src="images/emotion/omg_smile.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo14:');"><img src="images/emotion/regular_smile.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo15:');"><img src="images/emotion/sad_smile.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo16:');"><img src="images/emotion/shades_smile.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo17:');"><img src="images/emotion/teeth_smile.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo18:');"><img src="images/emotion/thumbs_down.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo19:');"><img src="images/emotion/thumbs_up.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo20:');"><img src="images/emotion/tounge_smile.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo21:');"><img src="images/emotion/whatchutalkingabout_smile.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo22:');"><img src="images/emotion/wink_smile.gif" border="0"></a>&nbsp;<br>
																		<a href="javascript:emoticon(':emo23:');"><img src="images/emotion2/001.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo24:');"><img src="images/emotion2/002.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo25:');"><img src="images/emotion2/003.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo26:');"><img src="images/emotion2/004.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo27:');"><img src="images/emotion2/005.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo28:');"><img src="images/emotion2/006.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo29:');"><img src="images/emotion2/007.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo30:');"><img src="images/emotion2/008.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon('::emo31:');"><img src="images/emotion2/009.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo32:');"><img src="images/emotion2/010.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo33:');"><img src="images/emotion2/011.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo34:');"><img src="images/emotion2/012.gif" border="0"></a>&nbsp; <br>
																		<a href="javascript:emoticon(':emo35:');"><img src="images/emotion2/013.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo36:');"><img src="images/emotion2/014.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo37:');"><img src="images/emotion2/015.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo38:');"><img src="images/emotion2/016.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo39:');"><img src="images/emotion2/017.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo40:');"><img src="images/emotion2/018.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo41:');"><img src="images/emotion2/019.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo42:');"><img src="images/emotion2/020.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo43:');"><img src="images/emotion2/021.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo44:');"><img src="images/emotion2/022.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo45:');"><img src="images/emotion2/023.gif" border="0"></a>&nbsp; <br>
																		<a href="javascript:emoticon(':emo46:');"><img src="images/emotion2/024.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo47:');"><img src="images/emotion2/025.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo48:');"><img src="images/emotion2/026.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo49:');"><img src="images/emotion2/027.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo50:');"><img src="images/emotion2/028.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo51:');"><img src="images/emotion2/029.gif" border="0"></a>&nbsp;
																		<a href="javascript:emoticon(':emo52:');"><img src="images/emotion2/030.gif" border="0"></a>&nbsp;
																		&nbsp;&nbsp;&nbsp;<a href="javascript:closeemotion();">ปิด</a>
																	</td>
																</tr>
															</table>
														</div>
														<a href="javascript:setsmile('[---]')"><img src="images/icon/indent.gif" border="0" alt="ย่อหน้า"></a>
														<a href="javascript:setLeft()"><img src="images/icon/left.gif" border="0" alt="จัดซ้าย"></a>
														<a href="javascript:setCenter()"><img src="images/icon/center.gif" border="0" alt="จัดกลาง"></a>
														<a href="javascript:setRight()"><img src="images/icon/right.gif" border="0" alt="จัดขวา"></a>
														<a href="javascript:setBold()"><img src="images/icon/b.gif" border="0" alt="ตัวหนา"></a>
														<a href="javascript:setItalic()"><img src="images/icon/i.gif" border="0" alt="ตัวเอียง"></a>
														<a href="javascript:setUnderline()"><img src="images/icon/u.gif" border="0" alt="เส้นใต้"></a>
														<a href="javascript:setsup()"><img src="images/icon/sup.gif" border="0" alt="ตัวยก"></a>
														<a href="javascript:setsub()"><img src="images/icon/sub.gif" border="0" alt="ตัวห้อย"></a>
														<a href="javascript:setglow()"><img src="images/icon/glow.gif" border="0" alt="ตัวหนังสือเรืองแสง"></a>
														<a href="javascript:setshadow()"><img src="images/icon/shadow.gif" border="0" alt="ตัวหนังสือมีเงา"></a>
														<a href="javascript:setColor('#FF0000','แดง')"><img src="images/icon/redcolor.gif" border="0" alt="สีแดง"></a>
														<a href="javascript:setColor('#009900','เขียว')"><img src="images/icon/greencolor.gif" border="0" alt="สีเขียว"></a>
														<a href="javascript:setColor('#0000FF','น้ำเงิน')"><img src="images/icon/bluecolor.gif" border="0" alt="สีน้ำเงิน"></a>
														<a href="javascript:setColor('#FF6600','ส้ม')"><img src="images/icon/orangecolor.gif" border="0" alt="สีส้ม"></a>
														<a href="javascript:setColor('#FF00FF','ชมพู')"><img src="images/icon/pinkcolor.gif" border="0" alt="สีชมพู"></a>
														<a href="javascript:setColor('#999999','เทา')"><img src="images/icon/graycolor.gif" border="0" alt="สีเทา"></a>
														<br>
														<a href="javascript:setsmile('[quote][/quote]')"><img src="images/icon/quote.gif" border="0" alt="อ้างอิงคำพูด"></a>
														<a href="javascript:setWinamp()"><img src="images/icon/winamp.gif" border="0" alt="เพิ่มเพลง"></a>
														<a href="javascript:setVideo()"><img src="images/icon/video.gif" border="0" alt="เพิ่มวีดีโอคลิป"></a>
														<a href="javascript:setImage()"><img src="images/icon/tree.gif" border="0" alt="เพิ่มรูปภาพ"></a>
														<a href="javascript:setFlash('')"><img src="images/icon/flash.gif" border="0" alt="เพิ่มไฟล์ Flash"></a>
														<a href="javascript:setlink()"><img src="images/icon/link.gif" border="0" alt="เพิ่มลิงก์"></a>
														<a href="javascript:setEmail()"><img src="images/icon/email.gif" border="0" alt="เพิ่มอีเมล์"></a>
													</td>
												</tr>
												<tr>
													<td width="80" align="right" valign="top"><b>ความคิดเห็น : </b></td>
													<td><TEXTAREA id="COMMENT" name="COMMENT" ROWS="7" COLS="5" style="width:300"></TEXTAREA></td>
												</tr>
												<tr>
													<td width="80" align="right" valign="top"></td>
													<td><input type="submit" value=" แสดงความคิดเห็น "><br>
														<br>กรุณาใช้คำพูดที่สุภาพ และอย่าใช้คำพูดที่พาดพิงถึงบุคคลอื่นให้เสียหาย ขอขอบคุณที่ให้ความร่วมมือ
													</td>
												</tr>
											</table>
										</form>
									</td>
								</tr>
							</TBODY>
						</table>
						<br>
						<br>
						ข้อความที่ท่านได้อ่าน เกิดจากการเขียนโดยสาธารณชน และส่งขึ้นมาแบบอัตโนมัติ เจ้าของระบบไม่รับผิดชอบต่อข้อความใดๆทั้งสิ้น เพราะไม่สามารถระบุได้ว่าเป็นความจริงหรือ ชื่อผู้เขียนที่ได้เห็นคือชื่อจริง ผู้อ่านจึงควรใช้วิจารณญาณในการกลั่นกรอง และถ้าท่านพบเห็นข้อความใดที่ขัดต่อกฎหมายและศีลธรรม กรุณาแจ้งที่ <a href="mailto:mocyc@hotmail.com">mocyc@hotmail.com</A> เพื่อให้ผู้ควบคุมระบบทราบและทำการลบข้อความนั้น ออกจากระบบต่อไป
						<br><br>
							<!-- End Enable Comment -->
							<?php
						}
						?>

						<!-- End News -->
					</td>
				</tr>
			</TBODY>
		</table>
<script type="text/javascript">
function setURL(){
	var temp = window.prompt('ใส่ URL ที่คุณต้องการสร้างเป็นลิงค์','http://');
	if(temp) setsmile('[url]'+temp+'[/url]');
}
function setImage(){
	var temp = window.prompt('ใส่ URL ของรูปที่คุณต้องการให้แสดง','http://');
	if(temp) setsmile('[img]'+temp+'[/img]');
}
function setBold(){
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวหนา','');
	if(temp) setsmile('[b]'+temp+'[/b]');
}
function setLeft(){
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการจัดซ้าย','');
	if(temp) setsmile('[left]'+temp+'[/left]');
}
function setCenter(){
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการจัดกลาง','');
	if(temp) setsmile('[center]'+temp+'[/center]');
}
function setRight(){
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการจัดขวา','');
	if(temp) setsmile('[right]'+temp+'[/right]');
}
function setsup(){
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวยก','');
	if(temp) setsmile('[sup]'+temp+'[/sup]');
}
function setsub(){
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวห้อย','');
	if(temp) setsmile('[sub]'+temp+'[/sub]');
}
function setglow(){
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวเรืองแสง');
	if(temp) setsmile('[glow]'+temp+'[/glow]');
}
function setshadow(){
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวอักษรมีเงา','');
	if(temp) setsmile('[shadow]'+temp+'[/shadow]');
}
function setItalic(){
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวเอียง','');
	if(temp) setsmile('[i]'+temp+'[/i]');
}
function setUnderline(){
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการให้มีเส้นใต้','');
	if(temp) setsmile('[u]'+temp+'[/u]');
}
function setColor(color,name){
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการให้เป็นสี'+name,'');
	if(temp) setsmile('[color='+color+']'+temp+'[/color]');
}
function setWinamp(){
	var temp = window.prompt('ใส่ URL ของไฟล์เพลงที่ท่านต้องการแทรกในข้อความของท่าน','http://');
	if(temp) setsmile('[media]'+temp+'[/media]');
}
function setVideo(){
	var temp = window.prompt('ใส่ URL ของไฟล์วีดีโอคลิปที่ท่านต้องการแทรกในข้อความของท่าน','http://');
	if(temp) setsmile('[movie]'+temp+'[/movie]');
}
function setlink(){
	var temp = window.prompt('ใส่ URL ของเว็บไซต์ที่ต้องการทำลิงก์','http://');
	if(temp) setsmile('[url]'+temp+'[/url]');
}
function setEmail(){
	var temp = window.prompt('ใส่ อีเมล์ของท่าน','');
	if(temp) setsmile('[email]'+temp+'[/email]');
}
function setFlash(){
	var temp = window.prompt('ใส่ URL ของไฟล์ Flash ที่ท่านต้องการนำมาแสดง','http://');
	if(temp) setsmile('[flash=200,200]'+temp+'[/flash]');
}
function setsmile(str){
	var comment = document.getElementById('COMMENT');
	comment.value = comment.value+' '+str;
	comment.focus();
}
</script>
