<?php
CheckAdmin($_SESSION['admin_user'], $_SESSION['admin_pwd']);
$ProcessOutput = false;
if( isset($_GET['op']) && $_GET['op'] == "calendar_edit"){
	if(CheckLevel($_SESSION['admin_user'],$_GET['op'])){
		if (!$_POST['EventDate'] OR !$_POST['subject'] OR !$_POST['DETAIL']){
			echo "<script language='javascript'>" ;
			echo "alert('กรุณากรอกข้อมูลต่างๆให้ครบถ้วน')" ;
			echo "</script>" ;
			echo "<script language='javascript'>javascript:history.back()</script>";
			exit();
		}
		$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
		$db->update_db(TB_CALENDAR,array(
			"subject"=>"".addslashes(htmlspecialchars($_POST['subject']))."",
			"update_date"=>"".TIMESTAMP.""
		)," date_event='".$_POST['EventDate']."' ");
		//Edit data
		$Filename = "".$_POST['EventDate'].".txt";
		$txt_name = "calendardata/".$Filename."";
		$txt_open = @fopen("$txt_name", "w");
		@fwrite($txt_open, "".$_POST['DETAIL']."");
		@fclose($txt_open);
		$ProcessOutput = "<BR><BR>";
		$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
		$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ได้ทำการแก้ไข รายการปฏิทิน เรียบร้อยแล้ว</B></FONT>";
		$ProcessOutput .= "</CENTER>";
		$ProcessOutput .= "<BR><BR>";
	}else{
		$ProcessOutput = $PermissionFalse ;
	}
}else{
	$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
	$query = $db->select_query("SELECT * FROM ".TB_CALENDAR." WHERE id='".$_GET['id']."' ");
	$event = $db->fetch($query);
	$db->closedb ();
	if (!$event['id']){
		echo "<script language='javascript'>" ;
		echo "alert('ไม่มีรายการที่ต้องการแก้ไข')" ;
		echo "</script>" ;
		echo "<script language='javascript'>javascript:history.back()</script>";
		exit();
	}
	//อ่านค่าจากไฟล์ Text เพื่อแก้ไข
	$FileEventTopic = "calendardata/".$event['date_event'].".txt";
	$file_open = @fopen($FileEventTopic, "r");
	$TextContent = @fread ($file_open, @filesize($FileEventTopic));
	@fclose ($file_open);
	$TextContent = stripslashes($TextContent);
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
									<BR><B>&nbsp;&nbsp;<IMG SRC="images/icon/calendar.gif" BORDER="0" ALIGN="absmiddle">&nbsp;&nbsp; แก้ไขรายการปฏิทิน</B>
										<BR><BR>
											<?php
											if(!$ProcessOutput){
												?>
												<form NAME="myform" METHOD=POST ACTION="?name=admin&file=editevent&op=calendar_edit">
													<br>
													&nbsp;&nbsp;&nbsp;<b>วันที่ :</b><BR>
														&nbsp;&nbsp;&nbsp;<input name="EventDate" value="<?=$event['date_event'];?>" readonly>
														<BR><BR>
															&nbsp;&nbsp;&nbsp;<b>หัวข้อ :</b><BR>
																&nbsp;&nbsp;&nbsp;<INPUT TYPE="text" NAME="subject" value="<?=$event['subject'];?>" style="width=400">
																	<BR><BR>
																		&nbsp;&nbsp;&nbsp;<b>รายละเอียด :</b><BR>

																			<?php
																			include("FCKeditor/fckeditor.php") ;
																			$oFCKeditor = new FCKeditor('DETAIL') ;
																			$oFCKeditor->BasePath	= 'FCKeditor/' ;
																			$oFCKeditor->Width	= '650' ;
																			$oFCKeditor->Height	= '300' ;
																			$oFCKeditor->Value		= $TextContent ;
																			$oFCKeditor->Create() ;
																			?>
																			<input type="submit" value=" แก้ไขรายการปฏิทิน " name="submit"> <input type="reset" value=" เคลีย " name="reset">
																		</form>
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
