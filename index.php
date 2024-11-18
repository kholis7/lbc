<?php
require_once("init.php");
helper(["auth"]);
isLogIn();
// ambil jumalh Saldo masuk dan keluar
$sql = "SELECT SUM(jumlah) as jmlh FROM rekapitulasi GROUP BY jenis ORDER BY jenis ASC";
$result = mysqli_query($conDB, $sql);
$data = [];
while ($r = mysqli_fetch_assoc($result)) {
  $data[] = $r;
}
$masuk = $data[0]["jmlh"];
$keluar = $data[1]["jmlh"];
$sisa_saldo = $masuk - $keluar;

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

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <div class="card shadow mb-4 p-3">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h3 mb-0 text-gray-800">
                Dashboard
              </h1>
            </div>


            <!-- Content Row -->
            <div class="row">

              <!-- kas masuk -->
              <div class="col-xl-3 col-md-4 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                          kas masuk
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          Rp <?= number_format($masuk, 0, ',', '.'); ?>
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-download fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- kas keluar -->
              <div class="col-xl-3 col-md-4 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                          kas keluar
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          Rp <?= number_format($keluar, 0, ',', '.'); ?>
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-upload fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- saldo akhir -->
              <div class="col-xl-3 col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                          Saldo Akhir
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          Rp <?= number_format($sisa_saldo, 0, ',', '.'); ?>
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-save fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
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

</body>
</html>