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
$search = trim($_GET['search'] ?? '');
$search_param = "%$search%";

// =======================
// COUNT TOTAL DATA
// =======================
$stmt = $conn->prepare("
    SELECT COUNT(*) as total
    FROM gudang_jkt
    WHERE deleted_at IS NULL
    AND (
        kode_barang LIKE ?
        OR nama_barang LIKE ?
        OR kode_gudang LIKE ?
        OR nama_gudang LIKE ?
    )
");
$stmt->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()['total'];

$total_pages = max(1, ceil($total / $limit));

// FIX page overflow
$page = min($page, $total_pages);
$offset = ($page - 1) * $limit;

// =======================
// PAGINATION RANGE
// =======================
$range = 2;
$start = max(1, $page - $range);
$end   = min($total_pages, $page + $range);

// =======================
// FETCH DATA
// =======================
$stmt = $conn->prepare("
    SELECT *
    FROM gudang_jkt
    WHERE deleted_at IS NULL
    AND (
        kode_barang LIKE ?
        OR nama_barang LIKE ?
        OR kode_gudang LIKE ?
        OR nama_gudang LIKE ?
    )
    ORDER BY tgl_masuk_barang DESC
    LIMIT ? OFFSET ?
");
$stmt->bind_param("ssssii", $search_param, $search_param, $search_param, $search_param, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

// nomor urut
$no = $offset + 1;

// CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>DASHBOARD GUDANG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
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

    <div class="content">

    <div class="d-flex justify-content-between mb-3">
        <h3>DASHBOARD GUDANG - JAKARTA</h3>
        <div style="text-transform: uppercase;"><i class="bi bi-person-circle"></i> <b><?= htmlspecialchars($_SESSION['username']); ?></b></div>
    </div>

    <!-- SEARCH -->
    <form method="GET" class="mb-3 d-flex">
        <input type="text" name="search" class="form-control me-2"
               placeholder="CARI KODE BARANG/NAMA BARANG"
               value="<?= htmlspecialchars($search) ?>">
        <button class="btn btn-primary"><i class="bi bi-search"></i></button>
    </form>

    <!-- ADMIN BUTTON -->
    <!-- <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'ADMIN'): ?>
        <a href="tambah_gudang.php" class="btn btn-success mb-3">
            <i class="bi bi-plus-circle"></i> TAMBAH STOK
        </a>
    <?php endif; ?> -->

    <!-- ADMIN BUTTON -->
    <?php if ($_SESSION['role'] === 'ADMIN'): ?>
        <a href="tambah_barang.php" class="btn btn-primary mb-3"><i class="bi bi-plus-circle"></i> TAMBAH BARANG</a>
    <?php endif; ?>

    <!-- INFO -->
    <!-- <div class="mb-2">
        TOTAL DATA: <b><?= $total ?></b> | HALAMAN: <?= $page ?> / <?= $total_pages ?>
    </div> -->

    <!-- TABLE -->
    <div class="card shadow">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>NO.</th>
                        <th>GROUP GUDANG</th>
                        <th>KODE GUDANG</th>
                        <th>NAMA GUDANG</th>
                        <th>KODE SUPPLIER</th>
                        <th>KODE BARANG</th>
                        <th>NAMA BARANG</th>
                        <th>KODE DIVISI BARANG</th>
                        <th>DIVISI BARANG</th>
                        <th>KODE JENIS BARANG</th>
                        <th>JENIS BARANG</th>
                        <th>KODE_BRAND_BARANG</th>
                        <th>BRAND BARANG</th>
                        <th>BARCODE</th>
                        <th>BARCODE SERIAL NUMBER</th>
                        <th>SATUAN</th>
                        <th>FRAKSI</th>
                        <th>HARGA BELI</th>
                        <th>QTY</th>
                        <th>TGL. MASUK BARANG</th>
                        <th>KETERANGAN</th>
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
                            <td><?= htmlspecialchars($row['group_gudang']) ?></td>
                            <td><?= htmlspecialchars($row['kode_gudang']) ?></td>
                            <td><?= htmlspecialchars($row['nama_gudang']) ?></td>
                            <td><?= htmlspecialchars($row['kode_supplier']) ?></td>
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
                            <td><?= htmlspecialchars($row['satuan']) ?></td>
                            <td><?= number_format($row['fraksi']) ?></td>
                            <td><?= number_format($row['harga_beli']) ?></td>
                            <td><?= number_format($row['qty']) ?></td>
                            <td><?= htmlspecialchars($row['tgl_masuk_barang']) ?></td>
                            <td><?= htmlspecialchars($row['keterangan']) ?></td>

                            <?php if ($_SESSION['role'] === 'ADMIN'): ?>
                            <td>
                                <a href="edit_gudang.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm" style="border-radius: 50%;">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form method="POST" action="hapus_gudang.php" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                    <button class="btn btn-danger btn-sm" style="border-radius: 50%;"
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
                        <td colspan="22">DATA TIDAK DITEMUKAN</td>
                    </tr>
                <?php endif; ?>
                </tbody>

            </table>
        </div>

        <!-- PAGINATION -->
        <nav class="p-3">
            <ul class="pagination justify-content-center">

                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=1&search=<?= urlencode($search) ?>">AWAL</a>
                    </li>
                <?php endif; ?>

                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>">&lsaquo;</a>
                    </li>
                <?php endif; ?>

                <?php for ($i=$start; $i<=$end; $i++): ?>
                    <li class="page-item <?= $i==$page?'active':'' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>">&rsaquo;</a>
                    </li>
                <?php endif; ?>

                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $total_pages ?>&search=<?= urlencode($search) ?>">AKHIR</a>
                    </li>
                <?php endif; ?>

            </ul>
        </nav>

    </div>

</div>

</body>
</html>