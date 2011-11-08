<?php if(defined("ROOT") === FALSE) { die("Hacking attempt"); }

$sidebar = <<<END
    <div class="dft-top">
        <div class="dft-hdr dft-ldr">
            Points of Interest</div>
    
        <a href="{$SITE["fauxlvl"]}extras/" title="" class="dft-lnk dft-alt">Member Rankings</a>
        <a href="{$SITE["fauxlvl"]}extras/staff/" title="" class="dft-lnk">Staff &amp; Credits Page</a>
        <a href="{$SITE["fauxlvl"]}extras/artwork/" title="" class="dft-lnk dft-alt">Fan Based Artwork</a>
        <a href="{$SITE["fauxlvl"]}extras/banners/" title="" class="dft-lnk">Promotional Banners</a>
    </div>

    <div class="dft-top">            
        <div class="dft-hdr dft-ldr">
            Explanation of Extras</div>                                                            
    
        <div class="dft-cnt">
            Site extras was created to display all the fascinating tidbits and history that make TXM so great.<br /><br />
    
            As the TXM staff scans through the backlogs and recovers funny stories and images from the past five years,
            they will be adding them to this section.<br /><br />
            
            Look forward to seeing The History of TXM by SzA, old Photoshop contests, stories from past members, a staff page,
            an about section, and a TXM help.<br /><br />
            
            For now, have fun competing against other members by referencing the new TXM Respect Chart.</div>
    </div>
END;

$template->assign_vars(array(
    "EXTRAS_side" => $sidebar,
));    

?>