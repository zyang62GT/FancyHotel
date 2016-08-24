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
      <div>
        <form name="review" action="./provideReviewprocess.php" method="POST">
          <table border = 1 width=500px style="border-collapse:collapse;">
            Location :
            <select name='location' style="border:1px solid gray; width:155px;">
              <option value="">Select location</option>
              <option value="Atlanta">Atlanta</option>
              <option value="Charlotte">Charlotte</option>
              <option value="Savannah">Savannah</option>
              <option value="Orlando">Orlando</option>
              <option value="Miami">Miami</option>
            </select>
            <br /><br />
            Rate :
            <select name='hotelRating' style="border:1px solid gray; width:155px;">
              <option value="">Select Rating</option>
              <option value="Excellent">Excellent</option>
              <option value="Good">Good</option>
              <option value="Bad">Bad</option>
              <option value="Very Bad">Very Bad</option>
              <option value="Neutral">Neutral</option>
            </select>
            <br /><br />
            <p>Comment:
            <input type="text" name="comment" maxlength="40" width="150">
            </p><br />

            <input type="submit" value="  Submit  ">
          </form>
      </div>
    </article>
  </body>
</html>

<?php
mysql_close($conn);
?>
