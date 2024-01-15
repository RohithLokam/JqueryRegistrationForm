<?php
session_start();
    if (count($_SESSION) == 0) {
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