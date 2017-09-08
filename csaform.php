<?php
include_once ('../include/config.php');
include_once ('../include/covenantportalfunctions.php');
include_once ('../include/functions.php');
session_start();
$_SESSION['loginid'] = 'CU1234';

$pistaffid = $_SESSION['loginid'];

//dont delete
$output = array();


if(isset($_POST['save1']))
{
	extract($_POST);
	$dates = date("Y-m-d H:i:s" );
	$sdate = date('Y-m-d', strtotime($startdate));
	$edate = date('Y-m-d', strtotime($enddate));
	$confregno = confregno($conn);
	
$confquery = "INSERT INTO `conferencesupport`(`confappid`, `conferenceid`, `clusterid`, `cpci`, `country`, `city`, `address`, `startdate`, `enddate`, `objectives`, `pistaffid`, `applicationstatus`, `datesubmitted`)
 VALUES ('$confregno', '$conferenceid', '$clusterid', '$cpci', '$country', '$city', '$address', '$sdate', '$edate', '$objectives', '$pistaffid', '0', '$dates')";
	$confquery = $conn->prepare($confquery); 
	$confquery -> execute();
	
	$stmtquery  = "SELECT confappid FROM conferencesupport where clusterid ='$clusterid'";
	$stmtquery = $conn->prepare($stmtquery);
		$stmtquery->execute();
		$stmtq = $stmtquery ->fetch(PDO::FETCH_ASSOC);
		$confappid=$stmtq['confappid'];
		
	$papercount = $totalpapercount;
	for($i= 1; $i<= $papercount;$i++){
		$mpapertitle = $_POST['papertitle'.$i];
		$authpapercount = $_POST['authcount'.$i];
		//echo '<Br/><Br/>'. $i . ' has ' . $authpapercount;	
		$paperquery = "INSERT INTO `conferencepapers`(`confappid`, `conferenceid`, `clusterid`, `papertitle`, `datecreated`) VALUES ('$confappid', '$conferenceid', '$clusterid', '$mpapertitle', '$dates')";	
		$paperquery = $conn->prepare($paperquery);
		$paperquery->execute();	
		
	
	
		$papquery = "SELECT paperid FROM conferencepapers where papertitle = '$mpapertitle'";
		$papquery = $conn->prepare($papquery);
		$papquery->execute();
		$papq = $papquery ->fetch(PDO::FETCH_ASSOC);
		$paperid = $papq['paperid'];

		for($j = 1; $j<= $authpapercount; $j++){
			$name = $_POST['name'.$i.$j];
			$attendance = $_POST['attendance'.$i.$j];
			$rank = $_POST['rank'.$i.$j];
			
			//echo '<br/>'.$i. ' - '.$j . $_POST['name'.$i.$j];
			
			$authorsquery = "INSERT INTO `paperauthors`(`confappid`, `conferenceid`, `clusterid`, `paperid`, `authorstaffid`, `contributionrank`, `attendancestatus`, `datecreated`) VALUES ('$confappid', '$conferenceid', '$clusterid', '$paperid', '$name', '$rank', '$attendance', '$dates')";
			$authorsquery = $conn->prepare($authorsquery);
			$authorsquery ->execute();
				
			
		}
	
	
	
	
	}
		//print_r ($confquery);
		
/* $stmtquery  = "SELECT confappid FROM conferencesupport where clusterid ='$clusterid'";
	$stmtquery = $conn->prepare($stmtquery);
		$stmtquery->execute();
		$stmtq = $stmtquery ->fetch(PDO::FETCH_ASSOC);
		$confappid=$stmtq['confappid']; */
		
	
	/* for($i=1;$i<=$pap;$i++){
		$papertitle = $_POST['papertitle'.$i];
		$paperquery = "INSERT INTO `conferencepapers`(`confappid`, `conferenceid`, `clusterid`, `papertitle`, `datecreated`) VALUES ('$confappid', '$conferenceid', '$clusterid', '$papertitle', '$dates')";	
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
$authorsquery = "INSERT INTO `paperauthors`(`confappid`, `conferenceid`, `clusterid`, `paperid`, `authorstaffid`, `contributionrank`, `attendancestatus`, `datecreated`) VALUES ('$confappid', '$conferenceid', '$clusterid', '$paperid', '$author', '1', '1', '$dates')";
	$authorsquery = $conn->prepare($authorsquery);
		$authorsquery ->execute();
		
		$_SESSION['conferenceid'] = $conferenceid;
		$_SESSION['clusterid'] = $clusterid;
			}
		} */
	
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
		<title>Conference Support Application Form (International) - Covenant University</title>

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
								<h1 class="text-primary">Conference Support Application Form - Covenant University</h1>
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
														<li class="active"><a href="#tab1" data-toggle="tab"><span class="step">1</span> <span class="title">CONFERENCE INFORMATION</span></a></li>
														<li><a href="#tab2" data-toggle="tab"><span class="step">2</span> <span class="title">PAPERS</span></a></li>
													</ul>
												</div><!--end .form-wizard-nav -->
												<div class="tab-content clearfix">
													<div class="tab-pane active" id="tab1">
														<br/><br/>
														<div class="form-group">
															<select id="clusterid" name="clusterid" class="form-control" >
																	  <option value = ''>&nbsp;</option>
																		<?php  
																		
																		$stmt1 = $conn->prepare("SELECT * FROM clusterreg where status=1"); 
																		$stmt1->execute();
																		$data1=$stmt1->fetchAll();
																		foreach($data1 as $dat){
																			echo "<option value= '".$dat['id'] . "'>". ucwords($dat['clustername'])."</option>";
																		}
																		?>
																</select>
															<label for="clusterid" class="control-label">Select Cluster Name</label>
														</div>
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
															
															
														</div>
															<div class="col-sm-4">
																<div class="form-group">
																	<input type="text" name="city" id="city" class="form-control">
																	<label for="city" class="control-label">City</label>
																</div>
															</div>
															<div class="col-sm-8">
																<div class="form-group">
																	<input type="text" name="address" id="address" class="form-control">
																	<label for="address" class="control-label">Address</label>
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
														
													</div><!--end #tab1 -->
													<!-- #tab2 -->
													<div class="tab-pane" id="tab2">
														<div id="firstdiv" class="row">
															<section class="style-default-bright" id="papersection1">
																
																<input class="form-control" onkeyup="writeTitle(this,1)" name="papertitle1" placeholder="Input Title of Paper 1"/>
																</br>
																<button id="addauthor1" type="button" onclick="addnewauthor(1)" class="btn btn-raised btn-default addauthor"> Add Authors 1</button>
																<table class="table table-hover">
																		<thead>
																			<tr>
																				<th>S/N</th>
																				<th>Name</th>
																				<!--<th><?php// echo $cat == 'acs'? 'Department': 'Department' ?></th> -->
																				<th>Contribution Rank</th>																			
																				<th>Attendance Status</th>
																				<th>Remove</th>
																			</tr>
																		</thead>
																		<tbody id="authorsbody1" >
																			<tr><td id = 'sn11'>1</td><td><select onchange="writeName(this,1,1)" id="name11" name = 'name11' class = 'form-control'></select></td>
																			<td><select type = 'text' name = 'rank11' onchange="writeRank(this,1,1)" id="rank11" class = 'form-control'>
																			<option value = ""></option><option value = "1st">1st</option><option value = "2st">2nd</option><option value = "3rd">3rd</option><option value = "4th">4th</option><option value = "5th">5th</option>
																			</select></td>
																			<td><select type = 'text' name = 'attendance11' onchange="writeAttendance(this,1,1)" id="attendance11" class = 'form-control'>
																				<option value = ""> </option>
																				<option value = "Attending">Attending</option>
																				<option value = "Not Attending">Not Attending</option>
																				</select>
																				</td>
																			</tr>	
																		</tbody>
																	</table>
																	<input type="hidden" id="authcount1" name="authcount1" />
															</section>
															
														<section class="style-default-bright" id="papersection2">
															
															<input class="form-control" onkeyup="writeTitle(this,2)" name="papertitle2" placeholder="Input Title of Paper 2"/>
															</br>
															<button type="button" id="addauthor2" onclick="addnewauthor(2)" class="btn btn-raised btn-default addauthor"> Add Authors 2</button>
															<table class="table table-hover">
																	<thead>
																		<tr>
																			<th>S/N</th>
																			<th>Name</th>
																			<!--<th><?php// echo $cat == 'acs'? 'Department': 'Department' ?></th> -->
																			<th>Contribution Rank</th>																			
																			<th>Attendance Status</th>
																			<th>Remove</th>
																		</tr>
																	</thead>
																	<tbody id="authorsbody2" >
																	
																		<tr><td id = 'sn21'>1</td>
																		<td><select onchange="writeName(this,2,1)" id="name21" name = 'name21' class = 'form-control'></select></td>
																		<td><select type = 'text' name = 'rank21' onchange="writeRank(this,2,1)" id="rank21" class = 'form-control'>
																		<option value = ""></option><option value = "1st">1st</option><option value = "2nd">2nd</option><option value = "3rd">3rd</option><option value = "4th">4th</option><option value = "5th">5th</option>
																		</select></td>
																		<td><select type = 'text' name = 'attendance21' onchange="writeAttendance(this,2,1)" id="attendance21" class = 'form-control'>
																				<option value = ""> </option>
																				<option value = "Attending">Attending</option>
																				<option value = "Not Attending">Not Attending</option>
																		</select></td>
																		</tr>																	
																	</tbody>
																</table>
																<input type="hidden" id="authcount2" name="authcount2" />		
														</section>
													</div>
														<button id="addpapers" type="button" class="btn btn-raised btn-lg btn-success btn-default addpaper">Add Papers</button>
														<input id="totalpapercount"  type="hidden" name = "totalpapercount"/>
														<input type="submit" id="save1" name="save1" class="btn btn-success pull-right" value="submit">
													</div><!--end #tab2 -->
											
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
				var paperlimit = 2;
				var clusterstatus = '1';
				var authorcount = 1;
				var paperobj = new Paper(paperlimit);
				var paper1 = new Paper(1);
				var paper2 = new Paper(2);
				
				var paper1author = new Author(1,1);
				var paper2author = new Author(2,1);
				paper1.count = 1;
				paper2.count = 1;
				paper1.authors = [paper1author];
				paper2.authors = [paper2author];
				var new_paper = "";
				var new_author = "";
				var papers = [paper1, paper2];

			$(document).ready(function(){
				//  
				daterange('#from','#to');
				$( "#tabs" ).tabs();
				
				$('#totalpapercount').val(papers.length);
				
				$('#authcount1').val(paper1.count);
				$('#authcount2').val(paper2.count);
				
				
				$.ajax({
						url:'../include/csaajax.php',
						data:{
							clusterstatus:clusterstatus
						},
						type:'POST',
						dataType:'JSON',
						success:function(clus){
							console.log(clus);
							var authors = '<option>Select an Author</option>';
							for(var i = 0; i < clus.length; i++){
								authors += '<option value = "'+ clus[i].staffid +'">'+ clus[i].text +'</option>';
							}
							
							$('#name11').append(authors);
							$('#name21').append(authors);
						
											
							}
							
						});
						
				$('#addpapers').on('click', function(){
					++paperlimit;
					if(paperlimit <= 10){
					   paperobj = new Paper(paperlimit);
					   authorcount = 1;
					   var authoradded = new Author(paperobj.id, authorcount);
					   paperobj.count = authorcount;
					   new_paper = '<section class="style-default-bright" id="papersection'+paperobj.id+'">'+
										'<input id="pap'+paperobj.id+'" name="papertitle'+paperobj.id+'" type="hidden" value="'+paperobj.id+'"/>'+
										'<input type="text" onkeyup="writeTitle(this,'+paperobj.id+')" id="title'+paperobj.id+'"  name="papertitle'+paperobj.id+'" class="form-control" placeholder="Input Title of Paper '+paperobj.id+'"/>'+
										'</br>'+
										'<button type="button" id="addauthor'+paperobj.id+'" onclick="addnewauthor('+paperobj.id+')" class="btn btn-raised btn-default addauthor"> Add Authors '+paperobj.id+'</button>'+
										'<table class="table table-hover">'+
												'<thead>'+
													'<tr>'+
														'<th>S/N</th>'+
														'<th>Name</th>'+
														<!--<th><?php// echo $cat == 'acs'? 'Department': 'Department' ?></th> -->
														
														'<th>Contribution Rank</th>	'+																		
														'<th>Attendance Status</th>'+
													'</tr>'+
												'</thead>'+
												'<tbody id="authorsbody'+paperobj.id+'" >'+
												
												'<tr><td id = "sn'+ paperobj.id +authorcount+'">'+authorcount+'</td>'+
												'<td><select name="name'+paperobj.id+authorcount+'" onchange="writeName(this,'+paperobj.id+','+authorcount+')" id="name'+paperobj.id+authorcount+'" class="form-control"></select></td>'+
												'<td><select name = "rank'+ paperobj.id +authorcount+'" onchange="writeRank(this,'+paperobj.id+','+authorcount+')" id="rank'+paperobj.id+authorcount+'" class = "form-control"><option value = ""></option><option value = "1st">1st</option><option value = "2nd">2nd</option><option value = "3rd">3rd</option><option value = "4th">4th</option><option value = "5th">5th</option></select></td>'+
												'<td><select name = "attendance'+ paperobj.id +authorcount+'" onchange="writeAttendance(this,'+paperobj.id+','+authorcount+')" id="attendance'+paperobj.id+authorcount+'" class = "form-control"><option value = ""></option><option value = "Attending">Attending</option><option value = "Not Attending">Not Attending</option></select></td></tr>' +
												'<input type = "hidden" id = "forpaper'+ paperobj.id +authorcount+'" value = "1">'+													
												'</tbody>'+
											'</table>'+
											'<input type="hidden" id="authcount'+ paperobj.id +'" name="authcount'+ paperobj.id +'" />'+	
											'<td><button type="button" onclick ="removepaper('+ paperobj.id +')" id="removepaper'+ paperobj.id +authorcount+'" class="paperfield btn btn-lg btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash-o"></i></button></td>'+
									'</section>';
						myId =  paperobj.id;
						paperobj.authors.push(authoradded);
						$('#firstdiv').append(new_paper);
						papers.push(paperobj);
						console.log(papers);
						$('#totalpapercount').val(papers.length);
						$('#authcount'+paperobj.id).val(paperobj.count);
						$(".select2-list").select2({
							allowClear: true
						});
						
						
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
							var authors = '<option>Select an Author</option>';
							for(var i = 0; i < clus.length; i++){
								authors += '<option value = "'+ clus[i].staffid +'">'+ clus[i].text +'</option>';
							}
							
							$('#name'+paperobj.id+authorcount).append(authors);
						
											
							}
							
						});
					}
				});
				
						//java script to remove appended rows dynamically;	
				$('#authorsbody1').on("click",".authorfield", function(e){ //user click on remove text
					e.preventDefault();
					id = $(this).attr('id').replace('removeauthor', '')
					$("#authorrow"+id).remove(); 
					--countauthor;
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
				
				//end of appending authors for each paper
				
				//java script to remove appended rows dynamically;	
				$('#firstdiv1').on("click",".paperfield", function(e){ //user click on remove text, ->  i changed firstdiv to firstdiv1
					e.preventDefault();
					id = $(this).attr('id').replace('removepaper', '')
					$("#papersection"+id).remove(); 
					--countpaper;
					//js to loop through all the fields and rename them;
					$('.authorfield').each(function(j, obj){
						
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
			});

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
			 /* $('#addmember').on('click', function(){
				 alert('');
			 }); */
			
			// Paper Class with its properties
			function Paper(id){
				this.id = id;
				this.title = '';
				this.authors = [];
				this.noOfAuthors = 0;
				this.count = 0;
			};

			//Author Class with its properties and initial values
			function Author(paperid, authorid){
				this.paperid = paperid;
				this.authorid = authorid;
				this.name = '';   
				this.attendance = ''; 
				this.rank = '';
			}
			
			//This is used to search for a key in a given array
			function search(key, myArray){
				var stats = 0;
				for (var i=0; i < myArray.length; i++) {
					if (myArray[i].id === key) {
						return myArray[i];
					}
				}
			}

			// This made use of the search function to get the paper required
			function getPapers(paperid) {
				var resultObject = search(paperid, papers);
				console.log(resultObject);
				return resultObject;
			}

			// This updates the author count of a given paper
			function updatePapers(key, myArray, value){
				for (var i=0; i < myArray.length; i++) {
					if(myArray[i].id === key) {
						myArray[i].count = value;
					}
				}
			}

			//This updates the title of the paper object
			function writeTitle(e, paperid){
				myobj = getPapers(paperid);
				myobj.title = e.value;
				console.log(myobj.title +  ' -  value - > ' + e.value);
			}
			
			//This updates the rank of the author in a paper object
			function writeRank(e,paperid, authorid){
				myobj = getPapers(paperid);
				console.log(myobj.id + " saf "+ authorid);
				myauthor = papers[myobj.id-1].authors[authorid-1];

				myauthor.rank = e.value;
				// console.log(myobj.authors.rank);
			}
			
			//This updates the attendance  of the  author in a paper object
			function writeAttendance(e,paperid, authorid){
				myobj = getPapers(paperid);
				myauthor = papers[myobj.id-1].authors[authorid-1];
				myauthor.attendance = e.value;
				// console.log(myobj.authors.attendance);
			}
			
			//This updates the name of the  author in a paper object
			function writeName(e,paperid, authorid){
				myobj = getPapers(paperid);
				console.log(myobj);
				myauthor = papers[myobj.id-1].authors[authorid-1];
				myauthor.name = e.value;
				// console.log(myobj.authors.name);
			}

			// this adds a new author to a paper
			function addnewauthor(paperidno){
				//get paper id and the added author using classes Author(paperno) -> store in an array og Authors
				paperobj = getPapers(paperidno);
				console.log(paperobj);
				++authorcount;
				var authoradded = new Author(paperobj.id, authorcount);
				var papercount = paperobj.count + 1;
				new_author = '<tr id=author'+paperobj.id+papercount+'>'+
								'<td id="sn'+paperobj.id+papercount+'">'+papercount+'</td>'+
								'<td>'+ 
								'<select type="text" name="name'+paperobj.id+papercount+'" onchange="writeName(this,'+paperobj.id+','+papercount+')" id="name'+paperobj.id+papercount+'" class="form-control">'+
									'</select>'+
								'</td>'+
								'<td>'+ 
								'<select type="text"  name="rank'+paperobj.id+papercount+'" onchange="writeRank(this,'+paperobj.id+','+papercount+')" id="rank'+paperobj.id+papercount+'" class="form-control">'+
										'<option value = ""> </option>'+
										'<option value = "1st">1st</option>'+
										'<option value = "2nd">2nd</option>'+
										'<option value = "3rd">3rd</option>'+
										'<option value = "4th">4th</option>'+
										'<option value = "5th">5th</option>'+
									'</select>'+
								'</td>'+
								'<td><select type="text"  name="attendance'+paperobj.id+papercount+'" onchange="writeAttendance(this,'+paperobj.id+','+papercount+')" id="attendance'+paperobj.id+papercount+'" class="form-control">'+
										'<option value = ""> </option>'+
										'<option value = "Attending">Attending</option>'+
										'<option value = "Not Attending">Not Attending</option>'+
									'</select>'+
								'</td>'+
								'<td><button type="button" onclick="removeauthor('+paperobj.id+','+papercount+')" class="authorfield btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash-o"></i></button></td>'+
							'</tr>'	;
						//addauthors = '<tr id="authorrow'+countauthor+'" >'+;
						$('#authorsbody'+paperobj.id).append(new_author);
						paperobj.authors.push(authoradded);
						
				//update the papers back
				updatePapers(paperidno, papers, papercount);
				$('#authcount'+paperobj.id).val(papercount);
				console.log(authoradded);
				console.log(papers);
				
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
							var authors = '<option>Select an Author</option>';
							for(var i = 0; i < clus.length; i++){
								authors += '<option value = "'+ clus[i].staffid +'">'+ clus[i].text +'</option>';
							}
							
							$('#name'+paperobj.id+papercount).append(authors);
						
											
							}
							
						});
			}

			//This removes a paper from list of papers
			function removepaper(paperidno){
				console.log(paperidno);
				//get paper id and the added author using classes Author(paperno) -> store in an array og Authors
				paperobj = getPapers(paperidno);
				console.log(paperobj);
				--paperlimit;
				$('#papersection'+paperobj.id).remove();
				
				// get index of object with id:37
				var removeIndex = papers.map(function(item) { return item.id; }).indexOf(paperobj.id);

				// remove object
				papers.splice(removeIndex, 1);
				$('#totalpapercount').val(papers.length);
				console.log(papers);
			}

			//This removes a paper from list of authors in a paper object
			function removeauthor(paperidno, authorid){
				//get paper id and the added author using classes Author(paperno) -> store in an array og Authors
				paperobj = getPapers(paperidno);
				console.log(paperobj);
				--authorcount;
				var papercount = paperobj.count - 1;
				console.log("author"+paperobj.id+authorid);
				$('#author'+paperobj.id+authorid).remove();

				// get index of object with id:37
				var removeIndex = paperobj.authors.map(function(item) { return item.id; }).indexOf(authorid);

				// remove object
				paperobj.authors.splice(removeIndex, 1);
				--paperobj.count;
				$('#authcount'+paperobj.id).val(paperobj.count);

				//update the papers back
				for (var i=0; i < papers.length; i++) {
					if(papers[i].id === paperobj.id) {
						papers[i] = paperobj;
					}
				}
				console.log(papers);
			}

			
		</script>
		
	
		
	</body>
</html>
