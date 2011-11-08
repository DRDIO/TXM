<?php

// Get Movie ID
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
$id = $router->getVar(0, 0);

// Grab Movie
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
$select = $dbAdapter->select()
    ->from(array('m' => 'movies'), array(
        'm.id',
        'm.id_user',
        'm.title',
        'u.link_name',
        'u.nick_name',
        'web_url' => 'u.user_website',
        'web_title' => 'u.user_website_title',
        'm.title',
        'm.synopsis',
        'm.commentary',
        'rating' => 'm.id_rating',
        'type' => 'm.id_type',
        'views' => 'm.view_offset',
        'votes' => 'm.vote_offset',
        'score' => 'm.score_offset',
        'm.size',
        'm.width',
        'm.height',
        'm.date'))
    ->joinInner(array('u' => 'txm_users'),
        $dbAdapter->quoteIdentifier('m.id_user') . ' = ' .
        $dbAdapter->quoteIdentifier('u.id'), array())
    ->where($dbAdapter->quoteIdentifier('m.id') . ' = ?')
    ->where($dbAdapter->quoteIdentifier('m.deleted') . ' = 0');

$row = $dbAdapter->fetchRow($select, array($id));

if ($row) {

// Update View Count
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    /*
    $dbAdapter->update('movies', array(
            'view_offset' => '(1 + view_offset)'),
        $dbAdapter->quoteIdentifier('id') . ' = ' . $row['id']);
	*/
// Grab Five Most Recent Reviews
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    $select = $dbAdapter->select()
        ->from(array('r' => 'movies_comments'), array(
            'r.id',
            'r.id_user',
            'u.link_name',
            'u.nick_name',
            'r.comment',
            'r.reply',
            'r.status',
            'r.date_comment',
            'r.date_reply'))
        ->joinInner(array('u' => 'txm_users'),
            $dbAdapter->quoteIdentifier('r.id_user') . ' = ' .
            $dbAdapter->quoteIdentifier('u.id'), array())
        ->where($dbAdapter->quoteIdentifier('r.id_movie') . ' = ?')
        ->where($dbAdapter->quoteIdentifier('r.status') . ' = 0')
        ->order('r.date_comment DESC')
        ->limit(1, 5);

    $count = 0;
    $stmt  = $dbAdapter->query($select, array($row['id']));

    // Build each template for media
    while ($comment = $stmt->fetch()) {
        $avatarUri  = '/media/profiles/avatars/' . $comment['id_user'] . '.gif';
        $avatarPath = $R->path['website'] . $avatarUri;

        $comment['avatar']     = (file_exists($avatarPath) ? $avatarUri : '/images/users/default-icon.gif');
        $comment['color']       = ($count % 2 ? '' : 'grn-alt');
        $comment['comment']     = preg_replace(array("/&lt;a href=&quot;(.*?)&quot;&gt;(.*?)&lt;\/A&gt;/i", "/\S{40}/"), array("<a href= \"$1\" >$2< /a>", "... "), nl2br($comment["comment"]));
        $comment['reply']       = preg_replace(array("/&lt;a href=&quot;(.*?)&quot;&gt;(.*?)&lt;\/A&gt;/i", "/\S{40}/"), array("<a href= \"$1\" >$2< /a>", "... "), nl2br($comment["reply"]));
        $comment['date_comment']= date("D, M. jS, \a\t g:ia", strtotime($comment["date_comment"]));
        $comment['date_reply']  = date("D, M. jS, \a\t g:ia", strtotime($comment["date_reply"]));

        $template->addBlock('comments', $comment);
    }

    $row['reviews'] = $count;

// Build Additional Fields
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    //$row["speed"] = round($row["size"] * 8 / 1000 / 56.6);
    //$row["speed"] = ($row["speed"] >= 60 ? floor($row["speed"] / 60) . " Min, " : "") . (row["speed"] % 60) . " Sec";
    $row["title_link"] = str2link($row["title"]);
    $row["title"]      = htmlentities($row["title"], ENT_QUOTES, 'ISO-8859-1', false);
    $row["nick_name"]  = htmlentities($row["nick_name"]);
    $row["size"]       = sprintf("%.1f", $row["size"] / 1000000);

    // Format fancy date based on when file was uploaded
    $dateTime          = strtotime('2007-09-14 11:54:23'); // strtotime($row["date"]);
    $dateOffset        = date('Ymd') - date('Ymd', $dateTime);

    if ($dateOffset === 0) {
            $row["date"] = 'Today at ' . date('g A', $dateTime);
    } else if ($dateOffset === 1) {
            $row["date"] = 'Yesterday at ' . date('g A', $dateTime);
    } else if ($dateOffset < 7) {
            $row["date"] = date('l \a\t g A', $dateTime);
    } else if ($dateOffset < 365) {
            $row["date"] = date('F jS \a\t g A', $dateTime);
    } else {
            $row["date"] = date('M. jS, Y \a\t g A', $dateTime);
    }

    $row["commentary"] = preg_replace(array("/\[url=(.*?)\](.*?)\[\/url\]/i", "/([^a-z0-9])((?:https?:\/\/)?(?:[a-z0-9-_]{1-63}\.)*(?:[a-z0-9][a-z0-9-]{1,61}[a-z0-9]\.)(?:[a-z]{2,6}|[a-z]{2}\.[a-z]{2})(?:.*?))($|&lt;|&gt;|&quot;| )/i"), array("$1 ($2)", "$1<a href=\"$2\" target=\"_blank\">[Link]</a>$3"), htmlentities($row["commentary"], ENT_QUOTES, 'ISO-8859-1', false));

    // $row["commentary"] = (empty($row["commentary"]) === FALSE ?
    //    preg_replace(array("/&lt;a href=&quot;(.*?)&quot;&gt;(.*?)&lt;\/A&gt;/i", "/\S{40}/"), array("<a href= \"$1\" >$2< /a>", " ... "), nl2br($row["commentary"])) : "Author did not provide any commentary.");

    $row["score_icon"] = sprintf("%.3f", $row["score"]);

    $avatarUri     = '/media/profiles/avatars/' . $row['id_user'] . '.gif';
    $avatarPath    = $R->path['website'] . $avatarUri;
    $row['avatar'] = (file_exists($avatarPath) ? $avatarUri : '/images/users/default-icon.gif');

    $template->setVars($row);

    $R->pageTitle = 'Movie "' . $row['title'] . '" by ' . $row['nick_name'];
/*
// Grab Ten Best of Author's Other Movies
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    $sql = "
        SELECT
            id,
            title,
            synopsis
        FROM
            movies
        WHERE
            id_user = " . intval($row["id_user"]) . " AND
            id <> " . intval($row["id"]) . " AND
            deleted = 0
        ORDER BY
            date DESC
        LIMIT
            0, 5
    ";

    $result = $db->sql_query($sql);
    if($result === FALSE)
    {
        message_die(GENERAL_ERROR, "We were unable to retrieve other movies by author.", $sql);
    }
    else
    {
        $count = 0;
        while($more = $db->sql_fetchrow($result))
        {
            $more["color"] = $count++ % 2 === 0 ? "blu-alt" : "";
            $more["title_link"] = str2link($more["title"]);
            $more["title"] = htmlentities($more["title"]);
            $more["synopsis"] = htmlentities($more["synopsis"]);
            $more["avatar"] = (file_exists($SITE["level"] . "media/movies/screenshots/" . $more["id"] . ".gif") === TRUE ?
                "movies/screenshots/" . $more["id"] : "assets/movies-icon");
            $template->assign_block_vars("movies_more", $more);
        }

        if($count < 5)
        {
            for($count; $count < 5; $count)
            {
                $more = array();
                $more["id"] = ".";
                $more["title"] = "Upload Your Own Movie";
                $more["synopsis"] = "Uploading your Flash movie is quick and easy, so get started!";
                $more["color"] = $count++ % 2 === 0 ? "blu-alt" : "";
                $more["title_link"] = "upload";
                $more["avatar"] = "assets/movies-icon";
                $template->assign_block_vars("movies_more", $more);
            }
        }
    }
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

// Grab Eight Random Movies
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    $sql = "
        SELECT
            id,
            title,
            synopsis
        FROM
            movies
        WHERE
            deleted = 0
        ORDER BY
            RAND()
        LIMIT 1, 5
    ";

    $result = $db->sql_query($sql);
    if($result === FALSE)
    {
        message_die(GENERAL_ERROR, "We were unable to retrieve random movies.", $sql);
    }
    else
    {
        $count = 0;
        while($random = $db->sql_fetchrow($result))
        {
            $random["color"] = $count++ % 2 === 0 ? "blu-alt" : "";
            $random["title_link"] = str2link($random["title"]);
            $random["title"] = htmlentities($random["title"]);
            $random["synopsis"] = htmlentities($random["synopsis"]);
            $random["avatar"] = (file_exists($SITE["level"] . "media/movies/screenshots/" . $random["id"] . ".gif") === TRUE ?
                "movies/screenshots/" . $random["id"] : "assets/movies-icon");
            $template->assign_block_vars("random", $random);
        }
    }
// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 */
}
