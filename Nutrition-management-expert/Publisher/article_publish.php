<?php
    require_once '../PHP/dbconfig.php';
    include 'publisher_header.php'; 

    if(isset($_GET['id']) && !empty($_GET['id'])){
		$id = $_GET['id'];
		$stmt = $DB_con->prepare("SELECT article_writer.*, user_info.* 
	                              FROM article_writer
	                              LEFT JOIN user_info
	                                   ON article_writer.article_author = user_info.user_id
	                              WHERE article_writer.article_writer_id = :id");
		$stmt->execute(array(':id'=>$id));
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);
		$articleAuthor = $full_name; //author fullname
	}
	else{
		header("Location: article.php");
	}

	//if the Publisher accepted the article
	if(isset($_POST['btn_save_updates'])){

		//update status_publisher to approved
		$articlePublisher = $login_session_id;
		$statusPublisher = "Approved";
		$timestamp = date('Y-m-d G:i:s');		

		$stmt = $DB_con->prepare('UPDATE article_writer 
							      SET article_publisher=:aarticlepublisher,
							      	  status_publisher=:astatuspublisher,
								      timestamp=:atimestamp								       
						          WHERE article_writer_id=:uid');
 		
 		$stmt->bindParam(':aarticlepublisher',$articlePublisher);
		$stmt->bindParam(':astatuspublisher',$statusPublisher);
		$stmt->bindParam(':atimestamp',$timestamp); 
		$stmt->bindParam(':uid',$id);
		$stmt->execute();

		//insert the new published article in article table
		$article_author_full = "$articleAuthor";
		$article_date = date("Y-m-d");						

		$stmt = $DB_con->prepare('INSERT INTO article(title,article_author,category,content,image,article_date) 
											 VALUES(:atitle, :aauthor, :acategory, :acontent, :aimage, :adate)');
		$stmt->bindParam(':atitle',$title);
		$stmt->bindParam(':aauthor',$article_author_full);
		$stmt->bindParam(':acategory',$category);			
		$stmt->bindParam(':acontent',$content); 
		$stmt->bindParam(':aimage',$image);
		$stmt->bindParam(':adate',$article_date);

		if($stmt->execute()){
			?>
            <script>
			alert('You have Successfully Published this Article ...');
			window.location.href='article.php';
			</script>
            <?php
		}
		else{
			$errMSG = "Sorry Data Could Not Updated !";
		}

		//Send notification to the article author
		$notification = "Your Article($title) has been successfully published by $login_session_fullname.";
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

		//Send notification to the article editor
		$notification = "The Article($title) you've approved/edited has been successfully published by $login_session_fullname.";
		$stmt = $DB_con->prepare('INSERT INTO notifications(notification) 
								  VALUES(:anotification)');
		$stmt->bindParam(':anotification',$notification);
		$stmt->execute();

		$lastId = $DB_con->lastInsertId();
		$stmt = $DB_con->prepare('INSERT INTO notifications_users(user_id, notification_id) 
								  VALUES(:auserid, :anotificationid)');
		$stmt->bindParam(':auserid',$article_editor);
		$stmt->bindParam(':anotificationid',$lastId);
		$stmt->execute();


	}


	//if the Publisher accepted the article
	if(isset($_POST['btn_reject'])){
		//update status_publisher to approved
		$articlePublisher = $login_session_id;
		$statusPublisher = "Rejected";
		$timestamp = date('Y-m-d G:i:s');		

		$stmt = $DB_con->prepare('UPDATE article_writer 
							      SET status_publisher=:astatuspublisher,
								      timestamp=:atimestamp								       
						          WHERE article_writer_id=:uid');
 		
		$stmt->bindParam(':astatuspublisher',$statusPublisher);
		$stmt->bindParam(':atimestamp',$timestamp); 
		$stmt->bindParam(':uid',$id);
		$stmt->execute();

		//Send notification to the article author
		if(isset($_POST['reject_reason']) && !empty($_POST['reject_reason'])){
			$reasonReject = $_POST['reject_reason'];
			$notification = "Your Article($title) has been rejected. Reason: $reasonReject";
			$notificationEditor = "The Article($title) you've approved/edited has been rejected. Reason: $reasonReject";
		}else{
			$notification = "Your Article($title) has been rejected.";
			$notificationEditor = "The Article($title) you've approved/edited has been rejected.";
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

		//Send notification to the article editor
		$stmt = $DB_con->prepare('INSERT INTO notifications(notification) 
								  VALUES(:anotification)');
		$stmt->bindParam(':anotification',$notificationEditor);
		$stmt->execute();

		$lastId = $DB_con->lastInsertId();
		$stmt = $DB_con->prepare('INSERT INTO notifications_users(user_id, notification_id) 
								  VALUES(:auserid, :anotificationid)');
		$stmt->bindParam(':auserid',$article_editor);
		$stmt->bindParam(':anotificationid',$lastId);
		if($stmt->execute()){
			?>
            <script>
			alert('You have Rejected Article ...');
			window.location.href='article.php';
			</script>
            <?php
		}
		else{
			$errMSG = "Sorry Data Could Not Updated !";
		}

	}				
?>

<div class="container container-style">
	<div class="page-header">
	    <?php
		if(isset($errMSG)){
				?>
	            <div class="alert alert-danger">
	            	<span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
	            </div>
	            <?php
		}
		?>
		
	    	

		<form method="post" enctype="multipart/form-data" class="form-horizontal">
				<div class = "col-lg-6" style = "font-size: 200%;">
					Publish Article  /  <a class="btn btn-default" href="article.php">
				    <span class="glyphicon glyphicon-backward"></span> Cancel </a> 				    
				</div>

				<div class = "col-lg-1 col-md-12 col-sm-12 col-xs-12">
			    	<button type="submit" name="btn_save_updates" class="btn btn-success" style = "margin-bottom:10px">
			        	<span class="glyphicon glyphicon-ok"></span> Accept
			        </button>
		    	</div>

		        <div class="input-group col-lg-5">
					<span class="input-group-btn">
				        <button type="submit" name="btn_reject" class="btn btn-danger" style = "margin-left:15px" onclick="return confirm('Are you sure you want to reject this article?')">
				        	<span class="glyphicon glyphicon-remove-circle"></span> Reject
				        </button>
				    </span>
				    <input type="text" name="reject_reason" class="form-control" placeholder = "Reason (optional)"  />
				</div>

		        
	    	
    	</form>
    </div>

	<div id="article-wrapper">
		<div id="article-content">
			<div class="article-img col-sm-12">
				<img src="../Images/<?php echo $row['image']; ?>" class="img-rounded" />
			</div>

			<div id = "article-title">
				<h1 class = "title-page"><?php echo $title; ?></h1>
				<p class = "text-muted"><?php echo $articleAuthor; ?></p>				
			</div>

			<div id = "article-info">
				<p><?php echo $content; ?></p>
			</div>
		</div>
	</div>
</div>
<!-- FOOTER -->
<?php include 'publisher_footer.php'; ?>