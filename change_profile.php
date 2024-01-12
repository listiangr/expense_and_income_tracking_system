<?php
  require './class/DB.php';
  require './class/Input.php';
  require './class/Validate.php';
  require './class/Akun.php';

  if(empty(Input::get('id'))) {
    header('Location:index.php');
  }

  $akun1 = new Akun();
  $akun1->generate(Input::get('id'));

  $usernameAwal = $akun1->getItem('username');

  if (!empty($_POST)) { // form submitted
    $error_message = $akun1->validate($_POST);

    if($error_message['username'] == "Username sudah terdaftar"){

      if($usernameAwal == $akun1->getItem('username')){
          unset($error_message['username']);
      }
    }

    if (empty($error_message)) {
      $akun1->update(Input::get('id'));
      
      header("Location:account.php");
    }
  }
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Expense Tacker</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body style="background-image:linear-gradient(rgba(167, 236, 205, 0.9),rgba(138, 218, 201, 0.9)); margin:8%;" class="bg-light">
  <div class="container my-5 pt-4 pb-5 px-5 rounded bg-white" style="max-width:500px">
    <h1 class="text-center mb-4">Update Profile</h1>
    <hr>
    </header>
  <section>
    
    <?php
      if (isset($error_message) && $error_message !== "") {
        echo "<div class=\"alert alert-danger alert-dismissible fade show mb-3\" role=\"alert\">";
        echo "<div class=\"m-0 p-0\">";
        foreach ($error_message as $message) {
          echo "<li>$message</li>";
        }
        echo "</div>";
        echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
          </div>";
      }
    ?>
    <form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="post">
      <div class="mb-3"">
        <label for="username" class="form-label">Username</label>
        <input style="border: 2px solid #009d63;"  type="text" name="username" id="username" class="form-control"
          value="<?php echo $akun1->getItem('username'); ?>" placeholder="Masukan username">
      </div>
      <div class="mb-3"">
        <label for="password" class="form-label">Password</label>
        <input style="border: 2px solid #009d63;"  type="text" name="password" id="password" class="form-control"
          value="<?php echo $akun1->getItem('password'); ?>" placeholder="Masukan password">
      </div>
      
      <div>
      </div>
       <input style="border: 2px solid #009d63; background-color:#009d63;" type="submit" name="submit" value="Update" class="w-100 btn btn-primary">
    </form>
  </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>