
</body>
<footer class="footer footer-style">
  <div class="container">
    <div id = "admin_login" class="pull-right">	
		<a href = "admin_login.php">Admin Login &nbsp</a>
		</div>
  </div>
</footer>
</html>



<!-- Parallax Background -->
<script src="JS/parallax.js"></script>
<script>
var scene = document.getElementById('scene');
var parallax = new Parallax(scene);
</script>

<!-- Hide Admin Login and Parallax Background in article_content & foods_content -->
<?php
	if($_SERVER['PHP_SELF'] == "/snc/article_content.php" || $_SERVER['PHP_SELF'] == "/snc/foods_content.php"){
		?>
		<script>
		document.getElementById('footer-links').style.display = "none";
		document.getElementById('parallax').style.display = "none";
		</script>
		<?php
	}
?>