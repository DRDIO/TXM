<SCRIPT>
function cb_checknone(j){
	var i = 0;
	var k = j.match("incoming") ? {COUNT_INCOMING} : {COUNT_OUTGOING};
	
	for(i = 0; i < k; i++){
		if(eval("document." + j + ".cb" + i))
		{
			eval("document." + j + ".cb" + i).checked = false;
		}
	}
	return false;
}

function cb_check(j, e){
	cb_checknone(j);
	var i = 0;
	var k = j.match("incoming") ? {COUNT_INCOMING} : {COUNT_OUTGOING};
	
	for(i = 0; i < k; i++){
		if(eval("document." + j + ".cb" + i))
		{
			if(eval("document." + j + ".cb" + i).value.match(e))
			{
				eval("document." + j + ".cb" + i).checked = true;
			}
		}
	}
	return false;
}
</SCRIPT>

<STYLE>
	fieldset { color: #403214; font: 12px Verdana; border: 1px solid #8E7B1B; padding: 4px; margin: 0px 4px 4px 4px; }
	legend { color: #8E7B1B; font-weight: bold; padding-bottom: 4px; }
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
				<TR>
					<TD CLASS='profile' WIDTH='100%' VALIGN='top' STYLE='font-size: 6px;'>					
						<!-- BEGIN notes_none -->
						<FIELDSET>
						<LEGEND>No Incoming or Outgoing Notes</LEGEND>
							<TABLE WIDTH='100%' BORDER='0' CELLSPACING='0' CELLPADDING='2'>						
								<TR CLASS='info'>
									<TD>You currently have no notes, incoming or outgoing.  You can write notes to other members by visiting their profiles.  
									There you will see a note form on their main page.  We encourage members to use notes for private communication, and
									request that they avoid chat like behavior in the forums.</TD>									
								</TR>
							</TABLE>
						</FIELDSET>
						<!-- END notes_none -->

						<!-- BEGIN notes_incoming_show -->
						<FORM NAME='notes_incoming_form' ACTION='{SITE_LINK}actionnote' METHOD='POST' ENCTYPE='multipart/form-data' STYLE='margin: 0px; padding: 0px;'>
						<FIELDSET>
						<LEGEND>Incoming Notes ({notes_incoming_show.RANGE} of {notes_incoming_show.TOTAL}) ({notes_incoming_show.PAGE})</LEGEND>
							<TABLE WIDTH='100%' BORDER='0' CELLSPACING='0' CELLPADDING='2'>						
								<TR STYLE='background: #8E7B1B;'>
									<TD WIDTH='18'></TD>									
									<TD WIDTH='54'></TD>									
									<TD STYLE='color: #F1E6CF;' WIDTH='100' CLASS='info'>From</TD>								
									<TD STYLE='color: #F1E6CF;' WIDTH='280' CLASS='info'>Subject</TD>								
									<TD STYLE='color: #F1E6CF;' WIDTH='80' CLASS='info'>Status</TD>								
									<TD STYLE='color: #F1E6CF;' CLASS='info'>Sent</TD>															
								</TR>
								
								<TR>
									<TD COLSPAN='5' STYLE='padding-bottom: 2px;'></TD>
								</TR>
						<!-- END notes_incoming_show -->			
								<!-- BEGIN notes_incoming -->
								<TR>
									<TD WIDTH='18' ROWSPAN='2'>
										<INPUT TYPE='checkbox' NAME='cb{notes_incoming.COUNT}' VALUE='incoming{notes_incoming.STATUS}{notes_incoming.ID}' STYLE='float: left;'></TD>
									
									<TD WIDTH='54' ROWSPAN='2'>
										<A HREF='http://{notes_incoming.USER_LINK}.{SITE_DOMAIN}.com/'><IMG SRC='http://{SITE_DOMAIN}.com/profiles/resample.php?m=1&u={notes_incoming.FROM_USER_ID}&t=1' WIDTH='50' HEIGHT='50' STYLE='float: left;'></A></TD>
										
									<TD WIDTH='100' HEIGHT='20' CLASS='info'>
										<A HREF='http://{notes_incoming.USER_LINK}.{SITE_DOMAIN}.com/'>{notes_incoming.USER_NAME}</A></TD>
									
									<TD WIDTH='280' CLASS='info'>
										<A HREF='{SITE_LINK}readnote/{notes_incoming.ID}'><STRONG>{notes_incoming.TITLE}</STRONG></A></TD>
									
									<TD WIDTH='80' CLASS='info'>
										{notes_incoming.STATUS}</A></TD>
									
									<TD CLASS='info' WIDTH='180'>
										{notes_incoming.DATE_SENT}</A></TD>															
								</TR>
								
								<TR>
									<TD COLSPAN='2' CLASS='info' STYLE='font-size: 11px; font-style: italic;'>
										{notes_incoming.NOTE}</TD>
									
									<TD VALIGN='top' WIDTH='80' CLASS='info'>									
										{notes_incoming.FROM_DEL}</TD>
										
									<TD CLASS='info' STYLE='vertical-align: bottom;'>
										<A HREF='{SITE_LINK}readnote/{notes_incoming.ID}'>Read &amp; Reply</A> or <A HREF='{SITE_LINK}deletenote/{notes_incoming.ID}'>Delete</A></TD>
								</TR>		
								
								<TR>
									<TD COLSPAN='6'>
										<DIV STYLE='width: inherit; margin: 1px; padding: 1px; border-bottom: 1px solid #8E7B1B;'></DIV></TD>
								</TR>												
								<!-- END notes_incoming -->								
						<!-- BEGIN notes_incoming_show -->	
								<TR>
									<TD COLSPAN='6' CLASS='info' STYLE='color: #F1E6CF; background: #8E7B1B; text-align: right;'>
										Select: &nbsp; <A HREF='' ONCLICK='return cb_checknone("notes_incoming_form");'>None</A>, &nbsp; <A HREF='' ONCLICK='return cb_check("notes_incoming_form", "Unread");'>Unread</A>, &nbsp; <A HREF='' ONCLICK='return cb_check("notes_incoming_form", "Read");'>Read</A>, &nbsp; <A HREF='' ONCLICK='return cb_check("notes_incoming_form", "Replied");'>Replied</A>, &nbsp; <A HREF='' ONCLICK='return cb_check("notes_incoming_form", "");'>All</A>. &nbsp; <INPUT TYPE='submit' NAME='mark' VALUE='Mark as Read'><INPUT TYPE='submit' NAME='delete' VALUE='Delete'></TD>
								</TR>				
							</TABLE>
						</FIELDSET>
						</FORM>						
						<!-- END notes_incoming_show -->
						
						<!-- BEGIN notes_outgoing_show -->
						<FORM NAME='notes_outgoing_form' ACTION='{SITE_LINK}actionnote' METHOD='POST' ENCTYPE='multipart/form-data' STYLE='margin: 0px; padding: 0px;'>
						<FIELDSET>
						<LEGEND>Outgoing Notes ({notes_outgoing_show.RANGE} of {notes_outgoing_show.TOTAL}) ({notes_outgoing_show.PAGE})</LEGEND>
							<TABLE WIDTH='100%' BORDER='0' CELLSPACING='0' CELLPADDING='2'>						
								<TR STYLE='background: #8E7B1B;'>
									<TD WIDTH='18'></TD>									
									<TD WIDTH='54'></TD>									
									<TD STYLE='color: #F1E6CF;' WIDTH='100' CLASS='info'>To</TD>								
									<TD STYLE='color: #F1E6CF;' WIDTH='280' CLASS='info'>Subject</TD>								
									<TD STYLE='color: #F1E6CF;' WIDTH='80' CLASS='info'>Status</TD>								
									<TD STYLE='color: #F1E6CF;' CLASS='info'>Sent</TD>															
								</TR>
								
								<TR>
									<TD COLSPAN='5' STYLE='padding-bottom: 2px;'></TD>
								</TR>
						<!-- END notes_outgoing_show -->			
								<!-- BEGIN notes_outgoing -->
								<TR>
									<TD WIDTH='18' ROWSPAN='2'>
										<INPUT TYPE='checkbox' NAME='cb{notes_outgoing.COUNT}' VALUE='outgoing{notes_outgoing.STATUS}{notes_outgoing.ID}' STYLE='float: left;'></TD>
									
									<TD WIDTH='54' ROWSPAN='2'>
										<A HREF='http://{notes_outgoing.USER_LINK}.{SITE_DOMAIN}.com/'><IMG SRC='http://{SITE_DOMAIN}.com/profiles/resample.php?m=1&u={notes_outgoing.TO_USER_ID}&t=1' WIDTH='50' HEIGHT='50' STYLE='float: left;'></A></TD>
										
									<TD WIDTH='100' HEIGHT='20' CLASS='info'>
										<A HREF='http://{notes_outgoing.USER_LINK}.{SITE_DOMAIN}.com/'>{notes_outgoing.USER_NAME}</A>
									</TD>
									
									<TD WIDTH='280' CLASS='info'>
										<STRONG><A HREF='{SITE_LINK}readnote/{notes_outgoing.ID}'>{notes_outgoing.TITLE}</A></STRONG></A>
									</TD>
									
									<TD WIDTH='80' CLASS='info'>
										{notes_outgoing.STATUS}</A>
									</TD>
									
									<TD CLASS='info' WIDTH='180'>
										{notes_outgoing.DATE_SENT}</A>
									</TD>		
								</TR>
	
								<TR>
									<TD COLSPAN='2' CLASS='info' STYLE='font-size: 11px; font-style: italic;'>
										{notes_outgoing.NOTE}</TD>
									
									<TD VALIGN='top' WIDTH='80' CLASS='info'>									
										{notes_outgoing.TO_DEL}</TD>
									
									<TD CLASS='info' STYLE='vertical-align: bottom;'>
										<A HREF='{SITE_LINK}readnote/{notes_outgoing.ID}'>Read &amp; Reply</A> or <A HREF='{SITE_LINK}deletenote/{notes_outgoing.ID}'>Delete</A></TD>
								</TR>	
								
								<TR>
									<TD COLSPAN='6'>
										<DIV STYLE='width: inherit; margin: 1px; padding: 1px; border-bottom: 1px solid #8E7B1B;'></DIV></TD>
								</TR>								
								<!-- END notes_outgoing -->																							
						<!-- BEGIN notes_outgoing_show -->
								<TR>
									<TD COLSPAN='6' CLASS='info' STYLE='color: #F1E6CF; background: #8E7B1B; text-align: right;'>
										Select: &nbsp; <A HREF='' ONCLICK='return cb_checknone("notes_outgoing_form");'>None</A>, &nbsp; <A HREF='' ONCLICK='return cb_check("notes_outgoing_form", "Unread");'>Unread</A>, &nbsp; <A HREF='' ONCLICK='return cb_check("notes_outgoing_form", "Read");'>Read</A>, &nbsp; <A HREF='' ONCLICK='return cb_check("notes_outgoing_form", "Replied");'>Replied</A>, &nbsp; <A HREF='' ONCLICK='return cb_check("notes_outgoing_form", "");'>All</A>. &nbsp; <INPUT TYPE='submit' NAME='delete' VALUE='Delete'></TD>
								</TR>						
							</TABLE>
						</FIELDSET>
						</FORM>
						<!-- END notes_outgoing_show -->					
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