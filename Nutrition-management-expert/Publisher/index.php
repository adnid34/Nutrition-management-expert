<?php
    require_once '../PHP/dbconfig.php';
    include 'publisher_header.php'; 

    $articleApproved = $DB_con->query("SELECT COUNT(*) FROM article_writer WHERE status_publisher = 'Approved' AND article_publisher = '".$login_session_id."'")->fetchColumn();
    $articlePending = $DB_con->query("SELECT COUNT(*) FROM article_writer WHERE status_publisher = 'Pending'")->fetchColumn();
?>

<div  class="container container-style" >

	<div class="page-header">
		<h2 class="h2">Welcome <?php echo $login_session_fullname;?>!</h2> 
    </div>

	<div class="row">
		<div class="col-lg-3 col-md-6">
	        <div class="panel panel-green">
	            <div class="panel-heading">
	                <div class="row">
	                    <div class="col-xs-3">
	                        <i class="fa fa-check fa-5x"></i>
	                    </div>
	                    <div class="col-xs-9 text-right">
	                        <div class="huge"><?php echo $articleApproved; ?></div>
	                        <div>Published Article</div>
	                    </div>
	                </div>
	            </div>
	            <a href="published_article.php">
	                <div class="panel-footer">
	                    <span class="pull-left">View All Published Article</span>
	                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                    <div class="clearfix"></div>
	                </div>
	            </a>
	        </div>
	    </div>
	    <div class="col-lg-3 col-md-6">
	        <div class="panel panel-yellow">
	            <div class="panel-heading">
	                <div class="row">
	                    <div class="col-xs-3">
	                        <i class="fa fa-spinner fa-5x"></i>
	                    </div>
	                    <div class="col-xs-9 text-right">
	                        <div class="huge"><?php echo $articlePending; ?></div>
	                        <div>Pending Article</div>
	                    </div>
	                </div>
	            </div>
	            <a href="article.php">
	                <div class="panel-footer">
	                    <span class="pull-left">Manage Pending Article</span>
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
        <div class="col-lg-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Pending Articles
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                <table width="100%" class="table table-hover" id="writerTable">
                    <thead>
                        <tr>    
                            <th>Title</th>
                            <th>Author</th>
                            <th>Time</th>

                        </tr>
                    </thead>
                    <tbody>
                        
                    <?php
                    
                    $row = $DB_con->query("SELECT COUNT(*) FROM article_writer")->fetchColumn();
                    $query = $DB_con->prepare("SELECT article_writer.*, user_info.* 
                                               FROM article_writer
                                               LEFT JOIN user_info
                                                    ON article_writer.article_author = user_info.user_id
                                               WHERE status_publisher = 'Pending'");
                    $query->execute();
                    if($query->rowCount() > 0){
	                    while($row=$query->fetch(PDO::FETCH_ASSOC)){
	                            extract($row);
	                    ?>

	                        <tr href="article_publish.php?id=<?php echo $article_writer_id; ?>" style = "cursor:pointer;">
	                        	
	                            <td><?php echo $title; ?></td>
	                            <td><?php echo $full_name; ?></td>                            
	                            <td><?php echo time_elapsed_string($timestamp); ?></td>
	                            
	                        </tr>
	                        <script>
	                        $('#writerTable').on( 'click', 'tbody tr', function () {
	                        window.location.href = $(this).attr('href');
	                        } );
	                        </script>   

	                    <?php
	                        }

	                        ?>
	                        <tr href="article.php" style = "cursor:pointer;">
	                            <td colspan = "3" class = "text-center">
			                        <strong>See All Pending Article</strong>
			                        <i class="fa fa-angle-right"></i>
	                            </td>			                                
	                        </tr>
	                        <?php
	                    }else{
	                    	?>
	                    	<tr>
                                <td colspan = "3" class = "text-center">
				                        <strong>No Aritcle Sent to be shown.</strong>					                        
                                </td>			                                
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
	</div>


</div>




<!-- FOOTER -->
<?php include 'publisher_footer.php'; ?>