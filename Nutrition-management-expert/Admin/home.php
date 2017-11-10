<?php
	require_once '../PHP/dbconfig.php';	
    if(isset($_GET['delete_home_id'])){  
        // delete record
        $stmt_delete = $DB_con->prepare('DELETE FROM home WHERE home_id =:uid');
        $stmt_delete->bindParam(':uid',$_GET['delete_home_id']);
        $stmt_delete->execute();

        header("Location: home.php");
    }

?>
<!-- HEADER -->
<?php include 'admin_header.php'; ?>



<div class="container">

<div class="page-header">
	<h2 class="h2">Manage Home Content </h2> 
</div>
<br />
	
<div id="content" class="admin-content cleafix" >

<!-- HOME CONTENT -->
<div id = "home_content" class="admin-search">
    <a class="btn btn-success admin-add-btn" href="home_addnew.php"><span class="glyphicon glyphicon-plus"></span> &nbsp; Add Content</a>
</div>
<div class="row">

    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Home Content
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="">
                    <thead>
                        <tr>    
                            <th>Title</th>
                            <th>Content</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        
                    <?php
                    
                    $row = $DB_con->query("SELECT COUNT(*) FROM home")->fetchColumn();
                    $total_row = $row;
                    $query = $DB_con->prepare("SELECT * FROM home ORDER BY home_id");
                    $query->execute();
                    while($row=$query->fetch(PDO::FETCH_ASSOC)){
                            extract($row);
                    ?>

                        <tr class="">
                            <td style = "width: 25%;"><?php echo $title; ?></td>
                            <td style = "width: 55%;"><?php echo $content; ?></td>                            
                            <td>
                            <a class="btn btn-info" href="home_editform.php?edit_id=<?php echo $row['home_id']; ?>" title="Click to edit"><span class="glyphicon glyphicon-edit"></span> Edit</a> 
                            <a class="btn btn-danger" href="?delete_home_id=<?php echo $row['home_id']; ?>#home_content" title="Click to delete" onclick="return confirm('Are you sure you want to delete this?')"><span class="glyphicon glyphicon-remove-circle"></span> Delete</a>
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
<!-- END HOME CONTENT -->



</div>	
</div>
<!-- FOOTER -->
<?php include 'admin_footer.php'; ?>