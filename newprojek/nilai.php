<?php
include 'config/koneksi.php';

// Ambil data siswa
$query_siswa = "SELECT * FROM siswa";
$result_siswa = mysqli_query($conn, $query_siswa);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nilai Ujian Per Mapel</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h2 { color: #6d2932; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 40px; }
        th, td { border: 1px solid #6d2932; padding: 8px; text-align: center; }
        th { background-color: #6d2932; color: white; }
    </style>
</head>
<body>

<h2>Nilai Ujian Siswa Per Mapel</h2>

<?php
while ($siswa = mysqli_fetch_assoc($result_siswa)) {
    echo "<h3>".$siswa['nama']." (NIS: ".$siswa['nis'].")</h3>";

    // Ambil nilai untuk siswa ini
    $id_siswa = $siswa['id'];
    $query_nilai = "SELECT * FROM nilai WHERE id_siswa = $id_siswa";
    $result_nilai = mysqli_query($conn, $query_nilai);

    if (mysqli_num_rows($result_nilai) > 0) {
        echo "<table>";
        echo "<tr><th>Mata Pelajaran</th><th>Nilai</th></tr>";
        while ($nilai = mysqli_fetch_assoc($result_nilai)) {
            echo "<tr>";
            echo "<td>".htmlspecialchars($nilai['mapel'])."</td>";
            echo "<td>".htmlspecialchars($nilai['nilai'])."</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Belum ada nilai yang dimasukkan.</p>";
    }
}
?>

</body>
</html>
