
<?php 
include('session.php');
require_once '../PHP/dbconfig.php';

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
          <!-- <li><a href="article.php">Pending Articles</a></li> -->
          
        </ul>
        <ul class="nav navbar-nav navbar-right">
           <!-- /.dropdown -->
            <li id = "checkNotif" class="dropdown" >
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    
                    <i class="fa fa-bell fa-fw"></i> 
                    <span style = "<?php if($_SESSION['notificationCount'] == 0) echo 'display:none';?>" class="button__badge">
                      <?php echo $_SESSION['notificationCount']; ?></span> 
                    <i class="fa fa-caret-down"></i>
                    
                </a>

                <ul class="dropdown-menu notif-width" >

                  <?php
                  $stmt = $DB_con->prepare('SELECT notifications_users.*, notifications.*
                                            FROM notifications_users 
                                            LEFT JOIN notifications
                                              ON notifications_users.notification_id = notifications.notification_id
                                            WHERE notifications_users.user_id = :auserid
                                            ORDER BY timestamp DESC 
                                            LIMIT 6');
                  $stmt->bindParam(':auserid', $login_session_id);
                  $stmt->execute();
                  if($stmt->rowCount() > 0){
                  while($results = $stmt->fetch(PDO::FETCH_ASSOC)){
                      extract($results);
                   ?>
                    <li >
                        <a href="notification.php?notifid=<?php echo $notif_user_id; ?>" style = "padding:15px;" class = " 
                        <?php
                        if($check_read == 'No')
                          echo 'hovered';
                        ?>
                        " >                                           
                          <div class="ellipsis">
                          <i class="fa fa-bell fa-fw"></i> <?php echo $notification; ?>
                          </div>                                
                          <span class="pull-right text-muted small"><?php echo time_elapsed_string($timestamp); ?></span>
                            
                        </a>

                    </li>
                    <li class="divider" style = "margin: -0.1px 0;"></li>
                    <?php
                      }
                    ?>                 
                    <li>
                        <a class="text-center" href="notification_all.php">
                            <strong>See All Alerts</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                    <?php }else{
                    echo "<li class = 'text-center'><strong> No Notification to be shown.</strong></li>";
                     } ?>
                </ul>
                <!-- /.dropdown-alerts -->       
            </li>
            <!-- /.dropdown -->
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

