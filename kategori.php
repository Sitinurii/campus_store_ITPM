<?php
require_once __DIR__ . '/koneksi.php';

$kategori_result = $koneksi->query("SELECT id_kategori, nama_kategori FROM kategori ORDER BY nama_kategori");
$kategori_list = [];

if (!$kategori_result) {
    http_response_code(500);
    exit('Gagal memuat kategori: ' . htmlspecialchars($koneksi->error, ENT_QUOTES, 'UTF-8'));
}

while ($row = $kategori_result->fetch_assoc()) {
    $kategori_list[] = $row;
}

if (empty($kategori_list)) {
    $kategori_list = [
        ['nama_kategori' => 'Jaket'],
        ['nama_kategori' => 'Kaos'],
        ['nama_kategori' => 'Tas'],
        ['nama_kategori' => 'Topi']
    ];
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
        <form class="header-search" action="produk.php" method="get" role="search">
            <input type="search" name="q" placeholder="Cari produk..." aria-label="Cari produk">
            <button type="submit">Cari</button>
        </form>
        <a href="keranjang.php" aria-label="Keranjang">🛒</a>
        <a href="login.php" aria-label="Masuk">👤</a>
    </div>
</header>

<main class="section category-page">
    <section class="category-intro">
        <div>
            <p class="category-eyebrow">CAMPUS STORE</p>
            <h1>Jelajahi Kategori</h1>
            <p>Temukan merchandise kampus yang cocok untuk menemani aktivitasmu.</p>
        </div>
        <a class="category-all-link" href="produk.php">Lihat semua produk <span aria-hidden="true">&rarr;</span></a>
    </section>

    <div class="category-summary">
        <h2>Semua Kategori</h2>
        <p><?php echo count($kategori_list); ?> pilihan untuk dijelajahi</p>
    </div>

    <div class="category-grid">
        <?php foreach ($kategori_list as $index => $kategori): ?>
            <?php $nama_kategori = $kategori['nama_kategori']; ?>
            <a class="category-card" href="produk.php?kategori=<?php echo urlencode($nama_kategori); ?>">
                <span class="category-card-number"><?php echo str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT); ?></span>
                <h3><?php echo htmlspecialchars($nama_kategori, ENT_QUOTES, 'UTF-8'); ?></h3>
                <span class="category-card-link">Lihat koleksi <span aria-hidden="true">&rarr;</span></span>
            </a>
        <?php endforeach; ?>
    </div>
</main>

<footer>
    <p>© 2026 Campus Store</p>
</footer>

</body>
</html>