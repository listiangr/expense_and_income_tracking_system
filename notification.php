<?php
  require './class/DB.php';
  require './class/Input.php';
  require './class/Validate.php';
  require './class/Minimum_Saldo.php';

  session_start();
  
  $id_akun = $_SESSION["id_akun"];

  $DB = DB::getInstance();

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
                <a href="notification.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold active"><i 
                        class="fas fa-paper-plane me-2"></i>Notification</a>
                <a href="export.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-file-export me-2"></i>Export</a>
                <a href="account.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold "><i 
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
                    <h2 class="fs-2 m-0">Notification</h2>
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

            <div class="container-fluid px-4">
                <div class="container my-5 pt-4 pb-5 px-5 rounded bg-white" style="max-width:700px">
                    <h1 class="text-center mb-4">Notification Minimum Balance</h1>
                    <hr>
                    <?php
                        if (Input::get('message') !== "") {
                        echo "<div class=\"alert alert-success alert-dismissible fade show my-3\" role=\"alert\">
                            <div class=\"m-0\">".Input::get('message')."</div>
                            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                        </div>";
                        }
                    ?>
                    <div class="notification-info">
                        <h5 align="center" style="color:#009d63">To get notified when your balance reaches a certain amount, you need to set or update the minimum balance</h5>
                        <br>
                        <?php

                            $data_minimum_saldo = $DB->getWhereOnce('minimum_saldo',['id_akun','=',$id_akun]);

                            if($data_minimum_saldo != false){
                                echo "<h6 style='padding:7px;'> Your current minimum balance: Rp. ". $data_minimum_saldo->jumlah_minimum_saldo ."</h6>";
                                echo                         
                                "<div class='button-minimum-balance text-left px-2'>
                                    <a href='minimal_saldo.php' style='border: 1px solid #009d63; background-color:#009d63;' class='w-30 btn btn-primary text-uppercase'>Update Minimum Balance</a>
                                </div>";
                            }else{
                                echo                         
                                "<div class='button-minimum-balance text-center'>
                                    <a href='minimal_saldo.php' style='border: 1px solid #009d63; background-color:#009d63;' class='w-30 btn btn-primary text-uppercase'>Set Minimum Balance</a>
                                </div>";
                            }

                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->
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