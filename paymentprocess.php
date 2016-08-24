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
      <h2>Payment</h2>
      <?php
        $_SESSION['card_number'] = $_POST['cardNumber'];
        $cvv = $_POST['CVV'];
        $exp_date = $_POST['expDate'].'-01';
        $p_name = $_POST['PName'];

        $exp=date($exp_date);
        $diff= (strtotime($exp) - strtotime("now"));
        $days = floor($diff / (60*60*24));
        if (!$_SESSION['card_number'] || strlen($_SESSION['card_number']) < 16) {
          echo "<h2>Wrong card information. Try again</h2>";
          ?>
          <input type="button" onclick="javascript_:location.href='./findRoom.php';" value="Start Over" />
          <?php
        } else if ($card_result) {
          echo "<h2>This card is invalid. Try again with different card.</h2>";
          ?>
          <input type="button" onclick="javascript_:location.href='./findRoom.php';" value="Start Over" />
          <?php
        } else if (!$_POST['cardNumber'] || !$cvv || !$exp_date || !$p_name) {
          echo "<h2>Dont leave blank. Please Start Over</h2>";
          ?>
          <input type="button" onclick="javascript_:location.href='./findRoom.php';" value="Start Over" />
          <?php
        } else if ($days < 0) {
          echo "<h2>This Card is already expired.</h2>";
          ?>
          <input type="button" onclick="javascript_:location.href='./findRoom.php';" value="Start Over" />
          <?php
        } else {

        $card = mysql_query("SELECT * FROM PaymentInfo WHERE CardNumber='".$_SESSION['card_number']."'");
        $card_result = mysql_fetch_assoc($card);

        mysql_query("INSERT INTO PaymentInfo(CusName,CardNumber,CVV,ExpDate,PName)
                  VALUES('".$_SESSION['user_id']."','".$_POST['cardNumber']."','".$cvv."',LAST_DAY('".$exp_date."'),'".$p_name."')");

        $payInfo = mysql_query("SELECT *
                                FROM PaymentInfo
                                WHERE CusName='".$_SESSION['user_id']."'");
        $payInfo_array = mysql_fetch_assoc($payInfo);
        while ($payInfo_array) {
          echo '<form name="payment" action="./confirm.php" method="POST">';
          echo '<table border = 1 width=250px style="border-collapse:collapse;">
            <tr><td>Card Number</td>
            <td>Select</td>
            </tr>';
          echo "<tr><td>".$payInfo_array['CardNumber']."</td>";
          echo "<td><input type='radio' name='cardNumber' value=".$payInfo_array['CardNumber']."></td>
            </tr>";
          echo '</table>';
          $payInfo_array = mysql_fetch_assoc($payInfo);
        }

        }


      ?>
<div style="margin-left:70px;">
<input type="submit" value="   Next   ">
</div>
</article>
</body>
</html>
<?php
mysql_close($conn);
?>
