<?php
 require_once 'PHP/dbconfig.php';
    include 'header.php';
	?>
	<div class="container" >
<div id="tools-wrapper" style="height:100%;">
	<h1 class = "title-line-style">Protein Calculator</h1>

	<div id = "upper-part">
 <div class = "col-lg-9">
            <form method="post" ACTION="calorycount.php" enctype="multipart/form-data" class="form-horizontal">
			<table class="table table-bordered table-responsive">
<?php
$in=$_POST['number'];
for($i=1;$i<=$in;$i++)
{	
?>
                
                <tr>
                    <td><label class="control-label">Food</label></td>
                    <td><input class="form-control" type="text" name="Food[]" placeholder="food you have taken" /></td>
				</tr>
				<tr>
                    <td><label class="control-label">Quantity</label></td>
                    <td><input class="form-control" type="integer" name="Quantity[]" placeholder= "Quantity of food" 
				</tr>
<?php
}
?>				
&nbsp
<div class = "column-calculate clearfix">
            <input type="Submit" class="btn-lg btn-info tools-submit" name="calculate">
 
           </div>
</div>
</div>


</div>
</div>
<?php
include 'footer.php'; // FOOTER 
?>