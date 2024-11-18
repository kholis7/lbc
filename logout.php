<?php
require_once("init.php");

unset($_SESSION);
session_destroy();
return redirect("/login.php");