<?
$_GET['id'] = intval($_GET['id']);
//ดึงข้อมูลกระทู้ 
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
$VIEWBOARD = $db->fetch($db->select_query("SELECT * FROM ".TB_WEBBOARD." WHERE id = '".$_GET[id]."' "));
$db->closedb ();
//กรณีไม่มีรายการกระทู้ 
NotTrueAlert($VIEWBOARD[id], "3", "ไม่มีรายการกระทู้ที่ท่านต้องการเข้าชม");

//Post Action
if($_GET[action] == "comment"){
	//Check data
	if(!$_POST[topic] OR !$_POST[detail] OR !$_POST[post_name] OR !$_GET[id]){
		echo "<script language='javascript'>" ;
		echo "alert('ท่านกรอกข้อมูลไม่ครบถ้วน กรุณาตรวจสอบ')" ;
		echo "</script>" ;
		echo "<script language='javascript'>javascript:history.go(-1)</script>";
		exit();
	}
	if(USE_CAPCHA){
		if($_SESSION['security_code'] != $_POST['security_code'] OR empty($_POST['security_code'])) {
			echo "<script language='javascript'>" ;
			echo "alert('!!!! กรุณากรอกโค๊ดให้ถูกต้อง !!!!')" ;
			echo "</script>" ;
			echo "<script language='javascript'>javascript:history.go(-1)</script>";
			exit();
		}
	}
	//เช็คแบนโฆษณา
	checkban($_POST[topic]);
	checkban($_POST[detail]);
	checkban($_POST[post_name]);
	//Check Pic Size
	$FILE = $_FILES['FILE'];
	if ( $FILE['size'] > _WEBBOARD_LIMIT_UPLOAD ) {
		echo "<script language='javascript'>" ;
		echo "alert('ขนาดรูปที่แนบมามีขนาดเกิน ".(_WEBBOARD_LIMIT_UPLOAD/1024)." kB กรุณาตรวจสอบรูปภาพของท่าน')" ;
		echo "</script>" ;
		echo "<script language='javascript'>javascript:history.back()</script>";
		exit();
	}
	//แปลงนามสกุล และทำการ upload
	if ( $FILE['type'] == "image/gif" )
			{$Filename = TIMESTAMP.".gif";}
	if ( $FILE['type'] == "image/png" )
			{$Filename = TIMESTAMP.".png";}
	elseif (($FILE['type']=="image/jpg")||($FILE['type']=="image/jpeg")||($FILE['type']=="image/pjpeg"))
			{$Filename = TIMESTAMP.".jpg";}
	@copy ($FILE['tmp_name'] , "webboard_upload/".$Filename );
	//Check Member
	if($_SESSION['max_user']){$ISMember = $_SESSION['max_id'];}else{$ISMember = "";}
	//Add Topic
	$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
	$db->add_db(TB_WEBBOARD_COMMENT,array(
		"topic_id"=>"".$_GET[id]."",
		"detail"=>"".htmlspecialchars($_POST[detail])."",
		"picture"=>"$Filename",
		"post_name"=>"".htmlspecialchars($_POST[post_name])."",
		"is_member"=>"$ISMember",
		"ip_address"=>"".IPADDRESS."",
		"post_date"=>"".TIMESTAMP."",
	)); 
	$PostComplete = True ;
}

//จำนวนคนเข้าชม
$PAGEVIEW = $VIEWBOARD[pageview]+1 ;
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
$db->update(TB_WEBBOARD," pageview='$PAGEVIEW' "," id='$_GET[id]' ");
$db->closedb ();

?>
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

	document.form2.detail.value += ' ' + theSmilie + ' ';
	document.form2.detail.focus();
}
</script>

    <TABLE cellSpacing=0 cellPadding=0 width=720 border=0>
      <TBODY>
        <TR>
          <TD width="10" vAlign=top><IMG src="images/fader.gif" border=0></TD>
          <TD width="710" vAlign=top><IMG src="images/topfader.gif" border=0><BR>
		  <!-- Webboard -->
		  &nbsp;&nbsp;<IMG SRC="images/menu/textmenu_webboard.gif" BORDER="0"><BR>

