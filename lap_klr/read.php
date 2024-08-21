<?php
session_start();
require_once('../koneksi/koneksi.php');

// login dulu
if (!isset($_SESSION["login"])) {
    echo "<script>
        document.location.href = '../login.php';
        </script>";
    exit;
}

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


    <link rel="stylesheet" href="../assets/css/demo.css" />
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
                        <li class="nav-item">
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
                        <!-- <li class="nav-item">
                            <a href="../order/order.php">
                                <i class="fas fa-cart-plus"></i>
                                <p>Order</p>
                            </a>
                        </li>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                        </li> -->
                        <li class="nav-item ">
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
                                    <li>
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
                        <li class="nav-item">
                            <a href="../pembayaran/read.php">
                                <i class="fas fa-dollar-sign"></i>
                                <p>Pembayaran</p>
                            </a>
                        </li>
                        <li class="nav-item active submenu">
                            <a data-bs-toggle="collapse" href="#charts">
                                <i class="far fa-chart-bar"></i>
                                <p>Laporan</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse show" id="charts">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="../lap_pms/read.php">
                                            <span class="sub-item">Pemasukan</span>
                                        </a>
                                    </li>
                                    <li class="active">
                                        <a href="read.php">
                                            <span class="sub-item">Pengeluaran</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

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
                    <h2 class="">Laporan Pengeluaran</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <form method="get" action="">
                                            <p class="">Filter Periode</p>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <input name="tgl_awal" type="date" class="form-control" value="<?= @$_GET['tgl_awal'] ?>" size="10" />
                                                </div> s/d
                                                <div class="col-lg-4">
                                                    <input name="tgl_akhir" type="date" class="form-control" value="<?= @$_GET['tgl_akhir'] ?>" size="10" />
                                                </div>
                                                <div class="col-lg-4">
                                                    <button type="submit" name="filter" value="true" class="btn btn-primary">Cari</button>
                                                    <?php
                                                    if (isset($_GET['filter'])) // Jika user mengisi filter tanggal, maka munculkan tombol untuk reset filter
                                                        echo '<a href="read.php" class="btn btn-danger">Reset</a>';
                                                    ?>
                                                </div>
                                            </div>

                                        </form>
                                        <?php
                                        $tgl_awal = @$_GET['tgl_awal']; // Ambil data tgl_awal sesuai input (kalau tidak ada set kosong)
                                        $tgl_akhir = @$_GET['tgl_akhir']; // Ambil data tgl_awal sesuai input (kalau tidak ada set kosong)

                                        if (empty($tgl_awal) or empty($tgl_akhir)) { // Cek jika tgl_awal atau tgl_akhir kosong, maka :
                                            // Buat query untuk menampilkan semua data pengeluaran
                                            $query = "SELECT * FROM pengeluaran";

                                            $url_cetak = "print.php";
                                            $label = "";
                                        } else { // Jika terisi
                                            // Buat query untuk menampilkan data pengeluaran sesuai periode tanggal
                                            $query = "SELECT * FROM pengeluaran WHERE tgl BETWEEN '" . $tgl_awal . "' AND '" . $tgl_akhir . "'";

                                            $url_cetak = "print.php?tgl_awal=" . $tgl_awal . "&tgl_akhir=" . $tgl_akhir . "&filter=true";
                                            $tgl_awal = date('d-m-Y', strtotime($tgl_awal)); // Ubah format tanggal jadi dd-mm-yyyy
                                            $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir)); // Ubah format tanggal jadi dd-mm-yyyy
                                            $label = 'Periode ' . $tgl_awal . ' s/d ' . $tgl_akhir;
                                        }
                                        ?>
                                        <button onclick="document.location='<?php echo $url_cetak ?>'" class="btn btn-success btn-round ms-auto">
                                            <i class="fa fa-print"></i>
                                            Cetak Laporan
                                        </button>


                                        <button onclick="document.location='insert.php'" class="btn btn-primary btn-round ms-auto">
                                            <i class="fa fa-plus"></i>
                                            Tambah Data
                                        </button>

                                    </div>
                                    <?php echo $label ?>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">

                                        <table id="add-row" class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%">No.</th>
                                                    <th>Keterangan</th>
                                                    <th>Tanggal</th>
                                                    <th>Jumlah</th>
                                                    <th>Nominal</th>
                                                    <th style="width: 10%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Keterangan</th>
                                                    <th>Tanggal</th>
                                                    <th>Jumlah</th>
                                                    <th>Nominal</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                $eksekusi = mysqli_query($koneksi, $query);
                                                $totalRows = mysqli_num_rows($eksekusi);
                                                $no = 1;
                                                while ($row = mysqli_fetch_assoc($eksekusi)) {
                                                    $tgl = date('d-m-Y', strtotime($row['tgl'])); ?>
                                                    <tr>
                                                        <td><?php echo $no++; ?></td>
                                                        <td><?php echo $row['ket']; ?></td>
                                                        <td><?php echo $tgl ?></td>
                                                        <td><?php echo $row['qty']; ?></td>
                                                        <td><?php echo number_format($row['nominal'], 0, ',', '.'); ?></td>
                                                        <td>
                                                            <div class="form-button-action">
                                                                <button onclick="document.location='update.php?id=<?php echo $row['idpl']; ?>'" type=" button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                                                                    <i class="fa fa-edit">
                                                                    </i>
                                                                </button>
                                                                <a href="delete.php?id=<?php echo $row['idpl']; ?>" onclick="return confirm('Apakah anda yakin akan menghapus data ?')" type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="footer">
                <div class="text-center">
                    <p class="mb-0 fs-6">2024</p>
                </div>
            </footer>
        </div>

        <!-- Custom template | don't include it in your project! -->
        <div class="custom-template">
            <div class="title">Settings</div>
            <div class="custom-content">
                <div class="switcher">
                    <div class="switch-block">
                        <h4>Sidebar</h4>
                        <div class="btnSwitch">
                            <button type="button" class="selected changeSideBarColor" data-color="white"></button>
                            <button type="button" class="changeSideBarColor" data-color="dark"></button>
                            <button type="button" class="changeSideBarColor" data-color="dark2"></button>
                        </div>
                    </div>
                    <div class="switch-block">
                        <h4>Background</h4>
                        <div class="btnSwitch">
                            <button type="button" class="selected changeBackgroundColor" data-color="white"></button>
                            <button type="button" class="changeBackgroundColor" data-color="dark"></button>
                            <button type="button" class="changeBackgroundColor" data-color="dark2"></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="custom-toggle">
                <i class="icon-settings"></i>
            </div>
        </div>
        <!-- End Custom template -->
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
    <script>
        $(document).ready(function() {
            $("#basic-datatables").DataTable({});

            $("#multi-filter-select").DataTable({
                pageLength: 5,
                initComplete: function() {
                    this.api()
                        .columns()
                        .every(function() {
                            var column = this;
                            var select = $(
                                    '<select class="form-select"><option value=""></option></select>'
                                )
                                .appendTo($(column.footer()).empty())
                                .on("change", function() {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                    column
                                        .search(val ? "^" + val + "$" : "", true, false)
                                        .draw();
                                });

                            column
                                .data()
                                .unique()
                                .sort()
                                .each(function(d, j) {
                                    select.append(
                                        '<option value="' + d + '">' + d + "</option>"
                                    );
                                });
                        });
                },
            });

            // Add Row
            $("#add-row").DataTable({
                pageLength: 5,
            });

            var action =
                '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

            $("#addRowButton").click(function() {
                $("#add-row")
                    .dataTable()
                    .fnAddData([
                        $("#addName").val(),
                        $("#addPosition").val(),
                        $("#addOffice").val(),
                        action,
                    ]);
                $("#addRowModal").modal("hide");
            });
        });
    </script>
</body>

</html>