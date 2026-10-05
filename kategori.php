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

<main class="section category-page">
    <div class="category-heading">
        <p class="category-eyebrow">Jelajahi Campus Store</p>
        <h1>Kategori Produk</h1>
        <p>Pilih kategori untuk menemukan merchandise kampus favoritmu.</p>
    </div>

    <div class="category-grid">
        <?php if (!empty($kategori_list)): ?>
            <?php foreach ($kategori_list as $kategori): ?>
                <a class="category-card" href="produk.php?kategori=<?php echo urlencode($kategori['nama_kategori']); ?>">
                    <span class="category-card-label">Kategori</span>
                    <h2><?php echo htmlspecialchars($kategori['nama_kategori'], ENT_QUOTES, 'UTF-8'); ?></h2>
                    <span class="category-card-action">Lihat produk <span aria-hidden="true">&rarr;</span></span>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <a class="category-card" href="produk.php?kategori=Jaket">
                <span class="category-card-label">Kategori</span>
                <h2>Jaket</h2>
                <span class="category-card-action">Lihat produk <span aria-hidden="true">&rarr;</span></span>
            </a>
            <a class="category-card" href="produk.php?kategori=Kaos">
                <span class="category-card-label">Kategori</span>
                <h2>Kaos</h2>
                <span class="category-card-action">Lihat produk <span aria-hidden="true">&rarr;</span></span>
            </a>
            <a class="category-card" href="produk.php?kategori=Tas">
                <span class="category-card-label">Kategori</span>
                <h2>Tas</h2>
                <span class="category-card-action">Lihat produk <span aria-hidden="true">&rarr;</span></span>
            </a>
            <a class="category-card" href="produk.php?kategori=Topi">
                <span class="category-card-label">Kategori</span>
                <h2>Topi</h2>
                <span class="category-card-action">Lihat produk <span aria-hidden="true">&rarr;</span></span>
            </a>
        <?php endif; ?>
    </div>
</main>

<footer>
    <p>© 2026 Campus Store</p>
</footer>

</body>
</html>
