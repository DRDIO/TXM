<?php $rtv .= '<div class="main">
'; $_edit_success_count = isset($this->_tpldata['edit_success.']) ? sizeof($this->_tpldata['edit_success.']) : 0;for($_edit_success_i = 0; $_edit_success_i < $_edit_success_count; $_edit_success_i++) { $rtv .= '
      <div class="col-pad blu-blck"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b>
        <div class="blk-hedr blu-dbck">
              Your Account Has Been Updated!</div>

        <div class="blu-back blu-brdr dft-cnt">
            Congratulations, your account has been updated.  TXM.com currently doesn\'t
            send out emails nor remember your previous changes, so please remember
            your updates!
        </div>
    <b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></div>
'; } $rtv .= '

'; $_edit_errors_count = isset($this->_tpldata['edit_errors.']) ? sizeof($this->_tpldata['edit_errors.']) : 0;for($_edit_errors_i = 0; $_edit_errors_i < $_edit_errors_count; $_edit_errors_i++) { $rtv .= '
      <div class="col-pad grn-blck"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b>
        <div class="blk-hedr grn-dbck">
              Unable to Create Profile
        </div>

        <div class="blu-back grn-brdr">
'; $_row_count = isset($this->_tpldata['edit_errors.'][$_edit_errors_i]['row.']) ? sizeof($this->_tpldata['edit_errors.'][$_edit_errors_i]['row.']) : 0;for($_row_i = 0; $_row_i < $_row_count; $_row_i++) { $rtv .= '
            <div class="dft-cnt ' . ( ( isset($this->_tpldata['edit_errors.'][$_edit_errors_i]['row.'][$_row_i]['class']) ) ? $this->_tpldata['edit_errors.'][$_edit_errors_i]['row.'][$_row_i]['class'] : '' ) . '">
                ' . ( ( isset($this->_tpldata['edit_errors.'][$_edit_errors_i]['row.'][$_row_i]['message']) ) ? $this->_tpldata['edit_errors.'][$_edit_errors_i]['row.'][$_row_i]['message'] : '' ) . '
            </div>
'; } $rtv .= '
                </div>
    <b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></div>
'; } $rtv .= '

'; $_edit_count = isset($this->_tpldata['edit.']) ? sizeof($this->_tpldata['edit.']) : 0;for($_edit_i = 0; $_edit_i < $_edit_count; $_edit_i++) { $rtv .= '
        <div class="col-pad blu-blck"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b>
        <div class="blk-hedr blu-dbck">
              Update Your Account Information</div>

        <div class="blu-back blu-brdr">
                <div class="dft-cnt">
                <ul>
                  <li>A confirmation email will be sent to verify your sign up.</li>
                </ul>
            </div>

            <form action="" enctype="multipart/form-data" method="post">
                <table border="0" cellspacing="0" cellpadding="4" width="100%">
                  <tr class="td-alt">
                    <td width="210" valign="top" align="right">
                      Link Name: &nbsp; </td>
                    <td width="210">
                      <input type="text" id="link_name" name="link_name" value="' . ( ( isset($this->_tpldata['edit.'][$_edit_i]['link_name']) ) ? $this->_tpldata['edit.'][$_edit_i]['link_name'] : '' ) . '" maxlength="25" style="width: 200px;" tabindex="1" /></td>
                    <td class="dft-clr">
                      Up to 25 letters, numbers, \'-\', or \'_\' (<em>linkname</em>.txm.com)</td>
                  </tr>

                  <tr>
                    <td width="210" valign="top" align="right">
                      Nick Name: &nbsp; </td>
                    <td width="210">
                      <input type="text" id="nick_name" name="nick_name" value="' . ( ( isset($this->_tpldata['edit.'][$_edit_i]['nick_name']) ) ? $this->_tpldata['edit.'][$_edit_i]['nick_name'] : '' ) . '" maxlength="25" style="width: 200px;" tabindex="1" /></td>
                    <td class="dft-clr">
                      Up to 25 characters</td>
                  </tr>

                  <tr class="td-alt">
                    <td valign="top" align="right">
                      Email: &nbsp; </td>
                    <td>
                      <input type="text" name="email" value="' . ( ( isset($this->_tpldata['edit.'][$_edit_i]['email']) ) ? $this->_tpldata['edit.'][$_edit_i]['email'] : '' ) . '" maxlength="100" style="width: 200px;" tabindex="2" /></td>
                    <td class="dft-clr">
                      Must reply to confirmation</td>
                  </tr>

                  <tr>
                    <td valign="top" align="right">
                      Current Password: &nbsp; </td>
                    <td>
                      <input type="password" name="pass_old" value="' . ( ( isset($this->_tpldata['edit.'][$_edit_i]['pass_old']) ) ? $this->_tpldata['edit.'][$_edit_i]['pass_old'] : '' ) . '" maxlength="16" style="width: 200px;" tabindex="3" /></td>
                    <td class="dft-clr">
                      Required to validate account update</td>
                  </tr>

                  <tr class="td-alt">
                    <td valign="top" align="right">
                      New Password: &nbsp; </td>
                    <td>
                      <input type="password" name="pass" value="' . ( ( isset($this->_tpldata['edit.'][$_edit_i]['pass']) ) ? $this->_tpldata['edit.'][$_edit_i]['pass'] : '' ) . '" maxlength="16" style="width: 133px; float: left;" onkeyup="pass_strength(this);" tabindex="3" />
                      <div class="pass-box"><div id="pass_bar" class="pass-bar"></div><div class="pass-text">strength</div></div>
                      <br class="clr" /></td>
                    <td class="dft-clr">
                      Only if you want to change password<br />
                      Must be 6 to 16 characters</td>
                  </tr>

                  <tr>
                    <td valign="top" align="right">
                      Birth Date: &nbsp; </td>
                    <td>
                      <select name="date_m" style="width: 72px;" tabindex="4">' . ( ( isset($this->_tpldata['edit.'][$_edit_i]['date_m']) ) ? $this->_tpldata['edit.'][$_edit_i]['date_m'] : '' ) . '
                      </select><select name="date_d" style="width: 66px;" tabindex="5">' . ( ( isset($this->_tpldata['edit.'][$_edit_i]['date_d']) ) ? $this->_tpldata['edit.'][$_edit_i]['date_d'] : '' ) . '
                      </select><select name="date_y" style="width: 66px;" tabindex="6">' . ( ( isset($this->_tpldata['edit.'][$_edit_i]['date_y']) ) ? $this->_tpldata['edit.'][$_edit_i]['date_y'] : '' ) . '</select></<br />
                    <td class="dft-clr">
                      Must be over 13</td>
                  </tr>

                  <tr class="td-alt">
                    <td></td>
                    <td colspan="2">
                      <input type="submit" name="edit" value="Update Account" class="submit" style="width: 206px;" tabindex="9" /></td>
                  </tr>
                </table>
            </form>
        </div>
        <b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></div>
'; } $rtv .= '
</div>

<script type="text/javascript" src="' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'misc/scripts/register.js"></script>

';?>