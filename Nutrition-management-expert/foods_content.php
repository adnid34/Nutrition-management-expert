<?php
	require_once 'PHP/dbconfig.php';
	include 'header.php'; // HEADER
	require_once 'JS/enable_share.js'; //ENABLE SOCIAL/SHARE PLUGINS 



	if(empty($_GET['aps']))
		$amout_per_serving = 1;
	else
		$amout_per_serving = $_GET['aps'];

	$id = $_GET['id'];
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

	//Multiply all nutrition amounts with $amount_per_serving
	$calories = $calories * $amout_per_serving;
	$fat = $fat * $amout_per_serving;
	$carbohydrate = $carbohydrate * $amout_per_serving;
	$protein = $protein * $amout_per_serving;
	$calories_from_fat = $calories_from_fat * $amout_per_serving;
	$saturated_fat = $saturated_fat * $amout_per_serving;
	$polyunsaturated_fat = $polyunsaturated_fat * $amout_per_serving;
	$monounsaturated_fat = $monounsaturated_fat * $amout_per_serving;
	$trans_fat = $trans_fat * $amout_per_serving;
	$cholesterol = $cholesterol * $amout_per_serving;
	$sodium = $sodium * $amout_per_serving;
	$potassium = $potassium * $amout_per_serving;
	$dietary_fiber = $dietary_fiber * $amout_per_serving;
	$sugars = $sugars * $amout_per_serving;
	$other_carbohydrate = $other_carbohydrate * $amout_per_serving;
	$vitaminA = $vitaminA * $amout_per_serving;
	$vitaminC = $vitaminC * $amout_per_serving;
	$calcium = $calcium * $amout_per_serving;
	$iron  = $iron * $amout_per_serving;

?>
<!-- Hide Parallax Background -->
<script>
document.getElementById('parallax').style.display = "none";
</script>

<style>
.nutpanel table tr td {
    
}
.nutpanel table tr{
    
}
</style>

