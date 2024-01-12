<?php
  require './class/DB.php';
  require './class/Input.php';
  require './class/Validate.php';
  require './class/Akun.php';
  require './class/User.php';

  $DB = DB::getInstance();
  $akun = new Akun();
  $user = new User();

  if (!empty($_POST)) { // form submitted

    $error_message_akun = $akun->validate($_POST);
    $error_message_user = $user->validate($_POST);

    if (empty($error_message_akun) && empty($error_message_user)){
      
      $user->insert(); //insert to user table

      $getIdUser = $DB->getWhereOnce('user',['email','=',$user->getItem('email')]);
      
      $akun->setId_User($getIdUser->id_user);
      $akun->insert(); //insert to akun tabel

      $getIdAkun = $DB->getWhereOnce('akun',['id_user','=',$getIdUser->id_user]);
      

      $saldo = [
        'jumlah_saldo' => 0,
        'tanggal' => date('Y-m-d H:i:s'),
        'id_akun' => $getIdAkun->id_akun,
      ];

      $DB->insert('saldo', $saldo); //create saldo in saldo table for new akun

      header("Location:login.php");
    }
  }
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Register </title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body style="background-image:linear-gradient(rgba(167, 236, 205, 0.9),rgba(138, 218, 201, 0.9)); margin:8%;" class="bg-light">
  <div class="container my-5 pt-4 pb-5 px-5 rounded bg-white" style="max-width:500px">
    <h1 class="text-center mb-4">Register Page</h1>
    <?php

        

      if (isset($error_message_user) || isset($error_message_akun)){
        echo "<div class=\"alert alert-danger\">";
          if (isset($error_message_user) && $error_message_user !== "") {

            foreach ($error_message_user as $message) {
                echo "$message<br>";
            }
            
          }

          if (isset($error_message_akun) && $error_message_akun !== "") {

              
              foreach ($error_message_akun as $message) {
                  echo "$message<br>";
              }
              
              
          }

          echo "</div>";
      }
        
      ?>
    <form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="post">
      <div class="mb-3"">
        <label for="nama" class="form-label">Nama</label>
        <input style="border: 2px solid #009d63;"  type="text" name="nama" id="nama" class="form-control"
          value="<?php echo $user->getItem('nama'); ?>" placeholder="Masukan nama">
      </div>
      <div class="mb-3"">
        <label for="email" class="form-label">Email</label>
        <input style="border: 2px solid #009d63;"  type="email" name="email" id="email" class="form-control"
          value="<?php echo $user->getItem('email'); ?>" placeholder="Masukan email">
      </div>
      <div class="mb-3"">
        <label for="no_telepon" class="form-label">No Telepon</label>
        <input style="border: 2px solid #009d63;"  type="text" name="no_telepon" id="no_telepon" class="form-control"
          value="<?php echo $user->getItem('no_telepon'); ?>" placeholder="Masukan no telepon">
      </div>
      <div class="mb-3"">
        <label for="username" class="form-label">Username</label>
        <input style="border: 2px solid #009d63;"  type="text" name="username" id="username" class="form-control"
          value="<?php echo $akun->getItem('username'); ?>" placeholder="Masukan username">
      </div>
      <div class="mb-3"">
        <label for="password" class="form-label">Password</label>
        <input style="border: 2px solid #009d63;"  type="password" name="password" id="password" class="form-control"
          value="<?php echo $akun->getItem('password'); ?>" placeholder="Masukan password">
      </div>
      <div>
      <p>already have an account? <a  style="color:#009d63; ;" href="login.php">login now</a></p>
      </div>
      <input style="border: 2px solid #009d63; background-color:#009d63;" type="submit" name="submit" value="Register" class="w-100 btn btn-primary">
    </form>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
