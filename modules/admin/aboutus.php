<?php 
CheckAdmin($_SESSION['admin_user'], $_SESSION['admin_pwd']);

if($_GET[op] == "aboutus_edit"){
	if(CheckLevel($_SESSION['admin_user'],$_GET[op])){
		//ทำการแก้ไขไฟล์ text ของ aboutus
		$Filename = "aboutus.html";
		$txt_name = "aboutus/".$Filename."";
		$txt_open = @fopen("$txt_name", "w");
		@fwrite($txt_open, "".$_POST[EDITORTALK]."");
		@fclose($txt_open);
		$ProcessOutput .= "<BR><BR>";
		$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
		$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ได้ทำการแก้ไข Aboutus เรียบร้อยแล้ว</B></FONT><BR><BR>";
		$ProcessOutput .= "<A HREF=\"?name=admin&file=main\"><B>หน้าหลักผู้ดูแลระบบ</B></A>";
		$ProcessOutput .= "</CENTER>";
		$ProcessOutput .= "<BR><BR>";
	}else{
		$ProcessOutput = $PermissionFalse ;
	}
}

//อ่านค่าจากไฟล์ Text เพื่อแก้ไข
$FileNewsTopic = "aboutus/aboutus.html";
$file_open = @fopen($FileNewsTopic, "r");
$TextContent = @fread ($file_open, @filesize($FileNewsTopic));
@fclose ($file_open);
$TextContent = stripslashes($TextContent);

?>
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
					<BR><B><IMG SRC="images/icon/plus.gif" BORDER="0" ALIGN="absmiddle"> <A HREF="?name=admin&file=main">หน้าหลักผู้ดูแลระบบ</A> &nbsp;&nbsp;<IMG SRC="images/icon/arrow_wap.gif" BORDER="0" ALIGN="absmiddle">&nbsp;&nbsp; เกี่ยวกับเรา</B>
					<BR><BR>
<?php 
if(!$ProcessOutput){
?>
						<FORM NAME="myform" METHOD=POST ACTION="?name=admin&file=aboutus&op=aboutus_edit">
						<BR>
						<B>ข้อความ :</B><BR>
<?php 
include("FCKeditor/fckeditor.php") ;
$oFCKeditor = new FCKeditor('EDITORTALK') ;
$oFCKeditor->BasePath	= 'FCKeditor/' ;
$oFCKeditor->Width	= '100%' ;
$oFCKeditor->Height	= '500' ;
$oFCKeditor->Value		= $TextContent ;
$oFCKeditor->Create() ;
?>
						<input type="submit" value=" แก้ไข " name="submit"> <input type="reset" value=" เคลีย " name="reset">
						</FORM>
<?php 
}else{
	echo $ProcessOutput ;
}
?>
						<BR><BR>
					</TD>
				</TR>
			</TABLE>
			<BR><BR>
			<!-- Admin -->
		  </TD>
        </TR>
      </TBODY>
    </TABLE>