<?php
require_once("../init.php");
helper(["auth"], "../helper");

if(isset($_GET["getDataByKode"])) {
  $kode = $_GET["getDataByKode"];
  $result = mysqli_query($conDB, "SELECT * FROM rekapitulasi WHERE kode = '$kode' ");
  $data = mysqli_fetch_assoc($result);
  echo json_encode($data);
}