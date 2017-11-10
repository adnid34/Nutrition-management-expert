<?php
    require_once '../PHP/dbconfig.php';
    include 'manager_header.php'; 
?>

<div class="container container-style">
	<div id="article-wrapper">
		<?php
			$id = $_GET['id'];
			$stmt = $DB_con->prepare("SELECT * FROM article_archived WHERE article_archived_id = '$id'");
			$stmt->execute();
				while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
					extract($row);
					?>
						<div id="article-content">
							<div class="article-img col-sm-12">
							<img src="../Images/<?php echo $row['image']; ?>" class="img-rounded" />
							</div>

							<div id = "article-title">
							<h1 class = "title-page"><?php echo $title; ?></h1>
							<p class = "text-muted"><?php echo $article_author; ?></p>
							<p class = "text-muted">Published <?php echo date("F d, Y", strtotime($article_date)); ?></p>
							</div>

							<div id = "article-info">
							<p><?php echo $content; ?></p>
							</div>
						</div>
					<?php
				}
		?>
	</div>
</div>


<!-- FOOTER -->
<?php include 'manager_footer.php'; ?>