<?php
include '../config/database.php';

// =======================
// PROTEKSI LOGIN
// =======================
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// =======================
// PARAMETER
// =======================
$limit = 15;
$page  = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

$search = trim($_GET['search'] ?? '');

// =======================
// COUNT TOTAL DATA
// =======================
$search_param = "%$search%";

$stmt = $conn->prepare("
    SELECT COUNT(*) as total
    FROM barang
    WHERE deleted_at IS NULL
    AND (kode_barang LIKE ? OR nama_barang LIKE ?)
");
$stmt->bind_param("ss", $search_param, $search_param);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()['total'];

// $total_pages = ceil($total / $limit);
$total_pages = max(1, ceil($total / $limit));

// =======================
// PAGINATION RANGE
// =======================
$range = 2;
$start = max(1, $page - $range);
$end   = min($total_pages, $page + $range);
$page = min($page, $total_pages);

// =======================
// FETCH DATA
// =======================
$stmt = $conn->prepare("
    SELECT *
    FROM barang
    WHERE deleted_at IS NULL
    AND (kode_barang LIKE ? OR nama_barang LIKE ?)
    ORDER BY created_at DESC
    LIMIT ? OFFSET ?
");

$stmt->bind_param("ssii", $search_param, $search_param, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

// NOMOR URUT
$no = $offset + 1;

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>DASHBOARD BARANG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        body {
            min-height: 100vh;
        }

        /* LAYOUT */
        .main-layout {
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background-color: #212529;
            color: #fff;
            flex-shrink: 0;
            /* height: 100vh;
            overflow-y: auto; */
        }

        .sidebar .nav-link {
            color: #ccc;
            transition: 0.2s;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: #bb00c2;
        }

        /* Content */
        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
            width: 80%;
        }

        /* TABLE FIX MOBILE */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            white-space: nowrap;
        }

        /* MOBILE FIX */
        @media (max-width: 991px) {
            .main-layout {
                display: block; /* ⬅️ INI PALING PENTING */
            }

            .content {
                padding: 10px;
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="main-layout">

    <?php include "../templates/sidebar.php"; ?>

    <!-- CONTENT -->
    <div class="content">

        <div class="d-flex justify-content-between mb-3">
            <h3>DASHBOARD BARANG</h3>
            <div style="text-transform: uppercase;"><i class="bi bi-person-circle"></i> <b><?= htmlspecialchars($_SESSION['username']); ?></b></div>
        </div>

        <!-- SEARCH -->
        <form method="GET" class="mb-3 d-flex">
            <div class="input-group me-2" style="max-width: 600px;">
                <input type="text" name="search" class="form-control"
                       placeholder="CARI KODE BARANG/NAMA BARANG..."
                       value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-primary"><i class="bi bi-search"></i></button>
            </div>
            <a href="dashboard_barang.php" class="btn btn-secondary" style="border-radius: 50%;">
                <i class="bi bi-arrow-clockwise"></i>
            </a>
        </form>

        <!-- ADMIN BUTTON -->
        <?php if ($_SESSION['role'] === 'ADMIN'): ?>
            <a href="tambah_barang.php" class="btn btn-primary mb-3"><i class="bi bi-plus-circle"></i> TAMBAH BARANG</a>
        <?php endif; ?>

        <a href="../export/export_barang.php?search=<?= urlencode($search) ?>" class="btn btn-success mb-3">
            <i class="bi bi-file-earmark-excel"></i> EXPORT EXCEL
        </a>

        <!-- <div class="mb-2">
            TOTAL DATA: <b><?= $total ?></b>
        </div>

        <div class="mb-2">
            HALAMAN: <b><?= $page ?></b> / <?= $total_pages ?>
        </div> -->

        <!-- TABLE -->
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>NO.</th>
                                <th>KODE BARANG</th>
                                <th>NAMA BARANG</th>
                                <th>KODE DIVISI BARANG</th>
                                <th>DIVISI BARANG</th>
                                <th>KODE JENIS BARANG</th>
                                <th>JENIS BARANG</th>
                                <th>KODE BRAND</th>
                                <th>BRAND</th>
                                <th>BARCODE</th>
                                <th>SERIAL NUMBER</th>
                                <?php if ($_SESSION['role'] === 'ADMIN'): ?>
                                    <th>AKSI</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody style="text-transform: uppercase;">
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($row['kode_barang']) ?></td>
                                        <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                                        <td><?= htmlspecialchars($row['kode_divisi_barang']) ?></td>
                                        <td><?= htmlspecialchars($row['nama_divisi_barang']) ?></td>
                                        <td><?= htmlspecialchars($row['kode_jenis_barang']) ?></td>
                                        <td><?= htmlspecialchars($row['nama_jenis_barang']) ?></td>
                                        <td><?= htmlspecialchars($row['kode_brand_barang']) ?></td>
                                        <td><?= htmlspecialchars($row['nama_brand_barang']) ?></td>
                                        <td><?= htmlspecialchars($row['barcode']) ?></td>
                                        <td><?= htmlspecialchars($row['barcode_serial_number']) ?></td>
                                        <?php if ($_SESSION['role'] === 'ADMIN'): ?>
                                        <td>
                                            <a href="edit_barang.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm" style="border-radius: 50%;"><i class="bi bi-pencil-square"></i></a>
                                            <!-- <a href="hapus_barang.php?id=<?= $row['id']; ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus?')"><i class="bi bi-trash"></i></a> -->
                                            <form method="POST" action="hapus_barang.php" style="display:inline;">
                                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

                                                <button type="submit"
                                                        class="btn btn-danger btn-sm" style="border-radius: 50%;"
                                                        onclick="return confirm('YAKIN HAPUS?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="12" class="text-center">DATA TIDAK DITEMUKAN</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- PAGINATION SMART -->
            <nav>
                <ul class="pagination justify-content-center">
    
                    <!-- FIRST -->
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=1&search=<?= urlencode($search) ?>">AWAL</a>
                        </li>
                    <?php endif; ?>
    
                    <!-- PREV -->
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>">&lsaquo;</a>
                        </li>
                    <?php endif; ?>
    
                    <!-- DOT LEFT -->
                    <!-- <?php if ($start > 1): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php endif; ?> -->
    
                    <!-- PAGE RANGE -->
                    <?php for ($i = $start; $i <= $end; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link"
                                href="?page=<?= $i ?>&search=<?= urlencode($search) ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
    
                    <!-- DOT RIGHT -->
                    <!-- <?php if ($end < $total_pages): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php endif; ?> -->
    
                    <!-- NEXT -->
                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>">&rsaquo;</a>
                        </li>
                    <?php endif; ?>
    
                    <!-- LAST -->
                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $total_pages ?>&search=<?= urlencode($search) ?>">AKHIR</a>
                        </li>
                    <?php endif; ?>
    
                </ul>
            </nav>
        </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>
</html>