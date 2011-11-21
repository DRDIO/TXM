<?php $rtv .= '<div class="col-w3x4">
    <div class="col-pad blu-blck"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b>
        <div class="blk-hedr blu-dbck icn-games">
            Game: \'' . (isset($this->_tpldata['.'][0]['title']) ? $this->_tpldata['.'][0]['title'] : '') . '\' By ' . (isset($this->_tpldata['.'][0]['nick_name']) ? $this->_tpldata['.'][0]['nick_name'] : '') . '
        </div>

        <div class="blu-back blu-brdr">
            <div style="float: left; width: 75px;">
                <img src="' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'games/images/ratings/' . (isset($this->_tpldata['.'][0]['rating']) ? $this->_tpldata['.'][0]['rating'] : '') . '.gif" alt="Rating ' . (isset($this->_tpldata['.'][0]['rating']) ? $this->_tpldata['.'][0]['rating'] : '') . '" style="margin: 6px 4px 4px 10px;" /><br />
                <img src="' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'games/images/types/' . (isset($this->_tpldata['.'][0]['type']) ? $this->_tpldata['.'][0]['type'] : '') . '.gif" alt="Type ' . (isset($this->_tpldata['.'][0]['type']) ? $this->_tpldata['.'][0]['type'] : '') . '" style="margin: 6px 4px 4px 10px;" />
            </div>

            <div style="float: left;">
                <table width="260" border="0" cellspacing="4" cellpadding="0">
                    <tr>
                        <td width="80">Title:</td><td><b>' . (isset($this->_tpldata['.'][0]['title']) ? $this->_tpldata['.'][0]['title'] : '') . '</b></td></tr>
                    <tr>
                        <td>Author:</td><td><b><a href="http://' . (isset($this->_tpldata['.'][0]['link_name']) ? $this->_tpldata['.'][0]['link_name'] : '') . '.txmafia.com/" title="View Profile">' . (isset($this->_tpldata['.'][0]['nick_name']) ? $this->_tpldata['.'][0]['nick_name'] : '') . '</a></b></td></tr>
                    <tr>
                        <td>Website:</td><td><b><a href="' . (isset($this->_tpldata['.'][0]['web_url']) ? $this->_tpldata['.'][0]['web_url'] : '') . '" title="website">' . (isset($this->_tpldata['.'][0]['web_title']) ? $this->_tpldata['.'][0]['web_title'] : '') . '</a></b></td></tr>
                    <tr>
                        <td valign="top">Score:</td><td valign="top"><b style="font-size: 18px; vertical-align: text-top;">' . (isset($this->_tpldata['.'][0]['score']) ? $this->_tpldata['.'][0]['score'] : '') . '</b> out of 10.00</td></tr>
                    <tr>
                        <td>Uploaded:</td><td>' . (isset($this->_tpldata['.'][0]['date']) ? $this->_tpldata['.'][0]['date'] : '') . '</td></tr>
                    <tr>
                        <td>Size:</td><td>' . (isset($this->_tpldata['.'][0]['size']) ? $this->_tpldata['.'][0]['size'] : '') . ' MB @ ' . (isset($this->_tpldata['.'][0]['speed']) ? $this->_tpldata['.'][0]['speed'] : '') . ' (56 kbps)</td></tr>
                    <tr>
                        <td>Status:</td><td>' . (isset($this->_tpldata['.'][0]['votes']) ? $this->_tpldata['.'][0]['votes'] : '') . ' Votes &amp; ' . (isset($this->_tpldata['.'][0]['reviews']) ? $this->_tpldata['.'][0]['reviews'] : '') . ' Reviews</td></tr>
                    <tr>
                        <td>Views:</td><td>' . (isset($this->_tpldata['.'][0]['views']) ? $this->_tpldata['.'][0]['views'] : '') . ' Plays</td></tr>
                </table>
            </div>

            <a href="' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'games/play/' . (isset($this->_tpldata['.'][0]['id']) ? $this->_tpldata['.'][0]['id'] : '') . '/' . (isset($this->_tpldata['.'][0]['title_link']) ? $this->_tpldata['.'][0]['title_link'] : '') . '/" onclick="return flaPLAY(' . (isset($this->_tpldata['.'][0]['id']) ? $this->_tpldata['.'][0]['id'] : '') . ', ' . (isset($this->_tpldata['.'][0]['width']) ? $this->_tpldata['.'][0]['width'] : '') . ', ' . (isset($this->_tpldata['.'][0]['height']) ? $this->_tpldata['.'][0]['height'] : '') . ');" style="display: block; float: right; margin: 20px 4px 4px 4px; width: 232px; height: 142px; background: url(' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'games/images/play.gif) no-repeat; text-indent: -9999em; border: 2px solid #ffffff;">Play Game</a>
            <br class="clr" />

            <div class="dft-cnt blu-alt">
                ' . (isset($this->_tpldata['.'][0]['commentary']) ? $this->_tpldata['.'][0]['commentary'] : '') . '
            </div>
        </div>
    <b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></div>
