<?php
session_start();
    if (count($_SESSION) == 0) {
    header("Location: index.php");
    exit();
}
?>

<?php
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employId = isset($_POST['employId']) ? $_POST['employId'] : '';
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $email = isset($_POST['Email']) ? $_POST['Email'] : '';
    // $password = isset($_POST['password']) ? $_POST['password'] : '';
    $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';


    $skillsArray = isset($_POST['skills']) ? (array)$_POST['skills'] : [];

    $skills = implode(',', $skillsArray);    

    $imageUrl = isset($_SESSION['image']) ? $_SESSION['image'] : '';

$image = null;

if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
        $file = $_FILES["image"];
        $fileName = htmlspecialchars($file["name"]);
        $fileTmpName = $file["tmp_name"];
        $fileSize = $file["size"];
                $imageContent = file_get_contents($fileTmpName);

$image = base64_encode($imageContent);
} elseif (!empty($imageUrl)) {
$image = $imageUrl;
}
    $postData = json_encode([
        'employId'  => $employId,
        'firstName' => $firstName,
        'lastName' => $lastName,
        'email' => $email,
        // 'password' => $password,
        'dob' => $dob,
        'skills' => $skills,
        'gender' => $gender,
        'image' => $image

    ]);

    $api_url = 'http://172.17.13.138:8080/employ_data';
    $ch = curl_init($api_url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_CUSTOMREQUEST   => 'PUT',
        CURLOPT_POSTFIELDS     => $postData,
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $decoded_response = json_decode($response, true);

    if ($decoded_response && isset($decoded_response['success'])) {

        // $data = json_decode($response, true);
        
        // if (!empty($data) && isset($data['data']) && count($data['data']) > 0) {
        //     $user = $data['data'][0];
    
        //     $_SESSION['firstName']= $user['firstName'];
        //     $_SESSION['lastName']= $user['lastName'];
          
        //     $_SESSION['image']= $user['image'];
          

        // } 

        if ($decoded_response['success']) {
            echo "<script>";
            echo "alert('Data Updated successfully.');";
            echo "</script>";
            header("Location: list.php");
            exit();
        } else {
            $message = isset($decoded_response['message']) ? $decoded_response['message'] : 'Failed to process the request';
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => $message]);
            exit();
        }
    }else {
        $message = isset($decoded_response['message']) ? $decoded_response['message'] : 'Failed to process the request';
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $message]);
        exit();
}
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}
?>
