<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  } if (count($_SESSION) == 0) {
    header("Location: index.php");
    exit();
}
?>


<?php include 'layout.php'; ?>

<?php


$passKey=$_SESSION['passKey'];



$url = "http://172.17.13.138:8080/employ_data/$passKey";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HTTPGET, true); 
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(['success' => false, 'message' => 'Curl error: ' . curl_error($ch)]);
} else {
    $empdata = json_decode($response, true);

    if (isset($empdata['success']) && $empdata['success']) {

        echo '<script>';
echo 'var empdata = ' . json_encode(json_decode($response, true)) . ';';
echo '</script>';

    } else {
        echo json_encode(['success' => false, 'message' => $empdata['message'] ?? 'Failed to process the request']);
    }
}

curl_close($ch);

// } else {
//     http_response_code(405);
//     echo json_encode(['success' => false, 'message' => 'Invalid request method']);
//     exit();
// }
?>


<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>PeopleConnect - Employee List</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: separate;
            width: 100%;
            border-spacing: 0 27px;
            margin-bottom: 5%;
        }

        th {
            background-color: #4287f5;
            color: white;
            font-size: 18px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        td {
            border: 1px solid white;
            text-align: left;
            padding: 8px;
        }

        tr {
            border: 3px solid gray;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .searching {
  float: right;
  width: 5%;
  padding: 10px;
  background: #2196F3;
  color: white;
  font-size: 17px;
  border: 1px solid grey;
  border-left: none;
  cursor: pointer;
  margin-right: 5%;
}
 input[type=text] {
  padding: 10px;
  font-size: 17px;
  border: 1px solid grey;
  float: right;
  width: 14%;
  background: #f1f1f1;
}
.searchbox{
    margin-top:9%;
}
@media only screen and (max-width: 550px) and (min-width: 270px) {
        .unwantedd{
            display:none;
        }
    }
  
        .register {
            
            border-radius: 5px; 
            text-align: center;
            padding: 20px 27px 30px 27px;
            background-color: white;
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
            /* .register {
            text-align: center;
            border-style: solid;
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
            margin-top: -21.6%;
            margin-left: 14%;
            max-height: 80vh;
            overflow-y: auto;
            position: absolute;
            width: 72%;
            top: 0;
            left: 3%;
            z-index: 0;
        } */
        .register {
            
            border-radius: 5px; 
            text-align: center;
            padding: 20px 27px 30px 27px;
            background-color: white;
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

<!-- <body onload="getData()"> -->
<body>
    <div class="container" style="max-width: 100vw;">
        <h1 class="mt-5 mb-3 text-center">Employee Data</h1>
        <table style="width:100%;" class="table table-striped">
            <thead>
                <tr>
                <th>First Name</th>
                    <th>Last Name</th>
                    <th class="unwantedd">DOB</th>
                    <th class="unwantedd">Gender</th>
                    <th >Skills</th>
                    <th class="unwantedd">Email</th>
                </tr>
            </thead>
            <tbody id="tableData">
              
            </tbody>
        </table>
    </div>
  

    <div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="employeeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <!-- <div class="modal-content"> -->
                <!-- <div class="modal-header">
                    <h5 class="modal-title" id="employeeModalLabel">Employee Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> -->
                <div class="modal-body" id="modalBody">
                    <!-- Employee details will be displayed here -->
                </div>
            <!-- </div> -->
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



    <script>

    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('#tableData tr');
        rows.forEach(row => {
            row.addEventListener('click', function() {
                const firstName = this.cells[0].innerText;
                const lastName = this.cells[1].innerText;
                const dob = this.cells[2].innerText;
                const gender = this.cells[3].innerText;
                const skills = this.cells[4].innerText;
                const email = this.cells[5].innerText;
                const userName = this.cells[6].innerText;
                const image= this.cells[7].innerText;


                displayEmployeeDetails(firstName, lastName, dob, gender, skills, email, userName, image);

            });
        });
    });

    function displayEmployeeDetails(firstName, lastName, dob, gender, skills, email, userName, imageUrl) {
        console.log(imageUrl);
        const modalBody = document.getElementById("modalBody");
            modalBody.innerHTML = `
    

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
  <b><label id="userName">${userName} </label></b>
  <label>First name : </label>
  <b><label id="firstName">${firstName} </label></b><br>
  <label class="last">Last name : </label>
  <b><label class="lastname" id="lastName">${lastName} </label></b>
  <label>Dob : </label>
  <b><label id="dob">${dob}</label></b><br>
      <label>Gender :</label>
      <b><label id="gender">${gender}</label></b><br>
      <label>Skills: </label>
      <b><label id="skills">${skills}</label></b><br>
  <label>Email</label>
  <b><label id="Email">${email}</label></b>
</form>
</div>
            `;    }
</script>


<script>
        var empdata;

// function getdata() {


    if (empdata && empdata.success && empdata.data) {
        const employDataMap = empdata.data;

        Object.values(employDataMap).forEach(user => {
         
            const markup = `
            <tr data-toggle='modal' data-target='#employeeModal'> 

                    <td>${user.firstName}</td>
                    <td>${user.lastName}</td>
                    <td class="unwantedd">${user.dob}</td>
                    <td class="unwantedd">${user.gender}</td>
                    <td>${user.skills}</td>
                    <td class="unwantedd">${user.email}</td>
                    <td hidden class="unwantedd">${user.userName}</td>
                    <td hidden class="unwantedd">${user.image}</td>

                   
                </tr>`;

            document.getElementById('tableData').insertAdjacentHTML('beforeend', markup);
        });
    } else {
        console.error('Invalid or missing data format', empdata);
    }
// }
     
    </script>
</body>

</html>
