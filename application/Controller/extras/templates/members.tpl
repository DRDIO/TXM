<TABLE WIDTH='772' BORDER='0' CELLPADDING='0' CELLSPACING='0'>
	<TR>
		<TD HEIGHT='100' COLSPAN='4'><A HREF='http://www.txmafia.com/'><IMG SRC='http://www.txmafia.com/extras/images/extras_header_upload.gif' WIDTH='193' HEIGHT='100' BORDER='0' /></A><A HREF='http://extras.txmafia.com/'><IMG SRC='http://www.txmafia.com/extras/images/extras_header.gif' WIDTH='579' HEIGHT='100' BORDER='0'></A></TD>
	</TR>		
	
	<TR>
		<TD VALIGN='top' WIDTH='193' VALIGN='top' STYLE='background: url(http://www.txmafia.com/extras/images/extras_side_body1.gif);'>
			{CELLBLOCK_SIDEBAR}</TD>

		<TD WIDTH='579' VALIGN='top' STYLE='background: url(http://www.txmafia.com/extras/images/extras_main_body1.gif);'>
			<TABLE BORDER='0' CELLSPACING='0' CELLPADDING='0' STYLE='font: 12px Verdana;'>
				<TR>
					<TD COLSPAN='2'>
						<IMG SRC='http://www.txmafia.com/extras/images/extras_main_online.gif' WIDTH='579' HEIGHT='32' BORDER='0'></TD>
				</TR>
			
				<TR>
					<TD COLSPAN='2' STYLE='font-weight: bold; background: left url(http://www.txmafia.com/extras/images/extras_main_body2.gif); padding: 2px 11px 2px 11px;'>
						<TABLE WIDTH='772' BORDER=0 CELLPADDING=6 CELLSPACING=0>
							<TR><TD VALIGN='bottom' STYLE='{LARGE_COMIC_FONT}'>
								<A HREF='/'>MAFIA MEMBER LIST</A><BR>
								<SPAN STYLE='{SUB_INFO_FONT}'><B>{PAGINATION}</B></TD>
							</TR>
						
							<TR><TD COLSPAN=2 VALIGN='top'>
								<TABLE BORDER=0 CELLPADDING=6 CELLSPACING=1 BGCOLOR='{LIGHT_COLOR_2}' WIDTH='760'>
									<TR><FORM METHOD='post' ACTION='{S_MODE_ACTION}'><TD ALIGN='right' STYLE='{SUB_INFO_FONT}' BGCOLOR='{DARK_COLOR_2}' BACKGROUND='/images/header_info.gif'>
										{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;{L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;&nbsp; 
										<INPUT TYPE='submit' NAME='submit' VALUE='{L_SUBMIT}' CLASS='liteoption'><BR>
										{L_SORT_PER_LETTER}:&nbsp;{S_LETTER_SELECT}&nbsp;{S_LETTER_HIDDEN}<BR>
										{TOTAL_MEMBERS_RETURNED} member(s) returned! OMG!</TD>
									</FORM></TR>
								</TABLE>
							</TD></TR>
						
							<TR><TD COLSPAN=2 >
								<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=1 BGCOLOR='#6080BF' WIDTH='760'>
									<TR><TD BACKGROUND='http://www.txmafia.com/images/forum_info.gif'>
										<TABLE BORDER=0 CELLPADDING=6 CELLSPACING=0 WIDTH='100%' STYLE='{MEDIUM_COMIC_FONT}'>
											<TR><TD WIDTH='320'><B>{L_USERNAME}</B></TD>
											<TD WIDTH='120'><B>{L_FROM}</B></TD>
											<TD WIDTH='100'><B>{L_JOINED}</B></TD>
											<TD WIDTH='40'><B>[P]</B></TD>
											<TD WIDTH='50'><B>[R]</B></TD>
											<TD WIDTH='80'><B>{L_WEBSITE}</B></TD>
											</TR>
										</TABLE>
									</TD></TR>
						
						<!-- BEGIN memberrow -->
									<TR><TD CLASS='row1' onMouseOver='trig_box("{topicrow.LAST_POST_TIME}"); this.style.backgroundColor="#142649";' onMouseOut='trig_box(); this.style.backgroundColor="";'>
										<TABLE BORDER=0 CELLPADDING=3 CELLSPACING=0 WIDTH='100%' STYLE='{MEDIUM_COMIC_FONT}'>
											<TR VALIGN='middle'>
												<TD WIDTH='20' STYLE='{SUB_INFO_FONT}' ALIGN='right'>{memberrow.ROW_NUMBER}</TD>
												<TD WIDTH='120' STYLE='{MEDIUM_FONT}'><B><A HREF='{memberrow.U_VIEWPROFILE}'>{memberrow.USERNAME}</A></TD>
												<TD WIDTH='160' ALIGN='center'>{memberrow.PM_IMG}{memberrow.EMAIL_IMG}</TD>
												<TD WIDTH='120' STYLE='{SMALL_FONT}'>{memberrow.FROM}</TD>
												<TD WIDTH='100' STYLE='{SUB_INFO_FONT}'>{memberrow.JOINED}</TD>
												<TD WIDTH='40' STYLE='{SUB_INFO_FONT}'><B>{memberrow.POSTS}</B></TD>
												<TD WIDTH='40' STYLE='{SUB_INFO_FONT}'><B>{memberrow.POINTS}</B></TD>
												<TD WIDTH='80' ALIGN='right'>{memberrow.WWW_IMG}</TD>
											</TR>
										</TABLE>
									</TD></TR>
						<!-- END memberrow -->
							
								</TABLE>
							</TD></TR>
						
							<TR><TD COLSPAN=2 VALIGN='top'>
								<TABLE BORDER=0 CELLPADDING=6 CELLSPACING=1 BGCOLOR='{LIGHT_COLOR_2}' WIDTH='760'>
									<TR><FORM METHOD='post' ACTION='{S_MODE_ACTION}'><TD ALIGN='right' STYLE='{SUB_INFO_FONT}' BGCOLOR='{DARK_COLOR_2}' BACKGROUND='/images/header_info.gif'>
										{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;{L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;&nbsp; 
										<INPUT TYPE='submit' NAME='submit' VALUE='{L_SUBMIT}' CLASS='liteoption'><BR>
										{L_SORT_PER_LETTER}:&nbsp;{S_LETTER_SELECT}&nbsp;{S_LETTER_HIDDEN}<BR>
										{TOTAL_MEMBERS_RETURNED} member(s) returned! OMG!</TD>
									</FORM></TR>
								</TABLE>
							</TD></TR>
						
							<TR><TD STYLE='{SUB_INFO_FONT}' VALIGN='top'>{PAGE_NUMBER}</TD>
						
							<TD STYLE='{SUB_INFO_FONT}' ALIGN='right'>{JUMPBOX}</TD>
							</TR>
						</TABLE></TD>
				</TR>
				<!-- END guest_user_row -->
			</TABLE>
		</TD>
	</TR>

	<TR>
		<TD>
			<IMG SRC='http://www.txmafia.com/extras/images/extras_side_footer.gif' WIDTH='193' HEIGHT='11' BORDER='0'></TD>

		<TD>
			<IMG SRC='http://www.txmafia.com/extras/images/extras_main_footer.gif' STYLE='width: 579px; height: 11px; border: 0px;'></TD>
	</TR>
</TABLE>	