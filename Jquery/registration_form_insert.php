<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['g-recaptcha-response'] != "") {

    $secret = '6Lfk6VopAAAAAGdCDEaWGAP5KyKPYdwupDUg61I6';
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);
    if ($responseData->success) {
        





    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $userName = isset($_POST['userName']) ? $_POST['userName'] : '';
    $email = isset($_POST['Email']) ? $_POST['Email'] : '';
    $officialMail = isset($_POST['officialMail']) ? $_POST['officialMail'] : '';
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
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'File upload failed. Please select a valid image file.']);
        exit();
    }

    $api_url = 'http://172.17.13.138:8080/employ_data';
    $ch = curl_init($api_url);

    $postData = [
        'firstName' => $firstName,
        'lastName' => $lastName,
        'email' => $email,
        'officialMail' => $officialMail,
        'userName' => $userName,
        'password' => $password,
        'dob' => $dob,
        'skills' => $skills,
        'gender' => $gender,
        'file' => new CURLFile($fileTmpName, $file['type'], $file['name'])

    ];

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => ['Content-Type: multipart/form-data'],
        CURLOPT_POST           => 1,
        CURLOPT_POSTFIELDS     => $postData,
        CURLOPT_SAFE_UPLOAD    => true,  
        CURLOPT_FOLLOWLOCATION => true, 
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $decoded_response = json_decode($response, true);

    if ($decoded_response && isset($decoded_response['success'])) {
        if ($decoded_response['success']) {
            header("Location: index.php?register_success=true");
            exit();
        } else {
            $message = isset($decoded_response['message']) ? $decoded_response['message'] : 'Failed to process the request';
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => $message]);
            exit();
        }
    }
}else{
    echo json_encode(['success' => false, 'message' => 'Captcha Not Entered']);
    exit();
}
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}
?>
