<?php

require_once('utils/simple_html_dom.php');

$d = file_get_html($url);

if (!empty($d)) {

  $tpl = array();
  $tpl['title'] = $d->find('head title')[0]->innertext();
  $tpl['description'] = $d->find('head meta[name="description"]')[0]->content;
  $tpl['items'] = array();
  
  foreach($d->find('div.thumbnail') as $i) {
    $item = array();
    $item['wid'] = ltrim($i->id,'thumb');
    $item['guid'] = "urn:x-wallbase:" . $item['wid'];
    $tags = explode('|',$i->{"data-tags"});
    $item['tags'] = array();
    while (count($tags)) {
      $a_tag = array_shift($tags);
      $item['tags'][array_shift($tags)] = $a_tag;
      array_shift($tags); array_shift($tags);
    }

    $item['title'] = implode(', ', $item['tags']);
    if (empty($item['title'])) $item['title'] = "wallbase.cc wallpaper";
    $item['link'] = "http://wallbase.cc/wallpaper/" . $item['wid'];
    $item['reso'] = explode('x',$i->find('span.reso')[0]->innertext());
    $item['thumb'] = array('url' => $i->find('a img')[0]->{"data-original"},'width'=>250,'height'=>188);
    $item['content'] = array('url' => str_replace('thumb','wallpaper', $item['thumb']['url']),'width'=>$item['reso'][0],'height'=>$item['reso'][1]);
    
    $item['description'] = "<p>";
    foreach($item['tags'] as $key => $tag) {
      $item['description'] .= '<a href="http://wallabase.cc/search?tag=' . $key . '">' . $tag . '</a>, ';
    }
    $item['description'] = rtrim($item['description'], ', ') . "</p>";

    $item['purity'] = (int)(preg_replace('/.*purity-(\d+).*/', '\1', $i->class));
    $item['adult'] = ($item['purity'] > 0);

    $tpl['items'][] = $item;
  }

}