<?php
session_start();
$conn = mysql_connect('academic-mysql.cc.gatech.edu', 'cs4400_Group_34', 'EvP1tOJE');
if (!$conn) {
  die('Could not connect: '.mysql_error());
}
mysql_select_db('cs4400_Group_34');
$user_id=$_SESSION['user_id'];
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
      <br />
      <h2>Please Select your reservation to update</h2>
      <?php
        $reserveInfo = mysql_query("SELECT * FROM Reservation INNER JOIN HasRoom
                                    WHERE CusName='".$_SESSION['user_id']."'
                                    AND ReservationID = ReserveID
                                    AND IsCancelled = false");
        $reserveInfo_array = mysql_fetch_assoc($reserveInfo);
        if (!$reserveInfo_array) {
          echo "<h2>There is no any Reservation</h2>";
        } else {
          echo '<form name="updateReservation" action="./updateReservationprocess.php?mode=update" method="POST">';
          echo '<table border = 1 width=1000px style="border-collapse:collapse;">
            <tr><td>Reservation ID</td>
                <td>Room Number</td>
                <td>Location</td>
                <td>Category</td>
                <td>Check in</td>
                <td>Check out</td>
                <td>Card Number</td>
                <td>Total Cost</td>
                <td>Select</td>
            </tr>';
          while ($reserveInfo_array) {
            $getCategory = mysql_query("SELECT *
                                        FROM Room
                                        WHERE RoomNumber = '".$reserveInfo_array['RoomNum']."'
                                        AND RoomLocation = '".$reserveInfo_array['RoomLoc']."'");
            $getCategory_array = mysql_fetch_assoc($getCategory);
            echo "<tr><td>".$reserveInfo_array['ReservationID']."</td>
                      <td>".$reserveInfo_array['RoomNum']."</td>
                      <td>".$reserveInfo_array['RoomLoc']."</td>
                      <td>".$getCategory_array['RoomCategory']."</td>
                      <td>".$reserveInfo_array['StartDate']."</td>
                      <td>".$reserveInfo_array['EndDate']."</td>
                      <td>".$reserveInfo_array['CardNum']."</td>
                      <td>".$reserveInfo_array['TotalCost']."</td>
                      <td><input type='radio' value=".$reserveInfo_array['ReservationID']." name='reserveInfo'></td>
                  </tr>";
            $reserveInfo_array = mysql_fetch_assoc($reserveInfo);
          }
          echo '</table>';
          ?>
          <br /><br />
          <br /><br />
          Category :
          <select name='category' style="border:1px solid gray; width:155px;">
            <option value="">Select Category</option>
            <option value="Standard">Standard</option>
            <option value="Deluxe">Deluxe</option>
            <option value="Suite">Suite</option>
          </select>
          <br /><br />
          Number of Extra Bed :
          <select name='extraBed' style="border:1px solid gray; width:155px;">
            <option value="">Select Number</option>
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
          <br /><br />
          <p>Check-in Date (yyyy-mm-dd):
          <input type="text" name="checkInDate" maxlength="10">
          <br /></p>
          <p>Check-out Date (yyyy-mm-dd):
          <input type="text" name="checkOutDate" maxlength="10">
          <br /></p>
          <div>
          <input type="submit" value="   Next   ">
          </div>
          </form>
          <?php
        }
      ?>
    </article>
  </body>
</html>
<?php
mysql_close($conn);
?>
