<table width="100%">
	<?php
	//แสดงปฏิทิน
	$id = input_get('id');
	$sql = "SELECT `id`,`date_event`,`subject`,`post_date`,`pageview`,UNIX_TIMESTAMP(`date_event`) AS `date_event2`
	FROM web_calendar
	WHERE id = :id ";
	$event = $msdb->fetch($sql, array(':id' => $id));

	if(!$event['id']){
		echo "<br><br><br><br><center><img src=\"images/icon/notview.gif\" border=\"0\" ><br><br><B>ไม่มีรายการปฏิทินกิจกรรมนี้</B></center><br><br><br><br>";
	}else{
		$contents = file_get_contents("calendardata/".$event['date_event'].".txt");
		$Detail = stripslashes(FixQuotes($contents));

		//ทำการเพิ่มจำนวนคนเข้าชม
		$pageview = $event['pageview'] + 1;
		$sql = "UPDATE `web_calendar` SET `pageview` = '$pageview' WHERE `id` = '$id' ";
		$update = $msdb->update($sql);
		// var_dump($update);
		// exit;
		?>
		<tr>
			<td>
				<img src="images/icon/calendar.gif" width="16" height="15" border="0" align="absmiddle">
				<p style="color: #990000;"><b><?= ThaiTimeConvert($event['date_event2'],"1","");?></b></p>
				<p style="color: #990000;"><b><?=$event['subject'];?></b></p>
			</td>
		</tr>
		<tr>
			<td height="1" class="dotline"></td>
		</tr>
		<tr>
			<td>
				<br>
				<?=$Detail;?>
				<br><br>
				เข้าชม : <?=$pageview;?>
				<br><br>
			</td>
		</tr>
		<tr>
			<td height="1" class="dotline"></td>
		</tr>
		<tr>
			<td>
				<br>
				<B>ลงประกาศเมื่อ : </B><?= ThaiTimeConvert($event['post_date'],"1","");?>
				<?php
				if( isset($_SESSION['admin_user']) ){
					//Admin Login Show Icon
					?>
					<a href="?name=admin&file=editevent&id=<?php echo $event['id'];?>"><img src="images/admin/edit.gif" border="0" alt="แก้ไข" ></a>
					<a href="javascript:Confirm('?name=admin&file=delevent&id=<?php echo $event['id'];?>','คุณมั่นใจในการลบปฏิทินหัวข้อนี้ ?');"><img src="images/admin/trash.gif"  border="0" alt="ลบ" ></a>
					<?php
				}
				?>
			</td>
		</tr>
	</table>
	<?php
}
?>
