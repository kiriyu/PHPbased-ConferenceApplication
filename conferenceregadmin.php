<?php
include_once ('../include/config.php');
include_once ('../include/covenantportalfunctions.php');
include_once ('../include/functions.php');
session_start();
$_SESSION['loginid'] = 'CU1234';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registered Conferences's - (ADMIN)</title>
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
	<body>
  <form  class="form-horizontal" method="post" action="">
    <h2 align="center">Registered Conferences's</h2>
        <div class="container">
          <div class="row">
            <div class="col-xs-12">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>S/N</th>                     
                      <th>CONFERENCE NAME</th>                                          
                      <th>EDIT</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php  
				  $stmt = $conn->prepare("select * from conferencereg");
				 $stmt->execute();
				$sn = 0;
				 $data = $stmt->fetchAll();
				  foreach ($data as $dat) { 
						
						++$sn;						
						$conferencename = implode(',', array_map(function($el){ return $el['conferencename']; }, getconferences($conn, $dat['id'])));
																		
						$cost = 11;
						$hashlinlk = password_hash($dat['id'], PASSWORD_BCRYPT, ["cost" => $cost]);	
						echo "<tr>
						<td>$sn</td>
						<td>$conferencename</td>
						<td><a class=\"btn btn-success  btn-block pull-right\" href = 'conferenceregadminedit.php?mkl=$hashlinlk'>EDIT</a></td>
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
</body>
</html>