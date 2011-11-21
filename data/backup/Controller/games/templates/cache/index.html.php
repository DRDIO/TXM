<?php $rtv .= '<div class="col-w1x4">
    <div class="col-pad blu-blck"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b>
        <div class="blk-hedr blu-dbck icn-games">
            Latest Games</div>

        <div class="blu-back blu-brdr">
            <div class="dft-hlt">
'; $_c1_image_count = isset($this->_tpldata['c1_image.']) ? sizeof($this->_tpldata['c1_image.']) : 0;for($_c1_image_i = 0; $_c1_image_i < $_c1_image_count; $_c1_image_i++) { $rtv .= '
                <a href="' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'games/' . ( ( isset($this->_tpldata['c1_image.'][$_c1_image_i]['id']) ) ? $this->_tpldata['c1_image.'][$_c1_image_i]['id'] : '' ) . '/' . ( ( isset($this->_tpldata['c1_image.'][$_c1_image_i]['title_link']) ) ? $this->_tpldata['c1_image.'][$_c1_image_i]['title_link'] : '' ) . '/" title="' . ( ( isset($this->_tpldata['c1_image.'][$_c1_image_i]['title']) ) ? $this->_tpldata['c1_image.'][$_c1_image_i]['title'] : '' ) . '">
                        <img src="' . ( ( isset($this->_tpldata['c1_image.'][$_c1_image_i]['avatar']) ) ? $this->_tpldata['c1_image.'][$_c1_image_i]['avatar'] : '' ) . '" width="50" height="50" alt="' . ( ( isset($this->_tpldata['c1_image.'][$_c1_image_i]['title_link']) ) ? $this->_tpldata['c1_image.'][$_c1_image_i]['title_link'] : '' ) . '" class="blk-img" style="margin: 4px 6px;" /></a>
'; } $rtv .= '
                <div class="clr"></div>
            </div>
'; $_c1_count = isset($this->_tpldata['c1.']) ? sizeof($this->_tpldata['c1.']) : 0;for($_c1_i = 0; $_c1_i < $_c1_count; $_c1_i++) { $rtv .= '
             <a href="' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'games/' . ( ( isset($this->_tpldata['c1.'][$_c1_i]['id']) ) ? $this->_tpldata['c1.'][$_c1_i]['id'] : '' ) . '/' . ( ( isset($this->_tpldata['c1.'][$_c1_i]['title_link']) ) ? $this->_tpldata['c1.'][$_c1_i]['title_link'] : '' ) . '/" title="' . ( ( isset($this->_tpldata['c1.'][$_c1_i]['title']) ) ? $this->_tpldata['c1.'][$_c1_i]['title'] : '' ) . '" class="dft-lnk media-lnk ' . ( ( isset($this->_tpldata['c1.'][$_c1_i]['color']) ) ? $this->_tpldata['c1.'][$_c1_i]['color'] : '' ) . '" style="background-image: url(' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'games/images/categories/' . ( ( isset($this->_tpldata['c1.'][$_c1_i]['id_type']) ) ? $this->_tpldata['c1.'][$_c1_i]['id_type'] : '' ) . '.gif);">
                ' . ( ( isset($this->_tpldata['c1.'][$_c1_i]['title']) ) ? $this->_tpldata['c1.'][$_c1_i]['title'] : '' ) . '</a>
'; } $rtv .= '
        </div>
    <b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></div>
</div>

<div class="col-w1x4">
    <div class="col-pad blu-blck"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b>
        <div class="blk-hedr blu-dbck icn-games">
            Weekly Best</div>

        <div class="blu-back blu-brdr">
            <div class="dft-hlt">
'; $_c2_image_count = isset($this->_tpldata['c2_image.']) ? sizeof($this->_tpldata['c2_image.']) : 0;for($_c2_image_i = 0; $_c2_image_i < $_c2_image_count; $_c2_image_i++) { $rtv .= '
                <a href="' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'games/' . ( ( isset($this->_tpldata['c2_image.'][$_c2_image_i]['id']) ) ? $this->_tpldata['c2_image.'][$_c2_image_i]['id'] : '' ) . '/' . ( ( isset($this->_tpldata['c2_image.'][$_c2_image_i]['title_link']) ) ? $this->_tpldata['c2_image.'][$_c2_image_i]['title_link'] : '' ) . '/" title="' . ( ( isset($this->_tpldata['c1_image.'][$_c1_image_i]['title']) ) ? $this->_tpldata['c1_image.'][$_c1_image_i]['title'] : '' ) . '">
                        <img src="' . ( ( isset($this->_tpldata['c2_image.'][$_c2_image_i]['avatar']) ) ? $this->_tpldata['c2_image.'][$_c2_image_i]['avatar'] : '' ) . '" width="50" height="50" alt="' . ( ( isset($this->_tpldata['c2_image.'][$_c2_image_i]['title_link']) ) ? $this->_tpldata['c2_image.'][$_c2_image_i]['title_link'] : '' ) . '" class="blk-img" style="margin: 4px 6px;" /></a>
