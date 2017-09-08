<?php
	include_once ('../include/config.php');
	include_once ('../include/covenantportalfunctions.php');
	include_once ('../include/functions.php');
	session_start();
	$_SESSION['loginid'] = 'CU1234';
	
	//BEGIN QQUERY TO DELETE CLUSTER MEMBER
	if(isset($_GET['sox'])){
		
		//echo "<script> alert ('Deleted Successfully tester');</script>";
	$sox = $_GET['sox'];
	
	$stmt4 = $conn->prepare("select * from clustermembers where clustermemberstatus = '1'");
	$stmt4->execute();
	while ($clustermemberfetch = $stmt4 -> fetch(PDO::FETCH_ASSOC)){
		//echo "<script> alert ('Deleted Successfully tester');</script>";
		$found1 = 0 ;
		if(password_verify($clustermemberfetch['id'],$sox)){
			$found1 = 1 ;
			$actualid = $clustermemberfetch['id'];
			break;
		}		
	}
	if($found1 == '1'){
		$sql4 = "UPDATE clustermembers SET clustermemberstatus = '0' WHERE id = '$actualid'";
			$stmt5 = $conn->prepare($sql4);
			$stmt5 -> execute();
			$deletecount = $stmt5 -> rowCount();
			if($deletecount > 0){
				echo "<script> alert ('Deleted Successfully');</script>";
			}	
		}	
	}//END QQUERY TO DELETE CLUSTER MEMBER
	
	//BEGIN QQUERY TO DELETE CLUSTER RESEARCHTOPIC
	if(isset($_GET['bgf'])){
		
		//echo "<script> alert ('Deleted Successfully tester');</script>";
	$bgf = $_GET['bgf'];
	
	$stmt6 = $conn->prepare("select * from clusterresearchtopics where researchstatus = '1'");
	$stmt6->execute();
	while ($clusterresearchfetch = $stmt6 -> fetch(PDO::FETCH_ASSOC)){
		//echo "<script> alert ('Deleted Successfully tester');</script>";
		$found2 = 0 ;
		if(password_verify($clusterresearchfetch['id'],$bgf)){
			$found2 = 1 ;
			$actualid1 = $clusterresearchfetch['id'];
			break;
		}		
	}
	if($found2 == '1'){
		$sql6 = "UPDATE clusterresearchtopics SET researchstatus = '0' WHERE id = '$actualid1'";
			$stmt8 = $conn->prepare($sql6);
			$stmt8 -> execute();
			$deletecount1 = $stmt8 -> rowCount();
			if($deletecount1 > 0){
				echo "<script> alert ('Deleted Successfully');</script>";
			}	
		}	
	}//END QQUERY TO DELETE CLUSTER RESEARCHTOPIC
	
	//BEGIN QQUERY TO ADD STAFF TO CLUSTER
	if(isset($_POST['addmember']))
	{
		$error = '';
		if(isset($_POST['test'])){
			$error = validatepositivenumber($_POST['test'], 'Number of fields');	
			$error .= validatepositivenumber($_POST['clusterid'], 'cluster name');		
			if($error == '')
			{
				$elementcount = $_POST['test'];
				for ($i=1; $i<=$elementcount; $i++){
					
					$error .= validatetext($_POST['memberid' . $i], 'cluster member ' . $i);
					$clusterid = $_POST['clusterid'];
					$cost = 11;
					$hashlink = password_hash($clusterid, PASSWORD_BCRYPT, ["cost" => $cost]);	
					if($error == ''){
														
						 echo  $staffid = $_POST['memberid' . $i]; 
									
						$dates = date("Y-m-d H:i:s" );
						$satffquery = "INSERT INTO `clustermembers`(`clusterid`, `staffid`, `clustermemberstatus`, `datecreated`) VALUES ('$clusterid', '$staffid', '1', '$dates')";
						$stmt7 = $conn->prepare($satffquery);
						$stmt7 -> execute();
						//echo "hello";
						
						if($stmt7->rowCount() >0){
							//echo "<script>window.location.href ='clusteregadminadd.php?ijk=$hashlink'</script>";
							//print_r ($stmt7);
							//echo "dfjhfdj";
						}
					}
					
				}
			}
		}	
	}//END QQUERY TO ADD STAFF TO CLUSTER
	
	//BEGIN QQUERY TO ADD RESEARCH TOPIC AND LEADRESEARCHER
	if(isset($_POST['addtopic']))
	{ /* echo "hello"; */
		$dates = date("Y-m-d H:i:s" );
		$clusterid = $_POST['clusterid'];
		$staffid = $_POST['researcher1'];
		$researchtopic = $_POST['topic1'];
			$topicquery = "INSERT INTO `clusterresearchtopics`(`clusterid`, `researchtopic`, `researchstatus`, `leadresearcher`, `datecreated`)
			VALUES ('$clusterid', '$researchtopic', '1', '$staffid', '$dates')";
			/* print_r($topicquery); */
			$stmt9 = $conn->prepare($topicquery);
			$stmt9 -> execute();
			
			if($stmt9->rowCount() > 0){
				
			}
	}
	//END QQUERY TO ADD RESEARCH TOPIC AND LEADRESEARCHER
	
	
	//BEGIN QQUERY TO FETCH ALL CLUSTER DATA INFORMATION
	if(isset($_GET['ijk']) && $_GET['ijk'] != '')
	{
		$ijk = $_GET['ijk'];
		$sql = "SELECT * FROM clusterreg";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$clusterid = 0;
		if($stmt->rowCount() >0)
		{
			$found = 0;
			while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
				if(password_verify($data['id'], $ijk)){
					$clusterid = $data['id'];
					$found = 1;
					break;
				}
			}
		}
		else if($stmt1->rowCount() == 0)
		{
			echo "no record";
		}
		if($found == 1)
		{
			$sql = "SELECT * FROM clusterreg where id='$clusterid'";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			if($stmt->rowCount() >0)
			{
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			$sql1 = "SELECT * FROM clustermembers where clusterid='$clusterid' and clustermemberstatus = '1'";
			$stmt1 = $conn->prepare($sql1);
			$stmt1->execute();
			
			$sql2 = "SELECT * FROM clusterresearchtopics where clusterid='$clusterid' and researchstatus = '1'";
			$stmt2 = $conn->prepare($sql2);
			$stmt2->execute();
			
				?>
				<!DOCTYPE html>
				<html lang="en">
					<head>
						<title>Cluster Information - (ADMIN)</title>
						<meta charset="utf-8">
						<meta name="viewport" content="width=device-width, initial-scale=1">
						<link rel="stylesheet" href="../assets/css/bootstrap.css" />
						<link rel="stylesheet" href="../assets/css/jquery-ui.css" />
						<style>
							.alignright{
								text-align:right;
							}
							.ui-autocomplete {
								max-height: 100px;
								overflow-y: auto;
								z-index: 100;
								/* prevent horizontal scrollbar */
								overflow-x: hidden;
							}
							/* IE 6 doesn't support max-height
							* we use height instead, but this forces the menu to always be this tall
							*/
							* html .ui-autocomplete {
								height: 100px;
							}
						</style>
						<link rel="stylesheet" href="../assets/css/jquery-ui.css">
						<script src="../assets/js/jquery-1.12.4.js"></script>
						<script src="../assets/js/jquery-ui.js"></script>
						<script src="../assets/js/jquery.validate.js"></script>
						<script src="../assets/js/bootstrap.js"></script>
					</head>
					<body>
									<div class="form-group">
										<p><?php if(isset($error)) echo $error; ?></p>
									</div>
						<div class="container row">
							
							<div class="col-sm-offset-2 col-sm-8">
									<fieldset>
										<legend>Cluster Information for <?php echo ucwords($data['clustername']);?>:</legend>
									
										<h4>1).</h4>
										<h4>Add New Cluster Member</h4>
										<div class="input_fields_wrap">
											<button type = 'button' class="btn btn-info" data-toggle="modal" data-target="#clustermembersmodal">ADD</button>
										</div>
										<table id="memberstable" class="table table-bordered">
											<thead>
												<tr>
													<th>S/N</th>
													<th>STAFF ID</th>
													<th>NAME</th>
													<td>DEPARTMENT</th>							
													<th>DELETE</th>													
												</tr>
											</thead>
											<tbody>
											<?php
											$sn = 0;
												while ($data1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
													$staffdetails = get_user($data1['staffid']);
													$sname = implode(',', array_map(function($el){return $el['sname']; }, $staffdetails));
													$fname = implode(',', array_map(function($el){return $el['fname']; }, $staffdetails));
													$mname = implode(',', array_map(function($el){return $el['mname']; }, $staffdetails));
													$unit = implode(',', array_map(function($el){return $el['unit']; }, $staffdetails));
													//$deptid = get_unit($conn, $unit);
													$cost = 11;
													$hashdelete = password_hash($data1['id'], PASSWORD_BCRYPT, ["cost" => $cost]);
													if($unit > 0)
													{
														$deptid = implode(',', array_map(function($el){return $el['dept']; }, get_unit($conn, $unit)));
														if($deptid != '')
															$deptartmentname = implode(',', array_map(function($el){return $el['location']; }, get_unit($conn, $deptid)));
														else $deptartmentname = $unit;
													}
													else $deptartmentname = $unit;											
													$sql3 = "SELECT * FROM clustermembers WHERE staffid in(SELECT clusterleader FROM clusterreg WHERE id=clusterid)AND staffid = '" . $data1['staffid'] . "'AND clusterid=clusterid";
													$stmt3 = $conn->prepare($sql3);
													$stmt3->execute();
													?>
													<tr id = 'tr<?php echo($data1['id']); ?>'>
													<td><?php echo ++$sn ;?></td>
													<td><?php echo strtoupper($data1['staffid']); echo $stmt3->rowCount() > 0 ? " Cluster Leader": "";?></td>
													<td><?php echo ucwords ($sname.' '.$fname.' '.$mname) ;?></td><td><?php echo ucwords($deptartmentname);?></td>
													<td><a onClick="return confirm('Are You Sure?')" class="delete btn btn-success  btn-block" id="remove<?php echo($data1['id']);?>" href="clusteregadminadd.php?sox=<?php echo($hashdelete);?>&ijk=<?php echo($_GET['ijk']);?>">DELETE</a></td></tr>
													<?php
												} 
												
											?>
												
											</tbody>						
										</table>
									</fieldset>
									
									<fieldset>
										<legend>Research Topic Information for <?php echo ucwords($data['clustername']);?>:</legend>
									
										<h4>2).</h4> 
										<h4>Add New Research Topic</h4>
										<div class="input_fields_wrap">
											<button type = 'button' class="add_field_button btn btn-info" data-toggle="modal" data-target="#researchtopicmodal">ADD</button>
										</div>
										<table class="table table-bordered">
											<thead>
												<tr>
													<th>S/N</th>
													<th>RESEARCH TOPICS</th>
													<th>LEAD RESEARCHER</th>
													<th>DELETE</th>													
												</tr>
											</thead>
											<tbody>
											<?php
											$sn = 0;
												while ($data2 = $stmt2->fetch(PDO::FETCH_ASSOC)){												
													$staffdetails = get_user($data2['leadresearcher']);
													$sname = implode(',', array_map(function($el){return $el['sname']; }, $staffdetails));
													$fname = implode(',', array_map(function($el){return $el['fname']; }, $staffdetails));
													$mname = implode(',', array_map(function($el){return $el['mname']; }, $staffdetails));	
													$cost1 = 11;
													$hashremove = password_hash($data2['id'], PASSWORD_BCRYPT, ["cost1" => $cost1]);
													?>
													<tr id="tr1<?php echo($data2['id']);?>">
													<td><?php echo ++$sn ;?></td>
													<td id="topic<?php echo($data2['id']);?>"><?php echo ucwords($data2['researchtopic']);?></td>
													<td id="topiclead<?php echo($data2['id']); ?>"><?php echo ucwords ($sname.' '.$fname.' '.$mname);?></td>
													</td><td><a onClick="return confirm('Are You Sure?')" class="class=delete btn btn-success btn-block" id="delete<?php echo($data2['id']);?>" href="clusteregadminadd.php?bgf=<?php echo($hashremove);?>&ijk=<?php echo($_GET['ijk']);?>">DELETE</a></td>
													</tr>
												<?php	
												
												}
											?>
											</tbody>
										</table>
									</fieldset>
									
									<!-- BEGIN MODAL TO ADD STAFF TO CLUSTER-->			
									<div class="modal fade" id="clustermembersmodal" role="dialog">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title">ADD NEW MEMBER</h4>
												</div>
												<div class="modal-body">
												<form id="clustermember" class="form-horizontal" method="POST" action="">
													
													<div class="form-group" id = 'dyn1'>
														<label for="member1" class="control-label col-sm-3">Cluster Member 1</label>
														<div class="col-sm-6">
															<input name="test" id="test" value="1" type="hidden"/> 
															<input name="clusterid" id="clusterid" value="<?php echo $clusterid;?>" type="hidden"/> 
															<input name="memberid1" id="memberid1" value="" type="hidden"/> 
															<input type="text" class="form-control addname" id="member1" name="member1">
														</div>
													
														<div class="col-sm-2 input_fields_wrap" id="addstaff">
																<button id="addstaffbutton" class="">Add + </button>
														</div>
													
													</div>
													<div id = "tester" class="form-group"></div>
												</form>
												</div>
												
												<div class="modal-footer">
													<button type="button" class="btn btn-default" id = "closeclustermember" data-dismiss="modal">Close</button>
													<input form="clustermember" name="addmember" id="addmember" type="submit" class="btn btn-primary" value="update">
												</div>
												
											</div>
										</div>
									</div><!-- END MODAL TO ADD STAFF TO CLUSTER-->
									
									<!-- BEGIN MODAL TO ADD RESEARCHTOPIC AND LEAD RESERACHER TO CLUSTERS-->
									<div class="modal fade" id="researchtopicmodal" role="dialog">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title">ADD RESEARCH TOPIC</h4>
												</div>
													<div class="modal-body">
														<form id="researchtopic" class="form-horizontal" method="POST" action="">
															<div class="form-group">															
																<label for="researchtopic" class="control-label col-sm-1">Research Topic</label>																			
																<div class="col-sm-5">
																	<input name="testing" id="testing" value="1" type="hidden"/> 
																	<input name="topicid1" id="topicid1" value="" type="hidden"/>
																	<input name="clusterid" id="clusterid" value="<?php echo $clusterid;?>" type="hidden"/>
																	<input type="text" class="form-control addname" id="topic1" name="topic1">
																	<p><?php if(isset($errors['topic1'])) echo $errors['topic1']; ?></p>
																</div>
																<div class="col-sm-5">
																	<select class="form-control" id="researcher1" name="researcher1">
																	</select>
																	<p><?php if(isset($errors['researcher1'])) echo $errors['researcher1']; ?></p>
																</div>
																<div class="input_fields_wrap col-sm-1">
																	<button class = 'addresearchtopic'>Add</button>
																</div>										
															</div>
															<div id = 'addtesting' class="form-group"></div>
														</form>	
													</div>
													
													
													<div class="modal-footer">
														<button type="button" class="btn btn-default" id="closeresearchtopic" data-dismiss="modal">Close</button>
														<input form="researchtopic"  name="addtopic" id="addtopic" type="submit" class="btn btn-primary" value="save">
													</div>
												
											</div>
										</div>
									</div><!-- END MODAL TO ADD RESEARCHTOPIC AND LEAD RESERACHER TO CLUSTERS-->

									<div class="col-lg-12">
										<a class="btn btn-success pull-left" href="clusteregadmin.php"> BACK </a>
									</div>										
								
							</div>
						</div>
						
					</body>

					<script>
						$(document).ready(function() {
							var staffid = "<option value = ''>Select one</option>";
							//function to add names to select box for lead researcher
							function addnames(idname){
								$('#memberstable tr').each(function(i) {
									one = $(this).find("td:nth-child(2)").text().replace('Cluster Leader', '').replace(' ', '');
									two = $(this).find("td:nth-child(3)").text();
									staffid += "<option value = '"+one+"'>"+two+"</option>";
									console.log(staffid);
									$('#'+ idname).html(staffid)
									//console.log( staffid + "   " + staffname);
								});
							}
							
							//to automatically populate the first lead researcher 
							addnames('researcher1');
							
							
							
							//BEGIN JS APPEND FOR CLUSTER MEMBERS
							var max_fields      = 10; //maximum input boxes allowed
							var wrapper         = $("#tester"); //Fields wrapper
							var add_button      = $(".add_field_button"); //Add button ID
							
							var countid = 1;
							$('#addstaffbutton').on('click', function(e){ //on add input button click
								//alert ('dfvbghnjmk');
								e.preventDefault();
								if(countid < max_fields && countid >= 1){ //max input box allowed
								++countid;
									//alert('tftyfut');
									$('#test').val(countid);
									$('#tester').append('<div id="dyn'+countid+'" class="form-group dyn">'+
										'<label for="member'+countid+'" class="control-label col-sm-3">Cluster Member '+countid+'</label>'+
													'<div class="col-sm-6">'+
														'<input class="form-control add addname" type="text" id="member'+countid+'" name="member'+countid+'">'+
														'<input class="form-control addid" type="hidden" id="memberid'+countid+'" name="memberid'+countid+'">'+
													'</div>'+
													'<div class="col-sm-2">'+
														'<button href="#" id="delete'+countid+'" class="remove_field ">Remove</button>'+
													'</div>'+
												'</div>'                                    
																			 
													 ); //add input box
								}else alert("You can only add a maximum of 10 Cluster members")
							});
							$(document).on('keyup', '.addname', function(){
								var dat = $(this).attr('id');
								var data1 = dat.replace('member', '');
								var data2 = 'memberid'+ data1;
								searchname(dat, data2);
								$("#"+dat).autocomplete("option","appendTo", "#dyn" + data1)
								
							});
							$(document).on("click",".remove_field", function(e){ //user click on remove text
								e.preventDefault();
								if(countid > 1)
								{
									var btnid = $(this).attr('id');
									var id =btnid.replace('delete', '');
									$("#dyn" + id).remove(); 
									--countid;
									$('.add').each(function(j, obj){
								
										num = obj['name'].replace('member', '');
										$('[name = ' + obj['name'] + ']').attr('name', 'member' + ((j*1) + 2));
										$('[name = ' + obj['name'] + ']').attr('id', 'member' + ((j*1) + 2));
										$('[for = member' + num + ']').html('Cluster Member ' + ((j*1) + 2));
										$('[for = member' + num + ']').attr('for', 'member' + ((j*1) + 2));
										$('#delete' + num  ).attr('id', 'delete' + ((j*1) + 2));
										$('#dyn' + num ).attr('id', 'dyn' + ((j*1) + 2));
										$('#memberid' + num  ).attr('name', 'memberid' + ((j*1) + 2));
										$('#memberid' + num ).attr('id', 'memberid' + ((j*1) + 2));
										
										console.log(num);
										countid = ((j*1) + 2)
										//i = (j * 1) + 2;
									});
									//console.log(countid);
									$('#test').val(countid);
								}
							});//END JS APPEND FOR CLUSTER MEMBERS
							
							
							//BEGIN JS APPEND FOR RESEARCH TOPIC
							countid1 = 1;
							$(".addresearchtopic").click(function(e){
								e.preventDefault();
								if(countid1 < max_fields && countid1 >= 1){ //max input box allowed
									//text box increment
									++countid1;
									//alert('tftyfut');
									$('#testing').val(countid1);
									
									addnames('researcher' + countid1);
									console.log('researcher' + countid1);
									$("#addtesting").append(
												'<div id="dyna'+countid1+'" class="form-group dyna">'+
													'<label for="topic'+countid1+'" class="control-label col-sm-1">Research Topic</label>'+
													'<div class="col-sm-5">'+
														'<input class="form-control add1 addtopic" type="text" id="topic'+countid1+'" name="topic'+countid1+'">'+
													'</div>'+
													'<div class="col-sm-5">'+
														'<select class="form-control" id="researcher'+countid1+'" name="researcher'+countid1+'">'+
														'</select>'+
													'</div>'+
													'<div class="col-sm-1">'+
														'<button href="#" id="remove'+countid1+'" class="remove_field1 ">Remove</button>'+
													'</div>'+
												'</div>'                                    
																		 
													 ); //add input box
								}
								else alert("You can only add a maximum of 10 research topics");
							});							
							$(document).on("click",".remove_field1", function(e){ //user click on remove text
								e.preventDefault();
								if(countid1 > 1)
								{
									var btnid = $(this).attr('id');
									var id =btnid.replace('remove', '');
									$("#dyna" + id).remove(); 
									--countid1;
									$('.add1').each(function(j, obj){
								
										num1 = obj['name'].replace('topic', '');
										$('[name = ' + obj['name'] + ']').attr('id', 'topic' + ((j*1) + 2));
										$('[name = ' + obj['name'] + ']').attr('name', 'topic' + ((j*1) + 2));
										$('[name = researcher' +num1+ ']').attr('id', 'researcher' + ((j*1) + 2));
										$('[name = researcher' +num1+ ']').attr('name', 'researcher' + ((j*1) + 2));
										$('[for = topic' + num1 + ']').attr('for', 'topic' + ((j*1) + 2));
										$('#remove' + num1 ).attr('id', 'remove' + ((j*1) + 2));
										$('#dyna' + num1 ).attr('id', 'dyna' + ((j*1) + 2));
										
										console.log(num1);
										//i = (j * 1) + 2;
										countid1 = ((j*1) + 2)
									});
									$('#testing').val(countid1);
								}
							}); //END JS APPEND FOR RESEARCHTOPICS
							
							
							
							//BEGIN JS TO AUTOCOMPLETE CLUSTER MEMBER FIELD
							function searchname(name, staffid){
								console.log(name);
								$( '#' + name ).autocomplete({
									source: function( request, response ) {
										$.ajax( {
											url: "../include/csaajax.php",
											dataType: "jsonp",
											data: {
												term: request.term
											},
											success: function( data ) {
												if(data != '' && $( '#' + name).val() != '')
												{
													response( data );
													//$("#submitname").val(data);
												}
											}
										} );
									},
									minLength: 2,
									select: function( event, ui ) {
										$('#' + staffid).val(ui.item.id);
									}
								});
							
							}//END JS TO AUTOCOMPLETE CLUSTER MEMBER FIELD
						});
					</script>



				</html>
				<?php
			}
		}
		else{
			die ("<script>window.location.href = 'clusteregadmin.php';</script>");
		}
	}//END QQUERY TO FETCH ALL CLUSTER INFO
	else{
		die ("<script>window.location.href = 'clusteregadmin.php';</script>");
	}
?>