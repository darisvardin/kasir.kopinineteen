<?php
$hostname = "localhost";
$database = "kasir";
$username = "root";
$password = "";
$koneksi = mysqli_connect($hostname, $username, $password, $database) ;
//mysqli_select_db($koneksi, $database_koneksi);

// Set timezone to Waktu Indonesia Bagian Barat (WIB)
date_default_timezone_set('Asia/Jakarta');

//fungsi sanitasi
if (!function_exists("inj")) {
    function inj($koneksi, $theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
    {
        $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

        $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($koneksi, $theValue) : mysqli_escape_string($koneksi, $theValue);

        switch ($theType) {
            case "text":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "long":
            case "int":
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                break;
            case "double":
                $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
                break;
            case "date":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "defined":
                $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
                break;
        }
        return $theValue;
    }
}

// fungsi kembali
function back()
{
    echo '<button onclick="window.history.go(-1); return false;"> Go Back</button>';
}

// fungsi menampilkan pesan kesalahan
function errorQuery($isi)
{
    // back();
    echo "<br>    
       <h4>WOW!! Ada yang salah GUYSSS</h4>
       <strong>Yang salah adalah : </strong>" . $isi . "</div>";
}
