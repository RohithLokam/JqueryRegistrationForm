<?php
session_start();
    if (count($_SESSION) == 0) {
    header("Location: index.php");
    exit();
}
?>

<?php include 'home.php'; ?>

<!DOCTYPE html>
<html>
<?php
if (empty($_SESSION['passKey'])) {
    header("Location: index.php");
    exit();
}
?>

<head>
    
    <title>PeopleConnect</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
  

<style>
        
        .register {
    text-align: center;
    border-style: solid;
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 14px 27px 41.4px 27px;
    margin-top: 5.76%;
    max-height: 80vh;
    overflow-y: auto; 
    position: absolute;
    width: 28%; 
    top: 0;
    left: 36%;
    z-index: 0;
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

    </style>
</head>

<body>
    <div class="register">
        <a href="home.php" style="float: left; margin-left: 3%; margin-top:7%;">
            <span class="arrow">&larr;</span>
            Go Back
          </a><br>
        <h2 style="color: rgb(177, 9, 73);"> Registrationn Form </h2>


            <form id="registrationForm" action="registration_form_insert.php" method="POST" onsubmit="return validateForm(event)" enctype="multipart/form-data">

            <br>
            <label>First name : </label>
            <input type="text" id="firstName" name="firstName" placeholder="enter first name" maxlength="66" >
            <p id="fname"></p>
            <label>Last name : </label>
            <input type="text" id="lastName" name="lastName" placeholder="enter last name" maxlength="60" >
            <p id="lname"></p>
            <label>Dob : </label>
            <input type="date" id="dob" name="dob" placeholder="enter date of birth" ><br>
            <p id="date"></p>
            <div class="select">
                <label>Gender :</label><br>
                <input type="radio" id="male" name="gender" value="male" >
                <label for="male">Male</label>
                <input type="radio" id="female" name="gender" value="female" >
                <label for="female">Female</label><br><br>
                <p id="genderError"></p>
                <label>Skills: </label><br>
                <input type="checkbox" id="java" name="skills[]" value="Java" >
                <label for="java">Java</label><br>
                <input type="checkbox" id="SQL" name="skills[]" value="SQL" >
                <label for="SQL">SQL</label><br>
                <input type="checkbox" id="SpringBoot" name="skills[]" value="Spring Boot" >
                <label for="SpringBoot">Spring Boot</label><br>
                <input type="checkbox" id="HTML" name="skills[]" value="HTML" >
                <label for="HTML">HTML</label><br>
                <p id="skill"></p>
            </div><br>
            <label>Email : </label>
            <input type="text" id="Email" name="Email" placeholder="enter email id"  readonly><br>
            <p id="email"></p>
            <label>Password : </label>
            <input type="text" id="password" class="form-control" name="password" placeholder="enter Password" ><br>
            <img src="https://clipground.com/images/password-eye-icon-png-2.png" width="7%" height="9%" style="margin-left: 54%; margin-top:-9.9%; display:inline; vertical-align: middle;" id="tp">
            <p id="pass"></p>
            <label>Profile : </label>
            <input type="file" id="image" name="image" accept="image/*" ><br>
            <p id="imag"></p>
            <button type="reset" id="clear" onclick="clearErrors()">Reset</button>
            <button type="submit" value="Submit">Submit</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        
const togglePassword = document.querySelector('#tp');
const password = document.querySelector('#password');
let isPasswordVisible = false;

password.setAttribute('type', 'password');

togglePassword.addEventListener('click', function () {
    isPasswordVisible = !isPasswordVisible;

    const type = isPasswordVisible ? 'text' : 'password';
    password.setAttribute('type', type);

    if (isPasswordVisible) {
        togglePassword.src = "https://clipground.com/images/password-eye-icon-png-2.png";
    } else {
        togglePassword.src = "https://cdn3.iconfinder.com/data/icons/show-and-hide-password/100/show_hide_password-08-512.png";

    }
});

function generateEmail() {
    const firstName = document.getElementById('firstName').value;
    const lastName = document.getElementById('lastName').value;

    fetch(`http://172.17.13.138:8080/user_name_check/${firstName}/${lastName}`)
        .then(res => res.json())
        .then(data => {
            console.log(data);

            if (data && Object.keys(data).length > 0) {
                const email = data['email'];
                document.getElementById("Email").value = email;
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

} 
        else {

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
        $("#image").on("click",function() {
            imageValidation();
        })
        
    });


            function firstNameValidation() {
        const firstName = $("#firstName").val();
        const namePattern = /^[A-Za-z]+$/;
        const fnameElement = $("#fname");

        if (firstName === "") {
            fnameElement.html("First name can't be empty");
        } else if (firstName.length < 3 || firstName.length > 60) {
            fnameElement.html("Name should be between 3 and 60 characters");
        } else if (!firstName.match(namePattern)) {
            fnameElement.html("Please enter only characters");
        } else {
            count++;
            fnameElement.html("");
        }
    }

   


        function lastNameValidation(){
            generateEmail();

            const lastName=$("#lastName").val();
            const namePattern=/^[A-Za-z]+$/;
            const lnameElement=$("#lname");

            if(lastName===""){
                lnameElement.html("Last name can't be empty");
            }else if (lastName.length<3 || lastName.length>60 ) {
                lnameElement.html("name should be below 60 and above 3 charactesr");
            }
             else if (!lastName.match(namePattern)) {
                lnameElement.html("Please enter only characters");
            } else {
                count++;
                lnameElement.html("");
            }
        }




        function dobValidation() {
    const dobInput = $("#dob").val();
    const today = new Date();
    const dob = new Date(dobInput);
    const dateElement = $("#date");

    if (dobInput === "") {
        dateElement.html("Date of birth is required");
    } else if (dob > today) {
        dateElement.html("Date of birth must be in the past");
    } else {
        count++;
        dateElement.html("");
    }
}

        function skillsValidation() {
    const checkedSkills = $("input[name='skills[]']:checked");
    const skillElement = $("#skill");

    if (checkedSkills.length < 2) {
        skillElement.html("Please select at least 2 skills");
    } else {
        count++;
        skillElement.html("");
    }
}

    
        function emailValidation() {
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            const email = $("#Email").val();
            emailElement=$("#email");

            if (email === "") {
                emailElement.html("Email can't be empty");
            } else if (!email.match(emailPattern)) {
                emailElement.html("Invalid email format");
            } else {
                count++;
                emailElement.html("");
            }
        }

        

        function genderValidation() {
    const selectedGender = $("input[name='gender']:checked");
    genderElement=$("#genderError");

    if (selectedGender.length === 0) {
        genderElement.html("Please select a gender");
    } else {
        count++;
        genderElement.html("");
    }
}


function passwordValidation() {
    const passwordInput = $("#password").val();
    const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\W).+$/;
    const passwordElement = $("#pass");
    const passwordMatch = passwordInput.match(passwordPattern);

    if (!passwordMatch) {
        passwordElement.html("Password must contain at least one uppercase letter, one lowercase letter, and one special character.");
    } else {
        count++;
        passwordElement.html("");
    }
}


    function imageValidation() {
        // let imageInput = $("#image").val();
		let imageElement = $("#imag");


			if ($('#image')[0].files.length === 0) {
				imageElement.html("No image selected");
			} else {
                count++;
				imageElement.html("");
            }

    }



        function clearErrors() {
    $("#fname").html("");
    $("#lname").html("");
    $("#date").html("");
    $("#skill").html("");
    $("#email").html("");
    $("#pass").html("");
    $("#genderError").html("");
    $("#imag").html("");
}

    </script>
</body>

</html>
