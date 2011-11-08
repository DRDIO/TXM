<?php $rtv .= '<div class="col-w3x4">
'; $_pagination_count = isset($this->_tpldata['pagination.']) ? sizeof($this->_tpldata['pagination.']) : 0;for($_pagination_i = 0; $_pagination_i < $_pagination_count; $_pagination_i++) { $rtv .= '
        <div class="col-pad blu-blck"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b>
        <div class="blu-dbck pagination">
'; $_row_count = isset($this->_tpldata['pagination.'][$_pagination_i]['row.']) ? sizeof($this->_tpldata['pagination.'][$_pagination_i]['row.']) : 0;for($_row_i = 0; $_row_i < $_row_count; $_row_i++) { $rtv .= '
            <a href="' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'games/filter/' . (isset($this->_tpldata['.'][0]['mode']) ? $this->_tpldata['.'][0]['mode'] : '') . '/' . ( ( isset($this->_tpldata['pagination.'][$_pagination_i]['row.'][$_row_i]['page']) ) ? $this->_tpldata['pagination.'][$_pagination_i]['row.'][$_row_i]['page'] : '' ) . '" title="Jump to Page ' . ( ( isset($this->_tpldata['pagination.'][$_pagination_i]['row.'][$_row_i]['page']) ) ? $this->_tpldata['pagination.'][$_pagination_i]['row.'][$_row_i]['page'] : '' ) . '">' . ( ( isset($this->_tpldata['pagination.'][$_pagination_i]['row.'][$_row_i]['title']) ) ? $this->_tpldata['pagination.'][$_pagination_i]['row.'][$_row_i]['title'] : '' ) . '</a>
'; } $rtv .= '
            <div class="clr"></div>
        </div>
    <b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></div>
'; } $rtv .= '

        <div class="col-pad blu-blck"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b>
        <div class="blk-hedr blu-dbck icn-games">
                        Games Filtered By ' . (isset($this->_tpldata['.'][0]['title']) ? $this->_tpldata['.'][0]['title'] : '') . '
        </div>

        <div class="blu-brdr blu-back">
'; $_listflash_count = isset($this->_tpldata['listflash.']) ? sizeof($this->_tpldata['listflash.']) : 0;for($_listflash_i = 0; $_listflash_i < $_listflash_count; $_listflash_i++) { $rtv .= '
            <a href="' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'games/' . ( ( isset($this->_tpldata['listflash.'][$_listflash_i]['id']) ) ? $this->_tpldata['listflash.'][$_listflash_i]['id'] : '' ) . '/' . ( ( isset($this->_tpldata['listflash.'][$_listflash_i]['title_link']) ) ? $this->_tpldata['listflash.'][$_listflash_i]['title_link'] : '' ) . '/" title="' . ( ( isset($this->_tpldata['listflash.'][$_listflash_i]['title']) ) ? $this->_tpldata['listflash.'][$_listflash_i]['title'] : '' ) . '" class="blk-lnk ' . ( ( isset($this->_tpldata['listflash.'][$_listflash_i]['color']) ) ? $this->_tpldata['listflash.'][$_listflash_i]['color'] : '' ) . '">
                <img src="' . ( ( isset($this->_tpldata['listflash.'][$_listflash_i]['avatar']) ) ? $this->_tpldata['listflash.'][$_listflash_i]['avatar'] : '' ) . '" width="50" height="50" alt="' . ( ( isset($this->_tpldata['listflash.'][$_listflash_i]['title']) ) ? $this->_tpldata['listflash.'][$_listflash_i]['title'] : '' ) . '" />
                <span>
                    <strong>' . ( ( isset($this->_tpldata['listflash.'][$_listflash_i]['title']) ) ? $this->_tpldata['listflash.'][$_listflash_i]['title'] : '' ) . '</strong><br />
                    ' . ( ( isset($this->_tpldata['listflash.'][$_listflash_i]['synopsis']) ) ? $this->_tpldata['listflash.'][$_listflash_i]['synopsis'] : '' ) . '<br />

                    ' . ( ( isset($this->_tpldata['listflash.'][$_listflash_i]['id_user']) ) ? $this->_tpldata['listflash.'][$_listflash_i]['id_user'] : '' ) . ' -
                    ' . ( ( isset($this->_tpldata['listflash.'][$_listflash_i]['link_name']) ) ? $this->_tpldata['listflash.'][$_listflash_i]['link_name'] : '' ) . ' -
                    ' . ( ( isset($this->_tpldata['listflash.'][$_listflash_i]['nick_name']) ) ? $this->_tpldata['listflash.'][$_listflash_i]['nick_name'] : '' ) . ' -
                    ' . ( ( isset($this->_tpldata['listflash.'][$_listflash_i]['rating']) ) ? $this->_tpldata['listflash.'][$_listflash_i]['rating'] : '' ) . ' -
                    ' . ( ( isset($this->_tpldata['listflash.'][$_listflash_i]['type']) ) ? $this->_tpldata['listflash.'][$_listflash_i]['type'] : '' ) . ' -
                    ' . ( ( isset($this->_tpldata['listflash.'][$_listflash_i]['views']) ) ? $this->_tpldata['listflash.'][$_listflash_i]['views'] : '' ) . ' -
                    ' . ( ( isset($this->_tpldata['listflash.'][$_listflash_i]['votes']) ) ? $this->_tpldata['listflash.'][$_listflash_i]['votes'] : '' ) . ' -
                    ' . ( ( isset($this->_tpldata['listflash.'][$_listflash_i]['score']) ) ? $this->_tpldata['listflash.'][$_listflash_i]['score'] : '' ) . '

                </span><br class="clr" />
            </a>
'; } $rtv .= '
        </div>
        <b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></div>

'; $_pagination_count = isset($this->_tpldata['pagination.']) ? sizeof($this->_tpldata['pagination.']) : 0;for($_pagination_i = 0; $_pagination_i < $_pagination_count; $_pagination_i++) { $rtv .= '
        <div class="col-pad blu-blck"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b>
            <div class="blu-dbck pagination">
'; $_row_count = isset($this->_tpldata['pagination.'][$_pagination_i]['row.']) ? sizeof($this->_tpldata['pagination.'][$_pagination_i]['row.']) : 0;for($_row_i = 0; $_row_i < $_row_count; $_row_i++) { $rtv .= '
            <a href="' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'games/filter/' . (isset($this->_tpldata['.'][0]['mode']) ? $this->_tpldata['.'][0]['mode'] : '') . '/' . ( ( isset($this->_tpldata['pagination.'][$_pagination_i]['row.'][$_row_i]['page']) ) ? $this->_tpldata['pagination.'][$_pagination_i]['row.'][$_row_i]['page'] : '' ) . '" title="Jump to Page ' . ( ( isset($this->_tpldata['pagination.'][$_pagination_i]['row.'][$_row_i]['page']) ) ? $this->_tpldata['pagination.'][$_pagination_i]['row.'][$_row_i]['page'] : '' ) . '">' . ( ( isset($this->_tpldata['pagination.'][$_pagination_i]['row.'][$_row_i]['title']) ) ? $this->_tpldata['pagination.'][$_pagination_i]['row.'][$_row_i]['title'] : '' ) . '</a>
'; } $rtv .= '
            <div class="clr"></div>
        </div>
        <b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></div>
'; } $rtv .= '
</div>
';?>