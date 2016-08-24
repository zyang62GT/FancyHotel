<?php
  session_start();
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
      <h3>Welcome to Fancy Hotel!!!</h3>
      <br />
    </article>
  </body>
</html>
