<?php
    require_once '../PHP/dbconfig.php';
    

    if(isset($_GET['archive_id'])){  
    //move article in article_archived table
    $stmt = $DB_con->prepare('SELECT * FROM article_archived WHERE article_archived_id =:uid');
    $stmt->bindParam(':uid',$_GET['archive_id']);
    $stmt->execute();
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);

    $stmt = $DB_con->prepare('INSERT INTO article(title,article_author,category,content,image,article_date) 
                                     VALUES(:atitle, :aauthor, :acategory, :acontent, :aimage, :adate)');
    $stmt->bindParam(':atitle',$title);
    $stmt->bindParam(':aauthor',$article_author);
    $stmt->bindParam(':acategory',$category);            
    $stmt->bindParam(':acontent',$content);
    $stmt->bindParam(':aimage',$image);    
    $stmt->bindParam(':adate',$article_date);
    $stmt->execute();

    // delete article in article table
    $stmt = $DB_con->prepare('DELETE FROM article_archived WHERE article_archived_id =:uid');
    $stmt->bindParam(':uid',$_GET['archive_id']);
    $stmt->execute();
    
    header("Location: article_archived.php");
    } 
?>

<!-- HEADER -->
<?php include 'manager_header.php'; ?>
<script>
    $(document).ready(function() {
        $('#writerTable').DataTable({
            "columnDefs": [{"orderable": false, "targets": [2, 3]}],
            "language": {"emptyTable":"No Pending Article(s) to be shown."},
            responsive: true
        });
    });
</script>
<div class="container container-style">
	    <div class="col-lg-12">
        <div class="panel panel-default">
        	<div class="panel-heading">
                Archived Articles
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="writerTable">
                    <thead>
                        <tr> 
                            <th>Title</th>
                            <th>Category</th>  
                            <th>Image</th>                          
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    <?php
                    
                    $row = $DB_con->query("SELECT COUNT(*) FROM article_archived")->fetchColumn();
                    $query = $DB_con->prepare("SELECT * FROM article_archived");
                    $query->execute();
                    while($row=$query->fetch(PDO::FETCH_ASSOC)){
                            extract($row);
                    ?>

                        <tr class="">
                            
                            <td><?php echo $title; ?></td>
                            <td><?php echo $category; ?></td>
                            <td><img src="../Images/<?php echo $row['image']; ?>" class="img-rounded" width="150px" height="150px" /></td>
                            <td>
                            <a class="btn btn-primary" href="article_content.php?id=<?php echo $row['article_archived_id']; ?>" title="Click to view"><span class="glyphicon glyphicon-eye-open"></span> View</a> 
                            <a class="btn btn-success" href="?archive_id=<?php echo $row['article_archived_id']; ?>" title="Click to unarchive" onclick="return confirm('Are you sure you want to unarchive this?')"><span class="glyphicon glyphicon-folder-open"></span> &nbsp; Unarchive</a>
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
    <!-- /.col-lg-12 -->
</div>




<!-- FOOTER -->
<?php include 'manager_footer.php'; ?>