<?
//แสดงผลการPost 
if($PostComplete){
	//Complete
?>
<BR><BR>
<TABLE width=90% align=center>
<TR>
	<TD><CENTER><IMG SRC="images/post_complete.png" BORDER="0"></CENTER></TD>
</TR>
<TR><TD height=1 class="dotline"></TD></TR>
<TR>
	<TD><CENTER><B>ข้อมูลความคิดเห็นได้ทำการเพิ่มเรียบร้อยแล้ว</B><BR><BR>
	<A HREF="?name=webboard&file=read&id=<?=$_GET[id];?>">คลิกที่นี่เพื่อดูรายละเอียดกระทู้</A>
	</CENTER></TD>
</TR>
<TR><TD height=1 class="dotline"></TD></TR>
</TABLE><BR><BR>
<?
}else{
	//Not Complete
?>
				<TABLE width="700" align=center cellSpacing=0 cellPadding=0 border=0>
				<TR>
					<TD>
					<B><FONT COLOR="#990000"><?=$VIEWBOARD[topic];?></FONT></B>
					<BR>
					<B>โดย : </B>
				<?//กรณีสมาชิก
					if($VIEWBOARD[is_member]){
						echo "<IMG SRC=\"images/human.gif\" BORDER=\"0\" ALIGN=\"absmiddle\"> ";
					}else{ };
				?>
					<?=$VIEWBOARD[post_name];?> &nbsp; <B>เมื่อวันที่ : </B><?= ThaiTimeConvert($VIEWBOARD[post_date],"1","");?> &nbsp;&nbsp;
<?
if($_SESSION['admin_user']){
	if($VIEWBOARD[pin_date]){
		echo "<A HREF=\"javascript:Confirm('?name=webboard&file=pin_topic&action=removepin&id=".$_GET[id]."','คุณมั่นใจในการลบกระทู้นี้ออกจากการปักหมุด ?');\"><IMG SRC=\"images/admin/pin.gif\" WIDTH=\"16\" HEIGHT=\"16\" BORDER=\"0\" ALIGN=\"absmiddle\"> ยกเลิกปักหมุด </A>&nbsp;&nbsp;&nbsp;";
	}else{
		echo "<A HREF=\"javascript:Confirm('?name=webboard&file=pin_topic&action=addpin&id=".$_GET[id]."','คุณมั่นใจในการปักหมุดให้กระทู้นี้ ?');\"><IMG SRC=\"images/admin/pin.gif\" WIDTH=\"16\" HEIGHT=\"16\" BORDER=\"0\" ALIGN=\"absmiddle\"> ทำการปักหมุด </A>&nbsp;&nbsp;&nbsp;";
	}
	echo " <A HREF=\"javascript:Confirm('?name=webboard&file=delete_topic&id=".$_GET[id]."','คุณมั่นใจในการลบกระทู้นี้ ?');\"><IMG SRC=\"images/admin/trash.gif\" WIDTH=\"20\" HEIGHT=\"20\" BORDER=\"0\" ALIGN=\"absmiddle\"> ลบกระทู้นี้ </A>";
};
?>
					<BR><BR>
					</TD>
				</TR>
				<TR>
					<TD height="1" class="dotline"></TD>
				</TR>
				<TR>
					<TD>
					<BR>
					<?
					//Show Picture
					if($VIEWBOARD[picture]){
						$postpicupload = @getimagesize ("webboard_upload/".$VIEWBOARD[picture]."");
						if ( $postpicupload[0] > _WEBBOARD_LIMIT_PICWIDTH ) {
							$PicUpload = "<BR><CENTER><img src='webboard_upload/".$VIEWBOARD[picture]."' width='"._WEBBOARD_LIMIT_PICWIDTH."' border='0' ><BR></CENTER><BR>";
							}else{
							$PicUpload = "<BR><CENTER><img src='webboard_upload/".$VIEWBOARD[picture]."' border='0' ><BR></CENTER><BR>";
							}
						echo $PicUpload ;
					}else{ };
					?>
					<?=(banword(CHANGE_EMOTICON(BBCODE($VIEWBOARD[detail]))));?>
					<BR><BR>
					เข้าชม : <?=$VIEWBOARD[pageview];?> 
					<BR><BR>
					</TD>
				</TR>
				<TR>
					<TD height="1" class="dotline"></TD>
				</TR>
			</TABLE>


<?
//ดึงรายการความคิดเห็น
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
$res[comment] = $db->select_query("SELECT * FROM ".TB_WEBBOARD_COMMENT." WHERE topic_id = '".$_GET[id]."' ORDER BY id ");
$count=0;
while($arr[comment] = $db->fetch($res[comment])){
	$count  ++;
?>
<BR>
			<TABLE cellSpacing=5 cellPadding=0 width=550 border=0 align="center" class="tablecomment">
			<TR>
				<TD><B><FONT COLOR="#990000">ความคิดเห็นที่ <?=$count;?></FONT></B>
				<?if($_SESSION['admin_user']){echo " <A HREF=\"javascript:Confirm('?name=webboard&file=delete_comment&id=".$_GET[id]."&comment=".$arr[comment][id]."','คุณมั่นใจในการลบความคิดเห็นนี้ ?');\"><IMG SRC=\"images/admin/trash.gif\" WIDTH=\"20\" HEIGHT=\"20\" BORDER=\"0\" ALIGN=\"absmiddle\"></A>";};?>
				<BR><?= ThaiTimeConvert($arr[comment][post_date],"1","1");?>
				</TD>
			</TR>
			<TR>
				<TD height="1" class="dotline"></TD>
			</TR>
			<TR>
				<TD>
<?
//Show Picture
if($arr[comment][picture]){
	$postpicupload = @getimagesize ("webboard_upload/".$arr[comment][picture]."");
	if ( $postpicupload[0] > _WEBBOARD_LIMIT_PICWIDTH ) {
		$PicUpload = "<BR><CENTER><img src='webboard_upload/".$arr[comment][picture]."' width='"._WEBBOARD_LIMIT_PICWIDTH."' border='0' ><BR></CENTER><BR>";
		}else{
		$PicUpload = "<BR><CENTER><img src='webboard_upload/".$arr[comment][picture]."' border='0' ><BR></CENTER><BR>";
		}
	echo $PicUpload ;
}else{ };
?>
<?=(banword(CHANGE_EMOTICON(BBCODE($arr[comment][detail]))));?></TD>
			</TR>
			<TR>
				<TD height="1" class="dotline"></TD>
			</TR>
			<TR>
				<TD><B><FONT COLOR="#990000">โดย : </FONT></B> <?=$arr[comment][post_name];?> &nbsp;&nbsp; <FONT COLOR="#990000"><B>ไอพี : </B></FONT><?=$arr[comment][ip_address];?>
				</TD>
			</TR>
			</TABLE>
			<BR>
<?
}
$db->closedb ();
?>
<BR><BR>

			<TABLE cellSpacing=0 cellPadding=0 width=550 border=0 align="center">
			  <TBODY>
				<TR>
				  <TD width="10" vAlign=top><IMG src="images/fader.gif" border=0></TD>
				  <TD width="490" vAlign=top><IMG src="images/topfader.gif" border=0><BR>
				  <IMG SRC="images/menu/textmenu_comment.gif" BORDER="0"><BR>

<FORM name="form2" METHOD=POST ACTION="?name=webboard&file=read&action=comment&id=<?=$_GET[id];?>" enctype="multipart/form-data" >
<TABLE width="95%" align="center">
<TR>
	<TD width=150 align=right><B>Re หัวข้อ : </B></TD>
	<TD><INPUT TYPE="text" NAME="topic" style="width:300" class="inputform" value="<?=$VIEWBOARD[topic];?>" readonly style="color: #FF0000"></TD>
</TR>
<TR><TD colspan=2 height=1 class="dotline"></TD></TR>
<?
//กรณี โพสรูปได้ 
if(_ENABLE_BOARD_UPLOAD){
?>
<TR>
	<TD width=150 align=right><B>รูปประกอบ : </B></TD>
	<TD><input type="file" name="FILE" style="width:250" class="inputform"> Limit <?=(_WEBBOARD_LIMIT_UPLOAD/1024);?> kB</TD>
</TR>
<TR><TD colspan=2 height=1 class="dotline"></TD></TR>
<?
}
?>
<TR>
	<TD width=150 align=right><B>ไอคอน : </B></TD>
	<TD>
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
<a href="javascript:emoticon(':emo12:');"><img src="images/emotion/lightbulb.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo13:');"><img src="images/emotion/omg_smile.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo14:');"><img src="images/emotion/regular_smile.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo15:');"><img src="images/emotion/sad_smile.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo16:');"><img src="images/emotion/shades_smile.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo17:');"><img src="images/emotion/teeth_smile.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo18:');"><img src="images/emotion/thumbs_down.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo19:');"><img src="images/emotion/thumbs_up.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo20:');"><img src="images/emotion/tounge_smile.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo21:');"><img src="images/emotion/whatchutalkingabout_smile.gif" border="0"></a>&nbsp; <a href="javascript:emoticon(':emo22:');"><img src="images/emotion/wink_smile.gif" border="0"></a>&nbsp;<BR>
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
<a href="javascript:emoticon(':emo34:');"><img src="images/emotion2/012.gif" border="0"></a>&nbsp; <BR>
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
<a href="javascript:emoticon(':emo45:');"><img src="images/emotion2/023.gif" border="0"></a>&nbsp; <BR>
<a href="javascript:emoticon(':emo46:');"><img src="images/emotion2/024.gif" border="0"></a>&nbsp; 
<a href="javascript:emoticon(':emo47:');"><img src="images/emotion2/025.gif" border="0"></a>&nbsp; 
<a href="javascript:emoticon(':emo48:');"><img src="images/emotion2/026.gif" border="0"></a>&nbsp; 
<a href="javascript:emoticon(':emo49:');"><img src="images/emotion2/027.gif" border="0"></a>&nbsp; 
<a href="javascript:emoticon(':emo50:');"><img src="images/emotion2/028.gif" border="0"></a>&nbsp; 
<a href="javascript:emoticon(':emo51:');"><img src="images/emotion2/029.gif" border="0"></a>&nbsp; 
<a href="javascript:emoticon(':emo52:');"><img src="images/emotion2/030.gif" border="0"></a>&nbsp; 
&nbsp;&nbsp;&nbsp;<a href="javascript:closeemotion();">ปิด</a> </td>
                      </tr>
                    </table>
                  </div>

<script language="JavaScript">
function setURL()
{
	var temp = window.prompt('ใส่ URL ที่คุณต้องการสร้างเป็นลิงค์','http://'); 
	if(temp) setsmile('[url]'+temp+'[/url]');
}

function setImage()
{
	var temp = window.prompt('ใส่ URL ของรูปที่คุณต้องการให้แสดง','http://'); 
	if(temp) setsmile('[img]'+temp+'[/img]');
}

function setBold()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวหนา',''); 
	if(temp) setsmile('[b]'+temp+'[/b]');
}
function setLeft()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการจัดซ้าย',''); 
	if(temp) setsmile('[left]'+temp+'[/left]');
}
function setCenter()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการจัดกลาง',''); 
	if(temp) setsmile('[center]'+temp+'[/center]');
}
function setRight()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการจัดขวา',''); 
	if(temp) setsmile('[right]'+temp+'[/right]');
}
function setsup()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวยก',''); 
	if(temp) setsmile('[sup]'+temp+'[/sup]');

}
function setsub()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวห้อย',''); 
	if(temp) setsmile('[sub]'+temp+'[/sub]');
}
function setglow()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวเรืองแสง',''); 
	if(temp) setsmile('[glow]'+temp+'[/glow]');
}
function setshadow()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวอักษรมีเงา',''); 
	if(temp) setsmile('[shadow]'+temp+'[/shadow]');
}
function setItalic()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวเอียง',''); 
	if(temp) setsmile('[i]'+temp+'[/i]');
}

