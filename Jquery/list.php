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
// session_start();

// if (empty($_SESSION['passKey'])) {
//     header("Location: index.html");
//     exit();
// }

$passKey=$_SESSION['passKey'];

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // $employId = isset($_POST['searching']) ? $_POST['searching'] : '';


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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>PeopleConnect</title>
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

    </style>
</head>

<body onload="getdata()">
    <!-- <a href="home.php" style="float: left; margin-left: 5%; margin-top: 7%;">
        <span class="arrow">&larr;</span>
        Go Back
    </a><br> -->
    <div class="searchbox">
    <!-- <form  action="" method="POST">
    <button class="searching" type="submit" onclick="getdata()"><i class="fa fa-search"></i></button>
    <input type="text" placeholder="Employ Search..."  id="searching" name="searching">
   </form> -->
    </div>
    <br>
    <center>
        <h1 style="margin-top: -9%; margin-left:1%;">Employee Data</h1>

        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th class="unwantedd">DOB</th>
                    <th class="unwantedd">Gender</th>
                    <th >Skills</th>
                    <th class="unwantedd">Email</th>
                    <!-- <th>Edit</th> -->
                </tr>
            </thead>
            <tbody id="tableData">
            </tbody>
        </table>

    </center>
    <script>
        var empdata;

function getdata() {

    const empdata = <?php echo json_encode($empdata); ?>;

    if (empdata && empdata.success && empdata.data) {
        const employDataMap = empdata.data;

        Object.values(employDataMap).forEach(user => {
         
            const markup = `
                <tr onclick="navigateToEditPage(${user.employId})">
 
                    <td>${user.firstName}</td>
                    <td>${user.lastName}</td>
                    <td class="unwantedd">${user.dob}</td>
                    <td class="unwantedd">${user.gender}</td>
                    <td>${user.skills}</td>
                    <td class="unwantedd">${user.email}</td>
                   
                </tr>`;

            document.getElementById('tableData').insertAdjacentHTML('beforeend', markup);
        });
    } else {
        console.error('Invalid or missing data format', empdata);
    }
}

        function navigateToEditPage(employId) {
            window.location.href = `view.php?employId=${employId}`;
        }

        
    </script>
</body>

</html>