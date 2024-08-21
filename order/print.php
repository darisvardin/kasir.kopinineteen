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
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>App Kasir</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="../assets/img/logo_b.png" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="../assets/js/plugin/webfont/webfont.min.js"></script>
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
                urls: ["../assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />


    <link rel="stylesheet" href="../assets/css/template.css" />
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a class="logo">
                        <img src="../assets/img/logo_b.png" alt="navbar brand" class="navbar-brand" height="45" />
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
                        <li class="nav-item ">
                            <a href="../dashboard.php">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                        </li>
                        <li class="nav-item active">
                            <a href="order.php">
                                <i class="fas fa-cart-plus"></i>
                                <p>Order</p>
                            </a>
                        </li>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                        </li>
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
                                            <a href="../produk/read.php">
                                                <span class="sub-item">Daftar Produk</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="../kategori/read.php">
                                                <span class="sub-item">Kategori Produk</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="../user/read.php">
                                    <i class="fas fa-users"></i>
                                    <p>User</p>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="../pembayaran/read.php">
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
                                            <a href="../lap_pms/read.php">
                                                <span class="sub-item">Pemasukan</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="../lap_klr/read.php">
                                                <span class="sub-item">Pengeluaran</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        <?php endif ?>
                        <li class="nav-item">
                            <a href="../logout.php">
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


                    <!-- Main content -->
                    <section class="content">
                        <div class="row">
                            <div class=" col-sm-5">
                                <!-- ./col -->

                                <div class="card">
                                    <div class="card-header with-border">
                                        <h3 class="card-title ">Tampilan Struk</h3>
                                        <div class="card-tools pull-right">
                                        </div>
                                    </div>
                                    <div class="card-body">


                                        <?php
                                        $decimal = "0";
                                        $a_decimal = ",";
                                        $thousand = ".";
                                        ?>

                                        <?php
                                        $nota = $_GET['nota'];

                                        $sql1 = "SELECT * FROM transaksi_msk where nota='$nota'";
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
                                                <td colspan="4" class="text-center"><img src="../assets/img/logo.png" style="width:100px;height:100px;"></td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:10px;"></td> <!-- <td colspan=" 4" class="text-center" style=" font-size:16px;  font-weight:bold; width:300px">Kopi Nineteen</td> -->
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="text-align:center; font-style:italic; width:400px;  ">Siap melayani kebutuhan perkopian anda</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="left" style=" text-align:center; width:400px;">jl. aja dulu</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style=" text-align:center; border-bottom:double 4px #000; padding-bottom:5px;width:300px;">08576766578</td>
                                            </tr>
                                        </table>

                                        <table class="table-print">
                                            <tr class="spa">
                                                <td width="20%" style="width:48px;">&nbsp;</td>
                                                <td width="15%" style="width:28.8px;">&nbsp;</td>
                                                <td width="20%" style="width:43.2px;">&nbsp;</td>
                                                <td width="18%" style="width:48px;">&nbsp;</td>
                                                <td width="18%" style="width:60px;">&nbsp;</td>
                                                <td width="8%" style="width:12px;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                            </tr>

                                            <tr>
                                                <td style="width:81px;" colspan="3" align="left">No.Nota - <?php echo $nota; ?>
                                                <td style="width:81px;" colspan="3" align="left"><?php echo date('H:i:s', strtotime($tanggal)); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="width:81px;" colspan="3" align="left">
                                                <td style="width:81px;" colspan="3" align="left"><?php echo date('d-m-Y', strtotime($tanggal)); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:300px;" colspan="6" align="left">Pelanggan: <?php echo $pembeli; ?></td>
                                            </tr>
                                            <tr class="siv">
                                                <td colspan="5" style="width:300px; border-top:double 1px #000;">
                                                </td>
                                            </tr>

                                            <?php
                                            $Subtotal = 0;
                                            foreach ($hasil1 as $fill) {

                                                $total = $fill['harga'] * $fill['qty'];
                                                $Subtotal += $total;
                                            ?>

                                                <tr>
                                                    <td colspan="6" style="width:300px;"><?php echo ($fill['nama_produk']); ?></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2" style="width:76.8px;">Qty : <?php echo ($fill['qty']); ?> x</td>
                                                    <td style="width:43.2px;"><?php echo number_format(($fill['harga']), $decimal, $a_decimal, $thousand) . ',-'; ?></td>
                                                    <td style="width:48px;" align="right"><?php echo number_format($total, $decimal, $a_decimal, $thousand) . ',-'; ?></td>
                                                    <td style="width:72px;" colspan="2" align="right"></td>
                                                </tr>
                                            <?php }
                                            ?>
                                            <tr class="siv">
                                                <td colspan="5" style="width:300px; border-top:double 1px #000;">
                                                </td>
                                                <td style="width:12px;"><br></td>
                                            </tr>

                                            <tr>
                                                <td colspan="3" style="width:300px;">SubTotal</td>
                                                <td style="width:48px;" align="right"><b><?php echo number_format($Subtotal, $decimal, $a_decimal, $thousand) . ',-'; ?></b></td>
                                                <td style="width:72px;" colspan="2"></td>
                                            </tr>

                                            <!-- <tr>
                                                <td colspan="3" style="width:120px;">Bayar</td>
                                                <td style="width:48px;" align="right"><?php echo number_format($bayar, $decimal, $a_decimal, $thousand) . ',-'; ?></td>
                                                <td style="width:72px;" colspan="2"></td>
                                            </tr>

                                            <tr class="siv">
                                                <td colspan="5" style="width:228px; border-top:double 1px #000; ">
                                                </td>
                                                <td style="width:12px;">(-) </td>
                                            </tr>

                                            <tr>
                                                <td colspan="3" style="width:120px;">Kembali</td>
                                                <td style="width:48px;" align="right"><?php echo number_format($kembali, $decimal, $a_decimal, $thousand) . ',-'; ?></td>
                                                <td style="width:72px;" colspan="2"></td>
                                            </tr> -->

                                            <tr class="siv solid">
                                                <td colspan="6" style="border-bottom:double 1px #000; padding-bottom:5px;width:300px;">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width:237px;text-align:left" colspan="6">Kasir: <?php echo $kasir; ?></td>
                                            </tr>

                                        </table>

                                    </div>
                                </div>


                                <div class="card-footer">
                                    <button onclick="window.history.go(-3);" class="btn btn-block btn-warning"><i class="fas fa-arrow-left"> Kembali</i></button>
                                    <button class="btn btn-block btn-primary" onclick="frames['printf'].print()"><i class="fas fa-print"></i> Cetak</button>
                                </div>

                                <!-- ./col -->
                            </div>


                        </div>
                        <!-- /.row (main row) -->
                    </section>
                    <!-- /.content -->
                    <iframe id="printf" name="printf" src="print_struk.php?nota=<?php echo $nota; ?>&printhandler=no" style="display:none;"></iframe>
                </div>
            </div>



            <footer class="footer">
                <div class="text-center">
                    <p class="">2024</p>
                </div>
            </footer>
        </div>

    </div>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <!-- Datatables -->
    <script src="../assets/js/plugin/datatables/datatables.min.js"></script>
    <!-- style JS -->
    <script src="../assets/js/kasir.min.js"></script>

    <script src="../assets/js/setting-demo2.js"></script>
</body>

</html>