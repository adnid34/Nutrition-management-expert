<?php
    require_once '../PHP/dbconfig.php';
    include 'publisher_header.php'; 
?>
<script>
    $(document).ready(function() {
        $('#writerTable').DataTable({
            "order": [[ 3, "desc" ]],
            "columnDefs": [{"orderable": false, "targets": 2}],
            "language": {"emptyTable":"No Pending Article(s) to be shown."},
            responsive: true
        });
    });
</script>
<div class="container container-style">
	    <div class="col-lg-12">
        <div class="panel panel-default">
        	<div class="panel-heading">
                Pending Articles
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="writerTable">
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
                    
                    $row = $DB_con->query("SELECT COUNT(*) FROM article_writer")->fetchColumn();
                    $query = $DB_con->prepare("SELECT article_writer.*, user_info.* 
                                               FROM article_writer
                                               LEFT JOIN user_info
                                                    ON article_writer.article_author = user_info.user_id
                                               WHERE status_publisher = 'Pending'");
                    $query->execute();
                    while($row=$query->fetch(PDO::FETCH_ASSOC)){
                            extract($row);
                    ?>

                        <tr href="article_publish.php?id=<?php echo $article_writer_id; ?>" style = "cursor:pointer;">
                        	
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
    <!-- /.col-lg-12 -->
</div>




<!-- FOOTER -->
<?php include 'publisher_footer.php'; ?>