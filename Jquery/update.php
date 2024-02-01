<?php
session_start();
    if (count($_SESSION) == 0) {
    header("Location: index.php");
    exit();
}
?>
<?php include 'home.php'; ?>
<?php
if (isset($_GET['employId'])) {
    $empId = $_GET['employId'];

    $url = "http://172.17.13.138:8080/employ_data_list?employId=$empId";

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPGET, true); 
    
    $headers = array(
        'Content-Type: application/json',
        'Authorization: ' . $_SESSION['token'] 
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "Error: " . curl_error($ch);
        return;
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if (!empty($data) && isset($data['data']) && count($data['data']) > 0) {
        $user = $data['data'][0];

        $employId=$user['employId'];
        $firstName= $user['firstName'];
        $lastName= $user['lastName'];
        $dob= $user['dob'];
        $email= $user['email'];
        $dob= $user['dob'];
        $skills= $user['skills'];
        $gender= $user['gender'];
        $userName= $user['userName'];

    } else {
        echo "No data found for the specified ID.";
    }
} else {
    echo "employId is not set.";
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
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 7px;
            margin-top: 7%;
            max-height: 80vh;
            overflow-y: auto;
            position: absolute;
            width: 33.3%;
            top: 0;
            left: 31.5%;
            z-index: 0;
        }

        .btn-primary:hover {
            opacity: 0.8;
        }

        .form-check-inline {
            display: flex;
            align-items: center;
            margin-right: 5px;
            margin-bottom: 8px;
            margin-left: 25%;
        }

        .form-check-inline label {
            order: -1;
            margin-right: 36px;
        }

        h2 {
            color: rgb(177, 9, 73);
        }

        label {
            display: inline-block;
            width: 30%;
            text-align: right;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="date"],
        input[type="password"],
        input[type="file"] {
            width: 50%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
            display: inline-block;
        }

        input[type="checkbox"],
        input[type="radio"] {
            margin-right: 8px;
        }

        .select {
            margin-top: -18px;
            border-color: white;
            margin-left: 14%;
            margin-right: 15%;
        }

        .form-group {
            margin-bottom: 0;
        }

        .btn-group {
            margin-top: 20px;
        }

        img#tp {
            margin-left: 54%;
            margin-top: -6.3%;
            display: inline;
            vertical-align: middle;
            width: 7%;
            height: 9%;
        }

        p {
            color: red;
            margin-bottom: 10px;
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

        .btn-secondary {
            margin-right: 5px;
            border-radius: 7px;
        }

        @media only screen and (max-width: 550px) and (min-width: 270px) {
            .register {
                text-align: center;
                border-style: solid;
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 5px;
                margin-top: 27%;
                max-height: 80vh;
                overflow-y: auto;
                position: absolute;
                width: 81%;
                top: 0;
                left: 14%;
                z-index: 0;
            }
        }

        button {
            background-color: #df1171;
            margin-top: 9px;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            width: 27%;

        }
    </style>
</head>

<body>
    <div class="register container">
        <h2>Profile</h2>
        <form id="registrationForm" action="update_insert.php" method="POST" onsubmit="return validateForm(event)"
            enctype="multipart/form-data">
            <div class="form-group">
                <label for="employId">Employ Id:</label>
                <input type="text" id="employId" name="employId" class="form-control" placeholder="Enter employId Name"
                    maxlength="66" readonly>
                <div id="empid-error-tooltip" class="error-tooltip"></div><br>

            </div>
            <div class="form-group">
                <label for="userName">User Name:</label>
                <input type="text" id="userName" name="userName" class="form-control" placeholder="Enter userName Name"
                    maxlength="66" readonly>
                <div id="uname-error-tooltip" class="error-tooltip"></div><br>

            </div>
            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" class="form-control" placeholder="Enter First Name"
                    maxlength="66">
                <div id="fname-error-tooltip" class="error-tooltip"></div><br>

            </div>
            <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" class="form-control" placeholder="Enter Last Name"
                    maxlength="60">
                <div id="lname-error-tooltip" class="error-tooltip"></div><br>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" class="form-control" placeholder="Enter Date of Birth">
                <div id="date-error-tooltip" class="error-tooltip"></div><br>

            </div>
            <div class="form-group select">
                <label>Gender:</label><br>
                <div class="form-check form-check-inline">
                    <input type="radio" id="male" name="gender" value="male" class="form-check-input">
                    <label for="male" class="form-check-label">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" id="female" name="gender" value="female" class="form-check-input">
                    <label for="female" class="form-check-label">Female</label>
                </div>
                <div id="gender-error-tooltip" class="error-tooltip"></div><br>

            </div>
            <div class="form-group select">
                <label>Skills:</label><br>
                <div class="form-check form-check-inline">
                    <input type="checkbox" id="Java" name="skills[]" value="Java" class="form-check-input">
                    <label for="java" class="form-check-label">Java</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="checkbox" id="SQL" name="skills[]" value="SQL" class="form-check-input">
                    <label for="SQL" class="form-check-label">SQL</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="checkbox" id="SpringBoot" name="skills[]" value="SpringBoot" class="form-check-input">
                    <label for="SpringBoot" class="form-check-label">Spring Boot</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="checkbox" id="HTML" name="skills[]" value="HTML" class="form-check-input">
                    <label for="HTML" class="form-check-label">HTML</label>
                </div>
                <div id="skill-error-tooltip" class="error-tooltip"></div><br>
            </div>
            <div class="form-group">
                <label for="Email">Email:</label>
                <input type="text" id="Email" name="Email" class="form-control" placeholder="Enter Email" readonly>
                <div id="email-error-tooltip" class="error-tooltip"></div><br>
                <!-- <input type="text" id="userName" name="userName" class="form-control" placeholder="Enter Email" hidden> -->

            </div>

            <div class="form-group">
                <label for="image">Profile:</label>
                <input type="file" id="image" name="image" accept="image/*" class="form-control">
                <div id="imag-error-tooltip" class="error-tooltip"></div><br>

            </div>
            <button style="  background-color: #df1171;" id="sendButton" type="submit" class="btn btn-primary"
                onclick="return handleButtonClick()">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="spinner"></span>
                <span class="button-text">Update</span>
            </button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        $('#spinner').hide();

        function handleButtonClick() {
            console.log('Button clicked');
            $('#sendButton').prop('disabled', true);
            $('#spinner').show();
            setTimeout(function() {
                $('#sendButton').prop('disabled', false);
                $('#spinner').hide();
                $('#registrationForm').submit();
            }, 3000);
            console.log('Form submitted');
            return true;
        }
        const employId = <?= json_encode($employId); ?> ;
        const dob = <?= json_encode($dob); ?> ;
        const userName = <?= json_encode($userName); ?> ;
        const firstName = <?= json_encode($firstName); ?> ;
        const lastName = <?= json_encode($lastName); ?> ;
        const email = <?= json_encode($email); ?> ;
        const skills = <?= json_encode($skills); ?> ;
        const gender = <?= json_encode($gender); ?> ;
        $("#firstName").val(firstName);
        $("#lastName").val(lastName);
        $("#Email").val(email);
        $("#dob").val(dob);
        $("#employId").val(employId);
        $("#userName").val(userName);
        const genderElement = $("#" + gender);
        if (genderElement.length) {
            genderElement.prop("checked", true);
        }
        const desiredValuesArray = skills.split(",");
        for (const desiredValue of desiredValuesArray) {
            const checkbox = $("#" + desiredValue);
            if (checkbox.length) {
                checkbox.prop("checked", true);
            }
        }
        let count = 0;

        function validateForm(event) {
            count = 0;
            firstNameValidation();
            lastNameValidation();
            dobValidation();
            skillsValidation();
            emailValidation();
            genderValidation();
            console.log(count);
            if (count === 6) {
                return true;
            } else {
                alert("Form validation failed. Please check the errors.");
                return false;
            }
        }
        $(document).ready(function() {
            $("#firstName").on("blur", function() {
                firstNameValidation();
            });
            $("#lastName").on("blur", function() {
                lastNameValidation();
            });
            $("#dob").on("blur", function() {
                dobValidation();
            });
            $("#Email").on("blur", function() {
                emailValidation();
            });
            $("input[name='skills[]']").on("change", function() {
                skillsValidation();
            });
            $("input[name='gender']").on("change", function() {
                skillsValidation();
            });
        });

        function firstNameValidation() {
            const firstName = $("#firstName").val();
            const namePattern = /^[A-Za-z]+$/;
            const fnameElement = $("#fname-error-tooltip");
            if (firstName === "") {
                fnameElement.text("First name can't be empty");
                fnameElement.show();
            } else if (firstName.length < 3 || firstName.length > 60) {
                fnameElement.text("Name should be between 3 and 60 characters");
                fnameElement.show();
            } else if (!firstName.match(namePattern)) {
                fnameElement.text("Please enter only characters");
                fnameElement.show();
            } else {
                count++;
                fnameElement.text("");
                fnameElement.hide();
            }
        }

        function lastNameValidation() {
            const lastName = $("#lastName").val();
            const namePattern = /^[A-Za-z]+$/;
            const lnameElement = $("#lname-error-tooltip");
            if (lastName === "") {
                lnameElement.text("Last name can't be empty");
                lnameElement.show();
            } else if (lastName.length < 3 || lastName.length > 60) {
                lnameElement.text("name should be below 60 and above 3 charactesr");
                lnameElement.show();
            } else if (!lastName.match(namePattern)) {
                lnameElement.text("Please enter only characters");
                lnameElement.show();
            } else {
                count++;
                lnameElement.text("");
                lnameElement.hide();
            }
        }

        function dobValidation() {
            const dobInput = $("#dob").val();
            const today = new Date();
            const dob = new Date(dobInput);
            const dateElement = $("#date-error-tooltip");
            if (dobInput === "") {
                dateElement.text("Date of birth is required");
                dateElement.show();
            } else if (dob > today) {
                dateElement.text("Date of birth must be in the past");
                dateElement.show();
            } else {
                count++;
                dateElement.text("");
                dateElement.hide();
            }
        }

        function skillsValidation() {
            const checkedSkills = $("input[name='skills[]']:checked");
            const skillElement = $("#skill-error-tooltip");
            if (checkedSkills.length < 2) {
                skillElement.text("Please select at least 2 skills");
                skillElement.show();
            } else {
                count++;
                skillElement.text("");
                skillElement.hide();
            }
        }

        function emailValidation() {
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            const email = $("#Email").val();
            emailElement = $("#email-error-tooltip");
            if (email === "") {
                emailElement.text("Email can't be empty");
                emailElement.show();
            } else if (!email.match(emailPattern)) {
                emailElement.text("Invalid email format");
                emailElement.show();
            } else {
                count++;
                emailElement.text("");
                emailElement.hide();
            }
        }

        function genderValidation() {
            const selectedGender = $("input[name='gender']:checked");
            let genderElement = $("#gender-error-tooltip");
            if (selectedGender.length === 0) {
                genderElement.text("Please select a gender");
                genderElement.show();
            } else {
                count++;
                genderElement.text("");
                genderElement.hide();
            }
        }
    </script>
</body>

</html>