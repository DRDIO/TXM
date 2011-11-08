<?php if(defined("ROOT") === FALSE) { die("Hacking attempt"); }

$cellblock_sidebar = <<<END
                            <div class="red-top"><div class="dft-btm"><div class="dft-rht"><div class="dft-lft"><div class="red-ctl"><div class="red-ctr">
                <div class="dft-hdr red-bdr">
                  Points of Interest</div>

                                <a href="{$SITE["fauxlvl"]}games/upload/" title="Upload Game" class="dft-lnk red-alt">Upload Your Own Game</a>
                                <a href="{$SITE["fauxlvl"]}movies/" title="Watch Movies" class="dft-lnk">Watch Some Movies</a>
                                <a href="{$SITE["fauxlvl"]}misc/copyright-notice/" title="Copyright Notice" class="dft-lnk red-alt">Review Copyright Policy</a>                                
        
                                <div class="dft-hdr red-bdr">
                  Content Filters</div>
        
                                <a href="{$SITE["fauxlvl"]}games/filter/latest" class="dft-lnk red-alt">Latest Flash Entries</a>
                                <a href="{$SITE["fauxlvl"]}games/filter/popular" class="dft-lnk">Most Popular By Vote</a>
                                <a href="{$SITE["fauxlvl"]}games/filter/best" class="dft-lnk red-alt">Only The Best</a>
                                <a href="{$SITE["fauxlvl"]}movies/filter/movies" class="dft-lnk">Favorite Movies</a>
                                <a href="{$SITE["fauxlvl"]}games/filter/games" class="dft-lnk red-alt">Favorite Games</a>
                                <a href="{$SITE["fauxlvl"]}games/filter/needsvotes" class="dft-lnk">Needs More Votes</a>
                                <a href="{$SITE["fauxlvl"]}games/filter/worst" class="dft-lnk red-alt">Only The Worst</a>
        
                                <div class="dft-hdr red-bdr">
                  Play By Game Types</div>
        
                                <a href="{$SITE["fauxlvl"]}games/filter/action" class="dft-lnk red-alt">Action Shooters</a>
                                <a href="{$SITE["fauxlvl"]}games/filter/fighters" class="dft-lnk">Battle Fighters</a>
                                <a href="{$SITE["fauxlvl"]}games/filter/othergames" class="dft-lnk red-alt">Other Games</a>
                                <a href="{$SITE["fauxlvl"]}games/filter/party" class="dft-lnk">Party Modes</a>
                                <a href="{$SITE["fauxlvl"]}games/filter/classic" class="dft-lnk red-alt">Classic Platforming</a>
                                <a href="{$SITE["fauxlvl"]}games/filter/rpg" class="dft-lnk">Role Playing Games</a>
                                <a href="{$SITE["fauxlvl"]}games/filter/puzzle" class="dft-lnk red-alt">Cards &amp; Puzzles</a>
                                <a href="{$SITE["fauxlvl"]}games/filter/racing" class="dft-lnk">Racing Vehicles</a>
                                <a href="{$SITE["fauxlvl"]}games/filter/tutor" class="dft-lnk red-alt">Interactive Tutorials</a>
                                <a href="{$SITE["fauxlvl"]}games/filter/sports" class="dft-lnk">Sports &amp; Competition</a>
        
                                <div class="dft-hdr red-bdr">
                  Play By Age Ratings</div>
        
                                <a href="{$SITE["fauxlvl"]}games/filter/childhood" class="dft-lnk red-alt">Early Childhood</a>
                                <a href="{$SITE["fauxlvl"]}games/filter/everyone" class="dft-lnk">Everyone Else</a>
                                <a href="{$SITE["fauxlvl"]}games/filter/teen" class="dft-lnk red-alt">Teenagers &amp; Up</a>
                                <a href="{$SITE["fauxlvl"]}games/filter/mature" class="dft-lnk">Mature Content</a>
                                <a href="{$SITE["fauxlvl"]}games/filter/adults" class="dft-lnk red-alt">Adults Only</a>
        
                                <div class="dft-hdr red-bdr">
                  Important Notice</div>
        
                                <div class="dft-cnt">
                                    Please review five movies or games for every submission you make to help the TXM community.<br /><br />
                                
                                    Give constructive feedback.<br /><br />
                                    
                                    Flash movies and games require five votes to be on 'Only The Best', 'Most Popular' movies and games are ordered by vote amounts, and 'Latest Entries' are ordered by date uploaded.<br /><br />
                                    
                                    Spam voting and 'vote fifen' techniques are not allowed at TXM.  Please review each Flash movie and game honestly and fairly.<br /><br />
                                    
                                    No porn is allowed.
                                </div>
                            </div></div></div></div></div></div>
END;

$template->assign_vars(array(
    "CELLBLOCK_SIDEBAR" => $cellblock_sidebar,
));    

?>