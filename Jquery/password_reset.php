<?php
session_start();
    if (count($_SESSION) == 0) {
    header("Location: index.php");
    exit();
}
?>

<?php
if (empty($_SESSION['passKey'])) {
    header("Location: index.php");
    exit();
}
?>
<?php
if (isset($_GET['reset_password_success']) && $_GET['reset_password_success'] === 'true') {


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
  echo "  var alertMessage = 'Password Not Updated!';";
  echo "  var alertElement = $('<div class=\"alert alert-warning custom-alert\">').html('<strong>Success!</strong> ' + alertMessage);";
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
<?php include 'home.php'; ?>

<?php
// session_start();

$passwd=$_SESSION['password'];
$empId=$_SESSION['employId'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employId = $empId;
    $password = $_POST["confirmpassword"];

    $api_url = "http://172.17.13.138:8080/reset_password";

    $data = array("employId" => $employId, "password" => $password);
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


            // header("Location: layout.php?reset_success=true");
            //             exit();
             echo "<script>";
             echo "alert('Password Updated successfully!');";
             echo "window.location.href='home.php';";
             echo "</script>";
            exit();
                } else {
                    // header("Location: password_reset.php?reset_password_success=true");
                    // exit();
                    echo "<script>";
                    echo "alert('Invalid credentials!');";
                    echo "window.location.history();";
                    echo "</script>";   
                     }
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>PeopleConnect</title>
    <style>
        #oldpassword,
        #newpassword,
        #confirmpassword{
            height: 36px;
width: 250px;
border: 2px solid #3498DB;
border-radius: 5px;
padding: 10px;
margin-bottom: 15px;
outline: none;
margin-left: 10px;
        }
        label{
            font-size:large;
            width:5px;
        }

        .register {
            text-align: center;
            border-style: solid;
            margin-left: 36%;
            margin-right: 36%;
            position: fixed;
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 14px 27px 18px 27px;
            margin-top: 3%;
            margin-bottom: 54%;
            z-index: 0;
            position: fixed;
            max-height: 80vh;
            overflow-y: auto;
        }

        h3 {
            text-align: center;
        }

        p {
            color: red;
        }

        .select {
            border-color: white;
            margin-left: 14%;
            margin-right: 15%;
        }

        .arrow {
            border: solid black;
            border-width: 0 3px 3px 0;
            display: inline-block;
            padding: 3px;
            cursor: pointer;
            text-align: left;
        }
        .button{
            background-color: #df1171;
  color: white;
  padding: 10px 15px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 50%; 
  border-radius: 4px;
        }

        .button:hover {
            background-color: purple;
            color: white;
            opacity:0.8;
        }
    </style>
</head>

<body>
    <div class="register">
        <a href="home.php" style="float: left; margin-left: 3%;">
            <span class="arrow">&larr;</span>
            Go Back
        </a><br>
        <h2 style="color: rgb(177, 9, 73);"> Reset Password </h2>
        <form action="" method="post" onsubmit="return validateForm()">
            <label>Old Password : </label>
            <input type="password" id="oldpassword" name="oldpassword" placeholder="Enter old password" >
            <img src="https://clipground.com/images/password-eye-icon-png-2.png" width="9%" height="14%" style="z-index:3; margin-left: 57.6%; margin-top:-13.5%; display:inline; vertical-align: middle;" id="tp1">
            <p  id="oldpasswordMessage"></p>
            <label>New Password : </label>
            <input type="password" id="newpassword" name="newpassword" placeholder="Enter new password" >
            <img src="https://clipground.com/images/password-eye-icon-png-2.png" width="9%" height="14%" style="z-index:3; margin-left: 57.6%; margin-top:-13.5%; display:inline; vertical-align: middle;" id="tp2">
            <p  id="newpasswordMessage"></p>
            <label>Confirm Password : </label>
            <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm new password"  ><br>
            <img src="https://clipground.com/images/password-eye-icon-png-2.png" width="9%" height="14%" style="z-index:3; margin-left: 57.6%; margin-top:-13.5%; display:inline; vertical-align: middle;" id="tp3">
            <p  id="confirmpasswordMessage"></p>
            <input class="button" type="submit" value="Update">
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>

    // console.log(existingPassword);
        $(document).ready(function () {
            $("#oldpassword").on("blur", function () {
                checkOldPassword();
            });
            $("#newpassword").on("blur", function () {
                validateNewPassword();
            });
            $("#confirmpassword").on("blur", function () {
                validateConfirmPassword();
            });
        });


        let count = 0;

