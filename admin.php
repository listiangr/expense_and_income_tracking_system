<?php
  require './class/DB.php';
  require './class/Input.php';
  require './class/Validate.php';
  require './class/Akun.php';
  require './class/User.php';

  session_start();
  
  $id_akun = $_SESSION["id_akun"];

  $DB = DB::getInstance();
  
//   $akun = new Akun();
  $akun = $DB->get('akun');
//   $user1 = $DB->get('user');
  


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
                    class="fas fa-user-secret me-2"></i>ExTracker</div>
            <div class="list-group list-group-flush my-3">
                <a href="admin.php" class="list-group-item list-group-item-action bg-transparent second-text"><i
                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">Admin</h2>
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
                    ?>
                    <div class="row my-5">
                        <h3 class="fs-4 mb-3">Admin</h3>
                        <div class="col">
                            <table class="table bg-white rounded shadow-sm  table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col" width="50">#</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">No Telp</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Password</th>
                                        <th scope="col">Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>      
                                <?php 

                                    // $no = 1;
                                    $i = 1;
                                    foreach ($akun as $data) { 

                                        
                                        if($data->id_user != null){
                                        
                                            $user = $DB->getWhereOnce('user',['id_user','=',$data->id_user]);

                                            echo "<tr>";
                                            echo "<th scope=\"row\">$i</th>";
                                            echo "<td>{$user->nama}</td>";
                                            echo "<td>{$user->no_telepon}</td>";
                                            echo "<td>{$user->email}</td>";;
                                            echo "<td>{$data->username}</td>";
                                            echo "<td>{$data->password}</td>";

                                            echo "<th scope=\"row\" class=\"text-center\">
                                            <a style=\"width:80px\"
                                                class=\"btn btn-info text-white d-inline-block\" href=\"./update.php?id_akun=$data->id_akun & id_user=$data->id_user\">Update</a>
                                            <a style=\"width:80px\"
                                                class=\"btn btn-danger text-white\" href=\"./delete.php?id_akun=$data->id_akun & id_user=$data->id_user\">Delete</a>
                                        </th>";

                                        }else{

                                            $admin = $DB->getWhereOnce('admin',['id_admin','=',$data->id_admin]);

                                            echo "<tr>";
                                            echo "<th scope=\"row\">$i</th>";
                                            echo "<td>{$admin->nama}</td>";
                                            echo "<td>{$admin->no_telepon}</td>";
                                            echo "<td>{$admin->email}</td>";;
                                            echo "<td>{$data->username}</td>";
                                            echo "<td>{$data->password}</td>";

                                            echo "<th scope=\"row\" class=\"text-center\">
                                            <a style=\"width:80px\"
                                                class=\"btn btn-info text-white d-inline-block\" href=\"./updateadmin.php?id_akun=$data->id_akun & id_admin=$data->id_admin\">Update</a>
                                            <a style=\"width:80px\"
                                                class=\"btn btn-danger text-white\" href=\"./deleteadmin.php?id_akun=$data->id_akun & id_admin=$data->id_admin\">Delete</a>
                                        </th>";

                                        }

                                      
                                        echo "</tr>";

                                    $i++;
                                    }
                                ?>
                                
                                </tbody>
                            </table>
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