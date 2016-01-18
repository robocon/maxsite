<?php
CheckAdmin($_SESSION['admin_user'], $_SESSION['admin_pwd']);
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
									<BR><B><IMG SRC="images/icon/plus.gif" BORDER="0" ALIGN="absmiddle"> <A HREF="?name=admin&file=main">หน้าหลักผู้ดูแลระบบ</A> &nbsp;&nbsp;<IMG SRC="images/icon/arrow_wap.gif" BORDER="0" ALIGN="absmiddle">&nbsp;&nbsp; จัดการผู้ดูแลระบบ</B>
										<BR><BR>
											<A HREF="?name=admin&file=user"><IMG SRC="images/admin/admins.gif"  BORDER="0" align="absmiddle"> จัดการผู้ดูแลระบบ</A> &nbsp;&nbsp;&nbsp;<A HREF="?name=admin&file=user&op=admin_add"><IMG SRC="images/admin/user.gif"  BORDER="0" align="absmiddle"> เพิ่มผู้ดูแลระบบ</A> &nbsp;&nbsp;&nbsp;<A HREF="?name=admin&file=groups"><IMG SRC="images/admin/keys.gif"  BORDER="0" align="absmiddle"> ระดับของผู้ดูแลระบบ</A> &nbsp;&nbsp;&nbsp;<A HREF="?name=admin&file=groups&op=group_add"><IMG SRC="images/admin/share.gif"  BORDER="0" align="absmiddle"> เพิ่มระดับของผู้ดูแลระบบ</A>
												<BR><BR>
													<!-- แสดงผลรายการกลุ่มผู้ดูแลระบบ -->
													<?php
													//////////////////////////////////////////// แสดงรายชื่อกลุ่มผู้ดูแลระบบ
													if( !isset($_GET['op']) ){
														$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
														$limit = 20 ;
														$SUMPAGE = $db->num_rows(TB_ADMIN_GROUP,"id","");
														if (empty($page)){
															$page=1;
														}
														$rt = $SUMPAGE%$limit ;
														$totalpage = ($rt!=0) ? floor($SUMPAGE/$limit)+1 : floor($SUMPAGE/$limit);
														$goto = ($page-1)*$limit ;
														?>
														<form action="?name=admin&file=groups&op=group_del&action=multidel" name="myform" method="post">
															<table width="100%" cellspacing="2" cellpadding="1" >
																<tr bgcolor="#990000" height=25>
																	<td width="60"><font color="#FFFFFF"><B><CENTER>Option</CENTER></B></font></td>
																	<td><font color="#FFFFFF"><B>Level</B></font></td>
																	<td width=80><CENTER><font color="#FFFFFF"><B>จำนวน</B></font></CENTER></td>
																	<td><font color="#FFFFFF"><B><CENTER>Check</CENTER></B></font></td>
																</tr>
																<?php
																$query = $db->select_query("SELECT * FROM ".TB_ADMIN_GROUP." ORDER BY id LIMIT $goto, $limit ");
																while($group = $db->fetch($query)){
																	$userRows = $db->num_rows(TB_ADMIN,"id"," level=".$group['id']." ");
																	?>
																	<tr>
																		<td width="60" align="center">
																			<a href="?name=admin&file=groups&op=group_edit&id=<?php echo $group['id'];?>"><img src="images/admin/edit.gif" border="0" alt="แก้ไข" ></a>
																			<a href="javascript:Confirm('?name=admin&file=groups&op=group_del&id=<?php echo $group['id'];?>&level=<?php echo $group['name'];?>','คุณมั่นใจในการลบระดับผู้ใช้ : <?php echo $group['name'];?>');"><img src="images/admin/trash.gif"  border="0" alt="ลบ" ></a>
																		</td>
																		<td><?php echo $group['name'];?></td>
																		<td ><CENTER><?php echo $userRows;?></CENTER></td>
																		<td align="center" width="40"><input type="checkbox" name="list[]" value="<?php echo $group['id'];?>"></td>
																	</tr>
																	<TR>
																		<TD colspan="4" height="1" class="dotline"></TD>
																	</TR>
																	<?php
																}
																?>
															</table>
															<div align="right">
																<input type="button" name="CheckAll" value="Check All" onclick="checkAll(document.myform)" >
																<input type="button" name="UnCheckAll" value="Uncheck All" onclick="uncheckAll(document.myform)" >
																<input type="submit" value="Delete" >
															</div>
														</form><BR><BR>
															<?php
															SplitPage($page,$totalpage,"?name=admin&file=groups");
															echo $ShowSumPages ;
															echo "<BR>";
															echo $ShowPages ;
															echo "<BR><BR>";

															$query = $db->select_query("SELECT * FROM ".TB_ADMIN_GROUP." ORDER BY id ");
															while ($group = $db->fetch($query))
															{
																echo "<LI><B>".$group['name']." : </B>".$group['description']."</LI>";
															}
															$db->closedb ();

														}
														else if($_GET['op'] == "group_add" AND ( isset($_GET['action']) && $_GET['action'] == "add" ) ){
															//////////////////////////////////////////// กรณีเพิ่ม Group Admin Database
															if(CheckLevel($_SESSION['admin_user'],$_GET['op'])){
																$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
																$query = mysql_query("SELECT * FROM ".TB_ADMIN_GROUP." WHERE name='".$_POST['GROUP_NAME']."'") or die(mysql_error());

																$queryGroups = mysql_query("SELECT * FROM ".TB_ADMIN_GROUP);
																/*******/
																$groupsTxt = "INSERT INTO ".TB_ADMIN_GROUP." VALUES(0,'".addslashes(htmlspecialchars($_POST['GROUP_NAME']))."','".addslashes(htmlspecialchars($_POST['GROUP_DESC']))."',";
																echo "<pre>";
																for($x=3; $x<mysql_num_fields($queryGroups); $x++)
																{
																	$fname =  mysql_field_name($queryGroups, $x);
																	$groupsTxt .= (isset($_POST[$fname])) ? "'".$_POST[$fname]."'" : "''";
																	if($x < mysql_num_fields($queryGroups)-1) $groupsTxt .= ", ";
																}
																$groupsTxt .= ");";
																/*******/

																if(mysql_num_rows($query)<1) {
																	mysql_query($groupsTxt) or die (mysql_error());
																}
																$db->closedb ();

																$ProcessOutput = "<BR><BR>";
																$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
																$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ได้ทำการเพิ่มกลุ่มผู้ดูแลระบบเรียบร้อยแล้ว</B></FONT><BR><BR>";
																$ProcessOutput .= "<A HREF=\"?name=admin&file=user\"><B>กลับหน้า จัดการผู้ดูแลระบบ</B></A>";
																$ProcessOutput .= "</CENTER>";
																$ProcessOutput .= "<BR><BR>";
															}else{
																//กรณีไม่ผ่าน
																$ProcessOutput = $PermissionFalse ;
															}
															echo $ProcessOutput ;
														}
														else if($_GET['op'] == "group_add"){
															//////////////////////////////////////////// กรณีเพิ่ม Group Admin Form
															if(CheckLevel($_SESSION['admin_user'],$_GET['op'])){
																?>
																<FORM name="groups" METHOD=POST ACTION="?name=admin&file=groups&op=group_add&action=add">
																	<B>ชื่อกลุ่ม :</B><br>
																	<input type="text"  name="GROUP_NAME" size="40"><br>
																	<B>รายละเอียด :</B><br>
																	<input type="text" name="GROUP_DESC"  size="40"><br>
																	<br>
																	<B>กรุณาเลือก :</B><br>
																	<?php
																	$m = 0;
																	$fnum = 3;
																	$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
																	$sql = "SELECT * FROM ".TB_ADMIN_GROUP." " ;
																	$query = mysql_query($sql);

																	echo '<table cellspacing="1" cellpadding="4"  bgcolor="#669999">';
																	for($x=3; $x<mysql_num_fields($query); $x++)
																	{
																		$fname =  mysql_field_name($query, $x);
																		list($name,$task) = explode("_",$fname);
																		if(empty($last) || $last <> $name)
																		{
																			if($m<$fnum)
																			{
																				$l = $fnum - $m;
																				echo '<td colspan="'.$l.'"></td>';
																			}
																			$ime = "echo _".strtoupper($name).";";
																			echo '</tr><tr bgcolor="#ffffff"><td>';
																			eval($ime);
																			echo '</td>';
																			$m=0;
																		}
																		echo '<td><input type="checkbox" name="'.$fname.'"  value="1"> '.$task.'</td>';
																		$m++;
																		$last = $name;
																	}
																	if($m<$fnum)
																	{
																		$l = $fnum - $m;
																		echo '<td colspan="'.$l.'"></td>';
																	}
																	echo '</tr></table>';
																	$db->closedb ();
																	?>
																	<br>
																	<input type="button" name="CheckAll" value="เลือกทั้งหมด" onclick="checkAll(document.groups)" >
																	<input type="button" name="UnCheckAll" value="ยกเลิกทั้งหมด" onclick="uncheckAll(document.groups)" >

																	<br>
																	<br><br>
																	<input type="submit" value=" เพิ่ม Level " >
																</FORM>
																<?php
															}else{
																//กรณีไม่ผ่าน
																echo  $PermissionFalse ;
															}
														}
														else if($_GET['op'] == "group_edit" AND ( isset($_GET['action']) && $_GET['action'] == "edit" ) ){
															//////////////////////////////////////////// กรณีแก้ไข User Admin Database Edit
															if(CheckLevel($_SESSION['admin_user'],$_GET['op'])){
																$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
																$query = mysql_query("SELECT * FROM ".TB_ADMIN_GROUP);

																$groupsTxt = "UPDATE ".TB_ADMIN_GROUP." SET name='".addslashes(htmlspecialchars($_POST['GROUP_NAME']))."', description='".addslashes(htmlspecialchars($_POST['GROUP_DESC']))."', ";
																for($x=3;$x<mysql_num_fields($query);$x++)
																{
																	$fname =  mysql_field_name($query, $x);
																	$groupsTxt .= ( isset($_POST[$fname]) ) ? $fname."='".$_POST[$fname]."'" : $fname."='0'" ;
																	if($x < mysql_num_fields($query)-1) $groupsTxt .= ", ";
																}
																$groupsTxt .= " WHERE id='".$_GET['id']."';";
																/******/
																mysql_query($groupsTxt) or die (mysql_error());
																$db->closedb ();
																$ProcessOutput = "<BR><BR>";
																$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
																$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ได้ทำการแก้ไขกลุ่มผู้ระบบเรียบร้อยแล้ว</B></FONT><BR><BR>";
																$ProcessOutput .= "<A HREF=\"?name=admin&file=user\"><B>กลับหน้า จัดการผู้ดูแลระบบ</B></A>";
																$ProcessOutput .= "</CENTER>";
																$ProcessOutput .= "<BR><BR>";
															}else{
																//กรณีไม่ผ่าน
																$ProcessOutput = $PermissionFalse ;
															}
															echo $ProcessOutput ;
														}
														else if($_GET['op'] == "group_edit"){
															//////////////////////////////////////////// กรณีแก้ไข Group Admin Edit Form
															$ProcessOutput = false;
															if(CheckLevel($_SESSION['admin_user'],$_GET['op'])){
																//ดึงกลุ่มผู้ดูแลระบบออกมา
																$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
																$query = $db->select_query("SELECT * FROM ".TB_ADMIN_GROUP." WHERE id='".$_GET['id']."' ");
																$group = $db->fetch($query);
																$db->closedb ();
																?>
																<form action="?name=admin&file=groups&op=group_edit&action=edit&id=<?=$_GET['id'];?>" name="groups" method="post">
																	<B>ชื่อกลุ่ม :</B><br>
																	<input type="text"  name="GROUP_NAME" size="40" value="<?php echo $group['name'];?>"><br>
																	<B>รายละเอียด :</B><br>
																	<input type="text" name="GROUP_DESC"  size="40" value="<?php echo $group['description'];?>"><br>
																	<br>
																	<B>กรุณาเลือก :</B><br>
																	<?php
																	$m = 0;
																	$fnum = 3;
																	$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
																	$queryGroups = mysql_query("SELECT * FROM ".TB_ADMIN_GROUP);

																	echo '<table cellspacing="1" cellpadding="4"  bgcolor="#669999">';
																	for($x=3; $x<mysql_num_fields($queryGroups); $x++)
																	{
																		$fname =  mysql_field_name($queryGroups, $x);
																		list($name,$task) = explode("_",$fname);
																		if(empty($last) || $last <> $name)
																		{
																			if($m<$fnum)
																			{
																				$l = $fnum - $m;
																				echo '<td colspan="'.$l.'"></td>';
																			}
																			$ime = "echo _".strtoupper($name).";";
																			echo '</tr><tr bgcolor="#ffffff"><td>';
																			eval($ime);
																			echo '</td>';
																			$m=0;
																		}
																		echo '<td><input type="checkbox" name="'.$fname.'" ';
																		if($group[$fname] == 1)
																		echo 'checked="checked"';
																		echo ' value="1"> '.$task.'</td>';
																		$m++;
																		$last = $name;
																	}
																	if($m<$fnum)
																	{
																		$l = $fnum - $m;
																		echo '<td colspan="'.$l.'"></td>';
																	}
																	echo '</tr></table>';
																	$db->closedb ();
																	?>
																	<br>
																	<input type="button" name="CheckAll" value="เลือกทั้งหมด" onclick="checkAll(document.groups)" >
																	<input type="button" name="UnCheckAll" value="ยกเลิกทั้งหมด" onclick="uncheckAll(document.groups)" >

																	<br>
																	<br><br>
																	<input type="submit" value=" แก้ไข Level " >
																</form>
																<?php
															}else{
																//กรณีไม่ผ่าน
																$ProcessOutput = $PermissionFalse ;
															}
															echo $ProcessOutput ;
														}
														else if($_GET['op'] == "group_del" AND ( isset($_GET['action']) && $_GET['action'] == "multidel" ) ){
															//////////////////////////////////////////// กรณีลบ User Admin Multi
															if(CheckLevel($_SESSION['admin_user'],$_GET['op'])){
																while(list($key, $value) = each ($_POST['list'])){
																	$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
																	$db->del(TB_ADMIN_GROUP," id='".$value."' ");
																	$db->closedb ();
																}
																$ProcessOutput .= "<BR><BR>";
																$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
																$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ได้ทำการลบรายการกลุ่มผู้ระบบเรียบร้อยแล้ว</B></FONT><BR><BR>";
																$ProcessOutput .= "<A HREF=\"?name=admin&file=user\"><B>กลับหน้า จัดการผู้ดูแลระบบ</B></A>";
																$ProcessOutput .= "</CENTER>";
																$ProcessOutput .= "<BR><BR>";
															}else{
																//กรณีไม่ผ่าน
																$ProcessOutput = $PermissionFalse ;
															}
															echo $ProcessOutput ;
														}
														else if($_GET['op'] == "group_del"){
															//////////////////////////////////////////// กรณีลบ Group Admin Form
															if(CheckLevel($_SESSION['admin_user'],$_GET['op'])){
																$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
																$db->del(TB_ADMIN_GROUP," id='".$_GET['id']."' ");
																$db->closedb ();
																$ProcessOutput = "<BR><BR>";
																$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
																$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ได้ทำการลบกลุ่มผู้ระบบเรียบร้อยแล้ว</B></FONT><BR><BR>";
																$ProcessOutput .= "<A HREF=\"?name=admin&file=user\"><B>กลับหน้า จัดการผู้ดูแลระบบ</B></A>";
																$ProcessOutput .= "</CENTER>";
																$ProcessOutput .= "<BR><BR>";
															}else{
																//กรณีไม่ผ่าน
																$ProcessOutput = $PermissionFalse ;
															}
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
