<?php

include('config.php');
$disp='';  $id=''; $actType='';
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
	$btn='<input class="btn btn-warning" type="submit" name="btnUpdate" value="UPDATE INFORMATION">';
	$updateInputs='<input type="text" name="EId" value="{$Id}">
	<input type="text" name="actionType" value="<?php echo $actType?>">';
}
else{
	$btn='<input class="btn btn-primary" type="submit" name="btnSubmit" value="SAVE INFORMATION">';
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>EMPLOYEE LIST</title>
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
  </head>
  <body>
	<center>

		<form  action="save_employee.php" method="post">	
					<input type="text" name="EId" value="<?php echo $id?>" hidden>
					<input type="text" name="actionType" value="<?php echo $actType?>" hidden>	
					<input type="text" name="Fname" placeholder="Enter First Name" value="<?php echo $Fname?>" required>
					<input type="text" name="Mname" placeholder="Enter Middle Name" value="<?php echo $Mname?>" required>
					<input type="text" name="Lname" placeholder="Enter Last Name" value="<?php echo $Lname?>" required>
					<input type="email" name="Email" placeholder="Enter Email" value="<?php echo $Email?>" required>
					<input type="text" name="Phone" placeholder="Enter Contact No" value="<?php echo $Phone?>"><br/>
					<select  name="JobTitle">
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
