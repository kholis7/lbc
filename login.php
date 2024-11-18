<?php
require_once("init.php");
helper(["flasher", "auth"]);
isLogOut();
if (isset($_POST["login"])) {
  // ambil data
  $username = strtolower($_POST["username"]);
  $password = $_POST["password"];

  // cek username & password
  $sql = "SELECT * FROM users WHERE username='$username' ";
  $result = mysqli_query($conDB, $sql);
  $data = mysqli_fetch_assoc($result);

  // jika username tdk ada
  if ($data == null) {
    setSessionGagalLogin();
    redirect("/login.php");
  }
  // cek password
  if (password_verify($password, $data["password"]) == false) {
    setSessionGagalLogin();
    redirect("/login.php");
  }
  // jika semua benar set session login
  setSessionLogin($data["id"], $data["level"]);
  redirect("/index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>

  <?php require_once("layout/header.php"); ?>

</head>

<body class="bg-primary">
  <div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-md-9 col-sm-12">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-0">
                      Selamat Datang
                    </h1>
                    <h1 class="h5 text-gray-900 mb-4">
                      Di Aplikasi Pengelolaan Kas Lima Benua Consultan
                    </h1>
                  </div>
                  <div class="row">
                    <div class="col">
                      <?= ShowMessageGagalLogin(); ?>
                    </div>
                  </div>
                  <form class="user" action="" method="post">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" placeholder="Username" name="username" required autocomplete="off" autofocus="on">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" placeholder="Password" name="password" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="<?= base_url('/register.php'); ?>">
                      Create an Account!
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- footer -->
  <?php require_once("layout/footer.php"); ?>

</body>

</html>