</div>

<div class="col-w1x4">
    <div class="col-pad blu-blck"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b>
        <div class="blk-hedr blu-dbck icn-games">
            Play a Random Game</div>

        <div class="blu-back blu-brdr">
'; $_random_count = isset($this->_tpldata['random.']) ? sizeof($this->_tpldata['random.']) : 0;for($_random_i = 0; $_random_i < $_random_count; $_random_i++) { $rtv .= '
        <a href="' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'games/' . ( ( isset($this->_tpldata['random.'][$_random_i]['id']) ) ? $this->_tpldata['random.'][$_random_i]['id'] : '' ) . '/' . ( ( isset($this->_tpldata['random.'][$_random_i]['title_link']) ) ? $this->_tpldata['random.'][$_random_i]['title_link'] : '' ) . '/" title="' . ( ( isset($this->_tpldata['random.'][$_random_i]['title']) ) ? $this->_tpldata['random.'][$_random_i]['title'] : '' ) . '" class="blk-lnk ' . ( ( isset($this->_tpldata['random.'][$_random_i]['color']) ) ? $this->_tpldata['random.'][$_random_i]['color'] : '' ) . '">
            <img src="' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'media/' . ( ( isset($this->_tpldata['random.'][$_random_i]['avatar']) ) ? $this->_tpldata['random.'][$_random_i]['avatar'] : '' ) . '.gif" width="50" height="50" alt="' . ( ( isset($this->_tpldata['random.'][$_random_i]['id']) ) ? $this->_tpldata['random.'][$_random_i]['id'] : '' ) . '" />
            <span>
                <strong>' . ( ( isset($this->_tpldata['random.'][$_random_i]['title']) ) ? $this->_tpldata['random.'][$_random_i]['title'] : '' ) . '</strong><br />
                ' . ( ( isset($this->_tpldata['random.'][$_random_i]['synopsis']) ) ? $this->_tpldata['random.'][$_random_i]['synopsis'] : '' ) . '<br />
            </span><br class="clr" />
        </a>
'; } $rtv .= '
        </div>
    <b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></div>

    <div class="col-pad blu-blck"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b>
        <div class="blk-hedr blu-dbck icn-games">
            Play More by Author</div>

        <div class="blu-back blu-brdr">
'; $_games_more_count = isset($this->_tpldata['games_more.']) ? sizeof($this->_tpldata['games_more.']) : 0;for($_games_more_i = 0; $_games_more_i < $_games_more_count; $_games_more_i++) { $rtv .= '
            <a href="' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'games/' . ( ( isset($this->_tpldata['games_more.'][$_games_more_i]['id']) ) ? $this->_tpldata['games_more.'][$_games_more_i]['id'] : '' ) . '/' . ( ( isset($this->_tpldata['games_more.'][$_games_more_i]['title_link']) ) ? $this->_tpldata['games_more.'][$_games_more_i]['title_link'] : '' ) . '/" title="' . ( ( isset($this->_tpldata['games_more.'][$_games_more_i]['title']) ) ? $this->_tpldata['games_more.'][$_games_more_i]['title'] : '' ) . '" class="blk-lnk ' . ( ( isset($this->_tpldata['games_more.'][$_games_more_i]['color']) ) ? $this->_tpldata['games_more.'][$_games_more_i]['color'] : '' ) . '">
                <img src="' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'media/' . ( ( isset($this->_tpldata['games_more.'][$_games_more_i]['avatar']) ) ? $this->_tpldata['games_more.'][$_games_more_i]['avatar'] : '' ) . '.gif" width="50" height="50" alt="' . ( ( isset($this->_tpldata['games_more.'][$_games_more_i]['id']) ) ? $this->_tpldata['games_more.'][$_games_more_i]['id'] : '' ) . '" />
                <span>
                    <strong>' . ( ( isset($this->_tpldata['games_more.'][$_games_more_i]['title']) ) ? $this->_tpldata['games_more.'][$_games_more_i]['title'] : '' ) . '</strong><br />
                    ' . ( ( isset($this->_tpldata['games_more.'][$_games_more_i]['synopsis']) ) ? $this->_tpldata['games_more.'][$_games_more_i]['synopsis'] : '' ) . '<br />
                </span><br class="clr" />
            </a>
