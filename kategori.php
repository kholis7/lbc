<?php
require_once("init.php");
helper(["flasher", "auth"]);
$act = "kategori";
isLogIn();

// tambah data
if (isset($_POST["tambah"])) {
  $nama_kategori = htmlspecialchars($_POST["nama_kategori"]);

  // tambah datanya
  mysqli_query($conDB, "INSERT INTO kategori VALUES(NULL, '$nama_kategori')") or die(mysqli_error($conDB));
  if (mysqli_affected_rows($conDB) > 0) {
    setSessionCRUD("success", "Selamat!!", "Data-berhasil-Ditambahkan");
  } else {
    setSessionCRUD("error", "Oupss..", "Data-gagal-Ditambahkan");
  }
  return redirect("/kategori.php");
}

// hapus data
if (isset($_GET["id_hps"])) {
  $id_hps = $_GET["id_hps"];
  mysqli_query($conDB, "DELETE FROM kategori WHERE id_kategori='$id_hps' ") or die(mysqli_error($conDB));
  if (mysqli_affected_rows($conDB) > 0) {
    setSessionCRUD("success", "Selamat!!", "Data-berhasil-Dihapus");
  } else {
    setSessionCRUD("error", "Oupss..", "Data-gagal-Dihapus");
  }
  return redirect("/kategori.php");
}

// edit data
if (isset($_POST["edit"])) {
  $nama_kategori = htmlspecialchars($_POST["nama_kategori"]);
  $id_kategori = $_POST["id_kategori"];

  $sql = "UPDATE kategori SET nama_kategori='$nama_kategori' WHERE id_kategori='$id_kategori' ";

  //   jalankan query
  mysqli_query($conDB, $sql) or die(mysqli_error($conDB));
  if (mysqli_affected_rows($conDB) > 0) {
    setSessionCRUD("success", "Selamat!!", "Data-berhasil-diuabah");
  } else {
    setSessionCRUD("error", "Oupss..", "Data-gagal-diubah");
  }
  return redirect("/kategori.php");
}

// ambil semua data
$result = mysqli_query($conDB, "SELECT * FROM kategori");
$data = [];
while ($r = mysqli_fetch_assoc($result)) {
  $data[] = $r;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Data Kategori</title>

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
            <div class="col-12">
              <?php ShowMessageCRUD(); ?>
            </div>

            <div class="col-md-8 col-sm-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Data Kategori
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped " id="tbl" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kategori</th>
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
                                    <?= $dt["nama_kategori"]; ?>
                                </td>
                                <?php if (getLevel() == "admin" || getLevel() == "takmir") : ?>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                        <button class="btn mr-2 pl-2 pr-1 btn-edit btn-info" data-toggle="modal" data-target="#modalEdit" data-id="<?= $dt['id_kategori']; ?>" data-nama="<?= $dt['nama_kategori']; ?>" onclick="isiModalEdit(this)">
                                            <i class="fas fa-edit d-flex align-items-center"></i>
                                        </button>
                                        <a href="<?= base_url('/kategori.php?id_hps='); ?><?= $dt['id_kategori']; ?>" class="btn d-flex btn-danger pl-2 pr-2 btn-hapus">
                                            <i class="fas fa-trash-alt d-flex align-items-center"></i>
                                        </a>
                                        </div>
                                    </td>
                                <?php endif; ?>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if (getLevel() == "admin" || getLevel() == "takmir") : ?>
            <!-- form tambah -->
            <div class="col-md-4 col-sm-12">
                <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                Tambah Kategori
                            </h6>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="">Nama Kategori</label>
                                    <input type="text" class="form-control" name="nama_kategori" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success w-100" name="tambah">
                                        Tambahkan
                                    </button>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
            <?php endif; ?>
          </div>
        </div>
        <!-- /.container-fluid -->


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
                  <input type="hidden" name="id_kategori" id="id_kategori">
                  <div class="form-group">
                    <label >
                      Nama Kategori
                    </label>
                    <input type="text" class="form-control" name="nama_kategori" required id="nama_kategori">
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
  <script>
    const id_kategori = document.querySelector("#id_kategori");
    const nama_kategori = document.querySelector("#nama_kategori");

    function isiModalEdit(e) {
        id_kategori.value = e.getAttribute("data-id");
        nama_kategori.value = e.getAttribute("data-nama");
    }
  </script>
</body>
</html>