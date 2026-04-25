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
// AMBIL INPUT
// =======================
$token = $_POST['token'] ?? '';
$password = $_POST['password'] ?? '';
$confirm  = $_POST['confirm_password'] ?? '';

// =======================
// VALIDASI INPUT
// =======================
if (empty($token) || empty($password) || empty($confirm)) {
    $_SESSION['error'] = "DATA TIDAK LENGKAP";
    header("Location: reset_password.php?token=" . urlencode($token));
    exit;
}

if ($password !== $confirm) {
    $_SESSION['error'] = "PASSWORD TIDAK SAMA";
    header("Location: reset_password.php?token=" . urlencode($token));
    exit;
}

if (strlen($password) < 6) {
    $_SESSION['error'] = "PASSWORD MINIMAL 6 KARAKTER";
    header("Location: reset_password.php?token=" . urlencode($token));
    exit;
}

// =======================
// CEK TOKEN
// =======================
$token_hash = hash('sha256', $token);

$stmt = $conn->prepare("
    SELECT id FROM users 
    WHERE reset_token = ? 
    AND reset_expired > NOW()
    AND is_active = 1
    LIMIT 1
");
$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    $_SESSION['error'] = "TOKEN TIDAK VALID ATAU EXPIRED";
    header("Location: login.php");
    exit;
}

$user = $result->fetch_assoc();

// =======================
// HASH PASSWORD
// =======================
$hash = password_hash($password, PASSWORD_DEFAULT);

// =======================
// UPDATE PASSWORD + HAPUS TOKEN
// =======================
$update = $conn->prepare("
    UPDATE users 
    SET password = ?, reset_token = NULL, reset_expired = NULL 
    WHERE id = ?
");
$update->bind_param("si", $hash, $user['id']);
$update->execute();

// =======================
// OPTIONAL: AUTO LOGIN
// =======================
// $_SESSION['user_id'] = $user['id'];

// =======================
// SUCCESS
// =======================
$_SESSION['success'] = "PASSWORD BERHASIL DIRESET, SILAHKAN LOGIN";
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
// $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
header("Location: login.php");
exit;