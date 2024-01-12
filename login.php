<?php
require './class/DB.php';
require './class/Input.php';
require './class/Validate.php';
require './class/Akun.php';

session_start();

if(isset($_SESSION["id_akun"])) {
    header('Location:index.php');
}

$DB = DB::getInstance();
$akun = new Akun();


if (!empty($_POST)) { // form submitted

    $error_message = $akun->validate($_POST);

    if(isset($error_message['username'])){
      if($error_message['username'] == "Username sudah terdaftar"){
            unset($error_message['username']);
      }
    }

    if (empty($error_message)) {

        $checkAkun = $akun->checkAkun($akun->getItem('username'), $akun->getItem('password'));
        
       
        if($checkAkun > 0){

            $data_akun = $DB->getWhereOnce('akun',['username','=',$akun->getItem('username')]);
            $_SESSION['id_akun'] = $data_akun->id_akun;

            if($data_akun->id_user != null){ //if akun have id_user 
              // redirect to index.php
              header('location:index.php');
            }else{
              // else (yang login admin) redirect to admin.php
              header('location:admin.php');
            }
            

        }else{

            $error_message['error'] = "Username atau Password tidak sesuai";

        }
    }
}

if((isset($_GET["message_error"])) && (empty($_POST))){

    $error_message['error'] = $_GET["message_error"];

}


?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Login </title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body style=" background-image:linear-gradient(rgba(167, 236, 205, 0.9),rgba(138, 218, 201, 0.9)); margin:15%;" class="bg-light">
  <div class="container my-5 pt-4 pb-5 px-5 rounded bg-white" style="max-width:500px">
    <h1 class="text-center mb-4">Login Page</h1>
    <?php
        if (isset($error_message) && $error_message !== "") {

            echo "<div class=\"alert alert-danger\">";
            foreach ($error_message as $message) {
                echo "$message<br>";
            }
            
            echo "</div>";
        }
      ?>
    <form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="post">
      <div class="mb-3"">
        <label for="username" class="form-label">Username</label>
        <input style="border: 2px solid #009d63;" type="text" name="username" id="username" class="form-control"
          value="<?php echo $akun->getItem('username'); ?>">
      </div>
      <div class="mb-3"">
        <label for="password" class="form-label">Password : </label>
        <input style="border: 2px solid #009d63;" type="password" name="password" id="password" class="form-control">
      </div>
      <div>
      <p>don't have an account? <a style="color:#009d63; ;" href="register.php">register now</a></p>
      </div>
      <input style="border: 2px solid #009d63; background-color:#009d63;" type="submit" name="submit" value="Login" class="w-100 btn btn-primary">
    </form>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
