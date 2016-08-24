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
      <h2>Payment Information</h2>
      <?php
        $payment = mysql_query("SELECT * FROM PaymentInfo
                                WHERE CusName='".$_SESSION['user_id']."'");
        $payment_array = mysql_fetch_assoc($payment);
        if (!$payment_array) {
          echo "<h2>Add your payment information</h2>";
        } else {
        echo '<form name="updatePayment" action="./updatePayment.php?mode=deleteCard" method="POST">';
        echo '<table border = 1 width=300px style="border-collapse:collapse;">
          <tr><td>Card Number</td>
              <td>Name</td>
              <td>Select</td>
          </tr>';
        while ($payment_array) {
          echo "<tr><td>".$payment_array['CardNumber']."</td>
                    <td>".$payment_array['PName']."</td>
                    <td><input type='radio' value=".$payment_array['CardNumber']." name='paymentInfo'></td>
                </tr>";
          $payment_array = mysql_fetch_assoc($payment);
        }
        echo '</table>';
        ?>
        <br /><div style="margin-left:10px;">
        <input type="submit" value="   Delete   ">
        </div>
        </form>
        <br />


        <?php
        }
        echo '<br />';
        echo '<form name="addPayment" action="./updatePayment.php?mode=addCard" method="POST">';
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
        ?>
    </article>
  </body>
</html>
<?php
mysql_close($conn);
?>
