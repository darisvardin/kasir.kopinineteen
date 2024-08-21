<?php
session_start();
// login dulu
if (!isset($_SESSION["login"])) {
    echo "<script>
        document.location.href = '../login.php';
        </script>";
    exit;
}
include('../koneksi/koneksi.php');

$queryn = "SELECT MAX(RIGHT(nota, 3)) as max_id FROM transaksi_msk ORDER BY nota";
$resultn = mysqli_query($koneksi, $queryn);
$datan = mysqli_fetch_array($resultn);
$id_max = $datan['max_id'];
$sort_num = (int) substr($id_max, 1, 3);
$sort_num++;
$new_code = sprintf("%05s", $sort_num);

$id = "-1";
if (isset($_SESSION['fullname'])) {
    $id = $_SESSION['fullname'];
}


$querykategori = mysqli_query($koneksi, "SELECT * FROM kategori");

if (isset($_GET['kategori'])) {
    $queryGetKategoriId = mysqli_query($koneksi, "SELECT idkategori FROM kategori WHERE namakategori='$_GET[kategori]'");
    $kategoriId = mysqli_fetch_array($queryGetKategoriId);
    $queryproduk = mysqli_query($koneksi, "SELECT * FROM produk WHERE kategori='$kategoriId[idkategori]'");
} else {
    $queryproduk = mysqli_query($koneksi, "SELECT * FROM produk");
}


$pilih = "-1";
if (isset($_POST['pilih'])) {
    $pilih = $_POST['pilih'];
}
$query = sprintf(
    "SELECT produk.*, namakategori FROM produk LEFT JOIN kategori ON idkategori = kategori WHERE namaproduk LIKE %s OR kodeproduk = %s ORDER BY idproduk ASC",
    inj($koneksi, $pilih, "text"),
    inj($koneksi, $pilih, "text")
);
$eksekusi = mysqli_query($koneksi, $query) or die(errorQuery(mysqli_error($koneksi)));
$row = mysqli_fetch_assoc($eksekusi);
$totalRows = mysqli_num_rows($eksekusi);

// $nota = "00001";
$periode = date('m-Y');
if ($totalRows > 0) {
    $querycek = sprintf(
        "SELECT produk FROM transaksi_sem WHERE produk = %s",
        inj($koneksi, $pilih, "text")
    );
    $cek = mysqli_query($koneksi, $querycek) or die(errorQuery(mysqli_error($koneksi)));
    $cekRows = mysqli_num_rows($cek);

    if ($cekRows > 0) {
        $updateqty = sprintf(
            "UPDATE transaksi_sem SET qty = qty + 1 WHERE produk = %s",
            inj($koneksi, $pilih, "text")
        );
        $resulqty = mysqli_query($koneksi, $updateqty) or die(errorQuery(mysqli_error($koneksi)));
    } else {
        //menyimpan data transaksi_sem
        $insertSQL = sprintf(
            "INSERT INTO `transaksi_sem`(`tanggal`, `produk`, `nama_produk`, `harga`, `harga_dasar`, `qty`) VALUES ( %s, %s, %s, %s, %s, %s)",
            inj($koneksi, date("Y-m-d"), "date"),
            inj($koneksi, $row['kodeproduk'], "text"),
            inj($koneksi, $row['namaproduk'], "text"),
            inj($koneksi, $row['hargajual'], "double"),
            inj($koneksi, $row['hargadasar'], "text"),
            inj($koneksi, 1, "int")
        );
        $Result = mysqli_query($koneksi, $insertSQL) or die(errorQuery(mysqli_error($koneksi)));
    }
}

//MENAMPILKAN DATA PEMBAYARAN
$querypem = "SELECT * FROM pembayaran ";
$eksekusipem = mysqli_query($koneksi, $querypem) or die(errorQuery(mysqli_error($koneksi)));
$rowpem = mysqli_fetch_assoc($eksekusipem);
$totalRowspem = mysqli_num_rows($eksekusipem);

// MENAMPILKAN DATA TRANSAKSI_sem
$query = "SELECT * FROM transaksi_sem ORDER BY idtr ASC";
$eksekusiSem = mysqli_query($koneksi, $query) or die(errorQuery(mysqli_error($koneksi)));
$totalRowsSem = mysqli_num_rows($eksekusiSem);

