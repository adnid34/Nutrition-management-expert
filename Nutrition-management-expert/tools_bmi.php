<?php

  require_once 'PHP/dbconfig.php';
	include 'header.php'; // HEADER


  function focusWeight(){
    ?><script>$(function(){
        $("#weight").focus();
      });</script><?php
  }

  function focusHeight($height_unit){
      switch ($height_unit){

      case "feet_inch" :
          ?><script>$(function(){
            $("#feet").focus();
          });</script><?php         
          break;

      case "cm" :
          ?><script>$(function(){
            $("#cm").focus();
          });</script><?php         
          break;
      default:
          break;
    }
  }  



  if(isset($_POST["calculate"])){
  //Check if the form has been submitted          
    
    //convert weight to kilogram
    switch ( $_POST["weight_unit"] ){
        case "pounds" :
            $weight = $_POST["weight"] * 0.454;
            break;
        case "kilos" :
            $weight = $_POST["weight"];
            break;
        default:
            break;
    }

    //convert heigth to meters
    switch ( $_POST["height"] ){
        case "feet_inch" :
            $height = ((($_POST["feet"] * 12) + $_POST["inches"]) * 2.54) / 100;
            break;
        case "cm" :
            $height = $_POST["cm"] / 100;
            break;
        default:
            break;
    }


    if(empty($weight)){
      $errMSG = "Please Enter Weight.";
      focusWeight();
    }
    else if(empty($height)){
      $errMSG = "Please Enter Height.";
      focusHeight($_POST["height"]);
    }
    else if($weight >= 181){
    $errMSG = "Please Enter Valid Weight";
    focusWeight();
    }
    else if($weight < 38){
    $errMSG = "Please Enter Valid Weight";
    focusWeight();
    }
    else if($height >= 2.4384){
    $errMSG = "Please Enter Valid Height";
    focusHeight($_POST["height"]);
    }
    else if($height < 1.2192){
    $errMSG = "Please Enter Valid Heightsss";
    focusHeight($_POST["height"]);
    }

    // continue if no error occured 
    if(!isset($errMSG)){

      $BMI = (double)$weight / ($height * $height);
      $result = $BMI;

      if($result < 18.5)
        $bmi_category = "Underweight";
      else if($result >= 18.5 && $result <= 24.9)
        $bmi_category = "Healthy Weight";
      else if($result >= 25 && $result <= 29.9)
        $bmi_category = "Overweight";
      else if($result >= 30 && $result <= 34.9)
        $bmi_category = "Obese";
      else if($result >= 35 && $result <= 39.9)
        $bmi_category = "Severely Obese";
      else if($result > 40)
        $bmi_category = "Morbidly Obese";

      ?>
      <!-- focus screen to result after submit-->
      <script>
      window.location.hash = '#result_tools';
      </script>
      <?php

    }
  }


    
?>

<script>

  function showFeet() {

  var divblock = document.getElementById("feetlabel");
  divblock.style.display = "inline";
  var cmblock = document.getElementById("cmlabel");
  cmblock.style.display = "none";

  var cm = document.getElementById("cm");
  cm.value = "";

  }


  function showCM() {

  var divblock = document.getElementById("feetlabel");
  divblock.style.display = "none";
  var cmblock = document.getElementById("cmlabel");
  cmblock.style.display = "inline";

  var feet = document.getElementById("feet");
  feet.value = "";
  var inches = document.getElementById("inches");
  inches.value = "";

  }
</script>