<div class="container">
	<div id="article-wrapper">
		<div id="article-content">
	
			<div class = "col-sm-12 title-page">
			<h1><?php echo $name; ?></h1>
			</div>

	
			<div id = "nutpanel" class="nutpanel col-sm-5 col-xs-12" >
		        <table>
					<colgroup>
						<col width="20"/>
						<col width="130"/>
						<col width="110"/>
						<col width="50"/>
					</colgroup>

					<tr>
						<td class="" colspan="4">
						  Serving Size: <?php echo $serving_size; ?>
						</td>
					</tr>

					<tr>
						<td class="sep" colspan="4">&nbsp;</td>
					</tr>
					<tr class="borderTop">
						<td class="borderTop strong small" colspan="3">Amount Per Serving</td>
						<td>
							<select class="form-control" type="text" style = "width:100%; display:inline; min-width:65px;" name="amout_per_serving" id="amout_per_serving">
								<option <?php if($amout_per_serving == "0.5") echo 'selected';?> value="0.5">1/2</option>
			                    <option <?php if($amout_per_serving == "1") echo 'selected';?> value="1">1</option>
			                    <option <?php if($amout_per_serving == "2") echo 'selected';?> value="2">2</option>
			                    <option <?php if($amout_per_serving == "3") echo 'selected';?> value="3">3</option>	                    
			                    <option <?php if($amout_per_serving == "4") echo 'selected';?> value="4">4</option>
			                    <option <?php if($amout_per_serving == "5") echo 'selected';?> value="5">5</option>  
			                </select>

						</td>
						<script>
							$('#amout_per_serving').change(function() {
							    window.location = "<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $id; ?>&aps=" + $(this).val() + "#nutpanel";
							});
						</script>
		 
					</tr>
					<tr>
						<td class="borderTop strong" colspan="2">Calories 
							<span style = "font-weight:normal;"><?php echo $calories?></span>
						</td>
						<td class="borderTop" align="right" colspan="2">
						  	Calories from Fat
						  	<span style = "font-weight:normal;"><?php echo $calories_from_fat ?></span>
						</td>
					</tr>
					<tr>
						<td class="sep" colspan="4">&nbsp;</td>
					</tr>
					<tr>
						<td class="strong small" colspan="4" align="right">% Daily Values *</td>
					</tr>
					<tr>
						<td class="label-nut borderTop" colspan="3">
							<b>Total Fat</b>
							<span style = "font-weight:normal;">&nbsp;<?php echo $fat ?>g</span>
						</td>
						<td class="borderTop strong">
							<?php 
								$DV = ($fat / 65) * 100;
								$DV = (int)$DV;
								echo $DV . "%";
							?>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="borderTop" colspan="2">
							Saturated Fat
							<span style = "font-weight:normal;">&nbsp;<?php echo $saturated_fat ?>g</span> 
						</td>
						<td class="borderTop strong">
							<?php 
								$DV = ($saturated_fat / 20) * 100;
								$DV = (int)$DV;
								echo $DV . "%";
							?>
						</td>
					</tr>
					<tr >
						<td>&nbsp;</td>
						<td class="borderTop" colspan="2">
							Polyunsaturated Fat
							<span style = "font-weight:normal;">&nbsp;<?php echo $polyunsaturated_fat ?>g</span> 
						</td>
						<td class="borderTop">&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="borderTop" colspan="2">
							Monounsaturated Fat
							<span style = "font-weight:normal;">&nbsp;<?php echo $monounsaturated_fat ?>g</span> 
						</td>
						<td class="borderTop">&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="borderTop" colspan="2">
							Trans Fat
							<span style = "font-weight:normal;">&nbsp;<?php echo $trans_fat ?>g</span> 
						</td>
						<td class="borderTop">&nbsp;</td>
					</tr>
					<tr>
						<td class="borderTop" colspan="3">
							<b>Cholesterol</b>
							<span style = "font-weight:normal;">&nbsp;<?php echo $cholesterol ?>mg</span> 
						</td>
						<td class="borderTop strong">
							<?php 
								$DV = ($cholesterol / 300) * 100;
								$DV = (int)$DV;
								echo $DV . "%";
							?>
						</td>
					</tr>
					<tr>
						<td class="borderTop" colspan="3">
							<b>Sodium</b>
							<span style = "font-weight:normal;">&nbsp;<?php echo $sodium ?>mg</span> 
						</td>
						<td class="borderTop strong">
							<?php 
								$DV = ($sodium / 2400) * 100;
								$DV = (int)$DV;
								echo $DV . "%";
							?>
						</td>
					</tr>
					<tr>
						<td class="borderTop" colspan="3">
							<b>Potassium</b>
							<span style = "font-weight:normal;">&nbsp;<?php echo $potassium ?>mg</span> 
						</td>
						<td class="borderTop strong">
							<?php 
								$DV = ($potassium / 3500) * 100;
								$DV = (int)$DV;
								echo $DV . "%";
							?>
						</td>
					</tr>
					<tr>
						<td class="borderTop" colspan="3">
							<b>Total Carbohydrate</b>
							<span style = "font-weight:normal;">&nbsp;<?php echo $carbohydrate ?>g</span> 
						</td>
						<td class="borderTop strong">
							<?php 
								$DV = ($carbohydrate / 300) * 100;
								$DV = (int)$DV;
								echo $DV . "%";
							?>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="borderTop" colspan="2">
							Dietary Fiber
							<span style = "font-weight:normal;">&nbsp;<?php echo $dietary_fiber ?>g</span>
						</td>
						<td class="borderTop strong">
							<?php 
								$DV = ($dietary_fiber / 25) * 100;
								$DV = (int)$DV;
								echo $DV . "%";
							?>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
							<td class="borderTop" colspan="2">
								Sugars
								<span style = "font-weight:normal;">&nbsp;<?php echo $sugars ?>g</span>
							</td>
						<td class="borderTop">&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="borderTop" colspan="2">
							Other Carbohydrate
							<span style = "font-weight:normal;">&nbsp;<?php echo $other_carbohydrate ?>g</span>
						</td>
						<td class="borderTop">&nbsp;</td>
					</tr>
					<tr>
						<td class="borderTop" colspan="3">
							<b>Protein</b> 
							<span style = "font-weight:normal;">&nbsp;<?php echo $protein ?>g</span>
						</td>
						<td class="borderTop strong">
							<?php 
								$DV = ($protein / 50) * 100;
								$DV = (int)$DV;
								echo $DV . "%";
							?>
						</td>
					</tr>
					<tr>
						<td class="sep" colspan="4">&nbsp;</td>
					</tr>
					<tr>
					<td class="" colspan="2">
					  <table class="generic" style="margin:0px">
					    <tr>
					      <td>Vitamin A</td>
					      <td align="right"><?php echo $vitaminA ?> %&nbsp;&nbsp;&nbsp;&nbsp;</td>
					    </tr>
					  </table>
					</td>
					<td class="l" colspan="2">
					  <table class="generic" style="margin:0px">
					    <tr>
					      <td>&nbsp;&nbsp;&nbsp;&nbsp;Vitamin C</td>
					      <td align="right"><?php echo $vitaminC ?> %&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					    </tr>
					  </table>
					</td>
					</tr>
					<tr style = "border-bottom: 1px solid #BCBCBC;">
					<td class="borderTop" colspan="2">
					  <table class="generic" style="margin:0px">
					    <tr>
					      <td>Calcium</td>
					      <td align="right"><?php echo $calcium ?> %&nbsp;&nbsp;&nbsp;&nbsp;</td>
					    </tr>
					  </table>
					</td>
					<td class="borderTop" colspan="2">
					  <table class="generic" style="margin:0px">
					    <tr>
					      <td>&nbsp;&nbsp;&nbsp;&nbsp;Iron</td>
					      <td align="right"><?php echo $iron ?> %&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					    </tr>
					  </table>
					</td>
					</tr>
					<tr>
					  <td class="" colspan="4">
						  <tr valign="top">
							  <td class="small">*&nbsp;</td>
							  <td class="small" colspan="3" style = "text-align: justify;
								text-justify: inter-word;">Percent Daily Values are based on a 2000 calorie diet. Your daily values may be higher or lower depending on your calorie needs.</td>
						  </tr>
					  </td>
					</tr>
				</table>
		    </div><!-- END class = nutpanel -->


		    <div class = "nut-summary col-sm-6 col-xs-12 ">		    	
		    	<h3 class = "col-sm-12">Nutrition Summary:</h3>
		    	<div class = "nut-desc col-sm-2 col-xs-5">
		    		<b>Calories</b> 
		    		<br />
		    		<?php echo $calories ?>
		    	</div>
		    	<div class = "nut-desc col-sm-2 col-xs-5">
		    		<b>Carbs</b> 
		    		<br />
		    		<?php echo $carbohydrate ?>g
		    	</div>
		    	<div class = "nut-desc col-sm-2 col-xs-5">
		    		<b>Fat</b> 
		    		<br />
		    		<?php echo $fat ?>g
		    	</div>
		    	<div class = "nut-desc col-sm-2 col-xs-5">
		    		<b>Protein</b> 
		    		<br />
		    		<?php echo $protein ?>g
		    	</div>
		    </div><!-- END Nutrition Summary -->


		    <div class = "nut-summary col-sm-6 col-xs-12">
		    	<h3 class = "col-sm-12">Calorie Breakdown:</h3>
		        <div style = "width:100%; height:auto;">
		            <canvas id="calorie_pie"  width="50" height="50"></canvas>
		        </div>
		    </div><!-- END Calorie Breakdown -->

