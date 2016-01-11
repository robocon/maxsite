<?
if(!$_POST[NAME] OR !$_POST[COMMENT]){
	echo "<script language='javascript'>" ;
	echo "alert('!!!! กรุณากรอกข้อมูลต่างๆให้ครบถ้วนครับ !!!!')" ;
	echo "</script>" ;
	echo "<script language='javascript'>javascript:history.go(-1)</script>";
	exit() ;
}
if(USE_CAPCHA){
	if($_SESSION['security_code'] != $_POST['security_code'] OR empty($_POST['security_code'])) {
		echo "<script language='javascript'>" ;
		echo "alert('!!!! กรุณากรอกโค๊ดให้ถูกต้อง !!!!')" ;
		echo "</script>" ;
		echo "<script language='javascript'>javascript:history.go(-1)</script>";
		exit();
	}
}
checkban($_POST[NAME]);
checkban($_POST[COMMENT]);

$_GET['id'] = intval($_GET['id']);
//ทำการเพิ่มข้อมูลลงดาต้าเบส
$db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
$db->add_db(TB_NEWS_COMMENT,array(
	"news_id"=>"$_GET[id]",
	"name"=>"".htmlspecialchars($_POST[NAME])."",
	"comment"=>"".htmlspecialchars($_POST[COMMENT])."",
	"ip"=>"".IPADDRESS."",
	"post_date"=>"".TIMESTAMP.""
));
$db->closedb ();
?>
	<TABLE cellSpacing=0 cellPadding=0 width=720 border=0>
      <TBODY>
        <TR>
          <TD width="10" vAlign=top><IMG src="images/fader.gif" border=0></TD>
          <TD width="710" vAlign=top><IMG src="images/topfader.gif" border=0><BR>
		  <!-- News -->
		  &nbsp;&nbsp;<IMG SRC="images/menu/textmenu_news.gif" BORDER="0"><BR><BR>
				<BR><BR><BR><BR>
				<CENTER><IMG SRC="images/icon/download.gif" BORDER="0"><BR><BR>
				<FONT SIZE="3" COLOR="#336600"><B>ได้ทำการบันทึกความคิดเห็นของท่านเรียบร้อยแล้ว</B></FONT><BR><BR>
				<A HREF="?name=news&file=readnews&id=<?=$_GET[id];?>">กลับไปหน้าแสดงผล</A>
				</CENTER>

				<BR><BR><BR><BR>
			<!-- End News -->
		  </TD>
        </TR>
      </TBODY>
    </TABLE>