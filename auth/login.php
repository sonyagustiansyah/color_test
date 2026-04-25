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
    <title>LOGIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: linear-gradient(135deg, #002fff, #5675ff);">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 400px; border-radius: 15px;">

        <div class="text-center">
            <img src="../aset/logo.png" alt="logo" width="120">
        </div>
        
        <h5 class="text-center mb-3">LOGIN</h5>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="process_login.php">
            
            <!-- CSRF -->
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

            <div class="mb-3">
                <label>USERNAME</label>
                <input type="text" name="username" class="form-control" required autofocus autocomplete="off">
            </div>

            <div class="mb-3">
                <label>PASSWORD</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" required autocomplete="off">
                    <!-- <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">👁</button> -->
                </div>
                <input type="checkbox" onclick="togglePassword()"> SHOW PASSWORD
            </div>

            <button class="btn btn-primary w-100" id="btnLogin">LOGIN</button>
        </form>

        <div class="text-center mt-3">
            <a href="forgot_password.php">FORGOT PASSWORD?</a>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById("password");
    input.type = input.type === "password" ? "text" : "password";
}

document.querySelector("form").addEventListener("submit", function() {
    document.getElementById("btnLogin").innerText = "LOADING...";
});
</script>

</body>
</html>