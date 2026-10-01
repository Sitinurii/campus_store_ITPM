<?php

$id = $_GET['id'] ?? 1;

$produk = [
    1 => [
        "nama" => "Jaket Almamater",
        "harga" => 250000,
        "deskripsi" => "Jaket almamater resmi kampus dengan bahan nyaman digunakan.",
        "stok" => 20,
        "ukuran" => "S, M, L, XL, XXL"
    ],
    2 => [
        "nama" => "Kaos Kampus",
        "harga" => 85000,
        "deskripsi" => "Kaos resmi kampus dengan desain sederhana dan nyaman.",
        "stok" => 30,
        "ukuran" => "S, M, L, XL"
    ],
    3 => [
        "nama" => "Tote Bag",
        "harga" => 65000,
        "deskripsi" => "Tote bag kampus yang cocok digunakan untuk aktivitas sehari-hari.",
        "stok" => 25,
        "ukuran" => "All Size"
    ],
    4 => [
        "nama" => "Topi Kampus",
        "harga" => 50000,
        "deskripsi" => "Topi resmi kampus dengan desain simpel.",
        "stok" => 15,
        "ukuran" => "All Size"
    ]
];

$data = $produk[$id] ?? $produk[1];

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $data['nama']; ?> - Kampus Store</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header>
    <div class="logo">CAMPUS STORE</div>

    <nav>
        <a href="index.php">BERANDA</a>
        <a href="produk.php">PRODUK</a>
    </nav>

    <a href="keranjang.php">🛒</a>
</header>

<section class="detail">

    <div class="detail-image">
        Foto Produk
    </div>

    <div class="detail-info">

        <p>Official Campus Store</p>

        <h1><?= $data['nama']; ?></h1>

        <h2>Rp <?= number_format($data['harga'], 0, ',', '.'); ?></h2>

        <p><?= $data['deskripsi']; ?></p>

        <p>Stok tersedia: <?= $data['stok']; ?></p>

        <label>Ukuran</label>
        <select>
            <?php
            $ukuran = explode(", ", $data['ukuran']);

            foreach ($ukuran as $u) {
                echo "<option>$u</option>";
            }
            ?>
        </select>

        <br><br>

        <button>+ KERANJANG</button>
        <button>BELI SEKARANG</button>

    </div>

</section>

</body>
</html>