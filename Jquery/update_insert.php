<?php
session_start();

if (count($_SESSION) == 0) {
    header("Location: index.php");
    exit();
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employId = isset($_POST['employId']) ? $_POST['employId'] : '';
    $userName = isset($_POST['userName']) ? $_POST['userName'] : '';
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $email = isset($_POST['Email']) ? $_POST['Email'] : '';
    $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';

    $skillsArray = isset($_POST['skills']) ? (array)$_POST['skills'] : [];
    $skills = implode(',', $skillsArray);

    $image = null;
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
        $file = $_FILES["image"];
        $fileName = htmlspecialchars($file["name"]);
        $fileTmpName = $file["tmp_name"];
        $fileSize = $file["size"];
        $image = new CURLFile($fileTmpName, $file['type'], $file['name']);
    } elseif (!empty($_SESSION['image'])) {
    
        $imageData = base64_decode($_SESSION['image']);
        $tempFileName = tempnam(sys_get_temp_dir(), 'image');
        file_put_contents($tempFileName, $imageData);
        $image = new CURLFile($tempFileName, 'image/png', 'image.png');
    }
    

    $postData = [
        'employId'  => $employId,
        'userName'  => $userName,
        'firstName' => $firstName,
        'lastName'  => $lastName,
        'email'     => $email,
        'dob'       => $dob,
        'skills'    => $skills,
        'gender'    => $gender,
        'file'      => $image,
    ];

    $api_url = 'http://172.17.13.138:8080/employ_data';
    $ch = curl_init($api_url);

    // $headers = array(
    //     'Content-Type: application/json',
    //     'Authorization: ' . $_SESSION['token']
    // );
    $headers = array(
        'Authorization: ' . $_SESSION['token']
    );
   
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST  => 'PUT',
        CURLOPT_POSTFIELDS     => $postData,
        CURLOPT_SAFE_UPLOAD    => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTPHEADER     => $headers 
    ]);

    $response = curl_exec($ch);

    curl_close($ch);

    $decoded_response = json_decode($response, true);

    if ($decoded_response && isset($decoded_response['success']) && $decoded_response['success']) {
        header("Location: home.php?update_success=true");
        exit();
    } else {
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