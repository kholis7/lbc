<?php
require_once("init.php");
helper(["flasher", "auth", "user"]);
$act = "user";
isLogIn();
// tambah data
if (isset($_POST["tambah"])) {
  $username = htmlspecialchars($_POST["username"]);
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
  $email = htmlspecialchars($_POST["email"]);
  $level = htmlspecialchars($_POST["level"]);
  $id = uniqid();
  // cek gambar
  if (empty($_FILES)) {
    $foto_profile = "profile.jpg";
  } else {
    $foto_profile = uploadGambar($_FILES["foto_profile"]);
  }
  if (!$foto_profile) {
    setSessionCRUD("error", "Oupss..", "Data-gagal-Ditambahkan");
    return redirect("/user.php");
  }

  // tambah datanya
  mysqli_query($conDB, "INSERT INTO users VALUES('$id', '$username', '$password', '$foto_profile', '$level', '$email')") or die(mysqli_error($conDB));
  if (mysqli_affected_rows($conDB) > 0) {
    setSessionCRUD("success", "Selamat!!", "Data-berhasil-Ditambahkan");
  } else {
    setSessionCRUD("error", "Oupss..", "Data-gagal-Ditambahkan");
  }
  return redirect("/user.php");
}

// hapus data
if (isset($_GET["id_hps"])) {
  $id_hps = $_GET["id_hps"];
  mysqli_query($conDB, "DELETE FROM users WHERE id='$id_hps' ") or die(mysqli_error($conDB));
  if (mysqli_affected_rows($conDB) > 0) {
    setSessionCRUD("success", "Selamat!!", "Data-berhasil-Dihapus");
  } else {
    setSessionCRUD("error", "Oupss..", "Data-gagal-Dihapus");
  }
  return redirect("/user.php");
}

// edit data
if (isset($_POST["edit"])) {
  $username = htmlspecialchars($_POST["username"]);
  $password = $_POST["password"];
  $email = htmlspecialchars($_POST["email"]);
  $level = htmlspecialchars($_POST["level"]);
  $id = $_POST["id"];

  $sql = "UPDATE users SET username='$username', email='$email', level='$level' ";
  if ($password != "") {
    $newPw = password_hash($password, PASSWORD_DEFAULT);
    $sql .= "password='$newPw' ";
  }
  $sql .= "WHERE id = '$id' ";
  mysqli_query($conDB, $sql) or die(mysqli_error($conDB));
  if (mysqli_affected_rows($conDB) > 0) {
    setSessionCRUD("success", "Selamat!!", "Data-berhasil-diuabah");
  } else {
    setSessionCRUD("error", "Oupss..", "Data-gagal-diubah");
  }
  return redirect("/user.php");
}

// ambil semua data
$result = mysqli_query($conDB, "SELECT * FROM users");
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
  <title>Data User</title>

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
              <h6 class="m-0 font-weight-bold text-primary">
                Manajemen User
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped " id="tbl" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Foto</th>
                      <th>Username</th>
                      <th>Email</th>
                      <th>Level</th>
                      <th>Aksi</th>
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
                        <img src="<?= base_url('/assets/img'); ?>/<?= $dt['foto_profile']; ?>" alt="" style="width:50px; height:50px;" class="rounded-circle">
                      </td>
                      <td>
                        <?= $dt["username"]; ?>
                      </td>
                      <td>
                        <?= $dt["email"]; ?>
                      </td>
                      <td>
                        <?= $dt["level"]; ?>
                      </td>
                      <td>
                        <div class="d-flex justify-content-center">
                          <button data-href="<?= base_url('/source/user.php?getDataById='); ?><?= $dt['id']; ?>" class="btn mr-2 pl-2 pr-1 btn-edit btn-info" data-toggle="modal" data-target="#modalEdit"
                            data-base="<?= base_url('/img/'); ?>"
                            >
                            <i class="fas fa-edit d-flex align-items-center"></i>
                          </button>
                          <a href="<?= base_url('/user.php?id_hps='); ?><?= $dt['id']; ?>" class="btn d-flex btn-danger pl-2 pr-2 btn-hapus">
                            <i class="fas fa-trash-alt d-flex align-items-center"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>

              </div>

              <hr>

              <!-- button tambah -->
              <div class="row">
                <div class="col">

                  <button type="button" class="btn btn-success align-middle mr-3" data-toggle="modal" data-target="#modalTambah">
                    <i class="fas fa-plus mr-1"></i>
                    Tambah
                  </button>

                </div>
              </div>
              <!-- end tanbah  -->

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
                <form action="" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="username">
                      Username
                    </label>
                    <input type="text" class="form-control" name="username" required>
                  </div>
                  <div class="form-group">
                    <label for="email">
                      Email
                    </label>
                    <input type="email" class="form-control" name="email" required>
                  </div>
                  <div class="form-group">
                    <label for="password">
                      Password
                    </label>
                    <input type="password" class="form-control" name="password">
                  </div>
                  <div class="form-group">
                    <label for="level">
                      Level
                    </label>
                    <select class="form-control" name="level" id="level">
                      <option value="jamaah">jamaah</option>
                      <option value="admin">admin</option>
                      <option value="takmir">takmir</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="foto_profile" class="mb-0">
                      Foto Profile
                    </label>
                    <img src="<?= base_url('/assets/img/profile.jpg'); ?>" alt="hai" class="d-block img-thumbnail mb-1" width="80" id="img_preview">
                    <input type="file" class="form-control-file" id="foto_profile" name="foto_profile" aria-descrabedby="fotoInfo" onchange="preview()">
                    <small class="text-muted form-text" id="fotoInfo">
                      ekstensi file hanya jpg,jpeg, dan png, serta max ukuran file adlh 2MB.
                    </small>
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
                <form action="" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="id" id="id">
                  <div class="form-group">
                    <label for="username">
                      Username
                    </label>
                    <input type="text" class="form-control" name="username" required id="username">
                  </div>
                  <div class="form-group">
                    <label for="email">
                      Email
                    </label>
                    <input type="email" class="form-control" name="email" required id="email">
                  </div>
                  <div class="form-group">
                    <label for="password">
                      password
                    </label>
                    <input type="text" class="form-control" name="password" id="password">
                    <small>kosongkan jika tdk mau ganti password</small>
                  </div>
                  <div class="form-group">
                    <label for="level">
                      Level
                    </label>
                    <select class="form-control" id="level" name="level" id="level">
                      <option value="" id="opt"></option>
                      <option value="admin">admin</option>
                      <option value="takmir">takmir</option>
                      <option value="jamaah">jamaah</option>
                    </select>
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

  <script src="<?= base_url(); ?>/assets/js/ajax_user.js"></script>
  <script src="<?= base_url(); ?>/assets/js/img_preview.js"></script>
</body>
</html>