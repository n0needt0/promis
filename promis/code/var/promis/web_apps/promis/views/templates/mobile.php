<!doctype html>
<html>
<head>
	<title> Mobile Outcomes </title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">

	<!-- Home screen icon  Mathias Bynens mathiasbynens.be/notes/touch-icons -->
	<!-- For iPhone 4 with high-resolution Retina display: -->
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="apple-touch-icon.png">
	<!-- For first-generation iPad: -->
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="apple-touch-icon.png">
	<!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
	<link rel="apple-touch-icon-precomposed" href="apple-touch-icon-precomposed.png">
	<!-- For nokia devices and desktop browsers : -->
	<link rel="shortcut icon" href="favicon.ico" />

	<!-- Mobile IE allows us to activate ClearType technology for smoothing fonts for easy reading -->
	<meta http-equiv="cleartype" content="on">

	<!-- jQuery Mobile CSS bits -->
	<link rel="stylesheet" href="/assets/mobile/css/jquery.mobile-1.3.0.min.css" />

	<!-- if you have a custom theme, add it here -->
	<link rel="stylesheet"  href="/assets/mobile/themes/ay.css" />

	<!-- Custom css -->
	<link rel="stylesheet" href="/assets/mobile/css/custom.css" />

	<!-- Startup Images for iDevices -->
	<script>(function(){var a;if(navigator.platform==="iPad"){a=window.orientation!==90||window.orientation===-90?"images/startup-tablet-landscape.png":"images/startup-tablet-portrait.png"}else{a=window.devicePixelRatio===2?"images/startup-retina.png":"images/startup.png"}document.write('<link rel="apple-touch-startup-image" href="'+a+'"/>')})()</script>
	<!-- The script prevents links from opening in mobile safari. https://gist.github.com/1042026 -->
	<script>(function(a,b,c){if(c in b&&b[c]){var d,e=a.location,f=/^(a|html)$/i;a.addEventListener("click",function(a){d=a.target;while(!f.test(d.nodeName))d=d.parentNode;"href"in d&&(d.href.indexOf("http")||~d.href.indexOf(e.host))&&(a.preventDefault(),e.href=d.href)},!1)}})(document,window.navigator,"standalone")</script>
</head>
<body>
	<div data-role="page">

		<div data-role="header">
			<h1>Mobile Outcomes</h1>
		</div>

		<div data-role="content">

			<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
				<li data-role="list-divider">Snippet Pages</li>
				<li><a href="buttons.html">Buttons</a></li>
				<li><a href="grids.html">Grids</a></li>
				<li><a href="collapsibles.html">Collapsible Boxes</a></li>
				<li><a href="collapsible-sets.html">Collapsible Sets</a></li>
				<li><a href="forms.html">Form Elements</a></li>
				<li><a href="lists.html">List Views</a></li>
			</ul>

		</div>

		<div data-role="footer" data-theme="c">
			<p>&copy; <?php echo date("Y",time());?> - Mobile Outcomes</p>
		</div>

	</div>

	   <!-- Javascript includes -->
    <script src="/assets/mobile/js/jquery-1.8.2-min.js"></script>
    <script src="/assets/mobile/js/mobileinit.js"></script>
    <script src="/assets/mobile/js/ios-orientationchange-fix.min.js"></script>
    <script src="/assets/mobile/js/jquery.mobile-1.3.0.min.js"></script>
    <script src="/assets/mobile/cordova-2.5.0.js"></script>
    <script src="/assets/mobile/js/application.js"></script>

</body>
</html>