'; } $rtv .= '
                <div class="clr"></div>
            </div>
'; $_c2_count = isset($this->_tpldata['c2.']) ? sizeof($this->_tpldata['c2.']) : 0;for($_c2_i = 0; $_c2_i < $_c2_count; $_c2_i++) { $rtv .= '
             <a href="' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'games/' . ( ( isset($this->_tpldata['c2.'][$_c2_i]['id']) ) ? $this->_tpldata['c2.'][$_c2_i]['id'] : '' ) . '/' . ( ( isset($this->_tpldata['c2.'][$_c2_i]['title_link']) ) ? $this->_tpldata['c2.'][$_c2_i]['title_link'] : '' ) . '/" title="' . ( ( isset($this->_tpldata['c2.'][$_c2_i]['title']) ) ? $this->_tpldata['c2.'][$_c2_i]['title'] : '' ) . '" class="dft-lnk media-lnk ' . ( ( isset($this->_tpldata['c2.'][$_c2_i]['color']) ) ? $this->_tpldata['c2.'][$_c2_i]['color'] : '' ) . '" style="background-image: url(' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'games/images/categories/' . ( ( isset($this->_tpldata['c2.'][$_c2_i]['id_type']) ) ? $this->_tpldata['c2.'][$_c2_i]['id_type'] : '' ) . '.gif);">
                ' . ( ( isset($this->_tpldata['c2.'][$_c2_i]['title']) ) ? $this->_tpldata['c2.'][$_c2_i]['title'] : '' ) . '</a>
'; } $rtv .= '
        </div>
    <b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></div>

    <div class="col-pad blu-blck"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b>
        <div class="blk-hedr blu-dbck icn-games">
            Dieing Classics</div>

        <div class="blu-back blu-brdr">
            <div class="dft-hlt">
'; $_c4_image_count = isset($this->_tpldata['c4_image.']) ? sizeof($this->_tpldata['c4_image.']) : 0;for($_c4_image_i = 0; $_c4_image_i < $_c4_image_count; $_c4_image_i++) { $rtv .= '
                <a href="' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'games/' . ( ( isset($this->_tpldata['c4_image.'][$_c4_image_i]['id']) ) ? $this->_tpldata['c4_image.'][$_c4_image_i]['id'] : '' ) . '/' . ( ( isset($this->_tpldata['c4_image.'][$_c4_image_i]['title_link']) ) ? $this->_tpldata['c4_image.'][$_c4_image_i]['title_link'] : '' ) . '/" title="' . ( ( isset($this->_tpldata['c1_image.'][$_c1_image_i]['title']) ) ? $this->_tpldata['c1_image.'][$_c1_image_i]['title'] : '' ) . '">
                        <img src="' . ( ( isset($this->_tpldata['c4_image.'][$_c4_image_i]['avatar']) ) ? $this->_tpldata['c4_image.'][$_c4_image_i]['avatar'] : '' ) . '" width="50" height="50" alt="' . ( ( isset($this->_tpldata['c4_image.'][$_c4_image_i]['title_link']) ) ? $this->_tpldata['c4_image.'][$_c4_image_i]['title_link'] : '' ) . '" class="blk-img" style="margin: 4px 6px;" /></a>
'; } $rtv .= '
                <div class="clr"></div>
            </div>
