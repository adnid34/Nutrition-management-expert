<?php
	require_once 'PHP/dbconfig.php';
	include 'header.php'; // HEADER
?>



<div class="container">
	<div id="article-wrapper">

		<div class = "title-line-style">
			<h1>For Kids</h1>
		</div>

		<!-- AJAX SEARCH -->
		<div class = "article-category-search col-lg-12">			
			<script>
			function showResult(str) {

				if(str == ""){
					
					window.location = '<?php echo "$_SERVER[REQUEST_URI]"; ?>';

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
			                document.getElementById("article-content").innerHTML = xmlhttp.responseText;
			            }
			        }
			        xmlhttp.open("GET","article_category_result.php?q="+str+"&category=<?php echo $_SERVER['PHP_SELF'];?>",true);
			        xmlhttp.send();
			    }  
			}
			</script>

			<form>
			<div class="has-feedback admin-search">
				<i class="glyphicon glyphicon-search form-control-feedback "></i>
				<input class="form-control admin-txtbox" type="text" name="search" 
				placeholder="Search" onkeyup="showResult(this.value)">
			</div>
			</form>
			
		</div> <!-- END AJAX SEARCH -->

		<div id="article-content">
			<!-- PAGINATION -->
			<?php
			if(isset($_GET['pr'])){
				$number_per_page = $_GET['pr'];
			}else{
				$number_per_page = 5;
			}
			?>
			<div class = "row">
				
				

				<div class = "article-category-nav col-lg-9 col-sm-12 col-xs-12">
				<?php 
					$queryCount = "SELECT COUNT(*) FROM article WHERE category = 'Kids'";
					$queryResult = "SELECT * FROM article WHERE category = 'Kids' ORDER BY article_date DESC";
					$pageRows = $number_per_page;

					include 'PHP/pagination_function.php';


				?>
				</div>

				

				<div class = "article-category-nav col-lg-3 col-sm-12 col-xs-12">
		                <span>Show</span>
		                <select class="form-control" type="text" style = "width:15%; display:inline; min-width:65px;" name="number_per_page" id="number_per_page">
		                    <option <?php if($number_per_page == "5") echo 'selected';?> value="5">5</option>
		                    <option <?php if($number_per_page == "10") echo 'selected';?> value="10">10</option>
		                    <option <?php if($number_per_page == "15") echo 'selected';?> value="15">15</option> 
		                    <option <?php if($number_per_page == "20") echo 'selected';?> value="20">20</option>
		                </select>
		                <span>entries</span>
		        <script>
				$('#number_per_page').change(function() {
				    window.location = "<?php echo $_SERVER['PHP_SELF']; ?>?pn=<?php echo $_GET['pn']; ?>&pr=" + $(this).val();
				});
				</script>
		                
	            </div>


			</div>
			<!-- END PAGINATION -->



			<div class="animated-btn">
				<?php
					if($query->rowCount() > 0){
						while($row=$query->fetch(PDO::FETCH_ASSOC)){
							extract($row);
				?>

					<a href="article_content.php?id=<?php echo $article_id; ?>" class="article-category-btn btn-radius">
						<div class = "left">
							<img src="Images/<?php echo $row['image']; ?>" class="img-rounded left-img" />
						</div>

						<div class = "right" >
							<h2><?php echo  $title; ?></h2>
							<p>By <?php echo $article_author; ?></p>
						</div>

					</a>

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

			</div>	<!-- class="animated-btn" END -->
			<?php include 'PHP/pagination_function.php'; ?> <!-- pagination in bottom -->
		</div>	<!-- id="article-content" END -->
	</div>	<!-- id="article-wrapper" END -->
</div> <!-- class="container" END -->


<?php include 'footer.php'; // FOOTER ?>