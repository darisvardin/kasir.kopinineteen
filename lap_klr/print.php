<?php ob_start(); ?>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Cetak Laporan</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="../assets/img/logo_b.png" type="image/x-icon" />

    <style>
        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 100px;
        }

        .header h4 {
            margin: 10px 0;
            font-size: 20px;
            font-weight: bold;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 20px;
            text-align: center;
            font-size: 12px;
        }

        .table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tr:hover {
            background-color: #f1f1f1;
        }

        .total {
            margin-top: 20px;
            font-size: 14px;
            font-weight: bold;
            text-align: left;
        }

        @media print {
            body {
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <?php
    include "../koneksi/koneksi.php";

    $tgl_awal = @$_GET['tgl_awal'];
    $tgl_akhir = @$_GET['tgl_akhir'];

    if (empty($tgl_awal) or empty($tgl_akhir)) {
        $query = "SELECT * FROM pengeluaran";
        $label = "Semua Data Transaksi Pengeluaran";
    } else {
        $query = "SELECT * FROM pengeluaran WHERE (tgl BETWEEN '" . $tgl_awal . "' AND '" . $tgl_akhir . "')";
        $tgl_awal = date('d-m-Y', strtotime($tgl_awal)); // Format tanggal dd-mm-yyyy
        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir)); // Format tanggal dd-mm-yyyy
        $label = 'Periode ' . $tgl_awal . ' s/d ' . $tgl_akhir;
    }
    ?>

    <div class="header">
        <img src="../assets/img/logo.png" alt="Logo">
        <h4>Laporan Transaksi Pengeluaran</h4>
    </div>

    <h4 style="text-align: center;"><?php echo $label; ?></h4>

    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Keterangan</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Nominal</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $eksekusi = mysqli_query($koneksi, $query);
            $totalRows = mysqli_num_rows($eksekusi);
            $no = 1;
            $grand_total = 0; // Initialize grand total variable
            $total_qty = 0;   // Initialize total quantity variable

            while ($row = mysqli_fetch_assoc($eksekusi)) {
                $tgl = date('d-m-Y', strtotime($row['tgl']));
                $grand_total += $row['nominal']; // Accumulate grand total
                $total_qty += $row['qty'];       // Accumulate total quantity
            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['ket']; ?></td>
                    <td><?php echo $tgl; ?></td>
                    <td><?php echo $row['qty']; ?></td>
                    <td><?php echo number_format($row['nominal'], 0, ',', '.'); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="total">
        Grand Total Pengeluaran: Rp. <?php echo number_format($grand_total, 0, ',', '.'); ?><br> <br>
        Total Jumlah Item: <?php echo number_format($total_qty); ?>
    </div>
</body>

</html>
<?php
$html = ob_get_contents();
ob_end_clean();

require '../html2pdf/autoload.php';

$pdf = new Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'en');
$pdf->WriteHTML($html);
$pdf->Output('Laporan Pengeluaran.pdf', 'I');
?>