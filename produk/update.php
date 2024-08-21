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

//MENAMPILKAN DATA KATEGORI
$querykategori = "SELECT  * FROM kategori ORDER BY idkategori ASC";
$kategori = mysqli_query($koneksi, $querykategori) or die(errorQuery(mysqli_error($koneksi)));
$rowkategori = mysqli_fetch_assoc($kategori);
$totalRows = mysqli_num_rows($kategori);

// //edit data
// $editFormAction = $_SERVER['PHP_SELF'];
// if (isset($_SERVER['QUERY_STRING'])) {
//   $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
// }

// if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
//   $updateSQL = sprintf(
//     "UPDATE produk SET kodeproduk =%s, kategori=%s, namaproduk=%s, hargadasar=%s, hargajual=%s, WHERE idproduk=%s",
//     inj($koneksi, $_POST['kodeproduk'], "text"),
//     inj($koneksi, $_POST['kategori'], "int"),
//     inj($koneksi, $_POST['namaproduk'], "text"),
//     inj($koneksi, $_POST['hargadasar'], "double"),
//     inj($koneksi, $_POST['hargajual'], "double"),
//     inj($koneksi, $_POST['idproduk'], "int")
//   );
//   $Result1 = mysqli_query($koneksi, $updateSQL) or die(errorQuery(mysqli_error($koneksi)));
//   if ($updateSQL) {
//     echo "<script> alert ('Data Berhasil Diubah !');
//     document.location='read.php';
//      </script>";
//   } else {
//     echo "<script> alert ('Data Gagal Diubah !');
//     document.location='read.php';
//      </script>";
//   }
// }


//MENAMPILKAN DATA YG SUDAH ADA
$id = "-1";
if (isset($_GET['id'])) {
  $id = $_GET['id'];
}

$queryproduk = sprintf("SELECT  * FROM produk WHERE idproduk = %s ORDER BY idproduk ASC", inj($koneksi, $id, "int"));
$produk = mysqli_query($koneksi, $queryproduk) or die(errorQuery(mysqli_error($koneksi)));
$rowproduk = mysqli_fetch_assoc($produk);
$totalRows = mysqli_num_rows($produk);

//update
function update_pr($update_pr)
{
  global $koneksi;

  $idproduk    = $update_pr['idproduk'];
  $kodeproduk  = htmlspecialchars($update_pr['kodeproduk']);
  $kategori    = htmlspecialchars($update_pr['kategori']);
  $namaproduk  = htmlspecialchars($update_pr['namaproduk']);
  $hargadasar  = htmlspecialchars($update_pr['hargadasar']);
  $hargajual   = htmlspecialchars($update_pr['hargajual']);

  mysqli_query($koneksi, "UPDATE produk SET
		kodeproduk = '$kodeproduk',
		kategori = '$kategori',
		namaproduk = '$namaproduk',
		hargadasar = '$hargadasar',
		hargajual = '$hargajual'
		WHERE idproduk = '$idproduk'
	");
  return mysqli_affected_rows($koneksi);
}

if (isset($_POST['update'])) :
  if (update_pr($_POST) > 0) {
    echo "<script>
      alert('Data Berhasil Disimpan !');
      document.location = 'read.php';
    </script>";
  } else {
    echo "<script>
      alert('Data Gagal Disimpan !');
      document.location = '';
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
                    <h4 class="card-title">Ubah Data Produk</h4>
                  </div>
                </div>
                <form action="" method="post">
                  <input type="hidden" name="idproduk" value="<?php echo htmlentities($rowproduk['idproduk'], ENT_COMPAT, ''); ?>">
                  <div class="card-body">
                    <div class="form-group">
                      <label>Kode Produk</label>
                      <input type="text" class="form-control" name="kodeproduk" value="<?php echo htmlentities($rowproduk['kodeproduk'], ENT_COMPAT, ''); ?>" />
                    </div>
                    <div class="form-group">
                      <label>Pilih Kategori</label><br>
                      <select class="btn btn-primary" name="kategori">
                        <?php do { ?>
                          <option value="<?php echo $rowkategori['idkategori']; ?>" <?php if (!(strcmp($rowkategori['idkategori'], htmlentities($rowproduk['kategori'], ENT_COMPAT, 'utf-8')))) {
                                                                                      echo "SELECTED";
                                                                                    } ?>>
                            <?php echo $rowkategori['namakategori']; ?></option>
                        <?php } while ($rowkategori = mysqli_fetch_assoc($kategori)); ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Nama Produk</label>
                      <input type="text" class="form-control" name="namaproduk" value="<?php echo htmlentities($rowproduk['namaproduk'], ENT_COMPAT, ''); ?>" />
                    </div>
                    <div class="form-group">
                      <label>Harga Dasar</label>
                      <input type="number" class="form-control" name="hargadasar" value="<?php echo htmlentities($rowproduk['hargadasar'], ENT_COMPAT, ''); ?>" />
                    </div>
                    <div class="form-group">
                      <label>Harga Jual</label>
                      <input type="number" class="form-control" name="hargajual" value="<?php echo htmlentities($rowproduk['hargajual'], ENT_COMPAT, ''); ?>" />
                    </div>
                    <button type="submit" name="update" class="btn btn-success">Simpan</button>
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
  <!-- Bootstrap Notify -->

</body>

</html>