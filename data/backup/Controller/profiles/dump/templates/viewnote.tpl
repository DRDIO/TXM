<STYLE>
	fieldset { color: #403214; font: 12px Verdana; border: 1px solid #8E7B1B; padding: 4px; margin: 0px 4px 4px 4px; }
	legend { color: #8E7B1B; font-weight: bold }
	dt { float: left; font-weight: bold; text-align: right; width: 30%; }
	dd { text-align: right; }

	.info { color: #403214; font: 12px Verdana; text-align: left; vertical-align: top; }
	.profile { vertical-align: top; padding: 2px 0px 0px 0px; height: 24px; color: #403214; font: 12px Verdana; text-align: left; }
	.text { font: 12px Verdana; width: 340px; height: 20px; padding: 2px; margin: 0px 2px 4px 2px; }
	.textarea { font: 12px Verdana; width: 340px; height: 62px; padding: 2px; margin: 0px 2px 4px 2px; overflow: auto; }
	.submit { font: 12px Verdana; width: 340px; height: 20px; padding: 2px; margin: 0px 2px 4px 2px; text-align: right; font-weight: bold; }
	
</STYLE>

<TABLE BORDER='0' CELLSPACING='0' CELLPADDING='0'>			
	<TR>
		<TD COLSPAN='2' VALIGN='top' ALIGN='left' STYLE='background-image:url({SITE_FOLDER}images/top_back.gif);'>
			{PROFILE_HEADER}</TD>

		<TD COLSPAN='2' VALIGN='top' ALIGN='right' STYLE='background-image:url({SITE_FOLDER}images/top_back.gif);'>
			<A HREF='{SITE_LINK}'><IMG BORDER='0' HEIGHT='45' SRC='{SITE_FOLDER}images/top_title_index.gif' ALT='index' /></A></TD>
	</TR>

	<TR>
		<TD WIDTH='10' STYLE='background-color: #C4C3AF; background-image: url({SITE_FOLDER}images/left.gif); background-repeat: repeat-y;'></TD>
		
		<TD ALIGN='center' COLSPAN='2' STYLE='background-color: #C4C3AF; font: 12px Verdana;'>
			<TABLE BORDER='0' WIDTH='100%' CELLSPACING='0' CELLPADDING='4'>
				<TR><TD CLASS='profile' WIDTH='228' VALIGN='top' STYLE='font-size: 6px;'>					
					<!-- BEGIN notes_incoming_show -->
					<FIELDSET>
					<LEGEND>Incoming Notes</LEGEND>
						<TABLE WIDTH='100%' BORDER='0' CELLSPACING='0' CELLPADDING='2'>						
							<TR STYLE='background: #8E7B1B;'>
								<TD WIDTH='54'></TD>									
								<TD STYLE='color: #F1E6CF;' WIDTH='100' CLASS='info'>Member</TD>								
								<TD STYLE='color: #F1E6CF;' WIDTH='320' CLASS='info'>Subject</TD>								
								<TD STYLE='color: #F1E6CF;' WIDTH='80' CLASS='info'>Status</TD>								
								<TD STYLE='color: #F1E6CF;' CLASS='info'>Sent</TD>															
							</TR>
							
							<TR>
								<TD COLSPAN='5' STYLE='padding-bottom: 2px;'></TD>
							</TR>
					<!-- END notes_incoming_show -->			
							<!-- BEGIN notes_incoming -->
							<TR>
								<TD WIDTH='54' ROWSPAN='2'>
									<A HREF='http://{notes_incoming.USER_LINK}.{SITE_DOMAIN}.com/'><IMG SRC='../profiles/resample.php?m=1&u={notes_incoming.FROM_USER_ID}&t=1' WIDTH='50' HEIGHT='50' STYLE='float: left;'></A></TD>
									
								<TD WIDTH='100' HEIGHT='20' CLASS='info'>
									<A HREF='http://{notes_incoming.USER_LINK}.{SITE_DOMAIN}.com/'>{notes_incoming.USER_NAME}</A>
								</TD>
								
								<TD WIDTH='320' CLASS='info'>
									<STRONG><A HREF='{SITE_LINK}readnote/{notes_incoming.ID}'>{notes_incoming.TITLE}</A></STRONG></A>
								</TD>
								
								<TD WIDTH='80' CLASS='info'>
									{notes_incoming.STATUS}</A>
								</TD>
								
								<TD CLASS='info'>
									{notes_incoming.DATE_SENT}</A>
								</TD>															
							</TR>
							
							<TR>
								<TD COLSPAN='3' CLASS='info' STYLE='font-size: 11px; font-style: italic;'>
									{notes_incoming.NOTE}
								</TD>
								
								<TD CLASS='info' STYLE='vertical-align: bottom;'>
									Read. &nbsp; Reply. &nbsp; Delete.
								</TD>
							</TR>		
							
							<TR>
								<TD COLSPAN='5'>
									<DIV STYLE='width: inherit; margin: 1px; padding: 1px; border-bottom: 1px solid #8E7B1B;'></DIV></TD>
							</TR>												
							<!-- END notes_incoming -->								
					<!-- BEGIN notes_incoming_show -->	
							<TR>
								<TD COLSPAN='5' CLASS='info' STYLE='color: #F1E6CF; background: #8E7B1B; text-align: right;'>
									Select: &nbsp; None, &nbsp; Unread, &nbsp; Read, &nbsp; Replied, &nbsp; All. &nbsp; Mark as Read. &nbsp; Delete.</TD>
							</TR>				
						</TABLE>
					</FIELDSET>
					<!-- END notes_incoming_show -->
					<BR><BR>			
					<!-- BEGIN notes_outgoing_show -->
					<FIELDSET>
					<LEGEND>Outgoing Notes</LEGEND>
						<TABLE BORDER='0' CELLSPACING='0' CELLPADDING='2'>
							<TR STYLE='background: #8E7B1B;'>
								<TD WIDTH='54'></TD>									
								<TD STYLE='color: #F1E6CF;' WIDTH='120' CLASS='info'>Member</TD>								
								<TD STYLE='color: #F1E6CF;' WIDTH='320' CLASS='info'>Subject</TD>								
								<TD STYLE='color: #F1E6CF;' WIDTH='80' CLASS='info'>Status</TD>								
								<TD STYLE='color: #F1E6CF;' CLASS='info'>Sent</TD>															
							</TR>
							
							<TR>
								<TD COLSPAN='5' STYLE='padding-bottom: 2px;'></TD>
							</TR>
					<!-- END notes_outgoing_show -->			
							<!-- BEGIN notes_outgoing -->
							<TR>
								<TD WIDTH='54' ROWSPAN='2'>
									<A HREF='http://{notes_outgoing.USER_LINK}.{SITE_DOMAIN}.com/'><IMG SRC='../profiles/resample.php?m=1&u={notes_outgoing.TO_USER_ID}&t=1' WIDTH='50' HEIGHT='50' STYLE='float: left;'></A></TD>
									
								<TD WIDTH='120' HEIGHT='20' CLASS='info'>
									<A HREF='http://{notes_outgoing.USER_LINK}.{SITE_DOMAIN}.com/'>{notes_outgoing.USER_NAME}</A>
								</TD>
								
								<TD WIDTH='320' CLASS='info'>
									<STRONG><A HREF='{SITE_LINK}readnote/{notes_outgoing.ID}'>{notes_outgoing.TITLE}</A></STRONG></A>
								</TD>
								
								<TD WIDTH='80' CLASS='info'>
									{notes_outgoing.STATUS}</A>
								</TD>
								
								<TD CLASS='info'>
									{notes_outgoing.DATE_SENT}</A>
								</TD>		
							</TR>

							<TR>
								<TD COLSPAN='3' CLASS='info' STYLE='font-size: 11px; font-style: italic;'>
									{notes_outgoing.NOTE}</TD>
								
								<TD CLASS='info' STYLE='vertical-align: bottom;'>
									Read. &nbsp; Reply. &nbsp; Delete.</TD>
							</TR>	
							
							<TR>
								<TD COLSPAN='5'>
									<DIV STYLE='width: inherit; margin: 1px; padding: 1px; border-bottom: 1px solid #8E7B1B;'></DIV></TD>
							</TR>								
							<!-- END notes_outgoing -->																							
					<!-- BEGIN notes_outgoing_show -->
							<TR>
								<TD COLSPAN='5' CLASS='info' STYLE='color: #F1E6CF; background: #8E7B1B; text-align: right;'>
									Select: &nbsp; None, &nbsp; Unread, &nbsp; Read, &nbsp; Replied, &nbsp; All. &nbsp; Delete.</TD>
							</TR>						
						</TABLE>
					</FIELDSET>
					<!-- END notes_outgoing_show -->
				</TD></TR>
			</TABLE>
		</TD>
		
		<TD WIDTH='10' STYLE='background-color: #C4C3AF; background-image: url({SITE_FOLDER}images/right.gif); background-repeat: repeat-y;'></TD>
	</TR>
	
	<TR>
		<TD COLSPAN='2' ALIGN='left' VALIGN='top' STYLE='background-image: url({SITE_FOLDER}images/bot.gif); background-repeat: repeat-x;'>
			<IMG SRC='{SITE_FOLDER}images/bot_left.gif' WIDTH='30' HEIGHT='12' /></TD>

		<TD COLSPAN='2' ALIGN='right' VALIGN='top' STYLE='background-image: url({SITE_FOLDER}images/bot.gif); background-repeat: repeat-x;'>
			<IMG SRC='{SITE_FOLDER}images/bot_right.gif' WIDTH='30' HEIGHT='12' /></TD>
	</TR>

	<TR><TD HEIGHT='1' WIDTH='10'></TD><TD WIDTH='376'></TD><TD WIDTH='376'></TD><TD WIDTH='10'></TD></TR>
</TABLE>