function validateForm() {
    count = 0; 

    checkOldPassword();
    validateNewPassword() ;
    validateConfirmPassword();
    if(count==3){
        return true;
    }else{
        return false;
    }


}

        
function checkOldPassword() {
    const togglePassword1 = document.querySelector('#tp1');
const password1 = document.querySelector('#oldpassword');
let isPasswordVisible1 = false;

password1.setAttribute('type', 'password');



togglePassword1.addEventListener('click', function () {
    isPasswordVisible1 = !isPasswordVisible1;

    const type1 = isPasswordVisible1 ? 'text' : 'password';
    password1.setAttribute('type', type1);

    // Toggle the eye icon
    if (isPasswordVisible1) {
        togglePassword1.src = "https://clipground.com/images/password-eye-icon-png-2.png";
    } else {
        togglePassword1.src = "https://cdn3.iconfinder.com/data/icons/show-and-hide-password/100/show_hide_password-08-512.png";

    }
});

    const existingPassword = <?= json_encode($passwd); ?>;
    const passwordInput = $("#oldpassword").val();
    const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\W).+$/;
    const passwordElement = $("#oldpasswordMessage");
    const passwordMatch = passwordInput.match(passwordPattern);

    if(passwordInput === ""){
        passwordElement.html("Password Can Not Be Empty.");
    }
    else if (!passwordMatch) {
        passwordElement.html("Password must contain at least one uppercase letter, one lowercase letter, and one special character.");
    }
    else if (existingPassword !== passwordInput) {
                passwordElement.html("Existing Password Does Not Match");
            } 
            else {
                count++;
        passwordElement.html("");
    }
}

function validateNewPassword() {
    const togglePassword2 = document.querySelector('#tp2');
const password2 = document.querySelector('#newpassword');
let isPasswordVisible2 = false;

password2.setAttribute('type', 'password');



togglePassword2.addEventListener('click', function () {
    isPasswordVisible2 = !isPasswordVisible2;

    const type2 = isPasswordVisible2 ? 'text' : 'password';
    password2.setAttribute('type', type2);

    // Toggle the eye icon
    if (isPasswordVisible2) {
        togglePassword2.src = "https://clipground.com/images/password-eye-icon-png-2.png";
    } else {
        togglePassword2.src = "https://cdn3.iconfinder.com/data/icons/show-and-hide-password/100/show_hide_password-08-512.png";

    }
});

    const oldPasswordInput = $("#oldpassword").val();
    const passwordInput = $("#newpassword").val();
    const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\W).+$/;
    const passwordElement = $("#newpasswordMessage");
    const passwordMatch = passwordInput.match(passwordPattern);

    if(passwordInput === ""){
        passwordElement.html("Password Can Not Be Empty.");
    }
    else if (!passwordMatch) {
        passwordElement.html("Password must contain at least one uppercase letter, one lowercase letter, and one special character.");
    }else if (oldPasswordInput == passwordInput) {
                passwordElement.html("Do Not Use Old Password.");
            } 
     else {
        count++;
        passwordElement.html("");
    }
}

function validateConfirmPassword() {
    const togglePassword3 = document.querySelector('#tp3');
const password3 = document.querySelector('#confirmpassword');
let isPasswordVisible3 = false;

password3.setAttribute('type', 'password');



togglePassword3.addEventListener('click', function () {
    isPasswordVisible3 = !isPasswordVisible3;

    const type3 = isPasswordVisible3 ? 'text' : 'password';
    password3.setAttribute('type', type3);

    // Toggle the eye icon
    if (isPasswordVisible3) {
        togglePassword3.src = "https://clipground.com/images/password-eye-icon-png-2.png";
    } else {
        togglePassword3.src = "https://cdn3.iconfinder.com/data/icons/show-and-hide-password/100/show_hide_password-08-512.png";

    }
});

    const newPasswordInput = $("#newpassword").val();
    const passwordInput = $("#confirmpassword").val();
    const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\W).+$/;
    const passwordElement = $("#confirmpasswordMessage");
    const passwordMatch = passwordInput.match(passwordPattern);
    if(passwordInput === ""){
        passwordElement.html("Password Can Not Be Empty.");
    }
    else if (!passwordMatch) {
        passwordElement.html("Password must contain at least one uppercase letter, one lowercase letter, and one special character.");
    }else if (newPasswordInput !== passwordInput) {
                passwordElement.html("Does Not Match With New Password.");
            }
     else {
        count++;
        passwordElement.html("");
    }
}

    </script>
</body>

</html>
