<TABLE cellSpacing=0 cellPadding=0 width=720 border=0>
    <TBODY>
        <TR>
            <TD width="10" vAlign=top><IMG src="images/fader.gif" border=0></TD>
            <TD width="710" vAlign=top><IMG src="images/topfader.gif" border=0><BR>
                <!-- Webboard -->
                &nbsp;&nbsp;<IMG SRC="images/menu/textmenu_webboard.gif" BORDER="0"><BR>
                <?php
                $cat_id = input_get('category');

                $sql = "SELECT COUNT(a.`id`) AS `rows`, b.`id`, b.`category_name`
                FROM `web_webboard` AS a
                RIGHT JOIN `web_webboard_category` AS b ON b.`id` = a.`category`
                GROUP BY a.`category`
                ORDER BY b.`id` ASC";
                $items = $msdb->fetchAll($sql);
                foreach( $items as $key => $item ){
                    echo "<TABLE width=95% align=center border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><TR><TD><LI><B><A HREF=\"?name=webboard&category=".$item['id']."\">".$item['category_name']."</A></B></TD>";
                    echo "<TD width=\"100\" align=right><FONT COLOR=\"#808080\">".$item['rows']."</FONT>&nbsp;&nbsp;</TD></TR></TABLE>";
                    echo "<TABLE width=95% align=center><TR><TD height=1 class=\"dotline\"></TD></TR></TABLE>\n";
                }

                $CatShow = "รายการกระทู้ทั้งหมด";
                $SQLwhere = " pin_date='' ";
                $SQLwhere2 = " WHERE pin_date='' ";
                $SQLwherePin = " WHERE pin_date!='' ";
                if($cat_id){
                    $SQLwhere = " pin_date='' AND category='".$cat_id."' ";
                    $SQLwhere2 = " WHERE pin_date='' AND category='".$cat_id."' ";
                    $SQLwherePin = " WHERE pin_date!='' AND category='".$cat_id."' ";

                }
                ?>
                <BR>
                <div align="right">
                    <B><IMG SRC="images/icon/icon_folder.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALIGN="absmiddle"> <A HREF="?name=webboard">รายการกระทู้ทั้งหมด</A>
                    &nbsp;&nbsp;&nbsp; <IMG SRC="images/icon/icon_add.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALIGN="absmiddle"> <A HREF="?name=webboard&file=post">ตั้งกระทู้ใหม่ </A>
                    </B>&nbsp;&nbsp;
                </div>
                <BR>
                <table width="95%"  align="center" border="0" cellspacing="2" cellpadding="0">
                    <tr><td colspan="3" height="30" bgcolor="#CC3300">&nbsp;&nbsp;<IMG SRC="images/icon/graph-i.gif" BORDER="0" ALIGN="absmiddle"> <FONT SIZE="2" COLOR="#FFFFFF"><B><?=$CatShow;?></B></FONT></td></tr>
                    <tr height="20">
                        <td bgcolor="#E5E5E5"><CENTER><B>หัวข้อ (อ่าน/ตอบ)</B></CENTER></td>
                        <td bgcolor="#E5E5E5" width="120"><CENTER><B>โดย</B></CENTER></td>
                        <td bgcolor="#E5E5E5" width="120"><CENTER><B>วันที่</B></CENTER></td>
                    </tr>
                    <tr><td colspan="3" height=1 class="dotline"></td></tr>
                    <?php
                    //แสดงกระทู้ปักหมุด
                    $sql = "SELECT * FROM `web_webboard` $SQLwherePin ORDER BY `pin_date` DESC LIMIT "._SHOW_BOARD_PIN;
                    $items = $msdb->fetchAll($sql);
                    foreach( $items as $key => $pin ){
                        $SumComm = $db->num_rows(TB_WEBBOARD_COMMENT,"id"," topic_id='".$pin['id']."' ");
                        echo "<tr height=\"20\"><td bgcolor=\"#E7FCE0\"><IMG SRC=\"images/icon/dock.gif\" BORDER=\"0\" ALIGN=\"absmiddle\"> <B>".sprintf("%0"._NUM_ID."d",$pin['id'])." : </B> <A HREF=\"?name=webboard&file=read&id=".$pin['id']."\" target=\"_blank\">".$pin['topic']."</A> ";
                        //กรณีแนบรูป
                        if($pin['picture']){
                            echo "<IMG SRC=\"images/attach.gif\" BORDER=\"0\" ALIGN=\"absmiddle\"> ";
                        }
                        //กรณีกระทู้ใหม่
                        NewsIcon(TIMESTAMP, $pin['post_date'], "images/icon_new.gif");
                        echo "<FONT FACE=\"tahoma\" COLOR=\"#808080\">(".number_format($pin['pageview'])."/".number_format($SumComm).")</FONT></td>\n";
                        echo "<td bgcolor=\"#E7FCE0\" width=\"120\"><CENTER><B><FONT COLOR=\"#6600FF\">";
                        //กรณีสมาชิก
                        if($pin['is_member']){
                            echo "<IMG SRC=\"images/human.gif\" BORDER=\"0\" ALIGN=\"absmiddle\"> <B><FONT COLOR=\"#FF0066\">";
                        }
                        echo "".$pin['post_name']."</FONT></B></CENTER></td>\n";
                        echo "<td bgcolor=\"#E7FCE0\" width=\"120\"><CENTER><FONT COLOR=\"#339900\">".ThaiTimeConvert($pin['post_date'],"","2")."</FONT></CENTER></td>\n";
                        echo "<tr><td colspan=\"3\" height=1 class=\"dotline\"></td></tr>\n";
                    }

                    //แสดงผลกระทู้
                    $limit = _PERPAGE_BOARD ;
                    $SUMPAGE = $db->num_rows(TB_WEBBOARD,"id","$SQLwhere");

                    $wb = $msdb->fetch("SELECT COUNT(`id`) AS `rows` FROM `web_webboard` WHERE $SQLwhere");
                    $SUMPAGE = $wb['rows'];
                    $page = input_get('page', 0);
                    if (empty($page)){
                        $page = 1;
                    }
                    $rt = $SUMPAGE%$limit ;
                    $totalpage = ($rt!=0) ? floor($SUMPAGE/$limit)+1 : floor($SUMPAGE/$limit);
                    $goto = ($page-1)*$limit ;

                    $Color = 0;

                    $sql = "SELECT * FROM `web_webboard` $SQLwhere2 ORDER BY `id` DESC LIMIT $goto, $limit";
                    $items = $msdb->fetchAll($sql);
                    foreach( $items as $key => $WebBoard ){
                        if($Color == 0){
                            $Color = 1 ;
                            $ColorFill = "#F0F0F0";
                        }else{
                            $Color = 0 ;
                            $ColorFill = "#FDEAFB";
                        }
                        //Sum comment

                        $wwc = $msdb->fetch("SELECT COUNT(`id`) AS `rows` FROM `web_webboard_comment` WHERE topic_id = :topic_id", array('topic_id' => $WebBoard['id']));
                        $SumComm = $wwc['rows'];

                        echo "<tr height=\"20\"><td bgcolor=\"".$ColorFill."\"><IMG SRC=\"images/icon/dok.gif\" BORDER=\"0\" ALIGN=\"absmiddle\"> <B>".sprintf("%0"._NUM_ID."d",$WebBoard['id'])." : </B> <A HREF=\"?name=webboard&file=read&id=".$WebBoard['id']."\" target=\"_blank\">".$WebBoard['topic']."</A> ";
                        //กรณีแนบรูป
                        if($WebBoard['picture']){
                            echo "<IMG SRC=\"images/attach.gif\" BORDER=\"0\" ALIGN=\"absmiddle\"> ";
                        }else{ };
                        //กรณีกระทู้ใหม่
                        NewsIcon(TIMESTAMP, $WebBoard['post_date'], "images/icon_new.gif");
                        echo "<FONT FACE=\"tahoma\" COLOR=\"#808080\">(".number_format($WebBoard['pageview'])."/".number_format($SumComm).")</FONT></td>\n";
                        echo "<td bgcolor=\"".$ColorFill."\" width=\"120\"><CENTER><B><FONT COLOR=\"#6600FF\">";
                        //กรณีสมาชิก
                        if($WebBoard['is_member']){
                            echo "<IMG SRC=\"images/human.gif\" BORDER=\"0\" ALIGN=\"absmiddle\"> <B><FONT COLOR=\"#FF0066\">";
                        }else{ };
                        echo "".$WebBoard['post_name']."</FONT></B></CENTER></td>\n";
                        echo "<td bgcolor=\"".$ColorFill."\" width=\"120\"><CENTER><FONT COLOR=\"#339900\">".ThaiTimeConvert($WebBoard['post_date'],"","2")."</FONT></CENTER></td>\n";
                        echo "<tr><td colspan=\"3\" height=1 class=\"dotline\"></td></tr>\n";
                    }
                    echo "</table>";

                    ?>
                    <BR>
                    <table border="0" cellpadding="0" cellspacing="1" width="700" align=center>
                        <tr>
                            <td>
                                <?php
                                SplitPage($page,$totalpage,"?name=webboard&category=".$cat_id."");
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
