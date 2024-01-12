<?php
    require './class/DB.php';
    require './class/Input.php';
    require './class/Validate.php';
    require './class/Pemasukan.php';
    require './class/Pengeluaran.php';

    session_start();
  
    $DB = DB::getInstance();

    $id_akun = $_SESSION["id_akun"];
  
    $data1 = new Pemasukan();
    $data2 = new Pengeluaran();

    $error_message = "";

    if (!empty($_POST)) { // form submitted

        $from_date = $_POST["from_date"];
        $to_date = $_POST["to_date"];

        
        if(empty($from_date)) {
            // echo "aasda";
            $error_message .= "Tanggal awal harus diisi<br>";
        }
      
        if(empty($to_date)) {
            $error_message .= "Tanggal akhir harus diisi<br>";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <title>Export</title>
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
                <a href="export.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold active"><i
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
                    <h2 class="fs-2 m-0">Export History</h2>
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
                <div class="container my-5 pt-4 pb-5 px-5 rounded bg-white" style="max-width:500px">
                    <h1 class="text-center mb-4">Select Date Range</h1>

                    <?php
                        if (isset($error_message) && $error_message !== "") {
                            echo "<div class=\"alert alert-danger mb-3\">
                            <ul class=\"m-0\">$error_message</ul>
                            </div>";
                        }
                    ?>

                    <form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="post">
                    <input type="hidden" id="id_akun" name="id_akun" value="<?php echo $id_akun; ?>">
                        <div class="mb-3"">
                            <label for="html5-datetime-local-input" class="col-md-2 col-form-label">From</label>
                            <input
                                style="border: 2px solid #009d63;"
                                class="form-control"
                                type="datetime-local"
                                name="from_date"
                                id="from_date"
                                value="<?php echo $data1->getItem('from_date'); echo $data2->getItem('from_date');?>"
                            />
                        </div>
                        <div class="mb-3"">
                            <label for="html5-datetime-local-input" class="col-md-2 col-form-label">To Date</label>
                            <input
                                style="border: 2px solid #009d63;"
                                class="form-control"
                                type="datetime-local"
                                name="to_date"
                                id="to_date"
                                value="<?php echo $data1->getItem('to_date'); echo $data2->getItem('to_date'); ?>"
                            />
                        </div>
                        <input 
                            style="border: 2px solid #009d63; background-color:#009d63;" 
                            type="submit" 
                            name="submit" 
                            value="Add" 
                            class="w-100 btn btn-primary"
                        />
                    </form>
                </div>
                <div class="row my-5">
                    <?php

                        if(!empty($_POST) && $error_message === "") {
                            echo "<h3 class='fs-4 mb-3'>Data History from {$from_date} to {$to_date}</h3>";
                        
                        }
                        else{
                            echo "<h3 class='fs-4 mb-3'>Data History from ... to ...</h3>";
                        }
                    ?>
                    <div class="col">
                        <table class="table bg-white rounded shadow-sm  table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" width="50">No.</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Note</th>
                                </tr>
                            </thead>
                            <tbody>      
                            <?php      
                                if(!empty($_POST) && $error_message === "") 
                                { 
                                    $data_pemasukan = $DB->range('pemasukan','id_akun','tanggal_pemasukan',[$id_akun, $from_date, $to_date]);
                                    $data_pengeluaran = $DB->range('pengeluaran','id_akun','tanggal_pengeluaran',[$id_akun, $from_date, $to_date]);

                                    $history = [];
                                    $key = 0;

                                    foreach ($data_pemasukan as $key => $data) 
                                    {
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

                                    foreach ($data_pengeluaran as $data) 
                                    {
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

                                    usort($history, function($a, $b) {
                                        $ad = new DateTime($a->tanggal);
                                        $bd = new DateTime($b->tanggal);
                                    
                                        if ($ad == $bd) {
                                        return 0;
                                        }
                                    
                                        return $ad < $bd ? -1 : 1;
                                    });

                                    $no = 1;
                                    foreach ($history as $data) 
                                    {
                                        if($data->kategori == "Pemasukan"){
                                            echo "<tr>";
                                            echo "<th scope='row'>$no</th>";
                                            echo "<td>{$data->tanggal}</a></td>";
                                            echo "<td>{$data->kategori}</td>";
                                            echo "<td>Rp.{$data->jumlah}</td>";
                                            echo "<td>{$data->deskripsi}</td>";
                                            echo "<tr>";
                                        }else{
                                            echo "<tr>";
                                            echo "<th scope='row'>$no</th>";
                                            echo "<td>{$data->tanggal}</a></td>";
                                            echo "<td>{$data->kategori}</td>";
                                            echo "<td>Rp.{$data->jumlah}</td>";
                                            echo "<td>{$data->deskripsi}</td>";
                                            echo "<tr>";
                                        }
                                        $no++;
                                    }
                                }   
                            ?>
                            </tbody>
                        </table>
                        <?php
                            if(!empty($_POST) && $error_message === "") {
                                echo "<a href='hasil_export.php?from_date=".$from_date."&to_date=".$to_date."'><button 
                                        type='submit' 
                                        name='submit' 
                                        style='border: 2px solid #009d63; background-color:#009d63; color:white'>
                                        Export Data
                                    </button></a>";
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
        