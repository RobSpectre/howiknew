<script src="<?= base_url()."js/jquery.jqEasyCharCounter.min.js"?>" type="text/javascript"></script>
<script language="javascript">
$(document).ready(function(){
	$('#formtextarea').jqEasyCounter({
	    'maxChars': 500,
	    'maxCharsWarning': 450,
	    'msgFontSize': '12px',
	    'msgFontColor': '#000',
	    'msgFontFamily': 'Tahoma',
	    'msgTextAlign': 'right',
	    'msgWarningColor': '#ff0000',
	    'msgAppendMethod': 'insertBefore'              
	});
});
</script>
<script language="javascript">
$(document).ready(function() {
    $('a.approve').click(function(e) {
		e.preventDefault();
		var parent = $(this).parent().parent();
		var id = parent.attr('id').replace('submission-','');
		$.ajax({
			type: 'post',
			url: '<?= site_url('mod/approveVignette')?>',
			data: 'id=' + id + '&body=' + $('#body-' + id).val() + '&tweet=' + $('#tweet-' + id).val(),
			beforeSend: function() {
				parent.animate({'backgroundColor': '#FBB0C4'},300);
			},
			success: function() {
				parent.slideUp(300,function() {
					parent.remove();
				});
			}
		});
    });

    $('a.reject').click(function(e) {
		e.preventDefault();
		var parent = $(this).parent().parent();
		var id = parent.attr('id').replace('submission-','');
		var body = $('#body-' + id).val();
		var tweet = $('#tweet-' + id).val();
		$.ajax({
			type: 'post',
			url: '<?= site_url('mod/rejectVignette')?>',
			data: 'id=' + id + '&body=' + $('#body-' + id).val() + '&tweet=' + $('#tweet-' + id).val(),
			beforeSend: function() {
				parent.animate({'backgroundColor':'#694593'},300);
			},
			success: function() {
				parent.slideUp(300,function() {
					parent.remove();
				});
			}
		});
    });
    
    $('a.edit').click(function(e) {
		e.preventDefault();
		var parent = $(this).parent().parent();
		var id = parent.attr('id').replace('submission-','');
		var body = $('#body-' + id).val();
		var tweet = $('#tweet-' + id).val();
		$.ajax({
			type: 'post',
			url: '<?= site_url('mod/editVignette')?>',
			data: 'id=' + id + '&body=' + $('#body-' + id).val() + '&tweet=' + $('#tweet-' + id).val(),
			success: function() {
				parent.animate({'backgroundColor':'#694593'},300);
			}
		});
    });

	$('.tweet').jqEasyCounter({
	    'maxChars': 94,
	    'maxCharsWarning': 84,
	    'msgFontSize': '12px',
	    'msgFontColor': '#000',
	    'msgFontFamily': 'Tahoma',
	    'msgTextAlign': 'right',
	    'msgWarningColor': '#ff0000',
	    'msgAppendMethod': 'insertBefore'              
	});
});
</script>
<div id="body">
	<div class="bodytop"></div>
	<? if ($query->num_rows() > 0): ?>
	
		<? foreach($query->result() as $item): ?>
			
			<div id="submission-<?= $item->id ?>" class="vignette">
				<? $formatDate = strtotime($item->timestamp);?>
				<div class="top">
					<h4><span class="timestamp"><?= date('l, j F', $formatDate); ?></span> <? if($item->geolocation) {print " <span class=\"geolocation\">$item->geolocation</span>";  }?> </h4>
				</div>
				<ul>
					<li>Body: <?= $item->body ?></li>
					<li>Location: <?= $item->geolocation ?></li>
					<li>Submitted: <?= $item->timestamp ?></li>
					<li>Published: <?= $item->publishtimestamp?></li>
					<li>IP: <a href="http://api.infochimps.com/web/an/de/geo.json?apikey=rob_spectre-_7xiT-HqoU9vRKVOGWV6-8lf869&ip=<?= $item->ip ?>"><?= $item->ip ?></a></li>
				</ul>
				<h3>Body</h3>
				<textarea name="body" id="body-<?=$item->id?>" rows="5"><?= $item->body; ?></textarea>
				<h3>Tweet</h3>
				<textarea name="tweet" id="tweet-<?=$item->id?>" class="tweet" rows="5"><?= $item->tweet; ?></textarea>
				<div class="moderatebuttons">
					<?= anchor('', 'Approve', array('vid' => $item->id, 'class' => 'approve'))?>
					<?= anchor('', 'Edit', array('vid' => $item->id, 'class' => 'edit'))?>
					<?= anchor('', 'Reject', array('vid' => $item->id, 'class' => 'reject'))?>
				</div>
			</div>
		
		<? endforeach; ?>
		
		<? if ( isset($paginationlinks) ):?>
			<div id="pagination"><?= $paginationlinks; ?></div>
		<? endif;?>
		
	<? endif;?>
</div>
