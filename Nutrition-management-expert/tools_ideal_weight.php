<?php

  require_once 'PHP/dbconfig.php';
	include 'header.php'; // HEADER

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
    
    $gender = $_POST["sex"];

    //convert heigth to inches
    switch ( $_POST["height"] ){
        case "feet_inch" :
            $height = ($_POST["feet"] * 12) + $_POST["inches"];
            break;
        case "cm" :
            $height = $_POST["cm"] * 0.3937008;
            break;
        default:
            break;
    }


    if(empty($height)){
      $errMSG = "Please Enter Height.";
      focusHeight($_POST["height"]);
    }
    else if($height >= 96){
    $errMSG = "Please Enter Valid Height";
    focusHeight($_POST["height"]);
    }
    else if($height < 48){
    $errMSG = "Please Enter Valid Height";
    focusHeight($_POST["height"]);
    }

    // continue if no error occured 
    if(!isset($errMSG)){

      

      switch ($gender){
        case "male" :
            if($height >= 60){
              $height -= 60;
              $ideal_weight = 50 + (2.3 * $height);
            }else{
              $height = 60 - $height;
              $ideal_weight = 50 - (2.3 * $height);
            }            
            break;

        case "female" :
            if($height >= 60){
              $height -= 60;
              $ideal_weight = 45.5 + (2.3 * $height);
            }else{
              $height = 60 - $height;
              $ideal_weight = 45.5 - (2.3 * $height);
            }
            break;
        default:
            break;
    }

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
	<h1 class = "title-line-style">Ideal Weight Calculator</h1>

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
      <p class = "calc-result-title"> Your Recommended Weight </p>
      <div class = "col-lg-6 col-md-6 col-sm-12 col-xs-12 cacl-result-left">
        <h2> <?php echo number_format($ideal_weight, 1); echo " kg";?> </h2>
        <p>Kilograms</p>
      </div>

      <div class = "col-lg-6 col-md-6 col-sm-12 col-xs-12 cacl-result-right">
        <h2> <?php echo number_format($ideal_weight * 2.20462, 1); echo " lbs";?></h2>
        <p>Pounds</p>
      </div>
    </div>
  </div>

	<div id = "lower-part">
    <div class = "lower-part-content">
      <h2>Reference</h2>
      <p>The ideal human body weight has been a topic of debate for a very long time. Hundreds of formulas and theories have been invented and put to the test, but the answer is still debatable. The ideal weight should be unique for everyone. The major factors that contribute to a person's ideal weight are height, gender, age, body frame, body type, and so on.<p>
      <br />
      <p><b>B. J. Devine Formula (1974)</b></p>

      <p>50.0 + 2.3 kg per inch over 5 feet (man)</p>
      <p>45.5 + 2.3 kg per inch over 5 feet (woman)</p>

    </div>
	</div>


</div>
</div>



<?php include 'footer.php'; // FOOTER ?>