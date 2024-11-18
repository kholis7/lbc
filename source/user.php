<?php
require_once("../init.php");
helper(["auth"], "../helper");

if(isset($_GET["getDataById"])) {
  $id = $_GET["getDataById"];
  $result = mysqli_query($conDB, "SELECT * FROM users WHERE id = '$id' ");
  $data = mysqli_fetch_assoc($result);
  echo json_encode($data);
}