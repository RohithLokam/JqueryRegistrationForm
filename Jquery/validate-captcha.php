<?php

if (isset($_POST['submit']) && $_POST['g-recaptcha-response'] != "") {
    $secret = '6LfVCVopAAAAALdco0TeWpAcwnqP-uRU3pEMXaMN';
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);
    if ($responseData->success) {
        echo "Your registration has been successfully done!";
    }
}