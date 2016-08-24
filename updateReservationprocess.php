<?php
session_start();
$conn = mysql_connect('academic-mysql.cc.gatech.edu', 'cs4400_Group_34', 'EvP1tOJE');
if (!$conn) {
  die('Could not connect: '.mysql_error());
}
mysql_select_db('cs4400_Group_34');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="./style.css">
  </head>
  <body>
    <header>
      <h1>
      <a href="https://academic-php.cc.gatech.edu/groups/cs4400_Group_34/intro.php" onfocus="this.blur()">
        <center>Welcome to FANCY HOTEL</center>
      </a>
      </h1>
    </header>
    <nav>
      <ol>
        <br />
        <li><a href="./findRoom.php">Make Reservation</a></li><br />
        <li><a href="./updateReservation.php">Update Reservation</a></li><br />
        <li><a href="./cancelReservation.php">Cancel Reservation</a></li><br />
        <li><a href="./paymentInfo.php">Payment Information</a></li><br />
        <li><a href="./review.php">Review</a></li><br />
        <li><a href="./logoutprocess">Logout</a></li><br />
      </ol>
    </nav>
    <article>
<?php
$_SESSION['reservationID'] = $_POST['reserveInfo'];
if (!$_SESSION['reservationID']) {
  echo "<script>alert('SELECT YOUR RESERVATION IN THE LIST');history.back();</script>";
} else {
$reserveInfo = mysql_query("SELECT * FROM Reservation INNER JOIN HasRoom
                            WHERE ReservationID = '".$_SESSION['reservationID']."'
                            AND ReservationID = ReserveID
                            AND IsCancelled = false");
$reserveInfo_array = mysql_fetch_assoc($reserveInfo);
$_SESSION['cardNumber']=$reserveInfo_array['CardNum'];
$findReservation = mysql_query("SELECT * FROM Reservation WHERE ReservationID = '".$_SESSION['reservationID']."'");
$findReservation_array = mysql_fetch_assoc($findReservation);

switch($_GET['mode']){
  case 'update':

    $hasroom_result = mysql_query("SELECT * FROM HasRoom WHERE ReserveID = '".$_SESSION['reservationID']."'");
    $hasroomr = mysql_fetch_array($hasroom_result);
    $_SESSION['new_location']=$hasroomr[2];
    $_SESSION['new_category']=$_POST['category'];
    $_SESSION['new_extraBed']=$_POST['extraBed'];
    $_SESSION['new_checkInDate']=$_POST['checkInDate'];
    $_SESSION['new_checkOutDate']=$_POST['checkOutDate'];

    $checkIn_date=date($findReservation_array['StartDate']);
    $diff= (strtotime($checkIn_date) - strtotime("now"));
    $days = floor($diff / (60*60*24));

    $date1=date($_POST['checkInDate']);
    $date2=date($_POST['checkOutDate']);
    $diff_date= (strtotime($date2) - strtotime($date1));
    $diff_days = floor($diff_date / (60*60*24));

    $now = strtotime(date("y-m-d", strtotime("now")));
    $daydiff_now = floor((strtotime($checkIn_date) - $now)/(60*60*24));
     if (strlen($_POST['checkInDate']) < 10
              || strlen($_POST['checkOutDate']) < 10) {
        echo "<script>alert('Wrong date. Try again.');
        history.back();</script>";

      } else if ($daydiff_now <= 3) {
        echo "<script>alert('Cannot update your Reservation 3 days before you check-in');
        history.back();</script>";
      } else if ($diff_days < 1) {
        echo "<script>alert('Check out date cannot be earlier than Check in date');
        history.back();</script>";

      } else if ($days < 1) {
        echo "<script>alert('You cannot check-in 24 hours.');
        history.back();</script>";

      } else if ( !$_SESSION['new_category'] ||
        !$_SESSION['new_checkInDate'] || !$_SESSION['new_checkOutDate']) {
        echo "<script>alert('Please choose appropriate values!');history.back();</script>";
      } else {
        $result = mysql_query(
        "SELECT *
        FROM Room
        WHERE (RoomNumber, RoomLocation)
        NOT IN (SELECT RoomNumber, RoomLocation
              FROM Room,HasRoom,Reservation
              WHERE RoomNumber = RoomNum
              AND RoomLocation = RoomLoc
              AND ReservationID = ReserveID
              AND ((EndDate >= '".$_SESSION['new_checkInDate']."'
                AND StartDate <= '".$_SESSION['new_checkInDate']."')
                OR (EndDate >= '".$_SESSION['new_checkOutDate']."'
                AND StartDate <= '".$_SESSION['new_checkOutDate']."')))
        AND RoomLocation = '".$_SESSION['new_location']."'
        AND RoomCategory = '".$_SESSION['new_category']."'
        ");
        $room_array = mysql_fetch_assoc($result);
        if (!$room_array) {
          echo "<script>
          alert('There is no available room. Choose another Date.');
          history.back();
          </script>";
        } else {
          if ($_SESSION['new_extraBed']>0) {
            $_SESSION['isExtraBed'] = 1;
          } else {
            $_SESSION['isExtraBed'] = 0;
          }
          $date1=date($_SESSION['new_checkInDate']);
          $date2=date($_SESSION['new_checkOutDate']);
          $diff= (strtotime($date2) - strtotime($date1));
          $days = floor($diff / (60*60*24));
          $_SESSION['new_totalCost']=($room_array['CostPerDay']*$days)
          + ($_SESSION['new_extraBed']*$room_array['ExtraBedCost']);
          $_SESSION['new_roomNumber'] = $room_array['RoomNumber'];
          $_SESSION['new_roomLocation'] = $room_array['RoomLocation'];

          echo "
          <br />
          <h2>Seleted Reservation</h2>";
          echo '<table border = 1 width=1000px style="border-collapse:collapse;">
          <tr><td>Reservation ID</td>
            <td>Room Number</td>
            <td>Location</td>
            <td>Category</td>
            <td>Check in</td>
            <td>Check out</td>
            <td>Card Number</td>
            <td>Total Cost</td>
          </tr>';

          $getCategory = mysql_query("SELECT *
                                      FROM Room INNER JOIN Reservation INNER JOIN HasRoom
                                      ON ReservationID = ReserveID
                                      AND RoomNum = RoomNumber AND RoomLoc = RoomLocation
                                      WHERE ReservationID = '".$_SESSION['reservationID']."'");
          $getCategory_array = mysql_fetch_assoc($getCategory);
          echo "<tr><td>".$getCategory_array['ReservationID']."</td>
                    <td>".$getCategory_array['RoomNum']."</td>
                    <td>".$getCategory_array['RoomLoc']."</td>
                    <td>".$getCategory_array['RoomCategory']."</td>
                    <td>".$getCategory_array['StartDate']."</td>
                    <td>".$getCategory_array['EndDate']."</td>
                    <td>".$getCategory_array['CardNum']."</td>
                    <td>".$getCategory_array['TotalCost']."</td>
                </tr>";
        }
        echo '</table><br />';
        echo "
        <br />
        <h2>New Reservation</h2>";
        echo '<table border = 1 width=1000px style="border-collapse:collapse;">
          <tr><td>Reservation ID</td>
              <td>Room Number</td>
              <td>Location</td>
              <td>Category</td>
              <td>Check in</td>
              <td>Check out</td>
              <td>Card Number</td>
              <td>Total Cost</td>
          </tr>';
        echo "<tr><td>".$reserveInfo_array['ReservationID']."</td>
                  <td>".$_SESSION['new_roomNumber']."</td>
                  <td>".$getCategory_array['RoomLoc']."</td>
                  <td>".$_SESSION['new_category']."</td>
                  <td>".$_SESSION['new_checkInDate']."</td>
                  <td>".$_SESSION['new_checkOutDate']."</td>
                  <td>".$reserveInfo_array['CardNum']."</td>
                  <td>".$_SESSION['new_totalCost']."</td>
              </tr>";
      ?>
      </table>
      <br />
      <form name="updateReservation" action="./updateReserveConfirm.php" method="POST">
      <input type="submit" value="   Confirm   ">
      <input type="button" onclick="javascript_:location.href='./updateReservation.php';" value="  Cancel  " />
      </form>

      <?php
      }

    break;

  case 'cancel':

    $checkIn_date=date($findReservation_array['StartDate']);
    $now = strtotime(date("y-m-d", strtotime("now")));
    $daydiff_now = floor((strtotime($checkIn_date) - $now)/(60*60*24));
    if ($daydiff_now <= 1) {
      mysql_query("DELETE FROM HasRoom WHERE ReserveID = '".$_SESSION['reservationID']."'");
      mysql_query("UPDATE Reservation SET IsCancelled = true WHERE ReservationID = '".$_SESSION['reservationID']."'");
      header("Location: cancelReservation.php");
    } else if ($daydiff_now <= 3) {
      mysql_query("DELETE FROM HasRoom WHERE ReserveID = '".$_SESSION['reservationID']."'");
      mysql_query("UPDATE Reservation SET TotalCost *= 0.2,IsCancelled = true WHERE ReservationID = '".$_SESSION['reservationID']."'");
      header("Location: cancelReservation.php");
    } else {
      mysql_query("DELETE FROM HasRoom WHERE ReserveID = '".$_SESSION['reservationID']."'");
      mysql_query("UPDATE Reservation SET TotalCost = 0,IsCancelled = true WHERE ReservationID = '".$_SESSION['reservationID']."'");
      header("Location: cancelReservation.php");
    }
    break;
}
}
?>
</article>
</body>
</html>
<?php
mysql_close($conn);
?>
