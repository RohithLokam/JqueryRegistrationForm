<?php
// session_start();
// $otpp=$_SESSION['otp'];
// echo "  $otpp  ";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp = $_POST["input1"] . $_POST["input2"] . $_POST["input3"] . $_POST["input4"]; 


    $api_url = "http://172.17.13.138:8080/otp_verification";

    $data = array("otp" => $otp );
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ),
    );

    $context = stream_context_create($options);
    $result = file_get_contents($api_url, false, $context);

    if ($result === FALSE) {
        echo "<script>";
        echo "alert('Unable to connect to the server.');";
        echo "</script>"; 
    } else {
        $response = json_decode($result, true);

        if ($response && isset($response['success']) && $response['success']) {

            // $data = json_decode($result, true);


        

      
           
             echo "<script>";
             echo "alert(' OTP Verified successfully!');";
             echo "window.location.href='new_password.php';";
             echo "</script>";
                exit();
                } else {
                    echo "<script>";
                    echo "alert('Invalid otp');";
                    echo "window.location.history();";
                    echo "</script>";   
                     }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PeopleConnect</title>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700&display=swap");


    .background-image {
      width: 50%;
      height: 100%;
      background: url('https://hubble.miraclesoft.com/assets/img/bg-login.jpg') center/cover no-repeat;
    }

   

    svg {
      margin: 16px 0;
    }
   
    #image-container {
  flex: 1;
  overflow: hidden;
  height: 100vh;
    display: flex;
  align-items: center; 
 
}

    #content-container {
      position: absolute;
      bottom: 0;
      left: 0;
      padding: 20px;
      color: #fff;
    }
    

    #background-image {
      height:100%;
      object-fit: cover;
    }


  body {
    margin: 0;
    padding: 0;
    display: flex;
    height: 100vh;
    justify-content: center;
    align-items: center;
    background-color: #f4f4f4; /* Background color for the body */
  }

  .box {
    width: 300px;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    text-align: center;
    margin-left: 9%;
    margin-right: 9%;
  }

  .title {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 10px;
  }

  p {
    color: #555;
    font-size: 14px;
    margin-bottom: 20px;
  }

  #inputs {
    display: flex;
    justify-content: space-around;
    margin-bottom: 20px;
  }

  input {
    width: 50px;
    height: 50px;
    text-align: center;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 18px;
    margin: 0 5px;
    outline: none;
  }

  input:focus {
    border-color: #3598dc;
  }

  button {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 4px;
    background-color: #3598dc;
    color: #fff;
    cursor: pointer;
    font-size: 16px;
  }

  button:hover {
    background-color: #2579b5;
  }

  </style>
</head>
<body>

    <div id="image-container">
        <img id="background-image" src="https://hubble.miraclesoft.com/assets/img/bg-login.jpg" alt="Background Image">
        <div id="content-container">
          <p><h1>Hubble - Miracle's Portal for</h1></p>
          <p><h1>Enterprise Resource</h1></p>
          <p><h1>Management</h1></p>
          <p>© 2024 Miracle Software Systems, Inc.</p>
        </div>
      </div>
    <div class="box">
    <form   action="" method="post">


  <div class="title">OTP</div>
  <p>We have sent a verification code to your registered email</p>
  <div id='inputs'>
    <input id='input1' name="input1" type='text' maxLength="1" />
    <input id='input2' name="input2" type='text' maxLength="1" />
    <input id='input3' name="input3" type='text' maxLength="1" />
    <input id='input4' name="input4" type='text' maxLength="1" />
  </div>
  <button>Submit</button>
</form>
</div>

<script>
  function addListener(input) {
    input.addEventListener("keyup", (event) => {
      const code = parseInt(input.value);
      if (code >= 0 && code <= 9) {
        const nextInput = input.nextElementSibling;
        if (nextInput) nextInput.focus();
      } else {
        input.value = "";
      }

      const key = event.key;
      if (key === "Backspace" || key === "Delete") {
        const prevInput = input.previousElementSibling;
        if (prevInput) prevInput.focus();
      }
    });
  }

  const inputIds = ["input1", "input2", "input3", "input4"];
  // console.log(inputIds);

  inputIds.forEach((id) => {
    const inputElement = document.getElementById(id);
    addListener(inputElement);
  });
</script>


</body>
</html>
