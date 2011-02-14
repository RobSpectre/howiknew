	<div id="footer">
		<div id="momentlinks">
			<h2>moments</h2>
			<ul>
				<li><?=anchor('', 'home'); ?></li>
				<li><?=anchor('mostloved', 'most loved'); ?></li>
				<li><?=anchor('random', 'random'); ?></li>
				<li><?=anchor('submit', 'share'); ?></li>

			</ul>
		</div>
		<div id="info">
			<h2>info</h2>
			<ul>
				<li><?=anchor('about', 'about'); ?></li>
				<li><?=anchor('questions', 'questions'); ?></li>
				<li><?=anchor('privacy', 'privacy'); ?></li>
				<li><?=anchor('contact', 'contact'); ?></li>
			</ul>
		</div>
		<div id="twittersearch">
			<script src="http://widgets.twimg.com/j/2/widget.js"></script>
			<script>
			new TWTR.Widget({
			  version: 2,
			  type: 'search',
			  search: 'howiknew',
			  interval: 6000,
			  title: '#howiknew',
			  subject: 'twitter',
			  width: 400,
			  height: 200,
			  theme: {
			    shell: {
			      background: '#c38f64',
			      color: '#ffffff'
			    },
			    tweets: {
			      background: '#ffffff',
			      color: '#000000',
			      links: '#000000'
			    }
			  },
			  features: {
			    scrollbar: false,
			    loop: false,
			    live: true,
			    hashtags: true,
			    timestamp: true,
			    avatars: true,
			    toptweets: false,
			    behavior: 'all'
			  }
			}).render().start();
			</script>
		</div>
	</div>
	<div id="credit">
		<p>This work is licensed under <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative Commons 3.0</a>. Created by Rob Spectre.  Lovingly crafted in Brooklyn, New York.</p>
	</div>
</div>
<!-- i carry your heart(i carry it in my heart)  -->
</body>
</html>
