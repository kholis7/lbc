<?php
require_once("init.php");
helper(["flasher", "auth"]);
$act = "rekap";
isLogIn();
$dataLogin = getDataLogin();

// ambil semua data nya dulu
$sql = "SELECT rekapitulasi.*, users.username, kategori.nama_kategori FROM rekapitulasi JOIN users ON rekapitulasi.id_user=users.id JOIN kategori ON rekapitulasi.id_kategori=kategori.id_kategori ORDER BY tanggal DESC";
$result = mysqli_query($conDB, $sql);
$data = [];
while ($r = mysqli_fetch_assoc($result)) {
  $data[] = $r;
}

// ambil data kategori
$result = mysqli_query($conDB, "SELECT * FROM kategori");
$data_kategori = [];
while ($r = mysqli_fetch_assoc($result)) {
  $data_kategori[] = $r;
}

// ambil jumalh Saldo masuk dan keluar
$sql_total = "SELECT SUM(jumlah) as jmlh FROM rekapitulasi GROUP BY jenis ORDER BY jenis ASC";
$result_total = mysqli_query($conDB, $sql_total);
$data_total = [];
while ($r = mysqli_fetch_assoc($result_total)) {
  $data_total[] = $r;
}
$total_masuk = $data_total[0]["jmlh"];
$total_keluar = $data_total[1]["jmlh"];
$sisa_saldo = $total_masuk - $total_keluar;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Rekapitulasi</title>

  <?php require_once("layout/header.php"); ?>

</head>

<body id="page-top">

  <div id="wrapper">
    <!-- Sidebar -->
    <?php require_once("layout/sidebar.php"); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php require_once("layout/topbar.php"); ?>
        <!-- End of Topbar -->


        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                Rekapitulasi
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped tbl" id="tbl" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kode</th>
                      <th>Penginput</th>
                      <th>Kategori</th>
                      <th>Keterangan</th>
                      <th>Tanggal</th>
                      <th>Jenis</th>
                      <th>Masuk</th>
                      <th>Keluar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($data as $dt) : ?>
                      <tr>
                        <td>
                          <?= $no++; ?>
                        </td>
                        <td>
                          <?= $dt["kode"]; ?>
                        </td>
                        <td>
                          <?= $dt["username"]; ?>
                        </td>
                        <td>
                          <?= $dt["nama_kategori"]; ?>
                        </td>
                        <td>
                          <?= $dt["keterangan"]; ?>
                        </td>
                        <td>
                          <?= date("d-M-Y", strtotime($dt["tanggal"])); ?>
                        </td>
                        <td>
                          <?= $dt["jenis"]; ?>
                        </td>
                        <td class="text-right">
                          <?= number_format(($dt["jenis"] == "masuk") ? $dt["jumlah"] : 0, 0, ",", ".") ?>
                        </td>
                        <td class="text-right">
                          <?= number_format(($dt["jenis"] == "keluar") ? $dt["jumlah"] : 0, 0, ",", ".") ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td class="text-center font-weight-bold" colspan="7">
                        Total Uang Masuk
                      </td>
                      <td class="text-right font-weight-bold">
                        Rp <?= number_format($total_masuk, 0, ",", "."); ?>
                      </td>
                      <td class="text-right font-weight-bold">
                        Rp <?= number_format($total_keluar, 0, ",", "."); ?>
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <hr>
              <!-- button tambah & print -->
              <div class="row">
                <div class="col">
                  <button type="button" class="btn border btn-white" data-toggle="modal" data-target="#modalPrint">
                    <i class="fas fa-print mr-1"></i>
                    Print
                  </button>
                </div>
              </div>
              <!-- end tanbah & print -->
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

        <!-- modal print -->
        <div class="modal fade" id="modalPrint" tabindex="-1" aria-labelledby="printLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="printLabel">
                  Laporan Keuangan
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <!-- form -->
                <form action="<?= base_url('/print_rekap.php'); ?>" method="post">
                  <div class="form-group">
                    <label for="tgl_mulai">
                      Dari Tanggal
                    </label>
                    <input type="date" class="form-control" name="tgl_mulai" required>
                  </div>
                  <div class="form-group">
                    <label for="tgl_selesai">
                      Sampai Tanggal
                    </label>
                    <input type="date" class="form-control" name="tgl_selesai" required>
                  </div>
                  <div class="form-group">
                    <label for="id_kategori">
                      Nama Kategori
                    </label>
                    <select name="id_kategori" id="id_kategori" class="form-control">
                      <option value="all">-- SEMUA KATEGORI --</option>
                      <?php foreach($data_kategori as $dtk) : ?>
                        <option value="<?= $dtk['id_kategori']; ?>">
                          <?= $dtk['nama_kategori']; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="mt-2">
                    <button type="submit" class="btn btn-success float-right" name="print">
                      <i class="fas fa-print mr-1"></i>
                      Cetak Per Periode
                    </button>
                    <a href="<?= base_url('/print_rekap.php'); ?>" target="_blank" class="btn btn-primary float-right mr-2">
                      <i class="fas fa-print mr-1"></i>
                      Cetak Semua
                    </a>
                  </div>
                </form>
                <!-- end form -->
              </div>
            </div>
          </div>
        </div>
        <!-- end modal print -->

      </div>
      <!-- End of Main Content -->

      <!-- copyright -->
      <?php require_once("layout/copyright.php"); ?>
      <!-- end copyright -->
    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- footer -->
  <?php require_once("layout/footer.php"); ?>
  <script src="<?= base_url(); ?>/assets/js/ajax.js"></script>
</body>

</html>