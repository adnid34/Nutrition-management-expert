<?php
    require_once '../PHP/dbconfig.php';
    include 'writer_header.php'; 
?>
<script>
    $(document).ready(function() {
        $('#writerTable').DataTable({
	        "ordering": false,
	        "info":     false,
	        "language": {"emptyTable":"No Sent Aritcle to be shown."},
	        responsive: true
        });
    });
</script>
<div class="container container-style">
	<div class="row">
        <div class="col-lg-12">
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
	                            <script>
		                        $('#writerTable').on( 'click', 'tbody tr', function () {
		                        window.location.href = $(this).attr('href');
		                        } );
		                        </script>
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
<?php include 'writer_footer.php'; ?>