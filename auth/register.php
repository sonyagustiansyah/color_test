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
    <title>REGISTER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: linear-gradient(135deg, #002fff, #5675ff);">

<div class="container d-flex justify-content-center align-items-center vh-110">
    <div class="card shadow p-4 mt-3 mb-5" style="width: 450px; border-radius: 15px;">
        
        <div class="text-center">
            <img src="../aset/logo.png" alt="logo" width="120">
        </div>

        <h5 class="text-center mb-3">REGISTER</h5>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="process_register.php">
            
            <!-- CSRF -->
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

            <div class="mb-2">
                <label>FULL NAME</label>
                <input type="text" name="full_name" class="form-control" required autofocus>
            </div>

            <div class="mb-2">
                <label>USERNAME</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-2">
                <label>EMAIL</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-2">
                <label>PASSWORD</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" required minlength="6">
                    <!-- <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">👁</button> -->
                </div>
            </div>
            
            <div class="mb-2">
                <label>CONFIRM PASSWORD</label>
                <div class="input-group">
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                </div>
                <input type="checkbox" onclick="togglePassword()"> SHOW PASSWORD
            </div>
            
            <div>
                <label>ROLE</label>
                <select name="role" class="form-select" required>
                    <option value="USER">USER</option>
                    <option value="ADMIN">ADMIN</option>
                </select>
            </div>

            <button class="btn btn-primary w-100 mt-2">REGISTER</button>
        </form>

        <div class="text-center mt-3">
            <a href="login.php">BACK TO LOGIN</a>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const password = document.getElementById("password");
    const confirm  = document.getElementById("confirm_password");

    const type = password.type === "password" ? "text" : "password";

    password.type = type;
    confirm.type  = type;
}

document.querySelector("form").addEventListener("submit", function(e) {
    const p1 = document.getElementById("password").value;
    const p2 = document.getElementById("confirm_password").value;

    if (p1 !== p2) {
        e.preventDefault();
        alert("PASSWORD TIDAK SAMA!");
    }
});
</script>

</body>
</html>