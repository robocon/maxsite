    <TABLE cellSpacing=0 cellPadding=0 width=720 border=0>
      <TBODY>
        <TR>
          <TD width="10" vAlign=top><IMG src="images/fader.gif" border=0></TD>
          <TD width="710" vAlign=top><IMG src="images/topfader.gif" border=0><BR>
		  <!-- Admin -->
		  &nbsp;&nbsp;<IMG SRC="images/menu/textmenu_admin.gif" BORDER="0"><BR>
				<TABLE width="700" align=center cellSpacing=0 cellPadding=0 border=0>
				<TR>
					<TD height="1" class="dotline"></TD>
				</TR>
				<TR>
					<TD>
<?
//Check Admin
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
$res[admin] = $db->select_query("SELECT * FROM ".TB_ADMIN." WHERE username='".$_POST[username]."' AND password='".md5($_POST[password])."'  "); 
$rows[admin] = $db->rows($res[admin]); 
if($rows[admin]){
	$arr[admin] = $db->fetch($res[admin]);
}
$db->closedb ();
if(USE_CAPCHA){
	if($_SESSION['security_code'] != $_POST['security_code'] OR empty($_POST['security_code'])) {
		echo "<script language='javascript'>" ;
		echo "alert('!!!! กรุณากรอกโค๊ดให้ถูกต้อง !!!!')" ;
		echo "</script>" ;
		echo "<script language='javascript'>javascript:history.go(-1)</script>";
		exit();
	}
}

//Can Login
if($arr[admin][id]){
	//Login ผ่าน
	ob_start();
	$_SESSION['admin_user'] = $_POST[username] ;
	$_SESSION['admin_pwd'] = md5($_POST[password]) ;
	session_write_close();
	ob_end_flush();
?>
<BR><BR>
<CENTER><A HREF="?name=admin&file=main"><IMG SRC="images/icon/login-welcome.gif" BORDER="0"></A><BR><BR>
<FONT COLOR="#336600"><B>ได้ทำการเข้าระบบเรียบร้อยแล้ว</B></FONT><BR><BR>
<A HREF="?name=admin&file=main"><B>เข้าหน้าหลักผู้ดูแลระบบ</B></A>
</CENTER>
<BR><BR>
<?
}else{
	//Login ไม่ผ่าน
?>
					<BR><BR>
					<CENTER><B><FONT COLOR="#FF0000">ชื่อผู้ใช้ หรือ รหัสผ่าน ไม่ถูกต้อง กรุณาตรวจสอบ</FONT></B></CENTER>
					<FORM METHOD=POST ACTION="?name=admin&file=login">
					<TABLE width=300 align=center>
					<TR>
						<TD width="100" align="right"><B>ชื่อผู้ใช้ : </B></TD>
						<TD><INPUT TYPE="text" NAME="username"></TD>
					</TR>
					<TR>
						<TD width="100" align="right"><B>รหัสผ่าน : </B></TD>
						<TD><INPUT TYPE="password" NAME="password"></TD>
					</TR>
<?
if(USE_CAPCHA){
?>
					<TR>
						<TD width="100" align="right">
						<?if(CAPCHA_TYPE == 1){ 
							echo "<img src=\"capcha/CaptchaSecurityImages.php?width=".CAPCHA_WIDTH."&height=".CAPCHA_HEIGHT."&characters=".CAPCHA_NUM."\" width=\"".CAPCHA_WIDTH."\" height=\"".CAPCHA_HEIGHT."\" align=\"absmiddle\" />";
						}else if(CAPCHA_TYPE == 2){ 
							echo "<img src=\"capcha/val_img.php?width=".CAPCHA_WIDTH."&height=".CAPCHA_HEIGHT."&characters=".CAPCHA_NUM."\" width=\"".CAPCHA_WIDTH."\" height=\"".CAPCHA_HEIGHT."\" align=\"absmiddle\" />";
						};?>
						</TD>
						<TD><input name="security_code" type="text" id="security_code" maxlength="6" ></TD>
					</TR>
<?
}
?>
					<TR>
						<TD width="100" align="right"></TD>
						<TD><INPUT TYPE="submit" VALUE=" เข้าระบบ "></TD>
					</TR>
					</TABLE>
					</FORM>
<?
}
?>
					</TD>
				</TR>
			</TABLE>
			<BR><BR>
			<!-- Admin -->
		  </TD>
        </TR>
      </TBODY>
    </TABLE>