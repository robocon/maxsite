<TABLE cellSpacing=0 cellPadding=0 width=720 border=0>
    <TBODY>
        <TR>
            <TD width="10" vAlign=top><IMG src="images/fader.gif" border=0></TD>
                <TD width="710" vAlign=top><IMG src="images/topfader.gif" border=0><BR>
                    <!-- News -->
                    &nbsp;&nbsp;<IMG SRC="images/menu/textmenu_knowledge2.gif" BORDER="0"><BR><BR>
                        <div align="right">
                            <form name="categoty">
                                <select name="category" onchange="MM_jumpMenu('parent',this,0)">
                                    <option value="?name=knowledge">-- หมวดหมู่ทั้งหมด --</option>
                                    <?php
                                    $_GET['category'] = intval($_GET['category']);
                                    $db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
                                    $query = $db->select_query("SELECT * FROM ".TB_KNOWLEDGE_CAT." ORDER BY sort  ");
                                    while($item = $db->fetch($query)){
                                        echo "<option value=\"?name=knowledge&category=".$item['id']."\" ";
                                        if($_GET['category'] == $item['id']){
                                            echo " Selected";
                                        }
                                        echo ">".$item['category_name']."</option>\n";
                                    }
                                    $db->closedb ();
                                    ?>
                                </select>
                                <input type="button" name="Button1" value=" Go " onclick="MM_jumpMenuGo('category','parent',0)" />&nbsp;&nbsp;
                            </form>
                        </div>
                        <BR>
                            <TABLE width="700" align=center cellSpacing=0 cellPadding=0 border=0>
                                <?php
                                //แสดงสาระความรู้
                                $SQLwhere = '';
                                $SQLwhere2 = '';
                                if($_GET['category']){
                                    $SQLwhere = " category='".$_GET['category']."' ";
                                    $SQLwhere2 = " WHERE category='".$_GET['category']."' ";
                                }
                                $db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
                                $limit = 20 ;
                                $SUMPAGE = $db->num_rows(TB_KNOWLEDGE,"id","$SQLwhere");
                                $page = isset($_GET['page']) ? intval($_GET['page']) : 0 ;
                                if (empty($page)){
                                    $page=1;
                                }
                                $rt = $SUMPAGE%$limit ;
                                $totalpage = ($rt!=0) ? floor($SUMPAGE/$limit)+1 : floor($SUMPAGE/$limit);
                                $goto = ($page-1)*$limit ;

                                $query = $db->select_query("SELECT * FROM ".TB_KNOWLEDGE." $SQLwhere2 ORDER BY id DESC LIMIT $goto, $limit ");
                                $count=0;
                                while($item = $db->fetch($query)){

                                    if ($count==0) { echo "<TR>"; }
                                    //ชื่อหมวดหมู่
                                    $query = $db->select_query("SELECT category_name FROM ".TB_KNOWLEDGE_CAT." WHERE id='".$item['category']."' ");
                                    $category = $db->fetch($query);
                                    ?>
                                    <TD width="50%" valign=top>
                                        <TABLE width="100%">
                                            <TR>
                                                <TD><FONT COLOR="#990000"><B>
                                                    <?= ThaiTimeConvert($item['post_date'],"","");?> : <?=$category['category_name'];?>
                                                </B></FONT></TD>
                                            </TR>
                                            <TR><TD height="3" ></TD></TR>
                                            <TR>
                                                <TD>
                                                    <A HREF="?name=knowledge&file=readknowledge&id=<?=$item['id'];?>" target="_blank">
                                                        <IMG SRC="knowledgeicon/<?=$item['post_date'];?>.jpg" WIDTH="80" HEIGHT="60" BORDER="0" ALIGN="left" class="topicicon"><B><?=$item['topic'];?></A></B>
                                                            <?php NewsIcon(TIMESTAMP, $item['post_date'], "images/icon_new.gif");?>
                                                            <BR><?=$item['headline'];?>
                                                            </TD>
                                                        </TR>
                                                        <TR><TD height="3" ></TD></TR>
                                                    </TABLE>
                                                </TD>
                                                <?php
                                                $count++;
                                                if (($count%_KNOW_COL) == 0) { echo "</TR><TR><TD colspan=2 height=\"1\" class=\"dotline\"></TD></TR>"; $count=0; }
                                            }
                                            $db->closedb ();
                                            //จบการแสดงข่าวสาร
                                            ?>
                                        </TABLE>
                                        <BR>
                                            <table border="0" cellpadding="0" cellspacing="1" width="700" align=center>
                                                <tr>
                                                    <td>
                                                        <?php
                                                        SplitPage($page,$totalpage,"?name=knowledge&category=".$_GET['category']."");
                                                        echo $ShowSumPages ;
                                                        echo "<BR>";
                                                        echo $ShowPages ;
                                                        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                            <BR><BR>
                                                <!-- End News -->
                                            </TD>
                                        </TR>
                                    </TBODY>
                                </TABLE>
