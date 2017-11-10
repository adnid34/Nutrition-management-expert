<?php
	require_once '../PHP/dbconfig.php';	
?>
<!-- HEADER -->
<?php include 'manager_header.php'; ?>
<script>
    $(document).ready(function() {
        $('#writerTable').DataTable({
            "ordering": false,
            "info":     false,          
            "language": {"emptyTable":"No Account to be shown."},
            responsive: true
        });
    });
</script>
<div class="container">

	<div class="page-header">
    	<h2 class="h2">Manage Accounts </h2> 
    </div>
	<br />
	<div class="has-feedback admin-search">
		<a class="btn btn-success admin-add-btn" href="accounts_addnew.php"><span class="glyphicon glyphicon-plus"></span> &nbsp; Add New Account </a>
	</div>
<div id="content" class="admin-content cleafix" >
	<!-- /.row -->
<div class="row">

    <div class="col-lg-12">
        <div class="panel panel-default">

            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="writerTable">
                    <thead>
                        <tr>    
                        	<th>Role</th>
                            <th>Username/Email</th>
                            <th>Password</th>                            
                            <th>Action</th>       
                        </tr>
                    </thead>
                    <tbody>
                        
                    <?php
                    
                    $row = $DB_con->query("SELECT COUNT(*) FROM user WHERE role != 'Admin' AND role != 'Manager'")->fetchColumn();
                    $query = $DB_con->prepare("SELECT * FROM user WHERE role != 'Admin' AND role != 'Manager'");
                    $query->execute();
                    while($row=$query->fetch(PDO::FETCH_ASSOC)){
                            extract($row);
                    ?>

                        <tr class="">
                            <td><?php echo $role; ?></td>
                            <td><?php echo $username; ?></td>
                            <td><?php echo $password;?></td>
                            <td>
                            <a class="btn btn-warning" href="accounts_editform.php?edit_id=<?php echo $row['user_id']; ?>" title="Click to Reset Password"> Reset Password</a> 
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
<?php include 'manager_footer.php'; ?>