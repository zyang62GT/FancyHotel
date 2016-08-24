<?
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
      <form name="login" action="./findRoomprocess.php" method="POST">
        <table border = 1 width=500px style="border-collapse:collapse; text-align:center;">
          <tr>
            <td>Number of People</td>
            <td>Category</td>
            <td>Cost per day</td>
            <td>Cost of extra bed</td>
          </tr>
          <tr>
            <td>3</td>
            <td>Standard</td>
            <td>$100.00</td>
            <td>$30.00</td>
          </tr>
          <tr>
            <td>5</td>
            <td>Deluxe</td>
            <td>$150.00</td>
            <td>$40.00</td>
          </tr>
          <tr>
            <td>7</td>
            <td>Suite</td>
            <td>$200.00</td>
            <td>$50.00</td>
          </tr>
        </table>
        <br />
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
        <input type="submit" value="  Find  ">
      </form>
      <br /><br />
    </article>
  </body>
</html>
