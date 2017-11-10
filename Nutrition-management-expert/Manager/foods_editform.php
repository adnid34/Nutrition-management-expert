<?php
	require_once '../PHP/dbconfig.php';

	
		
		if(isset($_GET['edit_id']) && !empty($_GET['edit_id'])){
		$id = $_GET['edit_id'];
		$stmt_edit = $DB_con->prepare('SELECT foods.*, foods_other_nutrients.*
										FROM foods 
										LEFT JOIN foods_other_nutrients
											ON foods_other_nutrients.food_id = foods.food_id
										WHERE foods.food_id = :id
										');
		$stmt_edit->bindParam(':id',$id);

		$stmt_edit->execute();
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else{
		header("Location: foods.php");
	}

	if(isset($_POST['btnsave'])){
	    $food_name = $_POST['food_name'];
	    $food_category = $_POST['food_category'];
	    $servingSize = $_POST['servingSize'];
	    $calories = $_POST['calories'];
	    $caloriesFromFat = $_POST['caloriesFromFat'];
	    $totalFat = $_POST['totalFat'];
	    $saturatedFat = $_POST['saturatedFat'];
	    $polyunsaturatedFat = $_POST['polyunsaturatedFat'];
	    $monounsaturatedFat = $_POST['monounsaturatedFat'];
	    $transFat = $_POST['transFat'];
	    $cholesterol = $_POST['cholesterol'];
	    $sodium = $_POST['sodium'];
	    $potassium = $_POST['potassium'];
	    $carbohydrate = $_POST['carbohydrate'];
	    $fiber = $_POST['fiber'];
	    $sugar = $_POST['sugar'];
	    $otherCarbohyrdate = $_POST['otherCarbohyrdate'];
	    $protein = $_POST['protein'];
	    $vitaminA = $_POST['vitaminA'];
	    $vitaminC = $_POST['vitaminC'];
	    $calcium = $_POST['calcium'];
	    $iron = $_POST['iron'];
						
		
		// if no error occured, continue ....
		if(!isset($errMSG)){
			$stmt = $DB_con->prepare('UPDATE foods 
									     SET name = :aname, 
										     category = :acategory,  
										     serving_size = :aserving_size, 
										     calories = :acalories,
										     fat = :afat,
										     carbohydrate = :acarbohydrate,
										     protein = :aprotein
										       
								       WHERE food_id=:afood_id');
			$stmt->bindParam(':afood_id', $id);
			$stmt->bindParam(':aname', $food_name);
		    $stmt->bindParam(':acategory', $food_category);      
		    $stmt->bindParam(':aserving_size', $servingSize); 
		    $stmt->bindParam(':acalories', $calories);
		    $stmt->bindParam(':afat', $totalFat);
	        $stmt->bindParam(':acarbohydrate', $carbohydrate);
	        $stmt->bindParam(':aprotein', $protein);
			$stmt->execute();


			$stmt = $DB_con->prepare('UPDATE foods_other_nutrients 
									     SET
										  calories_from_fat = :acalories_from_fat,
										  saturated_fat = :asaturated_fat,
										  polyunsaturated_fat = :apolyunsaturated_fat,
										  monounsaturated_fat = :amonounsaturated_fat,
										  trans_fat = :atrans_fat,
										  cholesterol = :acholesterol,
										  sodium = :asodium,
										  potassium = :apotassium,
										  dietary_fiber = :adietary_fiber,
										  sugars = :asugars,
										  other_carbohydrate = :aother_carbohydrate,
										  vitaminA = :avitaminA,
										  vitaminC = :avitaminC,
										  calcium = :acalcium,
										  iron = :airon
										       
								       WHERE food_id=:afood_id');

			$stmt->bindParam(':afood_id', $id);
		    $stmt->bindParam(':acalories_from_fat', $caloriesFromFat);     
		    $stmt->bindParam(':asaturated_fat', $saturatedFat); 
		    $stmt->bindParam(':apolyunsaturated_fat', $polyunsaturatedFat);
		    $stmt->bindParam(':amonounsaturated_fat', $monounsaturatedFat);
		    $stmt->bindParam(':atrans_fat', $transFat);
		    $stmt->bindParam(':acholesterol', $cholesterol);
		    $stmt->bindParam(':asodium', $sodium);
		    $stmt->bindParam(':apotassium', $potassium);
		    $stmt->bindParam(':adietary_fiber', $fiber);
		    $stmt->bindParam(':asugars', $sugar);
		    $stmt->bindParam(':aother_carbohydrate', $otherCarbohyrdate);
		    $stmt->bindParam(':avitaminA', $vitaminA);
		    $stmt->bindParam(':avitaminC', $vitaminC);
		    $stmt->bindParam(':acalcium', $calcium);
		    $stmt->bindParam(':airon', $iron);
				
			if($stmt->execute()){
				?>
                <script>
				alert('Successfully Updated ...');
				window.location.href='foods.php';
				</script>
                <?php
			}
			else{
				$errMSG = "Sorry Data Could Not Updated !";
			}
		}								
	}
	
	
?>
<!-- HEADER -->
<?php include 'manager_header.php'; ?>


<div class="container">

	<div class="page-header">
    	<h2 class="h2">Edit Food  / <a class="btn btn-default" href="foods.php"> <span class="glyphicon glyphicon-backward"></span> Cancel </a></h2>
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
    <td><label class="control-label">Name</label></td>
    <td><input class="form-control admin-title-box" type="text" name="food_name" value="<?php echo $name; ?>"/></td>
  </tr>

  <tr>
    <td><label class="control-label">Category</label></td>
    <td>
      <select class="form-control admin-select" type="text" style = "width:30%;" name="food_category">
      <option <?php if($category == "Dairy") echo 'selected';?> value="Dairy">Dairy</option>
      <option <?php if($category == "Fruits") echo 'selected';?> value="Fruits">Fruits</option>
      <option <?php if($category == "Grains, beans and legumes") echo 'selected';?> value="Grains, beans and legumes">Grains, beans and legumes</option>
      <option <?php if($category == "Meat") echo 'selected';?> value="Meat">Meat</option> 
      <option <?php if($category == "Sugary Foods") echo 'selected';?> value="Sugary Foods">Sugary Foods</option> 
      <option <?php if($category == "Vegetables") echo 'selected';?> value="Vegetables">Vegetables</option> 
      <option <?php if($category == "Beverages") echo 'selected';?> value="Beverages">Beverages</option> 
      <option <?php if($category == "Other") echo 'selected';?> value="Other">Other</option> 
      </select>
    </td>
  </tr>

  <tr>
    <td><label class="control-label">Nutrition Facts</label></td>
    <td>
        <table >
          <tr valign="top">
            <td >&nbsp;</td>
            <td width="480">  
            
              <div class="nutpanel" >
                <table>
                  <colgroup>
                    <col width="20"/>
                    <col width="130"/>
                    <col width="110"/>
                    <col width="50"/>
                  </colgroup>
                  
                  <tr>
                    <td class="label-nut" colspan="4">
                      Serving Size<span class="rec"> *</span> <input type="text" style="width:177px" name="servingSize" value="<?php echo $serving_size; ?>"/>
                    </td>
                  </tr>
                  
                  <tr>
                    <td class="sep" colspan="4">&nbsp;</td>
                  </tr>
                  <tr class="borderTop">
                    <td class="borderTop label-nut strong small" colspan="4">Amount Per Serving</td>
                  </tr>
                  <tr>
                    <td class="borderTop label-nut strong" colspan="2">Calories <span class="rec">*</span> <input type="number" name="calories" style="text-align:right;width:50px" step=any min="0" value="<?php echo $calories ?>"/></td>
                    <td class="borderTop label-nut" align="right" colspan="2">
                      Calories from Fat <input type="number" name="caloriesFromFat" style="text-align:right;width:40px" value="<?php echo $calories_from_fat ?>"/>
                    </td>
                  </tr>
                  <tr>
                    <td class="sep" colspan="4">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="strong small" colspan="4" align="right">% Daily Values</td>
                  </tr>

                  <tr>
                    <td class="label-nut borderTop" colspan="2">
                      <b>Total Fat</b> <span class="rec">*</span>
                    </td>
                    <td class="borderTop">
                      <input type="number" style="text-align:right;width:40px" name="totalFat" step=any min="0" value="<?php echo $fat ?>"/> g
                    </td>
                    <td class="borderTop">&nbsp;</td>

                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td class="borderTop">
                      Saturated Fat
                    </td>
                    <td class="borderTop">
                      <input type="number" style="text-align:right;width:40px" name="saturatedFat" step=any min="0" value="<?php echo $saturated_fat ?>"/> g
                    </td>
                    <td class="borderTop">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td class="light borderTop">
                      Polyunsaturated Fat
                    </td>
                    <td class="light borderTop">
                      <input type="number" style="text-align:right;width:40px" name="polyunsaturatedFat" step=any min="0" value="<?php echo $polyunsaturated_fat ?>"/> g
                    </td>
                    <td class="borderTop">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td class="label-nut light borderTop">
                      Monounsaturated Fat
                    </td>
                    <td class="light borderTop">
                      <input type="number" style="text-align:right;width:40px" name="monounsaturatedFat" step=any min="0" value="<?php echo $monounsaturated_fat ?>"/> g
                    </td>
                    <td class="borderTop">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td class="label-nut light borderTop">
                      Trans Fat
                    </td>
                    <td class="light borderTop">
                      <input type="number" style="text-align:right;width:40px" name="transFat" step=any min="0" value="<?php echo $trans_fat ?>"/> g
                    </td>
                    <td class="borderTop">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="label-nut borderTop" colspan="2">
                      <b>Cholesterol <span class="rec">*</span></b>
                    </td>
                    <td class="borderTop">
                      <input type="number" style="text-align:right;width:40px" name="cholesterol" step=any min="0" value="<?php echo $cholesterol ?>"/> mg
                    </td>
                    <td class="borderTop">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="label-nut borderTop" colspan="2">
                      <b>Sodium <span class="rec">*</span></b>
                    </td>
                    <td class="borderTop">
                      <input type="number" style="text-align:right;width:40px"  name="sodium" step=any min="0" value="<?php echo $sodium ?>"/> mg
                    </td>
                    <td class="borderTop">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="label-nut borderTop light" colspan="2">
                      <b>Potassium</b>
                    </td>
                    <td class="light borderTop">
                      <input type="number" style="text-align:right;width:40px" name="potassium" step=any min="0" value="<?php echo $potassium ?>"/> mg
                    </td>
                    <td class="borderTop">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="label-nut borderTop" colspan="2">
                      <b>Total Carbohydrate</b> <span class="rec">*</span>
                    </td>
                    <td class="borderTop">
                      <input type="number" style="text-align:right;width:40px" name="carbohydrate" step=any min="0" value="<?php echo $carbohydrate ?>"/> g
                    </td>
                    <td class="borderTop">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td class="borderTop label-nut">
                      Dietary Fiber <span class="rec">*</span>
                    </td>
                    <td class="borderTop">
                      <input type="number" style="text-align:right;width:40px" name="fiber" step=any min="0" value="<?php echo $dietary_fiber ?>"/> g
                    </td>
                    <td class="borderTop">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td class="borderTop label-nut">
                      Sugars <span class="rec">*</span>
                    </td>
                    <td class="borderTop">
                      <input type="number" style="text-align:right;width:40px" name="sugar" step=any min="0" value="<?php echo $sugars ?>"/> g
                    </td>
                    <td class="borderTop">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td class="label-nut light borderTop">
                      Other Carbohydrate
                    </td>
                    <td class="light borderTop">
                      <input type="number" style="text-align:right;width:40px" name="otherCarbohyrdate" step=any min="0" value="<?php echo $other_carbohydrate ?>"/> g
                    </td>
                    <td class="borderTop">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="label-nut borderTop" colspan="2">
                      <b>Protein</b> <span class="rec">*</span>
                    </td>
                    <td class="borderTop">
                      <input type="number" style="text-align:right;width:40px" name="protein" step=any min="0" value="<?php echo $protein ?>" /> g
                    </td>
                    <td class="borderTop">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="sep" colspan="4">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="label-nut" colspan="2">
                      <table class="generic" style="margin:0px">
                        <tr>
                          <td>Vitamin A</td>
                          <td align="right"><input type="number" style="text-align:right;width:40px" name="vitaminA" min="0" value="<?php echo $vitaminA ?>" /> %&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                      </table>
                    </td>
                    <td class="label-nut" colspan="2">
                      <table class="generic" style="margin:0px">
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;&nbsp;Vitamin C</td>
                          <td align="right"><input type="number" style="text-align:right;width:40px" name="vitaminC" min="0" value="<?php echo $vitaminC ?>" /> %&nbsp;&nbsp;</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td class="label-nut borderTop" colspan="2">
                      <table class="generic" style="margin:0px">
                        <tr>
                          <td>Calcium</td>
                          <td align="right"><input type="number" style="text-align:right;width:40px" name="calcium" min="0" value="<?php echo $calcium ?>" /> %&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                      </table>
                    </td>
                    <td class="label-nut borderTop" colspan="2">
                      <table class="generic" style="margin:0px">
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;&nbsp;Iron</td>
                          <td align="right"><input type="number" style="text-align:right;width:40px" name="iron" min="0" value="<?php echo $iron ?>" /> %&nbsp;&nbsp;</td>
                        </tr>
                      </table>
                    </td>
                  </tr>




                </table>

              </div>


            </td>
          </tr>

        </table>
    </td>
  </tr>

  <tr>
    <td colspan="2"><button type="submit" name="btnsave" class="btn btn-default">
    <span class="glyphicon glyphicon-save"></span> &nbsp; save
    </button>
    </td>
  </tr>





  </form>
</table>

</div>
<!-- FOOTER -->
<?php include 'manager_footer.php'; ?>