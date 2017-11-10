<?php
include('session.php');
error_reporting( ~E_NOTICE ); // avoid notice
date_default_timezone_set("Asia/Manila");

// get the user_id of $login_session(username)
$stmt = $DB_con->prepare('SELECT user_id FROM user WHERE username = :ausername');
$stmt->bindParam(':ausername', $login_session);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
extract($results);
$login_session_id = $user_id;



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- <meta http-equiv="refresh" content="5"/> -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manager Page</title>

<?php include('../PHP/link.php'); ?> <!-- get all css & js links -->

</head>
<body>

<!-- NAVIGATION BAR -->
<div style = "font-size: 150%; ">
<nav class="navbar navbar-default navigation-style"  >
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class ="container">
      <div class="navbar-header" >
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand snc-logo" href="index.php"><img src = "../Images/logo.png"></a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" >
        <ul class="nav navbar-nav">
          
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown" >
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                  <i class="fa fa-user fa-fw"></i>   <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu " style = "">
                    <li><a href="profile.php"><i class="fa fa-user fa-fw "></i> Update Profile</a></li>
                    <li><a href="profile_change_password.php"><i class="fa fa-gear fa-fw"></i> Change Password</a></li>                 
                    <li class = "divider"></li>
                    <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
      </div>
  </div>
</nav>
</div>
<!-- END NAVIGATION BAR -->


<?php
  function time_elapsed_string($datetime, $full = false) {
      
      $now = new DateTime;
      $ago = new DateTime($datetime);
      $diff = $now->diff($ago);

      $diff->w = floor($diff->d / 7);
      $diff->d -= $diff->w * 7;

      $string = array(
          'y' => 'year',
          'm' => 'month',
          'w' => 'week',
          'd' => 'day',
          'h' => 'hour',
          'i' => 'minute',
          's' => 'second',
      );
      foreach ($string as $k => &$v) {
          if ($diff->$k) {
              $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
          } else {
              unset($string[$k]);
          }
      }

      if (!$full) $string = array_slice($string, 0, 1);
      return $string ? implode(', ', $string) . ' ago' : 'just now';
  }



?>