'; } $rtv .= '
        </div>
    <b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></div>
</div>

<div class="col-w2x4">
    <div class="col-pad grn-blck"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b>
        <div class="blk-hedr grn-dbck">
            Read Latest Comments
        </div>

        <div class="grn-back grn-brdr">
'; $_comments_count = isset($this->_tpldata['comments.']) ? sizeof($this->_tpldata['comments.']) : 0;for($_comments_i = 0; $_comments_i < $_comments_count; $_comments_i++) { $rtv .= '
            <div class="dft-cnt ' . ( ( isset($this->_tpldata['comments.'][$_comments_i]['color']) ) ? $this->_tpldata['comments.'][$_comments_i]['color'] : '' ) . '" style="min-height: 50px;">
            <img src="' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'media/' . ( ( isset($this->_tpldata['comments.'][$_comments_i]['avatar']) ) ? $this->_tpldata['comments.'][$_comments_i]['avatar'] : '' ) . '.gif" width="50" height="50" alt="' . ( ( isset($this->_tpldata['comments.'][$_comments_i]['id']) ) ? $this->_tpldata['comments.'][$_comments_i]['id'] : '' ) . '" class="blk-lnk-img" />
            <div>
                <a href="http://' . ( ( isset($this->_tpldata['comments.'][$_comments_i]['link_name']) ) ? $this->_tpldata['comments.'][$_comments_i]['link_name'] : '' ) . '.' . (isset($this->_tpldata['.'][0]['SITE_DOMAIN']) ? $this->_tpldata['.'][0]['SITE_DOMAIN'] : '') . '"><strong>' . ( ( isset($this->_tpldata['comments.'][$_comments_i]['nick_name']) ) ? $this->_tpldata['comments.'][$_comments_i]['nick_name'] : '' ) . '</strong></a>
                <span class="grn-txt">on ' . ( ( isset($this->_tpldata['comments.'][$_comments_i]['date_comment']) ) ? $this->_tpldata['comments.'][$_comments_i]['date_comment'] : '' ) . '</span>
                <div class="blu-brd" style="margin: 3px 0px 4px 0px;"></div>
                ' . ( ( isset($this->_tpldata['comments.'][$_comments_i]['comment']) ) ? $this->_tpldata['comments.'][$_comments_i]['comment'] : '' ) . '<br />
                <span class="blu-brd">' . ( ( isset($this->_tpldata['comments.'][$_comments_i]['reply']) ) ? $this->_tpldata['comments.'][$_comments_i]['reply'] : '' ) . '</span>
            </div><br class="clr" />
            </div>
'; } $rtv .= '
'; $_comments_more_count = isset($this->_tpldata['comments_more.']) ? sizeof($this->_tpldata['comments_more.']) : 0;for($_comments_more_i = 0; $_comments_more_i < $_comments_more_count; $_comments_more_i++) { $rtv .= '
            <div class="index-more">Viewing 5 of ' . (isset($this->_tpldata['.'][0]['reviews']) ? $this->_tpldata['.'][0]['reviews'] : '') . ' reviews.</div>
'; } $rtv .= '
        </div>
    <b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></div>
</div>
';?>