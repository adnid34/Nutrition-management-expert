<?php
	require_once '../PHP/dbconfig.php';
	include 'writer_header.php';
	
	if(isset($_POST['btnsave'])){
		$articleTitle = $_POST['article_title'];
		$articleAuthor = $login_session_id;
		$articleCategory = $_POST['article_category'];
		$articleContent = $_POST['article_content'];
		

		$imgFile = $_FILES['article_image']['name'];
		$tmp_dir = $_FILES['article_image']['tmp_name'];
		$imgSize = $_FILES['article_image']['size'];
		
		
		if(empty($articleTitle)){
			$errMSG = "Please Enter Title.";
		}
		else if(empty($articleCategory)){
			$errMSG = "Please Choose Category.";
		}
		else if(empty($imgFile)){
			$errMSG = "Please Select Image File.";
		}
		else if(empty($articleContent)){
			$errMSG = "Please Enter Content.";
		}
		else{
			$upload_dir = '../Images/'; // upload directory
	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		
			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
		
			// rename uploading image
			$image = rand(1000,1000000).".".$imgExt;
				
			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions)){			
				// Check file size '5MB'
				if($imgSize < 5000000)				{
					move_uploaded_file($tmp_dir,$upload_dir.$image);
				}
				else{
					$errMSG = "Sorry, your file is too large.";
				}
			}
			else{
				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";		
			}
		}
		
		
		// if no error occured, continue ....
		if(!isset($errMSG)){
			$stmt = $DB_con->prepare('INSERT INTO article_writer(title,article_author,category,content,image) 
											 VALUES(:atitle, :aauthor, :acategory, :acontent, :aimage)');
			$stmt->bindParam(':atitle',$articleTitle);
			$stmt->bindParam(':aauthor',$articleAuthor);
			$stmt->bindParam(':acategory',$articleCategory);			
			$stmt->bindParam(':acontent',$articleContent);
			$stmt->bindParam(':aimage',$image);
			
			if($stmt->execute()){
				$successMSG = "Article has succesfully sent...";
				?><script>setTimeout(function(){window.location.href="index.php"},2000);</script><?php
			}
			else{
				$errMSG = "Error While Inserting....";
			}
		}
	}
?>

<div class="container">
	<div class="page-header">
    	<h2 class="h2">Send Article  / <a class="btn btn-default" href="index.php"> <span class="glyphicon glyphicon-backward"></span> Cancel </a></h2>    	
    </div>
<?php
	if(isset($errMSG)){
			?>
            <div class="alert alert-danger">
            	<span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
            </div>
            <?php
	}
	else if(isset($successMSG)){
		?>
        <div class="alert alert-success">
              <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
        </div>
        <?php
	}
	?>   

<form method="post" enctype="multipart/form-data" class="form-horizontal">
	    
	<table class="table table-bordered table-responsive">
	
    <tr>
    	<td><label class="control-label">Title</label></td>
        <td><input class="form-control admin-title-box" type="text" id="article_title" name="article_title" 
        	value="<?php echo htmlspecialchars($_POST['article_title']); ?>"/></td>
    </tr>

	<tr>
    	<td><label class="control-label">Category</label></td>
        <td>
        	<select class="form-control admin-select" type="text" style = "width:30%;" name="article_category">
        			<option <?php if($articleCategory == "Kids") echo 'selected';?> value="Kids">Kids</option>
					<option <?php if($articleCategory == "Men") echo 'selected';?> value="Men">Men</option>
					<option <?php if($articleCategory == "Women") echo 'selected';?> value="Women">Women</option>
					<option <?php if($articleCategory == "Seniors") echo 'selected';?> value="Seniors">Seniors</option> 
        	</select>
        </td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Article Image</label></td>
        <td><input class="input-group" type="file" name="article_image" accept="image/*"/></td>
    </tr>
    <tr>
    	<td><label class="control-label">Content</label></td>
        <td><textarea id="edit" rows = "120" cols = "150" name="article_content">
        	<?php echo htmlspecialchars($_POST['article_content']); ?></textarea></td>
    </tr>


    
    <tr>
        <td colspan="2"><button type="submit" name="btnsave" class="btn btn-default">
        <span class="fa fa-send"></span> &nbsp; send
        </button>
        </td>
    </tr>
    
    </table>
    
</form>
</div>

<!-- FOOTER -->
<?php include 'writer_footer.php'; ?>