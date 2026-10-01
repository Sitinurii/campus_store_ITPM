<?php
require_once "koneksi.php";

$pesan = "";

if (isset($_POST['register'])) {

    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $no_hp = trim($_POST['no_hp']);

    if ($nama == "" || $email == "" || $password == "") {

        $pesan = "Nama, email, dan password wajib diisi.";

    } else {

        $cek = $koneksi->prepare(
            "SELECT id_user FROM users WHERE email = ?"
        );

        $cek->bind_param("s", $email);
        $cek->execute();

        $hasil = $cek->get_result();

        if ($hasil->num_rows > 0) {

            $pesan = "Email sudah terdaftar.";

        } else {

            $password_hash = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $stmt = $koneksi->prepare(
                "INSERT INTO users 
                (nama, email, password, no_hp, role)
                VALUES (?, ?, ?, ?, 'user')"
            );

            $stmt->bind_param(
                "ssss",
                $nama,
                $email,
                $password_hash,
                $no_hp
            );

            if ($stmt->execute()) {

                header("Location: login.php");
                exit;

            } else {

                $pesan = "Registrasi gagal.";

            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Campus Store</title>

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

        .register-section {
            min-height: 75vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 20px;
        }

        .register-box {
            background: white;
            width: 430px;
            padding: 40px;
            border: 1px solid #ddd;
        }

        .register-box h1 {
            margin-top: 0;
            margin-bottom: 10px;
            text-align: center;
            font-size: 28px;
        }

        .description {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 18px;
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

        .btn-register {
            width: 100%;
            padding: 13px;
            background: #222;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-register:hover {
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

        .login {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
        }

        .login a {
            color: #222;
            font-weight: bold;
            text-decoration: none;
        }

        .login a:hover {
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

            .register-box {
                width: 100%;
                max-width: 430px;
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


<section class="register-section">

    <div class="register-box">

        <h1>DAFTAR</h1>

        <p class="description">
            Buat akun Campus Store kamu
        </p>

        <?php if ($pesan != ""): ?>

            <div class="pesan">
                <?php echo $pesan; ?>
            </div>

        <?php endif; ?>


        <form method="post">

            <div class="form-group">
                <label>Nama</label>

                <input
                    type="text"
                    name="nama"
                    placeholder="Masukkan nama"
                    required
                >
            </div>


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
                <label>No. HP</label>

                <input
                    type="text"
                    name="no_hp"
                    placeholder="Masukkan nomor HP"
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
                name="register"
                class="btn-register"
            >
                DAFTAR
            </button>

        </form>


        <div class="login">
            Sudah punya akun?
            <a href="login.php">LOGIN</a>
        </div>

    </div>

</section>


<footer>
    <p>© 2026 Campus Store</p>
</footer>

</body>
</html>