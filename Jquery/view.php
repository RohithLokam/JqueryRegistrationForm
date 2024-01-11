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

        $userName= $user['userName'];
        $firstName= $user['firstName'];
        $lastName= $user['lastName'];
        $dob= $user['dob'];
        $email= $user['email'];
        $dob= $user['dob'];
        $skills= $user['skills'];
        $gender= $user['gender'];
        $imageURL= $user['image'];



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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <style>
        .register {
            text-align: center;
            border-style: solid;
            margin-left: 36%;
            margin-right: 36%;
            position: relative;
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px 27px 30px 27px;
            margin-top:9%;
            margin-bottom:9%;
            z-index: 0;
            position: fixed;
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

          <a href="list.php" style="float: left; margin-left: 3%;">
            <span class="arrow">&larr;</span>
            Go Back
          </a>
          <br>
        <h2 style="color: blue;">Employ Details </h2>
        <form>
        <?php
if (!empty($imageURL)) {

    $imageData = base64_decode($imageURL);
    $imageType = "data:image/png;base64,";
    echo '<img style="max-width:20%; height: 10%;" id="profile-image" src="' . $imageType . base64_encode($imageData) . '" alt="Profile Image">';
    } else {
        echo '<img style="max-width:20%; height: 10%;" id="profile-image" src="unknown.jpg" alt="Profile Image">';

    }

?>


            <br><br>
            <label>User name : </label>
            <input type="text" id="userName" name="userName" placeholder="your user name" maxlength="60" readonly><br><br>
            <label>First name : </label>
            <input type="text" id="firstName" name="firstName" placeholder="your first name" maxlength="60" readonly><br><br>
            <label>Last name : </label>
            <input type="text" id="lastName" name="lastName" placeholder="your last name" maxlength="60" readonly><br><br>
            <label>Dob : </label>
            <input type="date" id="dob" name="dob" placeholder="enter date of birth" required readonly><br>
            <div class="select">
                <label>Gender :</label><br>
                <input type="radio" id="male" name="gender" value="male" disabled>
                <label for="male">Male</label>
                <input type="radio" id="female" name="gender" value="female" disabled>
                <label for="female">Female</label><br><br>
                <label>Skills: </label><br>
                <input type="checkbox" id="Java" name="skills" value="Java" disabled>
                <label for="java">Java</label><br>
                <input type="checkbox" id="SQL" name="skills" value="SQL" disabled>
                <label for="SQL">SQL</label><br>
                <input type="checkbox" id="SpringBoot" name="skills" value="SpringBoot" disabled>
                <label for="SpringBoot">Spring Boot</label><br>
                <input type="checkbox" id="HTML" name="skills" value="HTML" disabled>
                <label for="HTML">HTML</label><br>
            </div><br>
            <label>Email</label>
            <input type="text" id="Email" name="Email" placeholder="enter email id" readonly><br>
        </form>
    </div>

    <script>


    const userName = <?= json_encode($userName); ?>;
    const dob = <?= json_encode($dob); ?>;
    const firstName = <?= json_encode($firstName); ?>;
    const lastName = <?= json_encode($lastName); ?>;
    const email = <?= json_encode($email); ?>;
    const skills =<?= json_encode($skills); ?>;
    const gender = <?= json_encode($gender); ?>;


      console.log('User Name:', userName);
      console.log('First Name:', firstName);
      console.log('Last Name:', lastName);
      console.log('Email:', email);
      console.log('Skills:', skills);
      console.log('Gender:', gender);


      $("#userName").val(userName);
$("#firstName").val(firstName);
$("#lastName").val(lastName);
$("#Email").val(email);
$("#dob").val(dob);

const genderElement = $('input[name="gender"][value="' + gender + '"]');
if (genderElement.length) {
    genderElement.prop("checked", true);
}

const desiredValuesArray = skills.split(",");
for (const desiredValue of desiredValuesArray) {
    const checkbox = $('input[name="skills"][value="' + desiredValue + '"]');
    if (checkbox.length) {
        checkbox.prop("checked", true);
    }
}

    </script>

</body>



