<?php 
include '../config/database.php';

// CSRF TOKEN
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
// $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FORGOT PASSWORD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: linear-gradient(135deg, #002fff, #5675ff);">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 400px; border-radius: 15px;">

        <div class="text-center">
            <img src="../aset/logo.png" alt="logo" width="120">
        </div>
        
        <h5 class="text-center">RESET PASSWORD</h5>
        
        <p class="text-muted small">
            MASUKKAN EMAIL ANDA, KAMI AKAN KIRIM LINK RESET PASSWORD.
        </p>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="process_forgot.php">
            
            <!-- CSRF -->
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

            <div class="mb-3">
                <label>EMAIL</label>
                <input type="email" name="email" class="form-control" required autofocus>
            </div>

            <button class="btn btn-primary w-100" id="btnSubmit">SEND RESET LINK</button>
        </form>

        <div class="text-center mt-3">
            <a href="login.php">BACK TO LOGIN</a>
        </div>
    </div>
</div>

<script>
    document.querySelector("form").addEventListener("submit", function() {
        document.getElementById("btnSubmit").innerText = "SENDING...";
    });
</script>

</body>
</html>