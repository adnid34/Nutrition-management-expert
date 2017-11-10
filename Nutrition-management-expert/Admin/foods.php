<?php
	require_once '../PHP/dbconfig.php';	
	if(isset($_GET['delete_id'])){
		
		
		$DB_con->beginTransaction();
		$stmt_delete = $DB_con->prepare('DELETE FROM foods WHERE food_id =:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();

		$stmt_delete = $DB_con->prepare('DELETE FROM foods_other_nutrients WHERE food_id =:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();
		
		$DB_con->commit();
		header("Location: foods.php");
	}

?>
<!-- HEADER -->
<?php include 'admin_header.php'; ?>



<div class="container">

	<div class="page-header">
    	<h2 class="h2">Foods </h2> 
    </div>
	<br />
	<div class="has-feedback admin-search">
		<a class="btn btn-success admin-add-btn" href="foods_addnew.php"><span class="glyphicon glyphicon-plus"></span> &nbsp; Add New Food </a>
	</div>
<div id="content" class="admin-content cleafix" >
	<!-- /.row -->
<div class="row">

    <div class="col-lg-12">
        <div class="panel panel-default">

            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTable2">
                    <thead>
                        <tr>    
                            <th>Name</th>
                            <th>Category</th>
                            <th>Serving Size</th>
                            <th>Calories</th>
                            <th>Fat</th>
                            <th>Carbohydrate</th>
                            <th>Protein</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        
                    <?php
                    
                    $row = $DB_con->query("SELECT COUNT(*) FROM foods")->fetchColumn();
                    $query = $DB_con->prepare("SELECT * FROM foods ORDER BY name DESC");
                    $query->execute();
                    while($row=$query->fetch(PDO::FETCH_ASSOC)){

                            extract($row);
                    ?>

                        <tr class="">
                            <td><?php echo $name; ?></td>
                            <td><?php echo $category; ?></td>
                            <td><?php echo $serving_size; ?></td>
                            <td><?php echo $calories; ?></td>
                            <td><?php echo $fat. "g";?></td>
                            <td><?php echo $carbohydrate. "g";?></td>
                            <td><?php echo $protein. "g";?></td>
                            <td>
                            <a class="btn btn-info" href="foods_editform.php?edit_id=<?php echo $row['food_id']; ?>" title="click for edit"><span class="glyphicon glyphicon-edit"></span> Edit</a> 
                            <a class="btn btn-danger" href="?delete_id=<?php echo $row['food_id']; ?>" title="click for delete" onclick="return confirm('Are you sure you want to delete this?')"><span class="glyphicon glyphicon-remove-circle"></span> Delete</a>
                            </td>
                            
                        </tr>   

                    <?php
                        }

                    ?>
                    </tbody>
                </table>

            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>

</div>	
</div>



<!-- FOOTER -->
<?php include 'admin_footer.php'; ?>