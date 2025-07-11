<?php
include 'config/koneksi.php';
date_default_timezone_set('Asia/Jakarta');
$siswa = mysqli_query($conn, "SELECT * FROM siswa ORDER BY nama");

// Proses simpan nilai
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_siswa = $_POST['id_siswa'];
    $mapel = $_POST['mapel'];
    $nilai = $_POST['nilai'];
    $query = "INSERT INTO nilai (id_siswa, mapel, nilai) VALUES ('$id_siswa', '$mapel', '$nilai')";
    if (mysqli_query($conn, $query)) {
        $msg = "<div style='color:green; margin-bottom:10px;'>Nilai berhasil ditambahkan!</div>";
    } else {
        $msg = "<div style='color:red; margin-bottom:10px;'>Gagal menambah nilai.</div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Nilai Siswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f7f7f7; }
        .container { max-width: 420px; margin: 40px auto; background: #fff; border-radius: 14px; box-shadow: 0 4px 18px rgba(0,0,0,0.08); padding: 32px 28px; }
        h2 { color: #6d2932; text-align: center; margin-bottom: 24px; }
        label { display: block; margin-bottom: 6px; font-weight: 600; color: #6d2932; }
        select, input[type=text], input[type=number] { width: 100%; padding: 8px 10px; margin-bottom: 18px; border-radius: 6px; border: 1px solid #ccc; font-size: 1em; }
        button { background: #6d2932; color: #fff; border: none; padding: 10px 28px; border-radius: 20px; font-weight: 600; cursor: pointer; transition: 0.3s; }
        button:hover { background: #4b1d1d; }
        .back-link { display: inline-block; margin-top: 18px; text-decoration: none; color: #6d2932; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="container">
    <h2>Tambah Nilai Siswa</h2>
    <?php if (isset($msg)) echo $msg; ?>
    <form method="POST">
        <label>Pilih Siswa</label>
        <select name="id_siswa" required>
            <option value="">-- Pilih Siswa --</option>
            <?php while($row = mysqli_fetch_assoc($siswa)) {
                echo "<option value='{$row['id']}'>{$row['nama']} ({$row['nis']})</option>";
            } ?>
        </select>
        <label>Mata Pelajaran</label>
        <select name="mapel" required>
            <option value="">-- Pilih Mata Pelajaran --</option>
            <option value="BAHASA INDONESIA">BAHASA INDONESIA</option>
            <option value="BAHASA INGGRIS">BAHASA INGGRIS</option>
            <option value="BAHASA JAWA">BAHASA JAWA</option>
            <option value="DASAR PROGAM KEAHLIAN TKJ">DASAR PROGAM KEAHLIAN TKJ</option>
            <option value="MATEMATIKA">MATEMATIKA</option>
            <option value="PEMROGRAMAN PYTHON">PEMROGRAMAN PYTHON</option>
            <option value="PENDIDIKAN AGAMA ISLAM & BUDI PEKERTI">PENDIDIKAN AGAMA ISLAM & BUDI PEKERTI</option>
            <option value="PENDIDIKAN JASMANI, OLAHRAGA & KESEHATAN">PENDIDIKAN JASMANI, OLAHRAGA & KESEHATAN</option>
            <option value="PENDIDIKAN PANCASILA & KEWARGANEGARAAN">PENDIDIKAN PANCASILA & KEWARGANEGARAAN</option>
            <option value="PROJEK KREATIF & KEWIRAUSAHAAN">PROJEK KREATIF & KEWIRAUSAHAAN</option>
            <option value="SEJARAH">SEJARAH</option>
        </select>
        <label>Nilai</label>
        <input type="number" name="nilai" min="0" max="100" required placeholder="0-100">
        <button type="submit">Simpan Nilai</button>
    </form>
    <a href="dashboard.php" class="back-link">&larr; Kembali ke Dashboard</a>
</div>
</body>
</html>
