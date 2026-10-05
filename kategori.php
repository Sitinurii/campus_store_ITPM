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
            <p class="category-eyebrow">KOLEKSI RESMI KAMPUS</p>
            <h1>Temukan gaya<br>kampusmu.</h1>
            <p class="category-description">Dari pakaian hingga aksesori, pilih koleksi favoritmu dan tunjukkan kebanggaanmu.</p>
            <a class="category-intro-button" href="produk.php">Belanja sekarang <span aria-hidden="true">&rarr;</span></a>
        </div>
        <div class="category-intro-art" aria-hidden="true">
            <span class="category-art-orbit"></span>
            <svg viewBox="0 0 240 240" role="presentation">
                <path d="M82 38 105 27h30l23 11 35 27-20 30-18-12v111H80V83L62 95 42 65l40-27Z" fill="currentColor"/>
                <path d="m105 27 15 21 15-21M120 48v33m-40 0 15 8m65-8-15 8" fill="none" stroke="#f3f6fa" stroke-linecap="round" stroke-linejoin="round" stroke-width="5"/>
                <path d="M103 111h34v28h-34z" fill="#f3f6fa" opacity=".95"/>
                <path d="M109 119h22m-22 7h22m-22 7h14" stroke="#222" stroke-linecap="round" stroke-width="2"/>
            </svg>
            <span class="category-art-caption">CAMPUS<br>COLLECTION</span>
        </div>
    </section>

    <div class="category-summary">
        <h2>Semua Kategori</h2>
        <p><?php echo count($kategori_list); ?> koleksi untuk dijelajahi</p>
    </div>

    <div class="category-grid">
        <?php foreach ($kategori_list as $index => $kategori): ?>
            <?php $nama_kategori = $kategori['nama_kategori']; ?>
            <a class="category-card" href="produk.php?kategori=<?php echo urlencode($nama_kategori); ?>">
                <span class="category-card-art" aria-hidden="true">
                    <span class="category-card-number"><?php echo str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT); ?></span>
                    <svg class="category-icon category-icon-<?php echo htmlspecialchars($ikon_kategori[strtolower(trim($nama_kategori))] ?? 'other', ENT_QUOTES, 'UTF-8'); ?>" viewBox="0 0 100 100" focusable="false">
                        <?php
                        $jenis_ikon = $ikon_kategori[strtolower(trim($nama_kategori))] ?? 'other';
                        if ($jenis_ikon === 'jacket'):
                        ?>
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
                    <span class="category-card-art-mark">CS</span>
                </span>
                <span class="category-card-content">
                    <span class="category-card-label">Koleksi kampus</span>
                    <span class="category-card-title"><?php echo htmlspecialchars($nama_kategori, ENT_QUOTES, 'UTF-8'); ?></span>
                    <span class="category-card-link">Jelajahi koleksi <span aria-hidden="true">&rarr;</span></span>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
</main>

<footer>
    <p>© 2026 Campus Store</p>
</footer>

</body>
</html>