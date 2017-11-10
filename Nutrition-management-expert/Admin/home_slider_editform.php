<?php
	require_once '../PHP/dbconfig.php';

	if(isset($_GET['edit_id']) && !empty($_GET['edit_id'])){
		$id = $_GET['edit_id'];
		$stmt_edit = $DB_con->prepare('SELECT * FROM slider WHERE slider_id =:id');
		$stmt_edit->execute(array(':id'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else{
		header("Location: home_slider.php");
	}
	
	if(isset($_POST['btn_save_updates'])){
		$sliderTitle = $_POST['slider_title'];
		$sliderContent = $_POST['slider_content'];
			
		$imgFile = $_FILES['slider_image']['name'];
		$tmp_dir = $_FILES['slider_image']['tmp_name'];
		$imgSize = $_FILES['slider_image']['size'];
					
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
			$stmt = $DB_con->prepare('UPDATE slider 
									     SET title=:atitle,
										     content=:acontent, 
										     image=:aimage
										       
								       WHERE slider_id=:uid');
			$stmt->bindParam(':atitle',$sliderTitle);			
			$stmt->bindParam(':acontent',$sliderContent); 
			$stmt->bindParam(':aimage',$image);
			$stmt->bindParam(':uid',$id);
				
			if($stmt->execute()){
				?>
                <script>
				alert('Successfully Updated ...');
				window.location.href='home_slider.php';
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
    	<h2 class="h2">Edit Slider Page  / <a class="btn btn-default" href="home_slider.php"> <span class="glyphicon glyphicon-backward"></span> Cancel </a></h2>
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
        <td><input class="form-control admin-title-box" type="text" name="slider_title" value="<?php echo $title; ?>" required /></td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Image</label></td>
        <td>
        	<p><img src="../Images/<?php echo $image; ?>" height="200" width="200" /></p>

        	<input class="input-group" type="file" name="slider_image" accept="image/*" />
        </td>
    </tr>

    <tr>
    	<td><label class="control-label">Content</label></td>
        <div style = "width:100%;"><td><textarea id = "edit-2" rows = "20" cols = "50" name="slider_content" ><?php echo $content; ?></textarea></td></div>
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