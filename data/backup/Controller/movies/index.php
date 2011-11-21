<?php

$R->pageTitle = 'Movies';

$select = $dbAdapter->select()
    ->from('movies', array(
        'id',
        'title',
        'id_type',
        'score_offset'))
    ->where($dbAdapter->quoteIdentifier('deleted') . ' = 0');

$selectC1 = clone $select;
$selectC2 = clone $select;
$selectC3 = clone $select;
$selectC4 = clone $select;

// New Blood
$selectC1
    ->order('date DESC')
    ->limitPage(1, 53);
generateTemplate($selectC1, 'c1');

// Prime Rib
$selectC2
    ->order('vote_offset DESC')
    ->limitPage(1, 30);
generateTemplate($selectC2, 'c2');

// Pure Gold
$selectC3
    ->order('score_offset DESC')
    ->limitPage(1, 53);
generateTemplate($selectC3, 'c3');

// Life Mates
$selectC4
    ->where($dbAdapter->quoteIdentifier('vote_offset') . ' < 5')
    ->order('date ASC')
    ->limitPage(1, 21);
generateTemplate($selectC4, 'c4');

//Generates Query Template Array.
function generateTemplate($select, $name)
{
    global $dbAdapter, $R, $template;

    $count = 0;
    $stmt  = $dbAdapter->query($select);

    // Build each template for media
    while ($row = $stmt->fetch()) {
        $blockName  = $name . ($count < 6 ? '_image' : '');
        $avatarUri  = '/media/movies/screenshots/' . $row['id'] . '.gif';
        $avatarPath = $R->path['website'] . $avatarUri;

        $row['avatar']     = (file_exists($avatarPath) ? $avatarUri : '/images/movies/default-icon.gif');
        $row['color']      = ($count % 2 ? '' : 'dft-alt');
        $row['title_link'] = str2link($row['title']);
        $template->addBlock($blockName, $row);

        $count++;
    }
}