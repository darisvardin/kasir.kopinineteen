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


//edit data
if (isset($_POST['ubah'])) {
  $idksr    = strip_tags($_POST['idksr']);
  $userksr  = strip_tags($_POST['userksr']);
  $pwksr    = strip_tags($_POST['pwksr']);
  $fullname = strip_tags($_POST['fullname']);
  $jkksr    = strip_tags($_POST['jkksr']);
  $level    = strip_tags($_POST['level']);

  $pwksr = password_hash($pwksr, PASSWORD_DEFAULT);

  $queryu = mysqli_query($koneksi, "UPDATE ksr SET userksr = '$userksr', pwksr = '$pwksr', fullname = '$fullname', jkksr = '$jkksr', level = '$level' WHERE idksr = $idksr ");
  // mysqli_query($koneksi, $queryt);
  // return mysqli_affected_rows($koneksi);

  if ($queryu) {
    echo "<script> alert ('Data Berhasil Disimpan !');
      document.location='read.php';
      </script>";
  } else {
    echo "<script> alert ('Data Gagal Disimpan !');
      document.location='';
     </script>";
  }
}

//MENAMPILKAN DATA
$id = "-1";
if (isset($_GET['id'])) {
  $id = $_GET['id'];
}

$query = sprintf("SELECT  * FROM ksr WHERE idksr = %s ORDER BY idksr ASC", inj($koneksi, $id, "int"));
$eksekusi = mysqli_query($koneksi, $query) or die(errorQuery(mysqli_error($koneksi)));
$row = mysqli_fetch_assoc($eksekusi);
$totalRows = mysqli_num_rows($eksekusi);
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
            <li class="nav-item submenu">
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
            <li class="nav-item active">
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
                    <h4 class="card-title">Ubah Data User</h4>
                  </div>
                </div>
                <form action="" method="POST">
                  <div class="card-body">
                    <input type="hidden" name="idksr" value="<?php echo htmlentities($row['idksr'], ENT_COMPAT, ''); ?>">
                    <div class="form-group">
                      <label>Username</label>
                      <input type="text" class="form-control" name="userksr" value="<?php echo htmlentities($row['userksr'], ENT_COMPAT, ''); ?>" required />
                    </div>
                    <div class="form-group">
                      <label>Password <small>(Masukkan password baru/lama)</small></label>
                      <input type="password" class="form-control" name="pwksr" placeholder="Minimal 5 Karakter" required minlength="5" />
                    </div>
                    <div class="form-group">
                      <label>Nama Lengkap</label>
                      <input type="text" class="form-control" name="fullname" value="<?php echo htmlentities($row['fullname'], ENT_COMPAT, ''); ?>" required />
                    </div>
                    <div class="form-group">
                      <label>Jenis Kelamin</label><br>
                      <input type="radio" name="jkksr" value="L" <?php if (!(strcmp($row['jkksr'], "L"))) {
                                                                    echo "CHECKED";
                                                                  } ?> />Laki-laki <br>
                      <input type="radio" name="jkksr" value="P" <?php if (!(strcmp($row['jkksr'], "P"))) {
                                                                    echo "CHECKED";
                                                                  } ?> />Perempuan
                    </div>
                    <div class="form-group">
                      <label>Level</label>
                      <select name="level" id="level" class="form-control" required>
                        <?php $level = $row['level']; ?>
                        <option value="Admin" <?= $level == 'Admin' ? 'selected' : null ?>>Admin</option>
                        <option value="Kasir" <?= $level == 'Kasir' ? 'selected' : null ?>>Kasir</option>
                      </select>
                    </div>
                    <button type="submit" name="ubah" class="btn btn-success">Simpan</button>
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