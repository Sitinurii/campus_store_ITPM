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

$ikon_kategori = [
    'jaket' => 'jacket',
    'kaos' => 'shirt',
    'tas' => 'bag',
    'topi' => 'cap'
];

$deskripsi_kategori = [
    'jaket' => 'Hangat dan berkarakter',
    'kaos' => 'Nyaman untuk setiap hari',
    'tas' => 'Teman untuk aktivitas kampus',
    'topi' => 'Aksesori khas kampus'
];
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
        <div class="category-intro-title">
            <p class="category-eyebrow">CAMPUS STORE <span>/</span> KOLEKSI</p>
            <h1>Merchandise untuk<br><em>cerita kampusmu.</em></h1>
        </div>
        <div class="category-intro-note">
            <p>Pilihan merchandise resmi untuk menemani keseharian dan merayakan kebanggaanmu sebagai bagian dari kampus.</p>
            <a href="produk.php">Lihat semua produk <span aria-hidden="true">&rarr;</span></a>
        </div>
    </section>

    <div class="category-summary">
        <h2>Pilih kategori</h2>
        <p><span><?php echo str_pad((string) count($kategori_list), 2, '0', STR_PAD_LEFT); ?></span> koleksi</p>
    </div>

    <div class="category-grid">
        <?php foreach ($kategori_list as $index => $kategori): ?>
            <?php $nama_kategori = $kategori['nama_kategori']; ?>
            <?php $jenis_ikon = $ikon_kategori[strtolower(trim($nama_kategori))] ?? 'other'; ?>
            <?php $deskripsi = $deskripsi_kategori[strtolower(trim($nama_kategori))] ?? 'Pilihan merchandise resmi kampus'; ?>
            <a class="category-card" href="produk.php?kategori=<?php echo urlencode($nama_kategori); ?>">
                <span class="category-card-index"><?php echo str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT); ?></span>
                <span class="category-card-copy">
                    <span class="category-card-title"><?php echo htmlspecialchars($nama_kategori, ENT_QUOTES, 'UTF-8'); ?></span>
                    <span class="category-card-description"><?php echo htmlspecialchars($deskripsi, ENT_QUOTES, 'UTF-8'); ?></span>
                </span>
                <span class="category-card-symbol" aria-hidden="true">
                    <svg class="category-icon category-icon-<?php echo htmlspecialchars($jenis_ikon, ENT_QUOTES, 'UTF-8'); ?>" viewBox="0 0 100 100" focusable="false">
                        <?php if ($jenis_ikon === 'jacket'): ?>
                            <path d="m35 18 15-7 15 7 20 15-11 18-10-7v43H36V44l-10 7-11-18 20-15Z"/>
                            <path d="m42 13 8 12 8-12M50 25v34m-14-15 8 5m20-5-8 5"/>
                        <?php elseif ($jenis_ikon === 'shirt'): ?>
                            <path d="m34 20 16-7 16 7 19 13-10 18-11-7v43H36V44l-11 7-10-18 19-13Z"/>
                            <path d="m41 16 9 14 9-14m-9 14v12"/>
                        <?php elseif ($jenis_ikon === 'bag'): ?>
                            <path d="M23 38h54l5 48H18l5-48Z"/>
                            <path d="M35 40V29a15 15 0 0 1 30 0v11"/>
                            <path d="M37 58h26"/>
                        <?php elseif ($jenis_ikon === 'cap'): ?>
                            <path d="M18 58c2-20 16-35 35-35 18 0 30 13 32 32l-31 7-36-4Z"/>
                            <path d="M18 58c15 12 37 14 67 3 7-3 11 0 10 5-1 7-13 14-30 17-21 3-40-4-49-14-4-4-3-8 2-11Z"/>
                            <path d="M52 25c3 7 4 15 3 24"/>
                        <?php else: ?>
                            <path d="M50 12 60 38l28 2-21 18 7 28-24-15-24 15 7-28-21-18 28-2 10-26Z"/>
                        <?php endif; ?>
                    </svg>
                </span>
                <span class="category-card-arrow" aria-hidden="true">&rarr;</span>
            </a>
        <?php endforeach; ?>
    </div>
</main>

<footer>
    <p>© 2026 Campus Store</p>
</footer>

</body>
</html>