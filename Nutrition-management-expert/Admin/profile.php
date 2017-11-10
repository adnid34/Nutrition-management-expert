<?php	
	require_once '../PHP/dbconfig.php';
	include 'admin_header.php';

	$id = $login_session_id;
	$stmt = $DB_con->prepare("SELECT * FROM user WHERE user_id = :id");
	$stmt->execute(array(':id'=>$id));
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	extract($row);
	
	if(isset($_POST['btn_save_updates'])){
		$email = $_POST['email'];
		
		if(empty($email)){
			$errMSG = "Please Enter Username.";
		}
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          	$errMSG = "Invalid Email Address.";
        }										
		
		// if no error occured, continue ....
		if(!isset($errMSG)){
			$stmt = $DB_con->prepare('UPDATE user 
									     SET email=:aemail						       
								       WHERE user_id = :aid');
			$stmt->bindParam(':aemail',$email);
			$stmt->bindParam(':aid',$id);
				
			if($stmt->execute()){
				?>
                <script>
				alert('Email Address has been successfully updated...');
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
	                Update Email Address / <a class="btn btn-default" href="index.php"> 
						        	<span class="glyphicon glyphicon-backward"></span> Cancel 
						        </a>	
	            </div>
	            <!-- /.panel-heading -->
	            <div class="panel-body">
	            	<form method="post" enctype="multipart/form-data" class="form-horizontal">
	            	<table class="table table-responsive" >
					    <tr>
					    	<td><label class="control-label">Email</label></td>
					        <td><input class="form-control admin-title-box" type="text" name="email" 
					        	value="<?php echo $email; ?>"/></td>
					    </tr>
					    
					    <tr>
					        <td colspan = "2">
					        	<button type="submit" name="btn_save_updates" class="btn btn-default">
						        	<span class="glyphicon glyphicon-save"></span> &nbsp; Update
						        </button>
					        </td>
					    </tr>    
				    </table>

				    <div class = "well well-lg">
				    	<label>Note: This email address will be used if you reset your password. </labe>
				    </div>
				    </form>
	            </div>
	        </div>
	    </div>
	</div>

</div>

<!-- FOOTER -->
<?php include 'admin_footer.php'; ?>