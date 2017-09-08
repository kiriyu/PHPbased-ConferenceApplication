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
	$confappid = confappid($conn);
	
$confquery = "INSERT INTO `conferencesupport`(`confappid`, `conferenceid`, `clusterid`, `cpci`, `countryid`, `city`, `state`, `startdate`, `enddate`, `objectives`, `pistaffid`, `applicationstatus`, `datesubmitted`)
 VALUES ('$confappid', '$conferenceid', '$clusterid', '$cpci', '$country', '$city', '$state', '$sdate', '$edate', '$objectives', '$pistaffid', '0', '$dates')";
	$confquery = $conn->prepare($confquery); 
	$confquery -> execute();
		//print_r ($confquery);
		
$stmtquery  = "SELECT confappid FROM conferencesupport where clusterid ='$clusterid'";
	$stmtquery = $conn->prepare($stmtquery);
		$stmtquery->execute();
		$stmtq = $stmtquery ->fetch(PDO::FETCH_ASSOC);
		$confappid=$stmtq['confappid'];
		
	
	for($i=1;$i<=$pap;$i++){
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
														
													</div><!--end #tab1 -->
													<!-- #tab2 -->
													<div class="tab-pane" id="tab2">
														<div id="firstdiv" class="row">
															<section class="style-default-bright" id="papersection1">
																
																<input class="form-control" placeholder="Input Title of Paper 1"/>
																</br>
																<button id="addauthor1" type="button" onclick="addNewAuthor(1)" class="btn btn-raised btn-default addauthor"> Add Authors 1</button>
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
																			<tr>
																		<tr><td id = 'sn11'>1</td><td><input type = 'text' name = 'author11' class = 'form-control' /></td><td><input type = 'text' name = 'rank11' class = 'form-control' /></td><td><input type = 'text' name = 'status11' class = 'form-control' /></td></tr>
																			</tr>																	
																		</tbody>
																	</table>
																	
															</section>
														<section class="style-default-bright" id="papersection2">
															
															<input class="form-control" placeholder="Input Title of Paper 2"/>
															</br>
															<button type="button" id="addauthor2" onclick="addNewAuthor(2)" class="btn btn-raised btn-default addauthor"> Add Authors 2</button>
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
																	
																		<tr><td id = 'sn21'>1</td><td><input type = 'text' name = 'author21' class = 'form-control' /></td><td><input type = 'text' name = 'rank21' class = 'form-control' /></td><td><input type = 'text' name = 'status21' class = 'form-control' /></td></tr>												
																	</tbody>
																</table>
																
														</section>
													</div>
														<button id="addpapers" type="button" class="btn btn-raised btn-lg btn-success btn-default addpaper"> Add Papers</button>
														
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
			 var count = 2;
			 //begin appending authors for each paper
			var countauthor = 1;
			var countpaper = 2;
			 
			 function addNewAuthor(paperid){
					
					if(countauthor <= 9){
					++countauthor;
						 addauthors = '<tr id="authorrow'+countauthor+'" >'+
								'<td>'+countauthor+'</td>'+
								'<td>'+ 
								'<select  type="text" name="status1" id="authorstaffid'+countauthor+'" class="form-control">'+
										'<option value = ""> </option>'+
										'<option>Brendan</option>'+
										'<option>Jesuloluwa</option>'+
									'</select>'+
								'</td>'+
								'<td>'+ 
								'<select type="text" name="status1" id="status1" class="form-control">'+
										'<option value = ""> </option>'+
										'<option>1st</option>'+
										'<option>2nd</option>'+
									'</select>'+
								'</td>'+
								
								'<td><select type="text" name="status1" id="status1" class="form-control">'+
										'<option value = ""> </option>'+
										'<option>Attending</option>'+
										'<option>Not Attending</option>'+
									'</select>'+
								'</td>'+
								'<td><button type="button" id="removeauthor'+countauthor+'" class="authorfield btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash-o"></i></button></td>'+
									
							'</tr>'	;
						//addauthors = '<tr id="authorrow'+countauthor+'" >'+;
						$('#authorsbody'+paperid).append(addauthors);
						
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
								authors += '<option value = "'+ clus[i].staffid +'">'+ clus[i].text +'</option>';
							}
							
							$('#authorstaffid'+countauthor).append(authors);
						
											
							}
							
						});
					}
					
			 }
			 
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
			 /* $('#addmember').on('click', function(){
				 alert('');
			 }); */
				daterange('#from','#to');
				$( "#tabs" ).tabs();
				
				
				
				
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
				
				
				
				
					
				//begin appending for title of paper and no of authors
				$('#addpapers').on('click',function(){
					if(countpaper <= 9){
					++countpaper;
						var papers = '';
						countauthor = 1;
						//var paper = $('#papers').val();
						 papers =
						' <section class="style-default-bright" id="papersection'+countpaper+'">'+
										'<input id="pap'+countpaper+'" type="hidden" value="'+countpaper+'"/>'+
										'<input class="form-control" placeholder="Input Title of Paper '+countpaper+'"/>'+
										'</br>'+
										'<button type="button" id="addauthor'+countpaper+'" onclick="addNewAuthor('+countpaper+')" class="btn btn-raised btn-default addauthor"> Add Authors '+countpaper+'</button>'+
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
												'<tbody id="authorsbody'+countpaper+'" >'+
												
												'<tr><td id = "sn"'+ countpaper +'"1">1</td><td><input type = "text" name = "author"'+ countpaper +'"1" class = "form-control" /></td><td><input type = "text" name = "rank"'+ countpaper +'"1" class = "form-control" /></td><td><input type = "text" name = "status"'+ countpaper +'"1" class = "form-control" /></td></tr>' +
												'<input type = "hidden" id = "forpaper' + countpaper + '" value = "1">'+													
												'</tbody>'+
											'</table>'+
											'<td><button type="button" id="removepaper'+countpaper+'" class="paperfield btn btn-lg btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Delete row"><i class="fa fa-trash-o"></i></button></td>'+
									'</section>';
						 

		
						$('#firstdiv').append(papers);
						
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
								authors += '<option value = "'+ clus[i].staffid +'">'+ clus[i].text +'</option>';
							}
							
							$('#authorstaffid'+count).append(authors);
						
											
							}
							
						});
					}
					
				});
				
				
				//java script to remove appended rows dynamically;	
				$('#firstdiv').on("click",".paperfield", function(e){ //user click on remove text
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
				

					//java script to remove appended rows dynamically;	
				$('#authorcluster').on("click",".paperfield", function(e){ //user click on remove text
					e.preventDefault();
					id = $(this).attr('id').replace('rem', '')
					$("#authorrow"+id).remove(); 
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
							

			
			
			
				
			});
			
			
			</script>
			<!-- END JAVASCRIPT -->

		
	</body>
</html>
