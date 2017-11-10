<?php
    require_once 'PHP/dbconfig.php';
    include 'header.php'; // HEADER

    if(isset($_POST['btnsave'])){
        $role = "Writer";
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $full_name = $_POST['full_name'];
        $birthdate = $_POST['birthdate'];

        //check if username has duplicate
        $dupQuery = $DB_con->query("SELECT COUNT(*) FROM user WHERE username = '$email'")->fetchColumn();    
        
        if(empty($email)){
            $errMSG = "Please Enter Username.";
        }
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errMSG = "Please Enter Valid Email Address."; 
        }
        else if($dupQuery != 0){
            $errMSG = "Email Address is already registered.";
        }
        else if(empty($password)){
            $errMSG = "Please Enter Password.";
        }
        else if(empty($confirm_password)){
            $errMSG = "Please Enter Confirm Password.";
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
            $hash = md5(rand(0,1000)); //random hash for account activation
            $salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM)); //generate a random salt to use for this account
            $saltedPW =  $password . $salt;
            $hashedPW = hash('sha256', $saltedPW);

            $stmt = $DB_con->prepare('INSERT INTO user(username,password,role, salt, hash) 
                                             VALUES(:ausername, :apassword, :arole, :asalt, :ahash)');
            $stmt->bindParam(':ausername',$email);
            $stmt->bindParam(':apassword',$hashedPW);
            $stmt->bindParam(':arole',$role);
            $stmt->bindParam(':asalt',$salt);
            $stmt->bindParam(':ahash',$hash);
            $stmt->execute();

            $lastId = $DB_con->lastInsertId();
            $stmt = $DB_con->prepare('INSERT INTO user_info(user_id,full_name,birthdate) 
                                             VALUES(:aid, :aname, :abirthdate)');
            $stmt->bindParam(':aid',$lastId);
            $stmt->bindParam(':aname',$full_name);
            $stmt->bindParam(':abirthdate',$birthdate);
            if($stmt->execute()){
                //SEND EMAIL FOR ACCOUNT ACTIVATION
                $emailTo = $email;
                $emailSubject = "Account Activation";
                $emailBody = "
                Hello, <br /><br />
                Please click the following link to activate your account: <br />
                <a href = 'http://localhost/Nutrition-management-expert/verify.php?email=$email&hash=$hash'><span style = 'font-size:150%;'>Click here to activate your account.</span> </a><br /><br />
                Thank you!
                ";
                include 'mail.php';
                //END EMAIL

                $successMSG = "Your account has been made, <br /> please verify it by clicking the activation link that has been send to your email";
                
            }
            else{
                $errMSG = "Error While Inserting....";
            }
        }
    }

?>



<div class="container container-style">
    <div id="article-wrapper">
        <div id="article-content">

                <div class="page-header">
                    <h2 class="h2">Register</h2>       
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

                <tr>
                    <td><label class="control-label">Email</label></td>
                    <td><input class="form-control" type="text" name="email" 
                        value="<?php echo htmlspecialchars($_POST['email']); ?>"/></td>
                </tr>

                <tr>
                    <td><label class="control-label">Password</label></td>
                    <td><input class="form-control" type="password" name="password" 
                        value="<?php echo htmlspecialchars($_POST['password']); ?>" 
                        /></td>
                </tr>

                <tr>
                    <td><label class="control-label">Confirm Password</label></td>
                    <td><input class="form-control" type="password" name="confirm_password" 
                        value="<?php echo htmlspecialchars($_POST['confirm_password']); ?>" 
                        /></td>
                </tr>

                <tr>
                    <td><label class="control-label">Full Name</label></td>
                    <td><input class="form-control" type="test" name="full_name" 
                        value="<?php echo htmlspecialchars($_POST['full_name']); ?>" 
                        /></td>
                </tr>

                    <tr>
                    <td><label class="control-label">Birthdate</label></td>
                    <td><input class="form-control" style = "width:50%;" type="date" name="birthdate" 
                        value="<? echo htmlspecialchars($_POST['birthdate']); ?>"/></td>
                </tr>
                
                <tr>
                    <td colspan="2"><button type="submit" name="btnsave" class="btn btn-default">
                    <span class="glyphicon glyphicon-save"></span> &nbsp; Register
                    </button>
                    </td>
                </tr>
                
                </table>
                
            </form>
            </div>

        </div>
    </div>
</div>



<!-- FOOTER -->
<?php include 'footer.php'; ?>