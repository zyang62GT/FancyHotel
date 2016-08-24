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
      <?php
          $checkIn_date=date($_POST['checkInDate']);
          $diff= (strtotime($checkIn_date) - strtotime("now"));
          $days = floor($diff / (60*60*24));

          $date1=date($_POST['checkInDate']);
          $date2=date($_POST['checkOutDate']);
          $diff_date= (strtotime($date2) - strtotime($date1));
          $diff_days = floor($diff_date / (60*60*24));

          if (!$_POST['location'] || !$_POST['category']
          || !$_POST['checkInDate'] || !$_POST['checkOutDate']) {
            echo "<script>alert('Fill out all information.');
            history.back();</script>";

          } else if (strlen($_POST['checkInDate']) < 10
                  || strlen($_POST['checkOutDate']) < 10) {
            echo "<script>alert('Wrong date. Try again.');
            history.back();</script>";

          } else if ($days < 1) {
            echo "<script>alert('You cannot check-in 24 hours.');
            history.back();</script>";

          } else if ($diff_days < 1) {
            echo "<script>alert('Check out date cannot be earlier than Check in date');
            history.back();</script>";

          } else {

          echo "<h2>REVIEW</h2><br />";

        // $result = mysql_query("SELECT * FROM Room WHERE
        //   RoomLocation='".$_SESSION['location']."'
        //   AND RoomCategory='".$_SESSION['category']."'");
        $result = mysql_query(
        "SELECT *
        FROM Room
        WHERE (RoomNumber, RoomLocation)
          NOT IN (SELECT RoomNumber, RoomLocation
                  FROM Room,HasRoom,Reservation
                  WHERE RoomNumber = RoomNum
                    AND RoomLocation = RoomLoc
                    AND ReservationID = ReserveID
                    AND ((EndDate >= '".$_POST['checkInDate']."'
                      AND StartDate <= '".$_POST['checkInDate']."')
                      OR (EndDate >= '".$_POST['checkOutDate']."'
                      AND StartDate <= '".$_POST['checkOutDate']."')))
          AND RoomLocation = '".$_POST['location']."'
          AND RoomCategory = '".$_POST['category']."'
        ");
        $room_array = mysql_fetch_assoc($result);
        if (!$room_array) {
          echo "<script>
          alert('There is no available room. Choose another Date.');
          history.back();
          </script>";
        } else {
          $totalCost=($room_array['CostPerDay']*$diff_days)
          + ($_POST['extraBed']*$room_array['ExtraBedCost']);
            echo date_diff($_POST['checkInDate'],$_POST['checkOutDate']);
            echo '<table border = 1 width=800px style="border-collapse:collapse;">
              <tr><td>Location</td>
                  <td>Category</td>
                  <td>Total Cost</td>
                  <td>Date of Check-in</td>
                  <td>Date of Check-out</td>
              </tr>';

            echo '<tr><td>'.$_POST['location'].'</td>
                      <td>'.$_POST['category'].'</td>
                      <td>'.$totalCost.'</td>
                      <td>'.$_POST['checkInDate'].'</td>
                      <td>'.$_POST['checkOutDate'].'</td>
                  </tr>';
            echo '</table>';
        }
        $_SESSION['totalCost']=$totalCost;
        $_SESSION['location']=$_POST['location'];
        $_SESSION['category']=$_POST['category'];
        $_SESSION['extraBed']=$_POST['extraBed'];
        $_SESSION['checkInDate']=$_POST['checkInDate'];
        $_SESSION['checkOutDate']=$_POST['checkOutDate'];
      ?>
      <br /><br />
      <h2>Payment</h2>
      <?php
        $payInfo = mysql_query("SELECT *
                                FROM PaymentInfo
                                WHERE CusName='".$_SESSION['user_id']."'");
        $payInfo_array = mysql_fetch_assoc($payInfo);
        if (!$payInfo_array) {
          echo '<form name="addPayment" action="./paymentprocess.php?mode=addPayment" method="POST">';
          echo '<p>Card Number:
                <input type="text" name="cardNumber" maxlength="16">
                <br /></p>
                <p>CVV:
                <input type="text" name="CVV" maxlength="3">
                <br /></p>
                <p>Exp Date(yyyy-mm):
                <input type="text" name="expDate" maxlength="7">
                <br /></p>
                <p>Full Name on the card:
                <input type="text" name="PName" maxlength="40">
                <br /></p>
                <input type="submit" value="   Add   ">
                </form>
                ';
        } else {
          while ($payInfo_array) {
            echo '<form name="payment" action="./confirm.php" method="POST">';
            echo '<table border = 1 width=120px style="border-collapse:collapse;">
              <tr><td>Card Number</td>
              <td>Select</td>
              </tr>';
            echo '<tr><td>'.$payInfo_array['CardNumber'].'</td>';
            echo "<td><input type='radio' value=".$payInfo_array['CardNumber']." name='cardNumber'></td>
                  </tr>";
            echo '</table>';
            $payInfo_array = mysql_fetch_assoc($payInfo);
          }
          echo '<div style="margin-left:150px;">
          <input type="submit" value="   Next   ">
          </div>
          </form>';
        }
        }
      ?>
    </article>
  </body>
</html>
<?php
mysql_close($conn);
?>
