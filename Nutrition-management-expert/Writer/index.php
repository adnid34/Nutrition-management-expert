<?php
    require_once '../PHP/dbconfig.php';
    include 'writer_header.php'; 

    $articleSentCount = $DB_con->query("SELECT COUNT(*) FROM article_writer WHERE article_author = '".$login_session_id."'")->fetchColumn();

    $articlePendingEditorCount = $DB_con->query("SELECT COUNT(*) FROM article_writer WHERE article_author = '".$login_session_id."' AND status_editor = 'Pending'" )->fetchColumn();
    $articlePendingPublisherCount = $DB_con->query("SELECT COUNT(*) FROM article_writer WHERE article_author = '".$login_session_id."' AND status_publisher = 'Pending'" )->fetchColumn();
    $articlePending = $articlePendingEditorCount + $articlePendingPublisherCount;

    $articleApproved = $DB_con->query("SELECT COUNT(*) FROM article_writer WHERE article_author = '".$login_session_id."' AND status_editor = 'Approved' AND status_publisher = 'Approved'" )->fetchColumn();

    $articleRejectedEditorCount = $DB_con->query("SELECT COUNT(*) FROM article_writer WHERE article_author = '".$login_session_id."' AND status_editor = 'Rejected'" )->fetchColumn();
    $articleRejectedPublisherCount = $DB_con->query("SELECT COUNT(*) FROM article_writer WHERE article_author = '".$login_session_id."' AND status_publisher = 'Rejected'" )->fetchColumn();
    $articleRejected = $articleRejectedEditorCount + $articleRejectedPublisherCount;
?>

<script>
    $(document).ready(function() {
        $('#writerTable').DataTable({
        	"searching": false,
            "paging":   false,
	        "ordering": false,
	        "info":     false,
	        responsive: true
        });
    });
</script>

<div  class="container container-style">

	<div class="page-header">
		<h2 class="h2">Welcome <?php echo $login_session_fullname;?>!</h2> 
    </div>
	<div class="row">
	    <div class="col-lg-3 col-md-6">
	        <div class="panel panel-primary">
	            <div class="panel-heading">
	                <div class="row">
	                    <div class="col-xs-3">
	                        <i class="fa fa-book fa-5x"></i>
	                    </div>
	                    <div class="col-xs-9 text-right">
	                        <div class="huge"><?php echo $articleSentCount; ?></div>
	                        <div>Article Sent</div>
	                    </div>
	                </div>
	            </div>
	            <a href="send_article.php">
	                <div class="panel-footer">
	                    <span class="pull-left">Send Article</span>
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
	            <a href="pending_article.php">
	                <div class="panel-footer">
	                    <span class="pull-left">View Details</span>
	                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                    <div class="clearfix"></div>
	                </div>
	            </a>
	        </div>
	    </div>
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
	                    <span class="pull-left">View Details</span>
	                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                    <div class="clearfix"></div>
	                </div>
	            </a>
	        </div>
	    </div>
	    <div class="col-lg-3 col-md-6">
	        <div class="panel panel-red">
	            <div class="panel-heading">
	                <div class="row">
	                    <div class="col-xs-3">
	                        <i class="fa fa-trash-o fa-5x"></i>
	                    </div>
	                    <div class="col-xs-9 text-right">
	                        <div class="huge"><?php echo $articleRejected; ?></div>
	                        <div>Rejected Article</div>
	                    </div>
	                </div>
	            </div>
	            <a href="rejected_article.php">
	                <div class="panel-footer">
	                    <span class="pull-left">View Details</span>
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
                    Articles Sent
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-hover" id = "writerTable">
                    	<thead style = "dispaly:none;">
	                        <tr>    
	                            <th>&nbsp;</th>

	                        </tr>
	                    </thead>
	                    <tbody>
                		<?php
                			$query = $DB_con->prepare('SELECT *
                									  FROM article_writer
									                  WHERE article_author = :auserid
			                                          ORDER BY timestamp DESC
			                                          LIMIT 5');
			                $query->bindParam(':auserid', $login_session_id);
			                $query->execute();
			                if($query->rowCount() > 0){
				                while($row=$query->fetch(PDO::FETCH_ASSOC)){
				                	extract($row);
				                	switch($status_editor){
				                		case 'Pending':
				                		$approvalTitle = "0% Aproval";
				                		$progressBar = "progress-bar-warning";
				                		$approval = "width: 0%";
				                		break;				                		

				                		case 'Approved':
				                		switch($status_publisher){
				                			case 'Pending':
				                			$approvalTitle = "50% Aproval";
					                		$progressBar = "progress-bar-warning";
					                		$approval = "width: 50%";
				                			break;

				                			case 'Approved':
				                			$approvalTitle = "100% Aproval";
					                		$progressBar = "progress-bar-success";
					                		$approval = "width: 100%";
				                			break;

				                			case 'Rejected':
				                			$approvalTitle = "Rejected";
					                		$progressBar = "progress-bar-danger";
					                		$approval = "width: 50%";
				                			break;
				                		}					                		
				                		break;

				                		case 'Rejected':
				                		$approvalTitle = "Rejected";
				                		$progressBar = "progress-bar-danger";
				                		$approval = "width: 0%";	                		
				                		break;
				                	}                   
                    		?>
	                            <tr href="article_content.php?id=<?php echo $article_writer_id;?>" style = "cursor:pointer;">
	                                <td>
									    <p>
									        <strong><?php echo $title; ?></strong> 
									        <span class="pull-right text-muted"><?php echo $approvalTitle; ?> (<?php echo time_elapsed_string($timestamp); ?>)</span>
									    </p>
									    <div class="progress progress-striped active">
									        <div class="progress-bar <?php echo $progressBar; ?>" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="<?php echo $approval; ?>">
									        </div>
									    </div>
	                                </td>
	                            </tr>
                            <?php
                            	}
                            	?>
                            	<tr href="sent_article.php" style = "cursor:pointer;">
	                                <td colspan = "2" class = "text-center">
					                        <strong>See All Article Sent</strong>
					                        <i class="fa fa-angle-right"></i>
	                                </td>			                                
	                            </tr>

	                            <script>
		                        $('#writerTable').on( 'click', 'tbody tr', function () {
		                        window.location.href = $(this).attr('href');
		                        } );
		                        </script>
		                    <?php
		                    }else{
		                    	?>
		                    	<tr>
	                                <td colspan = "2" class = "text-center">
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
<!-- END class="container container-style" -->
<!-- FOOTER -->
<?php include 'writer_footer.php'; ?>