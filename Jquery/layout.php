<?php
// session_start();
    if (count($_SESSION) == 0) {
    header("Location: index.php");
    exit();
}
?>
<?php
if (isset($_GET['login_success']) && $_GET['login_success'] === 'true') {


  echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css'>";
  echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js'></script>";
  echo "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js'></script>";
  
  echo "<style>";
  echo "  .custom-alert {";
  echo "    position: fixed;";
  echo "    top: 9%;";
  echo "    left: 50%;";
  echo "    width: 100%;";
  echo "    text-align: left;";
  echo "    transform: translateX(-50%);";
  echo "    z-index: 1050;"; 
  echo "  }";
  echo "</style>";

  echo "<script>";
  echo "$(document).ready(function() {";
  echo "  var alertMessage = 'Login Successfully!';";
  echo "  var alertElement = $('<div class=\"alert alert-success custom-alert\">').html('<strong>Success!</strong> ' + alertMessage);";
  echo "  $('body').append(alertElement);";
  echo "  setTimeout(function() {";
  echo "    alertElement.remove();";
  echo "  }, 2007);";
  echo "});";
  echo "</script>";
  echo "<script>";
echo "setTimeout(function() {";
echo "  window.location.href = 'home.php?success=false';";
echo "}, 2007);";
echo "</script>";
}
else if (isset($_GET['register_success']) && $_GET['register_success'] === 'true') {


  echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css'>";
  echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js'></script>";
  echo "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js'></script>";
  
  echo "<style>";
  echo "  .custom-alert {";
  echo "    position: fixed;";
  echo "    top: 9%;";
  echo "    left: 50%;";
  echo "    width: 100%;";
  echo "    text-align: left;";
  echo "    transform: translateX(-50%);";
  echo "    z-index: 1050;"; 
  echo "  }";
  echo "</style>";

  echo "<script>";
  echo "$(document).ready(function() {";
  echo "  var alertMessage = 'Registered Successfully!';";
  echo "  var alertElement = $('<div class=\"alert alert-success custom-alert\">').html('<strong>Success!</strong> ' + alertMessage);";
  echo "  $('body').append(alertElement);";
  echo "  setTimeout(function() {";
  echo "    alertElement.remove();";
  echo "  }, 2007);";
  echo "});";
  echo "</script>";
  echo "<script>";
echo "setTimeout(function() {";
echo "  window.location.href = 'home.php?success=false';";
echo "}, 2007);";
echo "</script>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<title>Page Title</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
  a{
    text-decoration: none;

  }
body {
  font-family: Arial;
  margin: 0;
  
}

header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  height: 63px;
  padding: 10px;
  text-align: left;
  background: white;
  color: black;
  border: 1px solid grey;
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 1000;
}

.logo img {
  width: 171px; 
  height: 63px; 
}

.option {
  display: flex;
  gap: 10px;
  margin-right: 45%;

  padding-top: 2rem;
padding-left:1rem;
color: white;
text-decoration: none;
font-size: large;
}
.option:hover{
  opacity: 0.8;

}

button {
  background-color: #df1171;
  color: white;
  padding: 10px 15px;
  border: none;
  cursor: pointer;
  border-radius: 4px;  
}

button:hover {
  opacity: 0.8;
}

footer {
  background-color: #333;
  color: white;
  text-align: right;
  padding: -50px;
  position: fixed;
  bottom: 0;
  width: 100%;
}
.profile{
  margin-right:1%;
            border-radius: 50%;
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
    width:162px;
}

