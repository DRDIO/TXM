<?php $rtv .= '<style>
    fieldset { border: 1px dashed #83b340; padding: 4px; margin: 4px; }
    legend { font: bold 12px Arial, Helvetica, sans-serif; color: #ffffff; }
</style>

    <div style="float: left; width: 257px;">
'; $_member_photo_count = isset($this->_tpldata['member_photo.']) ? sizeof($this->_tpldata['member_photo.']) : 0;for($_member_photo_i = 0; $_member_photo_i < $_member_photo_count; $_member_photo_i++) { $rtv .= '
      <div class="grn-top"><div class="dft-btm"><div class="dft-rht"><div class="dft-lft"><div class="grn-ctl"><div class="grn-ctr">
        <div class="dft-hdr grn-bdr">
          Member Photo</div>
        <div class="dft-cnt" style="text-align: center;">
          ' . (isset($this->_tpldata['.'][0]['PHOTO']) ? $this->_tpldata['.'][0]['PHOTO'] : '') . '</div>
      </div></div></div></div></div></div>
'; } $rtv .= '
'; $_contacts_count = isset($this->_tpldata['contacts.']) ? sizeof($this->_tpldata['contacts.']) : 0;for($_contacts_i = 0; $_contacts_i < $_contacts_count; $_contacts_i++) { $rtv .= '
      <div class="grn-top"><div class="dft-btm"><div class="dft-rht"><div class="dft-lft"><div class="grn-ctl"><div class="grn-ctr">
        <div class="dft-hdr grn-bdr">
          Contact Information</div>
        <div class="dft-cnt" style="text-align: center;">
          <table border=\'0\' cellspacing=\'0\' cellpadding=\'2\'>
            ' . (isset($this->_tpldata['.'][0]['EMAIL']) ? $this->_tpldata['.'][0]['EMAIL'] : '') . '
            ' . (isset($this->_tpldata['.'][0]['AIM']) ? $this->_tpldata['.'][0]['AIM'] : '') . '
            ' . (isset($this->_tpldata['.'][0]['ICQ']) ? $this->_tpldata['.'][0]['ICQ'] : '') . '
            ' . (isset($this->_tpldata['.'][0]['MSN']) ? $this->_tpldata['.'][0]['MSN'] : '') . '
            ' . (isset($this->_tpldata['.'][0]['YIM']) ? $this->_tpldata['.'][0]['YIM'] : '') . '
          </table></div>
      </div></div></div></div></div></div>
'; } $rtv .= '
'; $_friends_exist_3_count = isset($this->_tpldata['friends_exist_3.']) ? sizeof($this->_tpldata['friends_exist_3.']) : 0;for($_friends_exist_3_i = 0; $_friends_exist_3_i < $_friends_exist_3_count; $_friends_exist_3_i++) { $rtv .= '
      <fieldset>
      <legend>' . ( ( isset($this->_tpldata['friends_exist_3.'][$_friends_exist_3_i]['FRIENDS_SHOWN']) ) ? $this->_tpldata['friends_exist_3.'][$_friends_exist_3_i]['FRIENDS_SHOWN'] : '' ) . ' of ' . ( ( isset($this->_tpldata['friends_exist_3.'][$_friends_exist_3_i]['FRIENDS_TOTAL']) ) ? $this->_tpldata['friends_exist_3.'][$_friends_exist_3_i]['FRIENDS_TOTAL'] : '' ) . ' ' . ( ( isset($this->_tpldata['friends_exist_3.'][$_friends_exist_3_i]['FRIENDS_LEVEL']) ) ? $this->_tpldata['friends_exist_3.'][$_friends_exist_3_i]['FRIENDS_LEVEL'] : '' ) . '</legend>
'; } $rtv .= '
'; $_friends_3_count = isset($this->_tpldata['friends_3.']) ? sizeof($this->_tpldata['friends_3.']) : 0;for($_friends_3_i = 0; $_friends_3_i < $_friends_3_count; $_friends_3_i++) { $rtv .= '
        <a href=\'http://' . ( ( isset($this->_tpldata['friends_3.'][$_friends_3_i]['NAME']) ) ? $this->_tpldata['friends_3.'][$_friends_3_i]['NAME'] : '' ) . '.txmafia.com/\'>' . ( ( isset($this->_tpldata['friends_3.'][$_friends_3_i]['AVATAR']) ) ? $this->_tpldata['friends_3.'][$_friends_3_i]['AVATAR'] : '' ) . '</a>
'; } $rtv .= '
'; $_friends_exist_3_count = isset($this->_tpldata['friends_exist_3.']) ? sizeof($this->_tpldata['friends_exist_3.']) : 0;for($_friends_exist_3_i = 0; $_friends_exist_3_i < $_friends_exist_3_count; $_friends_exist_3_i++) { $rtv .= '
        <br /><a href=\'#\' style=\'color: #403214; font: bold 10px Verdana;\'>[ View All ]</a>
      </fieldset>
'; } $rtv .= '
'; $_friends_exist_2_count = isset($this->_tpldata['friends_exist_2.']) ? sizeof($this->_tpldata['friends_exist_2.']) : 0;for($_friends_exist_2_i = 0; $_friends_exist_2_i < $_friends_exist_2_count; $_friends_exist_2_i++) { $rtv .= '
      <fieldset>
      <legend>' . ( ( isset($this->_tpldata['friends_exist_2.'][$_friends_exist_2_i]['FRIENDS_SHOWN']) ) ? $this->_tpldata['friends_exist_2.'][$_friends_exist_2_i]['FRIENDS_SHOWN'] : '' ) . ' of ' . ( ( isset($this->_tpldata['friends_exist_2.'][$_friends_exist_2_i]['FRIENDS_TOTAL']) ) ? $this->_tpldata['friends_exist_2.'][$_friends_exist_2_i]['FRIENDS_TOTAL'] : '' ) . ' ' . ( ( isset($this->_tpldata['friends_exist_2.'][$_friends_exist_2_i]['FRIENDS_LEVEL']) ) ? $this->_tpldata['friends_exist_2.'][$_friends_exist_2_i]['FRIENDS_LEVEL'] : '' ) . '</legend>
'; } $rtv .= '
'; $_friends_2_count = isset($this->_tpldata['friends_2.']) ? sizeof($this->_tpldata['friends_2.']) : 0;for($_friends_2_i = 0; $_friends_2_i < $_friends_2_count; $_friends_2_i++) { $rtv .= '
        <a href=\'http://' . ( ( isset($this->_tpldata['friends_2.'][$_friends_2_i]['NAME']) ) ? $this->_tpldata['friends_2.'][$_friends_2_i]['NAME'] : '' ) . '.txmafia.com/\'>' . ( ( isset($this->_tpldata['friends_2.'][$_friends_2_i]['AVATAR']) ) ? $this->_tpldata['friends_2.'][$_friends_2_i]['AVATAR'] : '' ) . '</a>
'; } $rtv .= '
'; $_friends_exist_2_count = isset($this->_tpldata['friends_exist_2.']) ? sizeof($this->_tpldata['friends_exist_2.']) : 0;for($_friends_exist_2_i = 0; $_friends_exist_2_i < $_friends_exist_2_count; $_friends_exist_2_i++) { $rtv .= '
        <br /><a href=\'#\' style=\'color: #403214; font: bold 10px Verdana;\'>[ View All ]</a>
      </fieldset>
'; } $rtv .= '
'; $_friends_exist_1_count = isset($this->_tpldata['friends_exist_1.']) ? sizeof($this->_tpldata['friends_exist_1.']) : 0;for($_friends_exist_1_i = 0; $_friends_exist_1_i < $_friends_exist_1_count; $_friends_exist_1_i++) { $rtv .= '
      <fieldset>
      <legend>' . ( ( isset($this->_tpldata['friends_exist_1.'][$_friends_exist_1_i]['FRIENDS_SHOWN']) ) ? $this->_tpldata['friends_exist_1.'][$_friends_exist_1_i]['FRIENDS_SHOWN'] : '' ) . ' of ' . ( ( isset($this->_tpldata['friends_exist_1.'][$_friends_exist_1_i]['FRIENDS_TOTAL']) ) ? $this->_tpldata['friends_exist_1.'][$_friends_exist_1_i]['FRIENDS_TOTAL'] : '' ) . ' ' . ( ( isset($this->_tpldata['friends_exist_1.'][$_friends_exist_1_i]['FRIENDS_LEVEL']) ) ? $this->_tpldata['friends_exist_1.'][$_friends_exist_1_i]['FRIENDS_LEVEL'] : '' ) . '</legend>
'; } $rtv .= '
'; $_friends_1_count = isset($this->_tpldata['friends_1.']) ? sizeof($this->_tpldata['friends_1.']) : 0;for($_friends_1_i = 0; $_friends_1_i < $_friends_1_count; $_friends_1_i++) { $rtv .= '
        <a href=\'http://' . ( ( isset($this->_tpldata['friends_1.'][$_friends_1_i]['NAME']) ) ? $this->_tpldata['friends_1.'][$_friends_1_i]['NAME'] : '' ) . '.txmafia.com/\'>' . ( ( isset($this->_tpldata['friends_1.'][$_friends_1_i]['AVATAR']) ) ? $this->_tpldata['friends_1.'][$_friends_1_i]['AVATAR'] : '' ) . '</a>
'; } $rtv .= '
'; $_friends_exist_1_count = isset($this->_tpldata['friends_exist_1.']) ? sizeof($this->_tpldata['friends_exist_1.']) : 0;for($_friends_exist_1_i = 0; $_friends_exist_1_i < $_friends_exist_1_count; $_friends_exist_1_i++) { $rtv .= '
        <br /><a href=\'#\' style=\'color: #403214; font: bold 10px Verdana;\'>[ View All ]</a>
      </fieldset>
'; } $rtv .= '
'; $_friends_exist_0_count = isset($this->_tpldata['friends_exist_0.']) ? sizeof($this->_tpldata['friends_exist_0.']) : 0;for($_friends_exist_0_i = 0; $_friends_exist_0_i < $_friends_exist_0_count; $_friends_exist_0_i++) { $rtv .= '
      <fieldset>
      <legend>' . ( ( isset($this->_tpldata['friends_exist_0.'][$_friends_exist_0_i]['FRIENDS_SHOWN']) ) ? $this->_tpldata['friends_exist_0.'][$_friends_exist_0_i]['FRIENDS_SHOWN'] : '' ) . ' of ' . ( ( isset($this->_tpldata['friends_exist_0.'][$_friends_exist_0_i]['FRIENDS_TOTAL']) ) ? $this->_tpldata['friends_exist_0.'][$_friends_exist_0_i]['FRIENDS_TOTAL'] : '' ) . ' ' . ( ( isset($this->_tpldata['friends_exist_0.'][$_friends_exist_0_i]['FRIENDS_LEVEL']) ) ? $this->_tpldata['friends_exist_0.'][$_friends_exist_0_i]['FRIENDS_LEVEL'] : '' ) . '</legend>
'; } $rtv .= '
'; $_friends_0_count = isset($this->_tpldata['friends_0.']) ? sizeof($this->_tpldata['friends_0.']) : 0;for($_friends_0_i = 0; $_friends_0_i < $_friends_0_count; $_friends_0_i++) { $rtv .= '
        <a href=\'http://' . ( ( isset($this->_tpldata['friends_0.'][$_friends_0_i]['NAME']) ) ? $this->_tpldata['friends_0.'][$_friends_0_i]['NAME'] : '' ) . '.txmafia.com/\'>' . ( ( isset($this->_tpldata['friends_0.'][$_friends_0_i]['AVATAR']) ) ? $this->_tpldata['friends_0.'][$_friends_0_i]['AVATAR'] : '' ) . '</a>
'; } $rtv .= '
'; $_friends_exist_0_count = isset($this->_tpldata['friends_exist_0.']) ? sizeof($this->_tpldata['friends_exist_0.']) : 0;for($_friends_exist_0_i = 0; $_friends_exist_0_i < $_friends_exist_0_count; $_friends_exist_0_i++) { $rtv .= '
        <br /><a href=\'#\' style=\'color: #403214; font: bold 10px Verdana;\'>[ View All ]</a>
      </fieldset>
'; } $rtv .= '

      <div class="grn-top"><div class="dft-btm"><div class="dft-rht"><div class="dft-lft"><div class="grn-ctl"><div class="grn-ctr">
        <div class="dft-hdr grn-bdr">
          Member Activity</div>

        <table border="0" cellspacing="0" cellpadding="4">
          <tr><td valign=\'top\' class=\'info\'>Forums Status:</td><td class=\'profile\' style=\'padding-bottom: 8px;\'>
            ' . (isset($this->_tpldata['.'][0]['POSTS']) ? $this->_tpldata['.'][0]['POSTS'] : '') . ' Total Posts<br>
            ' . (isset($this->_tpldata['.'][0]['POST_PERCENT']) ? $this->_tpldata['.'][0]['POST_PERCENT'] : '') . ' Posts Per Day<br>
            ' . (isset($this->_tpldata['.'][0]['POST_DAY']) ? $this->_tpldata['.'][0]['POST_DAY'] : '') . '% of All Posts<br>
          </td></tr>

          <tr><td valign=\'top\' class=\'info\'>Total Respect:</td><td class=\'profile\' style=\'padding-bottom: 8px;\'>
            ' . (isset($this->_tpldata['.'][0]['RESPECT']) ? $this->_tpldata['.'][0]['RESPECT'] : '') . ' Points<br>
            ' . (isset($this->_tpldata['.'][0]['RESPECT_PERCENT']) ? $this->_tpldata['.'][0]['RESPECT_PERCENT'] : '') . '% Of Top<br>
          </td></tr>
        </table>
         </div></div></div></div></div></div>
        </div>

    <div style="float: right; width: 512px;">
      <div class="grn-top"><div class="dft-btm"><div class="dft-rht"><div class="dft-lft"><div class="grn-ctl"><div class="grn-ctr">
        <div class="dft-hdr grn-bdr">
          Member Profile</div>

        <img src="http://www.' . (isset($this->_tpldata['.'][0]['SITE_DOMAIN']) ? $this->_tpldata['.'][0]['SITE_DOMAIN'] : '') . 'media/' . (isset($this->_tpldata['.'][0]['avatar']) ? $this->_tpldata['.'][0]['avatar'] : '') . '.gif" width="50" height="50" class="dft-img" style="display: block; float: left;" />
        <div>
            <span style="font-weight: bold; font-size: 32px;">' . (isset($this->_tpldata['.'][0]['nick_name']) ? $this->_tpldata['.'][0]['nick_name'] : '') . '</span><br />
          Link @ <a href="http://' . (isset($this->_tpldata['.'][0]['link_name']) ? $this->_tpldata['.'][0]['link_name'] : '') . '.' . (isset($this->_tpldata['.'][0]['SITE_DOMAIN']) ? $this->_tpldata['.'][0]['SITE_DOMAIN'] : '') . '" title="' . (isset($this->_tpldata['.'][0]['nick_name']) ? $this->_tpldata['.'][0]['nick_name'] : '') . '\'s Profile">http://' . (isset($this->_tpldata['.'][0]['link_name']) ? $this->_tpldata['.'][0]['link_name'] : '') . '.' . (isset($this->_tpldata['.'][0]['SITE_DOMAIN']) ? $this->_tpldata['.'][0]['SITE_DOMAIN'] : '') . '</a>
        </div>
        <br class="clr" />

        <fieldset>
          <legend>Basic Information</legend>
          <table border="0" cellspacing="0" cellpadding="0" width="100%">
              <tr>
                <td>Ranking:</td><td>' . (isset($this->_tpldata['.'][0]['POSTER_RANK']) ? $this->_tpldata['.'][0]['POSTER_RANK'] : '') . '</td>
            </tr>
            <tr>
              <td>Last Visit:</td><td>' . (isset($this->_tpldata['.'][0]['LAST_VISIT']) ? $this->_tpldata['.'][0]['LAST_VISIT'] : '') . '</td>
            </tr>
            ' . (isset($this->_tpldata['.'][0]['JOINED']) ? $this->_tpldata['.'][0]['JOINED'] : '') . '
            ' . (isset($this->_tpldata['.'][0]['BORN']) ? $this->_tpldata['.'][0]['BORN'] : '') . '
            ' . (isset($this->_tpldata['.'][0]['SEX']) ? $this->_tpldata['.'][0]['SEX'] : '') . '
            ' . (isset($this->_tpldata['.'][0]['WEBSITE']) ? $this->_tpldata['.'][0]['WEBSITE'] : '') . '
            ' . (isset($this->_tpldata['.'][0]['OCCUPATION']) ? $this->_tpldata['.'][0]['OCCUPATION'] : '') . '
            ' . (isset($this->_tpldata['.'][0]['SKILLS']) ? $this->_tpldata['.'][0]['SKILLS'] : '') . '
          </table>
        </fieldset>

'; $_personal_information_count = isset($this->_tpldata['personal_information.']) ? sizeof($this->_tpldata['personal_information.']) : 0;for($_personal_information_i = 0; $_personal_information_i < $_personal_information_count; $_personal_information_i++) { $rtv .= '
        <fieldset>
          <legend>Personal Information</legend>
          <table border=\'0\' cellspacing=\'0\' cellpadding=\'2\'>
            ' . (isset($this->_tpldata['.'][0]['NAME']) ? $this->_tpldata['.'][0]['NAME'] : '') . '
            ' . (isset($this->_tpldata['.'][0]['PI_RELATIONSHIP']) ? $this->_tpldata['.'][0]['PI_RELATIONSHIP'] : '') . '
            ' . (isset($this->_tpldata['.'][0]['PI_PREFERENCE']) ? $this->_tpldata['.'][0]['PI_PREFERENCE'] : '') . '
            ' . (isset($this->_tpldata['.'][0]['PI_STATUS']) ? $this->_tpldata['.'][0]['PI_STATUS'] : '') . '
            ' . (isset($this->_tpldata['.'][0]['PI_INTERESTS']) ? $this->_tpldata['.'][0]['PI_INTERESTS'] : '') . '
            ' . (isset($this->_tpldata['.'][0]['PI_ABOUT']) ? $this->_tpldata['.'][0]['PI_ABOUT'] : '') . '
        </table>
        </fieldset>
'; } $rtv .= '

'; $_favorites_count = isset($this->_tpldata['favorites.']) ? sizeof($this->_tpldata['favorites.']) : 0;for($_favorites_i = 0; $_favorites_i < $_favorites_count; $_favorites_i++) { $rtv .= '
        <fieldset>
          <legend>Favorites</legend>
          <table border=\'0\' cellspacing=\'0\' cellpadding=\'2\'>
            ' . (isset($this->_tpldata['.'][0]['FV_MUSIC']) ? $this->_tpldata['.'][0]['FV_MUSIC'] : '') . '
            ' . (isset($this->_tpldata['.'][0]['FV_MOVIES']) ? $this->_tpldata['.'][0]['FV_MOVIES'] : '') . '
            ' . (isset($this->_tpldata['.'][0]['FV_GAMES']) ? $this->_tpldata['.'][0]['FV_GAMES'] : '') . '
            ' . (isset($this->_tpldata['.'][0]['FV_BOOKS']) ? $this->_tpldata['.'][0]['FV_BOOKS'] : '') . '
            ' . (isset($this->_tpldata['.'][0]['FV_ARTISTS']) ? $this->_tpldata['.'][0]['FV_ARTISTS'] : '') . '
            ' . (isset($this->_tpldata['.'][0]['FV_QUOTES']) ? $this->_tpldata['.'][0]['FV_QUOTES'] : '') . '
          </table>
        </fieldset>
'; } $rtv .= '
            </div></div></div></div></div></div>
        </div>
    <br class="clr" />

    <div class="blu-top"><div class="dft-btm"><div class="dft-rht"><div class="dft-lft"><div class="blu-ctl"><div class="blu-ctr">
        <div class="dft-hdr blu-bdr">
          Movies By Author</div>
'; $_movies_count = isset($this->_tpldata['movies.']) ? sizeof($this->_tpldata['movies.']) : 0;for($_movies_i = 0; $_movies_i < $_movies_count; $_movies_i++) { $rtv .= '
      <a href="http://www.txm.com/movies/' . ( ( isset($this->_tpldata['movies.'][$_movies_i]['id']) ) ? $this->_tpldata['movies.'][$_movies_i]['id'] : '' ) . '/' . ( ( isset($this->_tpldata['movies.'][$_movies_i]['title_link']) ) ? $this->_tpldata['movies.'][$_movies_i]['title_link'] : '' ) . '/" title="' . ( ( isset($this->_tpldata['movies.'][$_movies_i]['title']) ) ? $this->_tpldata['movies.'][$_movies_i]['title'] : '' ) . '" class="blk-lnk ' . ( ( isset($this->_tpldata['movies.'][$_movies_i]['color']) ) ? $this->_tpldata['movies.'][$_movies_i]['color'] : '' ) . '">
        <img src="http://www.txm.com/media/' . ( ( isset($this->_tpldata['movies.'][$_movies_i]['avatar']) ) ? $this->_tpldata['movies.'][$_movies_i]['avatar'] : '' ) . '.gif" width="50" height="50" alt="' . ( ( isset($this->_tpldata['movies.'][$_movies_i]['id']) ) ? $this->_tpldata['movies.'][$_movies_i]['id'] : '' ) . '" />
        <span>
          <strong>' . ( ( isset($this->_tpldata['movies.'][$_movies_i]['title']) ) ? $this->_tpldata['movies.'][$_movies_i]['title'] : '' ) . '</strong><br />
          ' . ( ( isset($this->_tpldata['movies.'][$_movies_i]['synopsis']) ) ? $this->_tpldata['movies.'][$_movies_i]['synopsis'] : '' ) . '<br />
        </span><br class="clr" />
      </a>
'; } $rtv .= '
        </div></div></div></div></div></div>';?>