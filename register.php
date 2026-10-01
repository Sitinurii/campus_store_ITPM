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
    <title>Register - Campus Store</title>
</head>
<body>

<h2>Register Campus Store</h2>

<?php if ($pesan != ""): ?>
    <p><?php echo $pesan; ?></p>
<?php endif; ?>

<form method="post">

    <label>Nama</label><br>
    <input type="text" name="nama" required>

    <br><br>

    <label>Email</label><br>
    <input type="email" name="email" required>

    <br><br>

    <label>No. HP</label><br>
    <input type="text" name="no_hp">

    <br><br>

    <label>Password</label><br>
    <input type="password" name="password" required>

    <br><br>

    <button type="submit" name="register">
        Daftar
    </button>

</form>

<p>
    Sudah punya akun?
    <a href="login.php">Login</a>
</p>

</body>
</html>