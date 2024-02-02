<?php
session_start();
    if (count($_SESSION) == 0) {
    header("Location: index.php");
    exit();
}
?>

<?php include 'home.php'; ?>

<?php include 'api.php'  ?>

<?php
if (isset($_GET['employId'])) {
    $empId = $_GET['employId'];


    $url = "$root/employ_data_list?employId=$empId";

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

    <style>
        .register {
            text-align: center;
            border-style: solid;
            margin-left: 36%;
            margin-right: 36%;
            position: relative;
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px 27px 18px 27px;
            margin-top: 0%;
            margin-bottom: 5%;
            z-index: 0;
            position: fixed;
            width: 27%;
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

        .profile-container {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            padding: 12px 16px;
            display: block;
            text-decoration: none;
            color: #333;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .show {
            display: block;
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
        }
    </style>

</head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<body>
    <div class="register">
        <a style="float:left;" href="update.php?employId=<?php echo $empId; ?>">
            <i class="fa fa-edit" style="font-size:36px"></i>
            Edit
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
        const userName = <?= json_encode($userName); ?> ;
        const dob = <?= json_encode($dob); ?> ;
        const firstName = <?= json_encode($firstName); ?> ;
        const lastName = <?= json_encode($lastName); ?> ;
        const email = <?= json_encode($email); ?> ;
        const skills = <?= json_encode($skills); ?> ;
        const gender = <?= json_encode($gender); ?> ;
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
    </script>
</body>

<?php

if (!isset($_SESSION['firstName']) || !isset($_SESSION['lastName']) || !isset($_SESSION['image'])) {
  exit();
}

$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$image = $_SESSION['image'];
?>