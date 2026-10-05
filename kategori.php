<?php
require_once __DIR__ . '/koneksi.php';

$kategori_result = $koneksi->query("SELECT id_kategori, nama_kategori FROM kategori ORDER BY nama_kategori");
$kategori_list = [];

if ($kategori_result) {
    while ($row = $kategori_result->fetch_assoc()) {
        $kategori_list[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori - Kampus Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="logo">CAMPUS STORE</div>

    <nav>
        <a href="index.php">BERANDA</a>
        <a href="produk.php">PRODUK</a>
        <a href="kategori.php">KATEGORI</a>
        <a href="index.php#tentang">TENTANG</a>
    </nav>

    <div class="header-right">
        <a href="keranjang.php" aria-label="Keranjang">🛒</a>
        <a href="login.php" aria-label="Masuk">👤</a>
    </div>
</header>

<main class="section">
    <h2>KATEGORI</h2>
    <p>Pilih kategori untuk melihat merchandise yang tersedia.</p>

    <div class="category-list">
        <?php if (!empty($kategori_list)): ?>
            <?php foreach ($kategori_list as $kategori): ?>
                <a href="produk.php?kategori=<?php echo urlencode($kategori['nama_kategori']); ?>">
                    <?php echo htmlspecialchars($kategori['nama_kategori'], ENT_QUOTES, 'UTF-8'); ?>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <a href="produk.php?kategori=Jaket">Jaket</a>
            <a href="produk.php?kategori=Kaos">Kaos</a>
            <a href="produk.php?kategori=Tas">Tas</a>
            <a href="produk.php?kategori=Topi">Topi</a>
        <?php endif; ?>
    </div>
</main>

<footer>
    <p>© 2026 Campus Store</p>
</footer>

</body>
</html>
