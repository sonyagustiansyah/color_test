<?php
include '../config/database.php';
include '../auth/auth_check.php';
?>

<h2>Dashboard</h2>

<p>Welcome, <?= $_SESSION['username']; ?></p>
<p>Role: <?= $_SESSION['role']; ?></p>

<a href="../auth/logout.php">Logout</a>