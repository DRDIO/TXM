<STYLE>
	fieldset { color: #403214; font: 12px Verdana; border: 1px solid #8E7B1B; padding: 4px; margin: 0px 4px 4px 4px; }
	legend { color: #8E7B1B; font-weight: bold }
	dt { float: left; font-weight: bold; text-align: right; width: 30%; }
	dd { text-align: right; }

	.info { color: #403214; font: 12px Verdana; text-align: left; vertical-align: top; }
	.info2 { color: #403214; font: bold 12px Verdana; text-align: right; width: 120px; padding-right: 24px; vertical-align: top; }
	.profile { vertical-align: top; padding: 2px 0px 0px 0px; height: 24px; color: #403214; font: 12px Verdana; text-align: left; }
	.text { font: 12px Verdana; width: 640px; height: 20px; padding: 2px; margin: 0px 2px 4px 2px; }
	.textarea { font: 12px Verdana; width: 640px; height: 176px; padding: 2px; margin: 0px 2px 4px 2px; overflow: auto; }
	.submit { font: 12px Verdana; width: 640px; height: 20px; padding: 2px; margin: 0px 2px 4px 2px; text-align: right; font-weight: bold; }
	
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
				<TR>
					<TD CLASS='profile' VALIGN='top' COLSPAN='2' STYLE='font-size: 6px;'>								
						<!-- ABEGIN writenote -->
						<FIELDSET>
							<LEGEND>Write A Personal Blog</LEGEND>
							<TABLE BORDER='0' CELLSPACING='0' CELLPADDING='2'>
							<FORM METHOD='post' ACTION='/writenote' ENCTYPE='multipart/form-data'>
							<INPUT TYPE='hidden' NAME='writenote_to_user_id' VALUE='{PROFILE_ID}'>
							<TR>
								<TD CLASS='info2'>
									<LABEL FOR='writenote_title'>Title:</LABEL></TD>
								
								<TD CLASS='profile'>
									<INPUT TYPE='text' ID='writenote_title' NAME='writenote_title' VALUE='{WRITENOTE_TITLE}' CLASS='text'>
								</TD>
							</TR>
							
							<TR>
								<TD CLASS='info2'>
									<LABEL FOR='writenote_note'>Blog:</LABEL></TD>
								
								<TD CLASS='profile'>
									<TEXTAREA ID='writenote_note' NAME='writenote_note' ROWS='4' CLASS='textarea'>{WRITENOTE_NOTE}</TEXTAREA>
								</TD>
							</TR>
							
							<TR>
								<TD CLASS='info2'></TD>
								
								<TD CLASS='profile'>
									<INPUT TYPE='submit' NAME='writenote_submit' VALUE='Finish writing your blog.' CLASS='submit'>
								</TD>
							</TR>		
							</FORM>				
							</TABLE>
						</FIELDSET>
						<!-- AEND writenote -->
					</TD>
				</TR>
					
				<TR>
					<TD CLASS='profile' VALIGN='top' STYLE='font-size: 6px;'>				
						<!-- BEGIN blogs_personal_show -->
						<FIELDSET>
							<LEGEND>Previous Blogs By You</LEGEND>
							<TABLE BORDER='0' CELLPADDING='2' CELLSPACING='0' WIDTH='100%'>
								<TR STYLE='background: #8E7B1B;'>
									<TD ALIGN='left' WIDTH='328' CLASS='info' STYLE='color: #F1E6CF;'>Title</TD>									
								</TR>
						<!-- END blogs_personal_show -->
								<!-- BEGIN blogs_personal -->
								<TR>
									<TD VALIGN='left' STYLE='font: 12px Verdana;'>
										<STRONG><A HREF='{SITE_LINK}readblog/{blogs_personal.ID}'>{blogs_personal.TITLE}</A></STRONG></TD>									
								</TR>
								<!-- END blogs_personal -->
						<!-- BEGIN blogs_personal_show -->						
							</TABLE>
						</FIELDSET>
						<!-- END blogs_personal_show -->
						
						<!-- BEGIN blogs_personal_hide -->
						<!-- END blogs_personal_hide -->
																		
					</TD>
					
					<TD CLASS='profile' WIDTH='450' VALIGN='top' STYLE='font-size: 6px;'>												
						<!-- BEGIN blogs_five -->
						<FIELDSET>
						<LEGEND>Blog has {blogs_five.COMMENTS} Comments & {blogs_five.VIEWS} Views</A></LEGEND>
							<TABLE WIDTH='100%' BORDER='0' CELLSPACING='0' CELLPADDING='2'>						
								<TR STYLE='background: #8E7B1B;'>
									<TD  COLSPAN='2' STYLE='color: #F1E6CF;' CLASS='info'><STRONG><A HREF='{SITE_LINK}readblog/{blogs_five.ID}'>{blogs_five.TITLE}</A></STRONG></TD>								
								</TR>
								
								<TR>
									<TD  COLSPAN='2' STYLE='padding-bottom: 2px;'></TD>
								</TR>
								
								<TR>
									<TD  COLSPAN='2' CLASS='info'>
										{blogs_five.BLOG}
									</TD>																							
	
								<TR>
									<TD COLSPAN='2'>
										<DIV STYLE='width: inherit; margin: 1px; padding: 1px; border-bottom: 1px solid #8E7B1B;'></DIV></TD>
								</TR>	
								
								<TR STYLE='background: #8E7B1B;'>
									<TD STYLE='color: #F1E6CF;' CLASS='info'>Written {blogs_five.DATE_UPLOADED}</TD>								
									<TD WIDTH='120' CLASS='info' STYLE='color: #F1E6CF; text-align: right;'><A HREF='{SITE_LINK}editblog/{blogs_five.ID}'>Edit</A> or <A HREF='{SITE_LINK}deleteblog/{blogs_five.ID}'>Delete</A></TD>
								</TR>
							</TABLE>
						</FIELDSET><BR>
						<!-- END blogs_five -->
					</TD>				
				</TR>
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