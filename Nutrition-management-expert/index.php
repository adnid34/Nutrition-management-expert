<?php
require_once 'PHP/dbconfig.php';
include 'header.php'; // HEADER
?>


<div class="container">
<div id="article-wrapper">

	<div id="intro" class ="welcome-class">
		<h1 id="title">
			<span id="title-line3" class="title-line ">WELCOME!</span>
		</h1>
	</div>

	<div class = "nbsp-class clearfix" style = "">&nbsp; </div>

	<!-- SLIDER -->
	<div id="da-slider" class="da-slider">
		<?php
		$stmt = $DB_con->prepare("SELECT * FROM slider ORDER BY slider_id");
		$stmt->execute();
		
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				?>
				<div class="da-slide">
					<h2><?php echo $title; ?></h2>
					<p><?php echo $content; ?></p>					
					<div class="da-img"><img src="Images/<?php echo $row['image']; ?>" class = "img-rounded" width="250px" height="250px" alt="image01" /></div>
				</div>
			    <?php
			}
		?>	


		<nav class="da-arrows">
			<span class="da-arrows-prev"></span>
			<span class="da-arrows-next"></span>
		</nav>
	</div>

	<div id="showcase" >
		<h1>ARTICLES</h1> <br />
		<div class="gallery col-sm-12 clearfix">
			<?php
				$stmt = $DB_con->prepare("SELECT * FROM article ORDER BY timestamp DESC LIMIT 6");
				$stmt->execute();
					while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
						
						extract($row);
						?>
							<figure class = "col-sm-4" >
								<a class = "article-category-btn btn-radius-index" href="article_content.php?id=<?php echo $article_id; ?>">
									<img src="Images/<?php echo $row['image']; ?>" class="img-circle" width="250px" height="250px" />
								</a>
								<figcaption><?php echo $title; ?><br />
									
								</figcaption>
							</figure>
						<?php
					}
			?>			
		</div>
	</div>
	<div id = "home" style = "padding-bottom: 300px;">
			<h1>&nbsp</h1>

			<?php
				$stmt = $DB_con->prepare("SELECT * FROM home ORDER BY home_id");
				$stmt->execute();
				$count = 0;
					while($row=$stmt->fetch(PDO::FETCH_ASSOC)){						
						extract($row);
						$home_content = $content ;
						?>							
							<h1 id="smush-it-<?php echo $count; ?>"><?php echo $title; ?></h1>
							<div id ="fade-it-<?php echo $count; ?>" class ="home-content"><?php echo $home_content; ?></div>
						<?php
						$count++;
					}
			?>

			
	</div>
	<!-- 
	<div class="ellipsis" style = "height: 160px;">
	  <p href="">khkjhoyhi yguuygonug uygoguy khkjhoyhi y
	  	guuygonug uygoguy khkjhoyhi yguuygonug uygoguy</p>
	</div>
	 -->

</div>	
</div>
<?php include 'PHP/scrollorama.php'; // SCROLLORAMA SCRIPTS ?>
<?php include 'footer.php'; // FOOTER ?>

<?php
/*
	function time_elapsed_string($datetime, $full = false) {
	    
	    $now = new DateTime;
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'minute',
	        's' => 'second',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . ' ago' : 'just now';
	}
*/
?>