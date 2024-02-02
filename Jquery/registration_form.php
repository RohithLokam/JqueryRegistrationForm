<?php include 'layout_extra.php'; ?>

<?php include 'api.php'  ?>

<head>

    <title>PeopleConnect</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

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

        .g-recaptcha {
            height: 72px;
            margin-left: 126px;
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

            #tp {
                transform: translateY(-27%);
                transform: translateX(-63%);
                height: 72px;
            }

            .g-recaptcha {
                margin-left: -3px;
            }

            .mag {
                margin-top: 54%;
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

        <h2>Registration Form</h2>
        <form id="registrationForm" action="registration_form_insert.php" method="POST"
            onsubmit="return validateForm(event)" enctype="multipart/form-data">
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
                    <label for="Java" class="form-check-label">Java</label>
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
                <input type="text" id="Email" name="Email" class="form-control" placeholder="Enter Email">
                <div id="email-error-tooltip" class="error-tooltip"></div><br>
                <input type="text" id="officialMail" name="officialMail" class="form-control" placeholder="Enter Email"
                    hidden>
                <input type="text" id="userName" name="userName" class="form-control" placeholder="Enter Email" hidden>

            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="text" id="password" name="password" class="form-control" placeholder="Enter Password">
                <img style="margin-top:-72px; margin-right:-72px;"
                    src="https://clipground.com/images/password-eye-icon-png-2.png" id="tp">
                <div id="pass-error-tooltip" class="error-tooltip"></div><br>

            </div>
            <div class="form-group">
                <label for="image">Profile:</label>
                <input type="file" id="image" name="image" accept="image/*" class="form-control">
                <div id="imag-error-tooltip" class="error-tooltip"></div><br>
            </div>
            <div class="form-group">
                <div class="g-recaptcha" data-sitekey="6Lfk6VopAAAAAFO_JebJV1c8gghblI5fa0vzfL1B"></div>
            </div>
            <button class="btn btn-secondary" type="reset" id="clear" onclick="clearErrors()">Reset</button>
            <button style="  background-color: #df1171;" id="sendButton" type="submit" class="btn btn-primary"
                onclick="handleButtonClick()">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="spinner"></span>
                <span class="button-text">Send</span>
            </button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

<script>
    $('#spinner').hide();

    function handleButtonClick() {
        console.log('Button clicked');
        $('#sendButton').prop('disabled', true);
        $('#spinner').show();
        $('#registrationForm').submit();
        setTimeout(function() {
            $('#sendButton').prop('disabled', false);
            $('#spinner').hide();
        }, 9000);
        console.log('Form submitted');
        return false;
    }
    $(document).ready(() => {
        $("#firstName").on('input', function() {
            var inputValue = $(this).val();
            $(this).val(inputValue.charAt(0).toUpperCase() + inputValue.slice(1));
        });
    });
    $(document).ready(() => {
        $("#lastName").on('input', function() {
            var inputValue = $(this).val();
            $(this).val(inputValue.charAt(0).toUpperCase() + inputValue.slice(1));
        });
    });
    const togglePassword = document.querySelector('#tp');
    const password = document.querySelector('#password');
    let isPasswordVisible = false;
    password.setAttribute('type', 'password');
    togglePassword.addEventListener('click', function() {
        isPasswordVisible = !isPasswordVisible;
        const type = isPasswordVisible ? 'text' : 'password';
        password.setAttribute('type', type);
        if (isPasswordVisible) {
            togglePassword.src = "https://clipground.com/images/password-eye-icon-png-2.png";
        } else {
            togglePassword.src =
                "https://cdn3.iconfinder.com/data/icons/show-and-hide-password/100/show_hide_password-08-512.png";
        }
    });

    function generateEmail() {
        const firstName = document.getElementById('firstName').value;
        const lastName = document.getElementById('lastName').value;
        fetch(`<?php echo $root ?>/user_name_check?firstName=${firstName}&lastName=${lastName}`)
            .then(res => res.json())
            .then(data => {
                console.log(data);
                if (data && Object.keys(data).length > 0) {
                    const email = data['email'];
                    const userName = data['userName'];
                    document.getElementById("officialMail").value = email;
                    document.getElementById("userName").value = userName;
                } else {
                    console.error('No data found for the specified ID.');
                }
            })
            .catch(error => console.error(error));
    }
    let count = 0;

    function validateForm(event) {
        count = 0;
        firstNameValidation();
        lastNameValidation();
        dobValidation();
        skillsValidation();
        emailValidation();
        passwordValidation();
        genderValidation();
        imageValidation();
        console.log(count);
        if (count === 8) {
            return true;
        } else {
            alert("Form validation failed. Please check the errors.");
            event.preventDefault();
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
        $("#password").on("blur", function() {
            passwordValidation();
        });
        $("input[name='skills[]']").on("change", function() {
            skillsValidation();
        });
        $("input[name='gender']").on("change", function() {
            skillsValidation();
        });
        $("#clear").on("click", function() {
            clearErrors();
        });
        $("#image").on("click", function() {
            imageValidation();
        })
    });

    function firstNameValidation() {
        const firstName = $("#firstName").val();
        const namePattern = /^[A-Za-z]+$/;
        const fnameElement = $("#fname-error-tooltip");
        if (firstName === "") {
            fnameElement.text("First name can't be empty", "fname-error-tooltip");
            fnameElement.show();
        } else if (firstName.length < 3 || firstName.length > 60) {
            fnameElement.text("Name should be between 3 and 60 characters");
            fnameElement.show();
        } else if (!firstName.match(namePattern)) {
            fnameElement.text("Please enter only characters");
            fnameElement.show();
        } else {
            count++;
            fnameElement.hide();
        }
        setTimeout(function() {
            $("#fname-error-tooltip").hide();
        }, 2700);
    }

    function lastNameValidation() {
        generateEmail();
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
            lnameElement.hide();
        }
        setTimeout(function() {
            $("#lname-error-tooltip").hide();
        }, 3000);
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
        setTimeout(function() {
            $("#date-error-tooltip").hide();
        }, 3000);
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
        setTimeout(function() {
            $("#skill-error-tooltip").hide();
        }, 3000);
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
        setTimeout(function() {
            $("#email-error-tooltip").hide();
        }, 3000);
    }

    function genderValidation() {
        const selectedGender = $("input[name='gender']:checked");
        genderElement = $("#gender-error-tooltip");
        if (selectedGender.length === 0) {
            genderElement.text("Please select a gender");
            genderElement.show();
        } else {
            count++;
            genderElement.text("");
            genderElement.hide();
        }
        setTimeout(function() {
            $("#gender-error-tooltip").hide();
        }, 3000);
    }

    function passwordValidation() {
        const passwordInput = $("#password").val();
        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\W).+$/;
        const passwordElement = $("#pass-error-tooltip");
        const passwordMatch = passwordInput.match(passwordPattern);
        if (!passwordMatch) {
            passwordElement.text(
                "Password must contain at least one uppercase letter, one lowercase letter, and one special character."
            );
            passwordElement.show();
        } else {
            count++;
            passwordElement.text("");
            passwordElement.show();
        }
        setTimeout(function() {
            $("#pass-error-tooltip").hide();
        }, 3000);
    }

    function imageValidation() {
        // let imageInput = $("#image").val();
        let imageElement = $("#imag-error-tooltip");
        if ($('#image')[0].files.length === 0) {
            imageElement.html("No image selected");
            imageElement.show();
        } else {
            count++;
            imageElement.html("");
            imageElement.show();
        }
        setTimeout(function() {
            $("#imag-error-tooltip").hide();
        }, 3000);
    }

    function showErrorTooltip(message, elementId) {
        $("#" + elementId).text(message);
        $("#" + elementId).show();
    }

    function hideErrorTooltip(elementId) {
        // $("#" + elementId).text("");
        $("#" + elementId).hide();
    }

    function clearErrors() {
        $("#fname-error-tooltip").html("");
        $("#lname-error-tooltip").html("");
        $("#date-error-tooltip").html("");
        $("#skill-error-tooltip").html("");
        $("#email-error-tooltip").html("");
        $("#pass-error-tooltip").html("");
        $("#gender-error-tooltip").html("");
        $("#imag-error-tooltip").html("");
    }
</script>
</body>

</html>