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
						There are {REG_USER_ONLINE} members online.</TD>
				</TR>
				
				<TR>
					<TD COLSPAN='2' STYLE='background: left url(http://www.txmafia.com/extras/images/extras_main_body2.gif); padding: 2px 11px 2px 11px;'>
						<DIV STYLE='font: 0px; width: inherit; height: 2px; background: white;'></DIV></TD>
				</TR>	
						
				<!-- BEGIN reg_user_row -->
				<TR>
					<TD COLSPAN='2' STYLE='background: left url(http://www.txmafia.com/extras/images/extras_main_body{reg_user_row.COLOR}.gif); padding: 2px 11px 2px 11px;'>
						{reg_user_row.OUTPUT}</TD>
				</TR>
				<!-- END reg_user_row -->

				<TR>
					<TD COLSPAN='2' STYLE='padding: 14px 2px 1px 11px;'>
						</TD>
				</TR>
				
				<TR>
					<TD COLSPAN='2' STYLE='font-weight: bold; background: left url(http://www.txmafia.com/extras/images/extras_main_body2.gif); padding: 2px 11px 2px 11px;'>
						There are {GUEST_USER_ONLINE} guests online.</TD>
				</TR>
				
				<TR>
					<TD COLSPAN='2' STYLE='background: left url(http://www.txmafia.com/extras/images/extras_main_body2.gif); padding: 2px 11px 2px 11px;'>
						<DIV STYLE='font: 0px; width: inherit; height: 2px; background: white;'></DIV></TD>
				</TR>	

				<!-- BEGIN guest_user_row -->
				<TR>
					<TD COLSPAN='2' STYLE='background: left url(http://www.txmafia.com/extras/images/extras_main_body{guest_user_row.COLOR}.gif); padding: 2px 11px 2px 11px;'>
						{guest_user_row.OUTPUT}</TD>
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