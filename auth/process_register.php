<?php
include '../config/database.php';

// =======================
// PROTEKSI LOGIN + ADMIN
// =======================
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ADMIN') {
//     die("Akses ditolak");
// }

// =======================
// VALIDASI CSRF
// =======================
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("CSRF VALIDATION FAILED");
}

// HAPUS TOKEN LAMA
unset($_SESSION['csrf_token']);

// =======================
// AMBIL & TRIM DATA
// =======================
$full_name = trim($_POST['full_name']);
$username  = trim($_POST['username']);
$email     = trim($_POST['email']);
$password  = $_POST['password'];
$confirm   = $_POST['confirm_password'];
$role      = $_POST['role'];

// =======================
// VALIDASI INPUT
// =======================
if (empty($full_name) || empty($username) || empty($password)) {
    $_SESSION['error'] = "SEMUA FIELD WAJIB DIISI";
    header("Location: register.php");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "FORMAT EMAIL TIDAK VALID";
    header("Location: register.php");
    exit;
}

if ($password !== $confirm) {
    $_SESSION['error'] = "PASSWORD TIDAK SAMA";
    header("Location: register.php");
    exit;
}

if (strlen($password) < 6) {
    $_SESSION['error'] = "PASSWORD MINIMAL 6 KARAKTER";
    header("Location: register.php");
    exit;
}

// =======================
// VALIDASI ROLE
// =======================
// $allowed_roles = ['USER', 'ADMIN'];

// if (!in_array($role, $allowed_roles)) {
//     die("ROLE TIDAK VALID");
// }

// OPTIONAL: BATASI ASSIGN ADMIN
/*
if ($_SESSION['role'] !== 'SUPER_ADMIN' && $role === 'ADMIN') {
    die("TIDAK BOLEH ASSIGN ADMIN");
}
*/

// =======================
// CEK DUPLICATE USER
// =======================
$check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
$check->bind_param("ss", $username, $email);
$check->execute();
$check_result = $check->get_result();

if ($check_result->num_rows > 0) {
    $_SESSION['error'] = "USERNAME ATAU EMAIL SUDAH DIGUNAKAN";
    header("Location: register.php");
    exit;
}

// =======================
// HASH PASSWORD
// =======================
$hash = password_hash($password, PASSWORD_DEFAULT);

// =======================
// INSERT USER
// =======================
$stmt = $conn->prepare("
    INSERT INTO users (full_name, username, email, password, role)
    VALUES (?, ?, ?, ?, ?)
");

$stmt->bind_param("sssss", $full_name, $username, $email, $hash, $role);

if ($stmt->execute()) {

    // RESET CSRF BIAR TIDAK REUSE
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    // $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    header("Location: login.php");
    exit;

} else {
    if ($conn->errno == 1062) {
        $_SESSION['error'] = "USERNAME ATAU EMAIL SUDAH DIGUNAKAN";
    } else {
        $_SESSION['error'] = "GAGAL REGISTER";
    }

    header("Location: register.php");
    exit;
}