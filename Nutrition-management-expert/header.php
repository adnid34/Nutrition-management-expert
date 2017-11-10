<?php 
session_start(); 
ob_start();
error_reporting( ~E_NOTICE ); // avoid notice

//get user IP and set login interval(mins)
$ip = $_SERVER['REMOTE_ADDR'];
$login_interval = 10; //minutes

if(isset($_POST['login_writer'])){
        //delete all data older than $login_interval minutes
        $stmt = $DB_con->prepare("DELETE FROM ip 
                            WHERE timestamp < (NOW() - INTERVAL $login_interval MINUTE);");
        $stmt->execute();

        

        //select all data within $login_interval minutes
        $_SESSION['loginCount'] = $DB_con->query("SELECT COUNT(*) FROM ip 
                                WHERE address = '$ip' AND timestamp > (NOW() - INTERVAL $login_interval MINUTE)")->fetchColumn();

        if($_SESSION['loginCount'] < 3){
            $inputEmailAddress = $_POST['email_writer'];
            $inputPassword = $_POST['password_writer'];

            $stmt = $DB_con->prepare("SELECT * FROM user WHERE username = '$inputEmailAddress'");
            $stmt->execute();
            if($results = $stmt->fetch(PDO::FETCH_ASSOC)) //-----
              extract($results);            

            $inputPassword =  $inputPassword . $salt;
            $hashedPW = hash('sha256', $inputPassword);


            if(empty($inputEmailAddress)){
              $errMSG2 = "Please Enter Email Address.";
            }
            else if (!filter_var($inputEmailAddress, FILTER_VALIDATE_EMAIL)) {
              $errMSG2 = "Invalid Email Address.";
            }
            else if(empty($inputPassword)){
              $errMSG2 = "Please Enter Password.";
            }
            else if(isset($activation) && $activation == 0){ //----
              $errMSG2 = "Please Activate your Account by clicking the link in your email.";
            }


            if(!isset($errMSG2)){
                if($inputEmailAddress == $username && $hashedPW == $password){
                    $_SESSION['login_user']=$username;
                    header("Location: http://localhost/snc/Writer");

                    //delete all data from ip on login success
                    $stmt = $DB_con->prepare("DELETE FROM ip WHERE address = '$ip'");
                    $stmt->execute();

                }
                else{
                    $errMSG2 = "Incorrect email or password";
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
            $errMSG2 = "Maximum login attempt exceeded!";
        }              
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
<title>Nutrition management expert</title>
<link rel="shortcut icon" type="image/png" href="Images/logo.png"/>

<link rel="stylesheet" href="CSS/bootstrap.min.css">
<link rel="stylesheet" href="CSS/bootstrap-theme.min.css">
<link rel="stylesheet" type="text/css" href="CSS/slider-style.css" />
<link rel="stylesheet" href="CSS/style.css">

<script type="text/javascript" src="JS/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="JS/bootstrap.min.js"></script>
<script type="text/javascript" src="JS/addthis_widget.js"></script>
<script type="text/javascript" src="JS/modernizr.custom.28468.js"></script>
<noscript>
  <link rel="stylesheet" type="text/css" href="CSS/nojs.css" />
</noscript>
<script type="text/javascript" src="JS/jquery.js"></script>
<script type="text/javascript" src="JS/jquery.cslider.js"></script>

<!-- Chart.js  -->
<script type="text/javascript" src="JS/charts/Chart.bundle.js"></script>
<script type="text/javascript" src="JS/charts/utils.js"></script>

<!-- DataTables -->
<link href="CSS/dataTables.bootstrap.css" rel="stylesheet">
<link href="CSS/dataTables.responsive.css" rel="stylesheet">
<link href="CSS/sb-admin-2.css" rel="stylesheet">
<link href="CSS/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="CSS/froala/font-awesome.min.css">
<script type="text/javascript" src="JS/metisMenu.min.js"></script>
<script type="text/javascript" src="JS/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="JS/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="JS/dataTables.responsive.js"></script>
<script type="text/javascript" src="JS/sb-admin-2.js"></script>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            responsive: true
        });
    });
</script>


<!-- Slider Background movement -->
<script type="text/javascript">
  $(function() {
  
    $('#da-slider').cslider({
      autoplay  : true,
      bgincrement : 500
    });
  
  });
</script>


<!-- Animate loader off screen -->
<script>
  $(window).load(function() {
    $(".load-icon").fadeOut("slow");;
  });

// disable right click
// $(document).ready(function()
// { 
//        $(document).bind("contextmenu",function(e){
//               return false;
//        }); 
// });

</script>

<style>
	span#title-line3 {
    color: oldlace;
}
</style>


