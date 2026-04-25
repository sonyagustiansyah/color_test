<?php
include '../config/database.php';

// =======================
// VALIDASI CSRF
// =======================
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("CSRF VALIDATION FAILED");
}

// HAPUS TOKEN LAMA
unset($_SESSION['csrf_token']);

// =======================
// VALIDASI INPUT
// =======================
$username = trim($_POST['username']);
$password = $_POST['password'];

if (empty($username) || empty($password)) {
    $_SESSION['error'] = "USERNAME DAN PASSWORD WAJIB DIISI";
    header("Location: login.php");
    exit;
}

// =======================
// QUERY USER
// =======================
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND deleted_at IS NULL LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// =======================
// CEK USER
// =======================
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // CEK PASSWORD
    if (password_verify($password, $user['password'])) {

        // CEK AKTIF
        if ($user['is_active'] == 0) {
            $_SESSION['error'] = "USER TIDAK AKTIF";
            header("Location: login.php");
            exit;
        }

        // =======================
        // SECURITY: REGENERATE SESSION
        // =======================
        session_regenerate_id(true);

        // set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // =======================
        // UPDATE LAST LOGIN
        // =======================
        $update = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
        $update->bind_param("i", $user['id']);
        $update->execute();

        // =======================
        // RESET CSRF TOKEN (optional)
        // =======================
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        // $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        header("Location: ../dashboard/dashboard_barang.php");
        exit;
    }
}

// =======================
// LOGIN GAGAL
// =======================
$_SESSION['error'] = "USERNAME ATAU PASSWORD SALAH";
header("Location: login.php");
exit;