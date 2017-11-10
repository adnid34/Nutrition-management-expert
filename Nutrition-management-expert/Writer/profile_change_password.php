<?php	
	require_once '../PHP/dbconfig.php';
	include 'writer_header.php';

	$id = $login_session_id;
	$stmt = $DB_con->prepare("SELECT * FROM user WHERE user_id = :id");
	$stmt->execute(array(':id'=>$id));
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	extract($row);
	
	if(isset($_POST['btn_save_updates'])){

		$currentPassword = $password;
		$inputPassword = $_POST['input_password'];
		$newPassword = $_POST['new_password'];
		$confirmPassword = $_POST['confirm_password'];
		
		$saltedPW =  $inputPassword . $salt;
		$hashedPW = hash('sha256', $saltedPW);

		if($currentPassword != $hashedPW){
			$errMSG = "Incorrect Password!";
		}
		else if(empty($newPassword)){
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
				alert('Password has been successfully updated...');
				window.location.href='index.php';
				</script>
                <?php
			}
			else{
				$errMSG = "Sorry Data Could Not Updated !";
			}
		}								
	}	
?>

<div class="container container-style">
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

	<div class="row" >
	    <div class="col-lg-9">
	        <div class="panel panel-default">
	            <div class="panel-heading" style = "font-size: 150%;">
	                Change Password / <a class="btn btn-default" href="index.php"> 
						        	<span class="glyphicon glyphicon-backward"></span> Cancel 
						        </a>	
	            </div>
	            <!-- /.panel-heading -->
	            <div class="panel-body">
	            	<form method="post" enctype="multipart/form-data" class="form-horizontal">
	            	<table class="table table-responsive" >
					    <tr>
					    	<td><label class="control-label">Current Password</label></td>
					        <td><input class="form-control admin-title-box" type="password" name="input_password" /></td>
					    </tr>

					    <tr>
					    	<td><label class="control-label">New Password</label></td>
					        <td><input class="form-control admin-title-box" type="password" name="new_password" /></td>
					    </tr>

					    <tr>
					    	<td><label class="control-label">Confirm New Password</label></td>
					        <td><input class="form-control admin-title-box" type="password" name="confirm_password" /></td>
					    </tr>
					    
					    <tr>
					        <td colspan = "2">
					        	<button type="submit" name="btn_save_updates" class="btn btn-warning">
						        	Change Password
						        </button>
					        </td>
					    </tr>    
				    </table>
				    </form>
	            </div>
	        </div>
	    </div>
	</div>

</div>

<!-- FOOTER -->
<?php include 'writer_footer.php'; ?>