function setUnderline()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการให้มีเส้นใต้',''); 
	if(temp) setsmile('[u]'+temp+'[/u]');
}

function setColor(color,name)
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการให้เป็นสี'+name,''); 
	if(temp) setsmile('[color='+color+']'+temp+'[/color]');
}
function setWinamp()
{
	var temp = window.prompt('ใส่ URL ของไฟล์เพลงที่ท่านต้องการแทรกในข้อความของท่าน','http://'); 
	if(temp) setsmile('[media]'+temp+'[/media]');
}
function setVideo()
{
	var temp = window.prompt('ใส่ URL ของไฟล์วีดีโอคลิปที่ท่านต้องการแทรกในข้อความของท่าน','http://'); 
	if(temp) setsmile('[movie]'+temp+'[/movie]');
}
function setlink()
{
	var temp = window.prompt('ใส่ URL ของเว็บไซต์ที่ต้องการทำลิงก์','http://'); 
	if(temp) setsmile('[url]'+temp+'[/url]');
}
function setEmail()
{
	var temp = window.prompt('ใส่ อีเมล์ของท่าน',''); 
	if(temp) setsmile('[email]'+temp+'[/email]');
}
function setFlash()
{
	var temp = window.prompt('ใส่ URL ของไฟล์ Flash ที่ท่านต้องการนำมาแสดง','http://'); 
	if(temp) setsmile('[flash=200,200]'+temp+'[/flash]');
}

