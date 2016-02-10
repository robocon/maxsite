<table>
    <tbody>
        <tr>
            <td width="10" valign="top"><img src="images/fader.gif" border="0"></td>
                <td width="710" valign="top"><img src="images/topfader.gif" border="0"><br>
                    <!-- News -->
                    &nbsp;&nbsp;<img src="images/menu/textmenu_news.gif" border="0"><br><br>
                    <div align="right">
                        <form name="categoty">
                            <select name="category" onchange="MM_jumpMenu('parent',this,0)">
                                <option value="?name=news">-- หมวดหมู่ทั้งหมด --</option>
                                <?php
                                $category_id = input_get('category');
                                $items = $msdb->fetchAll("SELECT * FROM `web_news_category` ORDER BY `sort`");
                                foreach( $items as $key => $item ){
                                    $selected = ($category_id == $item['id']) ? 'selected="selected"' : '' ;
                                    ?>
                                    <option value="?name=news&category=<?=$item['id'];?>" <?=$selected;?>><?=$item['category_name'];?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <input type="button" name="Button1" value=" Go " onclick="MM_jumpMenuGo('category','parent',0)" />&nbsp;&nbsp;
                        </form>
                    </div>
                    <br>
                    <table width="700" align="center" border="0">
                        <?php
                        //แสดงข่าวสาร/ประชาสัมพันธ์
                        $SQLwhere = '';
                        $SQLwhere2 = '';
                        if($category_id){
                            $SQLwhere = " `category`='".$category_id."' ";
                            $SQLwhere2 = " WHERE a.`category`='".$category_id."' ";
                        }

                        $page = input_get('page', 1);
                        $limit = 20 ;
                        $count = 0;
                        
                        $goto = ( $page - 1 ) * $limit ;

                        $sql = "SELECT a.*, b.`category_name`
                        FROM `web_news` AS a
                        LEFT JOIN `web_news_category` AS b ON b.`id` = a.`category`
                        $SQLwhere2
                        ORDER BY a.`id` DESC LIMIT $goto, $limit";
                        $items = $msdb->fetchAll($sql);

                        $SUMPAGE = count($items);

                        $rt = $SUMPAGE % $limit ;
                        $totalpage = ($rt!=0) ? floor($SUMPAGE/$limit)+1 : floor($SUMPAGE/$limit);

                        foreach( $items as $key => $item ){
                            if ($count==0) { echo "<tr>"; }
                            ?>
                            <td width="50%" valign=top>
                                <table width="100%">
                                    <tr>
                                        <td><font color="#990000"><b>
                                            <?= ThaiTimeConvert($item['post_date'],"","");?> : <?=$item['category_name'];?>
                                        </b></font></td>
                                    </tr>
                                    <tr><td height="3" ></td></tr>
                                    <tr>
                                        <td>
                                            <a href="?name=news&file=readnews&id=<?=$item['id'];?>">
                                                <img src="newsicon/<?=$item['post_date'];?>.jpg" width="48" height="48" border="0" align="left" class="topicicon"><b><?=$item['topic'];?></b>
                                            </a>
                                            <?php NewsIcon(TIMESTAMP, $item['post_date'], "images/icon_new.gif");?>
                                            <br><?=$item['headline'];?>
                                        </td>
                                    </tr>
                                    <tr><td height="3" ></td></tr>
                                </table>
                            </td>
                            <?php
                            $count++;
                            if (($count%_NEWS_COL) == 0) {
                                echo "</tr><tr><td colspan=2 height=\"1\" class=\"dotline\"></td></tr>";
                                $count=0;
                            }
                        }
                        //จบการแสดงข่าวสาร
                        ?>
                    </table>
                    <br>
                    <table border="0" cellpadding="0" cellspacing="1" width="700" align="center">
                        <tr>
                            <td>
                                <?php
                                SplitPage($page,$totalpage,"?name=news&category=".$category_id."");
                                echo $ShowSumPages ;
                                echo "<br>";
                                echo $ShowPages ;
                                ?>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <br>
                        <!-- End News -->
                </td>
            </tr>
        </tbody>
    </table>
