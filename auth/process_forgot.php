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
$email = trim($_POST['email'] ?? '');

if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['success'] = "JIKA EMAIL TERDAFTAR, LINK RESET TELAH DIKIRIM";
    header("Location: forgot_password.php");
    exit;
}

// =======================
// CARI USER
// =======================
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND deleted_at IS NULL LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// =======================
// JIKA USER ADA
// =======================
if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();

    // GENERATE TOKEN
    $token = bin2hex(random_bytes(32));
    $expired = date("Y-m-d H:i:s", strtotime("+1 hour"));

    // SIMPAN TOKEN
    $update = $conn->prepare("
        UPDATE users 
        SET reset_token = ?, reset_expired = ? 
        WHERE id = ?
    ");
    $update->bind_param("ssi", $token, $expired, $user['id']);
    $update->execute();

    // LINK RESET
    $reset_link = "http://localhost/color/auth/reset_password.php?token=$token";

    // =======================
    // EMAIL (SEMENTARA PAKAI MAIL)
    // =======================
    $subject = "RESET PASSWORD";
    $message = "KLIK LINK BERIKUT UNTUK RESET PASSWORD:\n$reset_link";
    $headers = "FROM: no-reply@colorlink.com";

    @mail($email, $subject, $message, $headers);
}

// =======================
// RESPONSE (JANGAN BOCORKAN)
// =======================
$_SESSION['success'] = "JIKA EMAIL TERDAFTAR, LINK RESET TELAH DIKIRIM";
header("Location: forgot_password.php");
exit;