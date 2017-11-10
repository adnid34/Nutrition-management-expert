<?php
  require_once '../PHP/dbconfig.php';

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

    if(empty($food_name)){
      $errMSG = "Please Enter Food Name.";
    }
    else if(empty($calories)){
      $errMSG = "Please Enter Calories.";
    }
    else if(empty($totalFat)){
      $errMSG = "Please Enter Total Fats.";
    }
    else if(empty($cholesterol)){
      $errMSG = "Please Enter Cholesterol.";
    }
    else if(empty($sodium)){
      $errMSG = "Please Enter Sodium.";
    }
    else if(empty($carbohydrate)){
      $errMSG = "Please Enter Carbohydrate.";
    }
    else if(empty($fiber)){
      $errMSG = "Please Enter Dietary Fiber.";
    }
    else if(empty($sugar)){
      $errMSG = "Please Enter Sugars.";
    }
    else if(empty($protein)){
      $errMSG = "Please Enter Protein.";
    }



    if(!isset($errMSG)){
      //INSERT INFORMATION in foods table
      $stmt = $DB_con->prepare('INSERT INTO foods(name, category, serving_size, calories, fat, carbohydrate, protein) 
                       VALUES(:aname, :acategory, :aserving_size, :acalories, :afat, :acarbohydrate, :aprotein)');
      $stmt->bindParam(':aname', $food_name);
      $stmt->bindParam(':acategory', $food_category);      
      $stmt->bindParam(':aserving_size', $servingSize); 
      $stmt->bindParam(':acalories', $calories);
      $stmt->bindParam(':afat', $totalFat);
      $stmt->bindParam(':acarbohydrate', $carbohydrate);
      $stmt->bindParam(':aprotein', $protein);

      $stmt->execute();

      //get the last inserted ID
      $food_id = $DB_con->lastInsertId();

      //INSERT INFORMATION in foods_dairy table
      $stmt = $DB_con->prepare('INSERT INTO foods_other_nutrients(food_id, calories_from_fat, saturated_fat, polyunsaturated_fat, monounsaturated_fat, trans_fat, cholesterol, sodium, potassium, dietary_fiber, sugars, other_carbohydrate, vitaminA, vitaminC, calcium, iron) 
                       VALUES(:afood_id, :acalories_from_fat, :asaturated_fat, :apolyunsaturated_fat, :amonounsaturated_fat, :atrans_fat, :acholesterol, :asodium, :apotassium, :adietary_fiber, :asugars, :aother_carbohydrate, :avitaminA, :avitaminC, :acalcium, :airon)');

      $stmt->bindParam(':afood_id', $food_id);
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
        $successMSG = "New Article Succesfully Inserted...";
        header("refresh:2;foods.php"); // redirects image view page after x seconds.
      }
      else{
        $errMSG = "Error While Inserting....";
      }





    }



  }

?>

<!-- HEADER -->
<?php include 'manager_header.php'; ?>


