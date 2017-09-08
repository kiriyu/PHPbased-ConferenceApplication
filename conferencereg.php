<?php
include_once ('../include/config.php');
include_once ('../include/covenantportalfunctions.php');
session_start();
$_SESSION['loginid'] = 'CU1234';

if(isset($_POST['register']))
{
	extract($_POST);
	$sql = "INSERT INTO `conferencereg`(`conferencename`, `status`) VALUES ('$conferencename', '1')"; 
	$stmt = $conn->prepare($sql);
	$stmt -> execute();
	
	if($stmt->rowCount() > 0 ){
	$lastid=$conn->lastInsertId();
	$cost =11;
		$hashlinlk = password_hash($lastid, PASSWORD_BCRYPT,["cost" => $cost]);
			echo "<script>alert('Your Conference Has Been Successfully Registerd.');</script>";
			
	}else{
		echo"Unsuccessful";
	}
	
}
	
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Conference Registration - Covenant University</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
  <link rel="stylesheet" href="../assets/css/bootstrap.css" />
<link rel="stylesheet" href="../assets/css/mystyle.css" />
 <script src="../assets/js/jquery-1.12.4.js"></script>
<script src="../assets/js/jquery-ui.js"></script>
<style>
		.alignright{
			text-align:right;
		}
		}
	</style>
</head>

	<body>
			<div class="container row">
				<form class="form-horizontal" action="" method="post">
					<div class="col-sm-offset-2 col-sm-8">
						
							<h1>CONFERENCE REGISTRATION FORM</h1>
							  <fieldset> 
							   <legend>Conference Information:</legend>
								<div class="form-group">
									<div class="col-sm-3">
									  <label for="conferencename" class="control-label">Conference Name:</label>
									</div>
									<div class="col-sm-8">
									  <input type="text" class="form-control" id="conferencename" name="conferencename">
									</div>
									</div>	
									<div class="row col-sx-6">
									<input class="btn btn-success" id="register" name="register" type="submit" value="Register">
									</div>
									</div>	
								</fieldset>
								
								<!--	<div class="form-group">
									<div class="col-sm-3">
									  <label for="venue" class="control-label">Confernce Venue:</label>
									</div>
									 <div class="col-sm-8">
									 
									 <select class="form-control" id="venue" name="venue" placeholder="Country">
								  <option value = '' selected>Select Country</option>
									/* <?php  
									
									$stmt1 = $conn->prepare("SELECT * FROM countries where countrystatus=1"); 
									$stmt1->execute();
									$data2=$stmt1->fetchAll();
									foreach($data2 as $dat1){
										echo "<option value= '".$dat1['countryid'] . "'>". ucwords($dat1['country'])."</option>";
									}
									?> */
								  </select>
									</div> -->
								
								
					</div>																
				</form>	
			</div>						

	</body>

</html>