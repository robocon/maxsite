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
					<BR><BR>
						<TABLE width=90% align=center>
						<TR>
							<TD width=50%><A HREF="?name=admin&file=editortalk"><IMG SRC="images/admin/i-editor.png"  BORDER="0" align="absmiddle"> <B>Editor Talk</B></A></TD>
							<TD width=50%><A HREF="?name=admin&file=news"><IMG SRC="images/admin/i-knowledge.png"  BORDER="0" align="absmiddle"> <B>จัดการข่าวสารประชาสัมพันธ์ </B></A></TD>
						</TR>
						<TR>
							<TD><A HREF="?name=admin&file=aboutus"><IMG SRC="images/admin/i-knowledge.png"  BORDER="0" align="absmiddle"> <B>เกี่ยวกับเรา</B></A></TD>
							<TD><A HREF="?name=admin&file=knowledge"><IMG SRC="images/admin/i-knowledge.png"  BORDER="0" align="absmiddle"> <B>จัดการสาระความรู้ </B></A></TD>
						</TR>
						<TR>
							<TD><A HREF="?name=admin&file=calendar"><IMG SRC="images/admin/i-calendar.png"  BORDER="0" align="absmiddle"> <B>จัดการปฏิทินกิจกรรม</B></A></TD>
							<TD><A HREF="?name=admin&file=webboard_category"><IMG SRC="images/admin/i-webboard.png"  BORDER="0" align="absmiddle"> <B>จัดการหมวดหมู่เว็บบอร์ด</B></A></TD>
						</TR>
						<TR>
							<TD>&nbsp;</TD>
							<TD>&nbsp;</TD>
						</TR>
						<TR>
							<TD><A HREF="?name=admin&file=user"><IMG SRC="images/admin/i-groups.png"  BORDER="0" align="absmiddle"> <B>จัดการผู้ดูแลระบบ </B></A></TD>
							<TD><A HREF="?name=admin&file=user&op=minepass_edit"><IMG SRC="images/admin/i-lock.png"  BORDER="0" align="absmiddle"> <B>แก้ไขข้อมูลส่วนตัว</B></A></TD>
						</TR>
						<TR>
							<TD><A HREF="?name=admin&file=logout"><IMG SRC="images/admin/i-logout.png"  BORDER="0" align="absmiddle"> <B>ออกจากระบบ</B></A></TD>
							<TD></TD>
						</TR>
						</TABLE>
					</TD>
				</TR>
			</TABLE>
			<BR><BR>
			<!-- Admin -->
		  </TD>
        </TR>
      </TBODY>
    </TABLE>