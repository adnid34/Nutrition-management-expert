<?php
 require_once 'PHP/dbconfig.php';
    include 'header.php';
	?>
	<div class="container">
<div id="tools-wrapper">
	<h1 class = "title-line-style">Total Protein Intake</h1>

	<div id = "upper-part">
<?php
$servername="localhost";
$username="root";
$password="";
$dbname="snc";

$conn=mysqli_connect($servername,$username,$password,$dbname);
if(!$conn)
{
	die("Connection Failed: ". mysqli_connect_error());
}
	$sql="select name,protein from foods";
	$result=mysqli_query($conn,$sql);
	$pcount=0;
	$x=0;
	foreach($_POST['Quantity'] as $q)
	{
		$arr[$x]=$q;
		$x++;
	}
	$x=0;
	if(mysqli_num_rows($result) > 0)
	{
		while($row =mysqli_fetch_assoc($result))
		{
			$food=$row["name"];
			$protein=$row["protein"];
			$co=0;
			foreach($_POST['Food'] as $in)
			{
				if($food==$in)
				{
					$pcount=$pcount+($protein*$arr[$x]);
					$x++;
				}
				$co++;
			}
		}
	}
	
   echo "$pcount";
	
?>	
</div>
</div>
</div>

	
<?php
include 'footer.php'; // FOOTER 
?>