<script language="javascript">
$(document).ready(function() {
    $('a.heart').click(function(e) {
		e.preventDefault();
		var parent = $(this).parent().parent().parent();
		var box = $(this).parent().parent();
		var id = parent.attr('id').replace('vignette-','');
		var count = $('#heartcount-' + id).text();
		var pageTracker = _gat._getTracker('UA-1608534-4');
		if ($('#heart-' + id).hasClass('disabled')) return;
		$.ajax({
			type: 'post',
			url: '<?= site_url('heart')?>',
			data: 'id=' + id,
			beforeSend: function() {
				box.animate({'backgroundColor': '#BF3030'},300);
			},
			success: function() {
				$('#heart-' + id).addClass('disabled');
				$('#heart-' + id).fadeTo("fast", .5).removeAttr("href"); 
				count++;
				$('#heartcount-' + id).fadeOut('fast', function () {
					$('#heartcount-' + id).fadeIn('fast').html(count);
				});
				$('#heartcountbutton-' + id).fadeOut('fast', function () {
					$('#heartcountbutton-' + id).fadeIn('fast').html(count);
				});
				pageTracker._trackEvent("Button", "Heart", id);
			}
		});
    });

    $('a.tag').click(function(e) {
		e.preventDefault();
		var $this = $(this);
		var parent = $(this).parent().parent().parent().parent().parent();
		var id = parent.attr('id').replace('vignette-','');
		var counts = parent.children(".counts");
		var pageTracker = _gat._getTracker('UA-1608534-4');
		$.ajax({
			type: 'post',
			url: '<?= site_url('tag')?>',
			data: 'id=' + id + '&tag=' + $(this).attr('href').replace('<?= site_url('tag') ?>' + '/', ''),
			success: function() {
				$this.parent().animate({opacity: "hide"}, "slow");
				pageTracker._trackEvent("Button", "Tag", id);
				$.getJSON('<?= site_url('api')?>/' + id, function(data) {
					$('#taglist-' + id).fadeOut('slow', function () {
						$('#taglist-' + id).fadeIn('slow').html(' - tagged as ' + data.tags.taglist);
					});
				});
			}
		});
    });

    $('a.tagger').click(function(e) {
        e.preventDefault();
        var $this = $(this);
        var parent = $(this).parent().parent().parent();
        var id = parent.attr('id').replace('vignette-','');
        var pageTracker = _gat._getTracker('UA-1608534-4');
        if ($("#tags-" + id).is(":hidden")) {          
        	$("#tags-" + id).slideDown("slow");
        	$this.text("hide tags");
        	pageTracker._trackEvent("Button", "Show Tags", id);
        } else {
        	$("#tags-" + id).slideUp("slow");
        	$this.text("tag this");
        	pageTracker._trackEvent("Button", "Hide Tags", id);
        }
    });
});
</script>
<div id="body">
	<div class="bodytop"></div>
	<? if ($query->num_rows() > 0): ?>
	
		<? foreach($query->result() as $item): ?>
			<div id="vignette-<?= $item->id ?>" class="vignette">
				<? $formatDate = strtotime($item->publishtimestamp);?>
				<div class="top">
					<h4><span class="timestamp"><?=anchor('id/'.$item->id, date('l, j F', $formatDate));?></span> <? if($item->geolocation) {print " <span class=\"geolocation\">$item->geolocation</span>";  }?> </h4>
				</div>
				<div class="vignette-<?=$temp[$item->id]; ?>">
					<div class="hearts">
						<a href="#" id="heart-<?=$item->id?>" class="heart"><p id="heartcountbutton-<?=$item->id; ?>" class="heartcountbutton"><?=$hearts[$item->id]; ?></p></a>
						<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?= base_url()."id/".$item->id?>" data-text="#howiknew: <?= str_replace('"', '', $item->tweet); ?>" data-count="horizontal" data-via="howiknew">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
						<div class="facebook-like-button">
							<a name="fb_share" type="button" share_url="<?= base_url()."id/".$item->id?>">Share</a>
						</div>
					</div>
					<p class="gender">i knew <strong><? if($item->sex == 1) {print "he";} else {print "she";} ?></strong> was the one when:</p>
					<h3><?=$item->body; ?></h3>
				</div>
				<div class="bottom">
					<div class="counts">
						<p><span class="time"><?=anchor('id/'.$item->id, 'submitted '.date('g:ia', $formatDate));?></span> - <span id="heartcount-<?=$item->id; ?>"><?=$hearts[$item->id]; ?></span> hearts <span id="taglist-<?= $item->id ?>"> <? if ($tags[$item->id]['taglist']) { echo " - tagged as ".$tags[$item->id]['taglist']."</span>"; } ?></p>
					</div>
					<div class="tagthis">
						<?= anchor("#", "tag this", array('class' => 'tagger'))?>
					</div>
					<div class="clear"></div>
					<div id="tags-<?= $item->id ?>" class="tags">
						<p>tag this moment as...</p>
						<ul class="taglist">
						<? foreach($tagindex as $key => $tag):?>
							<li class="tagitem"><?= anchor("tag/$key", $tag, array('class' => 'tag'))?></li>
						<? endforeach;?>
						</ul>
					</div>
				</div>
			</div>
		<? endforeach; ?>
		
		<? if ( isset($paginationlinks) ):?>
			<div id="pagination"><?= $paginationlinks; ?></div>
		<? endif;?>
	<? endif;?>
</div>