function setsmile(what)
{
	document.form2.detail.value = document.form2.elements.detail.value+" "+what;
	document.form2.detail.focus();
}
</script>
<a href="javascript:setsmile('[---]')"><img src="images/icon/indent.gif" border=0 alt="ย่อหน้า"></a> 
<a href="javascript:setLeft()"><img src="images/icon/left.gif" border=0 alt="จัดซ้าย"></a> 
<a href="javascript:setCenter()"><img src="images/icon/center.gif" border=0 alt="จัดกลาง"></a> 
<a href="javascript:setRight()"><img src="images/icon/right.gif" border=0 alt="จัดขวา"></a> 
                            <a href="javascript:setBold()"><img src="images/icon/b.gif" border=0 alt="ตัวหนา"></a> 
                            <a href="javascript:setItalic()"><img src="images/icon/i.gif" border=0 alt="ตัวเอียง"></a> 
                            <a href="javascript:setUnderline()"><img src="images/icon/u.gif" border=0 alt="เส้นใต้"></a> 
                            <a href="javascript:setsup()"><img src="images/icon/sup.gif" border=0 alt="ตัวยก"></a> 
                            <a href="javascript:setsub()"><img src="images/icon/sub.gif" border=0 alt="ตัวห้อย"></a> 
                            <a href="javascript:setglow()"><img src="images/icon/glow.gif" border=0 alt="ตัวหนังสือเรืองแสง"></a> 
                            <a href="javascript:setshadow()"><img src="images/icon/shadow.gif" border=0 alt="ตัวหนังสือมีเงา"></a> 
                            <a href="javascript:setColor('#FF0000','แดง')"><img src="images/icon/redcolor.gif" border=0 alt="สีแดง"></a> 
                            <a href="javascript:setColor('#009900','เขียว')"><img src="images/icon/greencolor.gif" border=0 alt="สีเขียว"></a> 
                            <a href="javascript:setColor('#0000FF','น้ำเงิน')"><img src="images/icon/bluecolor.gif" border=0 alt="สีน้ำเงิน"></a> 
                            <a href="javascript:setColor('#FF6600','ส้ม')"><img src="images/icon/orangecolor.gif" border=0 alt="สีส้ม"></a> 
                            <a href="javascript:setColor('#FF00FF','ชมพู')"><img src="images/icon/pinkcolor.gif" border=0 alt="สีชมพู"></a> 
                            <a href="javascript:setColor('#999999','เทา')"><img src="images/icon/graycolor.gif" border=0 alt="สีเทา"></a>
							<BR><a href="javascript:setsmile('[quote][/quote]')"><img src="images/icon/quote.gif" border=0 alt="อ้างอิงคำพูด"></a>
							<a href="javascript:setWinamp()"><img src="images/icon/winamp.gif" border=0 alt="เพิ่มเพลง"></a> 
							<a href="javascript:setVideo()"><img src="images/icon/video.gif" border=0 alt="เพิ่มวีดีโอคลิป"></a> 
							<a href="javascript:setImage()"><img src="images/icon/tree.gif" border=0 alt="เพิ่มรูปภาพ"></a>
							<a href="javascript:setFlash('')"><img src="images/icon/flash.gif" border=0 alt="เพิ่มไฟล์ Flash"></a>
							<a href="javascript:setlink()"><img src="images/icon/link.gif" border=0 alt="เพิ่มลิงก์"></a>
							<a href="javascript:setEmail()"><img src="images/icon/email.gif" border=0 alt="เพิ่มอีเมล์"></a>
	</TD>
