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

//MENAMPILKAN DATA
$query = "SELECT * FROM kategori ORDER BY idkategori ASC";
$eksekusi = mysqli_query($koneksi, $query) or die(errorQuery(mysqli_error($koneksi)));
$row = mysqli_fetch_assoc($eksekusi);
$totalRows = mysqli_num_rows($eksekusi);

//tambah
if (isset($_POST['tambah'])) {
  $kodeproduk    = htmlentities($_POST['kodeproduk']);
  $kategori      = htmlentities($_POST['kategori']);
  $namaproduk    = htmlentities($_POST['namaproduk']);
  $hargadasar    = htmlentities($_POST['hargadasar']);
  $hargajual     = htmlentities($_POST['hargajual']);

  $queryt = mysqli_query($koneksi, "INSERT INTO produk VALUES ('', '$kodeproduk', '$kategori','$namaproduk', '$hargadasar', '$hargajual')");

  if ($queryt) {
    echo "<script> alert ('Data Berhasil Disimpan !');
      document.location='read.php';
      </script>";
  } else {
    echo "<script> alert ('Data Gagal Disimpan !');
      document.location='';
     </script>";
  }
}

// //SIMPAN DATA
// $editFormAction = $_SERVER['PHP_SELF'];
// if (isset($_SERVER['QUERY_STRING'])) {
//   $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
// }

// if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
//   $insertSQL = sprintf(
//     "INSERT INTO produk (kodeproduk, kategori, namaproduk, hargadasar, hargajual, ) VALUES (%s, %s, %s, %s, %s)",
//     inj($koneksi, $_POST['kodeproduk'], "text"),
//     inj($koneksi, $_POST['kategori'], "int"),
//     inj($koneksi, $_POST['namaproduk'], "text"),
//     inj($koneksi, $_POST['hargadasar'], "double"),
//     inj($koneksi, $_POST['hargajual'], "double"),
//   );
//   $Result1 = mysqli_query($koneksi, $insertSQL) or die(errorQuery(mysqli_error($koneksi)));
//   if ($insertSQL) {
//     echo "<script> alert ('Data Berhasil Disimpan !');
//     document.location='read.php';
//      </script>";
//   } else {
//     echo "<script> alert ('Data Gagal Disimpan !');
//     document.location='read.php';
//      </script>";
//   }
// }
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

            <li class="nav-item active submenu">
              <a data-bs-toggle="collapse" href="#tables">
                <i class="fas fa-layer-group"></i>
                <p>Produk</p>
                <span class="caret"></span>
              </a>
              <div class="collapse show" id="tables">
                <ul class="nav nav-collapse">
                  <li class="active">
                    <a href="../produk/read.php">
                      <span class="sub-item">Daftar Produk</span>
                    </a>
                  </li>
                  <?php if ($_SESSION['level'] == 'Admin') : ?>
                    <li>
                      <a href="../kategori/read.php">
                        <span class="sub-item">Kategori Produk</span>
                      </a>
                    </li>
                  <?php endif ?>
                </ul>
              </div>
            </li>
            <?php if ($_SESSION['level'] == 'Admin') : ?>
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
                <div class="card-header">
                  <div class="d-flex align-items-center">
                    <h4 class="card-title">Tambah Data Produk</h4>
                  </div>
                </div>
                <form action="" method="POST">
                  <div class="card-body">
                    <div class="form-group">
                      <label>Kode Produk</label>
                      <input type="text" class="form-control" name="kodeproduk" placeholder="Masukan Kode Produk" required />
                    </div>
                    <div class="form-group">
                      <label>Pilih Kategori</label><br>
                      <select class="btn btn-primary fs-5" name="kategori" required>
                        <?php do { ?>
                          <option class="btn-secondary fs-5" value="<?php echo $row['idkategori']; ?>"><?php echo $row['namakategori']; ?></option>
                        <?php } while ($row = mysqli_fetch_assoc($eksekusi)); ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Nama Produk</label>
                      <input type="text" class="form-control" name="namaproduk" placeholder="Masukan Nama Produk" required />
                    </div>
                    <div class="form-group">
                      <label>Harga Dasar</label>
                      <input type="number" class="form-control" name="hargadasar" placeholder="Masukan Harga Dasar" />
                    </div>
                    <div class="form-group">
                      <label>Harga Jual</label>
                      <input type="number" class="form-control" name="hargajual" placeholder="Masukan Harga Jual" required />
                    </div>
                    <button type="submit" name="tambah" class="btn btn-success">Simpan</button>
                    <a href="read.php" class="btn btn-danger">Kembali</a>
                  </div>
                </form>
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

</body>

</html>