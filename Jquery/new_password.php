<?php
session_start();
if (count($_SESSION) == 0) {
    header("Location: index.php");
    exit();
}
?>
<?php
if (isset($_GET['otp_verified_success']) && $_GET['otp_verified_success'] === 'true') {


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
    echo "  var alertMessage = 'OTP Verified successfully!';";
    echo "  var alertElement = $('<div class=\"alert alert-success custom-alert\">').html('<strong>Success!</strong> ' + alertMessage);";
    echo "  $('body').append(alertElement);";
    echo "  setTimeout(function() {";
    echo "    alertElement.remove();";
    echo "  }, 2007);";
    echo "});";
    echo "</script>";
    echo "<script>";
    echo "setTimeout(function() {";
    echo "  window.location.href = 'new_password.php?success=false';";
    echo "}, 2007);";
    echo "</script>";
} else if (isset($_GET['newPassword_success']) && $_GET['newPassword_success'] === 'true') {


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
    echo "  var alertMessage = 'Password Not Generated!';";
    echo "  var alertElement = $('<div class=\"alert alert-warning custom-alert\">').html('<strong>Failure!</strong> ' + alertMessage);";
    echo "  $('body').append(alertElement);";
    echo "  setTimeout(function() {";
    echo "    alertElement.remove();";
    echo "  }, 2007);";
    echo "});";
    echo "</script>";
    echo "<script>";
    echo "setTimeout(function() {";
    echo "  window.location.href = 'new_password.php?success=false';";
    echo "}, 2007);";
    echo "</script>";
}
?>
<?php include 'api.php'  ?>

<?php
// session_start();
$Email = $_SESSION['Email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];

    $api_url = "$root/password_update";

    $data = array("password" => $password, "email" => $Email);
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

            // $data = json_decode($result, true);




            header("Location: index.php?newPassword_success=true");
            exit();
            //  echo "<script>";
            //  echo "alert(' Password updated  successful!');";
            //  echo "window.location.href='logout.php';";
            //  echo "</script>";
        } else {
            header("Location: new_password.php?newPassword_success=true");
            exit();
            // echo "<script>";
            // echo "alert('password not  updated!');";
            // echo "window.location.history();";
            // echo "</script>";   
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
            z-index: 1008;
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

        @media only screen and (max-width: 550px) and (min-width: 2700px) {

            #image-container,
            #content-container {
                display: none;
            }

            #tp {
                transform: translateY(-27%);
                height: 45px;
            }

            #tpp {
                transform: translateY(-27%);
                height: 45px;
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

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
            <form onsubmit="return validPasswords();" action="" method="post">
                <input type="text" id="userName" class="form-control" name="username" placeholder="New Password"><br>
                <img src="https://clipground.com/images/password-eye-icon-png-2.png" width="9%" height="14%"
                    style="z-index:3; margin-left: 88%; margin-top:-16%; display:inline; vertical-align: middle;"
                    id="tp">
                <p style="color:red;" id="uname"></p>
                <div id="uname-error-tooltip" class="error-tooltip"></div><br>
                <input type="text" id="password" class="form-control" name="password"
                    placeholder="Confirm Password"><br>
                <img src="https://clipground.com/images/password-eye-icon-png-2.png" width="9%" height="14%"
                    style="z-index:3; margin-left: 88%; margin-top:-16%; display:inline; vertical-align: middle;"
                    id="tpp">
                <p style="color:red;" id="passwd"></p>
                <div id="passwd-error-tooltip" class="error-tooltip"></div><br>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                <!-- <p class="text-center small"> <a href="otp_sending.php">Forgot Password</a></p> -->
            </form>
        </div>
    </div>
</body>

<script>
    $(document).ready(function () {
        $("#userName").on("input", function () {
            userNameValidation();
        });
        $("#password").on("input", function () {
            passwordValidation();
        });
    });

    function userNameValidation() {
        const passwordInput = $("#userName").val();
        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\W).+$/;
        const passwordElement = $("#uname-error-tooltip");
        const passwordMatch = passwordInput.match(passwordPattern);
        if (!passwordMatch) {
            passwordElement.text(
                "Password must contain at least one uppercase letter, one lowercase letter, and one special character."
            );
            passwordElement.show();
            return false;
        } else {
            passwordElement.html("");
            passwordElement.hide();
            return true;
        }
    }

    function passwordValidation() {
        const togglePassword1 = document.querySelector('#tpp');
        const password1 = document.querySelector('#password');
        let isPasswordVisible1 = false;
        password.setAttribute('type', 'password');
        togglePassword1.addEventListener('click', function () {
            isPasswordVisible1 = !isPasswordVisible1;
            const type = isPasswordVisible1 ? 'text' : 'password';
            password1.setAttribute('type', type);
            // Toggle the eye icon
            if (isPasswordVisible1) {
                togglePassword1.src = "https://clipground.com/images/password-eye-icon-png-2.png";
            } else {
                togglePassword1.src =
                    "https://cdn3.iconfinder.com/data/icons/show-and-hide-password/100/show_hide_password-08-512.png";
            }
        });
        const passwordInput = $("#password").val();
        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\W).+$/;
        const passwordElement = $("#passwd-error-tooltip");
        const passwordMatch = passwordInput.match(passwordPattern);
        if (!passwordMatch) {
            passwordElement.text(
                "Password must contain at least one uppercase letter, one lowercase letter, and one special character."
            );
            return false;
        } else {
            passwordElement.html("");
            return true;
        }
    }

    function validPasswords() {
        userNameValidation();
        passwordValidation();
        var newPassword = $('#userName').val();
        var confirmPassword = $('#password').val();
        if (newPassword === "" && confirmPassword === "") {
            $('#passwd-error-tooltip').text("Fields Can't Be Empty!");
            ('#passwd-error-tooltip').show();
            return false;
        } else if (newPassword !== confirmPassword) {
            $('#passwd-error-tooltip').text("Does Not Match With New Password!");
            $('#passwd-error-tooltip').show();
            return false;
        } else {
            $('#uname-error-tooltip').text("");
            $('#uname-error-tooltip').hide();
            $('#passwd-error-tooltip').text("");
            ('#passwd-error-tooltip').hide();
            return true;
        }
    }
    const togglePassword = document.querySelector('#tp');
    const password = document.querySelector('#userName');
    let isPasswordVisible = false;
    password.setAttribute('type', 'password');
    togglePassword.addEventListener('click', function () {
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