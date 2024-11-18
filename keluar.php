<?php
require_once("init.php");
helper(["flasher", "auth"]);
$act = "keluar";
isLogIn();
$dataLogin = getDataLogin();
// tambah data
if (isset($_POST["tambah"])) {
  $kode = $_POST["kode"];
  $id_user = $dataLogin["id"];
  $id_kategori = $_POST['id_kategori'];
  $keterangan = htmlspecialchars($_POST["keterangan"]);
  $jumlah = htmlspecialchars($_POST["jumlah"]);
  $tanggal = htmlspecialchars($_POST["tanggal"]);

  $sql_insert = "INSERT INTO rekapitulasi VALUES('$kode', '$id_user', '$id_kategori' , '$keterangan', 'keluar', '$jumlah', '$tanggal') ";
  mysqli_query($conDB, $sql_insert) or die(mysqli_error($conDB));
  if (mysqli_affected_rows($conDB) > 0) {
    setSessionCRUD("success", "Selamat!!", "Data-berhasil-Ditambahkan");
  } else {
    setSessionCRUD("error", "Oupss..", "Data-gagal-Ditambahkan");
  }
  return redirect("/keluar.php");
}

// hapus data
if (isset($_GET["id_hps"])) {
  $id_hps = $_GET["id_hps"];
  mysqli_query($conDB, "DELETE FROM rekapitulasi WHERE kode=$id_hps ");
  if (mysqli_affected_rows($conDB) > 0) {
    setSessionCRUD("success", "Selamat!!", "Data-berhasil-Dihapus");
  } else {
    setSessionCRUD("error", "Oupss..", "Data-gagal-Dihapus");
  }
  return redirect("/keluar.php");
}

// edit data
if (isset($_POST["edit"])) {
  $kode = $_POST["kode"];
  $id_kategori = $_POST['id_kategori'];
  $keterangan = htmlspecialchars($_POST["keterangan"]);
  $jumlah = htmlspecialchars($_POST["jumlah"]);
  $tanggal = htmlspecialchars($_POST["tanggal"]);
  $sql_update = "UPDATE rekapitulasi SET keterangan = '$keterangan', jumlah = '$jumlah', tanggal = '$tanggal', id_kategori = '$id_kategori'  WHERE kode = '$kode'";
  mysqli_query($conDB, $sql_update) or die(mysqli_error($conDB));
  if (mysqli_affected_rows($conDB) > 0) {
    setSessionCRUD("success", "Selamat!!", "Data-berhasil-Diubah");
  } else {
    setSessionCRUD("error", "Oupss..", "Data-gagal-Diubah");
  }
  return redirect("/keluar.php");
}

// ambil semua data nya dulu
$sql = "SELECT rekapitulasi.*, users.username, kategori.nama_kategori FROM rekapitulasi JOIN users ON rekapitulasi.id_user=users.id JOIN kategori ON rekapitulasi.id_kategori=kategori.id_kategori  WHERE jenis='keluar' ORDER BY tanggal DESC";
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

// ambil kode max
$result_max = mysqli_query($conDB, "SELECT MAX(kode) as max FROM rekapitulasi");
$data_max = mysqli_fetch_assoc($result_max);
$kode_max = (int) $data_max["max"] + 1;

