<?php
    require_once 'PHP/dbconfig.php';
    include 'header.php'; // HEADER
?>



<div class="container">
    <div id="article-wrapper">
        <div id="article-content">

            
            <div class = "article-category-title ">
                <h1>Foods</h1>
            </div>

            

            <!-- /.row -->
            <div class="row">

                <div class="col-lg-12">
                    <p class = "text-muted">*Click/Tap a food to see more details. </p>
                    <div class="panel panel-default">


                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTable">
                                <thead>
                                    <tr class = "table-font">    
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Serving Size</th>
                                        <th>Calories</th>
                                        <th>Fat</th>
                                        <th>Carbohydrate</th>
                                        <th>Protein</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    
                                <?php
                                
                                $row = $DB_con->query("SELECT COUNT(*) FROM foods")->fetchColumn();
                                $query = $DB_con->prepare("SELECT * FROM foods ORDER BY name DESC");
                                $query->execute();
                                while($row=$query->fetch(PDO::FETCH_ASSOC)){
                                        extract($row);

                                        
                                ?>
                                    
                                    <tr class="table-font" href="foods_content.php?id=<?php echo $food_id; ?>" style = "cursor:pointer;">
                                        
                                        <td><?php echo $name; ?></td>
                                        <td><?php echo $category; ?></td>
                                        <td><?php echo $serving_size; ?></td>
                                        <td><?php echo $calories; ?></td>
                                        <td><?php echo $fat. "g";?></td>
                                        <td><?php echo $carbohydrate. "g";?></td>
                                        <td><?php echo $protein. "g";?></td>
                                    </tr>
                                    <script>
                                    $('#dataTable').on( 'click', 'tbody tr', function () {
                                    window.location.href = $(this).attr('href');
                                    } );
                                    </script>
                                <?php
                                    }

          
function time_elapsed_string($datetime, $full = false) {
    
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

                                ?>
                                </tbody>
                            </table>

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>


        </div>
    </div>  
</div>



<!-- FOOTER -->
<?php include 'footer.php'; ?>