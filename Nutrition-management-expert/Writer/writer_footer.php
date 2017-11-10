
</body>
<footer class="footer footer-style">
  <div class="container">
    <p class="text-muted"><?php echo "&copy; &nbsp;" . date("Y"); ?> Quiazon/Gracilla</p> 
  </div>
</footer>
</html>

<script>
function loadlink(){
	$('#reloadThis').load('refreshNotif.php');
}
function loadlink2(){
	$('#reloadThis2').load('writer_header_content.php');
}

var myInterval = setInterval(function(){
  loadlink(); // this will run after every x seconds
}, 1000);

function stopinterval(){
	clearInterval(myInterval);
}

loadlink();
loadlink2(); // This will run on page load

    
</script>