<?php

function getDataLogin($param = null) {
  global $conDB;
  $id_login = $_SESSION["login"]["id"];
  $result = mysqli_query($conDB, "SELECT * FROM users WHERE id='$id_login' ");
  $dt = mysqli_fetch_assoc($result);
  if ($param == null) return $dt;
  return $dt[$param];
}

function isLogIn() {
  if (!isset($_SESSION["login"])) {
    return redirect("/login.php");
  }
}

function isLogOut() {
  if (isset($_SESSION["login"])) {
    return redirect("/index.php");
  }
}

function getLevel() {
  return $_SESSION["login"]["level"];
}