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
<!-- แสดงผลรายการผู้ดูแลระบบ -->
<?php 
//////////////////////////////////////////// แสดงรายชื่อผู้ดูแลระบบ
if($_GET[op] == ""){
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
$limit = 20 ;
$SUMPAGE = $db->num_rows(TB_ADMIN,"id","");
$page=$_GET[page];
if (empty($page)){
	$page=1;
}
$rt = $SUMPAGE%$limit ;
$totalpage = ($rt!=0) ? floor($SUMPAGE/$limit)+1 : floor($SUMPAGE/$limit); 
$goto = ($page-1)*$limit ;
?>
 <form action="?name=admin&file=user&op=admin_del&action=multidel" name="myform" method="post">
 <table width="100%" cellspacing="2" cellpadding="1" >
  <tr bgcolor="#990000" height=25>
   <td><font color="#FFFFFF"><B><CENTER>Option</CENTER></B></font></td>
   <td><font color="#FFFFFF"><B>ชื่อผู้ใช้</B></font></td>
   <td><font color="#FFFFFF"><B>ชื่อ - นามสกุล</B></font></td>
   <td><font color="#FFFFFF"><B>Email</B></font></td>
   <td><font color="#FFFFFF"><B>Level</B></font></td>
   <td><font color="#FFFFFF"><B><CENTER>Check</CENTER></B></font></td>
  </tr>  
<?php 
$res[user] = $db->select_query("SELECT * FROM ".TB_ADMIN." ORDER BY id DESC LIMIT $goto, $limit ");
while($arr[user] = $db->fetch($res[user])){
	$res[groups] = $db->select_query("SELECT * FROM ".TB_ADMIN_GROUP." WHERE id='".$arr[user][level]."' ");
	$arr[groups] = $db->fetch($res[groups]);
?>
    <tr>
     <td width="44">
      <a href="?name=admin&file=user&op=admin_edit&id=<?php echo $arr[user][id];?>"><img src="images/icon/edit.gif" border="0" alt="แก้ไข" ></a> 
      <a href="javascript:Confirm('?name=admin&file=user&op=admin_del&id=<?php echo $arr[user][id];?>','คุณมั่นใจในการลบชื่อผู้ใช้ : <?php echo $arr[user][username];?>');"><img src="images/icon/trash.gif"  border="0" alt="ลบ" ></a>
     </td> 
     <td><?php echo $arr[user][username];?></td>
     <td ><?php echo $arr[user][name];?></td>
     <td ><?php echo $arr[user][email];?></td>
     <td ><?php echo $arr[groups][name];?></td>
     <td  align="center" width="40"><input type="checkbox" name="list[]" value="<?php echo $arr[user][id];?>"></td>
    </tr>
	<TR>
		<TD colspan="6" height="1" class="dotline"></TD>
	</TR>
<?php 
 } 
?>
 </table>
 <div align="right">
 <input type="button" name="CheckAll" value="Check All" onclick="checkAll(document.myform)" >
 <input type="button" name="UnCheckAll" value="Uncheck All" onclick="uncheckAll(document.myform)" >
 <input type="submit" value="Delete" onclick="return delConfirm(document.myform)">
 </div>
 </form><BR><BR>
<?php 
	SplitPage($page,$totalpage,"?name=admin&file=user");
	echo $ShowSumPages ;
	echo "<BR>";
	echo $ShowPages ;
	echo "<BR><BR>";

$res[groupstext] = $db->select_query("SELECT * FROM ".TB_ADMIN_GROUP." ORDER BY id ");
while ($arr[groupstext] = $db->fetch($res[groupstext]))
   {
		echo "<LI><B>".$arr[groupstext][name]." : </B>".$arr[groupstext][description]."</LI>";
   }
$db->closedb ();

}
else if($_GET[op] == "admin_add" AND $_GET[action] == "add"){
	//////////////////////////////////////////// กรณีเพิ่ม User Admin Database
	if(CheckLevel($_SESSION['admin_user'],$_GET[op])){
	$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
	//ตรวจสอบมี user นี้หรือยัง
	$res[admin] = $db->select_query("SELECT id FROM ".TB_ADMIN." WHERE username='".$_POST[USERNAME]."' ");
	$rows[admin] = $db->rows($res[admin]); 
	$db->closedb ();
		if($rows[admin]){
			$ProcessOutput .= "<BR><BR>";
			$ProcessOutput .= "<CENTER><IMG SRC=\"images/icon/notview.gif\" BORDER=\"0\"><BR><BR>";
			$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ชื่อผู้ดูแลระบบ : ".$_POST[USERNAME]." มีในระบบแล้วไม่สามารถเพิ่มได้</B></FONT><BR><BR>";
			$ProcessOutput .= "<A HREF=\"javascript:history.go(-1);\"><B>กลับไปแก้ไข</B></A>";
			$ProcessOutput .= "</CENTER>";
			$ProcessOutput .= "<BR><BR>";
		}else{
			//ทำการเพิ่มข้อมูลลงดาต้าเบส
			$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
			$db->add_db(TB_ADMIN,array(
				"username"=>"$_POST[USERNAME]",
				"password"=>"".md5($_POST[PASSWORD])."",
				"name"=>"$_POST[NAME]",
				"email"=>"$_POST[EMAIL]",
				"level"=>"$_POST[LEVEL]"
			));
			$db->closedb ();
			$ProcessOutput .= "<BR><BR>";
			$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
			$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ได้ทำการเพิ่มชื่อผู้ดูแลระบบ : ".$_POST[USERNAME]." เข้าสู่ระบบเรียบร้อยแล้ว</B></FONT><BR><BR>";
			$ProcessOutput .= "<A HREF=\"?name=admin&file=user\"><B>กลับหน้า จัดการผู้ดูแลระบบ</B></A>";
			$ProcessOutput .= "</CENTER>";
			$ProcessOutput .= "<BR><BR>";
		}
	}else{
		//กรณีไม่ผ่าน
		$ProcessOutput = $PermissionFalse ;
	}
	echo $ProcessOutput ;
}
else if($_GET[op] == "admin_add"){
	//////////////////////////////////////////// กรณีเพิ่ม User Admin Form
	if(CheckLevel($_SESSION['admin_user'],$_GET[op])){
?>
<FORM METHOD=POST ACTION="?name=admin&file=user&op=admin_add&action=add">
<B>ชื่อผู้ใช้ :</B><BR>
<INPUT TYPE="text" NAME="USERNAME" size="40"><BR>
<B>รหัสผ่าน :</B><BR>
<INPUT TYPE="password" NAME="PASSWORD" size="40"><BR>
<B>ชื่อ - นามสกุล :</B><BR>
<INPUT TYPE="text" NAME="NAME" size="40"><BR>
<B>Email :</B><BR>
<INPUT TYPE="text" NAME="EMAIL" size="40"><BR>
<B>Level :</B><BR>
<SELECT NAME="LEVEL">
<?php 
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
$res[groups] = $db->select_query("SELECT * FROM ".TB_ADMIN_GROUP." ORDER BY id ");
   while ($arr[groups] = $db->fetch($res[groups]))
   {
		echo "<option value=\"".$arr[groups][id]."\">".$arr[groups][name]."</option>";
   }
$db->closedb ();
?>
</SELECT>
<BR><BR>
<INPUT TYPE="submit" value=" เพิ่มผู้ดูแลระบบ ">
</FORM>
<?php 
	}else{
		//กรณีไม่ผ่าน
		echo  $PermissionFalse ;
	}
}
else if($_GET[op] == "admin_edit" AND $_GET[action] == "edit"){
	//////////////////////////////////////////// กรณีแก้ไข User Admin Database Edit
	if(CheckLevel($_SESSION['admin_user'],$_GET[op])){
	$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
	//ตรวจสอบมี user นี้หรือยัง
	$res[admin] = $db->select_query("SELECT id FROM ".TB_ADMIN." WHERE username='".$_POST[USERNAME]."' ");
	$rows[admin] = $db->rows($res[admin]); 
	$db->closedb ();
		if($rows[admin] AND ($_POST[USERNAME] != $_POST[USERNAME_OLD])){
			$ProcessOutput .= "<BR><BR>";
			$ProcessOutput .= "<CENTER><IMG SRC=\"images/icon/notview.gif\" BORDER=\"0\"><BR><BR>";
			$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ชื่อผู้ดูแลระบบ : ".$_POST[USERNAME]." มีในระบบแล้วไม่สามารถเพิ่มได้</B></FONT><BR><BR>";
			$ProcessOutput .= "<A HREF=\"javascript:history.go(-1);\"><B>กลับไปแก้ไข</B></A>";
			$ProcessOutput .= "</CENTER>";
			$ProcessOutput .= "<BR><BR>";
		}else{
			if($_POST[PASSWORD]){
				$NewPass = md5($_POST[PASSWORD]);
			}else{
				$NewPass = $_POST[oldpass];
			}
			//ทำการเพิ่มข้อมูลลงดาต้าเบส
			$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
			$db->update_db(TB_ADMIN,array(
				"username"=>"$_POST[USERNAME]",
				"password"=>"$NewPass",
				"name"=>"$_POST[NAME]",
				"email"=>"$_POST[EMAIL]",
				"level"=>"$_POST[LEVEL]"
			)," id='$_GET[id]' ");
			$db->closedb ();
			$ProcessOutput .= "<BR><BR>";
			$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
			$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ได้ทำการแก้ไขผู้ระบบเรียบร้อยแล้ว</B></FONT><BR><BR>";
			$ProcessOutput .= "<A HREF=\"?name=admin&file=user\"><B>กลับหน้า จัดการผู้ดูแลระบบ</B></A>";
			$ProcessOutput .= "</CENTER>";
			$ProcessOutput .= "<BR><BR>";
		}
	}else{
		//กรณีไม่ผ่าน
		$ProcessOutput = $PermissionFalse ;
	}
	echo $ProcessOutput ;
}
else if($_GET[op] == "admin_edit"){
	//////////////////////////////////////////// กรณีแก้ไข User Admin Edit Form
	if(CheckLevel($_SESSION['admin_user'],$_GET[op])){
		//ดึงค่าของผู้ดูแลระบบออกมา
		$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
		$res[admin] = $db->select_query("SELECT * FROM ".TB_ADMIN." WHERE id='".$_GET[id]."' ");
		$arr[admin] = $db->fetch($res[admin]);
		$db->closedb ();
		//ไม่ให้อัพเดทตัวเอง
		if($_SESSION['admin_user'] == $arr[admin][username]){
			$Readonly = " readonly ";
		}
?>
<FORM METHOD=POST ACTION="?name=admin&file=user&op=admin_edit&action=edit&id=<?=$_GET[id];?>">
<B>ชื่อผู้ใช้ :</B><BR>
<INPUT TYPE="text" NAME="USERNAME" size="40" VALUE="<?=$arr[admin][username];?>"><BR><INPUT TYPE="hidden" NAME="USERNAME_OLD" VALUE="<?=$arr[admin][username];?>">
<B>รหัสผ่าน :</B><BR>
<INPUT TYPE="password" NAME="PASSWORD" size="40" VALUE="" <?=$Readonly;?>><BR>
<B>ชื่อ - นามสกุล :</B><BR>
<INPUT TYPE="text" NAME="NAME" size="40" VALUE="<?=$arr[admin][name];?>"><BR>
<B>Email :</B><BR>
<INPUT TYPE="text" NAME="EMAIL" size="40" VALUE="<?=$arr[admin][email];?>"><BR>
<B>Level :</B><BR>
<SELECT NAME="LEVEL">
<?php 
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
$res[groups] = $db->select_query("SELECT * FROM ".TB_ADMIN_GROUP." ORDER BY id ");
   while ($arr[groups] = $db->fetch($res[groups]))
   {
		echo "<option value=\"".$arr[groups][id]."\" ";
		if($arr[groups][id] == $arr[admin][level]){echo " Selected";};
		echo ">".$arr[groups][name]."</option>";
   }
$db->closedb ();
?>
</SELECT>
<BR><BR>
<INPUT TYPE="submit" value=" แก้ไขผู้ดูแลระบบ "><INPUT TYPE="hidden" NAME="oldpass" value="<?=$arr[admin][password];?>">
</FORM>
<?php 
	}else{
		//กรณีไม่ผ่าน
		$ProcessOutput = $PermissionFalse ;
	}
	echo $ProcessOutput ;
}
else if($_GET[op] == "admin_del" AND $_GET[action] == "multidel"){
	//////////////////////////////////////////// กรณีลบ User Admin Multi
	if(CheckLevel($_SESSION['admin_user'],$_GET[op])){
		while(list($key, $value) = each ($_POST['list'])){
			$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
			$db->del(TB_ADMIN," id='".$value."' "); 
			$db->closedb ();
		}
		$ProcessOutput .= "<BR><BR>";
		$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
		$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ได้ทำการลบรายการผู้ระบบเรียบร้อยแล้ว</B></FONT><BR><BR>";
		$ProcessOutput .= "<A HREF=\"?name=admin&file=user\"><B>กลับหน้า จัดการผู้ดูแลระบบ</B></A>";
		$ProcessOutput .= "</CENTER>";
		$ProcessOutput .= "<BR><BR>";
	}else{
		//กรณีไม่ผ่าน
		$ProcessOutput = $PermissionFalse ;
	}
	echo $ProcessOutput ;
}
else if($_GET[op] == "admin_del"){
	//////////////////////////////////////////// กรณีลบ User Admin Form
	if(CheckLevel($_SESSION['admin_user'],$_GET[op])){
		$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
		$db->del(TB_ADMIN," id='".$_GET[id]."' "); 
		$db->closedb ();
		$ProcessOutput .= "<BR><BR>";
		$ProcessOutput .= "<CENTER><A HREF=\"?name=admin&file=main\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
		$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ได้ทำการลบผู้ระบบเรียบร้อยแล้ว</B></FONT><BR><BR>";
		$ProcessOutput .= "<A HREF=\"?name=admin&file=user\"><B>กลับหน้า จัดการผู้ดูแลระบบ</B></A>";
		$ProcessOutput .= "</CENTER>";
		$ProcessOutput .= "<BR><BR>";
	}else{
		//กรณีไม่ผ่าน
		$ProcessOutput = $PermissionFalse ;
	}
	echo $ProcessOutput ;
}
else if($_GET[op] == "minepass_edit" AND $_GET[action] == "edit"){
	//////////////////////////////////////////// กรณีแก้ไขข้อมูลส่วนตัว
	if(CheckLevel($_SESSION['admin_user'],$_GET[op])){
			if(!$_POST[USERNAME] OR !$_POST[NAME] OR !$_POST[EMAIL]){
				$ProcessOutput .= "<BR><BR>";
				$ProcessOutput .= "<CENTER><IMG SRC=\"images/icon/notview.gif\" BORDER=\"0\"><BR><BR>";
				$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>กรุณากรอกข้อมูลต่างๆให้ครบถ้วน</B></FONT><BR><BR>";
				$ProcessOutput .= "<A HREF=\"javascript:history.go(-1);\"><B>กลับไปแก้ไข</B></A>";
				$ProcessOutput .= "</CENTER>";
				$ProcessOutput .= "<BR><BR>";
			}else{
				$Admin_User = $_SESSION[admin_user];
				if($_POST[PASSWORD]){
					$NewPass = md5($_POST[PASSWORD]);
					$URLre = "?name=admin";
					session_unset();
					session_destroy();
				}else{
					$NewPass = $_POST[oldpass];
					$URLre = "?name=admin&file=main";
				}
				//ทำการแก้ไขข้อมูลลงดาต้าเบส
				$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
				$db->update_db(TB_ADMIN,array(
					"username"=>"$_POST[USERNAME]",
					"password"=>"$NewPass",
					"name"=>"$_POST[NAME]",
					"email"=>"$_POST[EMAIL]"
				)," username='$Admin_User' ");
				$db->closedb ();
				$ProcessOutput .= "<BR><BR>";
				$ProcessOutput .= "<CENTER><A HREF=\"".$URLre."\"><IMG SRC=\"images/icon/login-welcome.gif\" BORDER=\"0\"></A><BR><BR>";
				$ProcessOutput .= "<FONT COLOR=\"#336600\"><B>ได้ทำการแก้ไขข้อมูลเรียบร้อยแล้ว</B></FONT><BR><BR>";
				$ProcessOutput .= "<A HREF=\"".$URLre."\"><B>กลับไปหน้าดูแลระบบ</B></A>";
				$ProcessOutput .= "</CENTER>";
				$ProcessOutput .= "<BR><BR>";
		}
	}else{
		//กรณีไม่ผ่าน
		$ProcessOutput = $PermissionFalse ;
	}
	echo $ProcessOutput ;
}
else if($_GET[op] == "minepass_edit"){
	//////////////////////////////////////////// กรณีแก้ไขข้อมูลส่วนตัว
	if(CheckLevel($_SESSION['admin_user'],$_GET[op])){
		//ดึงค่าของผู้ดูแลระบบออกมา
		$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
		$res[admin] = $db->select_query("SELECT * FROM ".TB_ADMIN." WHERE username='".$_SESSION['admin_user']."' ");
		$arr[admin] = $db->fetch($res[admin]);
		$db->closedb ();
?>
<FORM METHOD=POST ACTION="?name=admin&file=user&op=minepass_edit&action=edit">
<B>ชื่อผู้ใช้ :</B><BR>
<INPUT TYPE="text" NAME="USERNAME" size="40" VALUE="<?=$arr[admin][username];?>" readonly style="color=#FF0000;"><BR>
<B>รหัสผ่าน :</B><BR>
<INPUT TYPE="password" NAME="PASSWORD" size="40" VALUE=""><BR>
<B>ชื่อ - นามสกุล :</B><BR>
<INPUT TYPE="text" NAME="NAME" size="40" VALUE="<?=$arr[admin][name];?>"><BR>
<B>Email :</B><BR>
<INPUT TYPE="text" NAME="EMAIL" size="40" VALUE="<?=$arr[admin][email];?>"><BR>
<BR><BR>
<INPUT TYPE="submit" value=" แก้ไขข้อมูลส่วนตัว "><INPUT TYPE="hidden" NAME="oldpass" value="<?=$arr[admin][password];?>">
</FORM>
<?php 
	}else{
		//กรณีไม่ผ่าน
		echo $PermissionFalse ;
	}
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