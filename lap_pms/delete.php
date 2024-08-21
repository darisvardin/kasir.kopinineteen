<?php require_once('../koneksi/koneksi.php');

//HAPUS DATA
if ((isset($_GET['id'])) && ($_GET['id'] != "")) {
    $deleteSQL = sprintf(
        "DELETE FROM transaksi_msk WHERE idtr=%s",
        inj($koneksi, $_GET['id'], "int")
    );
    $Result1 = mysqli_query($koneksi, $deleteSQL) or die(errorQuery(mysqli_error($koneksi)));
    if ($deleteSQL) {
        echo "<script> alert ('Data Berhasil Dihapus !');
    document.location='read.php';
     </script>";
    } else {
        echo "<script> alert ('Data Gagal Dihapus !');
    document.location='read.php';
     </script>";
    }
}
