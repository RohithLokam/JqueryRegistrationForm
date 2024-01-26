<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }     if (count($_SESSION) == 0) {
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
          /* #userName,
        #firstName,
        #lastName{
            height: 25px;
width: 250px;
border: 2px solid #3498DB;
border-radius: 5px;
padding: 10px;
margin-bottom: 15px;
outline: none;
margin-left: 10px;
        } */
        .register {
            text-align: center;
            border-style: solid;
            margin-left: 36%;
            margin-right: 36%;
            position: relative;
            border-radius: 5px;
            /* background-color: #f2f2f2; */
            background-color: white;
            padding: 20px 27px 30px 27px;
            margin-top:0%;
            margin-bottom:9%;
            z-index: 1089;
            position: fixed;
            width:27%;
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
@media only screen and (max-width: 550px) and (min-width: 270px) {
            .register {
            text-align: center;
            border-style: solid;
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
            margin-top: 27%;
            max-height: 80vh;
            overflow-y: auto;
            position: absolute;
            width: 72%;
            top: 0;
            left: -18%;
            z-index: 0;
        }
        .lastname{
            margin-right:45px;
        }
        .last{
            margin-left:36px;
        }
    }

    </style>

</head>

<body>
    <div class="register">

          <a href="list.php" style="float: left; margin-left: 3%;">
            <span class="arrow">&larr;</span>
            Go Back
          </a>
          <br><br>
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
            <b><label id="userName">User name : </label></b>
            <label>First name : </label>
            <b><label id="firstName">First name : </label></b><br>
            <label class="last">Last name : </label>
            <b><label class="lastname" id="lastName">Last name : </label></b>
            <label>Dob : </label>
            <b><label id="dob">Dob : </label></b><br>
                <label>Gender :</label>
                <b><label id="gender">Gender :</label></b><br>
                <label>Skills: </label>
                <b><label id="skills">Skills: </label></b><br>
            <label>Email</label>
            <b><label id="Email">Email</label></b>
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


      $("#userName").text(userName);
$("#firstName").text(firstName);
$("#lastName").text(lastName);
$("#Email").text(email);
$("#dob").text(dob);
$("#gender").text(gender);
$("#skills").text(skills);



// const genderElement = $('input[name="gender"][value="' + gender + '"]');
// if (genderElement.length) {
//     genderElement.prop("checked", true);
// }

// const desiredValuesArray = skills.split(",");
// for (const desiredValue of desiredValuesArray) {
//     const checkbox = $('input[name="skills"][value="' + desiredValue + '"]');
//     if (checkbox.length) {
//         checkbox.prop("checked", true);
//     }
// }

    </script>

</body>



