<?php

$feed = preg_replace('/\.rss$/', '', $url) . '.rss';
$rss = new simplexmlelement($feed,0,true);


if (!empty($rss)) {

  $tpl['title'] = $rss->channel->title;
  $tpl['link'] = $rss->channel->link;
  $tpl['description'] = $rss->channel->description;
  $tpl['image'] = array();
  $tpl['image']['url'] = $rss->channel->image->url;
  $tpl['image']['title'] = $rss->channel->image->title;
  $tpl['image']['link'] = $rss->channel->image->link;

  $tpl['items'] = array();

  foreach($rss->channel->item as $i) {
    if (preg_match('/([0-9]+) ?x ?([0-9]+)/', $i->title, $m)) {
      if (preg_match('@submitted by <a href="http://www.reddit.com/user/([A-Za-z0-9_]+)"> ?\1 ?</a>( to <a href="http://www.reddit.com/r/[^"]+">[^<]+</a>)?( <br/> )?<a href="([^"]+)">[^<]+</a>@',$i->description, $m1)) {
	$item = array();

	$item->author = $m1[1];
	$item['title'] = $i->title;
	$item['link'] = $i->link;
	$item['pubDate'] = strtotime($i->pubDate);
	$item['description'] = $i->description;
	$item['adult'] = (strpos($i->title, "NSFW") !== false);
      
	$item['content'] = array('url'=>$m1[4],'width'=>$m[1],'height'=>$m[2]);

	$tpl['items'][] = $item;
      }
    }
  }
}