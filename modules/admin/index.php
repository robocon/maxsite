<?php
if( isset($_SESSION['admin_user']) ){
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=?name=admin&file=main\">";
}
?>
<TABLE cellSpacing=0 cellPadding=0 width=720 border=0>
	<TBODY>
		<TR>
			<TD width="10" vAlign=top><IMG src="images/fader.gif" border=0></TD>
				<TD width="710" vAlign=top><IMG src="images/topfader.gif" border=0><BR>
					<!-- Admin -->
					&nbsp;&nbsp;<IMG SRC="images/menu/textmenu_admin.gif" BORDER="0"><BR>
						<TABLE width="700" align=center cellSpacing=0 cellPadding=0 border=0>
							<TR>
								<TD height="1" class="dotline"></TD>
							</TR>
							<TR>
								<TD>
									<BR><BR>
										<FORM METHOD=POST ACTION="?name=admin&file=login">
											<TABLE width=300 align=center>
												<TR>
													<TD width="100" align="right"><B>ชื่อผู้ใช้ : </B></TD>
													<TD><INPUT TYPE="text" NAME="username"></TD>
													</TR>
													<TR>
														<TD width="100" align="right"><B>รหัสผ่าน : </B></TD>
														<TD><INPUT TYPE="password" NAME="password"></TD>
														</TR>
														<?php
														if(USE_CAPCHA){
															?>
															<TR>
																<TD width="100" align="right">
																	<?php if(CAPCHA_TYPE == 1){
																		echo "<img src=\"capcha/CaptchaSecurityImages.php?width=".CAPCHA_WIDTH."&height=".CAPCHA_HEIGHT."&characters=".CAPCHA_NUM."\" width=\"".CAPCHA_WIDTH."\" height=\"".CAPCHA_HEIGHT."\" align=\"absmiddle\" />";
																	}else if(CAPCHA_TYPE == 2){
																		echo "<img src=\"capcha/val_img.php?width=".CAPCHA_WIDTH."&height=".CAPCHA_HEIGHT."&characters=".CAPCHA_NUM."\" width=\"".CAPCHA_WIDTH."\" height=\"".CAPCHA_HEIGHT."\" align=\"absmiddle\" />";
																	};?>
																</TD>
																<TD><input name="security_code" type="text" id="security_code" maxlength="6" ></TD>
															</TR>
															<?php
														}
														?>
														<TR>
															<TD width="100" align="right"></TD>
															<TD><INPUT TYPE="submit" VALUE=" เข้าระบบ "></TD>
															</TR>
														</TABLE>
													</FORM>
												</TD>
											</TR>
										</TABLE>
										<div align="center"><br />
											<br />
											<img src="images/logo_ie.gif" alt="" width="38" height="42" />  &nbsp;&nbsp;&nbsp;<img src="images/logo_firefox.jpg" alt="" width="38" height="36" /> &nbsp;&nbsp;<img src="images/logo_mozilla.gif" alt="" width="46" height="36" /> &nbsp;&nbsp;<img src="images/logo_netscape.jpg" alt="" width="35" height="36" /><br />
											Administrator is compatible with most <br />
											Internet browsers which include: IE 5.5+ (Windows), <br />
											Firefox 1.0+, Mozilla 1.3+ and Netscape 7.1+. <br />
											It runs under Windows, Mac and Linux operating systems.</div>
											<BR><BR>
												<!-- Admin -->
											</TD>
										</TR>
									</TBODY>
								</TABLE>
