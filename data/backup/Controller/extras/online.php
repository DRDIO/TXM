<?

define('ROOT', true);
define('PAGE_TITLE', 'View Online Members');
include('../includes/header.php');
include('includes/common.php');

// initialize variables
$guest_users             = 0;
$registered_users = 0;
$hidden_users         = 0;
$member_count         = 1;
$guest_count             = 1;
$prev_user                 = 0;
$prev_ip                     = '';

// Josh Tuttle's Random Cloth Generator
$wardrobe0 = array(); // complete outfits
$wardrobe1 = array(); // tops
$wardrobe2 = array(); // bottoms
$wardrobe3 = array(); // accessories

array_push($wardrobe0, "a prom dress");
array_push($wardrobe0, "a sumo suit");
array_push($wardrobe0, "superman roos");
array_push($wardrobe0, "simply nothing");
array_push($wardrobe0, "a tube sock");
array_push($wardrobe0, "leather bondage");
array_push($wardrobe0, "a sailor's uni");
array_push($wardrobe0, "a slinky dress");
array_push($wardrobe0, "a wedding dress");
array_push($wardrobe0, "a wet-suit");
array_push($wardrobe0, "a suit of armor");
array_push($wardrobe0, "just body paint");
array_push($wardrobe0, "a french outfit");
array_push($wardrobe0, "a nurse's uni");
array_push($wardrobe0, "footy pajamas");
array_push($wardrobe0, "a jump suit");
array_push($wardrobe0, "a space suit");
array_push($wardrobe0, "tin foil");
array_push($wardrobe0, "a bra");
array_push($wardrobe0, "a toga");

array_push($wardrobe1, "a Mr. T shirt");
array_push($wardrobe1, "a tube top");
array_push($wardrobe1, "a push-up bra");
array_push($wardrobe1, "a pink sweater");
array_push($wardrobe1, "no shirt");
array_push($wardrobe1, "nipple warmers");
array_push($wardrobe1, "a leather jacket");
array_push($wardrobe1, "a denim jacket");
array_push($wardrobe1, "a t-shirt");
array_push($wardrobe1, "a sweater");
array_push($wardrobe1, "a Spongebob top");
array_push($wardrobe1, "nipple rings");
array_push($wardrobe1, "a life preserver");
array_push($wardrobe1, "water wings");
array_push($wardrobe1, "a tank top");
array_push($wardrobe1, "a v-neck");
array_push($wardrobe1, "a spandex shirt");
array_push($wardrobe1, "a fake tie");
array_push($wardrobe1, "fake muscles");
array_push($wardrobe1, "a TXM jersey");
array_push($wardrobe1, "a parka");
array_push($wardrobe1, "a bear skin");
array_push($wardrobe1, "a fur coat");
array_push($wardrobe1, "a silk robe");
array_push($wardrobe1, "a fishnet top");
array_push($wardrobe1, "a bullet vest");
array_push($wardrobe1, "a stuffed bra");
array_push($wardrobe1, "duct taped dyno");

array_push($wardrobe2, "overalls");
array_push($wardrobe2, "tighty whiteys");
array_push($wardrobe2, "a speedo");
array_push($wardrobe2, "bell bottoms");
array_push($wardrobe2, "blue jeans");
array_push($wardrobe2, "leather chaps");
array_push($wardrobe2, "parachute pants");
array_push($wardrobe2, "a long skirt");
array_push($wardrobe2, "a short skirt");
array_push($wardrobe2, "pink panties");
array_push($wardrobe2, "no pants");
array_push($wardrobe2, "boxer shorts");
array_push($wardrobe2, "khakis");
array_push($wardrobe2, "biker shorts");
array_push($wardrobe2, "a jock strap");
array_push($wardrobe2, "wrestling tights");
array_push($wardrobe2, "a diaper");
array_push($wardrobe2, "jogging pants");
array_push($wardrobe2, "jogging shorts");
array_push($wardrobe2, "tear away pants");
array_push($wardrobe2, "cotton briefs");
array_push($wardrobe2, "black pants");
array_push($wardrobe2, "leather pants");
array_push($wardrobe2, "shorts");
array_push($wardrobe2, "short shorts");
array_push($wardrobe2, "Daisy Dukes");
array_push($wardrobe2, "a thong");

