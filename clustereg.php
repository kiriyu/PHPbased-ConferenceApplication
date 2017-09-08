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
		<title>Cluster Registration - Covenant University</title>

		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="your,keywords">
		<meta name="description" content="Short explanation about this website">
		<!-- END META -->

		<!-- BEGIN STYLESHEETS -->
		<link href="../assets/css/fonts.googleapis.com.css" rel="stylesheet" type="text/css"/>
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/bootstrap.css?1422792965" />
		<link type="text/css" rel="stylesheet" href="../assets/css/jquery-ui.css" />
		<link rel="stylesheet" href="../assets/css/mystyle.css" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/materialadmin.css?1425466319" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/font-awesome.min.css?1422529194" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/material-design-iconic-font.min.css?1421434286" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/select2/select2.css?1424887856" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/multi-select/multi-select.css?1424887857" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/bootstrap-datepicker/datepicker3.css?1424887858" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/jquery-ui/jquery-ui-theme.css?1423393666" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/bootstrap-colorpicker/bootstrap-colorpicker.css?1424887860" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/bootstrap-tagsinput/bootstrap-tagsinput.css?1424887862" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/typeahead/typeahead.css?1424887863" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/dropzone/dropzone-theme.css?1424887864" />
		<link type="text/css" rel="stylesheet" href="../assets/css/theme-default/libs/wizard/wizard.css?1425466601" />
		<!-- END STYLESHEETS -->
	</head>
	<body class="menubar-hoverable header-fixed ">

		<!-- BEGIN BASE-->
		<div id="base">

			<!-- BEGIN CONTENT-->
			<div id="content">
				<section>					
					<div class="section-body contain-lg">
						<!-- BEGIN INTRO -->
						<div class="row">
							<div class="col-lg-12">
								<h1 class="text-primary">Covenant University Cluster Registration Form</h1>
							</div>
					</div>

						<!-- BEGIN FORM WIZARD -->
						<div class="row">
							<div class="col-lg-12">
								<div class="card">
									<div class="card-body ">
										<div id="rootwizard2" class="form-wizard form-wizard-horizontal">
											<form class="form floating-label form-validation" role="form" method="post" novalidate="novalidate">
															<div class="form-group">
																<label for="Clustername" class="control-label">Cluster Name:</label>
																<input class="form-control" type="text" class="form-control" id="clustername" name="clustername">									  
															</div>
														
															<div class="form-group">
															  <label for="clusterdepartment" class="control-label"> Cluster Department:</label>
															
															  <select class="form-control" class="form-control" id="clusterdepartment" name="clusterdepartment">
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
														
															<div class="form-group">
															<label for="clusterleader" class="control-label">Cluster Leader:</label>
															<select class="form-control" class="form-control" id="clusterleader" name="clusterleader">
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
														<input class="btn btn-raised btn-lg btn-success btn-default pull-right" id="register" name="register" type="submit" value="Register">

																
												</div>																
											</form>
										</div><!--end #rootwizard -->
									</div><!--end .card-body -->
								</div><!--end .card -->								
							</div><!--end .col -->
						</div><!--end .row -->
						<!-- END FORM WIZARD -->

					</div><!--end .section-body -->
				</section>
			</div><!--end #content-->
	
		</div><!--end #base-->
		<!-- END BASE -->
		
		

		<!-- BEGIN JAVASCRIPT -->
		<script src="../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
		<script src="../assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
		<script src="../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
		<script src="../assets/js/libs/bootstrap/bootstrap.min.js"></script>
		<script src="../assets/js/libs/spin.js/spin.min.js"></script>
		<script src="../assets/js/libs/autosize/jquery.autosize.min.js"></script>
		<script src="../assets/js/libs/jquery-validation/dist/jquery.validate.min.js"></script>
		<script src="../assets/js/libs/jquery-validation/dist/additional-methods.min.js"></script>
		<script src="../assets/js/libs/wizard/jquery.bootstrap.wizard.min.js"></script>
		<script src="../assets/js/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
		<script src="../assets/js/libs/multi-select/jquery.multi-select.js"></script>
		<script src="../assets/js/libs/inputmask/jquery.inputmask.bundle.min.js"></script>
		<script src="../assets/js/libs/moment/moment.min.js"></script>
		<script src="../assets/js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
		<script src="../assets/js/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>
		<script src="../assets/js/libs/typeahead/typeahead.bundle.min.js"></script>
		<script src="../assets/js/libs/dropzone/dropzone.min.js"></script>
		<script src="../assets/js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
		<script src="../assets/js/core/source/App.js"></script>
		<script src="../assets/js/core/source/AppNavigation.js"></script>
		<script src="../assets/js/core/source/AppOffcanvas.js"></script>
		<script src="../assets/js/core/source/AppCard.js"></script>
		<script src="../assets/js/core/source/AppForm.js"></script>
		<script src="../assets/js/core/source/AppNavSearch.js"></script>
		<script src="../assets/js/core/source/AppVendor.js"></script>
		<script src="../assets/js/core/demo/Demo.js"></script>
		<script src="../assets/js/core/demo/DemoFormComponents.js"></script>
		<script src="../assets/js/core/demo/DemoFormWizard.js"></script>
		<script src="../assets/js/libs/select2/select2.min.js"></script>
		<!-- END JAVASCRIPT -->
		
	
	</body>
</html>
