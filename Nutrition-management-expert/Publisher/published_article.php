<?php
    require_once '../PHP/dbconfig.php';
    include 'publisher_header.php'; 
?>
<script>
    $(document).ready(function() {
        $('#writerTable').DataTable({
	        "ordering": false,
	        "info":     false,	        
	        "language": {"emptyTable":"No Published Aritcle to be shown."},
	        responsive: true
        });
    });
</script>
<div class="container container-style">
	<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Published Articles
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id = "writerTable">
                    	<thead>
                        <tr>    
                            <th>Title</th>
                            <th>Author</th>
                            <th>Image</th>
                            <th>Time</th>

                        </tr>
                    </thead>
	                    <tbody>
                		<?php
                			$status = 'Approved';
                			$query = $DB_con->prepare('SELECT *
                									  FROM article_writer
									                  WHERE article_publisher = :auserid
									                  AND status_editor = :astatuseditor
									                  AND status_publisher = :astatuspublisher
			                                          ORDER BY timestamp DESC');
			                $query->bindParam(':auserid', $login_session_id);
			                $query->bindParam(':astatuseditor', $status);
			                $query->bindParam(':astatuspublisher', $status);
			                $query->execute();
			                
				                while($row=$query->fetch(PDO::FETCH_ASSOC)){
				                	extract($row);                  
                    		?>
	                            <tr href="article_content.php?id=<?php echo $article_writer_id; ?>" style = "cursor:pointer;">
		                        	
		                            <td><?php echo $title; ?></td>
		                            <td><?php echo $full_name; ?></td>
		                            <td><img src="../Images/<?php echo $row['image']; ?>" class="img-rounded" width="150px" height="150px" /></td>
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