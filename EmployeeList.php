<?php

include('config.php');
$disp='';  $id=''; $actType=''; $errorMessage = '';

if(isset($_COOKIE['token'])){
	$id=$_COOKIE['token'];
	$sql ="SELECT * FROM users_table WHERE user_id=$id";
	if($rs=$conn->query($sql)){
	  if($rs->num_rows>0){
		$row=$rs->fetch_assoc();
		$usertype=$row['user_type'];
		$userid=$row['user_id'];
		switch($usertype){
		//  case 1 : header("location:EmployeeList.php"); break;
		  case 2 : header("location:staff_dash.php"); break;
		  case 3 : header("location:guest_dash.php"); break;
		}
	  }else{
		  // redirect if token not exist
		  header("location:logout.php");
	  }
	}
	else{
		  echo $conn->error;
	}
  }else{
	  header("location:logout.php");
  }

$sql ="SELECT EmployeeID, EmployeeFN, EmployeeMN, EmployeeLN,JobTitle FROM employees";
//execute query
if($rs=$conn->query($sql)){
	if($rs->num_rows>0){
		while($row=$rs->fetch_assoc()){
			$disp.='<tr>';
				$disp.='<td>'.$row['EmployeeID'].'</td>';
				$disp.='<td>'.$row['EmployeeFN'].' '.$row['EmployeeMN'].' '.$row['EmployeeLN'].'</td>';
				$disp.='<td>'.$row['JobTitle'].'</td>';
					$disp.='<td>
					<a class="btn btn-warning" href="EmployeeList.php?token='.$row['EmployeeID'].'&action=edit"> Edit</a>
					<a class="btn btn-danger" href="del.php?token='.$row['EmployeeID'].'"> Delete</a>
							
					</td>';
			$disp.='</tr>';
		}
	}
	else{
	  $disp="No record(s) Found!";
	}
}
else{
	echo $conn->error;
}

$Fname=''; $Mname=''; $Lname='';$Email=''; $Phone='';
if(isset($_GET['token']) && $_GET['action'] === 'edit'){
	$id=$_GET['token'];
	$actType=$_GET['action'];
	$sql="SELECT * FROM employees WHERE EmployeeID=$id";
	if($rs=$conn->query($sql)){
		if($rs->num_rows>0){
			$row=$rs->fetch_assoc();
			$Fname=$row['EmployeeFN'];
			$Mname=$row['EmployeeMN'];
			$Lname=$row['EmployeeLN'];
			$Email=$row['EmployeeEmail']; 
			$Phone=$row['EmployeePhone'];
		}
	}else{
		echo $conn->error;
	}
	$btn='<input class="btn btn-warning" style="width: 200px;" type="submit" name="btnUpdate" value="UPDATE INFORMATION">';
	$updateInputs='<input type="text" style="width: 200px;" name="EId" value="{$Id}">
	<input type="text" name="actionType" value="<?php echo $actType?>">';
}
else{
	$btn='<input class="btn btn-primary" style="width: 200px;" type="submit" name="btnSubmit" value="SAVE INFORMATION">';
}

include('get_messages.php'); // Display alerts messages
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>EMPLOYEE LIST - Activity</title>
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
	<style>
		body{
            margin: 50px;
		}
		form{
			display: flex;
            justify-content: center;
            align-items: center;
		}
	</style>
  </head>
  <body>
	<center>

		<form  class="row g-2" action="save_employee.php" method="post">	
					<input type="text" name="EId" class="form-control" value="<?php echo $id?>" hidden>
					<input type="text" name="actionType" class="form-control" value="<?php echo $actType?>" hidden>	
					<input type="text" name="Fname" class="form-control" placeholder="Enter First Name" value="<?php echo $Fname?>" required>
					<input type="text" name="Mname" class="form-control" placeholder="Enter Middle Name" value="<?php echo $Mname?>" required>
					<input type="text" name="Lname" class="form-control"placeholder="Enter Last Name" value="<?php echo $Lname?>" required>
					<input type="email" name="Email" class="form-control" placeholder="Enter Email" value="<?php echo $Email?>" required>
					<input type="text" name="Phone" class="form-control" placeholder="Enter Contact No" value="<?php echo $Phone?>">
					<select class="form-select" name="JobTitle">
<?php
	$sql="SELECT DISTINCT(JobTitle) FROM employees";
		if($rs=$conn->query($sql)){
				while($row=$rs->fetch_assoc()){
				echo '<option value="'.$row['JobTitle'].'">'.$row['JobTitle'].'</option>';
			}
		}else{

			echo $conn->error;
		}

 ?>
					</select>
	</br>	</br>
					<?php 
						echo $btn;
					?>
					
		</form>







		<table class="table table-bordered table-hover" id="myTable">
			<thead>
				<tr>
					<th>EmpNo</th>
					<th>Name</th>
					<th>Job Title</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php
				echo $disp;
			?>
			</tbody>
		</table>
	</center>
  </body>
  <script>
	$(document).ready( function () {
		$('#myTable').DataTable();
	} );
  </script>
</html>
