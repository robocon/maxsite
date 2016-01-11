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
					<BR><B><IMG SRC="images/icon/plus.gif" BORDER="0" ALIGN="absmiddle"> <A HREF="?name=admin&file=main">หน้าหลักผู้ดูแลระบบ</A> &nbsp;&nbsp;<IMG SRC="images/icon/arrow_wap.gif" BORDER="0" ALIGN="absmiddle">&nbsp;&nbsp; ข่าวสาร / ประชาสัมพันธ์ </B>
					<BR><BR>
					<A HREF="?name=admin&file=news"><IMG SRC="images/admin/open.gif"  BORDER="0" align="absmiddle"> รายการข่าวสาร</A> &nbsp;&nbsp;&nbsp;<A HREF="?name=admin&file=news&op=news_add"><IMG SRC="images/admin/book.gif"  BORDER="0" align="absmiddle"> เพิ่มข่าวสาร</A> &nbsp;&nbsp;&nbsp;<A HREF="?name=admin&file=news_category"><IMG SRC="images/admin/folders.gif"  BORDER="0" align="absmiddle"> รายการหมวดหมู่</A> &nbsp;&nbsp;&nbsp;<A HREF="?name=admin&file=news_category&op=newscat_add"><IMG SRC="images/admin/opendir.gif"  BORDER="0" align="absmiddle"> เพิ่มหมวดหมู่</A><BR><BR>
