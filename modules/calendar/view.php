<TABLE width="100%" align=center cellSpacing=5 cellPadding=0 border=0>
	<?php
	$_GET['id'] = ( isset($_GET['id']) ) ? intval($_GET['id']) : false ;
	//แสดงปฏิทิน
	$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
	$query = $db->select_query("SELECT id, date_event, subject, post_date, pageview , UNIX_TIMESTAMP(date_event) AS date_event2  FROM ".TB_CALENDAR." WHERE id='".$_GET['id']."' ");
	$event = $db->fetch($query);
	$db->closedb ();
	if(!$event['id']){
		echo "<BR><BR><BR><BR><CENTER><IMG SRC=\"images/icon/notview.gif\" BORDER=\"0\" ><BR><BR><B>ไม่มีรายการปฏิทินกิจกรรมนี้</B></CENTER><BR><BR><BR><BR>";
	}else{
		$FileEventTopic = "calendardata/".$event['date_event'].".txt";
		$file_open = @fopen($FileEventTopic, "r");
		$content = @fread ($file_open, @filesize($FileEventTopic));
		$Detail = stripslashes(FixQuotes($content));
		//ทำการเพิ่มจำนวนคนเข้าชม
		$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
		$query_pv = "UPDATE ".TB_CALENDAR." SET pageview = pageview+1 WHERE id = '".$_GET['id']."' ";
		mysql_query ( $query_pv ) or sql_error ( "db-query",mysql_error() );
		?>
		<TR>
			<TD>
				<B><IMG SRC="images/icon/calendar.gif" WIDTH="16" HEIGHT="15" BORDER="0" ALIGN="absmiddle"> <FONT COLOR="#990000"><?= ThaiTimeConvert($event['date_event2'],"1","");?></FONT><BR><BR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$event['subject'];?></B><BR>
					<BR>
					</TD>
				</TR>
				<TR>
					<TD height="1" class="dotline"></TD>
				</TR>
				<TR>
					<TD>
						<BR>
							<?=$Detail;?>
							<BR><BR>
								เข้าชม : <?=$event['pageview'];?>
								<BR><BR>
								</TD>
							</TR>
							<TR>
								<TD height="1" class="dotline"></TD>
							</TR>
							<TR>
								<TD>
									<BR>
										<B>ลงประกาศเมื่อ : </B><?= ThaiTimeConvert($event['post_date'],"1","");?>
										<?php
										if($_SESSION['admin_user']){
											//Admin Login Show Icon
											?>
											<a href="?name=admin&file=editevent&id=<?php echo $event['id'];?>"><img src="images/admin/edit.gif" border="0" alt="แก้ไข" ></a>
											<a href="javascript:Confirm('?name=admin&file=delevent&id=<?php echo $event['id'];?>','คุณมั่นใจในการลบปฏิทินหัวข้อนี้ ?');"><img src="images/admin/trash.gif"  border="0" alt="ลบ" ></a>
											<?php
										}
										?>
									</TD>
								</TR>
							</TABLE>
							<?php
						}
						?>
