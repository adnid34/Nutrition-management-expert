<?php
    require_once '../PHP/dbconfig.php';
    include 'manager_header.php'; 

    $articleCount = $DB_con->query("SELECT COUNT(*) FROM article")->fetchColumn();
    $articleCategoryArray = array("Kids", "Men", "Women", "Seniors");
    $articleCategoryCount = COUNT($articleCategoryArray);
    $article = array(3);
    for($x = 0; $x < $articleCategoryCount; $x++){
        $stmtArticle = "SELECT COUNT(*) FROM article WHERE category = '$articleCategoryArray[$x]'";
        $article[$x] = $DB_con->query($stmtArticle)->fetchColumn();
    }

    $foodsCount = $DB_con->query("SELECT COUNT(*) FROM foods")->fetchColumn();
    $foodsCategoryArray = array("Meat", "Vegetables", "Grains, beans and legumes", "Beverages", "Dairy", "Sugary Foods", "Other");
    $foodsCategoryCount = COUNT($foodsCategoryArray);
    $foods = array(5);
    for($x = 0; $x < $foodsCategoryCount; $x++){
        $stmtFoods = "SELECT COUNT(*) FROM foods WHERE category = '$foodsCategoryArray[$x]'";
        $foods[$x] = $DB_con->query($stmtFoods)->fetchColumn();
    }
    
    $archiveCount = $DB_con->query("SELECT COUNT(*) FROM article_archived")->fetchColumn();  
    $userCount = $DB_con->query("SELECT COUNT(*) FROM user WHERE role != 'Admin' AND role != 'Manager'")->fetchColumn();


?>

<div  class="container container-style" >

	<div class="page-header">
    	<div class="page-header">
    		<h2 class="h2">Welcome <?php echo $login_session_fullname;?>!</h2> 
	    </div>
		<br />
    	<!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-book fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div style = "font-size:34px;"><?php echo $articleCount;?></div>
                                    <div style = "font-size:16px;">Current Article</div>
                                </div>
                            </div>
                        </div>
                        <a href="article.php">
                            <div class="panel-footer">
                                <span class="pull-left">Manage Articles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div> 
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-archive fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div style = "font-size:34px;"><?php echo $archiveCount;?></div>
                                    <div style = "font-size:16px;">Archived Article</div>
                                </div>
                            </div>
                        </div>
                        <a href="article_archived.php">
                            <div class="panel-footer">
                                <span class="pull-left">Manage Archived Article</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" >
                    <div class="panel panel-yellow">
                        <div class="panel-heading" >
                            <div class="row" >
                                <div class="col-xs-3" >
                                    <i class="fa fa-cutlery fa-5x" style = "margin-left:8px;"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div style = "font-size:34px;"><?php echo $foodsCount;?></div>
                                    <div style = "font-size:16px;">Food Items</div>
                                </div>
                            </div>
                        </div>
                        <a href="foods.php">
                            <div class="panel-footer">
                                <span class="pull-left">Manage Food Items</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" >
                    <div class="panel panel-green">
                        <div class="panel-heading" >
                            <div class="row" >
                                <div class="col-xs-3" >
                                    <i class="fa fa-user fa-5x" style = "margin-left:8px;"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div style = "font-size:34px;"><?php echo $userCount;?></div>
                                    <div style = "font-size:16px;">Total Account</div>
                                </div>
                            </div>
                        </div>
                        <a href="accounts.php">
                            <div class="panel-footer">
                                <span class="pull-left">Manage Account</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        <div class="row" >
            <div class="col-lg-6" >
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i> Article Chart
                    </div>

                    <div style = "width:100%; height:auto;">
                        <canvas id="myChart" width="400" height="400"></canvas>
                    </div>


                </div>
            </div>

            <div class="col-lg-6" >
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i> Food Chart
                    </div>

                    <div style = "width:100%; height:auto;">
                        <canvas id="myChart2" width="400" height="400"></canvas>

                    </div>


                </div>
            </div>
        </div>

        <div class="row"  >
            
        </div>
<script>
var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Kids", "Men", "Women", "Seniors"],
        datasets: [{
            label: 'Articles',
            data: [<?php echo $article[0]; ?>, 
                   <?php echo $article[1]; ?>, 
                   <?php echo $article[2]; ?>, 
                   <?php echo $article[3]; ?>],
            backgroundColor: [
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

var ctx = document.getElementById("myChart2");
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Meat", "Vegetables", "Grains", "Beverages", "Dairy", "Sugary Foods", "Other"],
        datasets: [{
            label: 'Foods',
            data: [<?php echo $foods[0]; ?>,
                   <?php echo $foods[1]; ?>,
                   <?php echo $foods[2]; ?>,
                   <?php echo $foods[3]; ?>,
                   <?php echo $foods[4]; ?>,
                   <?php echo $foods[5]; ?>,
                   <?php echo $foods[6]; ?>],
            backgroundColor: [
                'rgba(255, 206, 86, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(255, 206, 86, 0.2)'
            ],
            borderColor: [
                'rgba(255, 206, 86, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>

        


        </div>


</div>




<!-- FOOTER -->
<?php include 'manager_footer.php'; ?>