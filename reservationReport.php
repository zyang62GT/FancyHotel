<?php
  session_start();

  //connect


  $conn = mysql_connect('academic-mysql.cc.gatech.edu', 'cs4400_Group_34', 'EvP1tOJE');
  if (!$conn) {
    die('Could not connect: '.mysql_error());
  }
  mysql_select_db('cs4400_Group_34');
  $_SESSION['new_month'] = $_POST['month'];
  $reservation_result = mysql_query("SELECT MONTH(StartDate), RoomLoc, COUNT( ReservationID ) 
FROM Reservation
INNER JOIN HasRoom
INNER JOIN Room ON ReservationID = ReserveID
AND (
RoomNum = RoomNumber
AND RoomLoc = RoomLocation
)
WHERE MONTH( StartDate ) =  '1'
AND RoomLoc =  'Atlanta';");
  $reservation_result2 = mysql_query("SELECT MONTH(StartDate), RoomLoc, COUNT( ReservationID )
FROM Reservation
INNER JOIN HasRoom
INNER JOIN Room ON ReservationID = ReserveID
AND (
RoomNum = RoomNumber
AND RoomLoc = RoomLocation
)
WHERE MONTH( StartDate ) =  '1'
AND RoomLoc =  'Charlotte';");
  $reservation_result3 = mysql_query("SELECT MONTH(StartDate), RoomLoc, COUNT( ReservationID )
FROM Reservation
INNER JOIN HasRoom
INNER JOIN Room ON ReservationID = ReserveID
AND (
RoomNum = RoomNumber
AND RoomLoc = RoomLocation
)
WHERE MONTH( StartDate ) =  '1'
AND RoomLoc =  'Savannah';");
  $reservation_result4 = mysql_query("SELECT MONTH(StartDate), RoomLoc, COUNT( ReservationID )
FROM Reservation
INNER JOIN HasRoom
INNER JOIN Room ON ReservationID = ReserveID
AND (
RoomNum = RoomNumber
AND RoomLoc = RoomLocation
)
WHERE MONTH( StartDate ) =  '1'
AND RoomLoc =  'Orlando';");
  $reservation_result5 = mysql_query("SELECT MONTH(StartDate), RoomLoc, COUNT( ReservationID )
FROM Reservation
INNER JOIN HasRoom
INNER JOIN Room ON ReservationID = ReserveID
AND (
RoomNum = RoomNumber
AND RoomLoc = RoomLocation
)
WHERE MONTH( StartDate ) =  '1'
AND RoomLoc =  'Miami';");

  //$re_array = mysql_fetch_array($reservation_result);

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
 <li><a href="./reservationReportmonth.php?month=<?php echo $month = $_POST['month']?>">Reservation Report</a></li><br />
        <li><a href="./popularRoommonth.php?month=<?php echo $month = $_POST['month']?>">Category Report</a></li><br />
        <li><a href="./revenueReportmonth.php?month=<?php echo $month = $_POST['month']?>">Revenue Report</a></li><br />
	        <li><a href="./logoutprocess">Logout</a></li><br />

     </ol>

    </nav>
    <article>
      
        <table border = 1 width=500px style="border-collapse:collapse; text-align:center;">
          <tr>
            <td>Month</td>
            <td>Location</td>
            <td>Number of Reservation</td>
          
          </tr>
          <?php 


          while ($val = mysql_fetch_assoc($reservation_result)){
          
          echo "         
          <tr>
            <td>" . $val['MONTH(StartDate)'] . "</td>
            <td>". $val['RoomLoc'] . "</td>
            <td>". $val['COUNT( ReservationID )'] . "</td>
          </tr>
          ";
      
          }
          while ($val2 = mysql_fetch_assoc($reservation_result2)){

          echo "
          <tr>
            <td>" . $val2['MONTH(StartDate)'] . "</td>
            <td>". $val2['RoomLoc'] . "</td>
            <td>". $val2['COUNT( ReservationID )'] . "</td>
          </tr>
          ";

          }
          while ($val3 = mysql_fetch_assoc($reservation_result3)){

          echo "
          <tr>
            <td>" . $val3['MONTH(StartDate)'] . "</td>
            <td>". $val3['RoomLoc'] . "</td>
            <td>". $val3['COUNT( ReservationID )'] . "</td>
          </tr>
          ";

          }
          while ($val4 = mysql_fetch_assoc($reservation_result4)){

          echo "
          <tr>
            <td>" . $val4['MONTH(StartDate)'] . "</td>
            <td>". $val4['RoomLoc'] . "</td>
            <td>". $val4['COUNT( ReservationID )'] . "</td>
          </tr>
          ";

          }
          while ($val5 = mysql_fetch_assoc($reservation_result5)){

          echo "
          <tr>
            <td>" . $val5['MONTH(StartDate)'] . "</td>
            <td>". $val5['RoomLoc'] . "</td>
            <td>". $val5['COUNT( ReservationID )'] . "</td>
          </tr>
          ";

          }

          ?>
        </table>
       
    </article>
  </body>
</html>
