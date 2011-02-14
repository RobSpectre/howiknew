<? header ("Content-Type: text/xml");  ?>
<items>
<? if ($query->num_rows() > 0): ?>
	<? foreach($items as $item): ?>
	<item>
		<title><?= $item['title'] ?></title>
		<geolocation><?= $item['geolocation'] ?></geolocation>
		<hearts><?= $item['hearts'] ?></hearts>
		<timestamp><?= date('D, d M Y H:i:s O', strtotime($item['publishtimestamp'])); ?></timestamp>
		<id><?= $item['id'] ?></id>
		<sex><?= $item['sex'] ?></sex>
		<? if ($item['tags'] != false): ?>
		<tags>
		<? foreach($item['tags'] as $key => $tag): ?>
			<? if ($key == "taglist" ): ?>
			<? continue; ?>
			<? endif; ?>
			<tag count="<?= $tag->count; ?>"><?= $tag->tag; ?></tag>
		<? endforeach; ?>
		</tags>
		<taglist><?= $item['tags']['taglist'] ?></taglist>
		<? else: ?>
		<tags>false</tags>
		<? endif; ?>
		<tweet><?= $item['tweet'] ?></tweet>
	</item>
	<? endforeach; ?>
<? endif;?>
</items>