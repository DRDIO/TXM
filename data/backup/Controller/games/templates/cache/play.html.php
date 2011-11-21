<?php $rtv .= '                        <div class="blu-top"><div class="dft-btm"><div class="dft-rht"><div class="dft-lft"><div class="blu-ctl"><div class="blu-ctr">
                <div class="dft-hdr blu-bdr blu-icn-games">
                  Play Game \'' . (isset($this->_tpldata['.'][0]['title']) ? $this->_tpldata['.'][0]['title'] : '') . '\' By ' . (isset($this->_tpldata['.'][0]['nick_name']) ? $this->_tpldata['.'][0]['nick_name'] : '') . '</div>

              <div class="dft-cnt blu-bdr" style="text-align: center;">
                  <object type="application/x-shockwave-flash" name="allowAccessScript" vlaue="sameDomain" width="' . (isset($this->_tpldata['.'][0]['width']) ? $this->_tpldata['.'][0]['width'] : '') . '" height="' . (isset($this->_tpldata['.'][0]['height']) ? $this->_tpldata['.'][0]['height'] : '') . '" data="' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'media/games/' . (isset($this->_tpldata['.'][0]['id']) ? $this->_tpldata['.'][0]['id'] : '') . '.swf">
                    <param name="allowAccessScript" vlaue="sameDomain" /><param name="movie" value="http://www.' . (isset($this->_tpldata['.'][0]['SITE_DOMAIN']) ? $this->_tpldata['.'][0]['SITE_DOMAIN'] : '') . 'media/games/' . (isset($this->_tpldata['.'][0]['id']) ? $this->_tpldata['.'][0]['id'] : '') . '.swf" />
                  </object></div>

                          <a href="' . (isset($this->_tpldata['.'][0]['SITE_LEVEL']) ? $this->_tpldata['.'][0]['SITE_LEVEL'] : '') . 'games/' . (isset($this->_tpldata['.'][0]['id']) ? $this->_tpldata['.'][0]['id'] : '') . '/' . (isset($this->_tpldata['.'][0]['title_link']) ? $this->_tpldata['.'][0]['title_link'] : '') . '/" class="dft-lnk-big blu-alt">Return to Game \'' . (isset($this->_tpldata['.'][0]['title']) ? $this->_tpldata['.'][0]['title'] : '') . '\' Details to Vote and to Comment</a>
                        </div></div></div></div></div></div>';?>