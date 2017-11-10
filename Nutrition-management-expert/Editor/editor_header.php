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
<title>Editor Page</title>

<?php include('../PHP/link.php'); ?> <!-- get all css & js links -->

</head>
<body>

<?php 
// count all unread notifications
$_SESSION['OldNotificationCount'] = $DB_con->query("SELECT COUNT(*) 
                             FROM notifications_users 
                             WHERE user_id = '".$login_session_id."'
                             AND check_read = 'No' ")->fetchColumn();                    
?>

<div id = "reloadThis"> 

</div>

<div id = "reloadThis2"> 

</div>


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

