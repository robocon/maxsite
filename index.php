<?php
session_start();

$PHP_SELF = "index.php";
define('_MAXSITE', '1');

// โหลดคอนฟิกและไฟล์พื้นฐาน
include 'mainfile.php';

$name = input_get('name', 'index');
$file = input_get('file', 'index');
GETMODULE($name, $file);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
    <head>
        <title><?=WEB_TITLE;?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="keywords" content="เว็บสำเร็จรูป,อัษฎา,มอไซค์ดอทคอม, maxsite">
        <meta name="description" content="เว็บไซต์สำเร็จรูป maxsite">
        <link href="style.css" rel="stylesheet" type="text/css">

        <script type="text/javascript" src="highslide/highslide.js"></script>
        <script type="text/javascript" src="highslide/highslide-html.js"></script>
        <script type="text/javascript">
        hs.graphicsDir = 'highslide/graphics/';
        hs.outlineType = 'rounded-white';
        hs.outlineWhileAnimating = true;
        hs.objectLoadTime = 'after';
        </script>
        <div class="highslide-html-content" id="highslide-html" style="width: 500px">
            <div class="highslide-move" style="border: 0; height: 18px; padding: 2px; cursor: default">
                <a href="#" onclick="return hs.close(this)" class="control">[x] ปิดหน้าต่างนี้ </a>
            </div>
            <div class="highslide-body"></div>
            <div style="text-align: center; border-top: 1px solid silver; padding: 5px 0">
                Powered by <a href="http://maxsite.geniuscyber.com" target="_blank"><?= _SCRIPT." "._VERSION ;?></a>
            </div>
        </div>

        <script type="text/javascript" src="java.js"></script>
        <script type="text/javascript">
        <!--
        function makevisible(cur,which){
            if (which==0)
            cur.filters.alpha.opacity=100
            else
            cur.filters.alpha.opacity=40
        }
        function MM_swapImgRestore() { //v3.0
            var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
        }

        function MM_preloadImages() { //v3.0
            var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
            var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
            if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
        }

        function MM_findObj(n, d) { //v4.01
            var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
            d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
            if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
            for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
            if(!x && d.getElementById) x=d.getElementById(n); return x;
        }

        function MM_swapImage() { //v3.0
            var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
            if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
        }

        function MM_displayStatusMsg(msgStr) { //v1.0
            status=msgStr;
            document.MM_returnValue = true;
        }

        function MM_jumpMenu(targ,selObj,restore){ //v3.0
            eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
            if (restore) selObj.selectedIndex=0;
        }

        function MM_findObj(n, d) { //v4.01
            var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
            d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
            if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
            for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
            if(!x && d.getElementById) x=d.getElementById(n); return x;
        }

        function MM_jumpMenuGo(selName,targ,restore){ //v3.0
            var selObj = MM_findObj(selName); if (selObj) MM_jumpMenu(targ,selObj,restore);
        }
        //-->
        </script>

    </head>
    <body onload="MM_preloadImages('images/menu_home02.gif','images/menu_about02.gif','images/menu_project02.gif','images/menu_news02.gif','images/menu_article02.gif','images/menu_board02.gif','images/menu_contact02.gif');" >
        <div id="dhtmltooltip"></div>
        <script type="text/javascript" src="dhtmltooltip.js"></script>

        <table width="760" height="100%" align="center" background="images/back.gif" style="margin: 0 auto;">
        <tbody>
            <tr>
                <td>
                    <div align="center"><img src="images/bg_top.jpg" width="720" height="85"></div>
                    <table width="100%">
                        <tr>
                            <td width="2%" height="150"></td>
                            <td width="96%"><div align="center">
                                <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="720" height="150">
                                    <param name="movie" value="images/head.swf">
                                    <param name="quality" value="high">
                                    <param name="wmode" value="transparent">
                                    <embed src="images/head.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="720" height="150"></embed>
                                </object>
                            </div></td>
                            <td width="2%">&nbsp;</td>
                        </tr>
                    </table>
                    <div class="main-menu-contain">
                        <div style="float: left;">
                            <img src="images/left-en.gif" width="86" height="30">
                        </div>
                        <div class="main-menu" style="background-image: url('images/leftback.gif'); float: left;">
                            <ul>
                                <li><a href="index.php"><img src="images/menu_home01.gif" name="home" ></a></li>
                                <li><a href="?name=aboutus"><img src="images/menu_about01.gif" name="about" ></a></li>
                                <li><a href="?name=news"><img src="images/menu_news01.gif" name="news" ></a></li>
                                <li><a href="?name=calendar"><img src="images/menu_calendar01.gif" name="calendar" ></a></li>
                                <li><a href="?name=webboard"><img src="images/menu_board01.gif" name="webboard" ></a></li>
                                <li><a href="?name=knowledge"><img src="images/menu_article01.gif" name="article" ></a></li>
                                <li><a href="?name=contact"><img src="images/menu_contact01.gif" name="contact" ></a></li>
                            </ul>
                        </div>
                        <div style="float: left;">
                            <img src="images/right_bar.gif" width="14" height="30">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td valign=top>
                    <table width="720" align="center" style="margin: 0 auto;">
                        <tbody>
                            <tr>
                                <td>
                                    <!-- Content -->
                                    <?php include $MODPATHFILE;?>
                                    <!-- End Content -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td  valign=top height="100%">
                    <table width="720" height="100" align="center" cellpadding="5" background="images/bottom-en.jpg" background-repeat="no-repeat">
                        <tr>
                            <td height="35">
                                <div align="right" class="foottext">
                                    <img src="images/icon/bullet.gif" align="absmiddle"> <a href="index.php"><font color="#FFFFFF">Home</font></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <img src="images/icon/bullet.gif" align="absmiddle"> <a href="?name=aboutus"><font color="#FFFFFF">About us</font></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <img src="images/icon/bullet.gif" align="absmiddle"> <a href="?name=news"><font color="#FFFFFF">News</font></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <img src="images/icon/bullet.gif" align="absmiddle"> <a href="?name=calendar"><font color="#FFFFFF">Calendar</font></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <img src="images/icon/bullet.gif" align="absmiddle"> <a href="?name=webboard"><font color="#FFFFFF">Webboard</font></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <img src="images/icon/bullet.gif" align="absmiddle"> <a href="?name=knowledge"><font color="#FFFFFF">Knowledge</font></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <img src="images/icon/bullet.gif" align="absmiddle"> <a href="?name=contact"><font color="#FFFFFF">Contact us</font></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <img src="images/icon/bullet.gif" align="absmiddle"> <a href="?name=admin<?php if(isset($_SESSION['admin_user'])){ echo "&file=main";};?>"><font color="#FFFFFF">Admin</font></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <div align="center" class="foottext">
                                    <strong><?=_SCRIPT." "._VERSION ;?> : : Easy & Easy CMS for Thailand.</strong><br>
                                    ผู้พัฒนา : <a href="http://www.mocyc.com" target="_blank"><font color="#E5E5E5">นาย อัษฎา อินต๊ะ</font></a> &nbsp; Email : <a href="mailto:mocyc@hotmail.com"><font color="#E5E5E5">mocyc@hotmail.com</font></a><br>
                                    <br><font color="#E5E5E5">Powered by </font><a href="http://maxsite.geniuscyber.com/" target="_blank"><font color="#E5E5E5"><?= _SCRIPT." "._VERSION ;?></font></a>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
        </table>
    </body>
</html>
