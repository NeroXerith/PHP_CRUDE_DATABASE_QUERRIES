<?php
include('config.php');

if (isset($_POST['Fname'])) {
  $id = $_POST['EId'];
  $Fname = trim($_POST['Fname']); // Remove leading and trailing spaces
  $Mname = trim($_POST['Mname']);
  $Lname = trim($_POST['Lname']);
  $Email = trim($_POST['Email']);
  $Phone = $_POST['Phone'];
  $JobTitle = $_POST['JobTitle'];
  $actionType = $_POST['actionType'];

  // Set the SQL query
  if ($actionType === 'edit') {
    $sql = "UPDATE employees SET EmployeeFN='$Fname', EmployeeMN='$Mname', EmployeeLN='$Lname', EmployeeEmail='$Email', EmployeePhone='$Phone', JobTitle='$JobTitle' WHERE EmployeeID=$id";
  } else {
    $current = date('d-M-y');
    $sql = "INSERT INTO employees (EmployeeFN, EmployeeMN, EmployeeLN, EmployeeEmail, EmployeePhone, HireDate, ManagerID, JobTitle) VALUES ('$Fname', '$Mname','$Lname', '$Email', '$Phone', '$current', 50, '$JobTitle')";
  }

  // Check for empty or null values for Fname, Lname, and Email
  if (empty($Fname) || is_null($Fname) || empty($Lname) || is_null($Lname) || empty($Email) || is_null($Email)) {
    echo "Error : First Name, Last Name, and Email should not be empty or null.";
    echo '<script>setTimeout(function(){ window.location = "EmployeeList.php"; }, 5000);</script>';
  } elseif (preg_match('/\s\s+/', $Fname) || preg_match('/\s\s+/', $Lname) || preg_match('/\s\s+/', $Email)) {
    echo "Error : First Name, Last Name, and Email should not contain consecutive spaces.";
    echo '<script>setTimeout(function(){ window.location = "EmployeeList.php"; }, 5000);</script>';
  } else {
    // Check if a record with the same first name and last name exists in the database
    $duplicateCheckQuery = "SELECT EmployeeID FROM employees WHERE EmployeeFN='$Fname' AND EmployeeLN='$Lname'";
    $duplicateCheckResult = $conn->query($duplicateCheckQuery);

    if ($duplicateCheckResult) {
      if ($duplicateCheckResult->num_rows > 0) {
        // Check if the duplicate record has the same ID as the current updating record
        $row = $duplicateCheckResult->fetch_assoc();
        $duplicateID = $row['EmployeeID'];

        if ($duplicateID == $id) {
          // If the duplicate record has the same ID, it's the current record being updated
          // Execute the SQL query
          if ($conn->query($sql)) {
            header("location: EmployeeList.php");
          } else {
            echo "Error: " . $conn->error;
          }
        } else {
          echo "Duplicate: A record with the same first name and last name already exists.";
          echo '<script>setTimeout(function(){ window.location = "EmployeeList.php"; }, 5000);</script>';
        }
      } else {
        // Execute the SQL query
        if ($conn->query($sql)) {
          header("location: EmployeeList.php");
        } else {
          echo "Error: " . $conn->error;
        }
      }
    }
  }
}

?>
