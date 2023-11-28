<?php
setcookie('token',"");
unset($_COOKIE['token']);
header("location:index.php");

?>