<?php 
//////////////////////////////////////////// แสดงรายการข่าวสาร / ประชาสัมพันธ์ 
if($_GET[op] == ""){
	$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
	$limit = 20 ;
	$SUMPAGE = $db->num_rows(TB_NEWS,"id","");
	$page=$_GET[page];
	if (empty($page)){
		$page=1;
	}
	$rt = $SUMPAGE%$limit ;
	$totalpage = ($rt!=0) ? floor($SUMPAGE/$limit)+1 : floor($SUMPAGE/$limit); 
	$goto = ($page-1)*$limit ;
?>
 <form action="?name=admin&file=news&op=news_del&action=multidel" name="myform" method="post">
 <table width="100%" cellspacing="2" cellpadding="1" >
  <tr bgcolor="#990000" height=25>
   <td width="44"><CENTER><font color="#FFFFFF"><B>Option</B></font></CENTER></td>
   <td><font color="#FFFFFF"><B>หัวข้อข่าว</B></font></td>
   <td width="100"><CENTER><font color="#FFFFFF"><B>ลงประกาศ</B></font></CENTER></td>
   <td width="40"><CENTER><font color="#FFFFFF"><B>หมวด</B></font></CENTER></td>
   <td width="40"><CENTER><font color="#FFFFFF"><B>Check</B></font></CENTER></td>
  </tr>  
<?php 
$res[news] = $db->select_query("SELECT * FROM ".TB_NEWS." ORDER BY id DESC LIMIT $goto, $limit ");
while($arr[news] = $db->fetch($res[news])){
	$res[category] = $db->select_query("SELECT * FROM ".TB_NEWS_CAT." WHERE id='".$arr[news][category]."' ");
	$arr[category] = $db->fetch($res[category]);
	//Comment Icon
	if($arr[news][enable_comment]){
		$CommentIcon = " <IMG SRC=\"images/icon/suggest.gif\" WIDTH=\"13\" HEIGHT=\"9\" BORDER=\"0\" ALIGN=\"absmiddle\">";
	}else{
		$CommentIcon = "";
	}
?>
    <tr>
     <td width="44">
      <a href="?name=admin&file=news&op=news_edit&id=<?php echo $arr[news][id];?>"><img src="images/admin/edit.gif" border="0" alt="แก้ไข" ></a> 
      <a href="javascript:Confirm('?name=admin&file=news&op=news_del&id=<?php echo $arr[news][id];?>&prefix=<?php echo $arr[news][post_date];?>','คุณมั่นใจในการลบหัวข้อนี้ ?');"><img src="images/admin/trash.gif"  border="0" alt="ลบ" ></a>
     </td> 
     <td><A HREF="?name=news&file=readnews&id=<?php echo $arr[news][id];?>" target="_blank"><?php echo $arr[news][topic];?></A><?=$CommentIcon;?></td>
     <td ><CENTER><?php echo ThaiTimeConvert($arr[news][post_date],'','');?></CENTER></td>
     <td align="center">
	 <?php if($arr[category][category_name]){ //หากมีหมวดแสดงรูป ?>
	 <A HREF="#"><IMG SRC="images/admin/folders.gif"  BORDER="0" align="absmiddle" alt="<?php echo $arr[category][category_name];?>" onMouseOver="MM_displayStatusMsg('<?php echo $arr[category][category_name];?>');return document.MM_returnValue"></A>
	 <?php } ?>
	 </td>
     <td valign="top" align="center" width="40"><input type="checkbox" name="list[]" value="<?php echo $arr[news][id];?>"></td>
    </tr>
	<TR>
		<TD colspan="5" height="1" class="dotline"></TD>
	</TR>
<?php 
 } 
?>
 </table>
 <div align="right">
 <input type="button" name="CheckAll" value="Check All" onclick="checkAll(document.myform)" >
 <input type="button" name="UnCheckAll" value="Uncheck All" onclick="uncheckAll(document.myform)" >
 <input type="hidden" name="ACTION" value="news_del">
 <input type="submit" value="Delete" onclick="return delConfirm(document.myform)">
 </div>
 </form><BR><BR>
<?php 
	SplitPage($page,$totalpage,"?name=admin&file=news");
	echo $ShowSumPages ;
	echo "<BR>";
	echo $ShowPages ;
}
else if($_GET[op] == "news_add" AND $_GET[action] == "add"){
	//////////////////////////////////////////// กรณีเพิ่ม Database
	if(CheckLevel($_SESSION['admin_user'],$_GET[op])){
		require("includes/class.resizepic.php");
		$FILE = $_FILES['FILE'];
		if (!$_POST[CATEGORY] OR !$_POST[TOPIC] OR !$_POST[HEADLINE] OR !$_POST[DETAIL] OR !$FILE['type']){
			echo "<script language='javascript'>" ;
			echo "alert('กรุณากรอกข้อมูลต่างๆให้ครบถ้วน')" ;
			echo "</script>" ;
			echo "<script language='javascript'>javascript:history.back()</script>";
			exit();
		}
		if (($FILE['type']!="image/jpg") AND ($FILE['type']!="image/jpeg") AND ($FILE['type']!="image/pjpeg")){
			echo "<script language='javascript'>" ;
			echo "alert('กรุณาใช้ไฟล์นามสกุล jpg เท่านั้น')" ;
			echo "</script>" ;
			echo "<script language='javascript'>javascript:history.back()</script>";
			exit();
		}else{
			@copy ($FILE['tmp_name'] , "newsicon/".TIMESTAMP.".jpg" );
			$original_image = "newsicon/".TIMESTAMP.".jpg" ;
			$desired_width = _INEWS_W ;
			$desired_height = _INEWS_H ;
			$image = new hft_image($original_image);
			$image->resize($desired_width, $desired_height, '0');
			$image->output_resized("newsicon/".TIMESTAMP.".jpg", "JPG");
		}
		//ทำการเพิ่มข้อมูลลงดาต้าเบส
		$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
		$db->add_db(TB_NEWS,array(
			"category"=>"$_POST[CATEGORY]",
			"topic"=>"".addslashes(htmlspecialchars($_POST[TOPIC]))."",
			"headline"=>"".addslashes(htmlspecialchars($_POST[HEADLINE]))."",
			"posted"=>"$_SESSION[admin_user]",
			"post_date"=>"".TIMESTAMP."",
			"update_date"=>"".TIMESTAMP."",
			"enable_comment"=>"$_POST[ENABLE_COMMENT]"
		));
		$db->closedb ();

		//ทำการสร้างไฟล์ text ของข่าวสาร
		$Filename = TIMESTAMP.".txt";
		$txt_name = "newsdata/".$Filename."";
		$txt_open = @fopen("$txt_name", "w");
		@fwrite($txt_open, "".$_POST[DETAIL]."");
		@fclose($txt_open);

		$ProcessOutput .= "<BR><BR>";
		$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
		$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ได้ทำการเพิ่มข่าวสาร / ประชาสัมพันธ์   เข้าสู่ระบบเรียบร้อยแล้ว</B></FONT><BR><BR>";
		$ProcessOutput .= "<A HREF=\"?name=admin&file=news\"><B>กลับหน้า จัดการข่าวสาร / ประชาสัมพันธ์ </B></A>";
		$ProcessOutput .= "</CENTER>";
		$ProcessOutput .= "<BR><BR>";
	}else{
		//กรณีไม่ผ่าน
		$ProcessOutput = $PermissionFalse ;
	}
	echo $ProcessOutput ;
}
else if($_GET[op] == "news_add"){
	//////////////////////////////////////////// กรณีเพิ่ม Form
	if(CheckLevel($_SESSION['admin_user'],$_GET[op])){
?>
<FORM NAME="myform" METHOD=POST ACTION="?name=admin&file=news&op=news_add&action=add" enctype="multipart/form-data">
<B>หัวข้อ :</B><BR>
<INPUT TYPE="text" NAME="TOPIC" size="50">
<BR><BR>
<B>รายละเอียดย่อสั้นๆ :</B><BR>
<INPUT TYPE="text" NAME="HEADLINE" size="100">
<BR><BR>
<B>หมวดหมู่ :</B><BR>
<SELECT NAME="CATEGORY">
<?php 
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
$res[category] = $db->select_query("SELECT * FROM ".TB_NEWS_CAT." ORDER BY sort ");
while ($arr[category] = $db->fetch($res[category])){
	   echo "<option value=\"".$arr[category][id]."\"";
	   echo ">".$arr[category][category_name]."</option>";
}
$db->closedb ();
?>
</SELECT>
<BR><BR>
<B>รูปไอคอนข่าวสาร : </B><BR>
<IMG name="view01" SRC="images/news_blank.gif" <?php echo " WIDTH=\""._INEWS_W."\" HEIGHT=\""._INEWS_H."\" ";?> BORDER="0" ><BR>
<input type="file" name="FILE" onpropertychange="view01.src=FILE.value;" style="width=250;"><BR>
รูปเป็นไฟล์ .jpg  .jpeg ขนาด <?php echo _INEWS_W." x "._INEWS_H ;?> Pixels เท่านั้น (หากรูปใหญ่จะย่อให้อัตโนมัติ)
<BR><BR>
<B>เนื้อหา :</B><BR>
<?php 
include("FCKeditor/fckeditor.php") ;
$oFCKeditor = new FCKeditor('DETAIL') ;
$oFCKeditor->BasePath	= 'FCKeditor/' ;
$oFCKeditor->Width	= '100%' ;
$oFCKeditor->Height	= '500' ;
$oFCKeditor->Value		= $TextContent ;
$oFCKeditor->Create() ;
?>
<BR>
<INPUT TYPE="checkbox" NAME="ENABLE_COMMENT" VALUE="1"> อนุญาติให้มีการแสดงความคิดเห็น
<BR>
<input type="submit" value=" เพิ่ม ข่าวสาร / ประชาสัมพันธ์ " name="submit"> <input type="reset" value=" เคลีย " name="reset">
</FORM>
<BR><BR>
<?php 
	}else{
		//กรณีไม่ผ่าน
		echo  $PermissionFalse ;
	}
}
else if($_GET[op] == "news_edit" AND $_GET[action] == "edit"){
	//////////////////////////////////////////// กรณีแก้ไข Database Edit
	if(CheckLevel($_SESSION['admin_user'],$_GET[op])){
		//ดึงค่า
		$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
		$res[news] = $db->select_query("SELECT * FROM ".TB_NEWS." WHERE id='".$_GET[id]."' ");
		$arr[news] = $db->fetch($res[news]);
		$db->closedb ();
		require("includes/class.resizepic.php");
		$FILE = $_FILES['FILE'];
		if (!$_POST[CATEGORY] OR !$_POST[TOPIC] OR !$_POST[HEADLINE] OR !$_POST[DETAIL]){
			echo "<script language='javascript'>" ;
			echo "alert('กรุณากรอกข้อมูลต่างๆให้ครบถ้วน')" ;
			echo "</script>" ;
			echo "<script language='javascript'>javascript:history.back()</script>";
			exit();
		}
		if ((($FILE['type']!="image/jpg") AND ($FILE['type']!="image/jpeg") AND ($FILE['type']!="image/pjpeg")) AND $FILE['size']){
			echo "<script language='javascript'>" ;
			echo "alert('กรุณาใช้ไฟล์นามสกุล jpg เท่านั้น')" ;
			echo "</script>" ;
			echo "<script language='javascript'>javascript:history.back()</script>";
			exit();
		}else{
			@copy ($FILE['tmp_name'] , "newsicon/".$arr[news][post_date].".jpg" );
			$original_image = "newsicon/".$arr[news][post_date].".jpg" ;
			$desired_width = _INEWS_W ;
			$desired_height = _INEWS_H ;
			$image = new hft_image($original_image);
			$image->resize($desired_width, $desired_height, '0');
			$image->output_resized("newsicon/".$arr[news][post_date].".jpg", "JPG");
		}
		//ทำการแก้ไขข้อมูลลงดาต้าเบส
		$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
		$db->update_db(TB_NEWS,array(
			"category"=>"$_POST[CATEGORY]",
			"topic"=>"".addslashes(htmlspecialchars($_POST[TOPIC]))."",
			"headline"=>"".addslashes(htmlspecialchars($_POST[HEADLINE]))."",
			"posted"=>"$_SESSION[admin_user]",
			"update_date"=>"".TIMESTAMP."",
			"enable_comment"=>"$_POST[ENABLE_COMMENT]"
		)," id=$_GET[id] ");
		$db->closedb ();

		//ทำการสร้างไฟล์ text ของข่าวสาร
		$Filename = $arr[news][post_date].".txt";
		$txt_name = "newsdata/".$Filename."";
		$txt_open = @fopen("$txt_name", "w");
		@fwrite($txt_open, "".$_POST[DETAIL]."");
		@fclose($txt_open);

		$ProcessOutput .= "<BR><BR>";
		$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
		$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ได้ทำการแก้ไขข่าวสาร / ประชาสัมพันธ์   เข้าสู่ระบบเรียบร้อยแล้ว</B></FONT><BR><BR>";
		$ProcessOutput .= "<A HREF=\"?name=admin&file=news\"><B>กลับหน้า จัดการข่าวสาร / ประชาสัมพันธ์ </B></A>";
		$ProcessOutput .= "</CENTER>";
		$ProcessOutput .= "<BR><BR>";
	}else{
		//กรณีไม่ผ่าน
		$ProcessOutput = $PermissionFalse ;
	}
	echo $ProcessOutput ;
}
else if($_GET[op] == "news_edit"){
	//////////////////////////////////////////// กรณีแก้ไข Form
	if(CheckLevel($_SESSION['admin_user'],$_GET[op])){
		//ดึงค่า
		$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
		$res[news] = $db->select_query("SELECT * FROM ".TB_NEWS." WHERE id='".$_GET[id]."' ");
		$arr[news] = $db->fetch($res[news]);
		$db->closedb ();

		//อ่านค่าจากไฟล์ Text เพื่อแก้ไข
		$FileNewsTopic = "newsdata/".$arr[news][post_date].".txt";
		$file_open = @fopen($FileNewsTopic, "r");
		$TextContent = @fread ($file_open, @filesize($FileNewsTopic));
		@fclose ($file_open);
		$TextContent = stripslashes($TextContent);
?>
<FORM NAME="myform" METHOD=POST ACTION="?name=admin&file=news&op=news_edit&action=edit&id=<?=$_GET[id];?>" enctype="multipart/form-data">
<B>หัวข้อ :</B><BR>
<INPUT TYPE="text" NAME="TOPIC" size="50" value="<?=$arr[news][topic];?>">
<BR><BR>
<B>รายละเอียดย่อสั้นๆ :</B><BR>
<INPUT TYPE="text" NAME="HEADLINE" size="100" value="<?=$arr[news][headline];?>">
<BR><BR>
<B>หมวดหมู่ :</B><BR>
<SELECT NAME="CATEGORY">
<?php 
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
$res[category] = $db->select_query("SELECT * FROM ".TB_NEWS_CAT." ORDER BY sort ");
while ($arr[category] = $db->fetch($res[category])){
	   echo "<option value=\"".$arr[category][id]."\"";
	   if($arr[category][id] == $arr[news][category]){echo " Selected";}
	   echo ">".$arr[category][category_name]."</option>";
}
$db->closedb ();
?>
</SELECT>
<BR><BR>
<B>รูปไอคอนข่าวสาร : </B><BR>
<IMG name="view01" SRC="newsicon/<?=$arr[news][post_date];?>.jpg" <?php echo " WIDTH=\""._INEWS_W."\" HEIGHT=\""._INEWS_H."\" ";?> BORDER="0" ><BR>
<input type="file" name="FILE" onpropertychange="view01.src=FILE.value;" style="width=250;"><BR>
รูปเป็นไฟล์ .jpg  .jpeg ขนาด <?php echo _INEWS_W." x "._INEWS_H ;?> Pixels เท่านั้น (หากรูปใหญ่จะย่อให้อัตโนมัติ)
<BR><BR>
<B>เนื้อหา :</B><BR>
<?php 
include("FCKeditor/fckeditor.php") ;
$oFCKeditor = new FCKeditor('DETAIL') ;
$oFCKeditor->BasePath	= 'FCKeditor/' ;
$oFCKeditor->Width	= '100%' ;
$oFCKeditor->Height	= '500' ;
$oFCKeditor->Value		= $TextContent ;
$oFCKeditor->Create() ;
?>
<BR>
<INPUT TYPE="checkbox" NAME="ENABLE_COMMENT" VALUE="1" <?php if($arr[news][enable_comment]){echo " Checked";};?>> อนุญาติให้มีการแสดงความคิดเห็น
<BR>
<input type="submit" value=" แก้ไข ข่าวสาร / ประชาสัมพันธ์ " name="submit"> <input type="reset" value=" เคลีย " name="reset">
</FORM>
<BR><BR>
<?php 
	}else{
		//กรณีไม่ผ่าน
		$ProcessOutput = $PermissionFalse ;
	}
	echo $ProcessOutput ;
}
else if($_GET[op] == "news_del" AND $_GET[action] == "multidel"){
	//////////////////////////////////////////// กรณีลบ Multi
	if(CheckLevel($_SESSION['admin_user'],$_GET[op])){
		while(list($key, $value) = each ($_POST['list'])){
			$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
			$res[news] = $db->select_query("SELECT * FROM ".TB_NEWS." WHERE id='".$value."' ");
			$arr[news] = $db->fetch($res[news]);
			$db->del(TB_NEWS," id='".$value."' "); 
			$db->closedb ();
			@unlink("newsdata/".$arr[news][post_date].".txt");
			@unlink("newsicon/".$arr[news][post_date].".jpg");
		}
		$ProcessOutput .= "<BR><BR>";
		$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
		$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ได้ทำการลบข่าวสาร/ประชาสัมพันธ์เรียบร้อยแล้ว</B></FONT><BR><BR>";
		$ProcessOutput .= "<A HREF=\"?name=admin&file=news\"><B>กลับหน้า จัดการข่าวสาร/ประชาสัมพันธ์</B></A>";
		$ProcessOutput .= "</CENTER>";
		$ProcessOutput .= "<BR><BR>";
	}else{
		//กรณีไม่ผ่าน
		$ProcessOutput = $PermissionFalse ;
	}
	echo $ProcessOutput ;
}
else if($_GET[op] == "news_del"){
	//////////////////////////////////////////// กรณีลบ Form
	if(CheckLevel($_SESSION['admin_user'],$_GET[op])){
		$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
		$db->del(TB_NEWS," id='".$_GET[id]."' "); 
		$db->closedb ();
		@unlink("newsdata/".$_GET[prefix].".txt");
		@unlink("newsicon/".$_GET[prefix].".jpg");
		$ProcessOutput .= "<BR><BR>";
		$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
		$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ได้ทำการลบข่าวสาร/ประชาสัมพันธ์เรียบร้อยแล้ว</B></FONT><BR><BR>";
		$ProcessOutput .= "<A HREF=\"?name=admin&file=news\"><B>กลับหน้า จัดการข่าวสาร/ประชาสัมพันธ์</B></A>";
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