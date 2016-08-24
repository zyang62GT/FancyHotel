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
      <div style="border-bottom:1px solid gray;
      width:1000px;
      height:120px;
      float:left">
      <form action="./reviewprocess.php" method="POST">
        <h2>Comment</h2>
        Hotel Location :
        <select name="location" style="border:1px solid gray; width:155px;">
          <option value="">Select location</option>
          <option value="Atlanta">Atlanta</option>
          <option value="Charlotte">Charlotte</option>
          <option value="Savannah">Savannah</option>
          <option value="Orlando">Orlando</option>
          <option value="Miami">Miami</option>
        </select>
        <input type="submit" value="Check Reviews">
      </form>
      </div>
      <?php
        $review_location = $_POST['location'];
        if (!$_POST['location']) {
          echo "<script>alert('Please select the location.');
          history.back();</script>";
        } else {
          ?>
          <div style="margin-top:145px;">
          <form action="./provideReview.php" method="POST">
            <input type="submit" value="Provide Review">
          </form>
          <br />
          <?php
          $review = mysql_query("SELECT * FROM HotelReview WHERE Location = '".$review_location."'");
          $review_array = mysql_fetch_assoc($review);
          echo '<table border = 1 width=1000px style="border-collapse:collapse;">
            <tr><td width=200px>Rating</td>
                <td>Comment</td>
            </tr>';
          while ($review_array) {
            echo "<tr><td>".$review_array['Rating']."</td>
                      <td>".$review_array['Comment']."</td>
                  </tr>";
            $review_array = mysql_fetch_assoc($review);
          }
          echo '</table>';
        }
      ?>
      <br />
      </div>
    </article>
  </body>
</html>

<?php
mysql_close($conn);
?>
