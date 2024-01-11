<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $email = isset($_POST['Email']) ? $_POST['Email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';


    $skillsArray = isset($_POST['skills']) ? (array)$_POST['skills'] : [];

    $skills = implode(',', $skillsArray);    

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
        $file = $_FILES["image"];
        $fileName = htmlspecialchars($file["name"]);
        $fileTmpName = $file["tmp_name"];
        $fileSize = $file["size"];

        $allowedTypes = ['image/jpeg', 'image/png'];
        if (!in_array($file['type'], $allowedTypes)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Please upload a valid image file.']);
            exit();
        }

        $maxFileSize = 7 * 1024 * 1024; 
        if ($fileSize > $maxFileSize) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'File size exceeds the maximum allowed limit.']);
            exit();
        }

        $imageContent = file_get_contents($fileTmpName);
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'File upload failed. Please select a valid image file.']);
        exit();
    }


 
// if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
//     $file = $_FILES["image"];
//     $fileName = $file["name"];
//     $fileTmpName = $file["tmp_name"];
//     $fileSize = $file["size"];
//     $fileError = $file["error"];
    
//     $imageContent = file_get_contents($fileTmpName);
//     } else {
//         echo "<script>";
//         echo "alert('File upload failed. Please select a valid image file.');";
//         echo "</script>";
//     exit();
//     }
    


    
    $postData = json_encode([
        'firstName' => $firstName,
        'lastName' => $lastName,
        'email' => $email,
        'password' => $password,
        'dob' => $dob,
        'skills' => $skills,
        'gender' => $gender,
        'image' => base64_encode($imageContent)
    ]);

    $api_url = 'http://172.17.13.138:8080/employ_data';
    $ch = curl_init($api_url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_POST           => 1,
        CURLOPT_POSTFIELDS     => $postData,
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $decoded_response = json_decode($response, true);

    if ($decoded_response && isset($decoded_response['success'])) {
        if ($decoded_response['success']) {
            header("Location: home.php");
            exit();
        } else {
            $message = isset($decoded_response['message']) ? $decoded_response['message'] : 'Failed to process the request';
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => $message]);
            exit();
        }
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}
?>
