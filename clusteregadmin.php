<?php
include_once ('../include/config.php');
include_once ('../include/covenantportalfunctions.php');
include_once ('../include/functions.php');
session_start();
$_SESSION['loginid'] = 'CU1234';

if(isset($_GET['pop'])){
	$pop = $_GET['pop'];
	
	$stmt1 = $conn->prepare("select * from clustereg where status = '1'");
	$stmt1->execute();
	while ($clusterregfetch = $stmt1 -> fetch(PDO::FETCH_ASSOC)){
		$found = 0 ;
		if(password_verify($clusterregfetch['id'],$pop)){
			$found = 1 ;
			$actualid = $clusterregfetch['id'];
			break;
		}
		
	}
	if($found == '1'){
		$sql2 = "UPDATE clustereg SET status = '0' WHERE id = '$actualid'";
			$stmt2 = $conn->prepare($sql2);
			$stmt2 -> execute();
			$deletecount = $stmt2 -> rowCount();
			if($deletecount > 0){
				echo "<script> alert ('Deleted Successfully');</script>";
}	
	}	
}

if(isset($_POST['updatecluster'])){
	extract($_POST);	
$sql = "UPDATE clustereg SET clustername = '$editclustername', clusterleader = '$editclusterleader', clusterdepartment = '$editclusterdept' WHERE id = '$clusternameid'";
$stmt = $conn->prepare($sql);
$stmt -> execute();
	
	if($stmt->rowCount() > 0){
			$lastid=$conn->lastInsertId();
			//echo $lastid;
			$cost =11;
			$hashlinlk = password_hash($lastid, PASSWORD_BCRYPT,["cost" => $cost]);
			echo "<script>alert('Your Cluster Information Has Been Successfully Updated.');</script>";
			
	}else{
				echo"Unsuccessful";
		}
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registered Cluster's - (ADMIN)</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/bootstrap.css" />
<link rel="stylesheet" href="../assets/css/mystyle.css" />
			<style>
				.alignright{
					text-align:right;
				}
			</style>
	<link rel="stylesheet" href="../assets/css/jquery-ui.css">
	<script src="../assets/js/jquery-1.12.4.js"></script>
	<script src="../assets/js/jquery-ui.js"></script>
	<script src="../assets/js/bootstrap.js"></script>
	<body>
  <form  class="form-horizontal" method="post" action="">
    <h2 align="center">Registered Cluster's</h2>
        <div class="container">
          <div class="row">
            <div class="col-xs-12">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>S/N</th>                     
                      <th>CLUSTER NAME</th>
                      <th>CLUSTER LEADER</th>
					  <th>CLUSTER DEPARTMENT</th>
                      <th>MODIFY</th>
					  <th>VIEW</th>
					  <th>DELETE</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php  
				  $stmt = $conn->prepare("select * from clusterreg where status = '1'");
				 $stmt->execute();
				$sn = 0;
				 $data = $stmt->fetchAll();
				  foreach ($data as $dat) { 
						
						++$sn;
						
						$clustername = getclusters($conn, $dat['clustername']);
						$clusterleader = getclusters($conn, $dat['clusterleader']);
						$clusterdepartment = getclusters($conn, $dat['clusterdepartment']);
						$leader = getdetailsbystaffid($conn,$clusterleader); 
						$dept = getdeptbyid($conn,$clusterdepartment);
						//var_dump($dept);
						//echo '<pre>';
						//print_r($leader[0]['fname']);
						//echo '</pre>';
						$cost = 11;
						$hashlinlk = password_hash($dat['id'], PASSWORD_BCRYPT, ["cost" => $cost]);	
						$hashadd = password_hash($dat['id'], PASSWORD_BCRYPT, ["cost" => $cost]);
						$hashdelete = password_hash($dat['id'], PASSWORD_BCRYPT, ["cost" => $cost]);
						echo "<tr>
						<td>$sn</td>
						<td>$clustername</td>
						<td>".$leader[0]['sname']." ".$leader[0]['fname']." ".$leader[0]['mname']."</td>
						<td>".$dept['department']."</td>
						<td>
						<button type='button' class='btn btn-success btn-block pull-right' 
						onClick = \"editcluster('".$clustername."','".$dat['id']."','".$clusterleader."','".$clusterdepartment."');\" 
						data-toggle = 'modal' data-target = '#clusteredit' >EDIT</button>
						</td>
						<td><a class=\"btn btn-success  btn-block pull-right\" href = 'clusteregadminadd.php?ijk=$hashadd'>VIEW</a></td>
						<td><a onClick=\"return confirm('Are You Sure?')\" class=\"btn btn-success  btn-block pull-right\" href = 'clusteregadmin.php?pop=$hashdelete'>DELETE</a></td>
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
			<!--BEGIN MODAL FOR EDIT CLUSTER NAME-->
			<div class="modal fade" id="clusteredit" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">EDIT CLUSTER INFO</h4>
						</div>
						<div class="modal-body">
						<form id="clustereditmodal" class="form-horizontal" method="POST" action="">							
							<div class="form-group" id = 'dyn1'>
								<div class="row">
									<div class="col-sm-4">
										<label for="edit1" class="control-label">Cluster Name</label>
									</div>	
									<div class="col-sm-6">						
										<input type="hidden" name="clusternameid" id="clusternameid" /> 
										<input class="form-control" name="editclustername" id="editclustername" />
									</div>
								</div>
								</br>
								<div class="row">
									<div class="col-sm-4">
									  <label for="edit2" class="control-label">Cluster Leader</label>
									</div>
									<div class="col-sm-6">
										<input type="hidden" name="clusterleaderid" id="clusterleaderid" /> 
										<input class="form-control" name="editclusterleader" id="editclusterleader" />
									</div>										
								</div>
								</br>
								<div class="row">
									<div class="col-sm-4">
									  <label for="edit3" class="control-label">Cluster Department</label>
									</div>
									<div class="col-sm-6">
										<input type="hidden" name="clusterdeptid" id="clusterdeptid" /> 
										<input class="form-control" name="editclusterdept" id="editclusterdept" />
									</div>										
								</div>								
							</div>							
						</form>
						</div>						
						<div class="modal-footer">
							<button type="button" class="btn btn-default" id = "closeclusteredit" data-dismiss="modal">Close</button>
							<input form="clustereditmodal" name="updatecluster" id="updatecluster" type="submit" class="btn btn-primary" value="update">
						</div>						
					</div>
				</div>
			</div>
			<!--END MODAL FOR EDIT CLUSTER NAME-->
</body>
</html>
<script><!-- BEGIN JAVA SCRIPT FOR EDIT CLUSTER NAME-->
$(document).ready(function(){		
});
 function editcluster(clustername,clusterid,clusterleader,clusterdepartment){
	 var cname = clustername;
	 var cid = clusterid ;
	 
	 $('#editclustername').val(clustername);
	 $('#clusternameid').val(clusterid);
	 $('#editclusterleader').val(clusterleader);
	 $('#editclusterdept').val(clusterdepartment);
	 
 }
</script><!-- END JAVA SCRIPT FOR EDIT CLUSTER NAME-->