<?php
session_start();
$conn = mysql_connect('academic-mysql.cc.gatech.edu', 'cs4400_Group_34', 'EvP1tOJE');
if (!$conn) {
  die('Could not connect: '.mysql_error());
}
mysql_select_db('cs4400_Group_34');

$location = $_POST['location'];
$hotelRating = $_POST['hotelRating'];
$comment = $_POST['comment'];
if (!$location || $hotelRating) {
  echo "<script>alert('Select location or Rating.');
  history.back();</script>";
}
mysql_query("INSERT INTO HotelReview(CusName,Location,Comment,Rating)
             VALUES('".$_SESSION['user_id']."','".$location."','".$comment."','".$hotelRating."')");
header("Location: review.php");
mysql_close($conn);
?>
