<?php
include_once ('../include/config.php');
include_once ('../include/covenantportalfunctions.php');
include_once ('../include/functions.php');
session_start();
$_SESSION['loginid'] = 'CU1234';

$pistaffid = $_SESSION['loginid'];

//dont delete
$output = array();

if(isset($_POST['submitform']))
{
	extract($_POST);
	$dates = date("Y-m-d H:i:s" );
	$sdate = date('Y-m-d', strtotime($startdate));
	$edate = date('Y-m-d', strtotime($enddate));
	
$sql = "INSERT INTO `csaform`() 
	VALUES ()";
	//$sql = "INSERT INTO `csaform`(`conferencestatus`, `clustername`,`datecreated`) VALUES ('$conferencestatus', '$clustername','$date')";
	$stmt4 = $conn->prepare($sql);
	/* print_r ($stmt4); */
	$stmt4 -> execute();
		
}

if(isset($_POST['save1']))
{
	extract($_POST);
	$dates = date("Y-m-d H:i:s" );
	$sdate = date('Y-m-d', strtotime($startdate));
	$edate = date('Y-m-d', strtotime($enddate));
	
$confquery = "INSERT INTO `conferencesupport`(`conferenceid`, `clusterid`, `cpci`, `countryid`, `city`, `state`, `startdate`, `enddate`, `objectives`, `pistaffid`, `applicationstatus`, `datesubmitted`)
 VALUES ('$conferenceid', '$clusterid', '$cpci', '$country', '$city', '$state', '$sdate', '$edate', '$objectives', '$pistaffid', '1', '$dates')";
	$confquery = $conn->prepare($confquery); 
	$confquery -> execute();
		//print_r ($confquery);
		
$stmtquery  = "SELECT appid FROM conferencesupport where clusterid ='$clusterid'";
	$stmtquery = $conn->prepare($stmtquery);
		$stmtquery->execute();
		$stmtq = $stmtquery ->fetch(PDO::FETCH_ASSOC);
		$appid=$stmtq['appid'];
		

	
	
	for($i=1;$i<=$pap;$i++){
		$papertitle = $_POST['papertitle'.$i];
		$paperquery = "INSERT INTO `conferencepapers`(`appid`, `conferenceid`, `papertitle`, `datecreated`) VALUES ('$appid', '$conferenceid', '$papertitle', '$dates')";	
	$paperquery = $conn->prepare($paperquery);
	$paperquery->execute();	
	
$papquery = "SELECT paperid FROM conferencepapers where papertitle = '$papertitle'";
	$papquery = $conn->prepare($papquery);
	$papquery->execute();
	$papq = $papquery ->fetch(PDO::FETCH_ASSOC);
	$paperid = $papq['paperid'];
		
		$authors = $_POST['authorstaffid'.$i];
		//print_r( $authors);
		//$authorids = explode(',',$authors);
		//print_r($authorids);
		$authorcount = count($authors);
		
		for($j=0;$j<$authorcount;$j++){
		$author = $authors[$j];
$authorsquery = "INSERT INTO `paperauthors`(`appid`, `conferenceid`, `clusterid`, `paperid`, `authorstaffid`, `contributionrank`, `attendancestatus`, `datecreated`) VALUES ('$appid', '$conferenceid', '$clusterid', '$paperid', '$author', '1', '1', '$dates')";
	$authorsquery = $conn->prepare($authorsquery);
		$authorsquery ->execute();
		}
		}
	
//$budgetquery = "INSERT INTO `conferencebudget`(`appid`, `conferenceid`, `clusterid`, `description`, `cost`, `datecreated`) VALUES ('$appid', '$conferenceid', '$clusterid', '$description', '$cost', '$dates')";
	//$budgetquery = $conn->prepare($budgetquery);
	//$budgetquery->execute();
		
}



