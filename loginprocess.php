<?php
session_start();
$conn = mysql_connect('academic-mysql.cc.gatech.edu', 'cs4400_Group_34', 'EvP1tOJE');
if (!$conn) {
  die('Could not connect: '.mysql_error());
}
mysql_select_db('cs4400_Group_34');
switch($_GET['mode']){
  case 'login':
    $user_result = mysql_query("SELECT * FROM User WHERE Username = '".$_POST['ID']."'");
    $user = mysql_fetch_array($user_result);
    $user_password = $_POST['pwd'];
    if (!$user || $user['Password'] != $user_password) {
      echo "<script>alert('ID or Password is not valid. Try again.');history.back();</script>";
    } else {
      $_SESSION['user_id'] = $_POST['ID'];
      $isManager = mysql_query("SELECT * FROM Management WHERE Mname='".$_SESSION['user_id']."'");
      $isManager_array = mysql_fetch_assoc($isManager);
      if ($isManager_array['Mname']) {
        header("Location: management.php");
      } else {
        header("Location: intro.php");
      }
    }
    break;
  case 'register':
    $user_result = mysql_query("SELECT * FROM User WHERE Username = '".$_POST['ID']."'");
    $user = mysql_fetch_array($user_result);
    $userId=$user['Username'];
	  $email_result = mysql_query("SELECT * FROM Customer WHERE Email = '".$_POST['email']."'");
	  $mail = mysql_fetch_array($email_result);
    if ($user) {
      echo "<script>alert('This ID already exists!');history.back();</script>";
    } else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)===TRUE){
	     echo "<script>alert('This Email is not valid!');history.back();</script>";
    } else if($mail) {
	     echo "<script>alert('This e-mail address already exists!');history.back();</script>";

    } else if($_POST['pwd']!=$_POST['confirmpwd']){
   	echo "<script>alert('Password not set correctly!');history.back();</script>";
    }else{
      $user_id = $_POST['ID'];
      $user_password = $_POST['pwd'];
      $user_email = $_POST['email'];
      mysql_query("INSERT INTO User(Username,Password) VALUES('".$user_id."','".$user_password."')");
      mysql_query("INSERT INTO Customer(Cname,Email) VALUES('".$user_id."','".$user_email."')");
      $_SESSION['user_id'] = $_POST['ID'];
      header("Location: intro.php");
    }
    break;
}
mysql_close($conn);
?>
