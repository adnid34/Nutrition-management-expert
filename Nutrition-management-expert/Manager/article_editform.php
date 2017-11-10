<?php	
	require_once '../PHP/dbconfig.php';

	if(isset($_GET['edit_id']) && !empty($_GET['edit_id'])){
		$id = $_GET['edit_id'];
		$stmt_edit = $DB_con->prepare('SELECT * FROM article WHERE article_id =:id');
		$stmt_edit->execute(array(':id'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else{
		header("Location: article.php");
	}
	
	if(isset($_POST['btn_save_updates'])){
		$articleTitle = $_POST['article_title'];
		$articleAuthor = $_POST['article_author'];
		$articleCategory = $_POST['article_category'];
		$articleDate = $_POST['article_date'];
		$articleContent = $_POST['article_content'];
			
		$imgFile = $_FILES['article_image']['name'];
		$tmp_dir = $_FILES['article_image']['tmp_name'];
		$imgSize = $_FILES['article_image']['size'];
					
		if($imgFile){
			$upload_dir = '../Images/'; // upload directory	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
			$image = rand(1000,1000000).".".$imgExt;
			if(in_array($imgExt, $valid_extensions)){			
				if($imgSize < 5000000){
					unlink($upload_dir.$edit_row['image']);
					move_uploaded_file($tmp_dir,$upload_dir.$image);
				}
				else{
					$errMSG = "Sorry, your file is too large it should be less then 5MB";
				}
			}
			else{
				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";		
			}	
		}
		else{
			// if no image selected the old image remain as it is.
			$image = $edit_row['image']; // old image from database
		}	
						
		
		// if no error occured, continue ....
		if(!isset($errMSG)){
			$stmt = $DB_con->prepare('UPDATE article 
									     SET title=:atitle,
									     	 article_author=:aauthor, 
										     category=:acategory,  
										     content=:acontent, 
										     image=:aimage,
										     article_date=:adate
										       
								       WHERE article_id=:uid');
			$stmt->bindParam(':atitle',$articleTitle);
			$stmt->bindParam(':aauthor',$articleAuthor);
			$stmt->bindParam(':acategory',$articleCategory);			
			$stmt->bindParam(':acontent',$articleContent); 
			$stmt->bindParam(':aimage',$image);
			$stmt->bindParam(':adate',$articleDate); 
			$stmt->bindParam(':uid',$id);
				
			if($stmt->execute()){
				?>
                <script>
				alert('Successfully Updated ...');
				window.location.href='article.php';
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
<?php include 'manager_header.php'; ?>


<div class="container">


	<div class="page-header">
    	<h2 class="h2">Edit Article  / <a class="btn btn-default" href="article.php"> <span class="glyphicon glyphicon-backward"></span> Cancel </a></h2>
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
        <td><input class="form-control admin-title-box" type="text" name="article_title" value="<?php echo $title; ?>" required /></td>
    </tr>

    <tr>
    	<td><label class="control-label">Author</label></td>
        <td><input class="form-control admin-title-box" type="test" name="article_author" 
        	value="<?php echo $article_author; ?>" 
        	/></td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Category</label></td>
        <td>
        	<select class="form-control admin-select" type="text" name="article_category">
        			<option <?php if($category == "Kids") echo 'selected';?> value="Kids">Kids</option>
					<option <?php if($category == "Men") echo 'selected';?> value="Men">Men</option>
					<option <?php if($category == "Women") echo 'selected';?> value="Women">Women</option>
					<option <?php if($category == "Seniors") echo 'selected';?> value="Seniors">Seniors</option> 
        	</select>
        </td>
    </tr>

    <tr>
    	<td><label class="control-label">Date Published</label></td>
        <td><input class="form-control admin-date-picker" type="date" name="article_date" value="<?php echo $article_date; ?>" /></td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Image</label></td>
        <td>
        	<p><img src="../Images/<?php echo $image; ?>" height="200" width="200" /></p>

        	<input class="input-group" type="file" name="article_image" accept="image/*" />
        </td>
    </tr>

    <tr>
    	<td><label class="control-label">Content</label></td>
        <div style = "width:100%;"><td><textarea id = "edit" rows = "20" cols = "50" name="article_content" ><?php echo $content; ?></textarea></td></div>
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
<?php include 'manager_footer.php'; ?>