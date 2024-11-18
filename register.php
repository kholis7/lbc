<?php
require_once("init.php");
helper(["flasher", "auth"]);
isLogOut();
if (isset($_POST["register"])) {
  $id = uniqid();
  $username = htmlspecialchars($_POST["username"]);
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
  $email = htmlspecialchars($_POST["email"]);
  // tanbah data
  $sql = "INSERT INTO users VALUES('{$id}', '{$username}', '{$password}', 'profile.jpg', 'jamaah', '{$email}') ";
  mysqli_query($conDB, $sql); //or die(mysqli_error($conDB));
  if (mysqli_affected_rows($conDB) > 0) {
    setSessionRegister(true, "Registrasi berhasil!!");
  } else {
    setSessionRegister(false, "username already exists");
  }
  redirect("/register.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Dashboard</title>

  <?php require_once("layout/header.php"); ?>

</head>

<body>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">
                      Create an Account!
                    </h1>
                  </div>
                  <div class="row">
                    <div class="col">
                      <?= showMessageRegisterTrue(); ?>
                      <?= showMessageRegisterFalse(); ?>
                    </div>
                  </div>
                  <form class="user" action="" method="post">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" placeholder="Username" name="username" required autocomplete="off">
                    </div>
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" placeholder="Email Address" name="email" required>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" placeholder="Password" name="password" required>
                    </div>
                    <button type="submit" name="register" class="btn btn-primary btn-user btn-block">
                      Register account
                    </button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="<?= base_url('/login.php'); ?>">Already have an account? Login!</a>
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