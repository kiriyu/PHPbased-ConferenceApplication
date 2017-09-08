<?php
session_start();
$_SESSION['loginid'] = 'CU1234';
include_once('../include/config.php');
include_once('../include/covenantportalfunctions.php');
include('../include/functions.php');
$adminid =($_SESSION['loginid']);

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registered Cluster's - (ADMIN)</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/css/bootstrap.css" />
			<link rel="stylesheet" href="assets/css/mystyle.css" />
			<style>
				.alignright{
					text-align:right;
				}
			</style>
			<link rel="stylesheet" href="assets/css/jquery-ui.css">
			<script src="assets/js/jquery-1.12.4.js"></script>
			<script src="assets/js/jquery-ui.js"></script>
</head>
<body>
	
		<div class="container row">
				<form class="form-horizontal" action="" method="post">
					<div class="col-sm-offset-2 col-sm-8">
				<fieldset>
					<legend>Cluster Information:</legend>
				</fieldset>
	
				<div class="form-group">
					<div class="col-sm-3">
						<label for="conferencename" class="control-label">Conference Name </label>
					</div>					
					<div class="col-sm-8">
						<input type="text" class="form-control" id="conferencename" name="conferencename">									  
					</div>										
				</div>
				<div class="col-lg-12">
					<a class="btn btn-success pull-left" href="clusteregadmin.php"> BACK </a>
										
					<input type="submit" class="btn btn-success pull-right" id="submit" name="submit" value="ADD">
				</div>
				
		</div>
		</form>
	</div>
</body>

</html>