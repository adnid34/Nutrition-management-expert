<?php	
	require_once '../PHP/dbconfig.php';

	if(isset($_GET['edit_id']) && !empty($_GET['edit_id'])){
		$id = $_GET['edit_id'];
		$stmt_edit = $DB_con->prepare('SELECT * FROM home WHERE home_id =:id');
		$stmt_edit->execute(array(':id'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else{
		header("Location: home.php");
	}
	
	if(isset($_POST['btn_save_updates'])){
		$homeTitle = $_POST['home_title'];
		$homeContent = $_POST['home_content'];	
		
		// if no error occured, continue ....
		if(!isset($errMSG)){
			$stmt = $DB_con->prepare('UPDATE home 
									     SET title=:atitle,
										     content=:acontent
										       
								       WHERE home_id=:uid');
			$stmt->bindParam(':atitle',$homeTitle);			
			$stmt->bindParam(':acontent',$homeContent);
			$stmt->bindParam(':uid',$id);
				
			if($stmt->execute()){
				?>
                <script>
				alert('Successfully Updated ...');
				window.location.href='home.php';
				</script>
                <?php
			}
			else{
				$errMSG = "Sorry Data Could Not Updated !";
			}
		}								
	}	
?>
<!-- HEADER -->
<?php include 'admin_header.php'; ?>


<div class="container">


	<div class="page-header">
    	<h2 class="h2">Edit Home Content  / <a class="btn btn-default" href="home.php"> <span class="glyphicon glyphicon-backward"></span> Cancel </a></h2>
    </div>

<div class="clearfix"></div>

<form method="post" enctype="multipart/form-data" class="form-horizontal">
	
    
    <?php
	if(isset($errMSG)){
			?>
            <div class="alert alert-danger">
            	<span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
            </div>
            <?php
	}
	?>
   
    
	<table class="table table-bordered table-responsive">
	
    <tr>
    	<td><label class="control-label">Title</label></td>
        <td><input class="form-control admin-title-box" type="text" name="home_title" value="<?php echo $title; ?>" required /></td>
    </tr>

    <tr>
    	<td><label class="control-label">Content</label></td>
        <div style = "width:100%;"><td><textarea id = "edit" rows = "20" cols = "50" name="home_content" ><?php echo $content; ?></textarea></td></div>
    </tr>

    
    <tr>
        <td colspan="2"><button type="submit" name="btn_save_updates" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Update
        </button>
        </td>
    </tr>
    
    </table>
    
</form>

</div>


<!-- FOOTER -->
<?php include 'admin_footer.php'; ?>