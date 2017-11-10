
<?php
	require_once 'PHP/dbconfig.php';
?>

<div class="">
<?php
$q = $_GET['q'];

switch($_GET['category']){
	case "/snc/article_kids.php":
	$search_category = "Kids";
	break;
	case "/snc/article_men.php":
	$search_category = "Men";
	break;
	case "/snc/article_women.php":
	$search_category = "Women";
	break;
	case "/snc/article_seniors.php":
	$search_category = "Seniors";
	break;
}

$query = $DB_con->prepare('SELECT * FROM article 
		WHERE title LIKE "%'.$q.'%" AND category = "'.$search_category.'" 
		ORDER BY article_date DESC'); 
$query->execute(); 

	if($query->rowCount() > 0){
		while($row=$query->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			?>
			<div class="animated-btn">
					<a href="article_content.php?id=<?php echo $article_id; ?>" class="article-category-btn	btn-radius">
						<div class = "left">
							<img src="Images/<?php echo $row['image']; ?>" class="img-rounded left-img" />
						</div>

						<div class = "right" >
							<h2><?php echo  $title; ?></h2>
							<p>By <?php echo $article_author; ?></p>
						</div>

					</a>

			</div>       
			<?php
		}
	}
	else{
		?>
        <div class="col-xs-12">
        	<div class="alert alert-warning">
            	<span class="glyphicon glyphicon-info-sign"></span> &nbsp; No matching records found.
            </div>
        </div>
        <?php
	}
	
?>
</div>	

</div>

<!-- FOOTER -->
</body>
</html>