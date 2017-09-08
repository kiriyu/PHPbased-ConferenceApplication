<?php
include_once ('../include/config.php');
include_once ('../include/covenantportalfunctions.php');
include_once ('../include/functions.php');
session_start();
$_SESSION['loginid'] = 'CU1234';


//dont delete
$output = array();



?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Submitted Conference Application's</title>

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
								<h1 class="text-primary">Submitted Conference Application's</h1>
							</div>
						<!--	<div class="col-lg-8">
								<article class="margin-bottom-xxl">
									<p class="lead">
										(International).
									</p>
								</article>
							</div> -->
						</div>

						<!-- BEGIN FORM WIZARD -->
						<div class="row">
							<div class="col-lg-12">
								<div class="card">
									<div class="card-body ">
										<div id="rootwizard2" class="form-wizard form-wizard-horizontal">
											<form class="form floating-label form-validation" role="form" method="post" novalidate="novalidate">
													<div class="container">
														  <div class="row">
															<div class="col-xs-12">
															  <div class="table-responsive">
																<table class="table table-bordered table-hover">
																  <thead>
																	<tr>
																	  <th>S/N</th>
																	  <th>Cluster Name</th>
																	  <th>Conference Title</th>
																	  <th>Conference Location</th>
																	  <th>Confrence Date</th>
																	  <th>Principal Investigator</th>
																	  <th>Approve</th>
																	</tr>
																  </thead>
																  <tbody>
																  <?php  
																  $stmt = $conn->prepare("select * from conferencesupport");
																	 $stmt->execute();
																		$sn = 0;
																	 $data = $stmt->fetchAll();
																	  foreach ($data as $dat) { 
																		$details= get_user($dat['pistaffid']);
																		++$sn;
																		$pistaffid = $dat['pistaffid'];
																		$sname = implode(',', array_map(function($el){ return $el['sname']; }, $details));
																		$fname = implode(',', array_map(function($el){ return $el['fname']; }, $details));
																		$mname = implode(',', array_map(function($el){ return $el['mname']; }, $details));
																		$title = implode(',', array_map(function($el){ return $el['title']; }, $details));
																		//$location = implode(',', array_map(function($el){ return $el['country']; }, $details));
																		//$datesubmitted = implode(',', array_map(function($el){ return $el['datesubmitted']; }, $details));
																		
																		$conf = getconferences($conn,$dat['conferenceid']);
																		$conftitle = $conf;
																		$cluster = getclusters($conn, $dat['clusterid']);
																		$clustername = $cluster;
																		$appid = getconfappid($conn,$dat['appid']);
																		$confappid = $appid;
																		
																		$location = getcountrybyid($conn,$dat['country']);
																		$venue = $location;
																		$conferencedate =date('l jS \of F Y', strtotime($dat['startdate']));
																		
																		$cost = 11;
																		$hashlinlk = password_hash($dat['appid'], PASSWORD_BCRYPT, ["cost" => $cost]);	
																		echo "<tr>
																		<td>$sn</td>
																		<td>$clustername</td>
																		<td>$conftitle</td>
																		<td>$venue</td>
																		<td>$conferencedate</td>
																		<td>$title $sname $fname $mname</td>
																		<td><a class=\"btn btn-success  btn-block pull-right\" href = 'csaformadminview.php?mkl=$hashlinlk'>VIEW</a></td>
																		</tr>";
																  }
																  
																  ?>
																  
																  </tbody>
																</table>
															  </div><!--end of .table-responsive-->
															</div>
														  </div>
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
