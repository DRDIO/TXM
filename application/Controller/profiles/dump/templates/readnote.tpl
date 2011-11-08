<STYLE>
	fieldset { color: #403214; font: 12px Verdana; border: 1px solid #8E7B1B; padding: 4px; margin: 0px 4px 4px 4px; }
	legend { color: #8E7B1B; font-weight: bold }
	dt { float: left; font-weight: bold; text-align: right; width: 30%; }
	dd { text-align: right; }

	.info { color: #403214; font: 12px Verdana; text-align: left; vertical-align: top; }
	.info2 { color: #403214; font: bold 12px Verdana; text-align: right; width: 120px; padding-right: 24px; vertical-align: top; }
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
			<TABLE BORDER='0' WIDTH='100%' CELLSPACING='0' CELLPADDING='0'>
				<TR><TD VALIGN='top' WIDTH='250'>
					<FIELDSET>
					<LEGEND>Other Notes</LEGEND>
						Test area.
					</FIELDSET>
				</TD>
				
				<TD VALIGN='top' STYLE='font-size: 6px;'>					
					<!-- BEGIN note -->
					<FIELDSET>
					<LEGEND>{note.MODE} <A HREF='http://{note.USER_LINK}.{SITE_DOMAIN}.com/'>{note.USER_NAME}</A></LEGEND>
						<TABLE WIDTH='100%' BORDER='0' CELLSPACING='0' CELLPADDING='2'>						
							<TR STYLE='background: #8E7B1B;'>
								<TD WIDTH='54'></TD>									
								<TD STYLE='color: #F1E6CF;' CLASS='info'><STRONG>{note.TITLE}</STRONG></TD>								
								<TD WIDTH='120' CLASS='info' STYLE='color: #F1E6CF; text-align: right;' NOWRAP>{note.STATUS} {note.DELETED}</TD>
							</TR>
							
							<TR>
								<TD COLSPAN='2' STYLE='padding-bottom: 2px;'></TD>
							</TR>
							<TR>
								<TD WIDTH='54'>
									<A HREF='http://{note.FROM_USER_LINK}.{SITE_DOMAIN}.com/'><IMG SRC='../profiles/resample.php?m=1&u={note.FROM_USER_ID}&t=1' WIDTH='50' HEIGHT='50' STYLE='float: left;'></A></TD>
									
								<TD COLSPAN='2' CLASS='info'>
									{note.NOTE}
								</TD>																							

							<TR>
								<TD COLSPAN='3'>
									<DIV STYLE='width: inherit; margin: 1px; padding: 1px; border-bottom: 1px solid #8E7B1B;'></DIV></TD>
							</TR>	
							
							<TR STYLE='background: #8E7B1B;'>
								<TD WIDTH='54'></TD>									
								<TD STYLE='color: #F1E6CF;' CLASS='info'>{note.DATE_SENT}</TD>								
								<TD WIDTH='120' CLASS='info' STYLE='color: #F1E6CF; text-align: right;'><A HREF='{SITE_LINK}deletenote/{note.ID}'>Delete</A></TD>
							</TR>
						</TABLE>
					</FIELDSET><BR>
					<!-- END note -->
					
					<!-- BEGIN write_note -->
					<FIELDSET>
						<LEGEND>Write <A HREF='http://{write_note.USER_LINK}.{SITE_DOMAIN}.com/'>{write_note.USER_NAME}</A> A Reply</LEGEND>
						<TABLE BORDER='0' CELLSPACING='0' CELLPADDING='2'>
						<FORM METHOD='post' ACTION='/writenote' ENCTYPE='multipart/form-data'>
						<INPUT TYPE='hidden' NAME='writenote_chain_id' VALUE='{write_note.CHAIN_ID}'>
						<INPUT TYPE='hidden' NAME='writenote_prev_id' VALUE='{write_note.ID}'>
						<INPUT TYPE='hidden' NAME='writenote_to_user_id' VALUE='{write_note.FROM_USER_ID}'>
						<TR>
							<TD CLASS='info2'>
								<LABEL FOR='writenote_title'>Subject:</LABEL></TD>
							
							<TD CLASS='profile'>
								<INPUT TYPE='text' ID='writenote_title' NAME='writenote_title' VALUE='{write_note.TITLE}' CLASS='text'>
							</TD>
						</TR>
						
						<TR>
							<TD CLASS='info2'>
								<LABEL FOR='writenote_note'>Note:</LABEL></TD>
							
							<TD CLASS='profile'>
								<TEXTAREA ID='writenote_note' NAME='writenote_note' ROWS='4' CLASS='textarea'></TEXTAREA>
							</TD>
						</TR>
						
						<TR>
							<TD CLASS='info2'></TD>
							
							<TD CLASS='profile'>
								<INPUT TYPE='submit' NAME='writenote_submit' VALUE='Send your note to {write_note.USER_NAME}.' CLASS='submit'>
							</TD>
						</TR>		
						</FORM>				
						</TABLE>
					</FIELDSET><BR>					
					<!-- END write_note -->
								
					<!-- BEGIN other_notes -->
					<FIELDSET>
					<LEGEND>{other_notes.MODE} <A HREF='http://{other_notes.USER_LINK}.{SITE_DOMAIN}.com/'>{other_notes.USER_NAME}</A></LEGEND>
						<TABLE WIDTH='100%' BORDER='0' CELLSPACING='0' CELLPADDING='2'>						
							<TR STYLE='background: #8E7B1B;'>
								<TD WIDTH='54'></TD>									
								<TD STYLE='color: #F1E6CF;' CLASS='info'><STRONG><A HREF='{SITE_LINK}readnote/{other_notes.ID}'>{other_notes.TITLE}</A></STRONG></TD>								
								<TD WIDTH='120' CLASS='info' STYLE='color: #F1E6CF; text-align: right;' NOWRAP>{other_notes.STATUS} {other_notes.DELETED}</TD>
							</TR>
							
							<TR>
								<TD COLSPAN='2' STYLE='padding-bottom: 2px;'></TD>
							</TR>
							<TR>
								<TD WIDTH='54'>
									<A HREF='http://{other_notes.FROM_USER_LINK}.{SITE_DOMAIN}.com/'><IMG SRC='../profiles/resample.php?m=1&u={other_notes.FROM_USER_ID}&t=1' WIDTH='50' HEIGHT='50' STYLE='float: left;'></A></TD>
									
								<TD COLSPAN='2' CLASS='info'>
									{other_notes.NOTE}
								</TD>																							

							<TR>
								<TD COLSPAN='3'>
									<DIV STYLE='width: inherit; margin: 1px; padding: 1px; border-bottom: 1px solid #8E7B1B;'></DIV></TD>
							</TR>	
							
							<TR STYLE='background: #8E7B1B;'>
								<TD WIDTH='54'></TD>									
								<TD STYLE='color: #F1E6CF;' CLASS='info'>{other_notes.DATE_SENT}</TD>								
								<TD WIDTH='120' CLASS='info' STYLE='color: #F1E6CF; text-align: right;'>
									<A HREF='{SITE_LINK}deleteother_notes/{other_notes.ID}'>Delete</A></TD>
							</TR>
						</TABLE>
					</FIELDSET><BR>
					<!-- END other_notes -->
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