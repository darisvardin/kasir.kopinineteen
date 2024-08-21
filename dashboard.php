<?php
session_start();
require_once('koneksi/koneksi.php');

// login dulu
if (!isset($_SESSION["login"])) {
    echo "<script>
        document.location.href = 'login.php';
        </script>";
    exit;
}

// Mendapatkan hari dalam bahasa Indonesia
$hari = array(
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
);
$hari_ini = $hari[date('l')];

// Mendapatkan tanggal, bulan, dan tahun
$tanggal = date('d');
$bulan = array(
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember'
);
$bulan_ini = $bulan[date('m')];
$tahun = date('Y');

$sqlprod = "SELECT COUNT(*) as total FROM produk";
// Langkah 3: Eksekusi query dan ambil hasilnya
$resultprod = $koneksi->query($sqlprod);
if ($resultprod->num_rows > 0) {
    // Ambil data
    $rowprod = $resultprod->fetch_assoc();
    $totalprod = $rowprod['total'];
} else {
    $totalprod = 0;
}

$sqlusr = "SELECT COUNT(*) as total FROM ksr";
// Langkah 3: Eksekusi query dan ambil hasilnya
$resultusr = $koneksi->query($sqlusr);
if ($resultusr->num_rows > 0) {
    // Ambil data
    $rowusr = $resultusr->fetch_assoc();
    $totalusr = $rowusr['total'];
} else {
    $totalusr = 0;
}

$sqlkat = "SELECT COUNT(*) as total FROM kategori";
$resultkat = $koneksi->query($sqlkat);
if ($resultkat->num_rows > 0) {
    // Ambil data
    $rowkat = $resultkat->fetch_assoc();
    $totalkat = $rowkat['total'];
} else {
    $totalkat = 0;
}

$sqlor = "SELECT COUNT(*) as total FROM transaksi_msk WHERE DATE(tanggal) = CURDATE()";
$resultor = $koneksi->query($sqlor);
if ($resultor->num_rows > 0) {
    // Ambil data
    $rowor = $resultor->fetch_assoc();
    $totalor = $rowor['total'];
} else {
    $totalor = 0;
}

$sqlpeng = "SELECT SUM(nominal) as totalpeng FROM pengeluaran WHERE DATE(tgl) = CURDATE()";
$resultpeng = $koneksi->query($sqlpeng);
if ($resultpeng->num_rows > 0) {
    // Ambil data
    $rowpeng = $resultpeng->fetch_assoc();
    $totalpeng = $rowpeng['totalpeng'];
} else {
    $totalpeng = 0;
}

// Mengambil grand total pemasukan hari ini
$queryTotalPemasukan = "SELECT SUM(harga * qty) AS grand_total FROM transaksi_msk WHERE DATE(tanggal) = CURDATE()";
$resultTotalPemasukan = $koneksi->query($queryTotalPemasukan);
if ($resultTotalPemasukan->num_rows > 0) {
    $rowTotalPemasukan = $resultTotalPemasukan->fetch_assoc();
    $grand_total = $rowTotalPemasukan['grand_total'];
} else {
    $grand_total = 0;
}

