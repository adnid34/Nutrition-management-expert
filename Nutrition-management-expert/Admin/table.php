<!-- HEADER -->
<?php 
        include 'admin_header.php'; 
        require_once '../PHP/dbconfig.php';   
?>



<div class="row">

</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">

            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTable">
                    <thead>
                        <tr>    
                            <th>Name</th>
                            <th>Category</th>
                            <th>Serving Size</th>
                            <th>Calories</th>
                            <th>Fat</th>
                            <th>Carbohydrate</th>
                            <th>Protein</th>
                            <th>Action</th>

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

                        <tr class="">
                            <td><?php echo $name; ?></td>
                            <td><?php echo $category; ?></td>
                            <td><?php echo $serving_size; ?></td>
                            <td><?php echo $calories; ?></td>
                            <td><?php echo $fat. "g";?></td>
                            <td><?php echo $carbohydrate. "g";?></td>
                            <td><?php echo $protein. "g";?></td>
                            <td>
                            <a class="btn btn-info" href="foods_editform.php?edit_id=<?php echo $row['food_id']; ?>" title="click for edit"><span class="glyphicon glyphicon-edit"></span> Edit</a> 
                            <a class="btn btn-danger" href="?delete_id=<?php echo $row['food_id']; ?>" title="click for delete" onclick="return confirm('Are you sure you want to delete this?')"><span class="glyphicon glyphicon-remove-circle"></span> Delete</a>
                            </td>
                            
                        </tr>   

                    <?php
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


    

    

</body>

</html>
