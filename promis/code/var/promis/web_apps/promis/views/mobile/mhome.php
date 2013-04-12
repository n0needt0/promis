<script>
var head= document.getElementsByTagName('head')[0];
var script= document.createElement('script');
script.setAttribute('type', 'text/javascript');
script.setAttribute('src', '/assets/vendor/require/require.js');
script.setAttribute('data-main', "/assets/mobile/js/mhome.config");
head.appendChild(script);
</script>

<form action="/mnew" method="get">
<p>
Welcome to Mobile Outcomes.
</p>

<input type="text" name="pin" id="pin" value="Enter your PIN"/>

</form>