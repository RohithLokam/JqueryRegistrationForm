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
  echo "  var alertMessage = 'Invalid Email Address!';";
  echo "  var alertElement = $('<div class=\"alert alert-warning custom-alert\">').html('<strong>Failure!</strong> ' + alertMessage);";
  echo "  $('body').append(alertElement);";
  echo "  setTimeout(function() {";
  echo "    alertElement.remove();";
  echo "  }, 2007);";
  echo "});";
  echo "</script>";
  echo "<script>";
  echo "setTimeout(function() {";
  echo "  window.location.href = 'otp_sending.php?success=false';";
  echo "}, 2007);";
  echo "</script>";
}
?>
<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["Email"];

  $api_url = "http://172.17.13.138:8080/sendmail";

  $data = array("email" => $username);
  $options = array(
    'http' => array(
      'header' => "Content-type: application/json\r\n",
      'method' => 'POST',
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


      if (!empty($data) && isset($data['data']) && count($data['data']) > 0) {
        $user = $data['data'][0];

        $_SESSION['otp'] = $user['otp'];
        $_SESSION['Email'] = $user['email'];




      }
      header("Location: otp_verification.php?otp_sending_success=true");
      exit();
    } else {
      header("Location: otp_sending.php?otp_sending_success=true");
      exit();   
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <title>PeopleConnect</title>
  <style>
    .login-form {
      width: 387px;
      text-align: center;
      box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
      padding: 30px;
      border-radius: 5px;
      background: #fff;
    }

    .login-form h2 {
      margin: 10px 0 25px;
    }

    .form-control {
      width: 100%;
      padding: 10px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 3px;
      outline: none;
      min-height: 41px;
      background: #f2f2f2;
      box-shadow: none !important;
      border: transparent;
    }

    .form-control:focus {
      border-color: #3598dc;
    }

    a {
      color: #3598dc;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    .text-center {
      text-align: center;
    }

    .small {
      font-size: 12px;
    }

    body {
      margin: 0;
      padding: 0;
      display: flex;
      height: 100vh;
    }

    #image-cont {
      flex: 1;
      overflow: hidden;
      height: 100vh;
      display: flex;
      align-items: center;

    }

    #login-container {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #f4f4f4;
      max-width: 396px;
      padding: 63px;
      width: 54%;
      z-index: 1000;

    }

    #content-cont {
      position: absolute;
      bottom: 0;
      left: 0;
      padding: 20px;
      color: #fff;
    }

    #login-form {

      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      background-color: #fff;
    }


    #background-image {
      height: 100%;
      object-fit: cover;
    }

    .instrument-serif-regular {
      font-family: "Instrument Serif", serif;
      font-weight: 400;
      font-size: 36px;
      font-style: normal;
    }


    .spinner {
      display: none;
      width: 14px;
      height: 14px;
      margin-top: 1px;
      border: 3px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      margin-bottom: 1px;
      border-top: 3px solid #ffffff;
      animation: spin 1s linear infinite;
      margin-right: 10px;
    }

    .button-content {
      display: flex;
      align-items: center;
      padding-left: 45px;
    }

    .butt {
      position: relative;
      background-color: #df1171;
      color: white;
      padding: 10px 15px;
      margin: 8px 0;
      border: none;
      cursor: pointer;
      width: 50%;
      border-radius: 4px;
    }

    .butt:hover {
      opacity: 0.8;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    @media only screen and (max-width: 550px) and (min-width: 270px) {
      #image-cont {
        display: none;
      }
    }

    .error-tooltip {
      position: absolute;
      margin-top: 5px;
      background-color: #ff000f;
      color: white;
      padding: 8px;
      border-radius: 4px;
      display: none;
      width: 200px;
      z-index: 50;
    }
  </style>

</head>

<body>
  <div id="image-cont">
    <img id="background-image" src="https://hubble.miraclesoft.com/assets/img/bg-login.jpg" alt="Background Image">
    <div id="content-cont">
      <p>
      <h1 class="instrument-serif-regular">Hubble - Miracle's Portal for</h1>
      </p>
      <p>
      <h1 class="instrument-serif-regular">Enterprise Resource</h1>
      </p>
      <p>
      <h1 class="instrument-serif-regular">Management</h1>
      </p>
      <p>© 2024 Miracle Software Systems, Inc.</p>
    </div>
  </div>

  <div id="login-container">

    <div class="login-form">
      <img alt="Image" width="189" height="72" src="Mlogo.png">
      <br><br>
      <form onsubmit="return handleButtonClick();" action="" method="post">
        <input type="text" id="Email" class="form-control" name="Email" placeholder="Enter Corporate  Email Address"
          required="required"><br>
        <div id="email-error-tooltip" class="error-tooltip"></div><br>

        <div class="form-group">
          <button id="sendButton" type="submit" class="butt">
            <div class="button-content">
              <p id="spinner" class="spinner"></p>
              <span class="button-text">Send</span>
            </div>
          </button>

        </div>
        <p class="text-center small"> <a href="index.php">Previous Page</a></p>
      </form>
    </div>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
  $(document).ready(function () {
    $("#Email").on("input", function () {
      emailValidation();
    });
  });

  function emailValidation() {
    var emailRegex = /^[^\s@]+@miraclesoft\.com$/;
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const userEmail = $("#Email").val();
    const unameElement = $("#email-error-tooltip");
    if (userEmail === "") {
      unameElement.html("Email can't be empty");
    }
    else if (!(emailRegex.test(userEmail) || emailPattern.test(userEmail))) {
      unameElement.text("Valid @miraclesoft.com email ID required");
      unameElement.show();
    } else {
      unameElement.text("");
      unameElement.hide();
    }
  }

  function handleButtonClick() {
    document.getElementById('sendButton').disabled = true;
    document.querySelector('.spinner').style.display = 'block';
    setTimeout(function () {
      document.getElementById('sendButton').disabled = false;
      document.querySelector('.spinner').style.display = 'none';
    }, 5000);
    return true;
  }

</script>

</html>