<?php
    require_once 'PHP/dbconfig.php';
    include 'header.php'; // HEADER
    


    //get user IP and set login interval(mins)
    $ip = $_SERVER['REMOTE_ADDR'];
    $login_interval = 10; //minutes
    
    if(isset($_POST['btnsave'])){
            //delete all data older than $login_interval minutes
            $stmt = $DB_con->prepare("DELETE FROM ip 
                                WHERE timestamp < (NOW() - INTERVAL $login_interval MINUTE);");
            $stmt->execute();

            

            //select all data within $login_interval minutes
            $_SESSION['loginCount'] = $DB_con->query("SELECT COUNT(*) FROM ip 
                                    WHERE address = '$ip' AND timestamp > (NOW() - INTERVAL $login_interval MINUTE)")->fetchColumn();

            if($_SESSION['loginCount'] < 30){
                $inputUsername = $_POST['username'];
                $inputPassword = $_POST['password'];
                $denyRole = "Writer";

                $stmt = $DB_con->prepare('SELECT * FROM user WHERE username = :ausername AND role != :arole');
                $stmt->bindParam(':ausername', $inputUsername);
                $stmt->bindParam(':arole', $denyRole);
                $stmt->execute();
                if($results = $stmt->fetch(PDO::FETCH_ASSOC))
                    extract($results);

                $inputPassword =  $inputPassword . $salt;
                $hashedPW = hash('sha256', $inputPassword);

                if(empty($inputUsername)){
                  $errMSG = "Please Enter Username.";
                }
                else if(empty($inputPassword)){
                  $errMSG = "Please Enter Password.";
                }


                if(!isset($errMSG)){
                    if($inputUsername == $username && $hashedPW == $password){
                        

                        switch($role){
                            case 'Admin':
                            header("Location: http://localhost/Nutrition-management-expert/Admin/index.php");
                            $_SESSION['login_user_admin']=$username;
                            break;

                            case 'Manager':
                            header("Location: http://localhost/Nutrition-management-expert/Manager/index.php/");
                            $_SESSION['login_user_manager']=$username;
                            break;

                            case 'Publisher':
                            header("Location: http://localhost/Nutrition-management-expert/Publisher/index.php/");
                            $_SESSION['login_user_publisher']=$username;
                            break;

                            case 'Editor':
                            header("Location: http://localhost/Nutrition-management-expert/Editor/index.php");
                            $_SESSION['login_user_editor']=$username;
                            break;

                            
                        }
                        

                        //delete all data from ip on login success
                        $stmt = $DB_con->prepare("DELETE FROM ip WHERE address = '$ip'");
                        $stmt->execute();

                    }
                    else{
                        $errMSG = "Invalid username or password";
                        //insert time now
                        if($_SESSION['loginCount'] < 3){
                        $stmt = $DB_con->prepare("INSERT INTO ip (address ,timestamp)
                                                  VALUES ('$ip',CURRENT_TIMESTAMP)");
                        $stmt->execute();
                        }

                        
                    }
                    
                }

            }
            else{
                $errMSG = "Maximum login attempt exceeded!";
            }


            
    
}

?>

<div class="container" style = "margin-top:50px;">
    <div id="article-wrapper" >
        <div id="article-content">
            
            <div class="row">  
                
                <div class="col-md-4 col-md-offset-4">
                    <?php
                            if(isset($errMSG)){
                                

                                    ?>
                                    <div class="alert alert-danger login-err" >   
                                        <strong><?php echo $errMSG; ?></strong>
                                    </div>
                                    <?php
                            }
                            ?>
                    <div class="login-panel panel panel-default">

                        <div class="panel-heading">
                            <h3 class="panel-title">Admin Login</h3>
                        </div>

                        <div class="panel-body">
                               
                            <form method="post" enctype="multipart/form-data">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Username" name="username" type="text" value="<?php echo htmlspecialchars($_POST['username']); ?>" />
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="password" type="password" value="<?php echo htmlspecialchars($_POST['password']); ?>" />
                                    </div>
                                    <div class="help-block text-right"><a href="forgot_admin_password.php">Forgot password?</a></div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <button type="submit" id="btnsave" name="btnsave" class="btn btn-lg btn-success btn-block">Login</button>
                                </fieldset>

                            </form>


                        </div>
                    </div>
                        <?php    
                        //-----------TEST CODE(shows login attempt)--------------------
                        $_SESSION['loginCount'] = $DB_con->query("SELECT COUNT(*) FROM ip WHERE address = '$ip' AND timestamp > (NOW() - INTERVAL $login_interval MINUTE)")->fetchColumn();
                        echo "login attempt: " . $_SESSION['loginCount'];
                        //-------------------------------------------------------------
                        ?>
                </div>
            </div>
        
        </div>


    </div>
</div>

<?php include 'footer.php'; // FOOTER ?>