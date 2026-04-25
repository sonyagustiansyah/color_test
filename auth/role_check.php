<?php
function checkRole($role) {
    if ($_SESSION['role'] !== $role) {
        echo "Akses ditolak!";
        exit;
    }
}
?>