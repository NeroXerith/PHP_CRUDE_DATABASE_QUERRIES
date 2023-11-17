<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['EId'] ?? '';
  $Fname = trim($_POST['Fname']);
  $Mname = trim($_POST['Mname']);
  $Lname = trim($_POST['Lname']);
  $Email = trim($_POST['Email']);
  $Phone = $_POST['Phone'];
  $JobTitle = $_POST['JobTitle'];
  $actionType = $_POST['actionType'];

  if ($actionType === 'edit') {
    $sql = "UPDATE employees SET EmployeeFN='$Fname', EmployeeMN='$Mname', EmployeeLN='$Lname', EmployeeEmail='$Email', EmployeePhone='$Phone', JobTitle='$JobTitle' WHERE EmployeeID=$id";
  } else {
    $current = date('d-M-y');
    $sql = "INSERT INTO employees (EmployeeFN, EmployeeMN, EmployeeLN, EmployeeEmail, EmployeePhone, HireDate, ManagerID, JobTitle) VALUES ('$Fname', '$Mname','$Lname', '$Email', '$Phone', '$current', 50, '$JobTitle')";
  }

  if (empty($Fname) || empty($Lname) || empty($Email)) {
    header("Location: EmployeeList.php?error=empty");
    exit;
  } elseif (preg_match('/\s\s+/', $Fname) || preg_match('/\s\s+/', $Lname) || preg_match('/\s\s+/', $Email)) {
    header("Location: EmployeeList.php?error=consecutive_spaces");
    exit;
  } else {
    $duplicateCheckQuery = "SELECT EmployeeID FROM employees WHERE EmployeeFN='$Fname' AND EmployeeLN='$Lname'";
    $duplicateCheckResult = $conn->query($duplicateCheckQuery);

    if ($duplicateCheckResult && $duplicateCheckResult->num_rows > 0) {
      $row = $duplicateCheckResult->fetch_assoc();
      $duplicateID = $row['EmployeeID'];

      if ($duplicateID != $id) {
        header("Location: EmployeeList.php?error=duplicate");
        exit;
      }
    }

    if ($conn->query($sql)) {
      header("Location: EmployeeList.php?success=true");
      exit;
    } else {
      $error = $conn->error;
      echo "<script>console.error('SQL Error: " . addslashes($error) . "');</script>";
      header("Location: EmployeeList.php?error=sql_error");
      exit;
    }
  }
}
?>
