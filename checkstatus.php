
<iframe id="theiframe" width="100%" height="100%">
</iframe>

<script>
	var ifr = document.getElementById('theiframe');
	ifr.src = window.location.protocol + "//" + window.location.hostname + '/status.php?t=' + new Date().getTime();
</script>


