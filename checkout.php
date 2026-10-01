<?php
session_start();
require_once "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

$pesan_error = "";

$keranjang = [];
$subtotal = 0;

$sql = "SELECT 
            k.id_keranjang,
            k.id_produk,
            k.jumlah,
            p.nama_produk,
            p.harga,
            p.stok
        FROM keranjang k
        JOIN produk p 
        ON k.id_produk = p.id_produk
        WHERE k.id_user = ?";

$stmt = $koneksi->prepare($sql);

$stmt->bind_param("i", $id_user);

$stmt->execute();

$hasil = $stmt->get_result();

while ($row = $hasil->fetch_assoc()) {

    $row['subtotal'] =
        $row['harga'] * $row['jumlah'];

    $subtotal += $row['subtotal'];

    $keranjang[] = $row;
}

$ongkir = 20000;

$total = $subtotal + $ongkir;


if (isset($_POST['checkout'])) {

    $nama_penerima =
        trim($_POST['nama_penerima']);

    $no_hp =
        trim($_POST['no_hp']);

    $alamat =
        trim($_POST['alamat']);


    if (count($keranjang) == 0) {

        $pesan_error =
            "Keranjang masih kosong.";

    } elseif (
        $nama_penerima == "" ||
        $no_hp == "" ||
        $alamat == ""
    ) {

        $pesan_error =
            "Data penerima harus lengkap.";

    } else {

        $koneksi->begin_transaction();

        try {

            $stmtPesanan = $koneksi->prepare(
                "INSERT INTO pesanan
                (
                    id_user,
                    nama_penerima,
                    no_hp,
                    alamat,
                    subtotal,
                    ongkir,
                    total_harga,
                    status
                )
                VALUES (?, ?, ?, ?, ?, ?, ?, 'menunggu')"
            );

            $stmtPesanan->bind_param(
                "isssddd",
                $id_user,
                $nama_penerima,
                $no_hp,
                $alamat,
                $subtotal,
                $ongkir,
                $total
            );

            $stmtPesanan->execute();

            $id_pesanan =
                $koneksi->insert_id;


            $stmtDetail = $koneksi->prepare(
                "INSERT INTO detail_pesanan
                (
                    id_pesanan,
                    id_produk,
                    jumlah,
                    harga,
                    subtotal
                )
                VALUES (?, ?, ?, ?, ?)"
            );


            foreach ($keranjang as $item) {

                if ($item['jumlah'] > $item['stok']) {

                    throw new Exception(
                        "Stok produk " .
                        $item['nama_produk'] .
                        " tidak mencukupi."
                    );
                }

                $id_produk =
                    $item['id_produk'];

                $jumlah =
                    $item['jumlah'];

                $harga =
                    $item['harga'];

                $subtotal_item =
                    $item['subtotal'];


                $stmtDetail->bind_param(
                    "iiidd",
                    $id_pesanan,
                    $id_produk,
                    $jumlah,
                    $harga,
                    $subtotal_item
                );

                $stmtDetail->execute();


                $stmtStok = $koneksi->prepare(
                    "UPDATE produk
                     SET stok = stok - ?
                     WHERE id_produk = ?"
                );

                $stmtStok->bind_param(
                    "ii",
                    $jumlah,
                    $id_produk
                );

                $stmtStok->execute();
            }


            $stmtHapus = $koneksi->prepare(
                "DELETE FROM keranjang
                 WHERE id_user = ?"
            );

            $stmtHapus->bind_param(
                "i",
                $id_user
            );

            $stmtHapus->execute();


            $koneksi->commit();


            header(
                "Location: pembayaran.php?id_pesanan=" .
                $id_pesanan
            );

            exit;


        } catch (Exception $e) {

            $koneksi->rollback();

            $pesan_error =
                $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>Checkout - Campus Store</title>
</head>

<body>

<h2>Checkout</h2>

<?php if ($pesan_error != ""): ?>

    <p>
        <?php echo htmlspecialchars($pesan_error); ?>
    </p>

<?php endif; ?>


<?php if (count($keranjang) == 0): ?>

    <p>Keranjang masih kosong.</p>

    <a href="index.php">
        Kembali ke produk
    </a>

<?php else: ?>


<h3>Pesanan</h3>

<table border="1" cellpadding="8">

<tr>
    <th>Produk</th>
    <th>Harga</th>
    <th>Jumlah</th>
    <th>Subtotal</th>
</tr>


<?php foreach ($keranjang as $item): ?>

<tr>

    <td>
        <?php
        echo htmlspecialchars(
            $item['nama_produk']
        );
        ?>
    </td>

    <td>
        Rp
        <?php
        echo number_format(
            $item['harga'],
            0,
            ',',
            '.'
        );
        ?>
    </td>

    <td>
        <?php echo $item['jumlah']; ?>
    </td>

    <td>
        Rp
        <?php
        echo number_format(
            $item['subtotal'],
            0,
            ',',
            '.'
        );
        ?>
    </td>

</tr>

<?php endforeach; ?>

</table>


<p>
    Subtotal:
    Rp <?php
    echo number_format(
        $subtotal,
        0,
        ',',
        '.'
    );
    ?>
</p>


<p>
    Ongkir:
    Rp <?php
    echo number_format(
        $ongkir,
        0,
        ',',
        '.'
    );
    ?>
</p>


<p>
    <strong>
        Total:
        Rp <?php
        echo number_format(
            $total,
            0,
            ',',
            '.'
        );
        ?>
    </strong>
</p>


<h3>Data Penerima</h3>


<form method="post">

    <label>Nama Penerima</label><br>

    <input
        type="text"
        name="nama_penerima"
        required
    >

    <br><br>


    <label>No. HP</label><br>

    <input
        type="text"
        name="no_hp"
        required
    >

    <br><br>


    <label>Alamat</label><br>

    <textarea
        name="alamat"
        rows="5"
        required
    ></textarea>

    <br><br>


    <button
        type="submit"
        name="checkout"
    >
        Buat Pesanan
    </button>

</form>


<?php endif; ?>

</body>
</html>