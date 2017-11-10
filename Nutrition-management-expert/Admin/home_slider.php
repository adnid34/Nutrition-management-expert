<?php
	require_once '../PHP/dbconfig.php';	
	if(isset($_GET['delete_id'])){		
		// image to delete
        $stmt_select = $DB_con->prepare('SELECT image FROM slider WHERE slider_id =:uid');
        $stmt_select->execute(array(':uid'=>$_GET['delete_id']));
        $imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
        unlink("../Images/".$imgRow['image']);
        
        // delete record
        $stmt_delete = $DB_con->prepare('DELETE FROM slider WHERE slider_id =:uid');
        $stmt_delete->bindParam(':uid',$_GET['delete_id']);
        $stmt_delete->execute();

		header("Location: home.php");
	}
?>
<!-- HEADER -->
<?php include 'admin_header.php'; ?>



<div class="container">

<div class="page-header">
	<h2 class="h2">Manage Slider </h2> 
</div>
<br />
	
<div id="content" class="admin-content cleafix" >

<!-- SLIDER -->
<div class="admin-search">
    <a class="btn btn-success admin-add-btn" href="home_slider_addnew.php"><span class="glyphicon glyphicon-plus"></span> &nbsp; Add Page </a>
</div>
<div class="row">

    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Slider Page
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="">
                    <thead>
                        <tr>    
                            <th>Title</th>
                            <th>Content</th>
                            <th>Image</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        
                    <?php
                    
                    $row = $DB_con->query("SELECT COUNT(*) FROM slider")->fetchColumn();
                    $total_row = $row;
                    $query = $DB_con->prepare("SELECT * FROM slider ORDER BY slider_id");
                    $query->execute();
                    while($row=$query->fetch(PDO::FETCH_ASSOC)){
                            extract($row);
                    ?>

                        <tr class="">
                            <td><?php echo $title; ?></td>
                            <td style = "width: 30%;"><?php echo $content; ?></td>
                            <td><img src="../Images/<?php echo $row['image']; ?>" class="img-rounded" width="150px" height="150px" /></td>
                            <td>
                            <a class="btn btn-info" href="home_slider_editform.php?edit_id=<?php echo $row['slider_id']; ?>" title="Click to edit"><span class="glyphicon glyphicon-edit"></span> Edit</a> 
                            <a class="btn btn-danger" href="?delete_id=<?php echo $row['slider_id']; ?>" title="Click to delete" onclick="return confirm('Are you sure you want to delete this?')"><span class="glyphicon glyphicon-remove-circle"></span> Delete</a>
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
<!-- END SLIDER -->
</div>	
</div>
<!-- FOOTER -->
<?php include 'admin_footer.php'; ?>