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


$id = "-1";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}


// MENAMPILKAN DATA
$query = sprintf("SELECT  * FROM transaksi_msk WHERE idtr = %s ORDER BY idtr ASC", inj($koneksi, $id, "int"));
$ekse = mysqli_query($koneksi, $query) or die(errorQuery(mysqli_error($koneksi)));
$row = mysqli_fetch_assoc($ekse);
$totalRows = mysqli_num_rows($ekse);


function update_pms($update_pms)
{
    global $koneksi;
    $idtr            = $update_pms['idtr'];
    $nota            = htmlspecialchars($update_pms['nota']);
    $tanggal         = htmlspecialchars($update_pms['tanggal']);
    $produk          = htmlspecialchars($update_pms['produk']);
    $nama_produk     = htmlspecialchars($update_pms['nama_produk']);
    $qty             = htmlspecialchars($update_pms['qty']);
    $namapembayaran  = htmlspecialchars($update_pms['namapembayaran']);
    $pembeli     = htmlspecialchars($update_pms['pembeli']);
    $ksr     = htmlspecialchars($update_pms['ksr']);
    $nama_ksr     = htmlspecialchars($update_pms['nama_ksr']);
    $periode     = htmlspecialchars($update_pms['periode']);


    mysqli_query($koneksi, "UPDATE transaksi_msk SET
		nota = '$nota',
		tanggal = '$tanggal', 
        produk ='$produk',
        nama_produk ='$nama_produk',
		qty = '$qty',
		namapembayaran = '$namapembayaran',
		pembeli = '$pembeli',
		ksr = '$ksr',
		nama_ksr = '$nama_ksr',
		periode = '$periode'
		WHERE idtr = '$idtr'
	");
    return mysqli_affected_rows($koneksi);
}

if (isset($_POST['update'])) :
    if (update_pms($_POST) > 0) {
        echo "<script>
      alert('Data Berhasil Disimpan !');
      document.location = 'read.php';
    </script>";
    } else {
        echo "<script>
      alert('Data Gagal Disimpan !');
      document.location = 'read.php';
    </script>";
    }
endif
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
                                        <a href="../produk/read.php">
                                            <span class="sub-item">produk Produk</span>
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
                                    <li class="active">
                                        <a href="read.php">
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Ubah Data Laporan Pemasukan</h4>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <form action="" name="form1" method="post">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Nota</label>
                                                <input type="text" class="form-control" name="nota" value="<?= $row['nota'] ?>" readonly />
                                            </div>

                                            <input type="hidden" class="form-control" name="tanggal" value="<?= $row['tanggal'] ?>" readonly />
                                            <input type="hidden" class="form-control" name="produk" value="<?= $row['produk'] ?>" readonly />

                                            <div class="form-group">
                                                <label>Nama Produk</label>
                                                <input type="text" class="form-control" name="nama_produk" value="<?= $row['nama_produk'] ?>" readonly />
                                            </div>
                                            <div class="form-group">
                                                <label>Harga</label>
                                                <input type="text" name="harga" class="form-control" value="<?= $row['harga'] ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Jumlah</label>
                                                <input type="number" class="form-control" name="qty" value="<?= $row['qty'] ?>" />
                                            </div>

                                            <input type="hidden" class="form-control" name="namapembayaran" value="<?= $row['namapembayaran'] ?>" />
                                            <input type="hidden" class="form-control" name="pembeli" value="<?= $row['pembeli'] ?>" />
                                            <input type="hidden" name="periode" value="<?= $row['periode'] ?>">
                                            <input type="hidden" name="nama_ksr" value="<?= $row['nama_ksr'] ?>">
                                            <input type="hidden" name="ksr" value="<?= $row['ksr'] ?>">
                                            <button type="submit" name="update" class="btn btn-success" id="displayNotif">Simpan</button>
                                            <a href="read.php" class="btn btn-danger">Kembali</a>
                                        </div>
                                        <input type="hidden" name="idtr" value="<?= $row['idtr'] ?>">
                                    </form>

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