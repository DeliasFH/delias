<?php
// Koneksi ke database
include 'config/koneksi.php';

// Ambil ID siswa dari parameter GET
$id_siswa = isset($_GET['id_siswa']) ? intval($_GET['id_siswa']) : 0;

// Query untuk mendapatkan data nilai siswa
$query = "SELECT * FROM nilai WHERE id_siswa = $id_siswa";
$result = mysqli_query($conn, $query);

// Siapkan array untuk response
$response = array(
    'success' => false,
    'data' => array()
);

// Jika query berhasil
if ($result) {
    $response['success'] = true;
    
    // Ambil semua data nilai
    while ($row = mysqli_fetch_assoc($result)) {
        $response['data'][] = array(
            'mapel' => $row['mapel'],
            'nilai' => $row['nilai']
        );
    }
}

// Set header sebagai JSON
header('Content-Type: application/json');

// Output response sebagai JSON
echo json_encode($response);

// Tutup koneksi
mysqli_close($conn);
?>