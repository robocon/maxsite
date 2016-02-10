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
		  <!-- News -->
		  &nbsp;&nbsp;<IMG SRC="images/menu/textmenu_calendar.gif" BORDER="0"><BR><BR>
						<CENTER>
						<?php
                        $year = input_get('year', date("Y"));
						$cal = new MyCalendar();
						echo $cal->getYearView($year);
						?>
						</CENTER>
				<BR><BR>
			<!-- End News -->
		  </TD>
        </TR>
      </TBODY>
    </TABLE>
