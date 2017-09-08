<?php
include_once ('../include/config.php');
include_once ('../include/covenantportalfunctions.php');
include_once ('../include/functions.php');
session_start();
$_SESSION['loginid'] = 'CU1234';

if(isset($_GET['mkl']) && ($_GET['mkl'] != '')){
			$stmt4=$conn->prepare("select * from conferencesupport");
			$stmt4-> execute();
			while($data2 = $stmt4->fetch(PDO::FETCH_ASSOC)){
				//print_r($data2);
				if (password_verify($data2['appid'], $_GET['mkl'])){
					$stmt5=$conn->prepare("select * from pdata where idno='".$data2['pistaffid']."'");
					$stmt5-> execute();
					$data3 = $stmt5->fetch(PDO::FETCH_ASSOC);
					$idno = $data2['pistaffid'];
					$id= $data2['confappid'];
					
					$sname = $data3['sname'];
					$fname = $data3['fname'];
					$mname = $data3['mname'];
					$title = $data3['title'];
					//$clusterid = implode(',', array_map(function($el){ return $el['clusterid']; }, getcsaform($conn, $id,$idno)));
					$clusterid = getclusters($conn, $data2['clusterid']);
					$conferenceid = getconferences($conn, $data2['conferenceid']);
					$cpci = implode(',', array_map(function($el){ return $el['cpci']; }, getcsaform($conn, $id,$idno)));
					$country = getcountrybyid($conn, $data2['country']);
					$city = implode(',', array_map(function($el){ return $el['city']; }, getcsaform($conn, $id,$idno)));
					$address = implode(',', array_map(function($el){ return $el['address']; }, getcsaform($conn, $id,$idno)));
					/* $street = implode(',', array_map(function($el){ return $el['street']; }, getcsaform($conn, $id,$idno))); */
					$startdate = implode(',', array_map(function($el){return $el['startdate'];}, getcsaform($conn, $id,$idno)));
					$enddate = implode(',', array_map(function($el){return $el['enddate'];}, getcsaform($conn, $id,$idno)));
					$objectives = implode(',', array_map(function($el){return $el['objectives'];}, getcsaform($conn, $id,$idno)));
					$datesubmitted = implode(',', array_map(function($el){return $el['datesubmitted'];}, getcsaform($conn, $id,$idno)));
					/* $conferenceid = implode(',', array_map(function($el){return $el['conferenceid'];}, getcsaform($conn, $id,$idno))); */
					
	

?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<title></title>

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
		<style>
			.form-control {
				border: 1px solid #f6f6f6;
				border-bottom: none;
			}
		</style>
		<!-- END STYLESHEETS -->
	</head>
	<body class="menubar-hoverablex header-fixedx ">

		<!-- BEGIN BASE-->
		<div id="basex">

			<!-- BEGIN CONTENT-->
			<div id="content">
				<section>					
					<div class="section-bodyx contain-lgx">
						<!-- BEGIN INTRO -->
						<div class="row">
							<div class="col-lg-12">
								<h1 class="text-primary"></h1>
							</div>
							<div class="col-lg-12">
								<a class="btn btn-success pull-left" href="csaformadmin.php">GO BACK </a>
							</div>
						</div>

						<!-- BEGIN FORM WIZARD -->
						<div class="row">
							<div class="col-md-9">
								<div class="card">
									<div class="card-body col-md-12">
										<div id="rootwizard2" class="form-wizard form-wizard-horizontal">
											<fieldset>
													<legend>Conference Information</legend>
											<div class="row">
												<div class="col-md-3">
													<h5>Conference Information:</h5>
												</div>
												<div class="col-md-9">
													<p><?php echo $clusterid; ?></p>
												</div>
											</div>
											
													<div class="form-group">
															
															<p><?php echo $clusterid; ?></p>
															
														</div>
														<div class="form-group">
																<input id="conferenceid" name="conferenceid" class="form-control" readonly="readonly" value="<?php echo $conferenceid ?>">
																<label for="conferenceid">Conference Title</label>
														</div>
														<div class="form-group">
															<input type="text" name="cpci" id="cpci" class="form-control" readonly="readonly" value="<?php echo $data2['cpci']; ?>">
															<label for="cpci" class="control-label">Conference Proceeding Citation Index</label>
														</div>
														<div class="row form-group">
															<div class="form-group col-sm-4">
																<input id="countryid" name="countryid" class="form-control" readonly="readonly" value="<?php echo $country; ?>">
																<label for="Country" class="control-label">Country</label>	
															</div>
															<div class="col-sm-4">
																<div class="form-group">
																	<input type="text" name="city" id="city" class="form-control" readonly="readonly" value="<?php echo $data2['city']; ?>">
																	<label for="city" class="control-label">City</label>
																</div>
															</div>
															<div class="col-sm-4">
																<div class="form-group">
																	<input type="text" name="address" id="address" class="form-control" readonly="readonly" value="<?php echo $data2['address']; ?>">
																	<label for="address" class="control-label">Address</label>
																</div>
															</div>
														</div>
														<div class="col-sm-4">
															<div class="form-group">
																<input type="text" name="startdate" id="from" class="form-control" readonly="readonly" value="<?php echo date('l jS \of F Y', strtotime($data2['startdate']));?>">
																<label for="from" class="control-label">Start Date</label>
															</div>
														</div>
														<div class="col-sm-4">
															<div class="form-group">
																<input type="text" name="enddate" id="to" class="form-control" readonly="readonly" value="<?php echo date('l jS \of F Y', strtotime($data2['enddate'])); ?>">
																<label for="to" class="control-label">End Date</label>
															</div>
														</div>															
														<div class="col-sm-12">
															<div class="form-group">
																<input type="text" name="objectives" id="objectives" class="form-control" readonly="readonly" value="<?php echo $data2['objectives']; ?>">
																<label for="objectives" class="control-label">Conference Objectives</label>
															</div>
														</div>
													</fieldset>
													<br/><br/>
													
													<fieldset>
														<legend>Conference Papers</legend>
														
															<div>
																<?php
																$sql = $conn->prepare("select * from conferencepapers where confappid = '{$data2['confappid']}'");
																$sql->execute();
																$data = $sql->fetchAll();
																foreach ($data as $dat) {
																	$papers = $dat['papertitle'];
																?>
																<label class="form-control" > <?php echo $papers; ?></label>
																<table class="table table-hover">
																	<thead>
																		<tr>
																			<th>S/N</th>
																			<th>Name</th>
																			<th>Contribution Rank</th>																			
																			<th>Attendance Status</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																		$sql1 = $conn->prepare("select * from paperauthors where confappid='{$dat['confappid']}' and paperid='{$dat['paperid']}'");
																		//echo $dat['confappid'];
																		$sql1->execute();
																		$authors = $sql1->fetchAll();
																		$countauthors = 1;
																		foreach ($authors as $author) { ?>
																			<tr>
																				<td><?php echo $countauthors?></td>
																				<td><?php  $authorname = getauthorname($conn,$author['authorstaffid']); echo $authorname['sname']." ".$authorname['fname']." ".$authorname['mname']; ?></td>
																				<td><?php echo $author['contributionrank']; ?></td>
																				<td><?php echo $author['attendancestatus']; ?></td>
																			</tr>
																		<?php 
																		$countauthors++;
																		} ?>
																	</tbody>
																</table>
																<?php } ?>
															</div>
													</fieldset>
												<!--	<div class="col-lg-12">
														<a class="btn btn-success pull-left" href="csaformadmin.php"> BACK </a>
													</div>	-->
											
										</div><!--end #rootwizard -->
									</div><!--end .card-body -->
									
								</div><!--end .card -->
								</div><!--end .col -->
								
							<div class="col-md-3">
								<div class="card" style="background-color: rgb(200,200,200); color: white;">
									<div class="card-head" style="border-color:3px #ffffff">
										<header>APPLICATION APPROVAL</header>
									</div>
									<div class="card-body col-md-12">
										<p>Date Submitted: <?php echo date('l jS \of F Y', strtotime($data2['datesubmitted'])); ?></p>
											<div class="btn-group">
												  <button type="button" class="btn btn-primary btn-success dropdown-toggle" data-toggle="dropdown">Recommendation<span class="caret"></span></button>
												  <ul class="dropdown-menu" role="menu">
													<li><a href="#">Recommend</a></li>
													<li><a href="#">Not Recommended</a></li>
													<li><a href="#">Not Yet Recommended</a></li>
												  </ul>
											</div>
											<div class="col-sm-12">
												<div class="form-group">
													<input type="text" name="clcomment" id="clcomment" class="form-control" placeholder="Cluster Leader's Comment">
												</div>
											</div>
											<br><br>
											<div class="btn-group">
												  <button type="button" class="btn btn-primary btn-success dropdown-toggle" data-toggle="dropdown">Recommendation<span class="caret"></span></button>
												  <ul class="dropdown-menu" role="menu">
													<li><a href="#">Recommend</a></li>
													<li><a href="#">Not Recommended</a></li>
													<li><a href="#">Not Yet Recommended</a></li>
												  </ul>
											</div>
											<div class="col-sm-12">
												<div class="form-group">
													<input type="text" name="deancomment" id="deancomment" class="form-control" placeholder="Dean Of College">
												</div>
											</div>
											<br><br>
											<div class="btn-group">
												  <button type="button" class="btn btn-primary btn-success dropdown-toggle" data-toggle="dropdown">Recommendation<span class="caret"></span></button>
												  <ul class="dropdown-menu" role="menu">
													<li><a href="#">Recommend</a></li>
													<li><a href="#">Not Recommended</a></li>
													<li><a href="#">Not Yet Recommended</a></li>
												  </ul>
											</div>
											<div class="col-sm-12">
												<div class="form-group">
													<input type="text" name="cucridcomment" id="cucridcomment" class="form-control" placeholder="CUCRID">
												</div>
											</div>
											<br><br>
											<div class="btn-group">
												  <button type="button" class="btn btn-primary btn-success dropdown-toggle" data-toggle="dropdown">Recommendation<span class="caret"></span></button>
												  <ul class="dropdown-menu" role="menu">
													<li><a href="#">Approve</a></li>
													<li><a href="#">Disapprove</a></li>
												  </ul>
												</div>
											<div class="col-sm-12">
												<div class="form-group">
													<input type="text" name="vccomment" id="vccomment" class="form-control" placeholder="Vice Chancellor">
												</div>
											</div>
											<br><br>
									</div>
								</div>
							</div>
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
<?php 
	
		}

	}
}



?>