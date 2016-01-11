<?
CheckAdmin($_SESSION['admin_user'], $_SESSION['admin_pwd']);
?>
	<TABLE cellSpacing=0 cellPadding=0 width=720 border=0>
      <TBODY>
        <TR>
          <TD width="10" vAlign=top><IMG src="images/fader.gif" border=0></TD>
          <TD width="710" vAlign=top><IMG src="images/topfader.gif" border=0><BR>
		  <!-- Pin  -->
		  &nbsp;&nbsp;<IMG SRC="images/menu/textmenu_webboard.gif" BORDER="0"><BR><BR>
				<BR><BR>
<?
	if(CheckLevel($_SESSION['admin_user'],"webboard_edit")){
		$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
		if($_GET[action] == "addpin"){
			$db->update(TB_WEBBOARD," pin_date='".TIMESTAMP."' "," id='$_GET[id]' ");
			$Title = "ปักหมุดกระทู้";
		}else if($_GET[action] == "removepin"){
			$db->update(TB_WEBBOARD," pin_date='' "," id='$_GET[id]' ");
			$Title = "ยกเลิกปักหมุดกระทู้";
		}
		$db->closedb ();
		$ProcessOutput .= "<BR><BR>";
		$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
		$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ได้ทำการ ".$Title." เรียบร้อยแล้ว</B></FONT><BR><BR>";
		$ProcessOutput .= "<A HREF=\"?name=webboard&file=read&id=".$_GET[id]."\"><B>กลับหน้าแสดงผลเว็บบอร์ด</B></A>";
		$ProcessOutput .= "</CENTER>";
		$ProcessOutput .= "<BR><BR>";
	}else{
		//กรณีไม่ผ่าน
		$ProcessOutput = $PermissionFalse ;
	}
	echo $ProcessOutput ;
?>

				<BR><BR>
			<!-- End Pin -->
		  </TD>
        </TR>
      </TBODY>
    </TABLE>