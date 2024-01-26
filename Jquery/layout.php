<?php
// session_start();
    if (count($_SESSION) == 0) {
    header("Location: index.php");
    exit();
}
?>
<?php
if (isset($_GET['login_success']) && $_GET['login_success'] === 'true') {


  echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css'>";
  echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js'></script>";
  echo "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js'></script>";
  
  echo "<style>";
  echo "  .custom-alert {";
  echo "    position: fixed;";
  echo "    top: 5%;";
  echo "    left: 50%;";
  echo "    width: 100%;";
  echo "    height: 5%;";
  echo "    text-align: left;";
  echo "    transform: translateX(-50%);";
  echo "    z-index: 1050;"; 
  echo "  }";
  echo "</style>";

  echo "<script>";
  echo "$(document).ready(function() {";
  echo "  var alertMessage = 'Login Successfully!';";
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
else if (isset($_GET['register_success']) && $_GET['register_success'] === 'true') {


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
  echo "  var alertMessage = 'Registered Successfully!';";
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

else if (isset($_GET['reset_success']) && $_GET['reset_success'] === 'true') {
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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
 <style>


header{
  position: sticky;
  top: 0;
  /* top:1rem; */
  z-index:50;
  
}
  footer {
    bottom: 0;
    background-color: black;
    color: white;
    position: fixed;
    padding: -50px;
    width: 100%;
    text-align: right;
    justify-content: flex-end;
    margin-left: -0.18400000%;
    display:block;
}


.profilee{
  
  /* border-radius: 20%; */
  /* justify-content: flex-end;  */
  margin-left:5 rem; 
  
   padding-top: 1rem;
  
  }
  .pname{
    white-space: nowrap; /* Prevent text from wrapping */
  
    padding-left:-9%;
    margin-right:3.6rem; 
    color:DeepSkyBlue;
    margin-left:5rem;
    /* text-align:left; */
    padding-top: 2rem;
    /* padding-bottom: 3rem; */
    justify-content: flex-end; 
  }
  #profile-image {
              max-width: 100px;
              height: 72px;
           
          }
          .profile{
    margin-right:1%;
    /* width: 150px; */
              border-radius: 50%;
              z-index:500;
              /* overflow: hidden; */
  }
  .profile-containerr {
      /* position: relative; */
      position: sticky;
      display: inline-block;
      z-index:50;
  }
  
  .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index:1000;
  }
  
  .dropdown-content a {
      padding: 12px 16px;
      display: block;
      text-decoration: none;
      color: #333;
    
  }
  
  .dropdown-content a:hover {
      background-color: #ddd;
  }
  
  .show {
      display: block;
  }
  .unwanted{
    display:none;
  }.menus{
    display:none;
  }
  @media only screen and (max-width: 450px) and (min-width: 243px) {
    .unwanted{
    display:flex;
  }
  .wanted{
    display:none;
  }
  .user_image{
    width:54px;
    height:27px;
  }
.menus{
    display:flex;
  }
  }
</style>


</head>

<title>PeopleConnect</title>
<body>
<header>
<nav class="navbar navbar-expand-lg navbar navbar-light bg-light" style="z-index:10089;">
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <a href="home.php">
    <img class="logo-image"  alt="Image" width="171" height="63" src="Mlogo.png" >
  </a>
  <div  class="profile-containerr unwanted">
    <?php
    if (!isset($_SESSION['firstName']) || !isset($_SESSION['lastName']) || !isset($_SESSION['image'])) {
      exit();
    }

    $firstNamee = $_SESSION['firstName'];
    $lastNamee = $_SESSION['lastName'];
    $imagee = $_SESSION['image'];
    $employId = $_SESSION['employId'];

    if (!empty($imagee)) {
        $imageData = base64_decode($imagee);
        $imageType = "data:image/png;base64,";
        echo '<div class="profile-containerr">';
        echo '<img class="user_image" style="max-width:100px; height: 72px; border-radius:45%;" id="profile-image" class="profile-image" src="' . $imageType . base64_encode($imageData) . '" alt="Profile Image">';
        echo '</div>';
        echo '</div>';
    } else {
        $num=9999;
        echo '<div class="profile-container">';
        echo '<img style="max-width:100px; height: 72px;" id="profile-image" class="profile-image" src="unknown.jpg" alt="Profile Image">';
        echo '</div>';
        echo '</div>';
    }
    ?>
  </div>
 
  <div class="collapse navbar-collapse" id="navbarSupportedContent" style="z-index:10089;">

    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        
        <a class="nav-link" href="home.php"><i class="fa fa-fw fa-home"></i><b> Home</b><span class="sr-only">(current)</span></a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" href="registration_form.php"><i class="fa fa-fw fa-plus"></i><b>Register</b><span class="sr-only">(current)</span></a>
      </li> -->
      <li class="nav-item">
        <a class="nav-link" href="practice.php"><i class="fa fa-fw fa-list"></i><b>Employ Data</b><span class="sr-only">(current)</span></a>
      </li>

      <li class="nav-item menus">
        <a class="nav-link " href="profile.php?employId=<?= json_encode($employId); ?>"><i class="fs-13 fa fa-user"></i> Profile<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item menus">
        <a class="nav-link" href="password_reset.php"><i class="fa fa-outdent"></i> Reset Password<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item menus">
        <a class="nav-link" href="logout.php"><i class="fa fa-power-off"></i> Log Out<span class="sr-only">(current)</span></a>
      </li>

      

   
    </ul>
    <form class="form-inline my-2 my-lg-0">


<div class="profilee">



  <?php

if (!isset($_SESSION['firstName']) || !isset($_SESSION['lastName']) || !isset($_SESSION['image'])) {
  exit();
}

$firstNamee = $_SESSION['firstName'];
$lastNamee = $_SESSION['lastName'];
$imagee = $_SESSION['image'];
$employId=$_SESSION['employId'];
   

if (!empty($imagee)) {
  $imageData = base64_decode($imagee);
  $imageType = "data:image/png;base64,";

  echo '<div class="profile-container wanted" >';
  echo '<img style="max-width:100px; height: 72px; border-radius:45%;" id="profile-image" class="profile-image" src="' . $imageType . base64_encode($imageData) . '" alt="Profile Image">';
  echo '<div class="dropdown-content" id="myDropdown">';
  echo '<a  href="profile.php?employId=' . $employId . '"><i class="fs-13 fa fa-user"></i> Profile</a>';
  echo '<a href="password_reset.php"><i class="fa fa-outdent"></i> Reset Pasword</a>';
  echo '<a href="logout.php"><i class="fa fa-power-off"></i> Logout</a>';
  echo '</div>';
  echo '</div>';
} else { 
  $num=9999;
  echo '<div class="profile-container">';
  echo '<img style="max-width:100px; height: 72px;" id="profile-image" class="profile-image" src="unknown.jpg" alt="Profile Image">';
  echo '<div class="dropdown-content" id="myDropdown">';
  echo '<a  href="profile.php?employId=' . $num . '"><i class="fs-13 fa fa-user"></i> Profile</a>';
  echo '<a href="password_reset.php"><i class="fa fa-outdent"></i> Reset Password</a>';
  echo '<a href="logout.php"><i class="fa fa-power-off"></i> Logout</a>';
  echo '</div>';
  echo '</div>';

}

?> 

</div>

<div class="pname"> 
<h3> <p style="color:black;" id="proff">User Name</p></h3>

</div>


</header>

<div class="foot">
<footer>
       
       <p>@Miracle Software Systems 2024.</p>
   

</footer>  
</div>
    </form>
  </div>
</nav>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    const firstNamee = <?= json_encode($firstNamee); ?>;
    const lastNamee = <?= json_encode($lastNamee); ?>;

    const unameElementt = $("#proff");

    const fullName = `${firstNamee} ${lastNamee}`;

    unameElementt.html(fullName);

  
    console.log(fullName);
</script>


  <script>


$(document).ready(function() {
    const profileImage = $('.profile-image');
    const dropdown = $('.dropdown-content');

    profileImage.on('click', function() {
        dropdown.toggleClass('show');
    });

    $(window).on('click', function(event) {
        if (!$(event.target).hasClass('profile-image')) {
            if (dropdown.hasClass('show')) {
                dropdown.removeClass('show');
            }
        }
    });
});

</script>
</body>
</html>