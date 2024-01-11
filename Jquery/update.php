<?php include 'home.php'; ?>

<?php
if (isset($_GET['employId'])) {
    $empId = $_GET['employId'];

    $url = "http://172.17.13.138:8080/employ_data_list?employId=$empId";

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

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
            margin-left: 36%;
            margin-right: 36%;
            position: relative;
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 14px 27px 18px 27px;
            margin-top: 5.76% ;
            margin-bottom:9%;
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
.button {
  background-color: #df1171;
  color: white;
  padding: 10px 15px;
  /* margin: 0; */
  border: none;
  cursor: pointer;
  border-radius: 4px;  
}

.button:hover {
  opacity: 0.8;
}
.resett:hover{
    opacity: 0.8;
    background-color: #df1171;
  color: white;
  padding: 10px 15px;
  /* margin: 0; */
  border: none;
  cursor: pointer;
  border-radius: 4px; 

}
    </style>
</head>

<body>
    <div class="register">
        <a href="home.php" style="float: left; margin-left: 3%;">
            <span class="arrow">&larr;</span>
            Go Back
          </a><br>
        <h2 style="color: rgb(177, 9, 73);"> Employ Details Update </h2>
        <form id="registrationForm" action="update_insert.php" method="POST" onsubmit="return validateForm(event)"   enctype="multipart/form-data">
            <label>Employ Id : </label>
            <input type="text" id="employId" name="employId" placeholder="enter employ id" readonly style="background-color: black;"><br><br>
            <label>First name : </label>
            <input type="text" id="firstName" name="firstName" placeholder="enter first name" maxlength="66">
            <p id="fname"></p>
            <label>Last name : </label>
            <input type="text" id="lastName" name="lastName" placeholder="enter last name" maxlength="60">
            <p id="lname"></p>
            <label>Dob : </label>
            <input type="date" id="dob" name="dob" placeholder="enter date of birth" ><br>
            <p id="date"></p>
            <div class="select">
                <label>Gender :</label><br>
                <input type="radio" id="male" name="gender" value="male">
                <label for="male">Male</label>
                <input type="radio" id="female" name="gender" value="female" >
                <label for="female">Female</label><br><br>
                <p id="genderError"></p>
                <label>Skills: </label><br>
                <input type="checkbox" id="Java" name="skills[]" value="Java" >
                <label for="java">Java</label><br>
                <input type="checkbox" id="SQL" name="skills[]" value="SQL" >
                <label for="SQL">SQL</label><br>
                <input type="checkbox" id="SpringBoot" name="skills[]" value="Spring Boot">
                <label for="SpringBoot">Spring Boot</label><br>
                <input type="checkbox" id="HTML" name="skills[]" value="HTML">
                <label for="HTML">HTML</label><br>
                <p id="skill"></p>
            </div><br>
            <label>Email</label>
            <input type="text" id="Email" name="Email" placeholder="enter email id"  ><br>
            <p id="email"></p>
            <!-- <label>Password : </label> -->
            <!-- <input type="text" id="password" placeholder="enter password" minlength="8" maxlength="16" style="background-color: black;"><br> -->
            <!-- <p id="pass"></p> -->
            <label style="margin-left:54px;">Profile : </label>
            <input type="file" id="image" name="image" accept="image/*" ><br><br>
            <input class="button" type="submit" value="Update">
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <script>

const employId = <?= json_encode($employId); ?>;
    const dob = <?= json_encode($dob); ?>;
    const firstName = <?= json_encode($firstName); ?>;
    const lastName = <?= json_encode($lastName); ?>;
    const email = <?= json_encode($email); ?>;
    const skills =<?= json_encode($skills); ?>;
    const gender = <?= json_encode($gender); ?>;

    $("#firstName").val(firstName);
$("#lastName").val(lastName);
$("#Email").val(email);
$("#dob").val(dob);
$("#employId").val(employId);

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

} 
        else {
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





    </script>
</body>

</html>
