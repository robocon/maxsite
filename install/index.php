<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>MAXSITE 1.10 : : ติดตั้งโปรแกรม</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div align="center">
  <p>&nbsp;</p>
  <p><img src="../images/icon/login-welcome.gif" alt="" width="97" height="105" /><br />
    <br />
      <strong>การติดตั้ง MAXSITE 1.10</strong><br />
    กรุณากรอกข้อมูลต่างๆให้ครบทุกช่องครับ
      <br />
  และให้สร้างดาต้าเบสขึ้นมาก่อนนะครับ</p>
  <form id="install" name="install" method="post" action="install.php">
    <table width="300" border="0" cellspacing="5" cellpadding="0">
      <tr>
        <td height="20" colspan="2" bgcolor="#E8F8FF"><strong>Database</strong></td>
      </tr>
      <tr>
        <td width="122"><div align="right">Hostname : </div></td>
        <td width="163"><div align="left">
          <input name="db_hostname" type="text" id="db_hostname" value="localhost" />
        </div></td>
      </tr>
      <tr>
        <td><div align="right">Database Name :</div></td>
        <td><div align="left">
          <input name="db_name" type="text" id="db_name" />
        </div></td>
      </tr>
      <tr>
        <td><div align="right">Database Username : </div></td>
        <td><div align="left">
          <input name="db_username" type="text" id="db_username" />
        </div></td>
      </tr>
      <tr>
        <td><div align="right">Database Password : </div></td>
        <td><div align="left">
          <input name="db_password" type="password" id="db_password" />
        </div></td>
      </tr>
      <tr>
        <td><div align="right"></div></td>
        <td><div align="left"></div></td>
      </tr>
      <tr>
        <td height="20" colspan="2" bgcolor="#E8F8FF"><strong>Website Config </strong></td>
      </tr>
      <tr>
        <td><div align="right">Website URL : </div></td>
        <td><div align="left">
          <input name="web_url" type="text" id="web_url" value="http://" />
        </div></td>
      </tr>
      <tr>
        <td><div align="right">Email : </div></td>
        <td><div align="left">
          <input name="web_email" type="text" id="web_email" />
        </div></td>
      </tr>
      <tr>
        <td><div align="right"></div></td>
        <td><div align="left"></div></td>
      </tr>
      <tr>
        <td height="20" colspan="2" bgcolor="#E8F8FF"><strong>Capcha</strong> ตัวอักษรยืนยันการโพส </td>
      </tr>
      <tr>
        <td><div align="right">การใช้งาน Capcha : </div></td>
        <td><div align="left">
            <input name="use_capcha" type="radio" value="true" checked="checked" />
          ใช้งาน 
            <input name="use_capcha" type="radio" value="false" />
ไม่ใช้งาน </div></td>
      </tr>
      <tr>
        <td valign="top"><div align="right">ชนิด Capcha : </div></td>
        <td><div align="left">
          <input name="capcha_type" type="radio" value="2" checked="checked" />
          แบบตัวอักษรปกติ<br />
          <input name="capcha_type" type="radio" value="1" />
        แบบกำหนดตัวอักษร</div></td>
      </tr>
      <tr>
        <td><div align="right">จำนวนตัวอักษร : </div></td>
        <td><div align="left">
          <input name="capcha_num" type="text" id="capcha_num" value="6" size="5" maxlength="2" />
        </div></td>
      </tr>
      <tr>
        <td><div align="right"></div></td>
        <td><div align="left"></div></td>
      </tr>
      <tr>
        <td colspan="2"><div align="center">
          <input type="submit" name="Submit" value=" ติดตั้ง MAXSITE 1.10 " />
        </div></td>
      </tr>
    </table>
  </form>
  <p>&nbsp;</p>
</div>
</body>
</html>
