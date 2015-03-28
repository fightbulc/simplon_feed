<?php

use Simplon\Feed\FeedReader;

require __DIR__ . '/../vendor/autoload.php';

$rss = 'http://detailseu.s3.amazonaws.com/rss/events_confirmed_berlin3_Superaki.rss';
$rss = 'http://feeds.feedburner.com/techcrunch/europe?format=xml';
$rss = 'http://www.spiegel.de/schlagzeilen/tops/index.rss';
$feed = (new FeedReader())->rss($rss);

//$atom = 'http://vvv.tobiassjosten.net/feed.atom';
//$feed = (new FeedReader())->atom($atom);

foreach($feed->getItems() as $item)
{
    print_r($item->getTitle());
    echo "\n";
}