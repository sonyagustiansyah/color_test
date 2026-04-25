<?php
include '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$barang_id = $_GET['barang_id'] ?? 0;
$gudang_id = $_GET['gudang_id'] ?? 0;

// =======================
// PAGINATION
// =======================
$limit = 10;
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

// =======================
// INFO BARANG
// =======================
$info = $conn->prepare("
    SELECT b.kdbrg, b.nmbrg, g.nama as gudang
    FROM barang b
    JOIN gudang_jkt g ON g.id = ?
    WHERE b.id = ?
");
$info->bind_param("ii", $gudang_id, $barang_id);
$info->execute();
$data_info = $info->get_result()->fetch_assoc();

if (!$data_info) {
    echo "<div class='alert alert-danger'>DATA TIDAK DITEMUKAN</div>";
    exit;
}

// =======================
// COUNT
// =======================
$count = $conn->prepare("
    SELECT COUNT(*) as total
    FROM stok_mutasi_jkt
    WHERE barang_id = ? AND gudang_id = ?
");
$count->bind_param("ii", $barang_id, $gudang_id);
$count->execute();
$total = $count->get_result()->fetch_assoc()['total'];

$total_pages = ceil($total / $limit);

// =======================
// PAGINATION RANGE (SMART)
// =======================
$range = 2;

$start = max(1, $page - $range);
$end   = min($total_pages, $page + $range);

// =======================
// DATA MUTASI
// =======================
$stmt = $conn->prepare("
    SELECT 
        tipe,
        qty,
        keterangan,
        created_at
    FROM stok_mutasi_jkt
    WHERE barang_id = ? AND gudang_id = ?
    ORDER BY created_at DESC
    LIMIT ? OFFSET ?
");

$stmt->bind_param("iiii", $barang_id, $gudang_id, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>MUTASI STOK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

    <div class="row">
        <div class="col-md-6 mb-3">
            <h4>MUTASI STOK</h4>
            <span><?= $data_info['kdbrg'] ?> - <?= $data_info['nmbrg'] ?></span>
            <span>GUDANG: <?= $data_info['gudang'] ?></span>
        </div>
        <div class="col-md-6 text-end">
            <a href="dashboard_gudang_jkt.php" class="btn btn-danger mb-3">KEMBALI</a>            
        </div>

    </div>

    <div class="card shadow">
        <div class="card-body table-responsive">

            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>NO.</th>
                        <th>TANGGAL</th>
                        <th>TIPE</th>
                        <th>QTY</th>
                        <th>KETERANGAN</th>
                    </tr>
                </thead>

                <tbody>
                <?php $no = $offset + 1; ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['created_at'] ?></td>
                        <td>
                            <?php if ($row['tipe'] == 'IN'): ?>
                                <span>IN</span>
                            <?php elseif ($row['tipe'] == 'OUT'): ?>
                                <span>OUT</span>
                            <?php else: ?>
                                <span><?= $row['tipe'] ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?= $row['qty'] ?></td>
                        <td><?= $row['keterangan'] ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>

            </table>

            <!-- PAGINATION -->
            <nav>
                <ul class="pagination justify-content-center">

                    <!-- FIRST -->
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link"
                            href="?barang_id=<?= $barang_id ?>&gudang_id=<?= $gudang_id ?>&page=1">
                            AWAL
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- PREV -->
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link"
                            href="?barang_id=<?= $barang_id ?>&gudang_id=<?= $gudang_id ?>&page=<?= $page-1 ?>">
                            &lsaquo;
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- PAGE RANGE -->
                    <?php for ($i = $start; $i <= $end; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link"
                            href="?barang_id=<?= $barang_id ?>&gudang_id=<?= $gudang_id ?>&page=<?= $i ?>">
                            <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <!-- NEXT -->
                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link"
                            href="?barang_id=<?= $barang_id ?>&gudang_id=<?= $gudang_id ?>&page=<?= $page+1 ?>">
                            &rsaquo;
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- LAST -->
                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link"
                            href="?barang_id=<?= $barang_id ?>&gudang_id=<?= $gudang_id ?>&page=<?= $total_pages ?>">
                            AKHIR
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </nav>

        </div>
    </div>

</div>

</body>
</html>