
<?php

	require_once '../PHP/dbconfig.php';
	
	if(isset($_GET['delete_id']))
	{
		// select image from db to delete
		$stmt_select = $DB_con->prepare('SELECT image FROM article WHERE article_id =:uid');
		$stmt_select->execute(array(':uid'=>$_GET['delete_id']));
		$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
		unlink("user_images/".$imgRow['image']);
		
		// it will delete an actual record from db
		$stmt_delete = $DB_con->prepare('DELETE FROM article WHERE article_id =:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();
		
		header("Location: index.php");
	}

?>

<div class="admin-content admin-result">
<?php
$q = $_GET['q'];
$test = $_GET['test'];

$query = $DB_con->prepare('SELECT * FROM article 
		WHERE title LIKE "%'.$q.'%" OR category LIKE "%'.$q.'%" 
		ORDER BY article_id DESC'); 
$query->execute(); 

	if($query->rowCount() > 0){
		while($row=$query->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			?>
			<div class="col-xs-4" style = "margin-bottom: 25px;">
				<h4 class=""><?php echo " " . $title."<br /><br />For ".$category; ?></h4>
				<img src="../Images/<?php echo $row['image']; ?>" class="img-rounded" width="250px" height="250px" />
				<p class="">
				<span>
				<a class="btn btn-info" href="editform.php?edit_id=<?php echo $row['article_id']; ?>" title="click for edit"><span class="glyphicon glyphicon-edit"></span> Edit</a> 
				<a class="btn btn-danger" href="?delete_id=<?php echo $row['article_id']; ?>" title="click for delete" onclick="return confirm('Are you sure you want to delete this?')"><span class="glyphicon glyphicon-remove-circle"></span> Delete</a>
				<?php echo $test; ?>
				</span>
				</p>
			</div>       
			<?php
		}
	}
	else{
		?>
		<p class="page-header"></p>
        <div class="col-xs-12">
        	<div class="alert alert-warning">
            	<span class="glyphicon glyphicon-info-sign"></span> &nbsp; No Data Found ...
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