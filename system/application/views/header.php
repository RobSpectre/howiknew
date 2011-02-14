<!DOCTYPE html>
<html lang="en">
<head>
	<title><?= $title ?></title>
	<meta charset="utf-8" />
	<meta name="description" content="A collection of magical moments from the luckiest people on Earth." />
	<meta name="keywords" content="how i knew you were the one, how i knew she was the one, how i knew he was the one, how i knew, true love, magical moment, romance, love, marriage, relationships, forever, rob spectre"/>
	<? if (isset($query)):?>
	<? if ($query->num_rows() === 1): ?>
	<meta property="og:title" content="<?= $title ?>" />
	<meta property="og:description" content="A moment shared on howiknewyouweretheone.com." />
	<meta property="og:image" content="<?= base_url()."images/facebookshare-logo.png"?>" />
	<? else:?>
	<meta property="og:title" content="how i knew you were the one." />
	<meta property="og:description" content="A collection of magical moments from the luckiest people on Earth." />
	<meta property="og:image" content="<?= base_url()."images/facebookshare-logo.png"?>" />
	<? endif; ?>
	<? endif; ?>
	<link rel="author" title="Rob Spectre" href="http://www.howiknewyouweretheone.com/about" />
	<link rel="shortcut icon" href="favicon.ico" />
	<link rel='index' title='how i knew you were the one' href='http://www.howiknewyouweretheone.com' />
	<link rel="alternate" type="application/rss+xml" title="how i knew you were the one RSS Feed" href="http://feeds.feedburner.com/howiknew" />
	<link rel="stylesheet" href="<?= base_url()."styles/howiknew-1.7.css"?>" />
	<link rel="image_src" href="<?= base_url()."images/short-logo.png"?>" />
	<link rel="shortcut icon" href="<?= base_url()."favicon.ico"?>" />
	<link rel="prefetch" href="<?= base_url() ?>" />
	<link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script src="<?= base_url()."js/color.js"?>"></script>
	<script src="<?= base_url()."js/jquery.corner.js"?>"></script>
	<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
	<script type="text/javascript">

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-1608534-4']);
_gaq.push(['_trackPageview']);

(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

$('#navigation').corner("8px");
$('#body').corner("top 8px");
$('#footer').corner("bottom 8px");
$('.top').corner("top 8px");
$('.bottom').corner("bottom 8px");
$('#static').corner("8px");
$('#formbody').corner("8px");

</script>
</head>
<body>
<div id="container">
	<div id="header">
		<h1>how i knew you were the one</h1>
		<div id="home">
			<a href="<?= base_url() ?>" alt="how i knew you were the one."><div class="headertext">how i knew you were the one</div></a>
		</div>
	</div>
