<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Pusher Test</title>
	<!--
	This example view uses the Pusher Javascript SDK to subscribe
	on new events. https://github.com/pusher/pusher-js
	-->
	<script src="https://js.pusher.com/3.2/pusher.min.js"></script>	 
</head>
<body>

	<script>
	    // Enable pusher logging - don't include this in production
	    Pusher.logToConsole = true;
	    var pusher = new Pusher('fd64588aa59825c4045b');
	    var channel = pusher.subscribe('test_channel');
	    channel.bind('my_event', function(data) {
	    	alert(data.message);
	    });
  	</script>

	<p id="event">Waiting on event...</p>
	<p>Go to <strong><a href="/example/trigger_event" target="_blank">/example/trigger_event</a></strong> in a new tab to trigger event.</p>

</body>
</html>
