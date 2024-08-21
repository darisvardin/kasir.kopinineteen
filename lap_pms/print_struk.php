<?php
session_start();
// login dulu
if (!isset($_SESSION["login"])) {
    echo "<script>
        document.location.href = '../login.php';
        </script>";
    exit;
}
require_once('../koneksi/koneksi.php');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../assets/csss/print_one.css">
    <title>Cetak</title>
    <link rel="icon" href="../assets/img/logo_b.png" type="image/x-icon" />

    <style>
        @page {
            size: 57mm auto;
            margin: 5mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 57mm;
            box-sizing: border-box;
        }

        .table-header,
        .table-print {
            width: 100%;
            border-collapse: collapse;
        }

        .table-header td,
        .table-print td {
            padding: 1mm;
            font-size: 8px;
        }

        .table-header td {
            text-align: center;
        }

        .table-header img {
            width: 60px;
            height: 60px;
        }

        .table-header td,
        .table-header tr {
            border: none;
        }

        .table-header .header-item {
            border-bottom: double 1px #000;
        }

        .table-print td {
            text-align: left;
        }

        .table-print .spa td,
        .table-print .siv td {
            border: none;
        }

        .table-print .siv {
            border-top: none;
        }

        .table-print .solid {
            border-bottom: none;
        }

        .table-print .qty,
        .table-print .subtotal,
        .table-print .pelanggan {
            border-bottom: double 1px #000;
        }
    </style>
</head>

<body>
    <?php
    $decimal = "0";
    $a_decimal = ",";
    $thousand = ".";

    $nota = $_GET['nota'];
    $sql1 = "SELECT * FROM transaksi_msk WHERE nota='$nota'";
    $hasil1 = mysqli_query($koneksi, $sql1);
    $row = mysqli_fetch_assoc($hasil1);
    $tanggal = $row['tanggal'];
    $harga = $row['harga'];
    $total = 0;
    $total = $harga;
    $kasir = $row['nama_ksr'];
    $pembeli = $row['pembeli'];
    ?>

    <table class="table-header">
        <tr>
            <td class=" text-center"><img src="../assets/img/logo.png" alt="logo"></td>
        </tr>

        <tr>
            <td colspan="4" class="" style="font-style:italic;">Siap melayani kebutuhan perkopian anda</td>
        </tr>
        <tr>
            <td colspan="4" class="">jl. aja dulu</td>
        </tr>
        <tr>
            <td colspan="4" class="header-item">08576766578</td>
        </tr>
    </table>

    <table class="table-print">
        <tr class="spa">
            <td colspan="3"></td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td colspan="4">No.Nota - <?php echo $nota; ?></td>
            <td colspan="4"><?php echo date('H:i:s', strtotime($tanggal)); ?></td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td colspan="4"><?php echo date('d-m-Y', strtotime($tanggal)); ?></td>
        </tr>
        <tr class="pelanggan">
            <td colspan="6">Pelanggan: <?php echo $pembeli; ?></td>
        </tr>

        <tr class="siv"></tr>

        <?php
        mysqli_data_seek($hasil1, 0); // Reset pointer result set
        foreach ($hasil1 as $fill) {
        ?>
            <tr>
                <td colspan="6"><?php echo $fill['nama_produk']; ?></td>
            </tr>
            <tr class="qty">
                <td colspan="2">Qty : <?php echo $fill['qty']; ?> x</td>
                <td colspan="2"><?php echo number_format($fill['harga'], $decimal, $a_decimal, $thousand) . ',-'; ?></td>
                <td align="right"><?php echo number_format($fill['harga'] * $fill['qty'], $decimal, $a_decimal, $thousand) . ',-'; ?></td>

            </tr>
            <tr class="siv solid">
                <td><br></td>
            </tr>
        <?php } ?>

        <tr class="subtotal">
            <td colspan="4">SubTotal</td>
            <td colspan="4" align="right"><b><?php echo number_format($fill['harga'] * $fill['qty'], $decimal, $a_decimal, $thousand) . ',-'; ?></b></td>
        </tr>

        <tr class="siv solid"></tr>

        <tr>
            <td colspan="6">Kasir: <?php echo $kasir; ?></td>
        </tr>


    </table>
</body>

</html>