// Insert data keranjang
if (isset($_POST['bayar'])) {
    $nota = mysqli_real_escape_string($koneksi, strip_tags($_POST["nota"]));
    $tanggal = date("Y-m-d H:i:s");
    $namapembayaran = mysqli_real_escape_string($koneksi, strip_tags($_POST["namapembayaran"]));
    $pembeli = mysqli_real_escape_string($koneksi, strip_tags($_POST["pembeli"]));
    $ksr = mysqli_real_escape_string($koneksi, $_SESSION['idksr']);
    $nama_ksr = mysqli_real_escape_string($koneksi, $_SESSION['fullname']);
    $periode = date('m-Y');

    // Iterasi melalui setiap baris hasil dari transaksi_sem
    while ($rowSem = mysqli_fetch_assoc($eksekusiSem)) {
        $produk = mysqli_real_escape_string($koneksi, strip_tags($rowSem["produk"]));
        $nama_produk = mysqli_real_escape_string($koneksi, strip_tags($rowSem["nama_produk"]));
        $harga = mysqli_real_escape_string($koneksi, strip_tags($rowSem["harga"]));
        $hargadasar = mysqli_real_escape_string($koneksi, strip_tags($rowSem["harga_dasar"]));
        $qty = mysqli_real_escape_string($koneksi, strip_tags($_POST["qty"]));

        // Validasi jumlah produk tidak boleh 0
        if ($qty <= 0) {
            echo "<script>
                alert('Jumlah produk tidak boleh kosong!');
                document.location = 'order.php'; // Kembali ke halaman sebelumnya
            </script>";
            exit; // Hentikan proses jika jumlah produk 0 atau kurang
        }

        $stmt = $koneksi->prepare("INSERT INTO transaksi_msk (nota, tanggal, produk, nama_produk, harga, harga_dasar, qty, namapembayaran, pembeli, ksr, nama_ksr, periode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssss", $nota, $tanggal, $produk, $nama_produk, $harga, $hargadasar, $qty, $namapembayaran, $pembeli, $ksr, $nama_ksr, $periode);

        if (!$stmt->execute()) {
            echo "<script>
                alert('Data Gagal Disimpan!');
                document.location = 'order.php';
            </script>";
            exit;
        }

        $stmt->close();
    }

    echo "<script>
        alert('Data Berhasil Disimpan!');
        document.location = 'print.php?nota=$nota';
    </script>";
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


    <link rel="stylesheet" href="../assets/css/semlate.css" />
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
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card">
                                <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                                    <h4 class="card-title mb-0">Kategori</h4>
                                    <button class="btn btn-primary btn-round ms-auto fs-4" data-bs-toggle="modal" data-bs-target="#modal">
                                        <i class="fas fa-cart-arrow-down"></i> Keranjang
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-12 col-sm-auto">
                                            <form action="order.php" method="get">
                                                <button type="submit" class="btn btn-secondary btn-round fs-5 w-100 mb-2">Semua</button>
                                            </form>
                                        </div>
                                        <?php while ($rowkategori = mysqli_fetch_array($querykategori)) { ?>
                                            <div class="col-12 col-sm-auto">
                                                <form action="order.php" method="get">
                                                    <input type="hidden" name="kategori" value="<?= $rowkategori['namakategori']; ?>">
                                                    <button type="submit" class="btn btn-secondary btn-round fs-5 w-100 mb-2"><?= $rowkategori['namakategori']; ?></button>
                                                </form>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <style>
                                @media (max-width: 768px) {
                                    .btn-round {
                                        font-size: 1rem;
                                    }
                                }

                                @media (max-width: 576px) {
                                    .btn-round {
                                        width: 100%;
                                    }
                                }
                            </style>


                            <div class="card">
                                <div class="card-header d-flex align-items-center">
                                    <h4 class="card-title mb-0">Produk</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <?php while ($rowproduk = mysqli_fetch_array($queryproduk)) { ?>
                                            <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                                                <div class="card h-200 border rounded bg-success ">
                                                    <form method="post" action="">
                                                        <div class="card-body text-center">
                                                            <h4 class="card-title mb-2 text-white text-truncate-2  "><?php echo $rowproduk['namaproduk']; ?></h4>
                                                            <h6 class="card-subtitle mb-2 text-light">- <?php echo $rowproduk['kodeproduk']; ?> -</h6>
                                                            <h5 class="card-text text-white">Rp. <?php echo number_format($rowproduk['hargajual'], 0, ',', '.'); ?></h5>
                                                            <input type="hidden" name="pilih" id="pilih" value="<?= $rowproduk['kodeproduk'] ?>">
                                                        </div>
                                                        <div class="card-footer text-center">
                                                            <button type="submit" class="btn btn-primary w-100">Pilih</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <style>
                                .text-truncate-2 {
                                    display: -webkit-box;
                                    -webkit-line-clamp: 2;
                                    -webkit-box-orient: vertical;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                    white-space: normal;
                                }
                            </style>


                        </div>
                    </div>
                </div>


                <div class="modal " id="modal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">Keranjang</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" method="post" name="bayar">

                                <!-- HTML untuk menampilkan data dari transaksi_sem -->
                                <?php if ($totalRowsSem > 0) { ?>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="">No. Nota:</label>
                                            <input type="text" name="nota" value="<?php echo $new_code ?>" class="form-control" readonly>
                                        </div> <br>
                                        <div class="table-responsive">
                                            <table class="display table table-striped table-bordered">
                                                <thead>
                                                    <th>No</th>
                                                    <th>Produk</th>
                                                    <th>Harga</th>
                                                    <th>Jumlah</th>
                                                    <th>Aksi</th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    $total = 0;
                                                    // Fetch all data and display in the table
                                                    mysqli_data_seek($eksekusiSem, 0); // Reset pointer to the beginning
                                                    while ($rowSem = mysqli_fetch_assoc($eksekusiSem)) { ?>
                                                        <tr>
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $rowSem['nama_produk']; ?></td>
                                                            <td>Rp. <?php echo number_format($rowSem['harga'], 0, ',', '.'); ?></td>
                                                            <td><input type="number" name="qty" value="<?php echo $rowSem['qty']; ?>" style="width: 120px;" class="form-control qty" data-harga="<?php echo $rowSem['harga']; ?>"></td>
                                                            <td><a class="btn btn-danger" href="delete.php?id=<?php echo $rowSem['idtr']; ?>">Hapus</a></td>
                                                        </tr>
                                                    <?php
                                                        $harga = $rowSem['qty'] * $rowSem['harga'];
                                                        $total += $harga;
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <h4>Total Belanja: Rp. <span id="total-belanja"><?php echo number_format($total); ?></span></h4>
                                        <div class="form-group">
                                            <label for="">Nama Pelanggan:</label>
                                            <input type="text" name="pembeli" value="" class="form-control" placeholder="Masukkan nama pelanggan">
                                        </div>

                                        <div class="modal-footer">
                                            <label>Pilih Pembayaran:</label><br>
                                            <div class="row">
                                                <div class="col-sm">
                                                    <select class="btn btn-primary my-1" name="namapembayaran">
                                                        <?php do { ?>
                                                            <option value="<?php echo $rowpem['namapembayaran']; ?>"><?php echo $rowpem['namapembayaran']; ?></option>
                                                        <?php } while ($rowpem = mysqli_fetch_assoc($eksekusipem)); ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm">
                                                    <button type="submit" name="bayar" class="btn btn-success my-1">Bayar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <br>
                                    <div class="form-group text-center">
                                        <h3>Keranjang masih kosong</h3>
                                    </div><br>
                                <?php } ?>

                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    // Menghitung total belanja ketika jumlah diubah
                    document.querySelectorAll('.qty').forEach(function(element) {
                        element.addEventListener('input', function() {
                            let total = 0;
                            document.querySelectorAll('.qty').forEach(function(qtyElement) {
                                let harga = parseFloat(qtyElement.getAttribute('data-harga'));
                                let qty = parseInt(qtyElement.value);
                                total += harga * qty;
                            });
                            document.getElementById('total-belanja').innerText = total.toLocaleString('id-ID');
                        });
                    });
                </script>

            </div>
        </div>
    </div>

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