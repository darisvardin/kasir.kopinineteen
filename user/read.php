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

// function tambah_akun($data_user)
// {
//   global $koneksi;
//   $userksr  = strip_tags($data_user['userksr']);
//   $pwksr    = strip_tags($data_user['pwksr']);
//   $fullname = strip_tags($data_user['fullname']);
//   $jkksr    = strip_tags($data_user['jkksr']);
//   $level    = strip_tags($data_user['level']);

//   $pwksr = password_hash($pwksr, PASSWORD_DEFAULT);

//   $queryt = "INSERT INTO ksr (`idksr`, `userksr`, `pwksr`, `pwksr`, `jkksr`, `level`) VALUES ('', '$userksr', '$pwksr', '$jkksr', '$level')";
//   mysqli_query($koneksi, $queryt);
//   return mysqli_affected_rows($koneksi);
// }


//tambah
if (isset($_POST['tambah_user'])) {
  $userksr  = strip_tags($_POST['userksr']);
  $pwksr    = strip_tags($_POST['pwksr']);
  $fullname = strip_tags($_POST['fullname']);
  $jkksr    = strip_tags($_POST['jkksr']);
  $level    = strip_tags($_POST['level']);

  $pwksr = password_hash($pwksr, PASSWORD_DEFAULT);

  $queryt = mysqli_query($koneksi, "INSERT INTO ksr VALUES ('', '$userksr', '$pwksr','$fullname', '$jkksr', '$level')");
  // mysqli_query($koneksi, $queryt);
  // return mysqli_affected_rows($koneksi);

  if ($queryt) {
    echo "<script> alert ('Data Berhasil Disimpan !');
      document.location='';
      </script>";
  } else {
    echo "<script> alert ('Data Gagal Disimpan !');
      document.location='';
     </script>";
  }
}


//MENAMPILKAN DATA
$query = "SELECT  * FROM ksr ORDER BY idksr ASC ";
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
                  <li>
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
                    <h4 class="card-title">Daftar User</h4>
                    <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#modal">
                      <i class="fa fa-plus"></i>
                      Tambah Data
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <?php if ($totalRows > 0) { ?>
                      <table id="add-row" class="display table table-striped table-hover">
                        <thead>
                          <tr>
                            <th style="width: 10%">No.</th>
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Jenis Kelamin</th>
                            <th>Level</th>
                            <th style="width: 10%">Aksi</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th>No.</th>
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Jenis Kelamin</th>
                            <th>Level</th>
                            <th>Aksi</th>
                          </tr>
                        </tfoot>
                        <tbody>
                          <?php $no = 1;
                          do { ?>
                            <tr>
                              <td><?php echo $no++; ?></td>
                              <td><?php echo $row['userksr']; ?></td>
                              <td><?php echo $row['fullname']; ?></td>
                              <td><?php echo $row['jkksr']; ?></td>
                              <td><?php echo $row['level']; ?></td>
                              <td>
                                <div class="form-button-action ">
                                  <button onclick="document.location='update.php?id=<?php echo $row['idksr']; ?>'" type=" button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                                    <i class="fa fa-edit">
                                    </i>
                                  </button>
                                  <a href="delete.php?id=<?php echo $row['idksr']; ?>" onclick="return confirm('Apakah anda yakin akan menghapus data ?')" type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                                    <i class="fa fa-times"></i>
                                  </a>
                                </div>
                              </td>
                            </tr>
                          <?php } while ($row = mysqli_fetch_assoc($eksekusi)); ?>
                        </tbody>
                      </table>
                    <?php } else {
                      echo "Data Tidak Tersedia !";
                    } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal" id="modal" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Data User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="" method="post">
                  <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="userksr" id="userksr" class="form-control" placeholder="Masukkan Username" required>
                  </div>
                  <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="pwksr" id="pwksr" class="form-control" placeholder="Minimal 5 Karakter" required minlength="5">
                  </div>
                  <div class="mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="fullname" id="fullname" class="form-control" required>
                  </div>
                  <div class="mb-3">
                    <label>Jenis Kelamin</label><br>
                    <select name="jkksr" id="jkksr" class="form-control" required>
                      <option value="">-- pilih jenis kelamin --</option>
                      <option value="L">Laki-laki</option>
                      <option value="P">Perempuan</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label>Level</label>
                    <select name="level" id="level" class="form-control" required>
                      <option value="">-- pilih level --</option>
                      <option value="Admin">Admin</option>
                      <option value="Kasir">Kasir</option>
                    </select>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                <button type="submit" name="tambah_user" class="btn btn-success">Simpan</button>
              </div>
              </form>
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