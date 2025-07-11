<?php
include 'config/koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan.";
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = "SELECT * FROM siswa WHERE id='$id'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Data siswa tidak ditemukan.";
    exit;
}

$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $nis = mysqli_real_escape_string($conn, $_POST['nis']);
    $kelas = mysqli_real_escape_string($conn, $_POST['kelas']);
    $jurusan = mysqli_real_escape_string($conn, $_POST['jurusan']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    $update = "UPDATE siswa SET nama='$nama', nis='$nis', kelas='$kelas', jurusan='$jurusan', alamat='$alamat' WHERE id='$id'";
    if (mysqli_query($conn, $update)) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Gagal mengupdate data. Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Siswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f9f9f9;
            padding: 30px;
        }
        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
            padding: 30px 26px;
        }
        h2 {
            text-align: center;
            color: #6d2932;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        .button-group {
            text-align: center;
        }
        button {
            background: #6d2932;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 24px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s;
            text-decoration: none;
            display: inline-block;
            width: 220px;
            text-align: center;
            margin: 10px 5px 0 5px;
            box-sizing: border-box;
        }
        button:hover {
            background: #4b1d1d;
        }

        /* Modal Style */
        .modal {
            display: none;
            position: fixed;
            z-index: 99;
            left: 0; top: 0;
            width: 100%; height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }
        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 30px;
            border-radius: 10px;
            max-width: 400px;
            text-align: center;
        }
        .modal-content h3 {
            margin-bottom: 20px;
        }
        .modal-button {
            margin: 10px;
            padding: 10px 22px;
            border: none;
            border-radius: 24px;
            font-weight: 600;
            cursor: pointer;
        }
        .yes {
            background-color: #6d2932;
            color: white;
        }
        .no {
            background-color: #ccc;
            color: #333;
        }
        .yes:hover { background: #4b1d1d; }
        .no:hover { background: #999; }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Data Siswa</h2>
    <form method="POST" id="editForm">

         <label>Nama:</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" placeholder="Nama" required>

         <label>NIS:</label>
        <input type="text" name="nis" value="<?= htmlspecialchars($data['nis']) ?>" placeholder="NIS" required>

       <label>Kelas:</label>
        <select name="kelas" required>
            <option value="">-- Pilih Kelas --</option>
            <option value="X" <?= $data['kelas']=='X' ? 'selected' : '' ?>>X</option>
            <option value="XI" <?= $data['kelas']=='XI' ? 'selected' : '' ?>>XI</option>
            <option value="XII" <?= $data['kelas']=='XII' ? 'selected' : '' ?>>XII</option>
        </select>

        <label>Jurusan:</label>
        <select name="jurusan" required>
            <option value="">-- Pilih Jurusan --</option>
            <?php
            $jurusan_options = ["TKJ 1","TKJ 2","TPM 1","TPM 2","TPM 3","DKV 1","DKV 2","TKR 1","TKR 2","TITL 1","TITL 2","TITL 3","PSPT 1","PSPT 2","BD 1","BD 2","TL 1","TL 2","TL 3"];
            foreach($jurusan_options as $j){
                $sel = ($data['jurusan']==$j) ? 'selected' : '';
                echo "<option value='$j' $sel>$j</option>";
            }
            ?>
        </select>

         <label>Alamat:</label>
        <input type="text" name="alamat" value="<?= htmlspecialchars($data['alamat']) ?>" placeholder="Alamat" required>

        <div class="button-group">
            <button type="button" onclick="showSaveModal()">Simpan Perubahan</button>
            <button type="button" onclick="showBackModal()">Kembali</button>
        </div>
    </form>
</div>

<!-- Modal Simpan -->
<div id="saveModal" class="modal">
  <div class="modal-content">
    <h3>Simpan perubahan data ini?</h3>
    <button class="modal-button yes" type="submit" form="editForm">Ya, Simpan</button>
    <button class="modal-button no" onclick="closeModal('saveModal')">Tidak</button>
  </div>
</div>

<!-- Modal Kembali -->
<div id="backModal" class="modal">
  <div class="modal-content">
    <h3>Batal mengedit data ini?</h3>
    <button class="modal-button yes" onclick="window.location.href='dashboard.php'">Ya, kembali</button>
    <button class="modal-button no" onclick="closeModal('backModal')">Tidak</button>
  </div>
</div>

<script>
function showSaveModal() {
    document.getElementById('saveModal').style.display = 'block';
}
function showBackModal() {
    document.getElementById('backModal').style.display = 'block';
}
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = "none";
    }
}
</script>

</body>
</html>
