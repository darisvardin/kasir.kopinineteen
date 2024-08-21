<?php
session_start();

include('koneksi/koneksi.php');

//cek tombol login
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $result = mysqli_query($koneksi, "SELECT * FROM ksr WHERE userksr = '$username'");

    if (mysqli_num_rows($result) == 1) {
        $hasil = mysqli_fetch_assoc($result);
        if (password_verify($password, $hasil['pwksr'])) {
            //set sesi
            $_SESSION['login']     = true;
            $_SESSION['idksr']     = $hasil['idksr'];
            $_SESSION['username']  = $hasil['userksr'];
            $_SESSION['fullname']  = $hasil['fullname'];
            $_SESSION['level']     = $hasil['level'];

            header("Location: dashboard.php");
            exit;
        }
    }
    //jika salah
    $error = true;
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>App Kasir - Login</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/logo_b.png" />
    <link rel="stylesheet" href="assets/css/login.min.css" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="assets/img/logo.png" width="150" alt="">
                                </a>
                                <h5 class="text-center form-label">Aplikasi Kasir</h5>

                                <?php if(isset($error)) :?>
                                    <div class="alert alert-danger text-center">
                                    <b>Username/Password SALAH</b>
                                </div>
                                <?php endif; ?>

                                <form action="" method="post">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username">
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="">
                                        </div>
                                    </div>
                                    <button type="submit" name="login" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Masuk</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>