.dropdown-content a {
    padding: 12px 14px;
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
.profff{
  margin-right:3%;
}
.profile-image:hover{
  border:solid;
  border-color:blue;
}
</style>
</head>

<title>PeopleConnect</title>
<body>
<header>
    <img alt="Image" width="171" height="63" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAaYAAAB3CAMAAAB/uhQPAAAAwFBMVEX///8jJScAquYAqOUApeUAAADx8fEeISM/QUJkw+0bHiAJDREApOQYGx0XGRy6u7vl5eXU8Pp2d3iysrNtbm5XWFl8fX4NERQABwz4/f4AAAbT09NoaWqkpKVYv+wAr+jI7PlEt+qLzfDp9fyb2vSw3PRfYGG45vf19fWbnJ1DvOuHiIkzNTfx+/7d3d5GSEnHx8d1ye+TlJUtLzHf8/uM1PKqq6tNT1Ch2/Q6PD2Z2vSy4PWCye8ruetWuuq/6fh0xCnTAAAUF0lEQVR4nO1dC1viOhOmtKVSoICK5aIUL6sogoiguByO//9ffW1uzWXSCwsL5/n67rOPUtpkZt5kMpkktVQqUKBAgQJ7QmU2mLWOLUSBZMwvX42G8XHdPLYgBfSYXfueYxiG06h1BscWpoAGg1ffoGgYRYc6TbQM14jheEV/Okm8NQwerjE+tkQFVDS7hgh/cWyRCqjouBJNjnNskQqosA0Z3WJ0Ojm0VJpq82MLVUDGAKDp4thCFZAxA2gqpk4nh3ExNv0n8CZHekbj2CIVUPFZk1jyro4tUgEAH444bWoU6xmniLkv0FS7ObZABUDc9Ln+1J8cW5wCGjQbNUyU49ufxxamgBbj51fb7vdtY1I5tigFEtEazAdF7FCgQIECBXZCRUT6A+O0ByqpRcp3cNhtRX68p3Kiklqt2WA+H8xarZ0LSUSC8loNWtdnAr6f02oZfIlPyFu8KlKJZ2dysqjZke/g8PV4ebX4HOSz0KzzLZfzln9pf1yZP1++fXhRkNq3bdt7fXuc3Aw0LXf8fCXiPNV0EVTzaMFpsLAdEXbKdHTmNMQHvDfRoou+IxcpLmRUvj35Dg6u2/D8mt3/WsyyaI0BlOjmnbE1r7582w8L4vJcTiiL7XUWTYCqG9uTYGfJtzzLBtdbwo7X6c49OZ+drF7lW0mAG2LcfamUKC0LtpQCILi+fZmVqLm8SwbZ+C1HhxzffNueqhkVpWu/TuTVGFXPTDnmK+UxLbjyVJoMP2lNvKPe70g0NeQbdqIpRCOtZzOhQAPbmVcjWxO75kBFcEp69seVUOC1omfjPENdeWiKywNocgz9tPRKXqUwDkhT+ORbliwGsGAcwe1keDZE5dzOZDpH9GrHpslonOncxQL0LoejyWg4GRyfTvN+plXjGy+z4RrX3HNHp8nwL+EqLnzg5oPSZLjpPFX6OjU1aggPP6a5O16YR+7J49Nk1MBoduaBGh2UJsM9S/N7z2DjQZKlUjx4zW6106PJ6ALDb8WAQ6HD0qTt2hTjV2138NNCkIE2ugNxcjQ5vtoQvzQVHJimtP1jFzqfF0r2mtwTB252hxfh5Ggy3Fc5jICCPIRD0+QmT4DgaBzDT5xwtjTuQS/JydFk+Ndi8Tdw1Gscnqbk7jTXd6ZQtO+EJ8dfiqQp+Ns0JU5vCfpCGJFgjX3Q5Pq+13Ad2AclToDU6nj4CQxPoNlFIv4yTVw+SE+TMItvGXovvgea3M5iMTl/fDM8OOTXR2yzZK3dN+2TA22ASGtVSzsQTZ7rug30j/yIfmn4l7GzT6CJO445Pktos3ug6YMO9a0F1GsTzgpMUoxd005xH/UqOX63b3sfrm33az7H1oFoqs1TFzISaArDCGq9xyRj/DlNzmtcBJRG9bT6tz5SYjXvWvPkXDvW+vb3Yk4EajUX3zZj6kA02elPJdFkeGRQmOiCPIT90lRaqE3COdOJf5MoGbKBJkGpCxB9byI90bo5s/HNJ0oTmR8qu8JF7JkmIPfjfGikH5+lTnw0J381I5PnL6Dof/7Vj4g6VZoM/zOaqifbYs80jb+V6rQ0NRVjq6L64KxLkyS71i0OzDshUd5hUq9/TpPjNQdp7n/fNKk9REuTehz7Wym8Bi1zVsAMU+KZ++abbfOKnBJNRrSknnzH3p0eMDa9wsIP1IXi5qPCHDSwzSE/XkvezDBuHmhZcA80ZcCeaQJGQt38VhW+Vmoqj0OruBNAbT+LlWPsjyZvcgPgk58snghNcYp0BrgjD850t6DdCKo7EwZ+AvVIY2qeVsY+p7c+gK7N8XQSNBkGlWi2gNKh0LJKCQrd7QE04bWVKe4YCDW6OXciHTxZxA+qp0GTY3x9dS4f3zwbjpPhZJEa5kWZVjV9pM6OZ0BnyvtqpYPT5HND5WnQFHqmKJ2lCVbcL1DhCyVfgStSs0C+HGbP1dagcax6/F/SlASNz1PnV/jIfFNJAymruGqcAcftSShoEuEBIUAJSsoRNsZvMn/OhxQdADRl24bE4dg0+QkTJRcY4A9Mk/sBZwZUM7nkRjW0kGdEysvkwjgjx15oTf1/lSa/CUSr1BBnQDs88M4iA27m6h5KlspRA3V5ozKghS5Fq8WRaepWBrrEg+PMgDdHHZQm/0PjjNS4O95Ufa6KIA5vEE3/MafXbwExFPmqCb3g65A0+ZeaRl5RWhK3UKsOW1KwCER6mjhFj+PTBG9CNvrP4HvYDkiTPkp+VvoDpxWQvfWE8wtqMjBlExKAYzu9yOrXwDQT5bz+Lk3azSrQQhMnxo0ivrD9G5reZtnJLODgNHW5hgP3ptL4VVHERZup/rbT68C5gaaydujwm5gH6tKiJ0RywOKMc7wshN+F4Cfm9BBNpZasqOOh6weiya35DTBukbcLEgBL5I7md1qQcEYM6Ix53620P5rczyaE5Ax5F1tdHoa72Lkfhib36+Lm8syG9vr0oaW6ATh2xuchoW9rfG8Bdvcpc+AU7I2mLOewdL0p9O+CKaijPAxNOAXQAjcwQZHy9Q65E35EBrd3HGu96c9oEnaF1qjLOBBNJA47B3hqqLkiIALIAP4lmTOow6Ws3g46DT5cPBWaSuesycVptcPSBB3tpe42UdUs6PJigJkW+FgXxuzSb7gGd+FkaBpTJ+R+s2sHpgnaHtmQ1UjdQwnD5TdFwLtl/WvN+DQ4dyJD8bsWAJqyxPT7p6nUwnuSHW5Z7sA0lS6gQUPqTsCGy0ywuXIG8NZk7/VTjcsr8+sGNlMyTY5+w3qMA9BUmn24USjOq3dgmqCt3VJ3Gu/WmaRRTrOF3Ome3Qj6tOZX3316bzJNRmMCh9Zzro/ui6YuL+XAa7h93soHp2kAdCcx0/O5Y2cSg0bwlR9IHd/vTC5mlcpsMH++6jh9bjdpCk2GVwMnqjY39QZoghen89BUGry9CjnJg9MEvL1ECvb0Z23TIGyK6OhPZLhezY7Q9aWzuWk06cDldaENYJ8XILhGlez0VByeJqAGw+ckBhYhMoPfFJF6vgnArjRxFgCTRTUQdhx4nh5N4OjEpYyAUBrc5+b7QBqcz7gv8vO9K01c+j3HZILzhidIE3TyKF4CBwTwJ3DWVD1V4xh8wP2We/r1d2ni1pxPkCYoLxovMwBxsPavrX0pHU/YzF/JHTLaXHv4GzSxRnWKNEGLx3SrAvAaKV+b4/lUChJ3IM/snDzZ3NP/9zSVgDUNGqQBWur/BgeQrhCXKwZ+vuwgv/2ooAl6CxHuTi112NeergVt4ohvN5vlemeRMPEqaBoDNOF3WQCpuKS3NAKruNKeh9ZXnricl7OgCdSlFjqcFrA2rj0+HUENIuTzMeNF9tdLOfxmvoIm8KUcUXcCpjr6ACICsPynnNycv2V7pZ7jO8lvp9TjFGlSj/Dlpgm0QW0GnZ5OeONpiIpqFMeQbxp/fqcT5fof4psI/ipN6lO1RL2BgFiiSR0+pC2nQPylLKRDmZzaAvibumn7tq7UQ1DKMZqIKKOW5Ppc3/u6kJaiciWL4uMeu01vP21XhK990Su2ccOXHqhJ+7MHtpSa6tqSgh35jv63shqn3FOr2fPxd1+5mLKnuKWmq+Etms1Otwa9WcH1Q/k6n+pBgEnSq8cke3PHfz/thpsRfS6Gfe6IuEo5mTC/kh6YyA+05OUWufVWlAUZdc1Uvac5QIfJ1YspyPxXGSrNyZlt97u1Gk4Jhu3Ltr3HRRO2SOvczgqX33x2/djJhsdF8cevdJgNmhc3zxFuLprFH6AqUKBAgQIFChQo8HfQ6/V01+EvTh+nJPpeZOmtq0EQvKyn4uXRw/vLNvyiuuGvvlcFDEul9rAKYLiZ4ut37NF1dLlNP93j+97Jxyl57p6v7IkHJ95vqa61otP6PZR8uyKl/UaiDEdMY/Igsl17Hel0R7/cgOpUw9qn0je4PFx0m68c2Wj4RD4tV8Mgsu/dU+lPsDEtM4JV3z4s46tBHV8Ovwju2PXeLb2KUQ/prJsArLvSFt1aps9Og+gypaW0Ro/VqYV/41LqK06yXrluxai//NAvqpZcl4hRQFUK7tqoavQ56AnPW5Hd7l+InnXzfRN9/wCqY4Y03Uvf1JHd8cWAa0QrrNkD+WRRYUNhpJ6QA6G5ygQhIdRAL/HV8LpZp9bt3XLXQ0Q0WWUA5qq0QV9Yv2lF6KNJJQ2igph60wCXK+jbC4TKzPqQ2PldFMKUaHqyYpWihhTKiC6YVaoyEixqEe341jJuM2uxbPodokm8hmguYe3NF1b7Bt9mYZqGnHVMs13aEcTIqN2Xza1oNE6klylPk9CbdDSVypgJgWBrxddLPxFKoyuciyU0mVi46MuhQBMTQqRpabLHomfQtRUqv44Kb1vMsFPx1kw0Sb2JCM7cRJs8j2laEfNGXSr8uTNNVWy86t0wcgyEpqFZjiUiv257sbHN4I7gH87plXktIke0wjYYoTJ/iMDE8yBLM48Yd1LzVqbJvA2r2Vo8iZgmkwpxJ4yexDTW8K4aqkRo6r1gucP6prfsV3JrqM4/w9D1I5oeLEidmCZzyHRvczRhjrkWjmkizeD9af1PJMyuNBGzR426t7mt45a/oU0gGA5D9oi879z9L1wR7ZchwgsxM/4UDev3vKuh1BNLC16I9C2kk8lGIEoTuom4zFuOprpGJ1QTErc3GlrkriXu2sNoYEJioK6wjRm7X5WR0/tF5CfmJp+GjCbmxAkoTcSjUTUxTct6rGZvE+zs9HDTquNG3VtvOYuaARpSpyvqcSLFAJoosP+3fikGK0+Rmag6yHHhlkA6GrNsZBpzyB7naSIeFHe/ZJr+RQ6MsP1Eh1syUq7IT+wncQX/4juWVT5irOKezA2V9/GQxoG5fDSs3rGPiCbiX4lDnK6WpR2BzV6lIzkSF9fKQjTirZFHzEfTD+Y76j/xqI+a1FAopo2+qC/xTXFYydO0xQWg9pilN73ccypFqFI3hsyPXS/pMtRp8oGYliZNb0LqbOKBDdE0JVGHPNnJDeLmg4e4oLU4urOOXO/FNN1TxCUBNJFGsKUu26Rt6x5XQVvvO4k12sxdIfA09UzWYqnQ1s/Tz0/0X5qQPOAmXF4JczA+LjJN0hSqJIIYjhQ76mgy30mlTyN01WLch2FErCUZm0id1u3mz4haEttZAdOKRBVxuSNC00gNyK2SdJdIE2F8iXukGdChAA3dLPgm48Ya04qdZARC07B3v9yQCBP3P9I12YxKVInwEar0LhAVh6QsnByR1m5at2spT6CjKYracK3YO5MghPAd/45pohFsKIxcQT5syMzBtMqkcf/Lx9ER2kS5p5gmLiBnVgBoug9IhIJ/blC/DN0GKoX11xWbUSFaTdrJaEBer9ctYnnccd61bYVIwlT6zdvmndqsqlwKK9mKA4eWJgqTo8naxKFq8GTFNIUVUF9rBaM0LpLwFLCCtqj1/Us9FcWStI8ncHobG0elibqzEf7R+6kj3XFwTj0P59sQrayFSNPbsG2suFL1NJXaQdyIeduQLhlw3DEzhqULOad8NI2IVwovP+HwzqJZCDOuQJw45ETvvU6bHxq+h3JvIupZo3h6C/gbkKY2MQztPdjwfGhAQxQciCPjkD7DaKLSDanNkp0eMo5FnUQ9DvCpiAIdo1vW3oV4OZfTC+NK4j9DJdsCTaXlkJmXRba7YboKiFcxmRHqsYCkpURXSAixHRGoNhBpKr3gcmkb+GXRj2ioQyCTWFwVHwFSmoKgLkZkJISgQkDK9x62xPz1eIDC3psZkGBDi6fxH4I+hKC1YlIpTTgFFXUxiaZQqfcyCTS4uftu2MSO7UcI9kssHor6V76AvMRlgciEk/qGuAzsysvBFgFbFlsg9oY/mGjaD5IDcooffixHgGkKRSeZt8hfCEpnDcjRLC2cN6OoSKGpxBIyO6ch2Lg5YjqRSImN8NTFRPXmpmkaD2btWN4yF21tmc9hKRrSRLhBa0mCqHtOIh1NTCUSQcbtTaGJ9R4pTVzKOb3Fk+lb7DZ5mhgtQuIsP9hSySjmhuYLb9dh196w2C6SODdNtDA64t6X6TBITIR9erw8gL9F1uHnTQ98F0+maXVLjIFDnySa3h+IFCSrw1GQvzeF7Rv1dp6m8h1xuQ9/SJNVHj6028sRZgNlfWkPiBai6FBMWn9+mpb0eSIhzW5Ti2BzBP/eYuDMIG6yQhYiYOMbo2m5bGOIofTKMl9W4cX2UI4YVJrqwbodGvKejHZcKKYfm2itbcQARxPJYgg0WUF1E8ryVKZTxt0QSoOoICFEGVfEgkgKk/T1/DTRke2FtFuS6LdIK1vSRGgPg4bw0d0CTcRroK4hrzcFQoUrQSVWUwmiKWyHZnB7SyZoZc6KqQE5kYWnidTC02Tilk7807C0I6qCxnQx9acsEGWyGcsONJGVJdZQh0I0fidbYxm3a4GmKUmXRJZMpYlDvF4M0oS1M5Vb90aTYMYRYLdMqHLLtKbF2I5iSCx91BzKbBtBIk0mSFNvi6asTF+Uj6UuEBtfGJYxjVFsLNDEd6cUmgSVtpyh27g2jiZLKIbPLRFnnE6TmUwTJ4spRR85sFwFZbIZwgw2whe3uPRguIl9QUhTBA1NEaUKTWjXA7fHIdpOwVbzV7hq3mVv8EaFURS9R7/StrPEcUa06FIVNyVINN2HkjOVBMu0UREcTT9b02ILuOJ2maqyx0HeC0FpiooUaYprGVVpeBQOmCPAatmx/PkVTliqqx/lm+myvZQyu0tgzMbo4XFVzQRP31crfrPGz92K7eOBimPjc28V4W4tXI++YIM4hVzl/ejXy3Y7vHsS0509buinha6rAeZT0mmplNyTa13GUk3V+2gt7Z/VdvtSXY9KBf4I0xDHlkGP/wEGPTzXY5GzvwAAAABJRU5ErkJggg==" >
    <div class="option">
          <a href="home.php">
          <i class="fa fa-fw fa-home"></i>
              <!-- <button >Register</button> -->
             <b> Home</b>
          </a> 
          <a href="registration_form.php">
          <i class="fa fa-fw fa-plus"></i>
             <b> Register</b>
          </a>
          <br>
          <a href="list.php">
              <i class="fa fa-fw fa-list"></i>
             <b> Employ Data </b>
          </a>
          
          
      </div>
   

<div class="profile">



  <?php

if (!isset($_SESSION['firstName']) || !isset($_SESSION['lastName']) || !isset($_SESSION['image'])) {
  exit();
}

$firstNamee = $_SESSION['firstName'];
$lastNamee = $_SESSION['lastName'];
$imagee = $_SESSION['image'];
$employId=$_SESSION['employId'];
   

if (!empty($imagee)) {
  $imageData = base64_decode($imagee);
  $imageType = "data:image/png;base64,";
  echo '<div class="profile-container">';
  echo '<img style="max-width:100px; height: 72px; border-radius:45%;" id="profile-image" class="profile-image" src="' . $imageType . base64_encode($imageData) . '" alt="Profile Image">';
  echo '<div class="dropdown-content" id="myDropdown">';
  echo '<a  href="profile.php?employId=' . $employId . '"><i class="fs-13 fa fa-user"></i> Profile</a>';
  echo '<a href="password_reset.php"><i class="fa fa-outdent"></i> Reset Pasword</a>';
  echo '<a href="logout.php"><i class="fa fa-power-off"></i> Logout</a>';
  echo '</div>';
  echo '</div>';
} else { 
  $num=9999;
  echo '<div class="profile-container">';
  echo '<img style="max-width:100px; height: 72px;" id="profile-image" class="profile-image" src="unknown.jpg" alt="Profile Image">';
  echo '<div class="dropdown-content" id="myDropdown">';
  echo '<a  href="profile.php?employId=' . $num . '"><i class="fs-13 fa fa-user"></i> Profile</a>';
  echo '<a href="password_reset.php"><i class="fa fa-outdent"></i> Reset Password</a>';
  echo '<a href="logout.php"><i class="fa fa-power-off"></i> Logout</a>';
  echo '</div>';
  echo '</div>';

}

?> 

</div>
<div> 
<h3> <p style="color:black;" id="proff">firstName</p></h3>
</div>
<div class="profff"> 
<h3> <p style="color:black;" id="profff">lastName</p></h3>

</header>

<footer>
<p style="margin-right:1%; color:white;">&copy; Miracle SoftWare Systems 2024.</p>
</footer>
        </body>

        </body>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
const firstNamee = <?= json_encode($firstNamee); ?>;                     
    const lastNamee = <?= json_encode($lastNamee); ?>;

    const unameElementt = $("#proff");
    const unameElementtt = $("#profff");
    
console.log(firstNamee);
console.log(lastNamee);
    unameElementt.html(firstNamee+" "); 
    unameElementtt.html(lastNamee); 


  </script>
  <script>


$(document).ready(function() {
    const profileImage = $('.profile-image');
    const dropdown = $('.dropdown-content');

    profileImage.on('click', function() {
        dropdown.toggleClass('show');
    });

    $(window).on('click', function(event) {
        if (!$(event.target).hasClass('profile-image')) {
            if (dropdown.hasClass('show')) {
                dropdown.removeClass('show');
            }
        }
    });
});

</script>

</html>


</html>


