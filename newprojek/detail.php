<?php
include 'config/koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan.";
    exit;
}

$id = $_GET['id'];
$query = "SELECT * FROM siswa WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Data siswa tidak ditemukan.";
    exit;
}

$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Siswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4b1d1d 0%, #6d2932 100%);
            margin: 0;
            padding: 40px 20px;
            color: #222;
        }
        .container {
            max-width: 600px;
            background: #fff;
            margin: auto;
            border-radius: 16px;
            box-shadow: 0 6px 24px rgba(0,0,0,0.1);
            padding: 30px 26px;
        }
        h2 {
            text-align: center;
            color: #6d2932;
            margin-bottom: 28px;
            font-weight: 600;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 12px 8px;
            vertical-align: top;
        }
        td:first-child {
            font-weight: 600;
            width: 180px;
            color: #6d2932;
        }
        .back-button {
            text-align: center;
            margin-top: 30px;
        }
        .back-button a {
            background: #6d2932;
            color: #fff;
            padding: 12px 30px;
            border-radius: 28px;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .back-button a:hover {
            background: #4b1d1d;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        @media (max-width: 700px) {
            .container {
                padding: 20px 16px;
            }
            td:first-child {
                width: 120px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>DETAIL SISWA</h2>
    <table>
        <tr><td>Nama</td><td><?= htmlspecialchars($data['nama']) ?></td></tr>
        <tr><td>NIS</td><td><?= htmlspecialchars($data['nis']) ?></td></tr>
        <tr><td>Kelas</td><td><?= htmlspecialchars($data['kelas'] ?? '-') ?></td></tr>
        <tr><td>Jurusan</td><td><?= htmlspecialchars($data['jurusan']) ?></td></tr>
        <tr>
            <td>Tempat, Tanggal Lahir</td>
            <td>
                <?= htmlspecialchars($data['tempat_lahir'] ?? '-') ?>,
                <?= !empty($data['tanggal_lahir']) ? date('d-m-Y', strtotime($data['tanggal_lahir'])) : '-' ?>
            </td>
        </tr>
        <tr><td>Alamat</td><td><?= htmlspecialchars($data['alamat'] ?? '-') ?></td></tr>
    </table>

    <div class="back-button">
        <a href="dashboard.php">Kembali ke Data Siswa</a>
    </div>
</div>

</body>
</html>
