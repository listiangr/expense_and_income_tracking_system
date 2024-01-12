<?php
  require './class/DB.php';
  require './class/Input.php';
  require './class/Validate.php';
  require './class/Akun.php';
  require './class/User.php';

  session_start();
  
  $id_akun = $_SESSION["id_akun"];

  $DB = DB::getInstance();

  $akun = new Akun();
  $akun->generate($id_akun);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <title>Expense Tracker</title>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><i
                    class="far fa-money-bill-alt me-2"></i>ExTracker</div>
            <div class="list-group list-group-flush my-3">
                <a href="index.php" class="list-group-item list-group-item-action bg-transparent second-text"><i
                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="add_income.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-chart-line me-2"></i>Add Income</a>
                <a href="add_expense.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i 
                        class="fas fa-hand-holding-usd me-2"></i></i>Add Expense</a>
                <a href="notification.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i 
                        class="fas fa-paper-plane me-2"></i>Notification</a>
                <a href="export.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-file-export me-2"></i>Export</a>
                <a href="account.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold active"><i 
                        class="fas fa-address-card me-2"></i>Account</a>
                <a href="logout.php" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                        class="fas fa-power-off me-2"></i>Logout</a>
            </div>
        </div>
        <!-- sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">Profile</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i>
                                <?php

                                    $data_akun = $DB->getWhereOnce('akun',['id_akun','=',$id_akun]);
                                    echo $data_akun->username;

                                ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="account.php">Profile</a></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>



            <div  class="d-flex justify-content-center">
                <div class="card text-center" style="width: 30rem;">
                    <div class="card-body">
                        <?php 
                            $user = new User();
                            $user->generate($akun->getItem('id_user'));
                            
                                ?>
                            <h5 class="card-header"><?php echo "Hello " .$user->getItem('nama') ."!"; ?></h5>
                            <div class="img mb-2"> <img src="" width="70" class="rounded-circle"> </div>
                            <h5><?php echo "Username: " .$akun->getItem('username'); ?></h5>
                            <small><?php echo "Email: " .$user->getItem('email'); ?></small><br>
                            <small><?php echo "No Telepon: " .$user->getItem('no_telepon'); ?></small>
                            <div class="mt-4 apointment"> 
                            <?php 
                            echo "<a class=\"btn btn-primary text-uppercase\" href=\"./change_profile.php?id=$id_akun\">Change Profile</a>";
                            ?>

                            <a href="logout.php" style="border: 1px solid #009d63; background-color:#009d63;" class="w-30 btn btn-primary text-uppercase">Logout</a>
                            <!-- <input style="border: 2px solid #009d63; background-color:#009d63;" type="submit" name="submit" value="Set Minimum Saldo" class="w-100 btn btn-primary"> -->
                       
                        </div>
                    </div>
                </div>
            </div><br>

            <div  class="d-flex justify-content-center">
                <div class="card text-center" style="width: 30rem;">
                    <div class="card-body">
                            <h5 class="card-header">Contact</h5>
                            <div class="img mb-2"> <img src="" width="70" class="rounded-circle"> </div>
                            <p>Need to get in touch with us? contact on the email below</p>
                            <h5>Email: extrackere@gmail.com</h5>
                            <div class="mt-4 apointment"> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };
    </script>
</body>

</html>