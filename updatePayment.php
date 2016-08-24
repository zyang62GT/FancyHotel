<?php
session_start();
$conn = mysql_connect('academic-mysql.cc.gatech.edu', 'cs4400_Group_34', 'EvP1tOJE');
if (!$conn) {
  die('Could not connect: '.mysql_error());
}
mysql_select_db('cs4400_Group_34');

switch($_GET['mode']){
  case 'deleteCard':
    $_SESSION['payment'] = $_POST['paymentInfo'];
    if (!$_SESSION['payment']) {
      echo "<script>alert('SELECT PAYMENT INFORMATION IN THE LIST');history.back();</script>";
    }
    mysql_query("DELETE FROM PaymentInfo WHERE CardNumber = '".$_SESSION['payment']."'");
    header("Location: paymentInfo.php");
    break;

  case 'addCard':
    $_SESSION['card_number'] = $_POST['cardNumber'];
    $cvv = $_POST['CVV'];
    $exp_date = $_POST['expDate'].'-01';
    $p_name = $_POST['PName'];
    $card = mysql_query("SELECT * FROM PaymentInfo WHERE CardNumber='".$_SESSION['card_number']."'");
    $card_result = mysql_fetch_assoc($card);
    if ($card_result) {
      echo "<script>alert('This card is invalid');
      history.back();</script>";
    }
    mysql_query("INSERT INTO PaymentInfo(CusName,CardNumber,CVV,ExpDate,PName)
                 VALUES('".$_SESSION['user_id']."','".$_SESSION['card_number']."','".$cvv."',LAST_DAY('".$exp_date."'),'".$p_name."')");
    header("Location: paymentInfo.php");
    break;
}

mysql_close($conn);
?>
