<table width="720">
    <tbody>
        <tr>
            <td width="250" valign="top" style="vertical-align: top;">
                <!-- Left -->
                <img src="images/menu/textmenu_news.gif" border="0"><br><br>
                <table width="250" align="top">
                    <?php
                    //แสดงข่าวสาร/ประชาสัมพันธ์
                    $items = $msdb->fetchAll("SELECT * FROM `web_news` ORDER BY `id` DESC LIMIT 5;");
                    foreach( $items as $key => $item ){
                        //Comment Icon
                        if($item['enable_comment']){
                            $CommentIcon = " <img SRC=\"images/icon/suggest.gif\" width=\"13\" height=\"9\" border=\"0\" align=\"absmiddle\">";
                        }else{
                            $CommentIcon = "";
                        }
                        ?>
                        <tr>
                            <td><font color="#990000"><b>
                                <?= ThaiTimeConvert($item['post_date'],"","");?>
                            </b></font></td>
                        </tr>
                        <tr><td height="3" ></td></tr>
                        <tr>
                            <td>
                                <a href="?name=news&file=readnews&id=<?=$item['id'];?>">
                                    <img src="newsicon/<?=$item['post_date'];?>.jpg" width="48" height="48" border="0" align="left" class="topicicon" ><b><?=$item['topic'];?></b>
                                </a>
                                <?php NewsIcon(TIMESTAMP, $item['post_date'], "images/icon_new.gif");?>
                                <br>
                                <?=$item['headline'];?><?=$CommentIcon;?>
                            </td>
                        </tr>
                        <tr><td height="3" ></td></tr>
                        <tr><td height="1" class="dotline"></td></tr>
                        <tr><td height="3" ></td></tr>
                    <?php
                    }
                    //จบการแสดงข่าวสาร
                    ?>
                </table>
                <br><br>
                <img src="images/menu/textmenu_calendar.gif" border="0"><br><br>
                <?php
                // If no month/year set, use current month/year
                $d = getdate(time());
                $month = ( isset($_GET['month']) ) ? intval($_GET['month']) : $d['mon'] ;
                $year = ( isset($_GET['year']) ) ? intval($_GET['year']) : $d['year'] ;
                $cal = new MyCalendar;
                echo $cal->getMonthView($month, $year);
                ?>
                <div align=right><a href="?name=calendar">&gt;&gt; รายการกิจกรรมทั้งหมด</a> </div>
                <!-- End Left -->
            </td>
            <td width="10" valign="top"><img src="images/fader.gif"></td>
            <td width="460" valign="top" style="vertical-align: top;">
                <img src="images/topfader.gif"><br>
                <img src="images/menu/textmenu_welcome.gif" border="0">
                <table width=100% cellspacing="5">
                    <tr>
                        <td>
                            <?php
                            $contents = file_get_contents('editortalk/editortalk.html');
                            echo stripslashes($contents);
                            ?>
                        </td>
                    </tr>
                </table>
                <br>
                <table width="100%" align="top" cellspacing="5">
                    <tr>
                        <td valign="top">
                            <img src="images/menu/textmenu_knowledge.gif" border="0">
                            <table width="100%" align="top" cellspacing="5">
                                <?php
                                //แสดงบทความ
                                $items = $msdb->fetchAll("SELECT * FROM `web_knowledge` ORDER BY `id` DESC LIMIT 2;");
                                foreach( $items as $key => $item ){
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="?name=knowledge&file=readknowledge&id=<?=$item['id'];?>" >
                                                <img src="knowledgeicon/<?=$item['post_date'];?>.jpg" border="0" align="left" class="topicicon" style="filter:alpha(opacity=100)" onMouseover="makevisible(this,1)" onMouseout="makevisible(this,0)"> <b><?=$item['topic'];?></b>
                                            </a>
                                            <?php NewsIcon(TIMESTAMP, $item['post_date'], "images/icon_new.gif");?>
                                            <br>
                                            <?=$item['headline'];?>
                                            <?php
                                            if($item['enable_comment']){
                                                echo " <img SRC=\"images/icon/suggest.gif\" width=\"13\" height=\"9\" border=\"0\" align=\"absmiddle\">";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr><td height="3" ></td></tr>
                                    <tr><td height="1" class="dotline"></td></tr>
                                    <tr><td height="3" ></td></tr>
                                <?php
                                }
                                //จบการแสดงบทความ
                                ?>
                            </table>
                        </td>
                    </tr>
                </table>
                <!-- บทความ Text Random -->
                <table width="100%" align="top" cellspacing="5">
                    <?php
                    //แสดงบทความ Text Random
                    $items = $msdb->fetchAll("SELECT * FROM `web_knowledge` ORDER BY RAND() LIMIT 5;");
                    foreach ($items as $key => $item) {
                        ?>
                        <tr>
                            <td>
                                <img src="images/icon/icon_page.gif" border="0" align="absmiddle"> <a href="?name=knowledge&file=readknowledge&id=<?=$item['id'];?>" ><?=$item['topic'];?></a> <?php if($item['enable_comment']){echo " <img SRC=\"images/icon/suggest.gif\" width=\"13\" height=\"9\" border=\"0\" align=\"absmiddle\">";}else{};?>
                            </td>
                        </tr>
                        <tr><td height="1" class="dotline"></td></tr>
                    <?php
                    }
                    //จบการแสดงบทความ Text Random
                    ?>
                    <tr>
                        <td></td>
                    </tr>
                </table>
                <!-- จบบทความ Text Random -->

                <br><br>
                <!-- เว็บบอร์ดล่าสุด -->
                <img src="images/menu/textmenu_webboard.gif" border="0">
                <table width="100%" align="top" cellspacing="5">
                    <?php
                    //แสดงเว็บบอร์ดล่าสุด
                    $items = $msdb->fetchAll("SELECT * FROM `web_webboard` ORDER BY `id` LIMIT 10;");
                    foreach( $items as $key => $item){
                        ?>
                        <tr>
                            <td>
                                <img src="images/icon/icon_page.gif" border="0" align="absmiddle">
                                <a href="?name=webboard&file=read&id=<?=$item['id'];?>" ><?=$item['topic'];?></a>
                                <?php NewsIcon(TIMESTAMP, $item['post_date'], "images/icon_new.gif");?>
                            </td>
                        </tr>
                        <tr><td height="1" class="dotline"></td></tr>
                    <?php
                    }
                    //จบการแสดงเว็บบอร์ดล่าสุด
                    ?>
                    <tr>
                        <td></td>
                    </tr>
                </table>
                <div align=right><a href="?name=webboard">&gt;&gt; รายการกระทู้ทั้งหมด</a> </div>
                <br><br>
            </td>
        </tr>
    </tbody>
</table>
