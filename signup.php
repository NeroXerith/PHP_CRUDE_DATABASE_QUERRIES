<?php
$msg = '';
include('config.php');

if(isset($_COOKIE['token'])){
    $id=$_COOKIE['token'];
    $sql ="SELECT * FROM users_table WHERE user_id=$id";
    if($rs=$conn->query($sql)){
      if($rs->num_rows>0){
        $row=$rs->fetch_assoc();
        $usertype=$row['user_type'];
        $userid=$row['user_id'];
        switch($usertype){
          case 1 : header("location:EmployeeList.php"); break;
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
  }


if (isset($_POST['txtUname'])) {
    $username = $_POST["txtUname"];
    $password = $_POST["txtUpass"];
    $confirmPassword = $_POST["comfirmPass"];

    if($password == $confirmPassword) {
        // Hashing the raw string
        $hashedPassword = md5($password);

        $sql = "INSERT INTO users_table (username, user_pass) VALUES ('$username', '$hashedPassword')";

        if ($conn->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        header("location: login.php");
    }

    else { $msg = 'Invalid credentials.'; }

    
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
</head>

<style>
    div {
        display: flex;
        align-items: center;
        justify-content: center;
    }   
</style>


<body>
    <div>
        <fieldset>
            <legend>SING UP ACCOUNT</legend>
            <form  method="post">
                <label>USERNAME</label><br/>
                <input type="text" required="true" name="txtUname" placeholder="Enter Username"/> <br/> <br/>
                <label>PASSWORD</label><br/>
                <input type="password" required="true" name="txtUpass" placeholder="Enter Password"/> <br/><br/>
                <label>CONFIRM PASSWORD</label><br/>
                <input type="password" required="true" name="comfirmPass" placeholder="Confirm Password"/> <br/><br/>
                <center><input type="submit" name="btnRegister" value="Register"/><br/></center>
                <center><?php echo $msg?></center>
            </form>
        </fieldset>
    </div>
</body>
</html>