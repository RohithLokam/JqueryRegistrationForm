<?php

 if (isset($_GET['update_success']) && $_GET['update_success'] === 'true') {
  echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css'>";
  echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js'></script>";
  echo "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js'></script>";

  echo "<style>";
  echo "  .custom-alert {";
  echo "    position: fixed;";
  echo "    top: 9%;";
  echo "    left: 50%;";
  echo "    width: 100%;";
  echo "    text-align: left;";
  echo "    transform: translateX(-50%);";
  echo "    z-index: 1050;"; 
  echo "  }";
  echo "</style>";

  echo "<script>";
  echo "$(document).ready(function() {";
  echo "  var alertMessage = 'Updated Successfully!';";
  echo "  var alertElement = $('<div class=\"alert alert-success custom-alert\">').html('<strong>Success!</strong> ' + alertMessage);";
  echo "  $('body').append(alertElement);";
  echo "  setTimeout(function() {";
  echo "    alertElement.remove();";
  echo "  }, 2007);";
  echo "});";
  echo "</script>";
  echo "<script>";
echo "setTimeout(function() {";
echo "  window.location.href = 'home.php?success=false';";
echo "}, 2007);";
echo "</script>";
}

?>

<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}    if (count($_SESSION) == 0) {
    header("Location: index.php");
    exit();
}
?>


<?php include 'layout.php'; ?>




<html>
<body>

</body>
<style>

    body{
        
  background-image: url('https://hubble.miraclesoft.com/assets/img/bg-login.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;

    }
</style>

</html>