<?php


function uploadGambar($file) {
  $namaGambar = $file["name"];
  $ukuran = $file["size"];
  $error = $file["error"];
  $tmpName = $file["tmp_name"];
  // cek gambar ada atau tdk
  if ($error == 4) {
    return "profile.jpg";
  }
  // cek ekstensi gambar
  $ekstensiValid = [
    "jpg",
    "jpeg",
    "png"];
  $ekstensiGambar = strtolower(end(explode(".", $namaGambar)));
  if (!in_array($ekstensiGambar, $ekstensiValid)) {
    return 0;
  }

  // cek ukuran gambar
  if ($ukuran > 2000000) {
    return 0;
  }

  // genereate nama file gambarnya
  $namaGambar = uniqid() . ".$ekstensiGambar";

  // upload gambarnya
  move_uploaded_file($tmpName, "assets/img/" . $namaGambar);
  return $namaGambar;

}