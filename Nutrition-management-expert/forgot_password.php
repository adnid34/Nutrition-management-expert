<?php
    require_once 'PHP/dbconfig.php';
    include 'header.php'; // HEADER
    

    if(isset($_POST['btn_submit'])){
    	$inputEmail = $_POST['email'];    	

    	//check if email exists on db
    	$checkEmail = $DB_con->query("SELECT COUNT(*) FROM user WHERE username = '$inputEmail'")->fetchColumn();

    	if(empty($inputEmail)){
            $errMSG = "Please Enter Email Address.";
        }
        else if (!filter_var($inputEmail, FILTER_VALIDATE_EMAIL)) {
            $errMSG = "Please Enter Valid Email Address."; 
        }
        else if($checkEmail == 0){
            $errMSG = "Email Address is not registered.";
        }


        if(!isset($errMSG)){
        	$stmt = $DB_con->prepare("SELECT * FROM user WHERE username = :aemail");
			$stmt->execute(array(':aemail'=>$inputEmail));
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);

        	$randomPassword = bin2hex(mcrypt_create_iv(2, MCRYPT_DEV_URANDOM)); //create a random password
        	$saltedPW =  $randomPassword . $salt;
			$hashedPW = hash('sha256', $saltedPW);

        	$stmt = $DB_con->prepare('UPDATE user 
									     SET password=:apassword						       
								       WHERE username=:aemail');
			$stmt->bindParam(':apassword',$hashedPW);
			$stmt->bindParam(':aemail',$inputEmail);
				
			if($stmt->execute()){
				//SEND EMAIL FOR NEW PASSWORD
	            $emailTo = $inputEmail;
	            $emailSubject = "New Password Request";
	            $emailBody = "
	            Hello, <br /><br />
	            Your new password is: <br />
	            <b>$randomPassword</b><br /><br />
	            Thank you!
	            ";
	            include 'mail.php';
	            //END EMAIL
	            $successMSG = "Your password has been reset, check your email to get your new password.";
			}
			else{
				$errMSG = "Sorry Data Could Not Updated !";
			}
        	
        }    
        else{
            $errMSG = "Error While Inserting....";
        }
    }
?>



<div class="container container-style">
    <div id="article-wrapper">
        <div id="article-content">
        	<div class="page-header">
                <h2 class="h2">Forgot Password</h2>       
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
            <div class = "well well-lg col-lg-5 col-md-5 col-centered">            	
            	<form method="post" enctype="multipart/form-data" class="form-horizontal">
		            <label>Enter the email address associated with your account below to reset your password.</label>
		            <br /><br />
					<div class="input-group">	
					    <input type="text" name="email" class="form-control" placeholder = "Email Address" value="<?php echo htmlspecialchars($_POST['email']); ?>"  />
					    <span class="input-group-btn">
					        <button type="submit" name="btn_submit" class="btn btn-warning" onclick="return confirm('Are you sure you want to reset your password?')">
					        	<span class=""></span> Reset Password
					        </button>
					    </span>
					</div>
				</form>
            </div>
            
        </div>
    </div>
</div>



<!-- FOOTER -->
<?php include 'footer.php'; ?>