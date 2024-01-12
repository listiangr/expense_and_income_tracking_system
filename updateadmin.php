<?php
  require './class/DB.php';
  require './class/Input.php';
  require './class/Validate.php';
  require './class/AdminModel.php';
  require './class/Akun.php';

  if(empty(Input::get('id_akun'))) {
    header('Location:admin.php');
  }

  if(empty(Input::get('id_admin'))) {
    header('Location:admin.php');
  }

  
 
  $admin = new AdminModel();
  $admin->generate(Input::get('id_admin'));
  $akun = new Akun();
  $akun->generate(Input::get('id_akun'));

  $emailAwal = $admin->getItem('email');
  $usernameAwal = $akun->getItem('username');

  if (!empty($_POST)) { // form submitted

    $error_message1 = $admin->validate($_POST);
    $error_message2 = $akun->validate($_POST);

    if($error_message1['email'] == "Email sudah terdaftar"){

      if($emailAwal == $admin->getItem('email')){
          unset($error_message1['email']);
      }
    }

    if($error_message2['username'] == "Username sudah terdaftar"){

      if($usernameAwal == $akun->getItem('username')){
          unset($error_message2['username']);
      }
    }

    if (empty($error_message1) && empty($error_message2)) {
      $admin->update(Input::get('id_admin'));
      $akun->update(Input::get('id_akun'));
      $message = urlencode("Admin dengan nama <b>{$admin->getItem('nama')}</b> sudah berhasil di-update");
      header("Location:admin.php?message={$message}");
    }
  }
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body style="background-image:linear-gradient(rgba(167, 236, 205, 0.9),rgba(138, 218, 201, 0.9)); margin:8%;" class="bg-light">
  <div class="container my-5 pt-4 pb-5 px-5 rounded bg-white" style="max-width:500px">
    <h1 class="text-center mb-4">Update Admin</h1>
    <hr>
    </header> 
  <section>
    
    <?php
      if (isset($error_message1) || isset($error_message2)){
        echo "<div class=\"alert alert-danger\">";
          if (isset($error_message1) && $error_message1 !== "") {

            foreach ($error_message1 as $message) {
                echo "$message<br>";
            }
            
          }

          if (isset($error_message2) && $error_message2 !== "") {

              
              foreach ($error_message2 as $message) {
                  echo "$message<br>";
              }
              
              
          }

          echo "</div>";
      }
    ?>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" class="form">
      <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" style="border: 2px solid #009d63;"  name="nama" id="nama" class="form-control" value="<?php echo $admin->getItem('nama'); ?>">
      </div>
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" style="border: 2px solid #009d63;"  name="username" id="username" class="form-control" value="<?php echo $akun->getItem('username'); ?>">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="text" style="border: 2px solid #009d63;"  name="password" id="password" class="form-control" value="<?php echo $akun->getItem('password'); ?>">
      </div>
      <div class="mb-3">
        <label for="no_telepon" class="form-label">No Telepon</label>
        <input type="text" style="border: 2px solid #009d63;"  name="no_telepon" id="no_telepon" class="form-control" value="<?php echo $admin->getItem('no_telepon'); ?>">
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" style="border: 2px solid #009d63;"  name="email" id="email" class="form-control"
          value="<?php echo $admin->getItem('email'); ?>">
      </div>
      <br>
      <input style="border: 2px solid #009d63; background-color:#009d63;" type="submit" name="submit" value="Update" class="w-100 btn btn-primary">
    </form>
  </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>