<?php include 'home.php'; ?>

<?php
session_start();

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

      
           
             echo "<script>";
             echo "alert('Password Updated successfully!');";
             echo "window.location.href='homee.php';";
             echo "</script>";
                exit();
                } else {
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
        .register {
            text-align: center;
            border-style: solid;
            margin-left: 36%;
            margin-right: 36%;
            position: relative;
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 14px 27px 18px 27px;
            margin-top: 9%;
            margin-bottom: 9%;
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

        .button:hover {
            background-color: purple;
            color: white;
            font-size: large;
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
            <p  id="oldpasswordMessage"></p>
            <label>New Password : </label>
            <input type="password" id="newpassword" name="newpassword" placeholder="Enter new password" >
            <p  id="newpasswordMessage"></p>
            <label>Confirm Password : </label>
            <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm new password"  ><br>
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
