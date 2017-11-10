<?php

  require_once 'PHP/dbconfig.php';
	include 'header.php'; // HEADER

  function focusAge(){
    ?><script>$(function(){
        $("#age").focus();
      });</script><?php
  }

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
    

    $age = $_POST["age"]; 
    $gender = $_POST["sex"];
    $activity = $_POST["activity"];
    
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

    //convert heigth to centimeters
    switch ( $_POST["height"] ){
        case "feet_inch" :
            $height = (($_POST["feet"] * 12) + $_POST["inches"]) * 2.54;
            break;
        case "cm" :
            $height = $_POST["cm"];
            break;
        default:
            break;
    }


    if(empty($age)){
      $errMSG = "Please Enter Age.";
      focusAge();

    }
    else if($age >= 85 ){
      $errMSG = "Age must be lower than 85.";
      focusAge();

    }
    else if(empty($weight)){
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
    else if($height >= 243.84){
    $errMSG = "Please Enter Valid Height";
    focusHeight($_POST["height"]);
    }
    else if($height < 121.92){
    $errMSG = "Please Enter Valid Height";
    focusHeight($_POST["height"]);
    }

    // continue if no error occured 
    if(!isset($errMSG)){

      
      //calculate Basal Metabolic Rate (BMR)
      if($gender == "male")
        $BMR = 10 * $weight + 6.25 * $height - 5 * $age + 5;
      else
        $BMR = 10 * $weight + 6.25 * $height - 5 * $age - 161;

      $result = $BMR * $activity;
      $result_weekly = $result * 7;

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
	<h1 class = "title-line-style">Calorie Calculator - Daily Calorie Needs</h1>

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
              <label>Age</label>
              </div>

              <div class = "column-right">
          		<input class="column-input " type="number" id = "age" name="age" 
              value="<?php 
              if(isset($_POST['age'])) 
                echo $_POST['age']; 
              ?>" required/>
              </div>
              </div>

            <div class="column-align clearfix" >
              <div class="column-left">
              <label>Gender</label>
              </div>

              <div class = "column-right">
              <input type="radio" name="sex" value="male" checked>
              <label >Male &nbsp</label>
              <input type="radio" name="sex" value="female"
              <?php 
              if(isset($_POST['sex'])) 
                if($_POST['sex'] == 'female')
                  echo "checked"; 
              ?> >
              <label >Female</label>
              </div>
            </div>

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

            <div class="column-align clearfix" style = "margin-top: -15px;">
              <div class="column-left">
              <label>Activity Level</label>
              </div>

              <div class = "column-right">
              <select class="form-control tools-select" name="activity" id="activity">
                <option value="1.2"<?php if(isset($_POST['activity'])){if($_POST['activity']=='1.2')echo "selected";}?>>Sedentary (office job)</option>

                <option value="1.375" <?php if(isset($_POST['activity'])){if($_POST['activity']=='1.375')echo "selected";}?>>Light Exercise (1-2 days/week)</option>

                <option value="1.55" <?php if(isset($_POST['activity'])){if($_POST['activity']=='1.55')echo "selected";}?>>Moderate Exercise (3-5 days/week)</option>

                <option value="1.725" <?php if(isset($_POST['activity'])){if($_POST['activity']=='1.725')echo "selected";}?>>Heavy Exercise (6-7 days/week)</option>

                <option value="1.9" <?php if(isset($_POST['activity'])){if($_POST['activity']=='1.9')echo "selected";}?>>Athlete (2x per day) </option>
              </select>
              </div>
            </div>
            
            <div class = "column-calculate clearfix">
            <input type="submit" class="btn-lg btn-info tools-submit" name="calculate">
            </div>
            
     			</table>
  		</form>

  		</div>
		</div><!-- END CALCFORM CLASS -->

	</div><!-- END UPPERPART CLASS -->

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
        <p class = "calc-result-title"> Your Maintenance Calories </p>
        <div class = "col-lg-6 col-md-6 col-sm-12 col-xs-12 cacl-result-left">
          <h2> <?php echo number_format($result, 0); ?> </h2>
          <p>calories per day</p>
        </div>

        <div class = "col-lg-6 col-md-6 col-sm-12 col-xs-12 cacl-result-right">
          <h2> <?php echo number_format($result_weekly, 0); ?></h2>
          <p>calories per week</p>
        </div>
      </div>
      <div class = "col-sm-6 col-centered">
      <p> The table below shows the difference if you were to have selected a different activity level.</p>
      </div>
      <div class = "col-sm-6 col-centered">
        <table id = "result-table" class="table table-responsive">
          <tr class = "<?php if($activity == 1.2) echo 'chosen-activity';?>">
            <td>Sedentary </td>
            <td><?php echo number_format($BMR * 1.2, 0);?></td>
          </tr>

          <tr class = "<?php if($activity == 1.375) echo 'chosen-activity';?>">
            <td>Light Exercise </td>
            <td><?php echo number_format($BMR * 1.375, 0);?></td>
          </tr>

          <tr class = "<?php if($activity == 1.55) echo 'chosen-activity';?>"> 
            <td>Moderate Exercise</td>
            <td><?php echo number_format($BMR * 1.55, 0);?></td>
          </tr>

          <tr class = "<?php if($activity == 1.725) echo 'chosen-activity';?>">
            <td>Heavy Exercise</td>
            <td><?php echo number_format($BMR * 1.725, 0);?></td>
          </tr>

          <tr class = "last-child <?php if($activity == 1.9) echo 'chosen-activity';?>">
            <td>Athlete</td>
            <td><?php echo number_format($BMR * 1.9, 0);?></td>
          </tr>

      </table>
      </div>
    </div><!-- END CALCRESULT CLASS -->

	<div id = "lower-part">
    <div class = "lower-part-content">
      <h2>Reference</h2>
      <p>Based on the <b>Mifflin - St Jeor</b> equation. With this equation, the Basal Metabolic Rate (BMR) is calculated by using the following formula:</p>

      <p class = "italic-style">BMR = 10 * weight(kg) + 6.25 * height(cm) - 5 * age(y) + 5         (man)</p>
      <p class = "italic-style">BMR = 10 * weight(kg) + 6.25 * height(cm) - 5 * age(y) - 161     (woman)</p>

      <p>The calories needed to maintain your weight equal to the BMR value, multiplied by an activity factor. To loss 1 pound, or 0.5kg per week, you will need to shave 500 calories from your daily menu.</p>

      <p>The best way to lose weight is through proper diet and exercise. Try not to lower your calorie intake by more than 1,000 calories per day, and try to lower your calorie intake gradually. Also, try to maintain your level of fiber intake and balance your other nutritional needs.</p>

      <p>The results are based on an estimated average.</p> 

      <h2>How Many Calories Do You Need?</h2>

      <p>Nearly all of us seek to lose weight, and often the best way to do this is to consume a lower amount of calories each day than we usually do. But how many calories do we need to be healthy? Much depends, of course, on the amount of physical activity you engage in each day. And it's different for us all; there are a lot of different factors involved.</p>

      <p>Factors include age, size, height, sex, lifestyle, and overall general health. A physically active, 25 –year-old six foot male requires considerably more calories than a 5 foot 70-year-old woman who is not especially active. The average male adult requires about 2,700 calories to maintain his weight, while the average female needs only 2,200 calories, according to the U.S Department of Health.</p>

      <p>Just to stay alive, we obviously need far less calories, but our bodies will function poorly if we consume too few. The basal metabolic rate, used in our calculator, is the amount of energy you require when you are just resting. Depending on the amount of physical exercise you do, you can multiply the basal metabolic rate by a specific number to determine calorie needs. For example, if you are not very active, your needed calorie intake is the basal metabolic rate times 1.2. Somewhat active people should multiply by 1.375. if you do some exercise during the week, the number is 1.55. And, if you do a lot of sports, you multiply by 1.95.</p>


      <h2>Minimum Daily Calorie intake</h2>

      <p>It is difficult to set absolute bottom calorie levels, because everyone has different body composition and activity levels.</p>

      <p>Health authorities do set some baselines - these are <b>1200 calories per day for women, and 1800 calories per day for men.</b></p>

      <p>These absolute rules don't make sense - are you are sedentary person with little muscle mass? Or someone who is tall, muscular, and exercises a lot? Absolute levels don't work - but do give us a starting point.</p>

    </div>
	</div>


</div>
</div>



<?php include 'footer.php'; // FOOTER ?>