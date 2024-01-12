<?php
    require './class/DB.php';

    session_start();
    $DB = DB::getInstance();
    $id_akun = $_SESSION["id_akun"];

    if(!isset($_GET['from_date']) && !isset($_GET['to_date'])){
        header('Location: export.php');
    }
    else if(isset($_GET['from_date']) && isset($_GET['to_date'])){
        $from_date = $_GET['from_date'];
        $to_date = $_GET['to_date'];
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Data History.xls");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hasil Export</title>
</head>
<body>
    <div>
        <?php
            if(isset($_GET['from_date']) && isset($_GET['to_date'])){
                echo "<h3 class='fs-4 mb-3'>Data History from {$from_date} to {$to_date}</h3>";
            }
        ?>
        <div>
            <table rules="all" border="1">
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

                        usort($history, function($a, $b) 
                        {
                            $ad = new DateTime($a->tanggal);
                            $bd = new DateTime($b->tanggal);
                            
                            if ($ad == $bd) {
                                return 0;
                            }
                            
                            return $ad < $bd ? -1 : 1;
                        });

                        $no = 1;
                        foreach ($history as $data) {

                            if($data->kategori == "Pemasukan"){
                                echo "<tr>";
                                echo "<th scope='row'>$no</th>";
                                echo "<td>{$data->tanggal}</a></td>";
                                echo "<td>{$data->kategori}</td>";
                                echo "<td>Rp.{$data->jumlah}</td>";
                                echo "<td>{$data->deskripsi}</td>";
                                echo "<tr>";
                            }
                            else{
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
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>