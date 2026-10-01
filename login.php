<?php
session_start();
require_once "koneksi.php";

if (isset($_SESSION['id_user'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/index.php");
    } else {
        header("Location: index.php");
    }
    exit;
}

$pesan = "";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $koneksi->prepare(
        "SELECT id_user, nama, email, password, role 
         FROM users 
         WHERE email = ?"
    );

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $hasil = $stmt->get_result();

    if ($hasil->num_rows == 1) {
        $user = $hasil->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') {
                header("Location: admin/index.php");
            } else {
                header("Location: index.php");
            }

            exit;

        } else {
            $pesan = "Email atau password salah.";
        }

    } else {
        $pesan = "Email atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Campus Store</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #222;
        }

        header {
            background: white;
            padding: 20px 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
        }

        nav {
            display: flex;
            gap: 30px;
        }

        nav a {
            text-decoration: none;
            color: #222;
            font-size: 14px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-right input {
            padding: 9px 12px;
            border: 1px solid #ccc;
            width: 180px;
        }

        .header-right a {
            text-decoration: none;
            font-size: 20px;
            color: #222;
        }

        .login-section {
            min-height: 70vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 20px;
        }

        .login-box {
            background: white;
            width: 400px;
            padding: 40px;
            border: 1px solid #ddd;
        }

        .login-box h1 {
            margin-top: 0;
            margin-bottom: 10px;
            text-align: center;
            font-size: 28px;
        }

        .login-box .description {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .form-group input:focus {
            outline: none;
            border-color: #222;
        }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: #222;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-login:hover {
            background: #444;
        }

        .pesan {
            background: #f8d7da;
            color: #842029;
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }

        .register {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
        }

        .register a {
            color: #222;
            font-weight: bold;
            text-decoration: none;
        }

        .register a:hover {
            text-decoration: underline;
        }

        footer {
            background: white;
            border-top: 1px solid #ddd;
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }

        @media (max-width: 800px) {
            header {
                padding: 20px;
                flex-direction: column;
                gap: 20px;
            }

            nav {
                gap: 15px;
            }

            .header-right input {
                width: 150px;
            }
        }
    </style>
</head>

<body>

<header>

    <div class="logo">CAMPUS STORE</div>

    <nav>
        <a href="index.php">BERANDA</a>
        <a href="produk.php">PRODUK</a>
        <a href="#">KATEGORI</a>
        <a href="#">TENTANG</a>
    </nav>

    <div class="header-right">
        <input type="text" placeholder="Cari produk...">
        <a href="keranjang.php">🛒</a>
        <a href="login.php">👤</a>
    </div>

</header>


<section class="login-section">

    <div class="login-box">

        <h1>LOGIN</h1>

        <p class="description">
            Masuk ke akun Campus Store kamu
        </p>

        <?php if ($pesan != ""): ?>

            <div class="pesan">
                <?php echo $pesan; ?>
            </div>

        <?php endif; ?>


        <form method="post">

            <div class="form-group">
                <label>Email</label>
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Masukkan email"
                    required
                >
            </div>


            <div class="form-group">
                <label>Password</label>
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Masukkan password"
                    required
                >
            </div>


            <button 
                type="submit" 
                name="login" 
                class="btn-login"
            >
                LOGIN
            </button>

        </form>


        <div class="register">
            Belum punya akun?
            <a href="register.php">DAFTAR SEKARANG</a>
        </div>

    </div>

</section>


<footer>
    <p>© 2026 Campus Store</p>
</footer>

</body>
</html>