</head>
<body>
<!-- loading screen div -->
<div class="load-icon"></div>

<div style = "font-size: 150%; ">
<nav class="navbar navbar-default" style = "z-index:100;">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class ="container">
      <div class="navbar-header" >
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand snc-logo" href="index.php"><img src = "Images/logo.png"></a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style = "font-size: 98%;">
        <ul class="nav navbar-nav navbar">
          <li><a href="foods.php">Foods</a></li>
		  
          <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tools<span class="caret"></span></a>
          <ul class="dropdown-menu dropdown-menu-size" role="menu">
            <li><a href="tools_bmi.php">BMI</a></li>            
            <li><a href="tools_ideal_weight.php">Ideal Body Weight</a></li>
            <li><a href="tools_daily_calorie_needs.php">Daily Calorie Needs</a></li>
			<li><a href="protein.php">Protein Counter</a></li>
          </ul>
        </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
		<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Articles<span class="caret"></span></a>
          <ul class="dropdown-menu dropdown-menu-size" role="menu">
          <li><a href="article_kids.php" >For Kids</a></li>
          <li><a href="article_men.php" >For Men</a></li>
          <li><a href="article_women.php" >For Women</a></li>
          <li><a href="article_seniors.php" >For Seniors</a></li>
			</ul>
			</li>
			
          <li class="dropdown
              <?php
                // keep login tab selected on "sign in"
                if(isset($_GET['loginSelected']) && !empty($_GET['loginSelected'])){
                  echo 'open';
              }
            ?>" id = "myTab">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Login<span class="caret"></span></a>
            <ul id="login-dp" class="dropdown-menu">
              <li>
                 <div class="row">
                    <div class="col-md-12">
                       <form class="form" role="form" method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?loginSelected=1'  ?>" accept-charset="UTF-8" id="login-nav" novalidate>
                            <?php
                              if(isset($errMSG2)){
                                ?>
                                <div class="alert alert-danger" >   
                                    <strong><?php echo $errMSG2; ?></strong>
                                </div>
                                <?php
                              }
                            ?>
                          <div class="form-group">
                             <label class="sr-only">Email address</label>
                             <input type="email" class="form-control" name="email_writer" placeholder="Email address" value="<?php echo htmlspecialchars($_POST['email_writer']); ?>">
                          </div>
                          <div class="form-group">
                             <label class="sr-only">Password</label>
                             <input type="password" class="form-control" name="password_writer" placeholder="Password" value="<?php echo htmlspecialchars($_POST['password_writer']); ?>">
                                                   <div class="help-block text-right"><a href="forgot_password.php">Forgot password?</a></div>
                          </div>
                          <div class="form-group">
                             <button type="submit" name="login_writer" class="btn btn-success btn-block">Sign in</button>
                          </div>
                       </form>
                    </div>
                    <div class="bottom text-center">
                      Send us your article! <a href="register.php"><b>Sign Up</b></a>
                    </div>
                 </div>
              </li>
            </ul>
        </li>
        </ul>
      </div>
  </div>
</nav>
</div>

<body>

  <?php date_default_timezone_set("Asia/Manila"); ?>
<style>
#bg { position: fixed; top: 0; left: 0; }
.bgwidth { width: 100%; }
.bgheight { height: 100%; }
</style>
<div id ="parallax">
  <ul id="scene" class="scene">
      <li style = "z-index: -50; opacity:0.7;" class="layer" data-depth="0.8"><img class="layer_2" ></li>
      <li style = "z-index: -60; opacity:0.1;" class="layer" data-depth="0.40"><img class="layer_3"></li>
      <li style = "z-index: -70; opacity:1;" class="layer" data-depth="0.20"><img class="layer_4"></li>
  </ul>
</div>
