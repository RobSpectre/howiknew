	<div id="navigation">
		<h2>Navigation</h2>
		<div id="submit">
			<a href="<?= base_url()."submit" ?>" class="share"><p class="sharetext">do you know?</p><p class="sharesubtitle">submit here</p></a>
		</div>
		<div id="followus">
			<a href="http://www.twitter.com/howiknew" alt="Follow how i knew you were the one on Twitter."><span class="anchortext">Follow how i knew you were the one on Twitter.</span></a>
		</div>
		<div id="redditbutton">
			<script type="text/javascript" src="http://reddit.com/static/button/button1.js"></script>
		</div>
		<div id="stumbleuponbutton">
			<script src="http://www.stumbleupon.com/hostedbadge.php?s=1"></script>
		</div>
		<div id="facebooklike">
			<iframe src="http://www.facebook.com/plugins/like.php?href=<?=urlencode(base_url());?>&amp;layout=standard&amp;show_faces=true&amp;width=165&amp;action=like&amp;font=verdana&amp;colorscheme=light&amp;height=120" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:165px; height:120px;"></iframe>
		</div>
	</div>
	<? if (isset($query)):?>
	<? if ($query->num_rows() > 1): ?>
		<div id="activityfeed">
			<iframe src="http://www.facebook.com/plugins/activity.php?site=howiknewyouweretheone.com&amp;width=179&amp;height=500&amp;header=false&amp;colorscheme=light&amp;font=tahoma&amp;border_color=%23ffffff&amp;recommendations=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:175px; height:500px;" allowTransparency="true"></iframe>
		</div>
	<? endif; ?>
	<? endif; ?>