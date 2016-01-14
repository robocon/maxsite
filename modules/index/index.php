<TABLE cellSpacing=0 cellPadding=0 width=720 border=0>
    <TBODY>
        <TR>
            <TD width="250" vAlign=top>
                <!-- Left -->
                <IMG SRC="images/menu/textmenu_news.gif" BORDER="0"><BR><BR>
                    <TABLE width="250" align=top cellSpacing=0 cellPadding=0 border=0>
                        <?php
                        //แสดงข่าวสาร/ประชาสัมพันธ์
                        $db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
                        $query = $db->select_query("SELECT * FROM ".TB_NEWS." ORDER BY id DESC LIMIT 5 ");
                        while($item = $db->fetch($query)){
                            //Comment Icon
                            if($item['enable_comment']){
                                $CommentIcon = " <IMG SRC=\"images/icon/suggest.gif\" WIDTH=\"13\" HEIGHT=\"9\" BORDER=\"0\" ALIGN=\"absmiddle\">";
                            }else{
                                $CommentIcon = "";
                            }
                            ?>
                            <TR>
                                <TD><FONT COLOR="#990000"><B>
                                    <?= ThaiTimeConvert($item['post_date'],"","");?>
                                </B></FONT></TD>
                            </TR>
                            <TR><TD height="3" ></TD></TR>
                            <TR>
                                <TD>
                                    <A HREF="?name=news&file=readnews&id=<?=$item['id'];?>" target="_blank">
                                        <IMG SRC="newsicon/<?=$item['post_date'];?>.jpg" WIDTH="48" HEIGHT="48" BORDER="0" ALIGN="left" class="topicicon" style="filter:alpha(opacity=100)" onMouseover="makevisible(this,1)" onMouseout="makevisible(this,0)"><B><?=$item['topic'];?></A></B>
                                            <?php NewsIcon(TIMESTAMP, $item['post_date'], "images/icon_new.gif");?>
                                            <BR><?=$item['headline'];?><?=$CommentIcon;?>
                                            </TD>
                                        </TR>
                                        <TR><TD height="3" ></TD></TR>
                                        <TR><TD height="1" class="dotline"></TD></TR>
                                        <TR><TD height="3" ></TD></TR>
                                        <?php
                                    }
                                    $db->closedb ();
                                    //จบการแสดงข่าวสาร
                                    ?>
                                </TABLE>
                                <BR><BR>
                                    <IMG SRC="images/menu/textmenu_calendar.gif" BORDER="0"><BR><BR>
                                        <?php
                                        // If no month/year set, use current month/year
                                        $d = getdate(time());
                                        $month = ( isset($_GET['month']) ) ? intval($_GET['month']) : $d['mon'] ;
                                        $year = ( isset($_GET['year']) ) ? intval($_GET['year']) : $d['year'] ;
                                        $cal = new MyCalendar;
                                        echo $cal->getMonthView($month, $year);
                                        ?>
                                        <div align=right><A HREF="?name=calendar">&gt;&gt; รายการกิจกรรมทั้งหมด</A> </div>




                                        <!-- End Left -->
                                    </TD>
                                    <TD width="10" vAlign=top><IMG src="images/fader.gif" border=0></TD>
                                        <TD width="460" vAlign=top><IMG src="images/topfader.gif" border=0><BR>
                                            <IMG SRC="images/menu/textmenu_welcome.gif" BORDER="0">
                                                <TABLE width=100% cellSpacing=5 cellPadding=0 border=0>
                                                    <TR>
                                                        <TD>
                                                            <?php
                                                            $FileEditorTalk = "editortalk/editortalk.html";
                                                            $FileEditorTalkOpen = @fopen($FileEditorTalk, "r");
                                                            $EditorTalkContent = @fread ($FileEditorTalkOpen, @filesize($FileEditorTalk));
                                                            @fclose ($FileEditorTalkOpen);
                                                            $EditorTalkContent = stripslashes($EditorTalkContent);
                                                            echo $EditorTalkContent;
                                                            ?>
                                                        </TD>
                                                    </TR>
                                                </TABLE>
                                                <BR>
                                                    <TABLE width="100%" align=top cellSpacing=5 cellPadding=0 border=0>
                                                        <TR>
                                                            <TD valign=top>
                                                                <IMG SRC="images/menu/textmenu_knowledge.gif" BORDER="0">
                                                                    <TABLE width="100%" align=top cellSpacing=5 cellPadding=0 border=0>
                                                                        <?php
                                                                        //แสดงบทความ
                                                                        $db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
                                                                        $query = $db->select_query("SELECT * FROM ".TB_KNOWLEDGE." ORDER BY id DESC LIMIT 2 ");
                                                                        while($item = $db->fetch($query)){
                                                                            ?>
                                                                            <TR>
                                                                                <TD>
                                                                                    <A HREF="?name=knowledge&file=readknowledge&id=<?=$item['id'];?>" target="_blank"><IMG SRC="knowledgeicon/<?=$item['post_date'];?>.jpg" BORDER="0" ALIGN="left" class="topicicon" style="filter:alpha(opacity=100)" onMouseover="makevisible(this,1)" onMouseout="makevisible(this,0)"> <B><?=$item['topic'];?></B></A>
                                                                                        <?php NewsIcon(TIMESTAMP, $item['post_date'], "images/icon_new.gif");?>
                                                                                        <BR><?=$item['headline'];?> <?php if($item['enable_comment']){echo " <IMG SRC=\"images/icon/suggest.gif\" WIDTH=\"13\" HEIGHT=\"9\" BORDER=\"0\" ALIGN=\"absmiddle\">";}else{};?>
                                                                                        </TD>
                                                                                    </TR>
                                                                                    <TR><TD height="3" ></TD></TR>
                                                                                    <TR><TD height="1" class="dotline"></TD></TR>
                                                                                    <TR><TD height="3" ></TD></TR>
                                                                                    <?php
                                                                                }
                                                                                $db->closedb ();
                                                                                //จบการแสดงบทความ
                                                                                ?>
                                                                            </TABLE>
                                                                        </TD>
                                                                    </TR>
                                                                </TABLE>
                                                                <!-- บทความ Text Random -->
                                                                <TABLE width="100%" align=top cellSpacing=5 cellPadding=0 border=0>
                                                                    <?php
                                                                    //แสดงบทความ Text Random
                                                                    $db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
                                                                    $query = $db->select_query("SELECT * FROM ".TB_KNOWLEDGE." ORDER BY rand() LIMIT 5 ");
                                                                    while($item = $db->fetch($query)){
                                                                        ?>
                                                                        <TR>
                                                                            <TD>
                                                                                <IMG SRC="images/icon/icon_page.gif" BORDER="0" ALIGN="absmiddle"> <A HREF="?name=knowledge&file=readknowledge&id=<?=$item['id'];?>" target="_blank"><?=$item['topic'];?></A> <?php if($item['enable_comment']){echo " <IMG SRC=\"images/icon/suggest.gif\" WIDTH=\"13\" HEIGHT=\"9\" BORDER=\"0\" ALIGN=\"absmiddle\">";}else{};?>
                                                                                </TD>
                                                                            </TR>
                                                                            <TR><TD height="1" class="dotline"></TD></TR>
                                                                            <?php
                                                                        }
                                                                        $db->closedb ();
                                                                        //จบการแสดงบทความ Text Random
                                                                        ?>
                                                                        <TR>
                                                                            <TD></TD>
                                                                        </TR>
                                                                    </TABLE>
                                                                    <!-- จบบทความ Text Random -->

                                                                    <BR><BR>
                                                                        <!-- เว็บบอร์ดล่าสุด -->
                                                                        <IMG SRC="images/menu/textmenu_webboard.gif" BORDER="0">
                                                                            <TABLE width="100%" align=top cellSpacing=5 cellPadding=0 border=0>
                                                                                <?php
                                                                                //แสดงเว็บบอร์ดล่าสุด
                                                                                $db->connectdb(DB_NAME,DB_USERNAME,DB_PASSWORD);
                                                                                $query = $db->select_query("SELECT * FROM ".TB_WEBBOARD." ORDER BY id DESC LIMIT 10 ");
                                                                                while($item = $db->fetch($query)){
                                                                                    ?>
                                                                                    <TR>
                                                                                        <TD>
                                                                                            <IMG SRC="images/icon/icon_page.gif" BORDER="0" ALIGN="absmiddle"> <A HREF="?name=webboard&file=read&id=<?=$item['id'];?>" target="_blank"><?=$item['topic'];?></A>
                                                                                                <?php NewsIcon(TIMESTAMP, $item['post_date'], "images/icon_new.gif");?>
                                                                                            </TD>
                                                                                        </TR>
                                                                                        <TR><TD height="1" class="dotline"></TD></TR>
                                                                                        <?php
                                                                                    }
                                                                                    $db->closedb ();
                                                                                    //จบการแสดงเว็บบอร์ดล่าสุด
                                                                                    ?>
                                                                                    <TR>
                                                                                        <TD></TD>
                                                                                    </TR>
                                                                                </TABLE>
                                                                                <div align=right><A HREF="?name=webboard">&gt;&gt; รายการกระทู้ทั้งหมด</A> </div>

                                                                                <BR><BR>

                                                                                </TD>
                                                                            </TR>
                                                                        </TBODY>
                                                                    </TABLE>
