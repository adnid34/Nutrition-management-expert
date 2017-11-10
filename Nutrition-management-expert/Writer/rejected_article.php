<?php
    require_once '../PHP/dbconfig.php';
    include 'writer_header.php'; 
?>
<script>
    $(document).ready(function() {
        $('#writerTable').DataTable({
	        "ordering": false,
	        "info":     false,	        
	        "language": {"emptyTable":"No Pending Aritcle to be shown."},
	        responsive: true
        });
    });
</script>
<div class="container container-style">
	<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Pending Articles
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
                			$status = 'Rejected';
                			$query = $DB_con->prepare('SELECT *
                									  FROM article_writer
									                  WHERE article_author = :auserid
									                  AND status_editor = :astatuseditor
			                                          ORDER BY timestamp DESC');
			                $query->bindParam(':auserid', $login_session_id);
			                $query->bindParam(':astatuseditor', $status);
			                $query->execute();
			                
				                while($row=$query->fetch(PDO::FETCH_ASSOC)){
				                	extract($row);                  
                    		?>
	                            <tr href="article_content.php?id=<?php echo $article_writer_id;?>" style = "cursor:pointer;">
	                                <td>
									    <p>
									        <strong><?php echo $title; ?></strong> 
									        <span class="pull-right text-muted">Rejected (<?php echo time_elapsed_string($timestamp); ?>)</span>
									    </p>
									    <div class="progress progress-striped active">
									        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
									        </div>
									    </div>
	                                </td>
	                            </tr>
                            <?php
                            	}

                			$query = $DB_con->prepare('SELECT *
                									  FROM article_writer
									                  WHERE article_author = :auserid
									                  AND status_publisher = :astatuspublisher
			                                          ORDER BY timestamp DESC');
			                $query->bindParam(':auserid', $login_session_id);
			                $query->bindParam(':astatuspublisher', $status);
			                $query->execute();
			                
				                while($row=$query->fetch(PDO::FETCH_ASSOC)){
				                	extract($row);                  
                    		?>
	                            <tr href="article_content.php?id=<?php echo $article_writer_id;?>" style = "cursor:pointer;">
	                                <td>
									    <p>
									        <strong><?php echo $title; ?></strong> 
									        <span class="pull-right text-muted">Rejected (<?php echo time_elapsed_string($timestamp); ?>)</span>
									    </p>
									    <div class="progress progress-striped active">
									        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
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