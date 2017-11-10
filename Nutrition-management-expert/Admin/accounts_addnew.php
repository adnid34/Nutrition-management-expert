<?php
	require_once '../PHP/dbconfig.php';

	
	if(isset($_POST['btnsave'])){
		$role = $_POST['role'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$confirm_password = $_POST['confirm_password'];
		$full_name = $_POST['full_name'];
		$birthdate = $_POST['birthdate'];

		//check if username has duplicate
	    $dupQuery = $DB_con->query("SELECT COUNT(*) FROM user WHERE username = '$username'")->fetchColumn();	
		
		if(empty($username)){
			$errMSG = "Please Enter Username.";
		}
	    else if($dupQuery != 0){
	        $errMSG = "Username Already Exist.";
	    }
		else if(empty($password)){
			$errMSG = "Please Enter Password.";
		}
		else if($password != $confirm_password){
            $errMSG = "Password does not match.";
        }
		else if(empty($full_name)){
			$errMSG = "Please Enter Name.";
		}
		else if(empty($birthdate)){
			$errMSG = "Please Enter Birthdate.";
		}		
		
		// if no error occured, continue ....
		if(!isset($errMSG)){
			$salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM)); //generate a random salt to use for this account
            $saltedPW =  $password . $salt;
            $hashedPW = hash('sha256', $saltedPW);

			$stmt = $DB_con->prepare('INSERT INTO user(username,password,role, salt) 
											 VALUES(:ausername, :apassword, :arole, :asalt)');
			$stmt->bindParam(':ausername',$username);
			$stmt->bindParam(':apassword',$hashedPW);
			$stmt->bindParam(':arole',$role);
			$stmt->bindParam(':asalt',$salt);
			$stmt->execute();

			$lastId = $DB_con->lastInsertId();
			$stmt = $DB_con->prepare('INSERT INTO user_info(user_id,full_name,birthdate) 
											 VALUES(:aid, :aname, :abirthdate)');
			$stmt->bindParam(':aid',$lastId);
			$stmt->bindParam(':aname',$full_name);
			$stmt->bindParam(':abirthdate',$birthdate);
			if($stmt->execute()){
				$successMSG = "New account has been succesfully added...";
				header("refresh:2;accounts.php"); // redirects page after x seconds.
			}
			else{
				$errMSG = "Error While Inserting....";
			}
		}
	}
?>

<!-- HEADER -->
<?php include 'admin_header.php'; ?>

<div class="container container-style">
	<div class="page-header">
    	<h2 class="h2">Add New Account  / <a class="btn btn-default" href="accounts.php"> <span class="glyphicon glyphicon-backward"></span> Cancel </a></h2>    	
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
<div class = "col-lg-9">
<form method="post" enctype="multipart/form-data" class="form-horizontal">
	    
	<table class="table table-bordered table-responsive">
	<tr >
    	<td><label class="control-label" >Role</label></td>
        <td>
        	<select class="form-control admin-select" type="text" style = "width:30%;" name="role">
					<option <?php if($role == "Editor") echo 'selected';?> value="Editor">Editor</option>
					<option <?php if($role == "Publisher") echo 'selected';?> value="Publisher">Publisher</option>
					<option <?php if($role == "Manager") echo 'selected';?> value="Manager">Manager</option>
        	</select>
        </td>
    </tr>

    <tr>
    	<td><label class="control-label">Username</label></td>
        <td><input class="form-control admin-title-box" type="text" name="username" 
        	value="<?php echo htmlspecialchars($_POST['username']); ?>"/></td>
    </tr>

    <tr>
    	<td><label class="control-label">Password</label></td>
        <td><input class="form-control admin-title-box" type="password" name="password" 
        	value="<?php echo htmlspecialchars($_POST['password']); ?>" 
        	/></td>
    </tr>

    <tr>
    	<td><label class="control-label">Confirm Password</label></td>
        <td><input class="form-control admin-title-box" type="password" name="confirm_password" 
        	value="<?php echo htmlspecialchars($_POST['confirm_password']); ?>" 
        	/></td>
    </tr>

    <tr>
    	<td><label class="control-label">Full Name</label></td>
        <td><input class="form-control" type="text" name="full_name" 
        	value="<?php echo htmlspecialchars($_POST['full_name']); ?>" 
        	/></td>
    </tr>

        <tr>
    	<td><label class="control-label">Birthdate</label></td>
        <td><input class="form-control admin-date-picker" type="date" name="birthdate" 
        	value="<? echo htmlspecialchars($_POST['birthdate']); ?>"/></td>
    </tr>
    
    <tr>
        <td colspan="2"><button type="submit" name="btnsave" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> &nbsp; Add
        </button>
        </td>
    </tr>
    
    </table>
    
</form>
</div>

</div>

<!-- FOOTER -->
<?php include 'admin_footer.php'; ?>