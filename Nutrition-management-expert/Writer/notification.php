<?php
    require_once '../PHP/dbconfig.php';
    include 'writer_header.php'; 
?>

<div class="container container-style">

<div class="row">

    <div class="col-lg-12">
        <div class="panel panel-default">

            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="">
                    <thead>
                        <tr>    
                            <th>Notification</th>
                            <th>Time</th>

                        </tr>
                    </thead>
                    <tbody>
                        
                    <?php

                    $query = $DB_con->prepare("UPDATE notifications_users 
                                               SET check_read= 'Yes'
                                               WHERE notif_user_id = :anotifid");
                    $query->bindParam(':anotifid', $_GET['notifid']);
                    $query->execute();
                    
                    $query = $DB_con->prepare('SELECT notifications_users.*, notifications.*, user_info.*
							                  FROM notifications_users 
							                  LEFT JOIN notifications
							                    ON notifications_users.notification_id = notifications.notification_id
							                  LEFT JOIN user_info
							                    ON notifications_users.user_id = user_info.user_id
							                  WHERE notifications_users.notif_user_id = :anotifid');
                    $query->bindParam(':anotifid', $_GET['notifid']);
                    $query->execute();
                    while($row=$query->fetch(PDO::FETCH_ASSOC)){

                            extract($row);
                    ?>

                        <tr class="">
                            <td style = "width: 80%;"><?php echo $notification; ?></td>
                            <td><?php echo time_elapsed_string($timestamp); ?></td>                            
                        </tr>   

                    <?php
                        }

                    ?>
                    </tbody>
                </table>

            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>

</div>




<!-- FOOTER -->
<?php include 'writer_footer.php'; ?>