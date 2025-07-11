<?php
include 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete']) && isset($_POST['id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    
    // Mulai transaksi
    mysqli_begin_transaction($conn);
    
    try {
        // 1. Hapus data nilai terkait
        $query1 = "DELETE FROM nilai WHERE id_siswa='$id'";
        if (!mysqli_query($conn, $query1)) {
            throw new Exception("Gagal menghapus data nilai");
        }
        
        // 2. Hapus data siswa
        $query2 = "DELETE FROM siswa WHERE id='$id'";
        if (!mysqli_query($conn, $query2)) {
            throw new Exception("Gagal menghapus data siswa");
        }
        
        // Commit transaksi jika berhasil
        mysqli_commit($conn);
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        // Rollback jika ada error
        mysqli_rollback($conn);
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hapus Data Siswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f9f9f9;
            margin: 0;
        }
        .modal {
            display: block;
            position: fixed;
            z-index: 99;
            left: 0; 
            top: 0;
            width: 100%; 
            height: 100%;
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
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .modal-content h3 {
            margin-bottom: 20px;
            color: #333;
        }
        .detail-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 24px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            color: white;
            transition: 0.3s;
        }
        .detail-button:hover {
            opacity: 0.9;
        }
        .button-group {
            display: flex;
            justify-content: center;
            margin-top: 25px;
        }
        form {
            margin: 0;
        }
    </style>
</head>
<body>

<!-- Modal Konfirmasi -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <h3>Apakah Anda yakin ingin menghapus data ini?</h3>
        <div class="button-group">
            <form method="post">
                <input type="hidden" name="confirm_delete" value="1">
                <button type="submit" class="detail-button" style="background:#b32b2b;">
                    <i class="bi bi-trash"></i> Ya, Hapus
                </button>
            </form>
            <button type="button" class="detail-button" style="background:#6d2932;" onclick="window.location.href='dashboard.php'">
                <i class="bi bi-x"></i> Tidak
            </button>
        </div>
    </div>
</div>

<script>
// Fungsi untuk menutup modal (jika masih diperlukan)
function closeDeleteModal() {
    window.location.href = 'dashboard.php';
}
</script>

</body>
</html>