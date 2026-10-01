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
    <title>Login - Campus Store</title>
</head>
<body>

<h2>Login Campus Store</h2>

<?php if ($pesan != ""): ?>
    <p><?php echo $pesan; ?></p>
<?php endif; ?>

<form method="post">

    <label>Email</label><br>
    <input type="email" name="email" required>

    <br><br>

    <label>Password</label><br>
    <input type="password" name="password" required>

    <br><br>

    <button type="submit" name="login">Login</button>

</form>

<p>
    Belum punya akun?
    <a href="register.php">Daftar</a>
</p>

</body>
</html>