<?php
include('config.php'); 

$msg='';

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


if(isset($_POST['txtUname'])){
  $U=$_POST['txtUname'];
  $P=md5($_POST['txtUpass']);
  $sql ="SELECT * FROM users_table WHERE username='$U' and user_pass='$P'";
  if($rs=$conn->query($sql)){
  	if($rs->num_rows>0){
  		$row=$rs->fetch_assoc();
      $usertype=$row['user_type'];
      $userid=$row['user_id'];
      setcookie('token',$userid);
      switch($usertype){
        case 1 : header("location:EmployeeList.php"); break;
        case 2 : header("location:staff_dash.php"); break;
        case 3 : header("location:guest_dash.php"); break;
      }
    }else{
      // invalid credential
      $msg='Invalid Credentials';
    }
  }else{
    	echo $conn->error;
  }
}
?>

<script>
  function btnClick() {
    window.location.href = "signup.php";
  }
</script>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div style="width:200px; margin:auto;">
      <fieldset>
        <legend>LOGIN ACCOUNT</legend>
        <form  method="post">
            <label>USERNAME</label><br/>
            <input type="text" required="true" name="txtUname" placeholder="Enter Username"/> <br/>
            <label>PASSWORD</label><br/>
            <input type="password" required="true" name="txtUpass" placeholder="Enter Password"/> <br/><br/>
            <input type="submit" name="btnLogin" value="Login"/>
            <input type="button" name="btnRegister" value="Register"/ onclick="btnClick()"><br/>
            <?php echo $msg; ?>
        </form>
      </fieldset>
    <div>
  </body>
</html>