// Mengambil total item terjual hari ini
$queryTotalItem = "SELECT SUM(qty) AS total_item FROM transaksi_msk WHERE DATE(tanggal) = CURDATE()";
$resultTotalItem = $koneksi->query($queryTotalItem);
if ($resultTotalItem->num_rows > 0) {
    $rowTotalItem = $resultTotalItem->fetch_assoc();
    $total_item = $rowTotalItem['total_item'];
} else {
    $total_item = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>App Kasir</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="assets/img/logo_b.png" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />

    <link rel="stylesheet" href="assets/css/demo.css" />
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a class="logo">
                        <img src="assets/img/logo_b.png" alt="navbar brand" class="navbar-brand" height="45" />
                    </a>
                    <a href="" class="d-flex align-items-right"></a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item active">
                            <a href="dashboard.php">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                        </li>
                        <?php if ($_SESSION['level'] == 'Kasir') : ?>
                            <li class="nav-item">
                                <a href="order/order.php">
                                    <i class="fas fa-cart-plus"></i>
                                    <p>Order</p>
                                </a>
                            </li>
                            <li class="nav-section">
                                <span class="sidebar-mini-icon">
                                    <i class="fa fa-ellipsis-h"></i>
                                </span>
                            </li>
                        <?php endif ?>
                        <?php if ($_SESSION['level'] == 'Admin') : ?>
                            <li class="nav-item">
                                <a data-bs-toggle="collapse" href="#tables">
                                    <i class="fas fa-layer-group"></i>
                                    <p>Produk</p>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse " id="tables">
                                    <ul class="nav nav-collapse">
                                        <li>
                                            <a href="produk/read.php">
                                                <span class="sub-item">Daftar Produk</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="kategori/read.php">
                                                <span class="sub-item">Kategori Produk</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a href="user/read.php">
                                    <i class="fas fa-users"></i>
                                    <p>User</p>
                                </a>
                            </li>

                            <li class="nav-item ">
                                <a href="pembayaran/read.php">
                                    <i class="fas fa-dollar-sign"></i>
                                    <p>Pembayaran</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a data-bs-toggle="collapse" href="#charts">
                                    <i class="far fa-chart-bar"></i>
                                    <p>Laporan</p>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="charts">
                                    <ul class="nav nav-collapse">
                                        <li>
                                            <a href="lap_pms/read.php">
                                                <span class="sub-item">Pemasukan</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="lap_klr/read.php">
                                                <span class="sub-item">Pengeluaran</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        <?php endif ?>
                        <li class="nav-item">
                            <a href="logout.php">
                                <i class="fas fa-sign-out-alt"></i>
                                <p>Keluar</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="container">
                <div class="page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h2 class="fw-bold mb-3">Dashboard</h2>
                            <h5 class="op-7 mb-2"><?php echo "$hari_ini, $tanggal $bulan_ini $tahun"; ?></h5>
                        </div>
                        <div class="ms-md-auto py-2 py-md-0">

                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-info bubble-shadow-small">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <h4 class="card-title">Selamat Datang, <?php echo $_SESSION['fullname']; ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col-sm-6 col-md-3 ms-auto me-auto">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                                <i class="fas fa-shopping-bag"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Jumlah Produk tersedia</p>
                                                <h4 class="card-title"><?php echo $totalprod ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-3 ms-auto me-auto">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-info bubble-shadow-small">
                                                <i class="fas fa-layer-group"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Jumlah Kategori Produk</p>
                                                <h4 class="card-title"><?php echo $totalkat ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if ($_SESSION['level'] == 'Admin') : ?>
                            <div class="col-sm-6 col-md-3 ms-auto me-auto">
                                <div class="card card-stats card-round">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-icon">
                                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                                    <i class="fas fa-users"></i>
                                                </div>
                                            </div>
                                            <div class="col col-stats ms-3 ms-sm-0">
                                                <div class="numbers">
                                                    <p class="card-category">Total User</p>
                                                    <h4 class="card-title"><?php echo $totalusr ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>

                        <div class="row">

                            <div class="col-sm-6 col-md-3 ms-auto me-auto">
                                <div class="card card-stats card-round">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-icon">
                                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                                    <i class="far fa-check-circle"></i>
                                                </div>
                                            </div>
                                            <div class="col col-stats ms-3 ms-sm-0">
                                                <div class="numbers">
                                                    <p class="card-category">Total Order Hari ini</p>
                                                    <h4 class="card-title"><?php echo $totalor ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-3 ms-auto me-auto">
                                <div class="card card-stats card-round">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-icon">
                                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                                    <i class="fas fa-cart-arrow-down"></i>
                                                </div>
                                            </div>
                                            <div class="col col-stats ms-3 ms-sm-0">
                                                <div class="numbers">
                                                    <p class="card-category">Produk Terjual Hari ini</p>
                                                    <h4 class="card-title"><?php echo $total_item ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-3 ms-auto me-auto">
                                <div class="card card-stats card-round">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-icon">
                                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                                    <i class="fas fa-arrow-alt-circle-down"></i>
                                                </div>
                                            </div>
                                            <div class="col col-stats ms-3 ms-sm-0">
                                                <div class="numbers">
                                                    <p class="card-category">Pemasukan Hari ini</p>
                                                    <h4 class="card-title">Rp. <?php echo number_format($grand_total) ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <?php if ($_SESSION['level'] == 'Admin') : ?>
                                <div class="col-sm-6 col-md-3 ms-auto me-auto">
                                    <div class="card card-stats card-round">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-icon">
                                                    <div class="icon-big text-center icon-danger bubble-shadow-small">
                                                        <i class="fas fa-arrow-alt-circle-up"></i>
                                                    </div>
                                                </div>
                                                <div class="col col-stats ms-3 ms-sm-0">
                                                    <div class="numbers">
                                                        <p class="card-category">Pengeluaran Hari ini</p>
                                                        <h4 class="card-title">Rp. <?php echo number_format($totalpeng) ?></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>

                    </div>
                </div>
            </div>

            <footer class="footer">
                <div class="text-center ">
                    <p class="">© <?= date('Y') ?></p>
                </div>
            </footer>

        </div>
        <!--   Core JS Files   -->
        <script src="assets/js/core/jquery-3.7.1.min.js"></script>
        <script src="assets/js/core/popper.min.js"></script>
        <script src="assets/js/core/bootstrap.min.js"></script>

        <!-- jQuery Scrollbar -->
        <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
        <!-- Datatables -->
        <script src="assets/js/plugin/datatables/datatables.min.js"></script>
        <!-- style JS -->
        <script src="assets/js/kasir.min.js"></script>

        <script src="assets/js/setting-demo2.js"></script>

</body>

</html>