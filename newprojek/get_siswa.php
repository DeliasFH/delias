<?php
header('Content-Type: application/json');

require_once 'config/koneksi.php';

try {
    $idSiswa = (int)$_GET['id_siswa'];
    
    $stmt = $conn->prepare("SELECT nama, nis, kelas, jurusan FROM siswa WHERE id = ?");
    $stmt->bind_param('i', $idSiswa);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Siswa tidak ditemukan']);
        exit;
    }
    
    echo json_encode([
        'success' => true,
        'data' => $result->fetch_assoc()
    ]);
    
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>