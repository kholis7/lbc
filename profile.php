<?php
require_once("init.php");
helper(["auth", "flasher", "user"]);
$act = "profile";
isLogIn();
$dt = getDataLogin();
// ubah data general
if (isset($_POST["editGeneral"])) {
  $id = $dt["id"];
  $username = htmlspecialchars(strtolower($_POST["username"]));
  $email = htmlspecialchars($_POST["email"]);
  mysqli_query($conDB, "UPDATE users SET username='$username', email='$email' WHERE id = '$id' ");
  if (mysqli_affected_rows($conDB) > 0) {
    setSessionCRUD("success", "Selamat!!", "Data-berhasil-diubah");
  } else {
    setSessionCRUD("error", "Oupss...", "Gagal-mengubah-Data");
  }
  return redirect("/profile.php");
}
// ubah Password
if (isset($_POST["editPassword"])) {
  $id = $dt["id"];
  $pw1 = $_POST["password1"];
  $pw2 = $_POST["password2"];
  if (empty($pw1) || empty($pw2)) {
    setSessionCRUD("error", "Oupss..", "Harap-isi-password-dulu!!");
    return redirect("/profile.php");
  }

  if ($pw2 != $pw1) {
    setSessionCRUD("error", "Oupss..", "konfirmasi-password-salah!");
    return redirect("/profile.php");
  }
  $password = password_hash($pw1, PASSWORD_DEFAULT);
  mysqli_query($conDB, "UPDATE users SET password = '$password' WHERE id = '$id' ");
  if (mysqli_affected_rows($conDB) > 0) {
    setSessionCRUD("success", "Selamat!!", "Data-berhasil-diubah");
  } else {
    setSessionCRUD("error", "Oupss...", "Gagal-mengubah-Data");
  }
  return redirect("/profile.php");
}
// ubah foto
if (isset($_POST["editFotoProfile"])) {
  $id = $dt["id"];
  if (empty($_FILES)) {
    $foto_profile = "profile.jpg";
  } else {
    $foto_profile = uploadGambar($_FILES["foto_profile"]);
  }
  if (!$foto_profile) {
    setSessionCRUD("error", "Oupss..", "Data-gagal-diubah");
    return redirect("/profile.php");
  }
  mysqli_query($conDB, "UPDATE users SET foto_profile = '$foto_profile' WHERE id = '$id' ");
  if (mysqli_affected_rows($conDB) > 0) {
    setSessionCRUD("success", "Selamat!!", "Data-berhasil-diubah");
  } else {
    setSessionCRUD("error", "Oupss...", "Gagal-mengubah-Data");
  }
  return redirect("/profile.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>dashboard</title>

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


        <!-- begin page content -->
        <div class="container-fluid">

          <div class="row">
            <div class="col">
              <?php
              ShowMessageCRUD();
              ?>
            </div>
          </div>

          <div class="row mb-3 ">
            <div class="col">
              <h4 class="text-center h4 font-weight-bold">
                My Profile
              </h4>
            </div>
          </div>

          <div class="row mb-5 ">

            <div class="col-md-4 sm-12 d-flex justify-content-center mb-3">
              <div class="card border-info " id="card_profile">
                <div class="card-header pb-2 bg-primary text-white h5 text-center">
                  Foto Profile
                </div>
                <div class="card-body p-1 mt-1 justify-content-center">
                  <img src="<?= base_url('/assets/img/'); ?><?= $dt['foto_profile']; ?>" alt="foto profile" class="img-thumbnail " id="img_preview_3">
                  <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <input type="file" class="form-control-file d-none" id="foto_profile_3" name="foto_profile" onchange="preview_profile()">
                    </div>
                    <div>
                      <button type="submit" name="editFotoProfile" class="btn border btn-primary w-100" id="btn_ubah_profile">
                        Ubah Gambar
                      </button>
                    </form>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="col-md-4 sm-12 col-d-flex mb-3">
            <div class="card border-info" id="card_profile">
              <div class="card-header pb-2 bg-info h5 text-white text-center">
                General
              </div>
              <div class="card-body p-1 mt-1">
                <form action="" method="post">
                  <div class="form-group mb-1">
                    <label for="username">
                      Username
                    </label>
                    <input type="text" class="form-control" id="username" required name="username" value="<?= $dt['username']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="email">
                      Email
                    </label>
                    <input type="email" class="form-control" id="email" required name="email" value="<?= $dt['email']; ?>">
                  </div>
                  <button type="submit" name="editGeneral" class="btn border btn-info w-100">
                    Simpan
                  </button>
                </form>
              </div>
            </div>
          </div>

          <div class="col-md-4 sm-12 col-d-flex">
            <div class="card border" id="card_profile">
              <div class="card-header pb-2 bg-danger h5 text-white text-center">
                Password
              </div>

              <div class="card-body p-1 mt-1">
                <form action="" method="post">
                  <div class="form-group">
                    <label for="password_baru">
                      Password Baru
                    </label>
                    <input type="text" class="form-control" id="password_baru" required name="password1">
                  </div>
                  <div class="form-group">
                    <label for="password_baru_2">
                      Konfirmasi Password
                    </label>
                    <input type="text" class="form-control" id="password_baru_2" required name="password2">
                  </div>

                  <button type="submit" name="editPassword" class="btn border btn-danger w-100">
                    Simpan
                  </button>
                </form>

              </div>
            </div>

          </div>
        </div>

      </div>
      <!-- end page content -->

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
<script src="<?= base_url(); ?>/assets/js/img_preview.js"></script>
<script src="<?= base_url(); ?>/assets/js/profile.js"></script>
</body>
</html>