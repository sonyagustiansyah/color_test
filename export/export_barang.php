<?php
include '../config/database.php';

$search = $_GET['search'] ?? '';
$search_param = "%$search%";

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=barang.xls");

$stmt = $conn->prepare("
    SELECT * FROM barang
    WHERE deleted_at IS NULL
    AND (kode_barang LIKE ? OR nama_barang LIKE ?)
");
$stmt->bind_param("ss",$search_param,$search_param);
$stmt->execute();
$result = $stmt->get_result();

echo "<table border='1'>";

echo "<tr>
        <th class='text-center'>NO.</th>
        <th class='text-center'>KODE BARANG</th>
        <th class='text-center'>NAMA BARANG</th>
        <th class='text-center'>KODE DIVISI BARANG</th>
        <th class='text-center'>DIVISI BARANG</th>
        <th class='text-center'>KODE JENIS BARANG</th>
        <th class='text-center'>JENIS BARANG</th>
        <th class='text-center'>KODE BRAND BARANG</th>
        <th class='text-center'>BRAND BARANG</th>
        <th class='text-center'>BARCODE</th>
        <th class='text-center'>BARCODE_SERIAL_NUMBER</th>
      </tr>";

$no = 1;

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$no}</td>
            <td>{$row['kode_barang']}</td>
            <td>{$row['nama_barang']}</td>
            <td>{$row['kode_divisi_barang']}</td>
            <td>{$row['nama_divisi_barang']}</td>
            <td>{$row['kode_jenis_barang']}</td>
            <td>{$row['nama_jenis_barang']}</td>
            <td>{$row['kode_brand_barang']}</td>
            <td>{$row['nama_brand_barang']}</td>
            <td>{$row['barcode']}</td>
            <td>{$row['barcode_serial_number']}</td>
          </tr>";
    $no++;
}

echo "</table>";
exit;