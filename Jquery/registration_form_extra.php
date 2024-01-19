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


<!DOCTYPE html>
<html>


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


            <form id="registrationForm" action="registration_form_insert_extra.php" method="POST" onsubmit="return validateForm(event)" enctype="multipart/form-data">

            <br>
            <label>First name : </label>
            <input type="text" id="firstName" name="firstName" placeholder="enter first name" maxlength="66" >
            <p id="fname"></p>
           
            <label>Profile : </label>
            <input type="file" id="image" name="image" accept="image/*" ><br>
            <p id="imag"></p>
            <button type="reset" id="clear" onclick="clearErrors()">Reset</button>
            <button type="submit" value="Submit">Submit</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>



        let count = 0;

        function validateForm(event) {
            count = 0; 

            firstNameValidation();
           
            imageValidation();

            console.log(count);
            if (count === 2) {
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

    $("#imag").html("");
}

    </script>
</body>

</html>
