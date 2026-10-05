<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - Kampus Store</title>
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
        <a href="keranjang.php">🛒</a>
        <a href="#">👤</a>
    </div>
</header>

<section class="section">

    <?php
    $produk = [
        [
            "id" => 1,
            "nama" => "Jaket Almamater",
            "harga" => 250000,
            "kategori" => "Jaket"
        ],
        [
            "id" => 2,
            "nama" => "Kaos Kampus",
            "harga" => 85000,
            "kategori" => "Kaos"
        ],
        [
            "id" => 3,
            "nama" => "Tote Bag",
            "harga" => 65000,
            "kategori" => "Tas"
        ],
        [
            "id" => 4,
            "nama" => "Topi Kampus",
            "harga" => 50000,
            "kategori" => "Topi"
        ]
    ];

    $kategori = trim($_GET['kategori'] ?? '');
    $kata_kunci = trim($_GET['q'] ?? '');
    $produk_ditemukan = array_filter($produk, function ($item) use ($kategori, $kata_kunci) {
        $sesuai_kategori = $kategori === '' || strcasecmp($item['kategori'], $kategori) === 0;
        $sesuai_pencarian = $kata_kunci === '' || stripos($item['nama'], $kata_kunci) !== false;

        return $sesuai_kategori && $sesuai_pencarian;
    });
    ?>

    <h1>
        <?php
        echo $kata_kunci !== ''
            ? 'Hasil pencarian: ' . htmlspecialchars($kata_kunci, ENT_QUOTES, 'UTF-8')
            : ($kategori !== ''
                ? 'Kategori: ' . htmlspecialchars($kategori, ENT_QUOTES, 'UTF-8')
                : 'Semua Produk');
        ?>
    </h1>

    <div class="filter">
        <a href="produk.php">Semua</a>
        <a href="produk.php?kategori=Jaket">Jaket</a>
        <a href="produk.php?kategori=Kaos">Kaos</a>
        <a href="produk.php?kategori=Tas">Tas</a>
        <a href="produk.php?kategori=Topi">Topi</a>
    </div>

    <div class="product-list">

        <?php foreach ($produk_ditemukan as $item): ?>
            <div class="product-card">
                <div class="product-image">Foto Produk</div>
                <h3><?php echo htmlspecialchars($item['nama'], ENT_QUOTES, 'UTF-8'); ?></h3>
                <p>Rp<?php echo number_format($item['harga'], 0, ',', '.'); ?></p>
                <a href="detail_produk.php?id=<?php echo $item['id']; ?>">Lihat Produk</a>
            </div>
        <?php endforeach; ?>

    </div>
    <?php if (count($produk_ditemukan) === 0): ?>
        <p>Produk tidak ditemukan. Coba kata kunci atau kategori lain.</p>
    <?php endif; ?>

</section>

</body>
</html>