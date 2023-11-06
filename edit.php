
<?php
include('config.php');

if(isset($_GET['token'])){
  $id =$_GET['token'];
  $Fname=$_POST['Fname'];
  $Lname=$_POST['Lname'];
  $Email=$_POST['Email'];
  $Phone=$_POST['Phone'];
  $JobTitle=$_POST['JobTitle'];
  
  $sql="UPDATE employees SET EmployeeFN='$Fname', EmployeeLN='$Lname', EmployeeEmail='$Email',EmployeePhone='$Phone', JobTitle='$JobTitle' WHERE EmployeeID=$id";
  if($conn->query($sql)){
    header("location:EmployeeList.php");// redirect in php
  }
  else{
    echo $conn->error;
  }

}

?>
