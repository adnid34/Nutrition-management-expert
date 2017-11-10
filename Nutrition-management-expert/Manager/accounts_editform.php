<?php	
	require_once '../PHP/dbconfig.php';
	include 'manager_header.php';

	if(isset($_GET['edit_id']) && !empty($_GET['edit_id'])){
		$id = $_GET['edit_id'];
		$stmt = $DB_con->prepare("SELECT * FROM user WHERE user_id = :id");
		$stmt->execute(array(':id'=>$id));
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);		
	}
	else{
		header("Location: accounts.php");
	}
	
	if(isset($_POST['btn_save_updates'])){
		$newPassword = $_POST['new_password'];
		$confirmPassword = $_POST['confirm_password'];

		if(empty($newPassword)){
			$errMSG = "Please Enter New Password.";
		}
		else if($newPassword != $confirmPassword){
			$errMSG = "New Password does not match!";
		}												
		
		// if no error occured, continue ....
		if(!isset($errMSG)){
		
			$saltedPW =  $newPassword . $salt;
			$hashedPW = hash('sha256', $saltedPW);

			$stmt = $DB_con->prepare('UPDATE user 
									     SET password=:apassword							       
								       WHERE user_id = :aid');
			$stmt->bindParam(':apassword',$hashedPW);
			$stmt->bindParam(':aid',$id);
				
			if($stmt->execute()){
				?>
                <script>
				alert('Account has been successfully updated ...');
				window.location.href='accounts.php';
				</script>
                <?php
			}
			else{
				$errMSG = "Sorry Data Could Not Updated !";
			}
		}								
	}	
?>
<!-- HEADER -->
<?php  ?>

<div class="container container-style">
	<div class="page-header">
    	<h2 class="h2">Reset Password  / <a class="btn btn-default" href="accounts.php"> <span class="glyphicon glyphicon-backward"></span> Cancel </a></h2>    	
    </div>
<?php
	if(isset($errMSG)){
			?>
            <div class="alert alert-danger">
            	<span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
            </div>
            <?php
	}
	else if(isset($successMSG)){
		?>
        <div class="alert alert-success">
              <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
        </div>
        <?php
	}
	?>   
	<div class = "col-lg-9 col-md-9">
		<form method="post" enctype="multipart/form-data" class="form-horizontal">
			    
			<table class="table table-bordered table-responsive">
			<tr>
		    	<td><label class="control-label">Role</label></td>
		        <td><input class="form-control" type="text" value="<?php echo $role; ?>" disabled /></td>
		    </tr>

		    <tr>
		    	<td><label class="control-label">Username/Email</label></td>
		        <td><input class="form-control" type="text" value="<?php echo $username; ?>" disabled/></td>
		    </tr>

		    <tr>
		    	<td><label class="control-label">New Password</label></td>
		        <td><input class="form-control" type="password" name="new_password" /></td>
		    </tr>

		    <tr>
		    	<td><label class="control-label">Confirm New Password</label></td>
		        <td><input class="form-control" type="password" name="confirm_password" /></td>
		    </tr>
		    
		    <tr>
		        <td colspan="2"><button type="submit" name="btn_save_updates" class="btn btn-default">
		        <span class="glyphicon glyphicon-save"></span> &nbsp; Save
		        </button>
		        </td>
		    </tr>
		    
		    </table>
		    
		</form>
	</div>
</div>

<!-- FOOTER -->
<?php include 'manager_footer.php'; ?>