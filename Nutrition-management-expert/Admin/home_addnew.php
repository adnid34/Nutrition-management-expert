<?php
	require_once '../PHP/dbconfig.php';

	
	if(isset($_POST['btnsave'])){
		$homeTitle = $_POST['home_title'];
		$homeContent = $_POST['home_content'];
		
		
		if(empty($homeTitle)){
			$errMSG = "Please Enter Title.";
		}
		else if(empty($homeContent)){
			$errMSG = "Please Enter Content.";
		}
		
		// if no error occured, continue ....
		if(!isset($errMSG)){
			$stmt = $DB_con->prepare('INSERT INTO home(title,content) 
											 VALUES(:atitle, :acontent)');
			$stmt->bindParam(':atitle',$homeTitle);			
			$stmt->bindParam(':acontent',$homeContent);
			
			if($stmt->execute()){
				$successMSG = "New Home Content Succesfully Inserted...";
				header("refresh:2;home.php"); // redirects image view page after x seconds.
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
    	<h2 class="h2">Add Home Page Content  / <a class="btn btn-default" href="home.php"> <span class="glyphicon glyphicon-backward"></span> Cancel </a></h2>    	
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
        <td><input class="form-control admin-title-box" type="text" id="home_title" name="home_title" 
        	value="<?php echo htmlspecialchars($_POST['home_title']); ?>"/></td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Content</label></td>
        <td><textarea id="edit" rows = "120" cols = "150" name="home_content">
        	<?php echo htmlspecialchars($_POST['home_content']); ?></textarea></td>
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