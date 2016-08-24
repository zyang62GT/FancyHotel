<?php
session_start();
$conn = mysql_connect('academic-mysql.cc.gatech.edu', 'cs4400_Group_34', 'EvP1tOJE');
if (!$conn) {
  die('Could not connect: '.mysql_error());
}
mysql_select_db('cs4400_Group_34');
$_SESSION['card_number'] = $_POST['cardNumber'];
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
    <article>
      <?php
        if (!$_SESSION['card_number']) {
          echo "<script>alert('Payment is NOT SELECTED.');</script>";
          header("Location: findRoom.php");
        }
        // echo '<p>'.$_SESSION['user_id'].'</p>';
        // echo '<p>'.$_POST['cardNumber'].'</p>';
        // echo '<p>'.$_SESSION['checkInDate'].'</p>';
        // echo '<p>'.$_SESSION['checkOutDate'].'</p>';
        // echo '<p>'.$_SESSION['totalCost'].'</p>';
        // echo '<p>'.$_SESSION['location'].'</p>';
        // echo '<p>'.$_SESSION['category'].'</p>';
        $_SESSION['isExtraBed'] = false;
        if ($_SESSION['extraBed']>0) {
          $_SESSION['isExtraBed'] = 1;
        } else {
          $_SESSION['isExtraBed'] = 0;
        }
        $result = mysql_query(
        "SELECT *
        FROM Room
        WHERE (RoomNumber, RoomLocation)
          NOT IN (SELECT RoomNumber, RoomLocation
                  FROM Room,HasRoom,Reservation
                  WHERE RoomNumber = RoomNum
                    AND RoomLocation = RoomLoc
                    AND ReservationID = ReserveID
                    AND ((EndDate >= '".$_SESSION['checkInDate']."'
                      AND StartDate <= '".$_SESSION['checkInDate']."')
                      OR (EndDate >= '".$_SESSION['checkOutDate']."'
                      AND StartDate <= '".$_SESSION['checkOutDate']."')))
          AND RoomLocation = '".$_SESSION['location']."'
          AND RoomCategory = '".$_SESSION['category']."'
        ");
        $room_array = mysql_fetch_assoc($result);
        $_SESSION['roomNumber'] = $room_array['RoomNumber'];
        mysql_query("INSERT INTO Reservation(CusName,CardNum,StartDate,EndDate,TotalCost,IsCancelled)
                     VALUES('".$_SESSION['user_id']."','".$_SESSION['card_number']."',
                     '".$_SESSION['checkInDate']."','".$_SESSION['checkOutDate']."',
                     ".$_SESSION['totalCost'].",0)");
        $re_id = mysql_insert_id();
        if ($_SESSION['isExtraBed'] = 0) {
          $extrabed_show = "NO";
        } else {
          $extrabed_show = "YES";
        }
        echo "<h2>Confirmation</h2>";
        echo '<table border = 1 width=1000px style="border-collapse:collapse;">
          <tr><td>Reservation ID</td>
              <td>Room Number</td>
              <td>Location</td>
              <td>Category</td>
              <td>Check In</td>
              <td>Check Out</td>
              <td>Total Cost</td>
              <td>Extra Bed</td>
          </tr>';
        echo "<tr><td>".$re_id."</td>
                  <td>".$_SESSION['roomNumber']."</td>
                  <td>".$_SESSION['location']."</td>
                  <td>".$_SESSION['category']."</td>
                  <td>".$_SESSION['checkInDate']."</td>
                  <td>".$_SESSION['checkOutDate']."</td>
                  <td>".'$ '.$_SESSION['totalCost']."</td>
                  <td>".$extrabed_show."</td>
          </tr>";
          // HERE!@!!!!!!!!!!!!!!!!

          mysql_query("INSERT INTO HasRoom(ReserveID,RoomNum,RoomLoc,IncludeExtrabed)
                       VALUES(".$re_id.",".$_SESSION['roomNumber'].",
                       '".$_SESSION['location']."',".$_SESSION['isExtraBed'].")");

          ?>
        </table>
        <input type="button" onclick="javascript_:location.href='./updateReservation.php';" value="  OK   " />

    </article>
  </body>
</html>
<?php
session_unregister('location');
session_unregister('category');
session_unregister('extraBed');
session_unregister('checkInDate');
session_unregister('checkOutDate');
mysql_close($conn);
?>
