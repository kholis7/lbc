<?php
require_once("init.php");
helper(["auth"]);
isLogIn();

$tgl_mulai = (isset($_POST["tgl_mulai"])) ? $_POST["tgl_mulai"] : null;
$tgl_selesai = (isset($_POST["tgl_selesai"])) ? $_POST["tgl_selesai"] : null;
$id_kategori = (isset($_POST["id_kategori"])) ? $_POST["id_kategori"] : null;


if ($tgl_mulai == null) {
  $sql = "SELECT rekapitulasi.*, users.username, kategori.nama_kategori FROM rekapitulasi JOIN users ON rekapitulasi.id_user=users.id JOIN kategori ON rekapitulasi.id_kategori=kategori.id_kategori  ORDER BY tanggal DESC";
  $sql_total = "SELECT SUM(jumlah) as jmlh FROM rekapitulasi GROUP BY jenis ORDER BY jenis ASC";
} else {
  if($id_kategori == "all") {
    $sql = "SELECT rekapitulasi.*, users.username, kategori.nama_kategori FROM rekapitulasi JOIN users ON rekapitulasi.id_user=users.id JOIN kategori ON rekapitulasi.id_kategori=kategori.id_kategori WHERE tanggal BETWEEN '$tgl_mulai' AND '$tgl_selesai' ORDER BY tanggal DESC";
    $sql_total = "SELECT SUM(jumlah) as jmlh FROM rekapitulasi WHERE tanggal BETWEEN '$tgl_mulai' AND '$tgl_selesai' GROUP BY jenis ORDER BY jenis ASC";
  } else {
    $sql = "SELECT rekapitulasi.*, users.username, kategori.nama_kategori FROM rekapitulasi JOIN users ON rekapitulasi.id_user=users.id JOIN kategori ON rekapitulasi.id_kategori=kategori.id_kategori WHERE rekapitulasi.id_kategori='$id_kategori' AND tanggal BETWEEN '$tgl_mulai' AND '$tgl_selesai' ORDER BY tanggal DESC";
    $sql_total = "SELECT SUM(jumlah) as jmlh FROM rekapitulasi WHERE rekapitulasi.id_kategori='$id_kategori' AND tanggal BETWEEN '$tgl_mulai' AND '$tgl_selesai' GROUP BY jenis ORDER BY jenis ASC";
  }
}

// ambil data
$result = mysqli_query($conDB, $sql);
$data = [];
while ($r = mysqli_fetch_assoc($result)) {
  $data[] = $r;
}
// var_dump($data); die;
// ambil total
$result_total = mysqli_query($conDB, $sql_total);
$data_total = [];
while ($r = mysqli_fetch_assoc($result_total)) {
  $data_total[] = $r;
}
if(!empty($data_total)) {
  $total_masuk = $data_total[0]["jmlh"];
  $total_keluar = $data_total[1]["jmlh"];
  $sisa_saldo = $total_masuk - $total_keluar;
} else {
  $total_masuk = 0;
  $total_keluar = 0;
  $sisa_saldo = 0;
}


$content = '
  <style type="text/css" media="all">
    * {
      margin: 0;
      padding: 0;
    }

    body {
      padding: 20px;
    }

    .judul {
      margin-top: 10px;
    }

    .masjid {
      margin-top: 5px;
      margin-bottom: 15px;
    }
    table tr th{
      padding : 10px 15px;
      text-align : center;
      background : #eee;
    }
    .center {
      text-align: center;
    }
    .left{
      text-align: left!important;
    }
    .right{
      text-align: right!important;
    }
    .w-100 {
      width: 100%;
    }
    table.tbl{
      width: 100%;
    }
    table tr td{
      padding:4px;
      text-align: center;
    }
    .bold{
      font-weight: bold;
      font-size: 15px;
    }
    #ket{
      float: right;
      margin-top: 20px;
    }
  </style>

  <h3 class="center judul">
    Laporan Rekapitulasi Keuangan
  </h3>
  <p class="center masjid">
    Lima Benua Consultan
  </p>
  <div class="table">
  <table border="1" cellpadding="0" cellspacing="0" id="table" class="tbl" width="100">
    <thead>
      <tr style="width: 100%;">
        <th style="width: 2%;">No</th>
        <th style="width: 3%;">Kode</th>
        <th style="width: 8%;">Penginput</th>
        <th style="width: 7%;">Kategori</th>
        <th style="width: 15%;">Keterangan</th>
        <th style="width: 15%;">Tanggal</th>
        <th style="width: 15%;">Masuk</th>
        <th style="width: 30%;">Keluar</th>
      </tr>
    </thead>
    <tbody> ';
$no = 1;
foreach ($data as $dt) {
  $content .= '
        <tr>
        <td>' . $no++ . '</td>
        <td>' . $dt["kode"] . '</td>
        <td>' . $dt["username"] . '</td>
        <td>' . $dt["nama_kategori"] . '</td>
        <td class="left">' . $dt["keterangan"] . '</td>
        <td>' . date("d M Y", strtotime($dt["tanggal"])) . '</td>
        <td style="text-align: right;">';
  if ($dt["jenis"] == "masuk") {
    $content .= number_format($dt["jumlah"], 0, ',', '.') . ',-';
  } else {
    $content .= '0,-';
  }
  $content .= '</td><td style="text-align:right;">';
  if ($dt["jenis"] == "keluar") {
    $content .= number_format($dt["jumlah"], 0, ',', '.') . ',-';
  } else {
    $content .= '0,-';
  }
  $content .= '</td>
        </tr>
      ';
}

$content .= ' <tr>
        <td colspan="6" class="center bold" style="padding:10px;">Total</td>
        <td class="right bold" style="text-align:right; padding : 10px;">Rp ' . number_format($total_masuk, 0, ",", ".") . ',-</td>
        <td class="right bold" style="text-align:right; padding:10px;">Rp ' . number_format($total_keluar, 0, ",", ".") . ',-</td>
      </tr>';
if ($sisa_saldo > 0) {

  $content .= '<tr>
        <td colspan="6" class="center bold" style="padding:10px;">
         Sisa Saldo Akhir
        </td>
        <td colspan="2" class="center bold" style="padding:10px;">
         Rp ' . number_format($sisa_saldo, 0, ",", ".") . ',-
        </td>
      </tr>';
}
$content .= '</tbody>
  </table>
  </div>
  <table class="tbl" border="0" style="margin-top:20px;">
    <tr style="width : 100%; ">
      <td style="width:70%;"></td>
      <td style="width:30%;" class="left">
        <p>Indramayu, ' . date("d F Y") . '</p>
        <p>Bendahara</p>
        <br>
        <br>
        <br>
        <p>...............</p>
      </td>
    </tr>
  </table>
	';

// echo $content;
// die;
// dompdf
require 'assets/libs/DomPdf/vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new DOMPDF();
$dompdf->load_html($content);
$dompdf->setPaper('A4', 'potrait');
$dompdf->render();
$dompdf->stream('rekapitulasi.pdf');
