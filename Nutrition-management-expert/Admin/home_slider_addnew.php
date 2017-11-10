<?php
	require_once '../PHP/dbconfig.php';

	
	if(isset($_POST['btnsave'])){
		$sliderTitle = $_POST['slider_title'];
		$sliderContent = $_POST['slider_content'];
		

		$imgFile = $_FILES['slider_image']['name'];
		$tmp_dir = $_FILES['slider_image']['tmp_name'];
		$imgSize = $_FILES['slider_image']['size'];
		
		
		if(empty($sliderTitle)){
			$errMSG = "Please Enter Title.";
		}
		else if(empty($imgFile)){
			$errMSG = "Please Select Image File.";
		}
		else if(empty($sliderContent)){
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
			$stmt = $DB_con->prepare('INSERT INTO slider(title,content,image) 
											 VALUES(:atitle, :acontent, :aimage)');
			$stmt->bindParam(':atitle',$sliderTitle);			
			$stmt->bindParam(':acontent',$sliderContent); 
			$stmt->bindParam(':aimage',$image);
			
			if($stmt->execute()){
				$successMSG = "New Slider Page Succesfully Inserted...";
				header("refresh:2;home_slider.php"); // redirects image view page after x seconds.
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
    	<h2 class="h2">Add New Slider Page  / <a class="btn btn-default" href="home_slider.php"> <span class="glyphicon glyphicon-backward"></span> Cancel </a></h2>    	
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
        <td><input class="form-control admin-title-box" type="text" id="slider_title" name="slider_title" 
        	value="<?php echo htmlspecialchars($_POST['slider_title']); ?>"/></td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Image</label></td>
        <td><input class="input-group" type="file" name="slider_image" accept="image/*"/></td>
    </tr>
    <tr>
    	<td><label class="control-label">Content</label></td>
        <td><textarea id="edit-2" rows = "120" cols = "150" name="slider_content">
        	<?php echo htmlspecialchars($_POST['slider_content']); ?></textarea></td>
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