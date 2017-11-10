<?php
	require_once '../PHP/dbconfig.php';	
    
	if(isset($_GET['archive_id'])){  
    //move article in article_archived table
    $stmt = $DB_con->prepare('SELECT * FROM article WHERE article_id =:uid');
    $stmt->bindParam(':uid',$_GET['archive_id']);
    $stmt->execute();
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);

    $stmt = $DB_con->prepare('INSERT INTO article_archived(title,article_author,category,content,image,article_date) 
                                     VALUES(:atitle, :aauthor, :acategory, :acontent, :aimage, :adate)');
    $stmt->bindParam(':atitle',$title);
    $stmt->bindParam(':aauthor',$article_author);
    $stmt->bindParam(':acategory',$category);            
    $stmt->bindParam(':acontent',$content);
    $stmt->bindParam(':aimage',$image);    
    $stmt->bindParam(':adate',$article_date);
    $stmt->execute();

    // delete article in article table
    $stmt = $DB_con->prepare('DELETE FROM article WHERE article_id =:uid');
    $stmt->bindParam(':uid',$_GET['archive_id']);
    $stmt->execute();
	
	header("Location: article.php");
	}

?>
<!-- HEADER -->
<?php include 'manager_header.php'; ?>



<div class="container">

	<div class="page-header">
    	<h2 class="h2">Articles </h2> 
    </div>
	<br />
	<div class="has-feedback admin-search">
		<a class="btn btn-success admin-add-btn" href="article_addnew.php"><span class="glyphicon glyphicon-plus"></span> &nbsp; Add New Article </a>
	</div>
<div id="content" class="admin-content cleafix" >
	<!-- /.row -->
<div class="row">

    <div class="col-lg-12">
        <div class="panel panel-default">

            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTable">
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
                    
                    $row = $DB_con->query("SELECT COUNT(*) FROM article")->fetchColumn();
                    $query = $DB_con->prepare("SELECT * FROM article");
                    $query->execute();
                    while($row=$query->fetch(PDO::FETCH_ASSOC)){
                            extract($row);
                    ?>

                        <tr class="">
                        	
                            <td><?php echo $title; ?></td>
                            <td><?php echo $category; ?></td>
                            <td><img src="../Images/<?php echo $row['image']; ?>" class="img-rounded" width="150px" height="150px" /></td>
                            <td>
                            <a class="btn btn-info" href="article_editform.php?edit_id=<?php echo $row['article_id']; ?>" title="Click to edit"><span class="glyphicon glyphicon-edit"></span> Edit</a> 
                            <a class="btn btn-primary" href="?archive_id=<?php echo $row['article_id']; ?>" title="Click to archive" onclick="return confirm('Are you sure you want to archive this?')"><span class="fa fa-archive"></span> Archive</a>
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

</div>	
</div>



<!-- FOOTER -->
<?php include 'manager_footer.php'; ?>