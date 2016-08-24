<?php
session_start();
$conn = mysql_connect('academic-mysql.cc.gatech.edu', 'cs4400_Group_34', 'EvP1tOJE');
if (!$conn) {
  die('Could not connect: '.mysql_error());
}
mysql_select_db('cs4400_Group_34');
?>
<?php

mysql_query("DELETE FROM HasRoom WHERE ReserveID = '".$_SESSION['reservationID']."'");
mysql_query("UPDATE Reservation
          SET StartDate='".$_SESSION['new_checkInDate']."', EndDate='".$_SESSION['new_checkOutDate']."',TotalCost='".$_SESSION['new_totalCost']."'
          WHERE ReservationID='".$_SESSION['reservationID']."'");
mysql_query("INSERT INTO HasRoom(ReserveID,RoomNum,RoomLoc,IncludeExtrabed)
          VALUES('".$_SESSION['reservationID']."','".$_SESSION['new_roomNumber']."','".$_SESSION['new_location']."',".$_SESSION['isExtraBed'].")");

header("Location: updateReservation.php");

mysql_close($conn);
?>