array_push($wardrobe3, "bunny slippers");
array_push($wardrobe3, "a top hat");
array_push($wardrobe3, "a franken mask");
array_push($wardrobe3, "yellow bikini");
array_push($wardrobe3, "tube socks");
array_push($wardrobe3, "pantyhose");
array_push($wardrobe3, "a beer hat");
array_push($wardrobe3, "a powdred wig");
array_push($wardrobe3, "an eye patch");
array_push($wardrobe3, "handcuffs");
array_push($wardrobe3, "a necklace");
array_push($wardrobe3, "a bandana");
array_push($wardrobe3, "a Marge wig");
array_push($wardrobe3, "a bald-cap");
array_push($wardrobe3, "french perfume");
array_push($wardrobe3, "a chastity belt");
array_push($wardrobe3, "a tin-foil hat");
array_push($wardrobe3, "a paper hat");
array_push($wardrobe3, "a bike helmet");
array_push($wardrobe3, "red lipstick");
array_push($wardrobe3, "stilletto heels");
array_push($wardrobe3, "a blindfold");
array_push($wardrobe3, "a gun holster");
array_push($wardrobe3, "a backpack");

// Grab forum information
$sql = "
    SELECT forum_name, 
                 forum_id 
    FROM " . FORUMS_TABLE . "
";

if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'Could not obtain Forum Info (SQL).');
while($row = $db->sql_fetchrow($result))
{
    $forum_data[$row['forum_id']] = $row['forum_name'];
}

// Get user list
$sql = "
    SELECT u.user_id, 
           u.username, 
                 u.user_nick_name,
                 u.user_allow_viewonline, 
                 u.user_level, 
                 s.session_logged_in, 
                 s.session_time, 
                 s.session_page, 
                 s.session_ip
    FROM " . USERS_TABLE . " u, 
         " . SESSIONS_TABLE . " s    
    WHERE u.user_id = s.session_user_id
        AND s.session_time >= UNIX_TIMESTAMP() - 900
    ORDER BY u.username ASC, 
             s.session_ip ASC
";

