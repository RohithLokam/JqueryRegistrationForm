<?php


if (isset($_GET['success']) && $_GET['success'] === 'true') {
    echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css'>";
    echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js'></script>";
    echo "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js'></script>";

    echo "<style>";
    echo "  .custom-alert {";
    echo "    position: fixed;";
    echo "    top: 0;";
    echo "    left: 50%;";
    echo "    width: 100%;";
    echo "    text-align: left;";
    echo "    transform: translateX(-50%);";
    echo "    z-index: 1050;";
    echo "  }";
    echo "</style>";

    echo "<script>";
    echo "$(document).ready(function() {";
    echo "  var alertMessage = 'Invalid Credentials!';";
    echo "  var alertElement = $('<div class=\"alert alert-warning custom-alert\">').html('<strong>Failure!</strong> ' + alertMessage);";
    echo "  $('body').append(alertElement);";
    echo "  setTimeout(function() {";
    echo "    alertElement.remove();";
    echo "  }, 2007);";
    echo "});";
    echo "</script>";
    echo "<script>";
    echo "setTimeout(function() {";
    echo "  window.location.href = 'index.php?success=false';";
    echo "}, 2007);";
    echo "</script>";
} else if (isset($_GET['newPassword_success']) && $_GET['newPassword_success'] === 'true') {
    echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css'>";
    echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js'></script>";
    echo "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js'></script>";

    echo "<style>";
    echo "  .custom-alert {";
    echo "    position: fixed;";
    echo "    top: 0;";
    echo "    left: 50%;";
    echo "    width: 100%;";
    echo "    text-align: left;";
    echo "    transform: translateX(-50%);";
    echo "    z-index: 1050;";
    echo "  }";
    echo "</style>";

    echo "<script>";
    echo "$(document).ready(function() {";
    echo "  var alertMessage = 'Password Generated Successfully!';";
    echo "  var alertElement = $('<div class=\"alert alert-Success custom-alert\">').html('<strong>Success!</strong> ' + alertMessage);";
    echo "  $('body').append(alertElement);";
    echo "  setTimeout(function() {";
    echo "    alertElement.remove();";
    echo "  }, 2007);";
    echo "});";
    echo "</script>";
    echo "<script>";
    echo "setTimeout(function() {";
    echo "  window.location.href = 'index.php?success=false';";
    echo "}, 2007);";
    echo "</script>";
} else if (isset($_GET['register_success']) && $_GET['register_success'] === 'true') {
    echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css'>";
    echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js'></script>";
    echo "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js'></script>";

    echo "<style>";
    echo "  .custom-alert {";
    echo "    position: fixed;";
    echo "    top: 0;";
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
    echo "  var alertElement = $('<div class=\"alert alert-Success custom-alert\">').html('<strong>Success!</strong> ' + alertMessage);";
    echo "  $('body').append(alertElement);";
    echo "  setTimeout(function() {";
    echo "    alertElement.remove();";
    echo "  }, 2007);";
    echo "});";
    echo "</script>";
    echo "<script>";
    echo "setTimeout(function() {";
    echo "  window.location.href = 'index.php?success=false';";
    echo "}, 2007);";
    echo "</script>";
}

?>

