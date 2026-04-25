<?php
include '../config/database.php';

// =======================
// CSRF TOKEN
// =======================
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
// $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// =======================
// AMBIL TOKEN
// =======================
$token = $_GET['token'] ?? '';

// =======================
// VALIDASI TOKEN
// =======================
$valid = false;

if ($token && strlen($token) === 64) {

    $token_hash = hash('sha256', $token);

    $stmt = $conn->prepare("
        SELECT id FROM users 
        WHERE reset_token = ? 
        AND reset_expired > NOW()
    ");
    $stmt->bind_param("s", $token_hash);
    $stmt->execute();
    $result = $stmt->get_result();

    $valid = $result->num_rows === 1;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>RESET PASSWORD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: linear-gradient(135deg, #002fff, #5675ff);">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="width:400px; border-radius:15px;">

        <div class="text-center">
            <img src="../aset/logo.png" alt="logo" width="120">
        </div>
        
        <h5 class="text-center">RESET PASSWORD</h5>

        <?php if (!$valid): ?>
            <div class="alert alert-danger text-center">
                TOKEN TIDAK VALID ATAU SUDAH EXPIRED
            </div>
        <?php else: ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger text-center">
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="process_reset.php">
            
            <!-- TOKEN -->
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

            <!-- CSRF -->
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

            <div class="mb-3">
                <label>PASSWORD</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" required minlength="6" autofocus autocomplete="new-password">
                    <!-- <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">👁</button> -->
                </div>
            </div>
            
            <div class="mb-3">
                <label>CONFIRM PASSWORD</label>
                <div class="input-group">
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                </div>
                <input type="checkbox" onclick="togglePassword()"> SHOW PASSWORD
            </div>

            <button class="btn btn-primary w-100" id="btnReset">RESET</button>
        </form>

        <?php endif; ?>
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

const form = document.querySelector("form");

if (form) {
    form.addEventListener("submit", function(e) {
        const btn = document.getElementById("btnReset");

        const pass = document.getElementById("password").value;
        const confirm = document.getElementById("confirm_password").value;

        if (pass !== confirm) {
            e.preventDefault();
            alert("PASSWORD TIDAK SAMA!");
            return;
        }

        btn.disabled = true;
        btn.innerText = "PROCESSING...";
    });
}
</script>

</body>
</html>