if(!($result = $db->sql_query($sql))) message_die(GENERAL_ERROR, 'Could not obtain User Info (SQL).');
while($row = $db->sql_fetchrow($result)) 
{
    $view_online = false;

    if ($row['session_logged_in']) 
    {
        $user_id = $row['user_id'];

        if ($user_id != $prev_user) 
        {
            $member_count++;        
            $user_name = !empty($row['user_nick_name']) ? $row['user_nick_name'] : ucwords($row['username']);
            $user_link = 'http://' . strtolower(str_replace(' ', '', $row['username'])) . '.' . $SITE_DOMAIN . '.com/';

            if ($row['user_level'] == ADMIN) 
            {
                $user_name = "<B STYLE='color: yellow;'>{$user_name}</B>";
            } 
            else if ($row['user_level'] == MOD) 
            {
                $user_name = "<B STYLE='color: yellow;'>{$user_name}</B>";
            }
            else
            {
                $user_name = "<B>{$user_name}</B>";
            }

            $view_online = true;
            $registered_users++;
            
            $which_row = 'reg_user_row';
            $prev_user = $user_id;
        }
    } 
    else 
    {
        $user_link = 'http://www.txmafia.com/';
        
        if($row['session_ip'] != $prev_ip)
        {
            $view_online = true;
            $guest_users++;

            $names = array();
            
            array_push($names, "A lowly thug");
            array_push($names, "A prostitute");
            array_push($names, "An asian");
            array_push($names, "A cracker");
            array_push($names, "A pothead");
            array_push($names, "A housewife");
            array_push($names, "A clown");
            array_push($names, "A packer");
            array_push($names, "A policeman");
            array_push($names, "A pimp");
            array_push($names, "A goth kid");
            array_push($names, "An emo girl");
            array_push($names, "Your mom");
            array_push($names, "The band");
            array_push($names, "The president");
                
            $user_name = $names[rand(0, count($names)-1)];

            $guest_count++;
            $which_row = 'guest_user_row';
        }
    }

    $prev_ip = $row['session_ip'];

    if($view_online) 
    {
        if($row['session_page'] < 1)
        {
            switch($row['session_page']) 
            {
                case PAGE_INDEX:
                    $location = "visiting the forums";
                    $location_url = 'index.php';
                    break;
                case PAGE_POSTING:
                    $location = "posting a message";
                    $location_url = 'index.php';
                    break;
                case PAGE_LOGIN:
                    $location = "logging on";
                    $location_url = 'index.php';
                    break;
                case PAGE_SEARCH:
                    $location = "searching TxMafia";
                    $location_url = 'search.php';
                    break;
                case PAGE_PROFILE:
                    $location = "reading mafioso files";
                    $location_url = 'index.php';
                    break;
                case PAGE_VIEWONLINE:
                    $location = "reading police scans";
                    $location_url = 'viewonline.php';
                    break;
                case PAGE_VIEWMEMBERS:
                    $location = "spying on mafiosos";
                    $location_url = 'memberlist.php';
                    break;
                case PAGE_PRIVMSGS:
                    $location = "reading dead notes";
                    $location_url = 'privmsg.php';
                    break;
                case PAGE_FAQ:
                    $location = "stumbling through FAQs";
                    $location_url = 'faq.php';
                    break;
                // Kevin Nuut (NUUTKD) January 12th, 2005
                // Additional Sessions for the Cellblock    
                case PAGE_CB_INDEX:
                    $location = "visiting the cellblock";
                    $location_url = '../cellblock/index.php';
                    break;
                case PAGE_CB_VIEW:
                    $location = "taunting Flash inmates";
                    $location_url = '../cellblock/index.php';
                    break;                    
                case PAGE_CB_NEW:
                    $location = "submitting a Flash inmate";
                    $location_url = '../cellblock/index.php';
                    break;            
                case PAGE_CB_EDIT:
                    $location = "changing a Flash inmate";
                    $location_url = '../cellblock/index.php';
                    break;
                case PAGE_CB_SEARCH:
                    $location = "searching the cellblock";
                    $location_url = '../cellblock/index.php';
                    break;                    
                case PAGE_FRONTPAGE:
                    $location = "entering TxMafia";
                    $location_url = '../index.php';
                    break;                    
                default:
                // End Additional Sessions for Cellblock
                    $location = "in the shadows";
                    $location_url = '/index.php';
            }
        } 
        else 
        {
            $location_url = "http://forum.txmafia.com/forum/{$row['session_page']}";
            $location = "in " . $forum_data[$row['session_page']];
        }

        // grab one entry from each wardrobe array
        $suit             = $wardrobe0[rand(0, count($wardrobe0) - 1)];
        $shirt             = $wardrobe1[rand(0, count($wardrobe1) - 1)];
        $pants             = $wardrobe2[rand(0, count($wardrobe2) - 1)];
        $accessory     = $wardrobe3[rand(0, count($wardrobe3) - 1)];

        // Randomly decide what wardrobe groups to use, then dress the user
        $outfit = rand(1, 600);

        if ($outfit > 500)             $wardrobe = $suit  . " &amp; " . $shirt;
        else if ($outfit > 400)    $wardrobe = $suit  . " &amp; " . $pants;
        else if ($outfit > 300) $wardrobe = $suit  . " &amp; " . $accessory;
        else if ($outfit > 200) $wardrobe = $shirt . " &amp; " . $pants;
        else if ($outfit > 100) $wardrobe = $shirt . " &amp; " . $accessory;
        else                                         $wardrobe = $pants . " &amp; " . $accessory;

        // END OF PSYCHOGOLDFISH RANDOM CLOTHES GENERATOR
        $time = create_date('g:i a', $row['session_time'], $board_config['board_timezone']);
        
        $final_sentence = "<A HREF='{$user_link}'>{$user_name}</A> is <A HREF='{$location_url}'>{$location}</A> at {$time} wearing {$wardrobe}.";
        
        $template->assign_block_vars($which_row, array(
            'COLOR'                 => ($which_row == 'reg_user_row') ? $member_count % 2 + 1 : $guest_count % 2 + 1,
            'OUTPUT'                => $final_sentence,            
        ));
    }
}

$template->assign_vars(array(
    'REG_USER_ONLINE' => $registered_users,
    'GUEST_USER_ONLINE' => $guest_users,
));

include('../includes/footer.php');

?>