<?php
	require_once '../PHP/dbconfig.php';

	
	if(isset($_POST['btnsave'])){
		$articleTitle = $_POST['article_title'];
		$articleAuthor = $_POST['article_author'];
		$articleDate = $_POST['article_date'];
		$articleCategory = $_POST['article_category'];
		$articleContent = $_POST['article_content'];
		

		$imgFile = $_FILES['article_image']['name'];
		$tmp_dir = $_FILES['article_image']['tmp_name'];
		$imgSize = $_FILES['article_image']['size'];
		
		
		if(empty($articleTitle)){
			$errMSG = "Please Enter Title.";
		}
		else if(empty($articleAuthor)){
			$errMSG = "Please Enter The Author.";
		}
		else if(empty($articleCategory)){
			$errMSG = "Please Choose Category.";
		}
		else if(empty($articleDate)){
			$errMSG = "Please Enter Date.";
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
			$stmt = $DB_con->prepare('INSERT INTO article(title,article_author,category,content,image,article_date) 
											 VALUES(:atitle, :aauthor, :acategory, :acontent, :aimage, :adate)');
			$stmt->bindParam(':atitle',$articleTitle);
			$stmt->bindParam(':aauthor',$articleAuthor);
			$stmt->bindParam(':acategory',$articleCategory);			
			$stmt->bindParam(':acontent',$articleContent); 
			$stmt->bindParam(':aimage',$image);
			$stmt->bindParam(':adate',$articleDate);
			
			if($stmt->execute()){
				$successMSG = "New Article Succesfully Inserted...";
				header("refresh:2;article.php"); // redirects image view page after x seconds.
			}
			else{
				$errMSG = "Error While Inserting....";
			}
		}
	}
?>

<!-- HEADER -->
<?php include 'admin_header.php'; ?>

<div class="container">
	<div class="page-header">
    	<h2 class="h2">Add New Article  / <a class="btn btn-default" href="article.php"> <span class="glyphicon glyphicon-backward"></span> Cancel </a></h2>    	
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
    	<td><label class="control-label">Author</label></td>
        <td><input class="form-control admin-title-box" type="test" name="article_author" 
        	value="<?php echo htmlspecialchars($_POST['article_author']); ?>" 
        	/></td>
    </tr>

    <tr>
    	<td><label class="control-label">Date Published</label></td>
        <td><input class="form-control admin-date-picker" type="date" name="article_date" 
        	value="<? echo htmlspecialchars($_POST['article_date']); ?>"/></td>
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
    	<td><label class="control-label">Image</label></td>
        <td><input class="input-group" type="file" name="article_image" accept="image/*"/></td>
    </tr>
    <tr>
    	<td><label class="control-label">Content</label></td>
        <td><textarea id="edit" rows = "120" cols = "150" name="article_content">
        	<?php echo htmlspecialchars($_POST['article_content']); ?></textarea></td>
    </tr>


    
    <tr>
        <td colspan="2"><button type="submit" name="btnsave" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> &nbsp; save
        </button>
        </td>
    </tr>
    
    </table>
    
</form>
</div>

<!-- FOOTER -->
<?php include 'admin_footer.php'; ?>