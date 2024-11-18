<?php

// konfigurasi database
const DB_HOST = "localhost";
const DB_USER = "root";
const DB_PASS = "";
const DB_NAME = "kas";

// base url,, jangan gunakan slash(/) pada akhir
const BASE_URL = "http://localhost/lbc";
//error_reporting(0);
// config lain
date_default_timezone_set('Asia/Jakarta');
session_start();
$act = "home";
