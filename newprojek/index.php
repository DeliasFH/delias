<?php
// File ini adalah halaman login
$error = isset($_GET['error']) ? true : false;
$registerSuccess = isset($_GET['register']) && $_GET['register'] === 'success';
$error = isset($_GET['error']) ? true : false;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Website Sekolah</title>
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
        .login-container {
            background: #fff;
            color: #222;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.12);
            padding: 40px 32px;
            max-width: 400px;
            width: 100%;
        }
        .login-container h2 {
            text-align: center;
            color: #6d2932;
            margin-bottom: 28px;
            font-size: 2em;
            font-weight: 700;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1em;
            font-family: 'Poppins', sans-serif;
        }
        .login-container button {
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
        .login-container button:hover {
            background: #4b1d1d;
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

        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #555;
        }
        .register-link a {
            color: #6d2932;
            font-weight: 600;
            text-decoration: none;
        }
        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-header img {
            width: 70px;
            border-radius: 10px;
            display: block;
            margin: 0 auto 10px auto;
        }
        .login-header h3 {
            margin:0;
            font-size: 1.4em;
            color: #6d2932;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <img src="logo/smk.png" alt="Logo SMK">
            <h3>LOGIN ACCOUNT</h3>
        </div>

        <?php if ($error): ?>
            <div class="error-message">Username atau password salah!</div>
        <?php endif; ?>

        <?php if ($registerSuccess): ?>
            <div class="success-message">Registrasi berhasil! Silakan login.</div>
        <?php endif; ?>

        <form method="POST" action="proses_login.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Masuk</button>
        </form>

        <div class="register-link">
            Belum punya akun? <a href="register.php">Daftar disini</a>
        </div>
    </div>
</body>
</html>