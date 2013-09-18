<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title><?=@$tpl['title']?:"MediaRSS Maker"?></title>
    <link><?=@$tpl['link']?:$url?></link>
    <description><?=@$tpl['description']?:"An image feed"?></description>
    <language><?=@$tpl['lang']?:"en-us"?></language>
    <copyright></copyright>
    <pubDate><?=date('r',@$tpl['pubDate']?:time())?></pubDate>
    <generator>mediarss-maker <?=$version?></generator>
    <docs>http://blogs.law.harvard.edu/tech/rss</docs>
    <?php if(!empty($tpl['icon'])): ?><atom:icon><?=$tpl['icon']?></atom:icon><?php endif;?>
    <atom:link href="http://<?=$_SERVER['HTTP_HOST']?><?=$_SERVER['REQUEST_URI']?>" 
	       rel="self" type="application/rss+xml"/>
    <?php if(!empty($tpl['next'])): ?><atom:link rel="next" href="<?=$tpl['next']?>"/><?php endif;?>
    <?php foreach($tpl['items'] as $item): ?>
    <item>
      <title><?=@$item['title']?></title>
      <link><?=$item['link']?></link>
      <guid isPermaLink="<?=empty($item['guid'])?'true':'false'?>"><?=empty($item['guid'])?$item['link']:$item['guid']?></guid>
      <pubDate><?date('r',@$item['pubDate']?:time())?></pubDate>
      <media:title type="plain"><?=@$item['title']?></media:title>
      <media:keywords><?=@implode(',',$item['keywords'])?></media:keywords>
      <media:rating><?=$item['adult']?"":"non"?>adult</media:rating>
      <?php if (!empty($item['credits'])) : foreach ($item['credits'] as $credit) : ?>
        <media:credit role="<?=$credit['role']?>" scheme="<?=$credit['scheme']?:'urn:ebu'?>"><?=$credit['value']?></media:credit>
      <?php endforeach; endif; ?>
      <?php if (!empty($item['copyright'])):?>
        <media:copyright<?php if (!empty($item['copy_url'])):?> url="<?=$item['copy_url']?>"<?php endif;?>>
	  <?=$item['copyright']?>
	</media:copyright>
      <?php endif;?>
      <media:description type="html"><![CDATA[<?=@$item['description']?>]]></media:description>
      <?php if (!empty($item['thumb'])):?>
      <media:thumbnail url="<?=$item['thumb']['url']?>" height="<?=@$item['thumb']['height']?>" width="<?=@$item['thumb']['width']?>"/>
      <?php endif; ?>
      <media:content url="<?=$item['content']['url']?>" height="<?=@$item['content']['height']?>" width="<?=@$item['content']['width']?>"/>
      <description><![CDATA[<?=@$item['description']?>]]></description>
    </item>
    <?php endforeach; ?>
  </channel>
</rss>
