<?php

use Simplon\Feed\FeedReader;

require __DIR__ . '/../vendor/autoload.php';

$rss = 'http://www.spiegel.de/schlagzeilen/tops/index.rss';
$rss = 'http://feeds.feedburner.com/techcrunch/europe?format=xml';
$rss = 'http://detailseu.s3.amazonaws.com/rss/events_confirmed_berlin3_Superaki.rss';
$rss = 'http://nullprogram.com/blog/index.rss';
$rss = 'http://feeds.feedburner.com/robweir/antic-atom?format=xml';
$rss = 'http://feeds.feedburner.com/TechCrunch22/';

try
{
    $feedVo = (new FeedReader())->rss($rss);
}
catch (Exception $e)
{
    die("Exception: " . $e->getMessage());
}

$data = $feedVo->toArray();
unset($data['items']);
//die(var_dump($data));
die(var_dump($feedVo->getItems()[0]->getGuid()));

// ----------------------------------------------

//$atom = 'http://vvv.tobiassjosten.net/feed.atom';
//$atom = 'http://ceciliaschola.org/feed/atom/';
//$feedVo = (new FeedReader())->atom($atom);
//
//$data = $feedVo->toArray();
//unset($data['entries']);
//die(var_dump($data));
//die(var_dump($feedVo->getEntries()[0]->toArray()));