if(isset($_SESSION['loginid']) && $_SESSION['loginid'] !='' ){
	//$staffid = test_input($_SESSION['loginid']);
	$idno= $_SESSION['loginid'];
	$unit = implode(',', array_map(function($el){return $el['unit']; }, get_user($idno)));
	$cat = implode(',', array_map(function($el){return $el['category']; }, get_user($idno)));
	
	if($cat == 'acs'){
		if($unit > 0)
			if(!empty(get_unit($conn, $unit))){
				$deptid = implode(',',array_map(function($el){return $el['dept']; }, get_user($conn, $unit)));
				$unit = implode(',',array_map(function($el){return $el['location']; }, get_user($conn, $deptid)));
			}
	}

	else{
		if ($unit > 0 || $unit !='')
			if(!empty(get_unit($conn, $unit)))
				$unit = implode(',', array_map(function($el){ return $el['location']; }, get_unit($conn, $unit)));
	}
	$idno = $_SESSION['loginid'];
	$stmt3=$conn->prepare("select * from pdata where idno= '$idno'");
	$stmt3-> execute();			
	$data3 = $stmt3->fetch(PDO::FETCH_ASSOC);
	
	$sname = $data3['sname'];
	$fname = $data3['fname'];
	$mname = $data3['mname'];
	$title = $data3['title'];
  }



