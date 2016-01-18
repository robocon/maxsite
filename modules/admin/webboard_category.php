<?php
CheckAdmin($_SESSION['admin_user'], $_SESSION['admin_pwd']);
$_GET['op'] = ( isset($_GET['op']) ) ? trim($_GET['op']) : false ;
$_GET['action'] = ( isset($_GET['action']) ) ? trim($_GET['action']) : false ;
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
									<BR><B><IMG SRC="images/icon/plus.gif" BORDER="0" ALIGN="absmiddle"> <A HREF="?name=admin&file=main">หน้าหลักผู้ดูแลระบบ</A> &nbsp;&nbsp;<IMG SRC="images/icon/arrow_wap.gif" BORDER="0" ALIGN="absmiddle">&nbsp;&nbsp; เว็บบอร์ด </B>
										<BR><BR>
											<A HREF="?name=admin&file=webboard_category"><IMG SRC="images/admin/folders.gif"  BORDER="0" align="absmiddle"> รายการหมวดหมู่</A> &nbsp;&nbsp;&nbsp;<A HREF="?name=admin&file=webboard_category&op=webboard_add"><IMG SRC="images/admin/opendir.gif"  BORDER="0" align="absmiddle"> เพิ่มหมวดหมู่</A><BR><BR>
												<?php
												//////////////////////////////////////////// แสดงรายการ
												if($_GET['op'] == ""){
													?>
													<form action="?name=admin&file=webboard_category&op=webboard_del&action=multidel" name="myform" method="post">
														<table width="100%" cellspacing="2" cellpadding="1" >
															<tr bgcolor="#990000" height=25>
																<td><font color="#FFFFFF"><B><CENTER>Option</CENTER></B></font></td>
																<td><font color="#FFFFFF"><B>หมวดหมู่</B></font></td>
																<td align="center" width="50"><font color="#FFFFFF"><B>จำนวน</B></font></td>
																<td align="center" width="50"><font color="#FFFFFF"><B>ลำดับ</B></font></td>
																<td><font color="#FFFFFF"><B><CENTER>Check</CENTER></B></font></td>
															</tr>
															<?php
															$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
															$query = $db->select_query("SELECT * FROM ".TB_WEBBOARD_CAT." ORDER BY sort ");
															$boardCat = $db->rows($query);
															$CATCOUNT = 0 ;
															while ($itemCat = mysql_fetch_assoc($query)){
																$sumBoard = $db->num_rows(TB_WEBBOARD,"id"," category=".$itemCat['id']." ");

																$CATCOUNT ++ ;
																//กำหนดการเปลี่ยนลำดับขึ้น
																$SETSORT_UP = $itemCat['sort']-1;
																if($CATCOUNT == "1"){
																	$SETSORT_UP = "1" ;
																}
																//กำหนดการเปลี่ยนลำดับลง
																$SETSORT_DOWN = $itemCat['sort']+1;
																if($CATCOUNT == $boardCat){
																	$SETSORT_DOWN = $itemCat['sort'] ;
																}

																?>
																<tr>
																	<td width="44">
																		<a href="?name=admin&file=webboard_category&op=webboard_edit&id=<?php echo $itemCat['id'];?>"><img src="images/admin/edit.gif" border="0" alt="แก้ไข" ></a>
																		<a href="javascript:Confirm('?name=admin&file=webboard_category&op=webboard_del&id=<?php echo $itemCat['id'];?>','คุณมั่นใจในการลบหมวดหมู่นี้ ? เพราะจะทำการลบทุกหัวข้อในหมวดหมู่นี้ด้วย!!!');"><img src="images/admin/trash.gif"  border="0" alt="ลบ" ></a>
																	</td>
																	<td><?php echo $itemCat['category_name'];?></td>
																	<td align="center" width="50" ><?php echo $sumBoard ;?></td>
																	<td align="center" width="50"><A HREF="?name=admin&file=webboard_category&op=webboard_edit&action=sort&setsort=<?php echo $SETSORT_UP ;?>&move=up&id=<?php echo $itemCat['id'];?>"><IMG SRC="images/icon/arrow_up.gif"  BORDER="0" ALT="เลื่อนขึ้น"></A>&nbsp;&nbsp;&nbsp;<A HREF="?name=admin&file=webboard_category&op=webboard_edit&action=sort&setsort=<?php echo $SETSORT_DOWN ;?>&move=down&id=<?php echo $itemCat['id'];?>"><IMG SRC="images/icon/arrow_down.gif"  BORDER="0" ALT="เลื่อนลง"></A></td>
																		<td valign="top" align="center" width="40"><input type="checkbox" name="list[]" value="<?php echo $itemCat['id'];?>"></td>
																	</tr>
																	<TR>
																		<TD colspan="5" height="1" class="dotline"></TD>
																	</TR>
																	<?php
																}
																$db->closedb ();
																?>
															</table>
															<div align="right">
																<input type="button" name="CheckAll" value="Check All" onclick="checkAll(document.myform)" >
																<input type="button" name="UnCheckAll" value="Uncheck All" onclick="uncheckAll(document.myform)" >
																<input type="hidden" name="ACTION" value="news_del">
																<input type="submit" value="Delete" onclick="return delConfirm(document.myform)">
															</div>
														</form>
														<?php
													}
													else if($_GET['op'] == "webboard_add" AND $_GET['action'] == "add"){
														//////////////////////////////////////////// กรณีเพิ่ม Database
														$ProcessOutput = false;
														if(CheckLevel($_SESSION['admin_user'],$_GET['op'])){
															//เช็คว่า id ตอนนี้เป็นอะไร
															$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
															$query = $db->select_query("SELECT sort FROM ".TB_WEBBOARD_CAT." ORDER BY sort DESC ");
															$boardCat = mysql_fetch_array($query);
															$SORTID = $boardCat['sort']+1 ;
															//เพิ่มข้อมูลลงดาต้าเบส
															$db->add_db(TB_WEBBOARD_CAT,array(
																"category_name"=>"".addslashes(htmlspecialchars($_POST['CATEGORY']))."",
																"sort"=>"$SORTID"
															));
															$db->closedb ();
															$ProcessOutput = "<BR><BR>";
															$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
															$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ได้ทำการเพิ่มหมวดหมู่เว็บบอร์ด   เข้าสู่ระบบเรียบร้อยแล้ว</B></FONT><BR><BR>";
															$ProcessOutput .= "<A HREF=\"?name=admin&file=webboard_category\"><B>กลับหน้า จัดการหมวดหมู่เว็บบอร์ด </B></A>";
															$ProcessOutput .= "</CENTER>";
															$ProcessOutput .= "<BR><BR>";
														}else{
															//กรณีไม่ผ่าน
															$ProcessOutput = $PermissionFalse ;
														}
														echo $ProcessOutput ;
													}
													else if($_GET['op'] == "webboard_add"){
														//////////////////////////////////////////// กรณีเพิ่ม Form
														$PermissionFalse = false;
														if(CheckLevel($_SESSION['admin_user'],$_GET['op'])){
															?>
															<FORM METHOD=POST ACTION="?name=admin&file=webboard_category&op=webboard_add&action=add">
																<B>ชื่อหมวดหมู่ :</B><BR>
																	<INPUT TYPE="text" NAME="CATEGORY" size="40">
																		<BR><BR>
																			<INPUT TYPE="submit" value=" เพิ่มหมวดหมู่ ">
																			</FORM>
																			<?php
																		}else{
																			//กรณีไม่ผ่าน
																			echo  $PermissionFalse ;
																		}
																	}
																	else if($_GET['op'] == "webboard_edit" AND $_GET['action'] == "edit"){
																		//////////////////////////////////////////// กรณีแก้ไข Database
																		$ProcessOutput = false;
																		if(CheckLevel($_SESSION['admin_user'],$_GET['op'])){
																			//แก้ไขข้อมูลลงดาต้าเบส
																			$db->update_db(TB_WEBBOARD_CAT,array(
																				"category_name"=>"".addslashes(htmlspecialchars($_POST['CATEGORY'])).""
																			)," id=".$_GET['id']." ");
																			$db->closedb ();
																			$ProcessOutput = "<BR><BR>";
																			$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
																			$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ได้ทำการแก้ไขหมวดหมู่เว็บบอร์ด   เข้าสู่ระบบเรียบร้อยแล้ว</B></FONT><BR><BR>";
																			$ProcessOutput .= "<A HREF=\"?name=admin&file=webboard_category\"><B>กลับหน้า จัดการหมวดหมู่เว็บบอร์ด </B></A>";
																			$ProcessOutput .= "</CENTER>";
																			$ProcessOutput .= "<BR><BR>";
																		}else{
																			//กรณีไม่ผ่าน
																			$ProcessOutput = $PermissionFalse ;
																		}
																		echo $ProcessOutput ;
																	}
																	else if($_GET['op'] == "webboard_edit" AND $_GET['action'] == "sort"){
																		//////////////////////////////////////////// Set Sort
																		$ProcessOutput = false;
																		if(CheckLevel($_SESSION['admin_user'],$_GET['op'])){
																			//กรณีเลื่อนขึ้น
																			if($_GET['move'] == "up"){
																				$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
																				$query = "UPDATE ".TB_WEBBOARD_CAT." SET sort = sort+1 WHERE sort = '".$_GET['setsort']."' ";
																				mysql_query ( $query ) or sql_error ( "db-query",mysql_error() );
																				$db->closedb ();

																				$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
																				$query = "UPDATE ".TB_WEBBOARD_CAT." SET sort = '".$_GET['setsort']."' WHERE id = '".$_GET['id']."' ";
																				mysql_query ( $query ) or sql_error ( "db-query",mysql_error() );
																				$db->closedb ();
																			}
																			if($_GET['move'] == "down"){
																				$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
																				$query = "UPDATE ".TB_WEBBOARD_CAT." SET sort = sort-1 WHERE sort = '".$_GET['setsort']."' ";
																				mysql_query ( $query ) or sql_error ( "db-query",mysql_error() );
																				$db->closedb ();

																				$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
																				$query = "UPDATE ".TB_WEBBOARD_CAT." SET sort = '".$_GET['setsort']."' WHERE id = '".$_GET['id']."' ";
																				mysql_query ( $query ) or sql_error ( "db-query",mysql_error() );
																				$db->closedb ();
																			}
																			$ProcessOutput = "<BR><BR>";
																			$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
																			$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ได้ทำการแก้ไขหมวดหมู่เว็บบอร์ด   เข้าสู่ระบบเรียบร้อยแล้ว</B></FONT><BR><BR>";
																			$ProcessOutput .= "<A HREF=\"?name=admin&file=webboard_category\"><B>กลับหน้า จัดการหมวดหมู่เว็บบอร์ด </B></A>";
																			$ProcessOutput .= "</CENTER>";
																			$ProcessOutput .= "<BR><BR>";
																		}else{
																			//กรณีไม่ผ่าน
																			$ProcessOutput = $PermissionFalse ;
																		}
																		echo $ProcessOutput ;
																	}
																	else if($_GET['op'] == "webboard_edit"){
																		//////////////////////////////////////////// กรณีแก้ไข Form
																		$ProcessOutput = false;
																		if(CheckLevel($_SESSION['admin_user'],$_GET['op'])){
																			//ดึงค่า
																			$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
																			$query = $db->select_query("SELECT * FROM ".TB_WEBBOARD_CAT." WHERE id='".$_GET['id']."' ");
																			$boardCat = $db->fetch($query);
																			$db->closedb ();
																			?>
																			<FORM METHOD=POST ACTION="?name=admin&file=webboard_category&op=webboard_edit&action=edit&id=<?=$_GET['id'];?>">
																				<B>ชื่อหมวดหมู่ :</B><BR>
																					<INPUT TYPE="text" NAME="CATEGORY" size="40" value="<?=$boardCat['category_name'];?>">
																						<BR><BR>
																							<INPUT TYPE="submit" value=" แก้ไขหมวดหมู่ ">
																							</FORM>
																							<?php
																						}else{
																							//กรณีไม่ผ่าน
																							$ProcessOutput = $PermissionFalse ;
																						}
																						echo $ProcessOutput ;
																					}
																					else if($_GET['op'] == "webboard_del" AND $_GET['action'] == "multidel"){
																						//////////////////////////////////////////// กรณีลบ Multi
																						if(CheckLevel($_SESSION['admin_user'],$_GET['op'])){
																							while(list($key, $value) = each ($_POST['list'])){
																								$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
																								$BoardResult = $db->select_query("SELECT id,picture FROM ".TB_WEBBOARD." WHERE category='".$value."' ORDER BY id ");
																								while($WebBoard = $db->fetch($BoardResult)){
																									$CommentResult = $db->select_query("SELECT id,picture FROM ".TB_WEBBOARD_COMMENT." WHERE topic_id='".$WebBoard['id']."' ORDER BY id ");
																									while($Comment = $db->fetch($CommentResult)){
																										@unlink("webboard_upload/".$Comment['picture']."");
																									}
																									@unlink("webboard_upload/".$WebBoard['picture']."");
																									$db->del(TB_WEBBOARD_COMMENT," topic_id='".$WebBoard['id']."' ");
																								}
																								$db->del(TB_WEBBOARD_CAT," id='".$value."' ");
																								$db->del(TB_WEBBOARD," category='".$value."' ");
																								$db->closedb ();
																							}
																							$ProcessOutput = "<BR><BR>";
																							$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
																							$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ได้ทำการลบหมวดหมู่เว็บบอร์ดเรียบร้อยแล้ว</B></FONT><BR><BR>";
																							$ProcessOutput .= "<A HREF=\"?name=admin&file=webboard_category\"><B>กลับหน้า จัดการหมวดหมู่เว็บบอร์ด</B></A>";
																							$ProcessOutput .= "</CENTER>";
																							$ProcessOutput .= "<BR><BR>";
																						}else{
																							//กรณีไม่ผ่าน
																							$ProcessOutput = $PermissionFalse ;
																						}
																						echo $ProcessOutput ;
																					}
																					else if($_GET['op'] == "webboard_del"){
																						//////////////////////////////////////////// กรณีลบ Form
																						if(CheckLevel($_SESSION['admin_user'],$_GET['op'])){
																							$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
																							$BoardResult = $db->select_query("SELECT id,picture FROM ".TB_WEBBOARD." WHERE category='".$_GET['id']."' ORDER BY id ");
																							while($WebBoard = $db->fetch($BoardResult)){
																								$CommentResult = $db->select_query("SELECT id,picture FROM ".TB_WEBBOARD_COMMENT." WHERE topic_id='".$WebBoard['id']."' ORDER BY id ");
																								while($Comment = $db->fetch($CommentResult)){
																									@unlink("webboard_upload/".$Comment['picture']."");
																								}
																								@unlink("webboard_upload/".$WebBoard['picture']."");
																								$db->del(TB_WEBBOARD_COMMENT," topic_id='".$WebBoard['id']."' ");
																							}
																							$db->del(TB_WEBBOARD_CAT," id='".$_GET['id']."' ");
																							$db->del(TB_WEBBOARD," category='".$_GET['id']."' ");
																							$db->closedb ();
																							$ProcessOutput = "<BR><BR>";
																							$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
																							$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ได้ทำการลบหมวดหมู่เว็บบอร์ดเรียบร้อยแล้ว</B></FONT><BR><BR>";
																							$ProcessOutput .= "<A HREF=\"?name=admin&file=webboard_category\"><B>กลับหน้า จัดการหมวดหมู่เว็บบอร์ด</B></A>";
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
