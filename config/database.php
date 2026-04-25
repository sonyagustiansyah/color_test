<?php
$host = "localhost";
$db   = "color_test";
$user = "root";
$pass = "";
$charset = "utf8mb4";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset($charset);

} catch (mysqli_sql_exception $e) {
    // log error (jangan tampilkan ke user)
    error_log($e->getMessage());
    die("DATABASE CONNECTION ERROR.");
}

session_start();
?>