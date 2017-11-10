<?php 
  include('session.php');
  // count all unread notifications

  $_SESSION['notificationCount'] = $DB_con->query("SELECT COUNT(*) 
                               FROM notifications_users 
                               WHERE user_id = '".$login_session_id."'
                               AND check_read = 'No' ")->fetchColumn();

  if($_SESSION['notificationCount'] != $_SESSION['OldNotificationCount']){

    if($_SESSION['notificationCount'] > $_SESSION['OldNotificationCount']){

      $showedNotifCount = $DB_con->query("SELECT COUNT(*) FROM notifications_users WHERE user_id ='$login_session_id' AND notif = 0")->fetchColumn();
      if($showedNotifCount != 0){
        ?>
          <script>
              function notify(style) {
                $.notify({
                    title: 'Notification',
                    text: 'You have a new notification!',
                    image: "<i class='fa fa-bell fa-fw fa-2x'></i>"
                }, {
                    style: 'metro',
                    className: style,
                    autoHide: true,
                    clickToHide: false
                });
            }

            notify('info');
          </script>
        <?php

        $newNotif = "1";
        $stmt = $DB_con->prepare('UPDATE notifications_users 
                         SET notif=:anotif                    
                         WHERE user_id = :aid');
        $stmt->bindParam(':anotif', $newNotif);
        $stmt->bindParam(':aid',$login_session_id);
        $stmt->execute();

      }
      
    }

    $_SESSION['OldNotificationCount'] = $_SESSION['notificationCount'];
    
    ?>
    <script>
    loadlink2(); // reload writer_header_content.php
    stopinterval();
    </script>
    <?php

  }else{

    ?>
      <script>
      startinterval();
      </script>
    <?php

  }                 
?>