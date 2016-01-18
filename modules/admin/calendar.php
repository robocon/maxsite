<?php
CheckAdmin($_SESSION['admin_user'], $_SESSION['admin_pwd']);
?>
<style type="text/css">
<!--
.calendar {
    width:220;
    background-color: #FFFFFF;
}
-->
</style>
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
                                    <BR><B><IMG SRC="images/icon/plus.gif" BORDER="0" ALIGN="absmiddle"> <A HREF="?name=admin&file=main">หน้าหลักผู้ดูแลระบบ</A> &nbsp;&nbsp;<IMG SRC="images/icon/arrow_wap.gif" BORDER="0" ALIGN="absmiddle">&nbsp;&nbsp; ปฏิทินกิจกรรม &nbsp;&nbsp;<IMG SRC="images/icon/calendar.gif" BORDER="0" ALIGN="absmiddle">&nbsp;&nbsp; <A HREF="popup.php?name=admin&file=addevent" onclick="return hs.htmlExpand(this, { contentId: 'highslide-html', objectType: 'iframe', objectWidth: 700, objectHeight: 500} )" class="highslide">เพิ่มรายการใหม่ </A></B>
                                        <BR><BR>
                                            <CENTER>
                                                <?php
                                                if(!isset($_GET['year'])){
                                                    $_GET['year'] = date("Y");
                                                }
                                                $cal = new MyCalendar();
                                                echo $cal->getYearView($_GET['year']);
                                                ?>
                                            </CENTER>
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