<div class="container">

    <div class="page-header">
    	<h2 class="h2">Add New Food  / <a class="btn btn-default" href="foods.php"> <span class="glyphicon glyphicon-backward"></span> Cancel </a></h2>     
    </div>
	<br />
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
    <td><label class="control-label">Name</label></td>
    <td><input class="form-control admin-title-box" type="text" name="food_name" value="<?php echo htmlspecialchars($_POST['food_name']); ?>"/></td>
  </tr>

  <tr>
    <td><label class="control-label">Category</label></td>
    <td>
      <select class="form-control admin-select" type="text" style = "width:30%;" name="food_category">
      <option <?php if($_POST["food_category"] == "Dairy") echo 'selected';?> value="Dairy">Dairy</option>
      <option <?php if($_POST["food_category"] == "Fruits") echo 'selected';?> value="Fruits">Fruits</option>
      <option <?php if($_POST["food_category"] == "Grains, beans and legumes") echo 'selected';?> value="Grains, beans and legumes">Grains, beans and legumes</option>
      <option <?php if($_POST["food_category"] == "Meat") echo 'selected';?> value="Meat">Meat</option> 
      <option <?php if($_POST["food_category"] == "Sugary Foods") echo 'selected';?> value="Sugary Foods">Sugary Foods</option> 
      <option <?php if($_POST["food_category"] == "Vegetables") echo 'selected';?> value="Vegetables">Vegetables</option> 
      <option <?php if($_POST["food_category"] == "Beverages") echo 'selected';?> value="Beverages">Beverages</option> 
      <option <?php if($_POST["food_category"] == "Other") echo 'selected';?> value="Other">Other</option> 
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
                      Serving Size<span class="rec"> *</span> <input type="text" style="width:177px" name="servingSize" value="<?php echo htmlspecialchars($_POST['servingSize']); ?>"/>
                    </td>
                  </tr>
                  
                  <tr>
                    <td class="sep" colspan="4">&nbsp;</td>
                  </tr>
                  <tr class="borderTop">
                    <td class="borderTop label-nut strong small" colspan="4">Amount Per Serving</td>
                  </tr>
                  <tr>
                    <td class="borderTop label-nut strong" colspan="2">Calories <span class="rec">*</span> <input type="number" name="calories" style="text-align:right;width:50px"  step=any min="0" value="<?php echo htmlspecialchars($_POST['calories']); ?>"/></td>
                    <td class="borderTop label-nut" align="right" colspan="2">
                      Calories from Fat <input type="number" name="caloriesFromFat" style="text-align:right;width:40px"  step=any min="0" value="<?php echo htmlspecialchars($_POST['caloriesFromFat']); ?>"/>
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
                      <input type="number" style="text-align:right;width:40px" name="totalFat" step=any min="0" value="<?php echo htmlspecialchars($_POST['totalFat']); ?>"/> g
                    </td>
                    <td class="borderTop">&nbsp;</td>

                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td class="borderTop">
                      Saturated Fat
                    </td>
                    <td class="borderTop">
                      <input type="number" style="text-align:right;width:40px" name="saturatedFat" step=any min="0" value="<?php echo htmlspecialchars($_POST['saturatedFat']); ?>"/> g
                    </td>
                    <td class="borderTop">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td class="light borderTop">
                      Polyunsaturated Fat
                    </td>
                    <td class="light borderTop">
                      <input type="number" style="text-align:right;width:40px" name="polyunsaturatedFat" step=any min="0" value="<?php echo htmlspecialchars($_POST['polyunsaturatedFat']); ?>"/> g
                    </td>
                    <td class="borderTop">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td class="label-nut light borderTop">
                      Monounsaturated Fat
                    </td>
                    <td class="light borderTop">
                      <input type="number" style="text-align:right;width:40px" name="monounsaturatedFat" step=any min="0" value="<?php echo htmlspecialchars($_POST['monounsaturatedFat']); ?>"/> g
                    </td>
                    <td class="borderTop">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td class="label-nut light borderTop">
                      Trans Fat
                    </td>
                    <td class="light borderTop">
                      <input type="number" style="text-align:right;width:40px" name="transFat" step=any min="0" value="<?php echo htmlspecialchars($_POST['transFat']); ?>"/> g
                    </td>
                    <td class="borderTop">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="label-nut borderTop" colspan="2">
                      <b>Cholesterol <span class="rec">*</span></b>
                    </td>
                    <td class="borderTop">
                      <input type="number" style="text-align:right;width:40px" name="cholesterol" step=any min="0" value="<?php echo htmlspecialchars($_POST['cholesterol']); ?>"/> mg
                    </td>
                    <td class="borderTop">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="label-nut borderTop" colspan="2">
                      <b>Sodium <span class="rec">*</span></b>
                    </td>
                    <td class="borderTop">
                      <input type="number" style="text-align:right;width:40px"  name="sodium" step=any min="0" value="<?php echo htmlspecialchars($_POST['sodium']); ?>"/> mg
                    </td>
                    <td class="borderTop">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="label-nut borderTop light" colspan="2">
                      <b>Potassium</b>
                    </td>
                    <td class="light borderTop">
                      <input type="number" style="text-align:right;width:40px" name="potassium" step=any min="0" value="<?php echo htmlspecialchars($_POST['potassium']); ?>"/> mg
                    </td>
                    <td class="borderTop">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="label-nut borderTop" colspan="2">
                      <b>Total Carbohydrate</b> <span class="rec">*</span>
                    </td>
                    <td class="borderTop">
                      <input type="number" style="text-align:right;width:40px" name="carbohydrate" step=any min="0" value="<?php echo htmlspecialchars($_POST['carbohydrate']); ?>"/> g
                    </td>
                    <td class="borderTop">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td class="borderTop label-nut">
                      Dietary Fiber <span class="rec">*</span>
                    </td>
                    <td class="borderTop">
                      <input type="number" style="text-align:right;width:40px" name="fiber" step=any min="0" value="<?php echo htmlspecialchars($_POST['fiber']); ?>"/> g
                    </td>
                    <td class="borderTop">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td class="borderTop label-nut">
                      Sugars <span class="rec">*</span>
                    </td>
                    <td class="borderTop">
                      <input type="number" style="text-align:right;width:40px" name="sugar" step=any min="0" value="<?php echo htmlspecialchars($_POST['sugar']); ?>"/> g
                    </td>
                    <td class="borderTop">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td class="label-nut light borderTop">
                      Other Carbohydrate
                    </td>
                    <td class="light borderTop">
                      <input type="number" style="text-align:right;width:40px" name="otherCarbohyrdate" step=any min="0" value="<?php echo htmlspecialchars($_POST['otherCarbohyrdate']); ?>"/> g
                    </td>
                    <td class="borderTop">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="label-nut borderTop" colspan="2">
                      <b>Protein</b> <span class="rec">*</span>
                    </td>
                    <td class="borderTop">
                      <input type="number" style="text-align:right;width:40px" name="protein" step=any min="0" value="<?php echo htmlspecialchars($_POST['protein']); ?>"/> g
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
                          <td align="right"><input type="number" style="text-align:right;width:40px" name="vitaminA" min="0" value="<?php echo htmlspecialchars($_POST['vitaminA']); ?>"/> %&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                      </table>
                    </td>
                    <td class="label-nut" colspan="2">
                      <table class="generic" style="margin:0px">
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;&nbsp;Vitamin C</td>
                          <td align="right"><input type="number" style="text-align:right;width:40px" name="vitaminC" min="0" value="<?php echo htmlspecialchars($_POST['vitaminC']); ?>"/> %&nbsp;&nbsp;</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td class="label-nut borderTop" colspan="2">
                      <table class="generic" style="margin:0px">
                        <tr>
                          <td>Calcium</td>
                          <td align="right"><input type="number" style="text-align:right;width:40px" name="calcium" min="0" value="<?php echo htmlspecialchars($_POST['calcium']); ?>"/> %&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                      </table>
                    </td>
                    <td class="label-nut borderTop" colspan="2">
                      <table class="generic" style="margin:0px">
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;&nbsp;Iron</td>
                          <td align="right"><input type="number" style="text-align:right;width:40px" name="iron" min="0" value="<?php echo htmlspecialchars($_POST['iron']); ?>"/> %&nbsp;&nbsp;</td>
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