<?php 

$total = $carbohydrate + $fat + $protein;
$carbohydrate_percent = ($carbohydrate / $total) * 100;
$fat_percent = ($fat / $total) * 100;
$protein_percent = ($protein / $total) * 100;

?>    
<script>
var ctx = document.getElementById("calorie_pie");
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ["Carbohydrate (<?php echo number_format($carbohydrate_percent, 2) ?>%)", 
		        "Fat (<?php echo number_format($fat_percent, 2) ?>%)", 
		        "Protein (<?php echo number_format($protein_percent, 2) ?>%)"],
        datasets: [{
            label: 'Calorie Breakdown',
            data: [<?php echo number_format($carbohydrate_percent, 2) ?>, 
		            <?php echo number_format($fat_percent, 2) ?>, 
		            <?php echo number_format($protein_percent, 2) ?>],
            backgroundColor: [
                'rgba(75, 184, 154, 0.8)',                
                'rgba(229, 180, 11, 0.8)',
                'rgba(188, 95, 84, 0.8)',
            ],
            borderColor: [
                'rgba(75, 184, 154, 1)',                
                'rgba(229, 180, 11, 1)',
                'rgba(188, 95, 84, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
    	tooltips: {
                callbacks: { //tooltip on hover
                    label: function(tooltipItems, data) { 
                         return data.datasets[tooltipItems.datasetIndex].data[tooltipItems.index] +'%';
                    }
                }
            },
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




			<div class = "clearfix"></div>
		</div> <!-- END class = article-content -->
	</div> <!-- END class = article-wrapper -->
</div> <!-- END class = container -->
<?php 
include 'footer.php'; // FOOTER 
require_once('counter.php');
updateFoodCounter($id); // Updates page hits
updateInfo(); // Updates hit info
?>