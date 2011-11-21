<?php if(defined("ROOT") === FALSE) { die("Hacking attempt"); }

// You need to be a NAZI about HTML to avoid attacks, SO PARSE THAT POST!
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
function format_post($post, $ext = FALSE)
{
// Don't waste time with empty strings
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
    if($post === "")
    {
        return $post;
    }

    $store = "";

// Declare regexs and extended regexs for moderators
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *         
    $regex = array(
        // Supported HTML tags
        "/&lt;br ?\/?&gt;/",
        "/&lt;(strong|b)&gt;(.+?)&lt;\/\\1&gt;/i",
        "/&lt;(em|i)&gt;(.+?)&lt;\/\\1&gt;/i",
        "/&lt;u&gt;(.+?)&lt;\/u&gt;/i",
        
        // Dealing with span classes
        "/&lt;span.*?style=&quot;(.*?)&quot;&gt;(.*?)&lt;\/span&gt;/i",
        "/&lt;span style=&quot;((?:(?:font-weight: ?bold|font-style: ?italic|text-decoration: ?underline); ?){1,3})&quot;&gt;(.+?)&lt;\/span&gt;/i",        
    );

    $regex_ext = array(
        // Supported HTML tags
        "/&lt;ul&gt;(.+?)&lt;\/ul&gt;/i",                
        "/&lt;ol&gt;(.+?)&lt;\/ol&gt;/i",
        "/&lt;li&gt;(.+?)&lt;\/li&gt;/i",
        "/&lt;sub&gt;(.+?)&lt;\/sub&gt;/i",
        "/&lt;sup&gt;(.+?)&lt;\/sup&gt;/i",
        "/&lt;strike&gt;(.+?)&lt;\/strike&gt;/i",
                            
        // Dealing with span classes
        "/&lt;span style=&quot;((?:(?:text-decoration: ?line-through|vertical-align: ?(?:sub|super)); ?){1,3})&quot;&gt;(.+?)&lt;\/span&gt;/i",            
    );
    
    $regex_once = array(
        // Link
        "/&lt;a.+?href=&quot;(.*?)&quot;.*?&gt;(.+?)&lt;\/a&gt;/i",
        
        // Flash (Dummy Images)
        // "/&lt;img.+?src=&quot;http:\/\/www\.txm\.com\/media\/assets\/flash-dummy\.gif&quot;.+?data=&quot;(.+?)&quot;.*?&gt;/i",
            
        // Images
        "/&lt;img.+?src=&quot;(.+?)&quot;.*?&gt;/i",
    );

// Declare replace and extended replace for moderators
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *                     
    $replace = array(
        // Supported HTML tags    
        "<br />",
        "<span style=\"font-weight: bold;\">\\2</span>",
        "<span style=\"font-style: italic;\">\\2</span>",
        "<span style=\"text-decoration: underline;\">\\1</span>",

        // Dealing with span classes
        "&lt;span style=&quot;$1&quot;&gt;$2&lt;/span&gt;",
        "<span style=\"$1\">$2</span>",
    );

    $replace_ext = array(
        // Supported HTML tags    
        "<ul>$1</ul>",
        "<ol>$1</ol>",
        "<li>$1</li>",
        "<span style=\"vertical-align: sub;\">$1</span>",
        "<span style=\"vertical-align: super;\">$1</span>",
        "<span style=\"text-decoration: line-through;\">$1</span>",
        
        // Dealing with span classes
        "<span style=\"$1\">$2</span>",
    );
    
    $replace_once = array(
        // Link
        "<a href=\"$1\" title=\"External Link from TXM.com\">$2</a>",
            
        // Images
        "<div style=\"text-align: center;\"><img src=\"$1\" /></div>",
    );
        
// Formats string to html entities (avoids double encoding) with breaks
// Leaves single quotes alone while converting double quotes for HTML parsing
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
    $post = htmlentities(str_replace(array("\r\n", "\r", "\n"), "<br />", (trim($post))), ENT_COMPAT, "ISO-8859-1", FALSE);

// Loop through post until all nested html has been replaced
// If user has set EXT, perform extended searches
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *     
    $store = "";

    do
    {                        
        $store = $post;
        $post = ($ext !== FALSE ? preg_replace(array_merge($regex, $regex_ext), array_merge($replace, $replace_ext), $post) : preg_replace($regex, $replace, $post));
    } 
    while($store !== $post);

// Perform additional non nested regular expressions    
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *         
    if($ext !== FALSE)
    {
        $post = preg_replace($regex_once, $replace_once, $post);
        
// Find images and validate them then fix their width if too large
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *     
        $dump = preg_split("/<img src=\"(.+?)\" \/>/i", $post, 0, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
        
        for($i = 1; $i < sizeof($dump); $i += 2)
        {
            $vars = getimagesize($dump[$i]);
            if($vars !== FALSE)
            {
                $multi = min(1, 498 / $vars[0], 800 / $vars[1]);
                $width = round($vars[0] * $multi);
                
                $dump[$i] = "<img src=\"" . $dump[$i] . "\" width=\"" . $width . "\" alt=\"TXM.com\" />";
            }
            else
            {
                // Clear entry since img was invalid
                $dump[$i] = "";
            }
        }
        
        $post = implode($dump);

// Find flash and validate them then fix their width if too large
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        $post = preg_replace_callback("/(&lt;(object|embed).*?&gt;.*?&lt;\/\\2&gt;)/i", "parse_flash", $post);
    }
    
// Destroy Empty Tags
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    $store = "";
    
    do
    {                        
        $store = $post;
        $post = preg_replace("/<(?P<x>(span|ul|ol|li|div|a|object))[^<]*?><\/\k<x>>/i", "", $post);
    } 
    while($store !== $post);
    
        
// Trash any other HTML that could damage us. Also, get rid of empty HTML
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *     
    $post = preg_replace("/&lt;\S.*?&gt;/i", "", $post);
    
    return $post;
}

function parse_flash($matches)
{    
    $string = $matches[1];
    if(preg_match("/type=(&quot;|'|)application\/x-shockwave-flash\\1/i", $string) === 1)
    {
        if(preg_match("/(?:name=(&quot;|'|)movie\\1 value|data|src)=(&quot;|'|)(.*?)\\2/i", $string, $dump) === 1)
        {
            $src = str_replace("\"", "'", $dump[3]);
                                            
            $width = preg_match("/width(:|=(&quot;|'|))([0-9]{2,4})/i", $string, $dumpw) === 1 ? intval($dumpw[3]) : 0;
            $height = preg_match("/height(:|=(&quot;|'|))([0-9]{2,4})/i", $string, $dumph) === 1 ? intval($dumph[3]) : 0;
            
            if($width !== 0 && $height !== 0)
            {
                $multx = min(425 / $width, 350 / $height, 1);
                $width = floor($width * $multx);
                $height = floor($height * $multx);
    
                $ext = preg_match("/classid=(&quot;|')(.*?)\\1/i", $string, $dumpc) === 1 ? " classid=\"" . str_replace("\"", "'", $dumpc[2]) . "\"" : "";
                $ext .= preg_match("/flashvars=(&quot;|')(.*?)\\1/i", $string, $dumpf) === 1 ? " flashvars=\"" . str_replace("\"", "'", $dumpf[2]) . "\"" : "";

                return "<div style=\"text-align: center;\"><object type=\"application/x-shockwave-flash\" data=\"" . $src . "\"" . $ext . " width=\"" . $width . "\" height=\"" . $height . "\"><param name=\"movie\" value=\"" . $src . "\" /><param name=\"AllowScriptAccess\" value=\"never\" /></object></div>";
            }
        }
    }
    
    return "";
}

?>