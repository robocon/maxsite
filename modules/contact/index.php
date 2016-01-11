    <TABLE cellSpacing=0 cellPadding=0 width=720 border=0>
      <TBODY>
        <TR>
          <TD width="10" vAlign=top><IMG src="images/fader.gif" border=0></TD>
          <TD width="710" vAlign=top><IMG src="images/topfader.gif" border=0><BR>
		  <!-- About us -->
		  &nbsp;&nbsp;<IMG SRC="images/menu/textmenu_contact.gif" BORDER="0"><BR>
				<TABLE width="700" align=center cellSpacing=0 cellPadding=0 border=0>
				<TR>
					<TD height="1" class="dotline"></TD>
				</TR>
				<TR>
					<TD>
					<BR>
<?php 
if($_GET[action] == "sendmail"){
	if(!$_POST[SUBJECT] OR !$_POST[YOURMAIL] OR !$_POST[DETAIL]){
		$Process .= "<CENTER><FONT SIZE=\"3\" COLOR=\"#FF0000\"><B>ท่านกรอกข้อมูลในการติดต่อไม่ครบถ้วน</B></FONT></CENTER><BR>";
	}
	if(!eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*"."@([a-z0-9]+([\.-][a-z0-9]{1,})+)*$",$_POST[YOURMAIL])){
		$Process .= "<CENTER><FONT SIZE=\"3\" COLOR=\"#FF0000\"><B>ท่านกรอกอีเมล์ของท่านไม่ถูกต้อง</B></FONT></CENTER><BR>";
	}
	if(USE_CAPCHA){
		if($_SESSION['security_code'] != $_POST['security_code'] OR empty($_POST['security_code'])) {
			$Process .= "<CENTER><FONT SIZE=\"3\" COLOR=\"#FF0000\"><B>!!!! กรุณากรอกโค๊ดให้ถูกต้อง !!!!</B></FONT></CENTER><BR>";
		}
	}
	if(!$Process){
		SendMail("Tis-620","".WEB_EMAIL."","","".$_POST[YOURMAIL]."","".$_POST[SUBJECT]."","".$_POST[DETAIL]."");
		$Process .= "<BR><BR><CENTER><IMG SRC=\"images/icon/mail.gif\" BORDER=\"0\" ><BR><BR><FONT SIZE=\"3\" COLOR=\"#009900\"><B>ได้ทำการส่งข้อความของท่านเรียบร้อยแล้ว</B></FONT></CENTER><BR><BR>";
		$Complete = True;
	}
}

echo $Process ;

if(!$Complete){
?>
					<FORM METHOD=POST ACTION="?name=contact&action=sendmail">
					<TABLE width="80%" align="center">
					<TR>
						<TD align="right"><B>หัวข้อ : </B></TD>
						<TD><INPUT TYPE="text" NAME="SUBJECT" size="40" value="<?=$_POST[SUBJECT];?>"></TD>
					</TR>
					<TR>
						<TD align="right"><B>อีเมล์ของท่าน : </B></TD>
						<TD><INPUT TYPE="text" NAME="YOURMAIL" size="40" value="<?=$_POST[YOURMAIL];?>"></TD>
					</TR>
					<TR>
						<TD align="right" valign="top"><B>ข้อความ : </B></TD>
						<TD><TEXTAREA NAME="DETAIL" ROWS="5" COLS="40"><?=$_POST[DETAIL];?></TEXTAREA></TD>
					</TR>
<?php 
if(USE_CAPCHA){
?>
					<TR>
						<TD align="right">
						<?php if(CAPCHA_TYPE == 1){ 
							echo "<img src=\"capcha/CaptchaSecurityImages.php?width=".CAPCHA_WIDTH."&height=".CAPCHA_HEIGHT."&characters=".CAPCHA_NUM."\" width=\"".CAPCHA_WIDTH."\" height=\"".CAPCHA_HEIGHT."\" align=\"absmiddle\" />";
						}else if(CAPCHA_TYPE == 2){ 
							echo "<img src=\"capcha/val_img.php?width=".CAPCHA_WIDTH."&height=".CAPCHA_HEIGHT."&characters=".CAPCHA_NUM."\" width=\"".CAPCHA_WIDTH."\" height=\"".CAPCHA_HEIGHT."\" align=\"absmiddle\" />";
						};?>
						</TD>
						<TD><input name="security_code" type="text" id="security_code" size="20" maxlength="6" style="width:80" > ใส่รหัสที่ท่านเห็นลงในช่องนี้ </TD>
					</TR>
<?php 
}
?>
					<TR>
						<TD align="right" valign="top"><B></B></TD>
						<TD><INPUT TYPE="submit" value=" ส่งอีเมล์ "> <INPUT TYPE="reset" value=" เคลีย "></TD>
					</TR>
					</TABLE>
					</FORM>
<?php 
}
?>
					<BR><BR>
					</TD>
				</TR>
			</TABLE>
			<BR><BR>
			<!-- About us -->
		  </TD>
        </TR>
      </TBODY>
    </TABLE>