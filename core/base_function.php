<?php
function base_url($url = null) {
  if ($url == null) {
    return BASE_URL;
  } else {
    return BASE_URL . $url;
  }
}

function helper($helperName, $prefix = "helper") {
  if (is_array($helperName)) {
    foreach ($helperName as $hlp) {
      require_once($prefix . "/" . $hlp . "_helper.php");
    }
  } else {
    require_once($prefix . "/" . $helperName . "_helper.php");
  }
}

function redirect($url) {
  echo "
    <script>
      window.location.href = '" . base_url($url) . "';
    </script>
  ";
  die;
}

function dd($data) {
  var_dump($data); die;
}