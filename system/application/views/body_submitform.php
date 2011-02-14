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
<div id="body">
	<div class="bodytop"></div>
	<div id="formbody">
		<div class="top"><h2>Share Your Moment</h2></div>
		
		<h3>Do you know?  Tell us how.</h3>
		
		<?= form_open('submit') ?>
		<?= form_error('sex'); ?>
		<h4 id="genderleft">I knew</h4>
		<?= form_radio('sex', '0'); ?><label>She</label>
		<?= form_radio('sex', '1'); ?><label>He</label>
		<h4 id="genderright">was the one when:</h4>
		<?= form_error('body'); ?>
		<textarea id="formtextarea" name="body"><?= set_value('body'); ?></textarea>
		<h4>Where you from? (optional)</h4>
		<?= form_error('geolocation') ?>
		<input type="text" id="geolocation" name = "geolocation" value="<?= set_value('geolocation') ?>" />
		<h4>Are you human? Type the words below.</h4>
		<?= form_error('recaptcha_response_field') ?>
		<div id="recaptcha"><?= $recaptcha ?></div>
		<?= form_submit(array('name' => "Submit", 'id' => 'submit', 'type' => 'submit'), "Submit") ?>
		<?= form_close() ?>
	</div>
	<div id="static">
		<div class="top"><h2>Share via SMS</h2></div>
		<h3>Want to send in your moment on the go? Text one to a number below.</h3>
		<p>Know <em>she</em> is the one?  Text <strong>(347) 441-0919</strong>.</p>
		<p>Know <em>he</em> is the one?  Text <strong>(914) 712-8170</strong>.</p>
	</div>
</div>