<?php
include '../config/database.php';

// if ($_SESSION['role'] !== 'ADMIN') exit;
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ADMIN') {
    die("AKSES DITOLAK");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("CSRF INVALID");
    }

    $id = $_POST['id'];

    $stmt = $conn->prepare("
        UPDATE barang 
        SET deleted_at = NOW(), deleted_by=?
        WHERE id=?
    ");
    $stmt->bind_param("ii", $_SESSION['user_id'], $id);
    $stmt->execute();

    // header("Location: dashboard_barang.php");
    // exit;
    }
    
header("Location: dashboard_barang.php");
exit;