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
      <h3>Choose Month, Location, Report Type</h3>
      <br />
    </article>
  </body>
</html>