// ambil total kas keluar
$result_total = mysqli_query($conDB, "SELECT SUM(jumlah) as jmlh FROM rekapitulasi WHERE jenis = 'keluar' ");
$data_keluar = mysqli_fetch_assoc($result_total);
$total_keluar = $data_keluar["jmlh"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Kas keluar</title>

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
          <div class="row">
            <div class="col">
              <?php ShowMessageCRUD(); ?>
            </div>
          </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-danger">
                Kas keluar
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
                      <th>Jumlah</th>
                      <?php if (getLevel() == "admin" || getLevel() == "takmir") : ?>
                      <th>Aksi</th>
                      <?php endif; ?>
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
                      <td class="text-right">
                        <?= number_format($dt["jumlah"], 0, ",", "."); ?>
                      </td>
                      <?php if (getLevel() == "admin" || getLevel() == "takmir") : ?>
                      <td>
                        <div class="d-flex justify-content-center">
                          <button data-href="<?= base_url('/source/rekapitulasi.php?getDataByKode='); ?><?= $dt['kode']; ?>" class="btn mr-2 pl-2 pr-1 btn-edit btn-info" data-toggle="modal" data-target="#modalEdit">
                            <i class="fas fa-edit d-flex align-items-center"></i>
                          </button>
                          <a href="<?= base_url('/keluar.php?id_hps='); ?><?= $dt['kode']; ?>" class="btn d-flex btn-danger pl-2 pr-2 btn-hapus">
                            <i class="fas fa-trash-alt d-flex align-items-center"></i>
                          </a>
                        </div>
                      </td>
                      <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td class="text-center font-weight-bold" colspan="<?= (getLevel() == 'jamaah') ? '5' : '6'; ?>">
                        Total Uang keluar
                      </td>
                      <td class="text-right font-weight-bold" colspan="2">
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
                      <?php if (getLevel() == "admin" || getLevel() == "takmir") : ?>
                  <button type="button" class="btn btn-success align-middle mr-3" data-toggle="modal" data-target="#modalTambah">
                    <i class="fas fa-plus mr-1"></i>
                    Tambah
                  </button>
<?php endif; ?>
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



        <!-- modal tambah -->
        <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="TambahLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="TambahLabel">
                  Tambah Data
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <!-- form -->
                <form action="" method="post">
                  <div class="form-group">
                    <label for="kode">
                      Kode
                    </label>
                    <input type="number" class="form-control" name="kode" readonly value="<?= $kode_max + 1; ?>">
                  </div>
                  <div class="form-group">
                    <label for="id_kategori">
                      Nama Kategori
                    </label>
                    <select name="id_kategori" id="id_kategori" class="form-control" require>
                      <option value="">-- PILIH KATEGORI --</option>
                      <?php foreach($data_kategori as $dtk) : ?>
                        <option value="<?= $dtk['id_kategori']; ?>">
                          <?= $dtk['nama_kategori']; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="keterangan">
                      Keterangan
                    </label>
                    <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" required></textarea>
                  </div>
                  <div class="form-group">
                    <label for="kode">
                      Tanggal
                    </label>
                    <input type="date" class="form-control" name="tanggal" value="<?= date('Y-m-d'); ?>">
                  </div>
                  <div class="form-group">
                    <label for="kode">
                      Jumlah
                    </label>
                    <input type="number" class="form-control" name="jumlah" required>
                  </div>

                  <div>
                    <button type="submit" class="btn btn-primary float-right ml-2" name="tambah">
                      Simpan
                    </button>
                    <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">
                      Close
                    </button>
                  </div>

                </form>
                <!-- end form -->
              </div>

            </div>
          </div>
        </div>
        <!-- end modal tambah -->


        <!-- modal edit -->
        <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="editLabel">
                  Edit Data
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <!-- form -->
                <form action="" method="post">
                  <div class="form-group">
                    <label for="kode">
                      Kode
                    </label>
                    <input type="number" class="form-control" name="kode" readonly id="EditKode">
                  </div>
                  <div class="form-group">
                    <label for="id_kategori">
                      Nama Kategori
                    </label>
                    <select name="id_kategori" id="EditIdKategori" class="form-control" require>
                      <option value="">-- PILIH KATEGORI --</option>
                      <?php foreach($data_kategori as $dtk) : ?>
                        <option value="<?= $dtk['id_kategori']; ?>" class="EditIdKategori">
                          <?= $dtk['nama_kategori']; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="keterangan">
                      Keterangan
                    </label>
                    <textarea name="keterangan" id="EditKeterangan" cols="30" rows="5" class="form-control"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="kode">
                      Tanggal
                    </label>
                    <input type="date" class="form-control" name="tanggal" id="EditTanggal">
                  </div>
                  <div class="form-group">
                    <label for="kode">
                      Jumlah
                    </label>
                    <input type="number" class="form-control" name="jumlah" id="EditJumlah">
                  </div>

                  <div>
                    <button type="submit" class="btn btn-primary float-right ml-2" name="edit">
                      Simpan
                    </button>
                    <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">
                      Close
                    </button>
                  </div>

                </form>
                <!-- end form -->

              </div>
            </div>
          </div>
        </div>

        <!-- end modal edit -->

        <!-- modal print -->
        <div class="modal fade" id="modalPrint" tabindex="-1" aria-labelledby="printLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="printLabel">
                  Laporan Kas keluar
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <!-- form -->
                <form action="<?= base_url('/print_periode.php?type=keluar'); ?>" method="post">
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

                    <a href="<?= base_url('/print_all.php?type=keluar'); ?>" target="_blank" class="btn btn-primary float-right mr-2">
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