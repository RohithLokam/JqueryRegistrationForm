<?php
session_start();
    if (count($_SESSION) == 0) {
    header("Location: index.php");
    exit();
}
?>
<?php
if (isset($_GET['otp_sending_success']) && $_GET['otp_sending_success'] === 'true') {


  echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css'>";
  echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js'></script>";
  echo "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js'></script>";
  
  echo "<style>";
  echo "  .custom-alert {";
  echo "    position: fixed;";
  echo "    top: 3%;";
  echo "    left: 50%;";
  echo "    width: 100%;";
  echo "    text-align: left;";
  echo "    transform: translateX(-50%);";
  echo "    z-index: 1050;"; 
  echo "  }";
  echo "</style>";

  echo "<script>";
  echo "$(document).ready(function() {";
  echo "  var alertMessage = 'OTP Sending successfully!';";
  echo "  var alertElement = $('<div class=\"alert alert-success custom-alert\">').html('<strong>Success!</strong> ' + alertMessage);";
  echo "  $('body').append(alertElement);";
  echo "  setTimeout(function() {";
  echo "    alertElement.remove();";
  echo "  }, 2007);";
  echo "});";
  echo "</script>";
  echo "<script>";
echo "setTimeout(function() {";
echo "  window.location.href = 'otp_verification.php?success=false';";
echo "}, 2007);";
echo "</script>";
}
else if (isset($_GET['otp_verified_success']) && $_GET['otp_verified_success'] === 'true') {


  echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css'>";
  echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js'></script>";
  echo "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js'></script>";
  
  echo "<style>";
  echo "  .custom-alert {";
  echo "    position: fixed;";
  echo "    top: 3%;";
  echo "    left: 50%;";
  echo "    width: 100%;";
  echo "    text-align: left;";
  echo "    transform: translateX(-50%);";
  echo "    z-index: 1050;"; 
  echo "  }";
  echo "</style>";

  echo "<script>";
  echo "$(document).ready(function() {";
  echo "  var alertMessage = 'Invalid OTP!';";
  echo "  var alertElement = $('<div class=\"alert alert-warning custom-alert\">').html('<strong>Failure!</strong> ' + alertMessage);";
  echo "  $('body').append(alertElement);";
  echo "  setTimeout(function() {";
  echo "    alertElement.remove();";
  echo "  }, 2007);";
  echo "});";
  echo "</script>";
  echo "<script>";
echo "setTimeout(function() {";
echo "  window.location.href = 'otp_verification.php?success=false';";
echo "}, 2007);";
echo "</script>";
}
?>

<?php
// session_start();
$otpp=$_SESSION['otp'];
// echo "  $otpp  ";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp = $_POST["input1"] . $_POST["input2"] . $_POST["input3"] . $_POST["input4"]; 


    $api_url = "http://172.17.13.138:8080/otp_verification";

    $data = array("otp" => $otp,"user_otp" => $otpp );
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ),
    );

    $context = stream_context_create($options);
    $result = file_get_contents($api_url, false, $context);

    if ($result === FALSE) {
        echo "<script>";
        echo "alert('Unable to connect to the server.');";
        echo "</script>"; 
    } else {
        $response = json_decode($result, true);

        if ($response && isset($response['success']) && $response['success']) {

            $data = json_decode($result, true);


            header("Location: new_password.php?otp_verified_success=true");
            exit();
                } else {

                  header("Location: otp_verification.php?otp_verified_success=true");
                  exit();  
                     }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PeopleConnect</title>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700&display=swap");


    .background-image {
      width: 50%;
      height: 100%;
      background: url('https://hubble.miraclesoft.com/assets/img/bg-login.jpg') center/cover no-repeat;
    }



    svg {
      margin: 16px 0;
    }

    #image-container {
      flex: 1;
      overflow: hidden;
      height: 100vh;
      display: flex;
      align-items: center;

    }

    #content-container {
      position: absolute;
      bottom: 0;
      left: 0;
      padding: 20px;
      color: #fff;
    }


    #background-image {
      height: 100%;
      object-fit: cover;
    }


    body {
      margin: 0;
      padding: 0;
      display: flex;
      height: 100vh;
      justify-content: center;
      align-items: center;
      background-color: #f4f4f4;
    }

    .box {
      width: 350px;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      background-color: #fff;
      text-align: center;
      margin-left: 5%;
      margin-right: 5%;
      z-index: 1000;
    }

    .title {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    p {
      color: #555;
      font-size: 14px;
      margin-bottom: 20px;
    }

    #inputs {
      display: flex;
      justify-content: space-around;
      margin-bottom: 20px;
    }

    input {
      width: 50px;
      height: 50px;
      text-align: center;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 18px;
      margin: 0 5px;
      outline: none;
    }

    input:focus {
      border-color: #3598dc;
    }

    button {


      background-color: #df1171;
      color: white;
      padding: 10px 15px;
      margin: 8px 0;
      border: none;
      cursor: pointer;
      width: 50%;
      border-radius: 4px;
    }

    button:hover {
      opacity: 0.8;

    }

    @media only screen and (max-width: 550px) and (min-width: 2700px) {
      #image-container {
        display: none;
      }
    }
  </style>
</head>

<body>

  <div id="image-container">
    <img id="background-image" src="https://hubble.miraclesoft.com/assets/img/bg-login.jpg" alt="Background Image">
    <div id="content-container">
      <p>
        <h1>Hubble - Miracle's Portal for</h1>
      </p>
      <p>
        <h1>Enterprise Resource</h1>
      </p>
      <p>
        <h1>Management</h1>
      </p>
      <p style="color:white;">© 2024 Miracle Software Systems, Inc.</p>
    </div>
  </div>
  <div class="box">
    <form action="" method="post">
      <img alt="Image" width="189" height="72" src="Mlogo.png">
      <p>We have sent a verification code to your registered email</p>
      <div id='inputs'>
        <input id='input1' name="input1" type='text' maxLength="1" />
        <input id='input2' name="input2" type='text' maxLength="1" />
        <input id='input3' name="input3" type='text' maxLength="1" />
        <input id='input4' name="input4" type='text' maxLength="1" />
      </div>
      <button>Submit</button>
    </form>
  </div>

  <script>
    function addListener(input) {
      input.addEventListener("keyup", (event) => {
        const code = parseInt(input.value);
        if (code >= 0 && code <= 9) {
          const nextInput = input.nextElementSibling;
          if (nextInput) nextInput.focus();
        } else {
          input.value = "";
        }
        const key = event.key;
        if (key === "Backspace" || key === "Delete") {
          const prevInput = input.previousElementSibling;
          if (prevInput) prevInput.focus();
        }
      });
    }
    const inputIds = ["input1", "input2", "input3", "input4"];
    inputIds.forEach((id) => {
      const inputElement = document.getElementById(id);
      addListener(inputElement);
    });
  </script>

</body>

</html>