<?php
 require_once 'PHP/dbconfig.php';
    include 'header.php';
	?>
	<div class="container">
<div id="tools-wrapper">
	<h1 class = "title-line-style">Protein Calculator</h1>

	<div id = "upper-part">

<FORM ACTION="form.php" method="POST"> 
 <div class = "col-lg-9">
            <form method="post" enctype="multipart/form-data" class="form-horizontal">
                    
                <table class="table table-bordered table-responsive">
				 <tr>
                    <td><label class="control-label">Number of foods</label></td>
                    <td><input class="form-control" type="integer" name="number" placeholder="Number of food" 
				</tr>
&nbsp
<div class = "column-calculate clearfix">
            <input type="Submit" class="btn-lg btn-info tools-submit" name="calculate">
            </div>
</div>
</div>
</FORM>	
<?php
include 'footer.php'; // FOOTER 
?>