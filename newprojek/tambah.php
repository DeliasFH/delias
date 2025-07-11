<?php
include 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $nis = $_POST['nis'];
    $jurusan = $_POST['jurusan'];
    $kelas = $_POST['kelas'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];

    $query = "INSERT INTO siswa (nama, nis, jurusan, kelas, tempat_lahir, tanggal_lahir, alamat)
              VALUES ('$nama', '$nis', '$jurusan', '$kelas', '$tempat_lahir', '$tanggal_lahir', '$alamat')";
    mysqli_query($conn, $query);
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Siswa</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
            padding: 30px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .form-container {
            background-color: white;
            max-width: 600px;
            margin: 0 auto;
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
        }

        input[type="text"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

        .form-actions {
            margin-top: 25px;
            text-align: right;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-link {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Tambah Data Siswa</h2>
    <form method="POST" action="">
        <label>Nama:</label>
        <input type="text" name="nama" required>

        <label>NIS:</label>
        <input type="text" name="nis" required>

        <label>Kelas:</label>
        <select name="kelas" required>
            <option value="">-- Pilih Kelas --</option>
            <option value="X">X</option>
            <option value="XI">XI</option>
            <option value="XII">XII</option>
        </select>

        <label>Jurusan:</label>
        <select name="jurusan" required>
            <option value="">-- Pilih Jurusan --</option>
            <option value="TKJ 1">TKJ 1</option>
            <option value="TKJ 2">TKJ 2</option>
            <option value="TPM 1">TPM 1</option>
            <option value="TPM 2">TPM 2</option>
            <option value="TPM 3">TPM 3</option>
            <option value="DKV 1">DKV 1</option>
            <option value="DKV 2">DKV 2</option>
            <option value="TKR 1">TKR 1</option>
            <option value="TKR 2">TKR 2</option>
            <option value="TITL 1">TITL 1</option>
            <option value="TITL 2">TITL 2</option>
            <option value="TITL 3">TITL 3</option>
            <option value="PSPT 1">PSPT 1</option>
            <option value="PSPT 2">PSPT 2</option>
            <option value="BD 1">BD 1</option>
            <option value="BD 2">BD 2</option>
            <option value="TL 1">TL 1</option>
            <option value="TL 2">TL 2</option>
            <option value="TL 3">TL 3</option>
        </select>

        <label>Tempat Lahir:</label>
        <input type="text" name="tempat_lahir" required>

        <label>Tanggal Lahir:</label>
        <input type="date" name="tanggal_lahir" required>

        <label>Alamat:</label>
        <textarea name="alamat" rows="3" required></textarea>

        <div class="form-actions">
            <button type="submit">Simpan</button>
        </div>
    </form>
    <a href="dashboard.php" class="back-link">Kembali ke Data Siswa</a>
</div>

</body>
</html>
