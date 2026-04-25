<?php
include '../config/database.php';

// if ($_SESSION['role'] !== 'ADMIN') exit;
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ADMIN') {
    header("Location: dashboard_barang.php");
    exit;
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM barang WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("CSRF INVALID");
    }

    $stmt = $conn->prepare("
        UPDATE barang SET
        kode_barang=?, nama_barang=?,
        kode_divisi_barang=?, nama_divisi_barang=?,
        kode_jenis_barang=?, nama_jenis_barang=?,
        kode_brand_barang=?, nama_brand_barang=?,
        barcode=?, barcode_serial_number=?,
        updated_by=?
        WHERE id=?
    ");

    $stmt->bind_param("ssssssssssii",
        $_POST['kode_barang'],$_POST['nama_barang'],
        $_POST['kode_divisi_barang'],$_POST['nama_divisi_barang'],
        $_POST['kode_jenis_barang'],$_POST['nama_jenis_barang'],
        $_POST['kode_brand_barang'],$_POST['nama_brand_barang'],
        $_POST['barcode'],$_POST['barcode_serial_number'],
        $_SESSION['user_id'],$id
    );

    $stmt->execute();
    header("Location: dashboard_barang.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>EDIT BARANG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-3 mb-3">
    <div class="card p-4 shadow">

    <h4>EDIT BARANG</h4>

            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

                <div class="mb-2">
                    <label>KODE BARANG</label>
                    <input type="text" name="kode_barang" value="<?= htmlspecialchars($data['kode_barang']) ?>" class="form-control" style="text-transform: uppercase;">
                </div>

                <div class="mb-2">
                    <label>NAMA BARANG</label>
                    <input type="text" name="nama_barang" value="<?= htmlspecialchars($data['nama_barang']) ?>" class="form-control" style="text-transform: uppercase;">
                </div>

                <div class="mb-2">
                    <label>KODE DIVISI BARANG</label>
                    <input type="text" name="kode_divisi_barang" value="<?= htmlspecialchars($data['kode_divisi_barang']) ?>" class="form-control" style="text-transform: uppercase;">
                </div>

                <div class="mb-2">
                    <label>DIVISI BARANG</label>
                    <input type="text" name="nama_divisi_barang" value="<?= htmlspecialchars($data['nama_divisi_barang']) ?>" class="form-control" style="text-transform: uppercase;">
                </div>

                <div class="mb-2">
                    <label>KODE JENIS BARANG</label>
                    <input type="text" name="kode_jenis_barang" value="<?= htmlspecialchars($data['kode_jenis_barang']) ?>" class="form-control" style="text-transform: uppercase;">
                </div>

                <div class="mb-2">
                    <label>JENIS BARANG</label>
                    <input type="text" name="nama_jenis_barang" value="<?= htmlspecialchars($data['nama_jenis_barang']) ?>" class="form-control" style="text-transform: uppercase;">
                </div>

                <div class="mb-2">
                    <label>KODE BRAND BARANG</label>
                    <input type="text" name="kode_brand_barang" value="<?= htmlspecialchars($data['kode_brand_barang']) ?>" class="form-control" style="text-transform: uppercase;">
                </div>

                <div class="mb-2">
                    <label>BRAND BARANG</label>
                    <input type="text" name="nama_brand_barang" value="<?= htmlspecialchars($data['nama_brand_barang']) ?>" class="form-control" style="text-transform: uppercase;">
                </div>

                <div class="mb-2">
                    <label>BARCODE</label>
                    <input type="text" name="barcode" value="<?= htmlspecialchars($data['barcode']) ?>" class="form-control" style="text-transform: uppercase;">
                </div>

                <div class="mb-2">
                    <label>BARCODE SERIAL NUMBER</label>
                    <input type="text" name="barcode_serial_number" value="<?= htmlspecialchars($data['barcode_serial_number']) ?>" class="form-control" style="text-transform: uppercase;">
                </div>

                <button class="btn btn-primary">SIMPAN</button>
                <a href="dashboard_barang.php" class="btn btn-danger">BATAL</a>
            </form>
        </div>
    </div>

</body>
</html>