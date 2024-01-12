<?php
  require './class/DB.php';
  require './class/Input.php';
  require './class/Validate.php';
  require './class/AdminModel.php';
  require './class/Akun.php';

 

  $admin = new AdminModel();
  $admin->generate(Input::get('id_admin'));

  $akun = new Akun();
  $akun->generate(Input::get('id_akun'));

  if (!empty($_POST)) {
    $admin->delete(Input::get('id_admin'));
    $akun->delete(Input::get('id_akun'));
    $message = urlencode("Admin dengan nama <b>{$admin->getItem('nama')} sudah berhasil dihapus");
    header("Location:admin.php?message={$message}");
  }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Expense Tracker</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body style="background-image:linear-gradient(rgba(167, 236, 205, 0.9),rgba(138, 218, 201, 0.9)); margin:8%;" class="bg-light" >
  <div class="container my-5 pt-4 pb-5 px-5 rounded bg-white" style="max-width:500px">
    <h1 class="text-center mb-4">Delete Admin</h1>
    <hr>
    </header> 
  <section >
    
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

<div class="modal-body">
                <p> Apakah Anda yakin menghapus Admin 
                  <b style=" color:#009d63;"><?php echo $admin->getItem('nama'); ?></b>?</b></p>
              </div>
              <div class="modal-footer">
              <a href="./admin.php" style="border: 2px solid #009d63; background-color:#009d63;" class="btn btn-secondary">Tidak</a>

              <form method="post">
                <input type="hidden" name="id"
                  value="<?php echo $admin->getItem('id_admin'); ?>">
                <input type="submit" style="border: 2px solid #009d63; background-color:red;" class="btn btn-danger" value="Ya">
              </form>
   
  </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>

