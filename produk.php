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
        <a href="#">KATEGORI</a>
        <a href="#">TENTANG</a>
    </nav>

    <div class="header-right">
        <a href="keranjang.php">🛒</a>
        <a href="#">👤</a>
    </div>
</header>

<section class="section">

    <h1>Semua Produk</h1>

    <div class="filter">
        <a href="produk.php">Semua</a>
        <a href="produk.php?kategori=Jaket">Jaket</a>
        <a href="produk.php?kategori=Kaos">Kaos</a>
        <a href="produk.php?kategori=Tas">Tas</a>
        <a href="produk.php?kategori=Topi">Topi</a>
        <a href="produk.php?kategori=Atribut">Atribut</a>
    </div>

    <div class="product-list">

        <div class="product-card">
            <div class="product-image">Foto Produk</div>
            <h3>Jaket Almamater</h3>
            <p>Rp250.000</p>
            <a href="detail_produk.php?id=1">Lihat Produk</a>
        </div>

        <div class="product-card">
            <div class="product-image">Foto Produk</div>
            <h3>Kaos Kampus</h3>
            <p>Rp85.000</p>
            <a href="detail_produk.php?id=2">Lihat Produk</a>
        </div>

        <div class="product-card">
            <div class="product-image">Foto Produk</div>
            <h3>Tote Bag</h3>
            <p>Rp65.000</p>
            <a href="detail_produk.php?id=3">Lihat Produk</a>
        </div>

        <div class="product-card">
            <div class="product-image">Foto Produk</div>
            <h3>Topi Kampus</h3>
            <p>Rp50.000</p>
            <a href="detail_produk.php?id=4">Lihat Produk</a>
        </div>

    </div>

</section>

</body>
</html>