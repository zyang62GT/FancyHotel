<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <style type="text/css">
      a img{
        border:none;
      }
      a:link { text-decoration:none; color:black;}
      a:visited { text-decoration:none;  color:black;}
      a:hover { text-decoration:none;  color:black;}
      a:active { text-decoration:none;  color:black;}
      h1{
        color:black;
        background-image: url('./cuba.jpg');
        background-position: top;
        background-repeat: no-repeat;
        background-size: cover;
        font-size: 50px;
        font-style: italic;
        font-family: "Times New Roman", Times, serif;
        border:1px solid gray;
        padding:30px;
        text-decoration: none;
      }
      nav{
        text-align:center;
        font-weight:200;
      }
    </style>
    <h1>
    <a href="https://academic-php.cc.gatech.edu/groups/cs4400_Group_34/" onfocus="this.blur()">
      <center>Welcome to FANCY HOTEL</center>
    </a>
    </h1>
  </head>
  <body>
    <nav>
    <br />
      <form name="login" action="./loginprocess.php?mode=login" method="POST">
        <pre>       ID: <input type="Text" name = "ID" maxlength="50"></pre>
        Password: <input type="Password" name = "pwd" maxlength="50">
        <br />
        <br />
        <input type="submit" value="Login">
        <input type="button" onclick="javascript_:location.href='./register.php';" value="Register" />
        <br />
      </form>
      <br />
    </nav>
  </body>
</html>
