<?php
include_once ('../include/config.php');
include_once ('../include/covenantportalfunctions.php');
session_start();
$_SESSION['loginid'] = 'CU1234';

if(isset($_POST['register']))
{
	extract($_POST);
$dates = date("Y-m-d H:i:s" );	
$sql = "INSERT INTO `clusterreg`(`clustername`, `clusterdepartment`, `clusterleader`, `status`, `datecreated`) VALUES ('$clustername', '$clusterdepartment', '$clusterleader', '1', '$dates')";
$stmt = $conn->prepare($sql);
$stmt -> execute();
	
	if($stmt->rowCount() > 0){
			$lastid=$conn->lastInsertId();
			//echo $lastid;
			$cost =11;
			$hashlinlk = password_hash($lastid, PASSWORD_BCRYPT,["cost" => $cost]);
			echo "<script>alert('Your Cluster Has Been Successfully Registerd.');</script>";
			
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
  <title>Cluster Registration - Covenant University</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
  <link rel="stylesheet" href="../assets/css/bootstrap.css" />
<link rel="stylesheet" href="../assets/css/mystyle.css" />
 <script src="../assets/js/jquery-1.12.4.js"></script>
<script src="../assets/js/jquery-ui.js"></script>
<style>
		.alignright{
			text-align:right;
		}
		
	</style>
</head>

	<body>
			<div class="container row">
				<form class="form-horizontal" action="" method="post">
					<div class="col-sm-offset-2 col-sm-8">
						
							<h1>CLUSTER REGISTRATION FORM</h1>
							  <fieldset> 
							   <legend>Cluster Information:</legend>
								<div class="form-group">
									<div class="col-sm-3">
									  <label for="Clustername" class="control-label">Cluster Name:</label>
									</div>
									<div class="col-sm-8">
									<input type="text" class="form-control" id="clustername" name="clustername">									  
									</div>
								</div>
							   																		
								
								<div class="form-group">
									<div class="col-sm-3">
									  <label for="clusterdepartment" class="control-label"> Cluster Department:</label>
									</div>
									<div class="col-sm-8">
									 
									  <select class="form-control" id="clusterdepartment" name="clusterdepartment">
										<option value = '' selected>Select Department</option>
											<?php  
											
											$stmt1 = $conn->prepare("SELECT * FROM departments where departmentstatus=1"); 
											$stmt1->execute();
											$data2=$stmt1->fetchAll();
											foreach($data2 as $dat1){
												echo "<option value= '".$dat1['dpid'] . "'>". ucwords($dat1['department'])."</option>";
											}
											?>
									   </select>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-3">
									  <label for="clusterleader" class="control-label">Cluster Leader:</label>
									</div>
									<div class="col-sm-8">
									  <select class="form-control" id="clusterleader" name="clusterleader">
										<option value = '' selected>Select Cluster Leader</option>
											<?php  
											
											$stmt2 = $conn->prepare("SELECT * FROM pdata where staffstatus='active'"); 
											$stmt2->execute();
											$data2=$stmt2->fetchAll();
											foreach($data2 as $dat2){
												$sname=$dat2['sname'];
												$fname=$dat2['fname'];
												$mname=$dat2['mname'];
												$title=$dat2['title'];
												$name=$title." ".$sname." ".$fname." ".$mname;
												echo "<option value= '".$dat2['idno'] . "'>". ucwords($name)."</option>";
											}
											?>
									   </select>
									  
									  
									</div>
								</div>
								</fieldset>
								<div class="row col-sx-6">
										
									<input class="btn btn-success" id="register" name="register" type="submit" value="Register">
								</div>
					</div>																
				</form>	
			</div>						

	</body>

</html>