<?php
include 'config/koneksi.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Validasi input
    if (empty($username) || empty($password) || empty($confirm_password) || empty($nama)) {
        $error = "Semua field harus diisi!";
    } elseif ($password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak sama!";
    } else {
        // Cek apakah username sudah ada
        $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Username sudah digunakan!";
        } else {
            // Enkripsi password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Simpan ke tabel users/login
            $query_user = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
            if (mysqli_query($conn, $query_user)) {
                // Simpan juga ke biodata siswa
                $query_biodata = "INSERT INTO siswa (nama, username) VALUES ('$nama', '$username')";
                if (mysqli_query($conn, $query_biodata)) {
                    header("Location: index.php?register=success");
                    exit();
                } else {
                    $error = "Register berhasil, tapi gagal menyimpan biodata: " . mysqli_error($conn);
                }
            } else {
                $error = "Gagal mendaftarkan akun: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - Website Sekolah</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4b1d1d 0%, #6d2932 100%);
            color: #fff;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-container {
            background: #fff;
            color: #222;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.12);
            padding: 40px 32px;
            max-width: 400px;
            width: 100%;
        }
        .register-container h2 {
            text-align: center;
            color: #6d2932;
            margin-bottom: 28px;
            font-size: 2em;
            font-weight: 700;
        }
        .register-container input[type="text"],
        .register-container input[type="password"],
        .register-container select {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1em;
            font-family: 'Poppins', sans-serif;
        }
        .register-container button {
            width: 100%;
            background: #6d2932;
            color: #fff;
            border: none;
            padding: 12px 0;
            border-radius: 24px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }
        .register-container button:hover {
            background: #4b1d1d;
        }
        .register-container .icon {
            font-size: 2.2em;
            color: #6d2932;
            display: block;
            text-align: center;
            margin-bottom: 10px;
        }
        .error-message {
            color: #b32b2b; 
            background: #ffeaea;
            border-radius: 8px;
            padding: 8px 0;
            margin-bottom: 16px;
            text-align: center;
            font-size: 0.98em;
        }
        .success-message {
            color: #28a745;
            background: #e8f5e9;
            border-radius: 8px;
            padding: 8px 0;
            margin-bottom: 16px;
            text-align: center;
            font-size: 0.98em;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #555;
        }
        .login-link a {
            color: #6d2932;
            font-weight: 600;
            text-decoration: none;
        }
        .register-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .register-header img {
            width: 70px;
            border-radius: 10px;
            display: block;
            margin: 0 auto 10px auto;
        }
        .register-header h3 {
            margin:0;
            font-size: 1.4em;
            color: #6d2932;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <img src="logo/smk.png" alt="Logo SMK">
            <h3>BUAT AKUN BARU</h3>
        </div>

        <?php if ($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success-message"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="nama" placeholder="Nama Lengkap" required
                   value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>">
                   
            <input type="text" name="username" placeholder="Username" required 
                value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            
            <input type="password" name="password" placeholder="Password" required>
            
            <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
    
    <button type="submit">Daftar</button>
</form>

        <div class="login-link">
            Sudah punya akun? <a href="index.php">Login disini</a>
        </div>
    </div>
</body>
</html>