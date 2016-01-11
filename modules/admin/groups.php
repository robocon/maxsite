<?
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
<?
//////////////////////////////////////////// แสดงรายชื่อกลุ่มผู้ดูแลระบบ
if($_GET[op] == ""){
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
<?
$res[groups] = $db->select_query("SELECT * FROM ".TB_ADMIN_GROUP." ORDER BY id LIMIT $goto, $limit ");
while($arr[groups] = $db->fetch($res[groups])){
	$row[user] = $db->num_rows(TB_ADMIN,"id"," level=".$arr[groups][id]." ");
?>
    <tr>
     <td width="60" align="center">
      <a href="?name=admin&file=groups&op=group_edit&id=<? echo $arr[groups][id];?>"><img src="images/admin/edit.gif" border="0" alt="แก้ไข" ></a> 
      <a href="javascript:Confirm('?name=admin&file=groups&op=group_del&id=<? echo $arr[groups][id];?>&level=<?echo $arr[groups][name];?>','คุณมั่นใจในการลบระดับผู้ใช้ : <?echo $arr[groups][name];?>');"><img src="images/admin/trash.gif"  border="0" alt="ลบ" ></a>
     </td> 
     <td><? echo $arr[groups][name];?></td>
     <td ><CENTER><? echo $row[user];?></CENTER></td>
     <td align="center" width="40"><input type="checkbox" name="list[]" value="<? echo $arr[groups][id];?>"></td>
    </tr>
	<TR>
		<TD colspan="4" height="1" class="dotline"></TD>
	</TR>
<?
 } 
?>
 </table>
 <div align="right">
 <input type="button" name="CheckAll" value="Check All" onclick="checkAll(document.myform)" >
 <input type="button" name="UnCheckAll" value="Uncheck All" onclick="uncheckAll(document.myform)" >
 <input type="submit" value="Delete" >
 </div>
 </form><BR><BR>
<?
	SplitPage($page,$totalpage,"?name=admin&file=groups");
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
else if($_GET[op] == "group_add" AND $_GET[action] == "add"){
	//////////////////////////////////////////// กรณีเพิ่ม Group Admin Database
	if(CheckLevel($_SESSION['admin_user'],$_GET[op])){
		$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
		$sql[GROUP] = mysql_query("SELECT * FROM ".TB_ADMIN_GROUP." WHERE name='".$_POST[GROUP_NAME]."'") or die(mysql_error());
		$q[GROUPS] = "SELECT * FROM ".TB_ADMIN_GROUP." ";
		$sql[GROUPS] = mysql_query($q[GROUPS]);  
	/*******/
		$q[GROUPS] = "INSERT INTO ".TB_ADMIN_GROUP." VALUES(0,'".addslashes(htmlspecialchars($_POST[GROUP_NAME]))."','".addslashes(htmlspecialchars($_POST[GROUP_DESC]))."',";
		for($x=3;$x<mysql_num_fields($sql[GROUPS]);$x++)
		{
		$fname =  mysql_field_name($sql[GROUPS], $x);
		$q[GROUPS] .= "'".$_POST[$fname]."'";
		if($x < mysql_num_fields($sql[GROUPS])-1) $q[GROUPS] .= ", ";
		}
		$q[GROUPS] .= ");";
	/*******/
		if(mysql_num_rows($sql[GROUP])<1) {
		mysql_query($q[GROUPS]) or die (mysql_error());
		}
		$db->closedb ();

		$ProcessOutput .= "<BR><BR>";
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
else if($_GET[op] == "group_add"){
	//////////////////////////////////////////// กรณีเพิ่ม Group Admin Form
	if(CheckLevel($_SESSION['admin_user'],$_GET[op])){
?>
<FORM name="groups" METHOD=POST ACTION="?name=admin&file=groups&op=group_add&action=add">
     <B>ชื่อกลุ่ม :</B><br>
        <input type="text"  name="GROUP_NAME" size="40"><br>
        <B>รายละเอียด :</B><br>
        <input type="text" name="GROUP_DESC"  size="40"><br>
        <br>
        <B>กรุณาเลือก :</B><br>
<?
	 $m = 0;
	 $fnum = 3;
	$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
	 $q[GROUPS] = "SELECT * FROM ".TB_ADMIN_GROUP." " ;
	 $sql[GROUPS] = mysql_query($q[GROUPS]);  

	 echo '<table cellspacing="1" cellpadding="4"  bgcolor="#669999">';
	 for($x=3;$x<mysql_num_fields($sql[GROUPS]);$x++)
	 {
	  $fname[GROUPS] =  mysql_field_name($sql[GROUPS], $x);
	  list($name,$task) = explode("_",$fname[GROUPS]);
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
	  echo '<td><input type="checkbox" name="'.$fname[GROUPS].'"  value="1"> '.$task.'</td>';
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
<?
	}else{
		//กรณีไม่ผ่าน
		echo  $PermissionFalse ;
	}
}
else if($_GET[op] == "group_edit" AND $_GET[action] == "edit"){
	//////////////////////////////////////////// กรณีแก้ไข User Admin Database Edit
	if(CheckLevel($_SESSION['admin_user'],$_GET[op])){
		$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
		$q[GROUPS] = "SELECT * FROM ".TB_ADMIN_GROUP." ";
		$sql[GROUPS] = mysql_query($q[GROUPS]);  

		$q[GROUPS] = "UPDATE ".TB_ADMIN_GROUP." SET name='".addslashes(htmlspecialchars($_POST[GROUP_NAME]))."', description='".addslashes(htmlspecialchars($_POST[GROUP_DESC]))."', ";
		for($x=3;$x<mysql_num_fields($sql[GROUPS]);$x++)
		{
		$fname =  mysql_field_name($sql[GROUPS], $x);
		$q[GROUPS] .= $fname."='".$_POST[$fname]."'";
		if($x < mysql_num_fields($sql[GROUPS])-1) $q[GROUPS] .= ", ";
		}
		$q[GROUPS] .= " WHERE id='".$_GET[id]."';";
	  /******/
		$sql[GROUPS] = mysql_query($q[GROUPS]) or die (mysql_error());
		$db->closedb ();
		$ProcessOutput .= "<BR><BR>";
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
else if($_GET[op] == "group_edit"){
	//////////////////////////////////////////// กรณีแก้ไข Group Admin Edit Form
	if(CheckLevel($_SESSION['admin_user'],$_GET[op])){
		//ดึงกลุ่มผู้ดูแลระบบออกมา
		$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
		$res[group] = $db->select_query("SELECT * FROM ".TB_ADMIN_GROUP." WHERE id='".$_GET[id]."' ");
		$arr[group] = $db->fetch($res[group]);
		$db->closedb ();
?>
<form action="?name=admin&file=groups&op=group_edit&action=edit&id=<?=$_GET[id];?>" name="groups" method="post">
     <B>ชื่อกลุ่ม :</B><br>
        <input type="text"  name="GROUP_NAME" size="40" value="<?echo $arr[group][name];?>"><br>
        <B>รายละเอียด :</B><br>
        <input type="text" name="GROUP_DESC"  size="40" value="<?echo $arr[group][description];?>"><br>
        <br>
        <B>กรุณาเลือก :</B><br>
<?
	 $m = 0;
	 $fnum = 3;
	$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
	 $q[GROUPS] = "SELECT * FROM ".TB_ADMIN_GROUP." " ;
	 $sql[GROUPS] = mysql_query($q[GROUPS]);  

	 echo '<table cellspacing="1" cellpadding="4"  bgcolor="#669999">';
	 for($x=3;$x<mysql_num_fields($sql[GROUPS]);$x++)
	 {
	  $fname[GROUPS] =  mysql_field_name($sql[GROUPS], $x);
	  list($name,$task) = explode("_",$fname[GROUPS]);
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
	  echo '<td><input type="checkbox" name="'.$fname[GROUPS].'" ';
	  if($arr[group][$fname[GROUPS]] == 1)
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
<?
	}else{
		//กรณีไม่ผ่าน
		$ProcessOutput = $PermissionFalse ;
	}
	echo $ProcessOutput ;
}
else if($_GET[op] == "group_del" AND $_GET[action] == "multidel"){
	//////////////////////////////////////////// กรณีลบ User Admin Multi
	if(CheckLevel($_SESSION['admin_user'],$_GET[op])){
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
else if($_GET[op] == "group_del"){
	//////////////////////////////////////////// กรณีลบ Group Admin Form
	if(CheckLevel($_SESSION['admin_user'],$_GET[op])){
		$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
		$db->del(TB_ADMIN_GROUP," id='".$_GET[id]."' "); 
		$db->closedb ();
		$ProcessOutput .= "<BR><BR>";
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