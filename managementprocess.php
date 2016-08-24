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
      <a href="https://academic-php.cc.gatech.edu/groups/cs4400_Group_34/management.php" onfocus="this.blur()">
        <center>Welcome to FANCY HOTEL</center>
      </a>
      </h1>
    </header>
    <nav>
      <form name="login" action="./managementprocess.php" method="POST">
      <ol>
        <br />
        <li><h4>Month</h4></li>
        <li><select name='month' style="border:1px solid gray; width:155px;">
          <option value = "">Select Month</option>
        	<option value = 1>January</option>
        	<option value = 2>February</option>
        	<option value = 3>March</option>
        	<option value = 4>April</option>
        	<option value = 5>May</option>
        	<option value = 6>June</option>
        	<option value = 7>July</option>
        	<option value = 8>August</option>
        	<option value = 9>September</option>
        	<option value = 10>October</option>
        	<option value = 11>November</option>
        	<option value = 12>December</option>
        </select>
        </li>
        <br />

        <li><h4>Report Type</h4></li>
        <li>
          <select name='reportType' style="border:1px solid gray; width:155px;">
          <option value = "">Select Report Type </option>
        	<option value = "ReservationReport"> Reservation Report </option>
        	<option value = "CategoryReport"> Category Report </option>
        	<option value = "RevenueReport"> Revenue Report </option>
        </select>
        </li>
        <li><h4></h4>
          <input type="submit" value="Submit" />
        </li>
        <br />
        <li><a href="./logoutprocess">Logout</a></li><br />
      </ol>
      </form>
    </nav>
    <article>
      <?php
        $_SESSION['month'] = $_POST['month'];
        $_SESSION['reportType'] = $_POST['reportType'];
        if (!$_SESSION['month'] || !$_SESSION['reportType']) {
          echo "Month or Location or Report type is not selected. Try again.";
        } else {
          $monthName = date('F', mktime(0, 0, 0, $_SESSION['month'], 10));
        switch($_SESSION['reportType']){
          case 'ReservationReport':
            $ReserveReport = mysql_query("SELECT RoomLoc, COUNT(*) as c FROM Reservation INNER JOIN HasRoom
                          ON ReserveID = ReservationID
                          WHERE IsCancelled = false
                          AND MONTH(StartDate) = '".$_SESSION['month']."'
                          GROUP BY RoomLoc");
            $ReserveReport_array = mysql_fetch_assoc($ReserveReport);
            if(!$ReserveReport_array) {
          		echo "<h2>No Reservation on ".$monthName."</h2>";
          	} else {
                echo "<h2>".$monthName."</h2><br />";
                echo '<table border = 1 width=400px style="border-collapse:collapse;">
                      <tr><td>Location</td>
                          <td>Total Number of Reservations</td>';
                 while ($ReserveReport_array) {
                echo "<tr><td>".$ReserveReport_array['RoomLoc']."</td>
                          <td>".$ReserveReport_array['c']."</td>
                          </tr>";
                  $ReserveReport_array = mysql_fetch_assoc($ReserveReport);
                }
                echo '</table>';
          	}
            break;

          case 'CategoryReport':

            $atlanta = mysql_query("
                        SELECT RoomCategory,RoomLoc,Count(ReservationID) as c
                        FROM Reservation INNER JOIN HasRoom INNER JOIN Room
                        ON ReservationID = ReserveID AND (RoomNum = RoomNumber AND RoomLoc = RoomLocation)
                        WHERE MONTH(StartDate) = '".$_SESSION['month']."' AND RoomLoc = 'Atlanta'
                        GROUP BY RoomCategory ORDER BY Count(ReservationID) DESC
                        LIMIT 1");
            $atlanta_array = mysql_fetch_assoc($atlanta);

            $savannah = mysql_query("
                        SELECT RoomCategory,RoomLoc,Count(ReservationID) as c
                        FROM Reservation INNER JOIN HasRoom INNER JOIN Room
                        ON ReservationID = ReserveID AND (RoomNum = RoomNumber AND RoomLoc = RoomLocation)
                        WHERE MONTH(StartDate) = '".$_SESSION['month']."' AND RoomLoc = 'Savannah'
                        GROUP BY RoomCategory ORDER BY Count(ReservationID) DESC
                        LIMIT 1");
            $savannah_array = mysql_fetch_assoc($savannah);

            $charlotte = mysql_query("
                        SELECT RoomCategory,RoomLoc,Count(ReservationID) as c
                        FROM Reservation INNER JOIN HasRoom INNER JOIN Room
                        ON ReservationID = ReserveID AND (RoomNum = RoomNumber AND RoomLoc = RoomLocation)
                        WHERE MONTH(StartDate) = '".$_SESSION['month']."' AND RoomLoc = 'Charlotte'
                        GROUP BY RoomCategory ORDER BY Count(ReservationID) DESC
                        LIMIT 1");
            $charlotte_array = mysql_fetch_assoc($charlotte);

            $orlando = mysql_query("
                        SELECT RoomCategory,RoomLoc,Count(ReservationID) as c
                        FROM Reservation INNER JOIN HasRoom INNER JOIN Room
                        ON ReservationID = ReserveID AND (RoomNum = RoomNumber AND RoomLoc = RoomLocation)
                        WHERE MONTH(StartDate) = '".$_SESSION['month']."' AND RoomLoc = 'Orlando'
                        GROUP BY RoomCategory ORDER BY Count(ReservationID) DESC
                        LIMIT 1");
            $orlando_array = mysql_fetch_assoc($orlando);

            $miami = mysql_query("
                        SELECT RoomCategory,RoomLoc,Count(ReservationID) as c
                        FROM Reservation INNER JOIN HasRoom INNER JOIN Room
                        ON ReservationID = ReserveID AND (RoomNum = RoomNumber AND RoomLoc = RoomLocation)
                        WHERE MONTH(StartDate) = '".$_SESSION['month']."' AND RoomLoc = 'Miami'
                        GROUP BY RoomCategory ORDER BY Count(ReservationID) DESC
                        LIMIT 1");
            $miami_array = mysql_fetch_assoc($miami);

            if(!$atlanta_array && !$savannah_array && !$charlotte_array
            && !$orlando_array && !$miami_array){
              echo "<h2>No Reservation on ".$monthName."</h2>";
            } else {
                echo "<h2>".$monthName."</h2><br />";
                echo '<table border = 1 width=900px style="border-collapse:collapse;">
                      <tr><td>Top Room Category</td>
                          <td>Location</td>
                          <td>Total number of Reservations for room category</td>
                      </tr>';
                if ($atlanta_array) {
                  echo "<tr><td>".$atlanta_array['RoomCategory']."</td>
                            <td>".$atlanta_array['RoomLoc']."</td>
                            <td>".$atlanta_array['c']."</td>
                            </tr>";
                }
                if ($savannah_array) {
                  echo "<tr><td>".$savannah_array['RoomCategory']."</td>
                            <td>".$savannah_array['RoomLoc']."</td>
                            <td>".$savannah_array['c']."</td>
                            </tr>";
                }
                if ($charlotte_array) {
                  echo "<tr><td>".$charlotte_array['RoomCategory']."</td>
                            <td>".$charlotte_array['RoomLoc']."</td>
                            <td>".$charlotte_array['c']."</td>
                            </tr>";
                }
                if ($orlando_array) {
                  echo "<tr><td>".$orlando_array['RoomCategory']."</td>
                            <td>".$orlando_array['RoomLoc']."</td>
                            <td>".$orlando_array['c']."</td>
                            </tr>";
                }
                if ($miami_array) {
                  echo "<tr><td>".$miami_array['RoomCategory']."</td>
                            <td>".$miami_array['RoomLoc']."</td>
                            <td>".$miami_array['c']."</td>
                            </tr>";
                }
              echo '</table>';
            }
            break;
          case 'RevenueReport':
            $revenueReport = mysql_query("SELECT RoomLoc, SUM(TotalCost) as s
                                          FROM Reservation
                                          INNER JOIN HasRoom
                                          INNER JOIN Room ON ReservationID = ReserveID
                                          AND (
                                            RoomNum = RoomNumber
                                          AND RoomLoc = RoomLocation
                                          )
                                          WHERE MONTH(StartDate) =  '".$_SESSION['month']."'
                                          GROUP BY RoomLoc");
            $revenueReport_array = mysql_fetch_assoc($revenueReport);
            if(!$revenueReport_array) {
              echo "<h2>No Reservation on ".$monthName."</h2>";
            } else {
              echo "<h2>".$monthName."</h2><br />";
              echo '<table border = 1 width=500px style="border-collapse:collapse;">
                    <tr><td>Location</td>
                        <td>Total Reveneu</td>';
               while ($revenueReport_array) {
              echo "<tr><td>".$revenueReport_array['RoomLoc']."</td>
                        <td> $ ".$revenueReport_array['s']."</td>
                        </tr>";
                $revenueReport_array = mysql_fetch_assoc($revenueReport);
              }
              echo '</table>';
            }
            break;
        }

      }
?>
    </article>
  </body>
</html>