<?php
session_start();



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $_SESSION['password'] = $password;


    $api_url = "http://172.17.13.138:8080/employ";

    $data = array("userName" => $username, "password" => $password);
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
            if (!empty($data) && isset($data['Token'])) {
                $_SESSION['test2'] = "hii";
                $secret_key = "+Pm3mQ9BnNJy3E3h5J90E8+DjoitTunV/nS5GOWCuau0WEuhexg/ze112Wte9fYwEW+jJX9KoRBMCSd499p83w==";
                $jwt_token = $data['Token'];
                $_SESSION['token'] = $data['Token'];
                try {
                    $tokenParts = explode('.', $jwt_token);
                    $payloadEncoded = $tokenParts[1];
                    $payload = base64_decode($payloadEncoded);
                    $decodedPayload = json_decode($payload, true);
                    $firstName = $decodedPayload['firstName'];
                    $lastName = $decodedPayload['lastName'];
                    $employId = $decodedPayload['employId'];

                    $_SESSION['firstName'] = $firstName;
                    $_SESSION['lastName'] = $lastName;
                    $_SESSION['employId'] = $employId;

                } catch (\Exception $e) {
                    echo 'Error: ' . $e->getMessage();
                }
            }
            if (!empty($data) && isset($data['data']) && count($data['data']) > 0) {
                $user = $data['data'][0];
                $_SESSION['image'] = $user['image'];
                $_SESSION['passKey'] = $user['passKey'];
            }
            header("Location: home.php?login_success=true");
            exit();
        } else {
            header("Location: index.php?success=true");
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
    <title>PeopleConnect</title>
    <style>
        .login-form {
            width: 350px;
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

        .btn {
            background-color: #df1171;
            color: white;
            padding: 10px 15px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 50%;
            border-radius: 4px;
        }

        .btn:hover {
            opacity: 0.8;
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

        #image-container {
            flex: 1;
            overflow: hidden;
            height: 100vh;
            display: flex;
            align-items: center;
            position: relative;

        }

        #login-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
            max-width: 420px;
            padding: 63px;
            width: 72%;
            z-index: 1000;
            /* position: fixed; */
        }

        #content-container {
            position: absolute;
            bottom: 0;
            left: 0;
            padding: 20px;
            color: #fff;
        }

        #login-form {
            /* max-width: 270px;  */
            /* width: 81%; */
            /* padding: 14px; */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }


        #background-image {
            height: 100%;
            object-fit: cover;
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


        @media only screen and (max-width: 550px) and (min-width: 270px) {
            #image-container {
                display: none;
            }


            #tp {
                transform: translateY(-27%);
                height: 45px;
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
            <p>© 2024 Miracle Software Systems, Inc.</p>
        </div>
    </div>

    <div id="login-container">

        <div class="login-form">
            <img alt="Image" width="189" height="72" src="Mlogo.png">

            <br><br>
            <form action="" method="post">
                <input type="text" id="userName" class="form-control" name="username" placeholder="Username"
                    required="required"><br>
                <div id="uname-error-tooltip" class="error-tooltip"></div><br>
                <!-- <p style="color:red;" id="uname"></p> -->
                <input type="text" id="password" class="form-control" name="password" placeholder="Password"
                    required="required"><br>
                <img class="eye" src="https://clipground.com/images/password-eye-icon-png-2.png" width="9%" height="14%"
                    style="z-index:3; margin-left: 88%; margin-top:-16%; display:inline; vertical-align: middle; position:relative;"
                    id="tp">
                <p style="text-align: right; margin-top:-5px; margin-bottom:-5px;" class="text-center small"> <a
                        href="otp_sending.php">Forgot Password</a></p>
                <!-- <p style="color:red;" id="passwd"></p> -->
                <div id="pname-error-tooltip" class="error-tooltip"></div><br>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Sign in</button>
                </div>
                <p class="text-center small"><b>Don't have an account? <a href="registration_form.php">Sign up</a></b>
                </p>
            </form>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
        $("#userName").on("blur", function() {
            userNameValidation();
        });
        $("#password").on("blur", function() {
            passwordValidation();
        });
    });

    function userNameValidation() {
        const userName = $("#userName").val();
        if (userName === "") {
            showErrorTooltip("Username can't be empty!!!", "uname-error-tooltip");
        } else {
            hideErrorTooltip("uname-error-tooltip");
        }
        setTimeout(function() {
            $("#uname-error-tooltip").hide();
        }, 2700);
    }

    function passwordValidation() {
        const password = $("#password").val();
        if (password === "") {
            showErrorTooltip("Password can't be empty!!!", "pname-error-tooltip");
        } else {
            hideErrorTooltip("pname-error-tooltip");
        }
        setTimeout(function() {
            $("#pname-error-tooltip").hide();
        }, 2700);
    }

    function showErrorTooltip(message, elementId) {
        $("#" + elementId).text(message);
        $("#" + elementId).show();
    }

    function hideErrorTooltip(elementId) {
        $("#" + elementId).text("");
        $("#" + elementId).hide();
    }
    const togglePassword = document.querySelector('#tp');
    const password = document.querySelector('#password');
    let isPasswordVisible = false;
    password.setAttribute('type', 'password');
    togglePassword.addEventListener('click', function() {
        isPasswordVisible = !isPasswordVisible;
        const type = isPasswordVisible ? 'text' : 'password';
        password.setAttribute('type', type);
        // Toggle the eye icon
        if (isPasswordVisible) {
            togglePassword.src = "https://clipground.com/images/password-eye-icon-png-2.png";
        } else {
            togglePassword.src =
                "https://cdn3.iconfinder.com/data/icons/show-and-hide-password/100/show_hide_password-08-512.png";
        }
    });
</script>

</html>