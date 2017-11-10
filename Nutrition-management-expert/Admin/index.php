<?php
    require_once '../PHP/dbconfig.php';
    include 'admin_header.php'; 

    $contentCount = $DB_con->query("SELECT COUNT(*) FROM home")->fetchColumn();
    $sliderPageCount = $DB_con->query("SELECT COUNT(*) FROM slider")->fetchColumn();
    $userCount = $DB_con->query("SELECT COUNT(*) FROM user WHERE role != 'Admin'")->fetchColumn();
?>

<div  class="container container-style" >

	<div class="page-header">
		<h2 class="h2">Welcome <?php echo $login_session;?>!</h2> 
    </div>

	<div class="row">
		<div class="col-lg-3 col-md-6">
	        <div class="panel panel-primary">
	            <div class="panel-heading">
	                <div class="row">
	                    <div class="col-xs-3">
	                        <i class="fa fa-align-justify fa-5x"></i>
	                    </div>
	                    <div class="col-xs-9 text-right">
	                        <div class="huge"><?php echo $contentCount; ?></div>
	                        <div>Total Home Content</div>
	                    </div>
	                </div>
	            </div>
	            <a href="home.php">
	                <div class="panel-footer">
	                    <span class="pull-left">Manage Home Content</span>
	                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                    <div class="clearfix"></div>
	                </div>
	            </a>
	        </div>
	    </div>
	    <div class="col-lg-3 col-md-6">
	        <div class="panel panel-primary">
	            <div class="panel-heading">
	                <div class="row">
	                    <div class="col-xs-3">
	                        <i class="fa fa-photo fa-5x"></i>
	                    </div>
	                    <div class="col-xs-9 text-right">
	                        <div class="huge"><?php echo $sliderPageCount; ?></div>
	                        <div>Total Slider Page</div>
	                    </div>
	                </div>
	            </div>
	            <a href="home_slider.php">
	                <div class="panel-footer">
	                    <span class="pull-left">Manage Slider</span>
	                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                    <div class="clearfix"></div>
	                </div>
	            </a>
	        </div>
	    </div>
	    <div class="col-lg-3 col-md-6" >
                    <div class="panel panel-green">
                        <div class="panel-heading" >
                            <div class="row" >
                                <div class="col-xs-3" >
                                    <i class="fa fa-user fa-5x" style = "margin-left:8px;"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div style = "font-size:34px;"><?php echo $userCount;?></div>
                                    <div style = "font-size:16px;">Total Account</div>
                                </div>
                            </div>
                        </div>
                        <a href="accounts.php">
                            <div class="panel-footer">
                                <span class="pull-left">Manage Account</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
	</div>
	<!-- /.row --> 
	<br />
	<div class="row">
		<div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Slider Preview
                </div>
                <div class="panel-body">
                	<!-- SLIDER -->
					<div id="da-slider" class="da-slider">
						<?php
						$stmt = $DB_con->prepare("SELECT * FROM slider ORDER BY slider_id");
						$stmt->execute();
						
							while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
								extract($row);
								?>
								<div class="da-slide">
									<h2><?php echo $title; ?></h2>
									<p><?php echo $content; ?></p>					
									<div class="da-img"><img src="../Images/<?php echo $row['image']; ?>" class = "img-rounded" width="250px" height="250px" alt="image01" /></div>
								</div>
							    <?php
							}
						?>	


						<nav class="da-arrows">
							<span class="da-arrows-prev"></span>
							<span class="da-arrows-next"></span>
						</nav>
					</div>
                </div>
            </div>
        </div>        
	</div>
</div>
<!-- FOOTER -->
<?php include 'admin_footer.php'; ?>