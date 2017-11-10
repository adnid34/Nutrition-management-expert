<?php	
	require_once '../PHP/dbconfig.php';
	include 'editor_header.php';

	if(isset($_GET['edit_id']) && !empty($_GET['edit_id'])){
		$id = $_GET['edit_id'];
		$stmt_edit = $DB_con->prepare('SELECT article_writer.*, user_info.* 
                                       FROM article_writer
                                       LEFT JOIN user_info
                                            ON article_writer.article_author = user_info.user_id
                                       WHERE article_writer.article_writer_id = :id');
		$stmt_edit->execute(array(':id'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else{
		header("Location: article.php");
	}
	
	//if the Editor accepted the article
	if(isset($_POST['btn_save_updates'])){
		$articleTitle = $_POST['article_title'];
		$articleEditor = $login_session_id;
		$articleCategory = $_POST['article_category'];
		$articleContent = $_POST['article_content'];		
		$statusEditor = "Approved";
		$statusPublisher = "Pending";
		$timestamp = date('Y-m-d G:i:s');

			
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
			$stmt = $DB_con->prepare('UPDATE article_writer 
									     SET title=:atitle,
									     	 article_editor=:aeditor, 
										     category=:acategory,  
										     content=:acontent, 
										     image=:aimage,
										     status_editor=:astatuseditor, 
										     status_publisher=:statuspublisher,
										     timestamp=:atimestamp
										       
								       WHERE article_writer_id=:uid');
			$stmt->bindParam(':atitle',$articleTitle);
			$stmt->bindParam(':aeditor',$articleEditor);
			$stmt->bindParam(':acategory',$articleCategory);			
			$stmt->bindParam(':acontent',$articleContent); 
			$stmt->bindParam(':aimage',$image);
			$stmt->bindParam(':astatuseditor',$statusEditor); 
			$stmt->bindParam(':statuspublisher',$statusPublisher);
			$stmt->bindParam(':atimestamp',$timestamp); 
			$stmt->bindParam(':uid',$id);
				
			if($stmt->execute()){
				?>
                <script>
				alert('You have Successfully Accepted and Edited this Article ...');
				window.location.href='article.php';
				</script>
                <?php
			}
			else{
				$errMSG = "Sorry Data Could Not Updated !";
			}
		}

		//Send notification to the article author
		$notification = "Your Article($title) has been approved/edited by $login_session_fullname.";
		$stmt = $DB_con->prepare('INSERT INTO notifications(notification) 
								  VALUES(:anotification)');
		$stmt->bindParam(':anotification',$notification);
		$stmt->execute();

		$lastId = $DB_con->lastInsertId();
		$stmt = $DB_con->prepare('INSERT INTO notifications_users(user_id, notification_id) 
								  VALUES(:auserid, :anotificationid)');
		$stmt->bindParam(':auserid',$article_author);
		$stmt->bindParam(':anotificationid',$lastId);
		$stmt->execute();
	}	



	//if the editor rejected this article
	if(isset($_POST['btn_reject'])){
		$statusEditor = "Rejected";
		$timestamp = date('Y-m-d G:i:s');

		
		// if no error occured, continue ....
		$stmt = $DB_con->prepare('UPDATE article_writer 
								     SET status_editor=:astatuseditor,
									     timestamp=:atimestamp
									       
							       WHERE article_writer_id=:uid');

		$stmt->bindParam(':astatuseditor',$statusEditor);
		$stmt->bindParam(':atimestamp',$timestamp); 
		$stmt->bindParam(':uid',$id);
			
		if($stmt->execute()){
			?>
            <script>
			alert('You have Rejected this Article ...');
			window.location.href='article.php';
			</script>
            <?php
		}
		else{
			$errMSG = "Sorry Data Could Not Updated !";
		}

		//Send notification to the article author
		if(isset($_POST['reject_reason']) && !empty($_POST['reject_reason'])){
			$reasonReject = $_POST['reject_reason'];
			$notification = "Your Article($title) has been rejected. Reason: $reasonReject";
		}else{
			$notification = "Your Article($title) has been rejected.";
		}
		
		$stmt = $DB_con->prepare('INSERT INTO notifications(notification) 
								  VALUES(:anotification)');
		$stmt->bindParam(':anotification',$notification);
		$stmt->execute();

		$lastId = $DB_con->lastInsertId();
		$stmt = $DB_con->prepare('INSERT INTO notifications_users(user_id, notification_id) 
								  VALUES(:auserid, :anotificationid)');
		$stmt->bindParam(':auserid',$article_author);
		$stmt->bindParam(':anotificationid',$lastId);
		$stmt->execute();

	}
?>



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
        <td>
        	<button type="submit" name="btn_save_updates" class="btn btn-success">
	        	<span class="glyphicon glyphicon-ok"></span> Accept
	        </button>
        </td>
        <td>
        	<div class="input-group">
				<span class="input-group-btn">
			        <button type="submit" name="btn_reject" class="btn btn-danger" onclick="return confirm('Are you sure you want to reject this article?')">
			        	<span class="glyphicon glyphicon-remove-circle"></span> Reject
			        </button>
			    </span>
			    <input type="text" name="reject_reason" class="form-control" placeholder = "Reason (optional)"  />
			</div>
        </td>
    </tr>
    
    </table>
    
</form>

</div>


<!-- FOOTER -->
<?php include 'editor_footer.php'; ?>