</TR>
<TR><TD colspan=2 height=1 class="dotline"></TD></TR>
<TR>
	<TD width=150 align=right valign=top><IMG SRC="images/bullet.gif" BORDER="0" ALIGN="absmiddle"> <B>รายละเอียด : </B></TD>
	<TD><TEXTAREA NAME="detail" ROWS="10" style="width:350" class="textareaform"></TEXTAREA></TD>
</TR>
<TR><TD colspan=2 height=1 class="dotline"></TD></TR>
<?
if(USE_CAPCHA){
?>
						<TR>
							<TD width=150 align=right>
							<?if(CAPCHA_TYPE == 1){ 
								echo "<img src=\"capcha/CaptchaSecurityImages.php?width=".CAPCHA_WIDTH."&height=".CAPCHA_HEIGHT."&characters=".CAPCHA_NUM."\" width=\"".CAPCHA_WIDTH."\" height=\"".CAPCHA_HEIGHT."\" align=\"absmiddle\" />";
							}else if(CAPCHA_TYPE == 2){ 
								echo "<img src=\"capcha/val_img.php?width=".CAPCHA_WIDTH."&height=".CAPCHA_HEIGHT."&characters=".CAPCHA_NUM."\" width=\"".CAPCHA_WIDTH."\" height=\"".CAPCHA_HEIGHT."\" align=\"absmiddle\" />";
							};?>
							</TD>
							<TD><input name="security_code" type="text" id="security_code" size="20" maxlength="6" style="width:80" > ใส่รหัสที่ท่านเห็นลงในช่องนี้ </TD>
						</TR>
						<TR><TD colspan=2 height=1 class="dotline"></TD></TR>
<?
}
?>
<TR>
	<TD width=150 align=right><IMG SRC="images/bullet.gif" BORDER="0" ALIGN="absmiddle"> <B>ชื่อของท่าน : </B></TD>
	<TD><INPUT TYPE="text" NAME="post_name" style="width:150" class="inputform" <?if($_SESSION['zone_user']){echo "value=\"".$_SESSION['zone_user']."\" readonly style=\"color: #FF0000\" ";};?>></TD>
</TR>
<TR><TD colspan=2 height=1 class="dotline"></TD></TR>
<TR>
	<TD width=150 align=right><B></B></TD>
	<TD><INPUT TYPE="submit" value=" แสดงความเห็น " class="buttonform"></TD>
</TR>
<TR><TD colspan=2 height=1 class="dotline"></TD></TR>
</TABLE>
</FORM>

				  </TD>
				</TR>
			  </TBODY>
			</TABLE>
<?
}
//จบการแสดงผลฟอร์ม Post
?>

  			<BR><BR>
			<!-- webboard -->
		  </TD>
        </TR>
      </TBODY>
    </TABLE>