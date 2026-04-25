<?php
include '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ADMIN') {
    header("Location: dashboard_barang.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("INVALID CSRF TOKEN");
    }

    $kode_barang            = $_POST['kode_barang'];
    $nama_barang            = $_POST['nama_barang'];
    $kode_divisi_barang     = $_POST['kode_divisi_barang'];
    $nama_divisi_barang     = $_POST['nama_divisi_barang'];
    $kode_jenis_barang      = $_POST['kode_jenis_barang'];
    $nama_jenis_barang      = $_POST['nama_jenis_barang'];
    $kode_brand_barang      = $_POST['kode_brand_barang'];
    $nama_brand_barang      = $_POST['nama_brand_barang'];
    $barcode                = $_POST['barcode'];
    $barcode_serial_number  = $_POST['barcode_serial_number'];

    $stmt = $conn->prepare("
        INSERT INTO barang 
        (kode_barang,nama_barang,kode_divisi_barang,nama_divisi_barang,
        kode_jenis_barang,nama_jenis_barang,
        kode_brand_barang,nama_brand_barang,
        barcode,barcode_serial_number,created_by)
        VALUES (?,?,?,?,?,?,?,?,?,?,?)
    ");

    $stmt->bind_param("ssssssssssi",
        $kode_barang,$nama_barang,$kode_divisi_barang,$nama_divisi_barang,
        $kode_jenis_barang,$nama_jenis_barang,
        $kode_brand_barang,$nama_brand_barang,
        $barcode,$barcode_serial_number,$_SESSION['user_id']
    );

    $stmt->execute();

    header("Location: dashboard_barang.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>TAMBAH BARANG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-3 mb-3">
    <div class="card p-4 shadow">
        <h4>TAMBAH BARANG</h4>

        <form method="POST" action="">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

            <div class="mb-2">
                <label>KODE BARANG</label>
                <input type="text" name="kode_barang" class="form-control" style="text-transform: uppercase;" required>
            </div>

            <div class="mb-2">
                <label>NAMA BARANG</label>
                <input type="text" name="nama_barang" class="form-control" style="text-transform: uppercase;" required>
            </div>
            
            <div class="mb-2">
                <label>KODE DIVISI BARANG</label>
                <input type="text" name="kode_divisi_barang" class="form-control" style="text-transform: uppercase;" required>
            </div>

            <div class="mb-2">
                <label>DIVISI BARANG</label>
                <input type="text" name="nama_divisi_barang" class="form-control" style="text-transform: uppercase;" required>
            </div>

            <div class="mb-2">
                <label>KODE JENIS BARANG</label>
                <input type="text" name="kode_jenis_barang" class="form-control" style="text-transform: uppercase;" required>
            </div>

            <div class="mb-2">
                <label>JENIS BARANG</label>
                <input type="text" name="nama_jenis_barang" class="form-control" style="text-transform: uppercase;" required>
            </div>

            <div class="mb-2">
                <label>KODE BRAND BARANG</label>
                <input type="text" name="kode_brand_barang" class="form-control" style="text-transform: uppercase;" required>
            </div>

            <div class="mb-2">
                <label>BRAND BARANG</label>
                <input type="text" name="nama_brand_barang" class="form-control" style="text-transform: uppercase;" required>
            </div>

            <div class="mb-2">
                <label>BARCODE</label>
                <input type="text" name="barcode" class="form-control" style="text-transform: uppercase;" required>
            </div>

            <div class="mb-2">
                <label>BARCODE SERIAL NUMBER</label>
                <input type="text" name="barcode_serial_number" class="form-control" style="text-transform: uppercase;" required>
            </div>

            <div class="text-end mt-3">
                    <button class="btn btn-primary" type="submit">SIMPAN</button>
                    <a href="dashboard_barang.php" class="btn btn-danger">BATAL</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>