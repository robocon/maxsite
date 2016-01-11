<?php 
session_start();
require_once("mainfile.php");
$PHP_SELF = "index.php";
GETMODULE($_GET[name],$_GET[file]);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE><?=WEB_TITLE;?></TITLE>
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
		Powered by <A HREF="http://maxsite.geniuscyber.com" target="_blank"><?= _SCRIPT." "._VERSION ;?></A>
	</div>
</div>
<script type="text/javascript" src="java.js"></script>
<script language="JavaScript1.2">
function makevisible(cur,which){
  if (which==0)
    cur.filters.alpha.opacity=100
  else
    cur.filters.alpha.opacity=40
}
</script>
<script type="text/JavaScript">
<!--
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
//-->
</script>
<script language="JavaScript">
<!--
function MM_displayStatusMsg(msgStr) { //v1.0
  status=msgStr;
  document.MM_returnValue = true;
}
//-->
</script>
<script type="text/JavaScript">
<!--
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

<body onLoad="MM_preloadImages('images/menu_home02.gif','images/menu_about02.gif','images/menu_project02.gif','images/menu_news02.gif','images/menu_article02.gif','images/menu_board02.gif','images/menu_contact02.gif');" >
<div id="dhtmltooltip"></div>
<script type="text/javascript" src="dhtmltooltip.js"></script>

<TABLE width=760 height="100%" 
border=0 align=center cellPadding=0 cellSpacing=0 background="images/back.gif">
  <TBODY>
    <TR>
      <TD ><div align="center"><IMG src="images/bg_top.jpg" width="720" height="85"></div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
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
          <tr>
            <td height="10"></td>
            <td height="10"></td>
            <td height="10"></td>
          </tr>
        </table>
        <TABLE cellSpacing=0 cellPadding=0 width=720 align=center border=0>
            <TBODY>
              <TR>
                <TD width="86"><IMG src="images/left-en.gif" width="86" height="30"></TD>
                <TD width="619" background="images/leftback.gif"><div align="right"><a href="index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('home','','images/menu_home02.gif',1)"><img src="images/menu_home01.gif" name="home"  border="0"></a><a href="?name=aboutus" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('about','','images/menu_about02.gif',1)"><img src="images/menu_about01.gif" name="about"  border="0"></a><a href="?name=news" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('news','','images/menu_news02.gif',1)"><img src="images/menu_news01.gif" name="news"  border="0"></a><a href="?name=calendar" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('calendar','','images/menu_calendar02.gif',1)"><img src="images/menu_calendar01.gif" name="calendar"  border="0"></a><a href="?name=webboard" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('webboard','','images/menu_board02.gif',1)"><img src="images/menu_board01.gif" name="webboard"  border="0"></a><a href="?name=knowledge" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('article','','images/menu_article02.gif',1)"><img src="images/menu_article01.gif" name="article"  border="0"></a><a href="?name=contact" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('contact','','images/menu_contact02.gif',1)"><img src="images/menu_contact01.gif" name="contact"  border="0"></a></div></TD>
                <TD width="15" background="images/leftback.gif"><div align="right"><img src="images/right_bar.gif" width="14" height="30"></div></TD>
              </TR>
            </TBODY>
        </TABLE>
      <BR></TD>
    </TR>
    <TR>
      <TD  vAlign=top><TABLE cellSpacing=0 cellPadding=0 width=720 align=center border=0>
        <TBODY>
          <TR>
            <TD>
			<!-- Content -->
			<?php include ("".$MODPATHFILE."");?>
			<!-- End Content -->
              </TD>
          </TR>
        </TBODY>
      </TABLE></TD>
    </TR>
    <TR>
      <TD  vAlign=top height="100%"><table width="720" height="100" border="0" align="center" cellpadding="5" cellspacing="0" background="images/bottom-en.jpg">
        <tr>
          <td height="35"><div align="right" class="foottext"><IMG SRC="images/icon/bullet.gif" BORDER="0" ALIGN="absmiddle"> <a href="index.php"><FONT COLOR="#FFFFFF">Home</FONT></a>&nbsp;&nbsp;&nbsp;&nbsp;<IMG SRC="images/icon/bullet.gif" BORDER="0" ALIGN="absmiddle"> <A HREF="?name=aboutus"><FONT COLOR="#FFFFFF">About us</FONT></A>&nbsp;&nbsp;&nbsp;&nbsp;<IMG SRC="images/icon/bullet.gif" BORDER="0" ALIGN="absmiddle"> <A HREF="?name=news"><FONT COLOR="#FFFFFF">News</FONT></A>&nbsp;&nbsp;&nbsp;&nbsp;<IMG SRC="images/icon/bullet.gif" BORDER="0" ALIGN="absmiddle"> <A HREF="?name=calendar"><FONT COLOR="#FFFFFF">Calendar</FONT></A>&nbsp;&nbsp;&nbsp;&nbsp;<IMG SRC="images/icon/bullet.gif" BORDER="0" ALIGN="absmiddle"> <A HREF="?name=webboard"><FONT COLOR="#FFFFFF">Webboard</FONT></A>&nbsp;&nbsp;&nbsp;&nbsp;<IMG SRC="images/icon/bullet.gif" BORDER="0" ALIGN="absmiddle"> <A HREF="?name=knowledge"><FONT COLOR="#FFFFFF">Knowledge</FONT></A>&nbsp;&nbsp;&nbsp;&nbsp;<IMG SRC="images/icon/bullet.gif" BORDER="0" ALIGN="absmiddle"> <A HREF="?name=contact"><FONT COLOR="#FFFFFF">Contact us</FONT></A>&nbsp;&nbsp;&nbsp;&nbsp;<IMG SRC="images/icon/bullet.gif" BORDER="0" ALIGN="absmiddle"> <A HREF="?name=admin<?php if($_SESSION['admin_user']){echo "&file=main";};?>"><FONT COLOR="#FFFFFF">Admin</FONT></A> </div></td>
        </tr>
        <tr>
          <td valign="top"><div align="center" class="foottext"><strong><?=_SCRIPT." "._VERSION ;?> : : Easy & Easy CMS for Thailand.</strong><br>
		  ผู้พัฒนา : <A HREF="http://www.mocyc.com" target="_blank"><FONT COLOR="#E5E5E5">นาย อัษฎา อินต๊ะ</FONT></A> &nbsp; Email : <A HREF="mailto:mocyc@hotmail.com"><FONT COLOR="#E5E5E5">mocyc@hotmail.com</FONT></A><BR>
           <BR><FONT COLOR="#E5E5E5">Powered by </FONT><A HREF="http://maxsite.geniuscyber.com/" target="_blank"><FONT COLOR="#E5E5E5"><?= _SCRIPT." "._VERSION ;?></FONT></A>
			</div></td>
        </tr>
      </table></TD>
    </TR>
  </TBODY>
</TABLE>
</body>
</html>