<div class="container">
<div id="tools-wrapper">
	<h1 class = "title-line-style">Body Mass Index Calculator</h1>

	<div id = "upper-part">
		
		<div id = "" class="form-horizontal col-sm-6 col-centered calc-form">
      <div class = "calc-form-border">
        <?php
        if(isset($errMSG)){
              ?>
              <div class="alert alert-danger">
                <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
              </div>
              <?php
            }
        ?>

    		<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="form-horizontal" novalidate>

              <div class="column-align clearfix">
                <div class="column-left">
                <label>Weight</label>
                </div>

                <div class = "column-right">
            		<input class="column-input" type="number" id = "weight" name="weight" value="<?php 
                if(isset($_POST['weight'])) 
                  echo $_POST['weight']; 
                ?>" required/>

                <input type="radio" name="weight_unit" value="pounds" checked>
                <label >Pounds &nbsp</label>
                <input type="radio" name="weight_unit" value="kilos" 
                <?php 
                if(isset($_POST['weight_unit'])) 
                  if($_POST['weight_unit'] == 'kilos')
                    echo "checked"; 
                ?> >
                <label >Kilos</label>
                </div>
              </div>

              <div class="column-align clearfix">
                <div class="column-left">
                <label>Heigth</label>
                </div>

                <div class = "column-right">
                
                <div id="feetlabel" style = "
                <?php 
                if(isset($_POST['height'])) 
                  if($_POST['height'] == 'feet_inch')
                    echo "display: inline;";
                  else
                    echo "display: none;";
                ?>
                ">
                <input class="column-input" name="feet" type="number" id="feet" max = "8" value="<?php 
                if(isset($_POST['feet'])) 
                  echo $_POST['feet']; 
                ?>" required/>
                <label>Ft &nbsp</label>
                
                <input class="column-input" name="inches" type="number" id="inches" max = "11" value="<?php 
                if(isset($_POST['inches'])) 
                  echo $_POST['inches'];
                ?>" required/>
                <label class="inline">In</label>
                </div>

                <div id="cmlabel" style="
                <?php 
                if(isset($_POST['height'])){
                  if($_POST['height'] == 'cm')
                    echo "display: inline;";
                  else
                    echo "display: none;";
                }else{
                  echo "display: none;";
                } 
                  
                ?>
                ">
                <input class="column-input" name="cm" type="number" id="cm" autocorrect="off" value="<?php 
                if(isset($_POST['cm'])) 
                  echo $_POST['cm']; 
                ?>" />
                <label>Cm</label>
                </div>
                </div>
              </div>



              <div class="column-align clearfix">
                <label class="column-left">&nbsp</label>

                <div class = "column-right" style = "margin-top: -15px;">
                <input name="height" type="radio" class="rad" id="heightFeet" value="feet_inch" onclick="showFeet();" checked>
                <label class="inline" for="heightFeet">Feet &amp; Inches &nbsp</label>

                <input name="height" type="radio" class="rad" id="heightCM" value="cm" onclick="showCM();"
                <?php 
                if(isset($_POST['height'])) 
                  if($_POST['height'] == 'cm')
                    echo "checked";
                ?> >
                <label  class="inline" for="heightCM">Centimeters</label>
                </div>
                
              </div>
              
              <div class = "column-calculate clearfix">
              <input type="submit" class="btn-lg btn-info tools-submit" name="calculate">
              </div>
              
       			</table>
    		</form>

    	
      </div>
		</div><!-- END CALCFORM CLASS -->




		
	</div>

  <div id = "result_tools" style = "
      <?php 
      if(isset($errMSG))
        echo 'display:none;';
      else if (empty($_POST))
        echo 'display:none;';
      ?>
      col-sm-6 col-centered calc-result">
        <div class = "col-sm-6 col-centered">
          <br />
          <p class = "calc-result-title"> Your BMI Result </p>
          <div class = "col-lg-6 col-md-6 col-sm-12 col-xs-12 cacl-result-left">
            <h2> <?php echo number_format($result, 1); ?> </h2>
            <p>Body Mass Index</p>
          </div>

          <div class = "col-lg-6 col-md-6 col-sm-12 col-xs-12 cacl-result-right">
            <h2> <?php echo $bmi_category ?></h2>
            <p>Weight Category</p>
          </div>
        </div>
        <div class = "col-sm-6 col-centered " style = "clear:both;">
        <p> The table below shows the category of BMI.</p>
        </div>
        
        <div class = "col-sm-6 col-centered ">
          <table id = "result-table" class="table table-responsive">
            <tr>
              <td>BMI</td>
              <td>Weight Category</td>

            </tr>
            <tr class = "<?php if($bmi_category == "Underweight") echo 'chosen-activity';?>">
              <td>Less than 18.5 </td>
              <td>Underweight</td>
            </tr>

            <tr class = "<?php if($bmi_category == 'Healthy Weight') echo 'chosen-activity';?>">
              <td>18.5 to 24.9</td>
              <td>Healthy Weight</td>
            </tr>

            <tr class = "<?php if($bmi_category == 'Overweight') echo 'chosen-activity';?>">
              <td>25 to 30</td>
              <td>Overweight</td>
            </tr>

            <tr class = "<?php if($bmi_category == 'Obese') echo 'chosen-activity';?>">            
              <td>30 to 35</td>
              <td>Obese</td>
            </tr>

            <tr class = "<?php if($bmi_category == 'Severely Obese') echo 'chosen-activity';?>">
              <td>35 to 40</td>
              <td>Severely Obese</td>
            </tr>

            <tr class = "last-child <?php if($bmi_category == 'Morbidly Obese') echo 'chosen-activity';?>">
              <td>40 and over</td>
              <td>Morbidly Obese</td>
            </tr>

        </table>
        </div>


    </div>

	<div id = "lower-part" >
    <div class = "lower-part-content">
      <h2>What is BMI?</h2>
      <p>Your BMI is a measurement of your body weight based on your height and weight. Although your BMI does not actually "measure" your percentage of body fat, it is a useful tool to estimate a healthy body weight based on your height. Due to its ease of measurement and calculation, it is the most widely used diagnostic indicator to identify a person's optimal weight depending on his height. Your BMI "number" will inform you if you are underweight, of normal weight, overweight, or obese. However, due to the wide variety of body types, the distribution of muscle and bone mass, etc., it is not appropriate to use this as the only or final indication for diagnosis.</p>

      <h2>Body Mass Index Formula</h2>
      <p>The formulas to calculate BMI based on two of the most commonly used unit systems:</p>
      <p>BMI = weight(kg)/height2(m2)         (Metric Units)</p>
      <p>BMI = 703·weight(lb)/height2(in2)         (U.S. Units)</p>


    </div>
	</div>


</div>
</div>



<?php include 'footer.php'; // FOOTER ?>