?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<title>CONFERENCE SUPPORT APPLICATION FORM (International) - Covenant University</title>

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
								<h1 class="text-primary">CONFERENCE SUPPORT APPLICATION FORM - Covenant University</h1>
							</div>
							<div class="col-lg-8">
								<article class="margin-bottom-xxl">
									<p class="lead">
										(International).
									</p>
								</article>
							</div>
						</div>

						<!-- BEGIN FORM WIZARD -->
						<div class="row">
							<div class="col-lg-12">
								<div class="card">
									<div class="card-body ">
										<div id="rootwizard2" class="form-wizard form-wizard-horizontal">
											<form class="form floating-label form-validation" role="form" method="post" novalidate="novalidate">
												<div class="form-wizard-nav">
													<div class="progress"><div class="progress-bar progress-bar-primary"></div></div>
													<ul class="nav nav-justified">
														<li class="active"><a href="#tab1" data-toggle="tab"><span class="step">1</span> <span class="title">CLUSTER INFORMATION</span></a></li>
														<li><a href="#tab2" data-toggle="tab"><span class="step">2</span> <span class="title">PARTICIPANTS INFORMATION</span></a></li>
														<li><a href="#tab3" data-toggle="tab"><span class="step">3</span> <span class="title">CONFERENCE INFORMATION</span></a></li>
														<li><a href="#tab4" data-toggle="tab"><span class="step">4</span> <span class="title">BUDGET</span></a></li>
													</ul>
												</div><!--end .form-wizard-nav -->
												<div class="tab-content clearfix">
													<div class="tab-pane active" id="tab1">
														<br/><br/>
														<div class="form-group">
																<select id="conferenceid" name="conferenceid" class="form-control">
																	<option value="">&nbsp;</option>
																	<?php
																	$cquery = $conn->prepare("SELECT * FROM conferencereg where status=1");
																	$cquery->execute();
																	$data=$cquery->fetchAll();
																	foreach($data as $da1){
																		echo "<option value= '".$da1['id'] . "'>". ucwords($da1['conferencename'])."</option>";
																	}
																	?>																	
																</select>
																<label for="conferenceid">Select Conference Title</label>
														</div>
														<div class="form-group">
															<select id="clusterid" name="clusterid" class="form-control" >
																	  <option value = ''>&nbsp;</option>
																		<?php  
																		
																		$stmt1 = $conn->prepare("SELECT * FROM clustername where clusterstatus=1"); 
																		$stmt1->execute();
																		$data1=$stmt1->fetchAll();
																		foreach($data1 as $dat){
																			echo "<option value= '".$dat['id'] . "'>". ucwords($dat['clustername'])."</option>";
																		}
																		?>
																</select>
															<label for="clusterid" class="control-label">Select Cluster Name</label>
														</div>	
													<!--	<div class="form-group">
															<input type="number" name="papers" id="papers" class="form-control">
															<label for="papers" class="control-label">Number of Accepted Papers</label>
															<p class="help-block">Numbers only</p>
														</div> -->
													<!--<div class="row" id="paperdetails">
														</div> -->
														<!--	<div class="col-sm-4">
															<div class="form-group">
																<input type="text" name="authors" id="authors" class="form-control">
																<label for="authors" class="control-label">No of Authors</label>
															</div>
														</div> -->
									
														<div class="row" id="row1">
															 <div class="col-sm-5">
																<div class="form-group">
																	<div><input type="hidden" value = '2' id="pap" name="pap" ></div>
																	<textarea type="text" name="papertitle1" id="papertitle" class="form-control" required></textarea>
																	<label for="papers" class="control-label">Title of Accepted Paper</label>
																</div>
															</div>
															<div class="form-group col-sm-7">
																<select name="authorstaffid1[]" class="form-control select2-list" data-placeholder="Select paper authors" multiple required>
																	<option value = ''>&nbsp;</option>
																		<?php  
																		$stmt = $conn->prepare("SELECT * FROM clustermembers where clustermemberstatus=1"); 
																		$stmt->execute();
																		$data2=$stmt->fetchAll();
																		
																		// foreach($data2 as $dat1){
																			// $result = array();
																			// $staff = getauthorname($conn,$dat1['staffid']);
																			// $clustername = getclustername($conn,$dat1['clusterid']);
																			// $result['text'] =  ucwords($staff['sname'])." ". ucwords($staff['fname']) ." ". ucwords($staff['mname']) ." - ". $clustername['clustername'];
																			// $result['id'] = $dat1['id'];
																			// array_push($output, $result);
																			// echo "<option value= '".$dat1['id'] . "'>". ucwords($staff['sname'])." ". ucwords($staff['fname']) ." ". ucwords($staff['mname']) ." - ". $clustername['clustername']."</option>";
																		// }
																		
																		foreach($data2 as $dat1){
																			$staff = getauthorname($conn,$dat1['staffid']);
																			$clustername = getclustername($conn,$dat1['clusterid']);
																			echo "<option value= '".$dat1['id'] . "'>". ucwords($staff['sname'])." ". ucwords($staff['fname']) ." ". ucwords($staff['mname']) ." - ". $clustername['clustername']."</option>";
																		}
																		?>
																</select>
															</div>
															
														</div>
														
														<div class="row" id="row2">
															 <div class="col-sm-5">
																<div class="form-group">
																	<textarea type="text" name="papertitle2" id="papertitle1" class="form-control" required></textarea>
																	<label for="papers1" class="control-label">Title of Accepted Paper</label>
																</div>
															</div>
															<div class="form-group col-sm-7">
																<select name="authorstaffid2[]" class="form-control select2-list" data-placeholder="Select paper authors" multiple required>
																	<option value = ''>&nbsp;</option>
																		<?php  
																		$stmt = $conn->prepare("SELECT * FROM clustermembers where clustermemberstatus=1"); 
																		$stmt->execute();
																		$data2=$stmt->fetchAll();
										
																		
																			foreach($data2 as $dat1){
																			$staff = getauthorname($conn,$dat1['staffid']);
																			$clustername = getclustername($conn,$dat1['clusterid']);
																			echo "<option value= '".$dat1['id'] . "'>". ucwords($staff['sname'])." ". ucwords($staff['fname']) ." ". ucwords($staff['mname']) ." - ". $clustername['clustername']."</option>";
																		}
																		?>
																</select>
															</div>
															
														</div>
														
														
														
														<div id="authorcluster">
														</div>
														<button id="addpaper" type="button" class="btn ink-reaction btn-raised btn-primary">ADD PAPER</button>
														<input type="submit" id="save1" name="save1" class="btn btn-success pull-right" value="save">
													</div><!--end #tab1 -->
													<!-- #tab2 -->
													<div class="tab-pane" id="tab2">
														<section class="style-default-bright">
															<div class="section-body">
																<h2 class="text-primary">Paper 1</h2>
																<button id="addcustaff" type="button" class="btn ink-reaction btn-raised btn-primary ">ADD</button>
																<table class="table table-hover">
																	<thead>
																		<tr>
																			<th>S/N</th>
																			<td>Title</td>
																			<th>Name</th>
																			<th><?php echo $cat == 'acs'? 'Department': 'Department' ?></th>
																			<th>Conference Status</th>
																			<th>Designation</th>																			
																			<th class="text-right">Actions</th>
																		</tr>
																	</thead>
																	<tbody id="tester" >
																		<tr>
																			<td>1</td>
																			<input class="form-control" type="hidden" readonly="readonly" id="idno" name="idno1" value="<?php echo $idno; ?>">
																			<td><input type="text" readonly="readonly" id="title" name="title1" class="form-control" value="<?php echo $title; ?>"></td>
																			<td><input type="text" readonly="readonly" name="name1" id="name1" class="form-control" value="<?php echo $sname." ".$fname." ".$mname ; ?>"></td>
																			<td><input type="text" readonly="readonly" name="dept1" id="dept1" class="form-control" value="<?php echo $unit ; ?>"></td>
																			<td><select type="text" name="status1" id="status1" class="form-control">
																				<option value = ""> </option>
																				<option>Attending</option>
																				<option>Not Attending</option>
																			</select></td>
																			<td><input type="text" name="desg1" id="desg1" class="form-control"></td>
																		<!--	<td class="text-right">
																				<button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash-o"></i></button>
																			</td>
																		</tr>	-->																	
																	</tbody>
																</table>
																<h2 class="text-primary">For Non Covenant University Staff</h2>
																<button id="addnoncustaff" type="button" class="btn ink-reaction btn-raised btn-primary">ADD</button>
																<table class="table table-hover">
																	<thead>
																		<tr>
																			<th>S/N</th>
																			<td>Title</td>
																			<th>Name</th>
																			<th>University</th>
																			<th>Department</th>
																			<th>Designation</th>																			
																			<th class="text-right">Actions</th>
																		</tr>
																	</thead>
																	<tbody id="collab">
																		<tr>
																			<td>1</td>
																			<td><input type="text" id="title2" name="title2" class="form-control"></td>
																			<td><input type="text" name="name2" id="name2" class="form-control"></td>
																			<td><input type="text" name="university1" id="university1" class="form-control"></td>
																			<td><input type="text" name="dept2" id="dept2" class="form-control"></td>
																			<td><input type="text" name="desg2" id="desg2" class="form-control"></td>
																			<!-- <td class="text-right">
																				<button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash-o"></i></button>
																			</td> -->
																		</tr>																		
																	</tbody>
																</table>

															</div><!--end .section-body -->
														</section>
														<input type="submit" id="save2" name="save2" class="btn btn-success pull-right" value="save">
													</div><!--end #tab2 -->
													<!-- #tab3 -->
													<div class="tab-pane" id="tab3">
														<br/><br/>
														<div class="form-group">
															<input type="text" name="cpci" id="cpci" class="form-control">
															<label for="cpci" class="control-label">Conference Proceeding Citation Index</label>
														</div>
														<div class="form-group">
															<select id="country" name="country" class="form-control" >
																	  <option value = ''>&nbsp;</option>
																		<?php  
																		
																		$stmt1 = $conn->prepare("SELECT * FROM countries where countrystatus=1"); 
																		$stmt1->execute();
																		$data2=$stmt1->fetchAll();
																		foreach($data2 as $dat1){
																			echo "<option value= '".$dat1['countryid'] . "'>". ucwords($dat1['country'])."</option>";
																		}
																		?>
																</select>
																<label for="Country" class="control-label">Country</label>
															<!-- <select id="select1" name="select1" class="form-control">
																<option value="">&nbsp;</option>
																<option value="30">30</option>
																<option value="40">40</option>
																<option value="50">50</option>
																<option value="60">60</option>
																<option value="70">70</option>
															</select> -->
															
														</div>
															<div class="col-sm-8">
																<div class="form-group">
																	<input type="text" name="city" id="city" class="form-control">
																	<label for="city" class="control-label">City</label>
																</div>
															</div>
															<div class="col-sm-4">
																<div class="form-group">
																	<input type="text" name="state" id="state" class="form-control">
																	<label for="state" class="control-label">State</label>
																</div>
															</div>
															<div class="col-sm-4">
																<div class="form-group">
																	<input type="text" name="startdate" id="from" class="form-control">
																	<label for="from" class="control-label">Start Date</label>
																</div>
															</div>
															<div class="col-sm-4">
																<div class="form-group">
																	<input type="text" name="enddate" id="to" class="form-control">
																	<label for="to" class="control-label">End Date</label>
																</div>
															</div>															
															<div class="col-sm-12">
																<div class="form-group">
																	<textarea type="text" name="objectives" id="objectives" class="form-control"></textarea>
																	<label for="objectives" class="control-label">Conference Objectives</label>
																	<p class="help-block">list conference objectives</p>
																</div>
															</div>
														<!--	<div class="col-sm-8">
																<div class="form-group">
																	<textarea type="text" name="objective2" id="objective2" class="form-control"></textarea>
																	<label for="objective2" class="control-label">Conference Objectives</label>
																	<p class="help-block">objective 2</p>
																</div>
															</div>
															<div class="col-sm-8">
																<div class="form-group">
																	<textarea type="text" name="objective3" id="objective3" class="form-control"></textarea>
																	<label for="objective3" class="control-label">Conference Objectives</label>
																	<p class="help-block">objective 3</p>
																</div>
															</div>  -->
															<div class="col-sm-8">
																<div class="form-group">
																	<input type="text" name="cpciconferences" id="cpciconferences" class="form-control">
																	<label for="cpciconferences" class="control-label">How many CPCI conferences Have You Been Sponsored To Attend?</label>
																</div>
															</div>
															<div class="col-sm-8">
																<div class="form-group">
																	<input type="text" name="paperspublished" id="paperspublished" class="form-control">
																	<label for="paperspublished" class="control-label">How many of the papers have been published?</label>
																</div>
															</div>
															<div class="col-sm-8">
																<div class="form-group">
																	<textarea type="text" name="contributions" id="contributions" class="form-control"></textarea>
																	<label for="contributions" class="control-label">Expected Contributions</label>
																</div>
															</div>
															<div class="col-sm-8">
																<div class="form-group">
																	<textarea type="text" name="role" id="role" class="form-control"></textarea>
																	<label for="role" class="control-label">Indicate role at conference</label>
																</div>
															</div>
															<br/><br/>
														<input type="submit" id="save3" name="save3" class="btn btn-success pull-right" value="save">
													</div><!--end #tab3 -->
													
													<div class="tab-pane" id="tab4">
														<h2 class="text-primary">Conference Budget</h2>
														<button id="addbudgettype" type="button" class="btn ink-reaction btn-raised btn-primary">ADD</button>
														<table class="table table-hover">														
																	<thead>
																		<tr>
																			<th>S/N</th>																			
																			<th>Description</th>
																			<th>Cost (dollars)</th>																																					
																			<th class="text-right">Actions</th>
																		</tr>
																	</thead>
																	<tbody id="testing">
																		<tr>
																			<td>1</td>																			
																			<td><input type="text" name="desc1" id="desc1" class="form-control"></td>
																			<td><input type="text" name="cost1" id="cost1" class="form-control"></td>												
																		<!--	<td class="text-right">
																				<button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash-o"></i></button>
																			</td>
																		</tr>	-->																	
																	</tbody>
														</table>
																<input type="submit" id="save4" name="save4" class="btn btn-success pull-right" value="save">
																<input type="submit" id="submitform" name="submitform" class="btn btn-success pull-right" value="submit">
													</div><!--end #tab4 -->
												</div><!--end .tab-content -->
												<ul class="pager wizard">								
													<li class="previous"><a class="btn-raised" href="javascript:void(0);">Previous</a></li>													
													<li class="next"><a class="btn-raised" href="javascript:void(0);">Next</a></li>
												</ul>
												
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
		
	<script>
			 var count = 2;
			$(document).ready(function(){
				
				function daterange(startdate,enddate) {
				//the date range stuff
					var dateFormat = "mm/dd/yy",
					from = $( startdate ).datepicker({
						defaultDate: "+1w",
						changeMonth: true,
						changeYear: true
					})
					.on( "change", function() {
						to.datepicker( "option", "minDate", getDate( this ) );
					}),
					to = $( enddate ).datepicker({
						defaultDate: "+1w",
						changeMonth: true,
						changeYear: true
					})
					.on( "change", function() {
						from.datepicker( "option", "maxDate", getDate( this ) );
					});
					function getDate( element ) {
						var date;
						try {
							date = $.datepicker.parseDate( dateFormat, element.value );
						} catch( error ) {
							date = null;
						}
						return date;
					}
					$('.dates').on('keyup', function(){
						if(/^\d{4}-((0\d)|(1[012]))-(([012]\d)|3[01])$/.test($(this).val()) == false){
							$(this).val('');
						}
					});
					$(startdate).on('change', function(){
						$(enddate).val('');
					});
				//code
				
			 }
			 $('#addmember').on('click', function(){
				 alert('');
			 });
				daterange('#from','#to');
				$( "#tabs" ).tabs();
				
				//begin appending for title of paper and no of authors
				$('#addpaper').on('click',function(){
					//$('#authorcluster').html('');
					// var array = <?php print_r(json_encode($output)); ?>;
					//console.log('asfas'+array);
					// var author = "";
					// for(var i = 0; i < array.length; i++){
						// author += '<option value = "'+ array[i].id +'">'+ array[i].text +'</option>';
					// }
					if(count <= 9){
					++count;
					$('#pap').val(count);
						var addpapers = '';
						//var paper = $('#papers').val();
						 addpapers = '<div class="row" id="row'+count+'">'+
									 '<div class="col-sm-5">'+
										'<div class="form-group">'+
											'<textarea type="text" name="papertitle'+ count +'" id="papertitle'+ count +'" class="titlefield form-control"></textarea>'+
											'<label for="papertitle'+ count +'" class="control-label">Title of Accepted Paper</label>'+
										'</div>'+
									'</div>'+
									'<div class="form-group col-sm-6">'+
										'<select id="authorstaffid'+ count +'" name="clustername'+ count +'[]" class="form-control select2-list" data-placeholder="Select paper authors" multiple>'+
											
										'</select>'+
										
										//'<select id="authorstaffid'+ count +'" name="clustername'+ count +'" class="form-control select2-list" data-placeholder="Select paper authors" multiple>'+
											//'<option id = "clusternames" value = "">&nbsp;</option>'+
										//'</select>'+
									'</div>'+
									'<button type="button" id="rem'+count+'" class="paperfield btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash-o"></i></button>'+
								'</div>';

		
						$('#authorcluster').append(addpapers);
						
						$(".select2-list").select2({
							allowClear: true
						});
						
						var clusterstatus = '1';
						//alert (staffid);
						
						
						$.ajax({
						url:'../include/csaajax.php',
						data:{
							clusterstatus:clusterstatus
						},
						type:'POST',
						dataType:'JSON',
						success:function(clus){
							console.log(clus);
							var authors = "";
							for(var i = 0; i < clus.length; i++){
								authors += '<option value = "'+ clus[i].id +'">'+ clus[i].text +'</option>';
							}
							
							$('#authorstaffid'+count).append(authors);
						
											
							}
							
						});
					}
					
				});
					//java script to remove appended rows dynamically;	
				$('#authorcluster').on("click",".paperfield", function(e){ //user click on remove text
					e.preventDefault();
					id = $(this).attr('id').replace('rem', '')
					$("#row"+id).remove(); 
					--count;
					//js to loop through all the fields and rename them;
					$('.titlefield').each(function(j, obj){
						
						num = obj['name'].replace('papertitle', '');
						$('[name = ' + obj['name'] + ']').attr('name', 'papertitle' + ((j*1) + 3));
						$('[name = ' + obj['name'] + ']').attr('id', 'papertitle' + ((j*1) + 3));
						$('[for = papertitle' + num + ']').html('papertitle ' + ((j*1) + 3));
						$('[for = papertitle' + num + ']').attr('for', 'papertitle' + ((j*1) + 3));
						$('#rem' + num  ).attr('id', 'rem' + ((j*1) + 3));
						$('#row' + num ).attr('id', 'row' + ((j*1) + 3));
						$('#authorstaffid' + num  ).attr('name', 'authorstaffid' + ((j*1) + 3));
						$('#authorstaffid' + num ).attr('id', 'authorstaffid' + ((j*1) + 3));
						
						console.log(num);
						count = ((j*1) + 3)
						//i = (j * 1) + 2;
					});
					$('#pap').val(count);
				
				});
				//end of append for title and authors of papers;
							
				$('#staffname'+countid).on('change',function(){
				//alert ('yo');
				
			});
				
				//BEGIN APPEND FOR CU STAFF INFO TABLE
			var max_fields = 10; //maximum input boxes allowed
			var wrapper = $('#tester'); //Fields wrapper
			var addcustaff = $('#addcustaff');
			
			var x = 1;
			var countid = 1;
			$(addcustaff).click(function(e){
				countid++;
				e.preventDefault();
			if(x < max_fields){
				x++;
				$(wrapper).append(
					
					'<tr id="blabla">'+
						'<td>'+countid+'</td>'+
						'<td><input type="text" id="title1'+countid+'" name="title'+countid+'"class="form-control"></td>'+
						'<td><select type="text" name="name1'+countid+'" id="staffname'+countid+'"class="form-control"></select></td>'+
						'<td><input type="text" name="dept1'+countid+'" id="dept1'+countid+'" class="form-control"></td>'+
						'<td><select type="text" name="status1'+countid+'" id="status1'+countid+'" class="form-control">'+
							'<option value = ""> </option>'+
							'<option>Attending</option>'+
							'<option>Not Attending</option>'+
						'</select></td>'+
						'<td><input type="text" name="desg1'+countid+'" id="desg1'+countid+'" class="form-control"></td>'+
						'<td class="text-right">'+
							'<button type="button" class="btn btn-icon-toggle remove_field" data-toggle="tooltip" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash-o"></i></button>'+
						'</td>'+				
					'</tr>'
					
				);
			  }
			  
			  
			  //ajax code for fetching name, title and department for appended table rowws
			var userid = $('#idno').val();
			var status = 'active';
			$.ajax({
				url:'../include/csaajax.php',
				data:{
					status:status,userid:userid
				},
				type:'POST',
				dataType:'JSON',
				success:function(csa){
					//alert (csa[0][0]);
					var staffdetails = '<option disabled selected> Please Choose </option> ';
					var clusternames = '<option disabled selected> Please Choose </option> ';
					for(i=0;i<csa[0].length;i++){
					console.log('csa' + csa[0]);
					staffdetails += '<option value="'+csa[0][i]['idno']+'"> '+ csa[0][i]['sname'] + ' ' + csa[0][i]['fname']+' '+csa[0][i]['mname'] +'</option> ';
									
					}
					$('#staffname'+countid).html(staffdetails);
				}
			});
			
			$('#staffname'+countid).on('change',function(){
				//alert ('yo');
				var staffid = $('#staffname'+countid+' option:selected').val();
				//alert (staffid);
				
				
				$.ajax({
				url:'../include/csaajax.php',
				data:{
					staffid:staffid
				},
				type:'POST',
				dataType:'JSON',
				success:function(sta){
				//	alert (sta[0]['id']);
				$('#title1'+countid).val(sta[0]['title']);
				$('#dept1'+countid).val(sta[1]);
									
					}
					
				});
			});
			//end of ajax code for fetching name title and department to appended table rowws
			  
			});
			$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
			e.preventDefault();
			$("#blabla").remove(); 
			--countid;		
			});//END APPEND FOR CU STAFF INFO TABLE
			
			//BEGIN APPEND FOR NON CU STAFF INFO TABLE
			var maxfields = 10;
			var wrapper1 = $('#collab');
			var addnoncustaff = $('#addnoncustaff');
			
			var z = 1;
			var countid2 = 1;
			$(addnoncustaff).click(function(e){
				countid2++;
				e.preventDefault();
				if(z < maxfields){
					++z;
					$(wrapper1).append(
						'<tr id="asdf">'+
						'<td>'+countid2+'</td>'+
							'<td><input type="text" id="title2'+countid2+'" name="title2'+countid2+'" class="form-control"></td>'+
								'<td><input type="text" name="name2'+countid2+'" id="name2'+countid2+'" class="form-control"></td>'+
								'<td><input type="text" name="university1'+countid2+'" id="university1'+countid2+'" class="form-control"></td>'+
								'<td><input type="text" name="dept2'+countid2+'" id="dept2'+countid2+'" class="form-control"></td>'+
								'<td><input type="text" name="desg2'+countid2+'" id="desg2'+countid2+'" class="form-control"></td>'+
								'<td class="text-right">'+
									'<button type="button" class="btn btn-icon-toggle removefield" data-toggle="tooltip" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash-o"></i></button>'+
								'</td>'+
							'</tr>'
					)
				}
				});
				$(wrapper1).on("click",".removefield", function(e){ //user click on remove text
					e.preventDefault();
					$("#asdf").remove(); 
					--countid2;		
					});
			
			//END APPEND FOR NON CU STAFF INFO TABLE
			
			//BEGIN APPEND FOR BUDGET TABLE
			var maximum_fields = 10; //maximum input boxes allowed
			var wrapper2 = $('#testing'); //Fields wrapper
			var addbudgettype = $('#addbudgettype');
			
			var y = 1;
			var countid1 = 1;
			$(addbudgettype).click(function(e){ 
				countid1++;
				e.preventDefault();	
				if (y < maximum_fields){
					++y;
					$(wrapper2).append(
						'<tr id="yumyum">'+	
							'<td>'+countid1+'</td>'+
							'<td><input type="text" name="desc1'+countid1+'" id="desc1'+countid1+'" class="form-control"></td>'+
							'<td><input type="text" name="cost'+countid1+'1" id="cost1'+countid1+'" class="form-control"></td>'+												
							'<td class="text-right">'+
								'<button type="button" class="btn btn-icon-toggle delete_field" data-toggle="tooltip" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash-o"></i></button>'+
							'</td>'+
						'</tr>'
					
					);
				}
			});
			$(wrapper2).on("click",".delete_field", function(e){ //user click on remove text
			e.preventDefault();
			$("#yumyum").remove(); 
			--countid1;		
			});
			
			//END APPEND FOR BUDGET TABLE

			
				
			});
			
			
			</script>
			<!-- END JAVASCRIPT -->

		
	</body>
</html>
