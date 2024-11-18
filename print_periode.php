<?php
require_once("init.php");
helper(["auth"]);
isLogIn();
$type = (isset($_GET["type"])) ? $_GET["type"] : NULL;

$id_kategori = $_POST['id_kategori'];
$tgl_mulai = htmlspecialchars($_POST["tgl_mulai"]);
$tgl_selesai = htmlspecialchars($_POST["tgl_selesai"]);

// ambil data
if($id_kategori == "all") {
  $sql = "SELECT rekapitulasi.*, users.username, kategori.nama_kategori FROM rekapitulasi JOIN users ON rekapitulasi.id_user = users.id JOIN kategori ON rekapitulasi.id_kategori=kategori.id_kategori WHERE jenis = '$type' AND tanggal BETWEEN '$tgl_mulai' AND '$tgl_selesai' ";
} else {
  $sql = "SELECT rekapitulasi.*, users.username, kategori.nama_kategori FROM rekapitulasi JOIN users ON rekapitulasi.id_user = users.id JOIN kategori ON rekapitulasi.id_kategori=kategori.id_kategori WHERE jenis = '$type' AND rekapitulasi.id_kategori='$id_kategori' AND tanggal BETWEEN '$tgl_mulai' AND '$tgl_selesai' ";
}


$result = mysqli_query($conDB, $sql);
$data = [];
while($r = mysqli_fetch_assoc($result)) {
  $data[] = $r;
}

// ambil jumalh 
if($id_kategori == "all") {
  $sql_jumlah = "SELECT SUM(jumlah) AS jmlh FROM rekapitulasi WHERE jenis = '$type' AND tanggal BETWEEN '$tgl_mulai' AND '$tgl_selesai' ";
} else {
  $sql_jumlah = "SELECT SUM(jumlah) AS jmlh FROM rekapitulasi WHERE jenis = '$type' AND rekapitulasi.id_kategori='$id_kategori' AND tanggal BETWEEN '$tgl_mulai' AND '$tgl_selesai' ";
}
$reslut_jumlah = mysqli_query($conDB, $sql_jumlah);
$dt_jmlh = mysqli_fetch_assoc($reslut_jumlah);
$jmlh_masuk = $dt_jmlh["jmlh"];


$judul = ($type != null) ? "Laporan Kas $type" : "Laporan Keuangan";

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
      padding: 8px 12px;
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
    ' . $judul  .' Keuangan
  </h3>
  <p class="center masjid">
    Lima Benua Consultan
  </p>
  
  <div class="table">
  <table border="1" cellpadding="0" cellspacing="0" id="table" class="tbl">
    <thead>
      <tr style="width: 100%;">
        <th style="width: 5%;">No</th>
        <th style="width: 10%;">Kode</th>
        <th style="width: 10%;">Penginput</th>
        <th style="width: 10%;">Kategori</th>
        <th style="width: 25%;">Keterangan</th>
        <th style="width: 20%;">Tanggal</th>
        <th style="width: 20%;">Jumlah</th>
      </tr>
    </thead>
    <tbody> ';
    $no = 1;
    foreach ($data as $dt) {
      $content .= '
        <tr>
        <td>' . $no++ . '</td>
        <td>'. $dt["kode"] .'</td>
        <td class="left">'. $dt["username"] .'</td>
        <td class="left">'. $dt["nama_kategori"] .'</td>
        <td class="left">'. $dt["keterangan"] .'</td>
        <td>' . date("d M Y", strtotime($dt["tanggal"])) .'</td>
        <td class="right" style="text-align: right;">' . number_format($dt["jumlah"], 0, ",", ".") . ',-</td>
      </tr>
      ';
    }
      
$content .=  ' <tr>
        <td colspan="6" class="center bold">Total</td>
        <td class="right bold" style="text-align:right;">Rp ' . number_format($jmlh_masuk, 0, ",", ".") .',-</td>
      </tr>
    </tbody>
  </table>
  </div>
  <table class="tbl" border="0" style="margin-top:20px;">
    <tr>
      <td style="width:70%;"></td>
      <td style="width:30%;" class="left">
        <p>Indramayu, '. date("d F Y") .'</p>
        <p>Bendahara</p>
        <br>
        <br>
        <br>
        <p>...............</p>
      </td>
    </tr>
  </table>
  
	';

// render donpdf
require 'assets/libs/DomPdf/vendor/autoload.php';
use Dompdf\Dompdf;

$dompdf = new DOMPDF();
$dompdf->load_html($content);
$dompdf->setPaper('A4', 'potrait');
$dompdf->render();
$dompdf->stream($judul .  '.pdf');
