    <TABLE cellSpacing=0 cellPadding=0 width=720 border=0>
      <TBODY>
        <TR>
          <TD width="10" vAlign=top><IMG src="images/fader.gif" border=0></TD>
          <TD width="710" vAlign=top><IMG src="images/topfader.gif" border=0><BR>
		  <!-- Webboard -->
		  &nbsp;&nbsp;<IMG SRC="images/menu/textmenu_webboard.gif" BORDER="0"><BR>
<?
$_GET['category'] = intval($_GET['category']);
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
$res[BoardCat] = $db->select_query("SELECT * FROM ".TB_WEBBOARD_CAT." ORDER BY sort ");
while($arr[BoardCat] = $db->fetch($res[BoardCat])){
	echo "<TABLE width=95% align=center border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><TR><TD><LI><B><A HREF=\"?name=webboard&category=".$arr[BoardCat][id]."\">".$arr[BoardCat][category_name]."</A></B></TD>";
	//Sum Album
	$SumCat = $db->num_rows(TB_WEBBOARD,"id"," category='".$arr[BoardCat][id]."' "); 
	echo "<TD width=\"100\" align=right><FONT COLOR=\"#808080\">".number_format($SumCat)."</FONT>&nbsp;&nbsp;</TD></TR></TABLE>";
	echo "<TABLE width=95% align=center><TR><TD height=1 class=\"dotline\"></TD></TR></TABLE>\n";
}

if($_GET[category]){
	$SQLwhere = " pin_date='' AND category='".$_GET[category]."' ";
	$SQLwhere2 = " WHERE pin_date='' AND category='".$_GET[category]."' ";
	$SQLwherePin = " WHERE pin_date!='' AND category='".$_GET[category]."' ";
	//ชื่อหมวดหมู่ 
	$res[category] = $db->select_query("SELECT category_name FROM ".TB_WEBBOARD_CAT." WHERE id='".$_GET[category]."' "); 
	$arr[category] = $db->fetch($res[category]);
	$CatShow = $arr[category][category_name];
}else{
	$CatShow = "รายการกระทู้ทั้งหมด";
	$SQLwhere = " pin_date='' ";
	$SQLwhere2 = " WHERE pin_date='' ";
	$SQLwherePin = " WHERE pin_date!='' ";
}
?>
<BR>
<div align="right"><B><IMG SRC="images/icon/icon_folder.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALIGN="absmiddle"> <A HREF="?name=webboard">รายการกระทู้ทั้งหมด</A> &nbsp;&nbsp;&nbsp; <IMG SRC="images/icon/icon_add.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALIGN="absmiddle"> <A HREF="?name=webboard&file=post">ตั้งกระทู้ใหม่ </A></B>&nbsp;&nbsp;</div>
<BR>
<table width="95%"  align="center" border="0" cellspacing="2" cellpadding="0">
<tr><td colspan="3" height="30" bgcolor="#CC3300">&nbsp;&nbsp;<IMG SRC="images/icon/graph-i.gif" BORDER="0" ALIGN="absmiddle"> <FONT SIZE="2" COLOR="#FFFFFF"><B><?=$CatShow;?></B></FONT></td></tr>
<tr height="20">
	<td bgcolor="#E5E5E5"><CENTER><B>หัวข้อ (อ่าน/ตอบ)</B></CENTER></td>
	<td bgcolor="#E5E5E5" width="120"><CENTER><B>โดย</B></CENTER></td>
	<td bgcolor="#E5E5E5" width="120"><CENTER><B>วันที่</B></CENTER></td>
