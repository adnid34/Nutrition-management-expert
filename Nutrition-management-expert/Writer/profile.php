<?php	
	require_once '../PHP/dbconfig.php';
	include 'writer_header.php';

	$id = $login_session_id;
	$stmt = $DB_con->prepare("SELECT * FROM user_info WHERE user_id = :id");
	$stmt->execute(array(':id'=>$id));
	$stmt->execute();
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	extract($row);
	
	if(isset($_POST['btn_save_updates'])){
		$full_name = $_POST['full_name'];
		$birthdate = $_POST['birthdate'];	
		
		if(empty($full_name)){
			$errMSG = "Please Enter Username.";
		}
		else if(empty($birthdate)){
			$errMSG = "Please Enter Password.";
		}											
		
		// if no error occured, continue ....
		if(!isset($errMSG)){
			$stmt = $DB_con->prepare('UPDATE user_info 
									     SET full_name=:afullname,
									     	 birthdate=:abirthdate						       
								       WHERE user_id = :aid');
			$stmt->bindParam(':afullname',$full_name);
			$stmt->bindParam(':abirthdate',$birthdate);
			$stmt->bindParam(':aid',$id);
				
			if($stmt->execute()){
				?>
                <script>
				alert('Profile has been successfully updated...');
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
	                Update Profile / <a class="btn btn-default" href="index.php"> 
						        	<span class="glyphicon glyphicon-backward"></span> Cancel 
						        </a>	
	            </div>
	            <!-- /.panel-heading -->
	            <div class="panel-body">
	            	<form method="post" enctype="multipart/form-data" class="form-horizontal">
	            	<table class="table table-responsive" >
					    <tr>
					    	<td><label class="control-label">Full Name</label></td>
					        <td><input class="form-control admin-title-box" type="text" name="full_name" 
					        	value="<?php echo $full_name; ?>"/></td>
					    </tr>

				        <tr>
					    	<td><label class="control-label">Birthdate</label></td>
					        <td><input class="form-control admin-date-picker" type="date" name="birthdate" value="<?php echo $birthdate; ?>" /></td>
					    </tr>
					    
					    <tr>
					        <td colspan = "2">
					        	<button type="submit" name="btn_save_updates" class="btn btn-default">
						        	<span class="glyphicon glyphicon-save"></span> &nbsp; Update
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