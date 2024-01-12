<?php
  require "./class/DB.php";
  require "./class/Input.php";

  session_start();
  
  // redirect to login.php if user has not logged
  if(!isset($_SESSION["id_akun"])) {
    $message_error = urlencode('Anda Belum Login');
    header("location: login.php?message_error=$message_error");
  }

  $DB = DB::getInstance();
  $id_akun = $_SESSION["id_akun"];

  $data_akun = $DB->getWhereOnce('akun',['id_akun','=',$_SESSION["id_akun"]]); //get data akun

  $data_user = $DB->getWhereOnce('user',['id_user','=',$data_akun->id_user]); //get data user


?><!DOCTYPE html>
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
                <a href="index.php" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="add_income.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-chart-line me-2"></i>Add Income</a>
                <a href="add_expense.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i 
                        class="fas fa-hand-holding-usd me-2"></i></i>Add Expense</a>
                <a href="notification.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i 
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
                    <h2 class="fs-2 m-0">Dashboard</h2>
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
                <?php
                    if (Input::get('message') !== "") {
                    echo "<div class=\"alert alert-success alert-dismissible fade show my-3\" role=\"alert\">
                        <div class=\"m-0\">".Input::get('message')."</div>
                        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                    </div>";
                    }

                    // if (isset($message_warning) && $message_warning !== "") {

                    //     echo "<div class=\"alert alert-warning alert-dismissible fade show my-3\" role=\"alert\">
                    //     <div class=\"m-0\">". $message_warning ."</div>
                    //     <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                    //     </div>";
                    // }
                ?>
                <div class="row g-3 my-2">
                    <div class="col-md-4">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"> +Rp. 
                                <?php
                                    $income = 0;

                                    $DB->orderBy('tanggal_pemasukan');
                                    $data_pemasukan = $DB->getWhere('pemasukan',['id_akun','=',$_SESSION["id_akun"]]);
                                    
                                    // count all income user
                                    foreach ($data_pemasukan as $data) { 
                                        $income = $income + $data->jumlah_pemasukan;
                                    }

                                    echo $income;						
                                                                
                                ?>
                                </h3>
                                <p class="fs-5">Income</p>
                            </div>
                            <i class="fas fa-chart-line fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                            <h3 class="fs-2"> -Rp. 
                            <?php
                                $expense = 0;

                                $DB->orderBy('tanggal_pengeluaran');
                                $data_pengeluaran = $DB->getWhere('pengeluaran',['id_akun','=',$_SESSION["id_akun"]]);

                                // count all expense user
                                foreach ($data_pengeluaran as $data) { 
                                    $expense = $expense + $data->jumlah_pengeluaran;
                                }

                                echo $expense;								
                                                        
                            ?>
                                </h3>
                                <p class="fs-5">Expense</p>
                            </div>
                            <i
                                class="fas fa-hand-holding-usd fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2">
                                <?php

                                    $saldo = 0;

                                    // count saldo
                                    $saldo = $income - $expense;

                                    $data_saldo = [
                                      'jumlah_saldo' => $saldo,
                                      'tanggal' => date('Y-m-d H:i:s'),
                                    ];
                              
                                    // update amount of saldo user from count result 
                                    $DB->update('saldo', $data_saldo,['id_akun','=',$_SESSION["id_akun"]]);

                                    if($saldo < 0){
                                        echo "Rp. -". $saldo * -1;
                                    }else{
                                        echo "Rp. +". $saldo;
                                    }
                                ?>
                                </h3>
                                <p class="fs-5">Balance</p>
                            </div>
                            <i class="fas fa-dollar-sign fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center mb-5">
                    <div class="col-md-6 mt-4">
                        <div class="card h-100 mb-4">
                            <div class="card-header pb-0 px-3">
                            <div class="row">
                                <div class="col-md-6">
                                <h6 class="mb-0">Your Transaction's History</h6>
                                </div>
                            </div>
                            </div>
                            <div class="card-body pt-4 p-3">
                            <ul class="list-group">

                            <?php

                                $history = [];

                                $key = 0;
                                
                                foreach ($data_pemasukan as $key => $data) {

                                    $object = new stdClass();
                                    $object->id = $data->id_pemasukan;
                                    $object->jumlah = $data->jumlah_pemasukan;
                                    $object->deskripsi = $data->deskripsi_pemasukan;
                                    $object->tanggal = $data->tanggal_pemasukan;
                                    $object->id_akun = $data->id_akun;
                                    $object->kategori = "Pemasukan";

                                    $history[$key] = $object;

                                }

                                $key = $key+1;

                                foreach ($data_pengeluaran as $data) {

                                    $object = new stdClass();
                                    $object->id = $data->id_pengeluaran;
                                    $object->jumlah = $data->jumlah_pengeluaran;
                                    $object->deskripsi = $data->deskripsi_pengeluaran;
                                    $object->tanggal = $data->tanggal_pengeluaran;
                                    $object->id_akun = $data->id_akun;
                                    $object->kategori = "Pengeluaran";

                                    $history[$key] = $object;
                                    $key++;

                                }

                                // sorting history income and expense user by date
                                usort($history, function($a, $b) {
                                    $ad = new DateTime($a->tanggal);
                                    $bd = new DateTime($b->tanggal);
                                
                                    if ($ad == $bd) {
                                    return 0;
                                    }
                                
                                    return $ad < $bd ? -1 : 1;
                                });

                                foreach ($history as $data) {

                                    $raw_date = strtotime($data->tanggal);
                                    $date1 = date("j F Y", $raw_date);
                                    $date2 = date("h:i:s A", $raw_date);

                                    if($data->kategori == "Pengeluaran"){
                                        echo "<li class='list-group-item border-0 d-flex justify-content-between ps-2 mb-2 border-radius-lg'>
                                        <div class='d-flex align-items-center'>
                                        <i class='fas fa-arrow-circle-down fa-2x'  style='color:red'></i>
                                            <div class='d-flex flex-column px-4'>
                                            <h6 class='mb-1 text-dark text-sm'>$date1 at $date2</h6>
                                            <span class='text-xs'>$data->deskripsi</span>
                                            </div>
                                        </div>
                                        <div class='d-flex align-items-center text-danger text-gradient text-sm font-weight-bold'>
                                            - Rp. $data->jumlah 
                                        </div>
                                        </li>";
                                    }else{
                                        echo "<li class='list-group-item border-0 d-flex justify-content-between ps-2 mb-2 border-radius-lg'>
                                        <div class='d-flex align-items-center'>
                                            <i class='fas fa-arrow-circle-up fa-2x'  style='color:#009d63'></i>
                                            <div class='d-flex flex-column px-4'>
                                            <h6 class='mb-1 text-dark text-sm'>$date1 at $date2</h6>
                                            <span class='text-xs'>$data->deskripsi</span>
                                            </div>
                                        </div>
                                        <div class='d-flex align-items-center text-success text-gradient text-sm font-weight-bold'>
                                            + Rp. $data->jumlah 
                                        </div>
                                        </li>";
                                    }

                                }
                            ?>
                            </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->
    </div>

    <?php
     
        $data_saldo = $DB->getWhereOnce('saldo',['id_akun','=',$id_akun]); //get data saldo
        $data_minimum_saldo = $DB->getWhereOnce('minimum_saldo',['id_akun','=',$id_akun]); //get data minimum_saldo

        if(!empty($data_minimum_saldo->jumlah_minimum_saldo)){

            // Untuk pengiriman email
            $to = $data_user->email;
            $subject = "Layanan Notifikasi ExTracker";

            $message = "
            <html>
            <head>
                <title>Layanan Notifikasi ExTracker</title>
            </head>
            <body>
                <p>Hallo $data_akun->username</p>
                <p>EXTracker ingin mengigatkan bahwa saldo pada ExTracker anda sudah menyentuh jumlah minimum yang ditetapkan!</p>
            </body>
            </html>
            ";

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // Header Email
            $headers .= 'From: <extrackere@gmail.com>' . "\r\n";
            $headers .= 'Cc: extrackere@gmail.com' . "\r\n";

            // kirim email jika saldo sudah lebih kecil atau sama dengan jumlah minimum saldo yang ditetapkan
            if($data_saldo->jumlah_saldo <= $data_minimum_saldo->jumlah_minimum_saldo){

                // show alert
                echo '<script type ="text/JavaScript">';  
                echo 'alert("Saldo sudah melewati batas minimum saldo")';  
                echo '</script>'; 

                // send email to user
                mail($to,$subject,$message,$headers);

            }

        }


    ?>

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