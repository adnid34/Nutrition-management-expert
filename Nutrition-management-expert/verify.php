<?php
    require_once 'PHP/dbconfig.php';
    include 'header.php'; // HEADER

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    // Verify data
    $email = $_GET['email']; 
    $hash = $_GET['hash'];
    $activation = "1"; 

    $searchEmailHash = $DB_con->query("SELECT COUNT(*) FROM user WHERE username = '$email' AND hash = '$hash'")->fetchColumn();

    if ($searchEmailHash != 0){
    	$stmt = $DB_con->prepare('UPDATE user 
								     SET activation=:aactivation						       
							       WHERE username = :aemail');
    	$stmt->bindParam(':aactivation',$activation);
		$stmt->bindParam(':aemail',$email);						
		$stmt->execute();
		
		$successMSG = "Your account has been activated!";
    }else{
    	$errMSG = "Something went wrong..";
    } 
}

?>

<div class="container container-style">
    <div id="article-wrapper">
        <div id="article-content">
            <div class="page-header">
                <h2 class="h2">Verify Account</h2>       
            </div>

            <?php
                if(isset($errMSG)){
                        ?>
                        <div class="alert alert-danger col-lg-9 col-md-9 col-centered">
                            <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
                        </div>
                        <?php
                }
                else if(isset($successMSG)){
                    ?>
                    <div class="alert alert-success col-lg-9 col-md-9 col-centered">
                          <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
                    </div>
                    <?php
                }
            ?>


        </div>
    </div>
</div>



<!-- FOOTER -->
<?php include 'footer.php'; ?>