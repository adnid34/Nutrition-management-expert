<?php
	require_once '../PHP/dbconfig.php';	
	if(isset($_GET['delete_id'])){
		
		
		$DB_con->beginTransaction();
		$stmt_delete = $DB_con->prepare('DELETE FROM foods WHERE food_id =:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();

		$stmt_delete = $DB_con->prepare('DELETE FROM foods_beverages WHERE food_id =:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();

		$stmt_delete = $DB_con->prepare('DELETE FROM foods_dairy WHERE food_id =:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();

		$stmt_delete = $DB_con->prepare('DELETE FROM foods_fruits WHERE food_id =:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();

		$stmt_delete = $DB_con->prepare('DELETE FROM foods_grains WHERE food_id =:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();

		$stmt_delete = $DB_con->prepare('DELETE FROM foods_meat WHERE food_id =:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();

		$stmt_delete = $DB_con->prepare('DELETE FROM foods_sugary WHERE food_id =:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();

		$stmt_delete = $DB_con->prepare('DELETE FROM foods_vegetables WHERE food_id =:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();
		
		$DB_con->commit();
		header("Location: foods.php");
	}

?>

<div class="admin-content admin-result">
<?php
$q = $_GET['q'];

$query = $DB_con->prepare('SELECT * FROM article 
		WHERE title LIKE "%'.$q.'%" OR category LIKE "%'.$q.'%" 
		ORDER BY article_id DESC'); 
$query->execute(); 

	if($query->rowCount() > 0){
		while($row=$query->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			?>
			<div class="col-xs-4">
				<h4 class="page-header"><?php echo " " . $title."<br /><br />For ".$category; ?></h4>
				<img src="../Images/<?php echo $row['image']; ?>" class="img-rounded" width="250px" height="250px" />
				<p class="page-header">
				<span>
				<a class="btn btn-info" href="editform.php?edit_id=<?php echo $row['article_id']; ?>" title="click for edit"><span class="glyphicon glyphicon-edit"></span> Edit</a> 
				<a class="btn btn-danger" href="?delete_id=<?php echo $row['article_id']; ?>" title="click for delete" onclick="return confirm('Are you sure you want to delete this?')"><span class="glyphicon glyphicon-remove-circle"></span> Delete</a>
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