'; $_c4_count = isset($this->_tpldata['c4.']) ? sizeof($this->_tpldata['c4.']) : 0;for($_c4_i = 0; $_c4_i < $_c4_count; $_c4_i++) { $rtv .= '
             <a href="' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'games/' . ( ( isset($this->_tpldata['c4.'][$_c4_i]['id']) ) ? $this->_tpldata['c4.'][$_c4_i]['id'] : '' ) . '/' . ( ( isset($this->_tpldata['c4.'][$_c4_i]['title_link']) ) ? $this->_tpldata['c4.'][$_c4_i]['title_link'] : '' ) . '/" title="' . ( ( isset($this->_tpldata['c4.'][$_c4_i]['title']) ) ? $this->_tpldata['c4.'][$_c4_i]['title'] : '' ) . '" class="dft-lnk media-lnk ' . ( ( isset($this->_tpldata['c4.'][$_c4_i]['color']) ) ? $this->_tpldata['c4.'][$_c4_i]['color'] : '' ) . '" style="background-image: url(' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'games/images/categories/' . ( ( isset($this->_tpldata['c4.'][$_c4_i]['id_type']) ) ? $this->_tpldata['c4.'][$_c4_i]['id_type'] : '' ) . '.gif);">
                ' . ( ( isset($this->_tpldata['c4.'][$_c4_i]['title']) ) ? $this->_tpldata['c4.'][$_c4_i]['title'] : '' ) . '</a>
'; } $rtv .= '
        </div>
    <b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></div>
</div>

<div class="col-w1x4">
    <div class="col-pad blu-blck"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b>
        <div class="blk-hedr blu-dbck icn-games">
            All Time Greatest</div>

        <div class="blu-back blu-brdr">
            <div class="dft-hlt">
'; $_c3_image_count = isset($this->_tpldata['c3_image.']) ? sizeof($this->_tpldata['c3_image.']) : 0;for($_c3_image_i = 0; $_c3_image_i < $_c3_image_count; $_c3_image_i++) { $rtv .= '
                <a href="' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'games/' . ( ( isset($this->_tpldata['c3_image.'][$_c3_image_i]['id']) ) ? $this->_tpldata['c3_image.'][$_c3_image_i]['id'] : '' ) . '/' . ( ( isset($this->_tpldata['c3_image.'][$_c3_image_i]['title_link']) ) ? $this->_tpldata['c3_image.'][$_c3_image_i]['title_link'] : '' ) . '/" title="' . ( ( isset($this->_tpldata['c1_image.'][$_c1_image_i]['title']) ) ? $this->_tpldata['c1_image.'][$_c1_image_i]['title'] : '' ) . '">
                        <img src="' . ( ( isset($this->_tpldata['c3_image.'][$_c3_image_i]['avatar']) ) ? $this->_tpldata['c3_image.'][$_c3_image_i]['avatar'] : '' ) . '" width="50" height="50" alt="' . ( ( isset($this->_tpldata['c3_image.'][$_c3_image_i]['title_link']) ) ? $this->_tpldata['c3_image.'][$_c3_image_i]['title_link'] : '' ) . '" class="blk-img" style="margin: 4px 6px;" /></a>
'; } $rtv .= '
                <div class="clr"></div>
            </div>
'; $_c3_count = isset($this->_tpldata['c3.']) ? sizeof($this->_tpldata['c3.']) : 0;for($_c3_i = 0; $_c3_i < $_c3_count; $_c3_i++) { $rtv .= '
             <a href="' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'games/' . ( ( isset($this->_tpldata['c3.'][$_c3_i]['id']) ) ? $this->_tpldata['c3.'][$_c3_i]['id'] : '' ) . '/' . ( ( isset($this->_tpldata['c3.'][$_c3_i]['title_link']) ) ? $this->_tpldata['c3.'][$_c3_i]['title_link'] : '' ) . '/" title="' . ( ( isset($this->_tpldata['c3.'][$_c3_i]['title']) ) ? $this->_tpldata['c3.'][$_c3_i]['title'] : '' ) . '" class="dft-lnk media-lnk ' . ( ( isset($this->_tpldata['c3.'][$_c3_i]['color']) ) ? $this->_tpldata['c3.'][$_c3_i]['color'] : '' ) . '" style="background-image: url(' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'games/images/categories/' . ( ( isset($this->_tpldata['c3.'][$_c3_i]['id_type']) ) ? $this->_tpldata['c3.'][$_c3_i]['id_type'] : '' ) . '.gif);">
                ' . ( ( isset($this->_tpldata['c3.'][$_c3_i]['title']) ) ? $this->_tpldata['c3.'][$_c3_i]['title'] : '' ) . '</a>
'; } $rtv .= '
        </div>
    <b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></div>
</div>
';?>