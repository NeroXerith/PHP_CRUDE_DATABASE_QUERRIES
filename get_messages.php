<?php 
// Display success message if redirected from save_employee.php
if (isset($_GET['success']) && $_GET['success'] === 'true') {
	echo '<div class="alert alert-success" role="alert">Employee saved successfully! </div>';
  } else if(isset($_GET['error']) && $_GET['error'] === 'duplicate') {
	echo '<div class="alert alert-danger" role="alert">A record with the same first name and last name already exists. </div>';
  } else if(isset($_GET['error']) && $_GET['error'] === 'consecutive_spaces'){
	echo '<div class="alert alert-warning" role="alert">Consecutive spaces is not allowed. </div>';
  } else if(isset($_GET['error']) && $_GET['error'] === 'empty'){
	echo '<div class="alert alert-warning" role="alert">Empty fields!. </div>';
  } else if(isset($_GET['error']) && $_GET['error'] === 'sql_error'){
	echo '<div class="alert alert-danger" role="alert">Query Error!. </div>';
  }
  ?>