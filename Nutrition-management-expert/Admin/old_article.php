<?php
	require_once '../PHP/dbconfig.php';	
	if(isset($_GET['delete_id'])){
		// image to delete
		$stmt_select = $DB_con->prepare('SELECT image FROM article WHERE article_id =:uid');
		$stmt_select->execute(array(':uid'=>$_GET['delete_id']));
		$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
		unlink("../Images/".$imgRow['image']);
		
		// delete record
		$stmt_delete = $DB_con->prepare('DELETE FROM article WHERE article_id =:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();
		
		header("Location: old_article.php");
	}

?>
<!-- HEADER -->
<?php include 'admin_header.php'; ?>

<div class="container">

	<div class="page-header">
    	<h2 class="h2">Articles </h2> 
    </div>
	<br />

<!-- AJAX SEARCH -->
<div class = "">
	<script>
	function showResult(str) {

		if(str == ""){
			window.location = 'http://localhost/snc/admin/old_article.php';
			abort();
		}
		else{
	        if (window.XMLHttpRequest) {
	            // code for IE7+, Firefox, Chrome, Opera, Safari
	            xmlhttp = new XMLHttpRequest();
	        } else {
	            // code for IE6, IE5
	            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	        }
	        xmlhttp.onreadystatechange = function() {
	            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	                document.getElementById("content").innerHTML = xmlhttp.responseText;
	                document.getElementById("hideThis").style.visibility = "hidden";
	            }
	        }
	        xmlhttp.open("GET","articleResult.php?q="+str+"&test=321",true);
	        xmlhttp.send();
	    }  
	}
	</script>
	<form>
		<div class="has-feedback admin-search">
			<i class="glyphicon glyphicon-search form-control-feedback "></i>
			<input class="form-control admin-txtbox" type="text" name="search" 
			placeholder="Search Article Title or Category" onkeyup="showResult(this.value)">

			<a class="btn btn-success admin-add-btn" href="article_addnew.php"><span class="glyphicon glyphicon-plus"></span> &nbsp; Add New Article </a>
		</div>

	</form>
</div>
<!-- END AJAX SEARCH -->



<div id="content" class="admin-content cleafix" >
	<!-- PAGINATION -->
	<?php
	if(isset($_GET['pr'])){
		$number_per_page = $_GET['pr'];
	}else{
		$number_per_page = 5;
	}
	?>
	<div class = "myPagination row">
		<div class = "col-xs-6">
                <span>Show</span>
                <select class="form-control" type="text" style = "width:15%; display:inline; min-width:65px;" name="number_per_page" id="number_per_page">
                    <option <?php if($number_per_page == "10") echo 'selected';?> value="10">10</option>
                    <option <?php if($number_per_page == "20") echo 'selected';?> value="20">20</option>
                    <option <?php if($number_per_page == "35") echo 'selected';?> value="35">35</option> 
                    <option <?php if($number_per_page == "50") echo 'selected';?> value="50">50</option> 
                </select>
                <span>entries</span>

                
        </div>
		

		<div class = "col-lg-pull-3 pull-right" >
		<?php 
			$queryCount = "SELECT COUNT(*) FROM article";
			$queryResult = "SELECT * FROM article ORDER BY article_date DESC";
			$pageRows = $number_per_page;
			include '../PHP/pagination_function.php';
		?>
		</div>

		<script>
		$('#number_per_page').change(function() {
		    window.location = "http://localhost<?php echo $_SERVER['PHP_SELF']; ?>?pn=<?php echo $_GET['pn']; ?>&pr=" + $(this).val();
		});
		</script>
	</div>
	<!-- END PAGINATION -->
	
<div style = "clear:both;"> </div> 
<?php
	if($query->rowCount() > 0){
		while($row=$query->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			?>
			<div class="col-xs-4" style = "margin-bottom: 25px;">
				<h4 class=""><?php echo " " . $title."<br /><br />For ".$category; ?></h4>
				<img src="../Images/<?php echo $row['image']; ?>" class="img-rounded" width="250px" height="250px" />
				<p class="">
				<br />
				<span>
				<a class="btn btn-info" href="article_editform.php?edit_id=<?php echo $row['article_id']; ?>" title="click for edit"><span class="glyphicon glyphicon-edit"></span> Edit</a> 
				<a class="btn btn-danger" href="?delete_id=<?php echo $row['article_id']; ?>" title="click for delete" onclick="return confirm('Are you sure you want to delete this?')"><span class="glyphicon glyphicon-remove-circle"></span> Delete</a>
				</span>
				</p>
			</div>       
			<?php
		}
	}
	else{
		?>
		<p class="page-header"></p>
        <div class="col-xs-12">
        	<div class="alert alert-warning">
            	<span class="glyphicon glyphicon-info-sign"></span> &nbsp; No Data Found ...
            </div>
        </div>
        <?php
	}
	
?>
</div>	
</div>


<!-- FOOTER -->
<?php include 'admin_footer.php'; ?>