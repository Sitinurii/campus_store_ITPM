<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kampus Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="logo">CAMPUS STORE</div>

    <nav>
        <a href="index.php">BERANDA</a>
        <a href="produk.php">PRODUK</a>
        <a href="kategori.php">KATEGORI</a>
        <a href="#tentang">TENTANG</a>
    </nav>

    <div class="header-right">
        <form class="header-search" action="produk.php" method="get" role="search">
            <input type="search" name="q" placeholder="Cari produk..." aria-label="Cari produk">
            <button type="submit">Cari</button>
        </form>
        <a href="keranjang.php">🛒</a>
        <a href="login.php" aria-label="Masuk">👤</a>
    </div>
</header>

<section class="hero">
    <div>
        <p>OFFICIAL CAMPUS STORE</p>
        <h1>Tampil Bangga<br>Dengan Identitas Kampusmu.</h1>
        <p>Temukan merchandise resmi kampus untuk melengkapi aktivitasmu.</p>

        <a href="produk.php" class="btn">BELANJA SEKARANG</a>
    </div>
</section>

<section class="section" id="kategori">
    <h2>KATEGORI</h2>

    <div class="category-list">
        <a href="produk.php?kategori=Jaket">Jaket</a>
        <a href="produk.php?kategori=Kaos">Kaos</a>
        <a href="produk.php?kategori=Tas">Tas</a>
        <a href="produk.php?kategori=Topi">Topi</a>
    </div>
</section>

<section class="section">
    <h2>PRODUK TERBARU</h2>

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

<section class="features" id="tentang">
    <div>
        <h3>Official & Original</h3>
        <p>Produk resmi dan original dari kampus.</p>
    </div>

    <div>
        <h3>Pembayaran Aman</h3>
        <p>Proses pembayaran yang mudah dan aman.</p>
    </div>

    <div>
        <h3>Pengiriman Cepat</h3>
        <p>Pesanan diproses dengan cepat.</p>
    </div>

    <div>
        <h3>Customer Service</h3>
        <p>Siap membantu kebutuhanmu.</p>
    </div>
</section>

<footer>
    <p>© 2026 Campus Store</p>
</footer>

</body>
</html>