</tr>
<tr><td colspan="3" height=1 class="dotline"></td></tr>
<?
//แสดงกระทู้ปักหมุด
$res[Pin] = $db->select_query("SELECT * FROM ".TB_WEBBOARD." $SQLwherePin ORDER BY pin_date DESC  LIMIT "._SHOW_BOARD_PIN." ");
while($arr[Pin] = $db->fetch($res[Pin])){
	$SumComm = $db->num_rows(TB_WEBBOARD_COMMENT,"id"," topic_id='".$arr[Pin][id]."' "); 
	echo "<tr height=\"20\"><td bgcolor=\"#E7FCE0\"><IMG SRC=\"images/icon/dock.gif\" BORDER=\"0\" ALIGN=\"absmiddle\"> <B>".sprintf("%0"._NUM_ID."d",$arr[Pin][id])." : </B> <A HREF=\"?name=webboard&file=read&id=".$arr[Pin][id]."\" target=\"_blank\">".$arr[Pin][topic]."</A> ";
	//กรณีแนบรูป
	if($arr[Pin][picture]){
		echo "<IMG SRC=\"images/attach.gif\" BORDER=\"0\" ALIGN=\"absmiddle\"> ";
	}else{ };
	//กรณีกระทู้ใหม่ 
	NewsIcon(TIMESTAMP, $arr[Pin][post_date], "images/icon_new.gif");
	echo "<FONT FACE=\"tahoma\" COLOR=\"#808080\">(".number_format($arr[Pin][pageview])."/".number_format($SumComm).")</FONT></td>\n";
	echo "<td bgcolor=\"#E7FCE0\" width=\"120\"><CENTER><B><FONT COLOR=\"#6600FF\">";
	//กรณีสมาชิก
	if($arr[Pin][is_member]){
		echo "<IMG SRC=\"images/human.gif\" BORDER=\"0\" ALIGN=\"absmiddle\"> <B><FONT COLOR=\"#FF0066\">";
	}else{ };
	echo "".$arr[Pin][post_name]."</FONT></B></CENTER></td>\n";
	echo "<td bgcolor=\"#E7FCE0\" width=\"120\"><CENTER><FONT COLOR=\"#339900\">".ThaiTimeConvert($arr[Pin][post_date],"","2")."</FONT></CENTER></td>\n";
	echo "<tr><td colspan=\"3\" height=1 class=\"dotline\"></td></tr>\n";
}


//แสดงผลกระทู้ 
$limit = _PERPAGE_BOARD ;
$SUMPAGE = $db->num_rows(TB_WEBBOARD,"id","$SQLwhere");
$page=$_GET[page];
if (empty($page)){
	$page=1;
}
$rt = $SUMPAGE%$limit ;
$totalpage = ($rt!=0) ? floor($SUMPAGE/$limit)+1 : floor($SUMPAGE/$limit); 
$goto = ($page-1)*$limit ;

$Color = 0; 
$BoardResult = $db->select_query("SELECT * FROM ".TB_WEBBOARD." $SQLwhere2 ORDER BY id DESC  LIMIT $goto, $limit ");
while($WebBoard = $db->fetch($BoardResult)){
	if($Color == 0){
		$Color = 1 ;
		$ColorFill = "#F0F0F0";
	}else{
		$Color = 0 ;
		$ColorFill = "#FDEAFB";
	}
	//Sum comment
	$SumComm = $db->num_rows(TB_WEBBOARD_COMMENT,"id"," topic_id='".$WebBoard[id]."' "); 
	echo "<tr height=\"20\"><td bgcolor=\"".$ColorFill."\"><IMG SRC=\"images/icon/dok.gif\" BORDER=\"0\" ALIGN=\"absmiddle\"> <B>".sprintf("%0"._NUM_ID."d",$WebBoard[id])." : </B> <A HREF=\"?name=webboard&file=read&id=".$WebBoard[id]."\" target=\"_blank\">".$WebBoard[topic]."</A> ";
	//กรณีแนบรูป
	if($WebBoard[picture]){
		echo "<IMG SRC=\"images/attach.gif\" BORDER=\"0\" ALIGN=\"absmiddle\"> ";
	}else{ };
	//กรณีกระทู้ใหม่ 
	NewsIcon(TIMESTAMP, $WebBoard[post_date], "images/icon_new.gif");
	echo "<FONT FACE=\"tahoma\" COLOR=\"#808080\">(".number_format($WebBoard[pageview])."/".number_format($SumComm).")</FONT></td>\n";
	echo "<td bgcolor=\"".$ColorFill."\" width=\"120\"><CENTER><B><FONT COLOR=\"#6600FF\">";
	//กรณีสมาชิก
	if($WebBoard[is_member]){
		echo "<IMG SRC=\"images/human.gif\" BORDER=\"0\" ALIGN=\"absmiddle\"> <B><FONT COLOR=\"#FF0066\">";
	}else{ };
	echo "".$WebBoard[post_name]."</FONT></B></CENTER></td>\n";
	echo "<td bgcolor=\"".$ColorFill."\" width=\"120\"><CENTER><FONT COLOR=\"#339900\">".ThaiTimeConvert($WebBoard[post_date],"","2")."</FONT></CENTER></td>\n";
	echo "<tr><td colspan=\"3\" height=1 class=\"dotline\"></td></tr>\n";
}
@mysql_free_result($BoardResult);
$db->closedb();
echo "</table>";

?>
				<BR>
				<table border="0" cellpadding="0" cellspacing="1" width="700" align=center>
					<tr>
						<td>
				<?
				SplitPage($page,$totalpage,"?name=webboard&category=".$_GET[category]."");
				echo $ShowSumPages ;
				echo "<BR>";
				echo $ShowPages ;
				?>
						</td>
					</tr>
				</table>

			<BR><BR>
			<!-- webboard -->
		  </TD>
        </TR>
      </TBODY>
    </TABLE>