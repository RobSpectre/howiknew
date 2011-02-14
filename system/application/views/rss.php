<? header ("Content-Type: text/xml");  ?>
<?= "<?xml version=\"1.0\"?>\n" ?>
<rss version="2.0">
<channel>
<title>how i knew you were the one</title>
<description>A collection of magical moments from the luckiest people on Earth.</description>
<link>http://www.howiknewyouweretheone.com/</link>
<? if ($query->num_rows() > 0): ?>
	<? foreach($query->result() as $item): ?>
	<item>
		<title><? if($item->geolocation) { echo $item->geolocation;  } else { echo "Undisclosed Location"; }?></title>
		<link><?=site_url("/id/$item->id")?></link>
		<guid><?=site_url("/id/$item->id")?></guid>
		<? $formatDate = strtotime($item->timestamp);?>
		<pubId><?=date('D, d M Y H:i:s O', $formatDate)?></pubId>
		<description><?=$item->body?></description>
	</item>
	<? endforeach; ?>
<? endif;?>
</channel>
</rss>
