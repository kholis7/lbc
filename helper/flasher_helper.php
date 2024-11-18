<?php

// set
function setSessionCRUD($icon, $title, $text) {
  $_SESSION["CRUD"] = [
    "icon" => $icon,
    "title" => $title,
    "text" => $text
  ];
}
function setSessionLogin($id, $level) {
  $_SESSION["login"] = [
    "status" => true,
    "id" => $id,
    "level" => $level
  ];
}
function setSessionGagalLogin() {
  $_SESSION["gagalLogin"] = true;
}
function setSessionRegister($status, $message) {
  $_SESSION["register"] = [
    "status" => $status,
    "message" => $message
  ];
}

// show
function ShowMessageCRUD() {
  if (isset($_SESSION["CRUD"])) {
    $title = $_SESSION["CRUD"]["title"];
    $icon = $_SESSION["CRUD"]["icon"];
    $text = $_SESSION["CRUD"]["text"];
    echo "
            <div id='flash-crud' data-title=$title data-text=$text data-icon=$icon data-flash=true>
            </div>
          ";
    unset($_SESSION["CRUD"]);
  }
}

function ShowMessageGagalLogin() {
  if (isset($_SESSION["gagalLogin"])) {
    echo '
            <div class="alert alert-danger" role="alert">
               Terjadi Kesalahan Saat Login!
            </div>
          ';
    unset($_SESSION["gagalLogin"]);
  }
}

function showMessageRegisterTrue() {
  if (isset($_SESSION["register"])) {
    if ($_SESSION["register"]["status"] == true) {
      echo '
      <div class="alert alert-success" role="alert">'
      . $_SESSION["register"]["message"] .
      '</div>
                <script>
                  setTimeout(function(){
                    document.location.href = "' . base_url() . '/login.php";
                  }, 1500);
                </script>
              ';
      unset($_SESSION["register"]);
    }
  }
}

function showMessageRegisterFalse() {
    if (isset($_SESSION["register"])) {
  if ($_SESSION["register"]["status"] == false) {
    echo '
      <div class="alert alert-danger" role="alert">'
    . $_SESSION["register"]["message"] .
    '</div>
            ';
    unset($_SESSION["register"]);
  }
    }
}