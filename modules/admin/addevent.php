<?
CheckAdmin($_SESSION['admin_user'], $_SESSION['admin_pwd']);

if($_GET[op] == "calendar_add"){
	if(CheckLevel($_SESSION['admin_user'],$_GET[op])){
		if (!$_POST[EventDate] OR !$_POST[subject] OR !$_POST[DETAIL]){
			echo "<script language='javascript'>" ;
			echo "alert('กรุณากรอกข้อมูลต่างๆให้ครบถ้วน')" ;
			echo "</script>" ;
			echo "<script language='javascript'>javascript:history.back()</script>";
			exit();
		}
		if(!$_GET[confirm]){
			$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
			$CKdate = $db->num_rows(TB_CALENDAR,"id"," date_event = '$_POST[EventDate]' ");
			if($CKdate){
				$ProcessOutput .= "<BR><BR>";
				$ProcessOutput .= "<CENTER><IMG SRC=\"images/icon/dangerous.png\" BORDER=\"0\"><BR><BR><B>วันที่ ".$_POST[EventDate]." ได้มีข้อมูลอยู่แล้วในระบบ ท่านต้องการบันทึกทับใช่หรือไม่ ?</B>";
				$ProcessOutput .= "<form NAME=\"myform\" METHOD=POST ACTION=\"?name=admin&file=addevent&op=calendar_add&confirm=1\">";
				$ProcessOutput .= "<INPUT TYPE=\"hidden\" NAME=\"EventDate\" value=\"".$_POST[EventDate]."\">";
				$ProcessOutput .= "<INPUT TYPE=\"hidden\" NAME=\"subject\" value=\"".$_POST[subject]."\">";
				$ProcessOutput .= "<INPUT TYPE=\"hidden\" NAME=\"DETAIL\" value=\"".$_POST[DETAIL]."\">";
				$ProcessOutput .= "<BR><BR><INPUT TYPE=\"submit\" VALUE=\" ต้องการบันทึกทับ \">  <INPUT TYPE=\"button\" VALUE=\" กลับไปเขียนใหม่ \" onclick=\"window.location='?name=admin&file=addevent'\">";
				$ProcessOutput .= "</form></CENTER>";
			}else{
				$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
				$db->add_db(TB_CALENDAR,array(
					"date_event"=>"$_POST[EventDate]",
					"subject"=>"".addslashes(htmlspecialchars($_POST[subject]))."",
					"post_date"=>"".TIMESTAMP.""
				));
				//Add data
				$Filename = "".$_POST[EventDate].".txt";
				$txt_name = "calendardata/".$Filename."";
				$txt_open = @fopen("$txt_name", "w");
				@fwrite($txt_open, "".$_POST[DETAIL]."");
				@fclose($txt_open);
				$ProcessOutput .= "<BR><BR>";
				$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
				$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ได้ทำการเพิ่ม รายการปฏิทิน เรียบร้อยแล้ว</B></FONT>";
				$ProcessOutput .= "</CENTER>";
				$ProcessOutput .= "<BR><BR>";
			}
		}else{
			$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
			$db->update_db(TB_CALENDAR,array(
				"subject"=>"".addcslashes(htmlspecialchars($_POST[subject]), ENT_QUOTES)."",
				"update_date"=>"".TIMESTAMP.""
			)," date_event='".$_POST[EventDate]."' ");
			//Edit data
			$Filename = "".$_POST[EventDate].".txt";
			$txt_name = "calendardata/".$Filename."";
			$txt_open = @fopen("$txt_name", "w");
			@fwrite($txt_open, "".$_POST[DETAIL]."");
			@fclose($txt_open);
			$ProcessOutput .= "<BR><BR>";
			$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
			$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ได้ทำการแก้ไข รายการปฏิทิน เรียบร้อยแล้ว</B></FONT>";
			$ProcessOutput .= "</CENTER>";
			$ProcessOutput .= "<BR><BR>";
		}
	}else{
		$ProcessOutput = $PermissionFalse ;
	}
}

?>

<script type="text/javascript" src="datepicker.js"></script>
	<TABLE cellSpacing=0 cellPadding=0 width=650 border=0>
      <TBODY>
        <TR>
          <TD width="10" vAlign=top><IMG src="images/fader.gif" border=0></TD>
          <TD width="650" vAlign=top><IMG src="images/topfader.gif" border=0><BR>
		  <!-- Admin -->
		  &nbsp;&nbsp;<IMG SRC="images/menu/textmenu_admin.gif" BORDER="0"><BR>
				<TABLE width="650" align=center cellSpacing=0 cellPadding=0 border=0>
				<TR>
					<TD height="1" class="dotline"></TD>
				</TR>
				<TR>
					<TD>
					<BR><B>&nbsp;&nbsp;<IMG SRC="images/icon/calendar.gif" BORDER="0" ALIGN="absmiddle">&nbsp;&nbsp; เพิ่มรายการปฏิทินใหม่ </B>
					<BR><BR>
<?
if(!$ProcessOutput){
?>
<form NAME="myform" METHOD=POST ACTION="?name=admin&file=addevent&op=calendar_add">
<br>
&nbsp;&nbsp;&nbsp;<b>เลือกวันที่ :</b><BR>
&nbsp;&nbsp;&nbsp;<input name="EventDate" readonly> <IMG SRC="images/admin/dateselect.gif" BORDER="0" ALT="เลือกวันที่" onclick="displayDatePicker('EventDate', false, 'ymd', '-');" align="absmiddle"> 
<BR><BR>
&nbsp;&nbsp;&nbsp;<b>หัวข้อ :</b><BR>
&nbsp;&nbsp;&nbsp;<INPUT TYPE="text" NAME="subject" style="width=400">
<BR><BR>
&nbsp;&nbsp;&nbsp;<b>รายละเอียด :</b><BR>

<?
include("FCKeditor/fckeditor.php") ;
$oFCKeditor = new FCKeditor('DETAIL') ;
$oFCKeditor->BasePath	= 'FCKeditor/' ;
$oFCKeditor->Width	= '650' ;
$oFCKeditor->Height	= '300' ;
$oFCKeditor->Value		= $TextContent ;
$oFCKeditor->Create() ;
?>
<input type="submit" value=" เพิ่มรายการในปฏิทิน " name="submit"> <input type="reset" value=" เคลีย " name="reset">
</form>
<?
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