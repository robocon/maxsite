    <TABLE cellSpacing=0 cellPadding=0 width=720 border=0>
      <TBODY>
        <TR>
          <TD width="10" vAlign=top><IMG src="images/fader.gif" border=0></TD>
          <TD width="710" vAlign=top><IMG src="images/topfader.gif" border=0><BR>
		  <!-- About us -->
		  &nbsp;&nbsp;<IMG SRC="images/menu/textmenu_aboutus.gif" BORDER="0"><BR>
				<TABLE width="700" align=center cellSpacing=0 cellPadding=0 border=0>
				<TR>
					<TD height="1" class="dotline"></TD>
				</TR>
				<TR>
					<TD>
					<BR>
<?php 
$FileAboutUs = "aboutus/aboutus.html";
$FileAboutUsOpen = @fopen($FileAboutUs, "r");
$AboutUsContent = @fread ($FileAboutUsOpen, @filesize($FileAboutUs));
@fclose ($FileAboutUsOpen);
$AboutUsContent = stripslashes($AboutUsContent);
echo $AboutUsContent;
?>
					<BR><BR>
					</TD>
				</TR>
			</TABLE>
			<BR><BR>
			<!-- About us -->
		  </TD>
        </TR>
      </TBODY>
    </TABLE>