<?php
session_start();
require_once "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

$id_pesanan =
    isset($_GET['id_pesanan'])
    ? (int) $_GET['id_pesanan']
    : 0;

$pesan = "";


if ($id_pesanan <= 0) {
    die("ID pesanan tidak ditemukan.");
}


$stmt = $koneksi->prepare(
    "SELECT
        id_pesanan,
        nama_penerima,
        no_hp,
        alamat,
        subtotal,
        ongkir,
        total_harga,
        tanggal_pesanan,
        status
     FROM pesanan
     WHERE id_pesanan = ?
     AND id_user = ?"
);

$stmt->bind_param(
    "ii",
    $id_pesanan,
    $id_user
);

$stmt->execute();

$hasil = $stmt->get_result();


if ($hasil->num_rows != 1) {
    die("Pesanan tidak ditemukan.");
}


$pesanan =
    $hasil->fetch_assoc();


if (isset($_POST['konfirmasi'])) {

    if ($pesanan['status'] == 'menunggu') {

        $status = 'diproses';


        $update = $koneksi->prepare(
            "UPDATE pesanan
             SET status = ?
             WHERE id_pesanan = ?
             AND id_user = ?"
        );

        $update->bind_param(
            "sii",
            $status,
            $id_pesanan,
            $id_user
        );


        if ($update->execute()) {

            $pesan =
                "Pembayaran berhasil dikonfirmasi. Pesanan sedang diproses.";

            $pesanan['status'] =
                'diproses';

        } else {

            $pesan =
                "Konfirmasi pembayaran gagal.";
        }

    } else {

        $pesan =
            "Pesanan ini tidak dapat dikonfirmasi lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Pembayaran - Campus Store
    </title>

</head>

<body>


<h2>Pembayaran</h2>


<?php if ($pesan != ""): ?>

    <p>
        <?php
        echo htmlspecialchars($pesan);
        ?>
    </p>

<?php endif; ?>


<p>
    Nomor Pesanan:

    <strong>
        #<?php echo $pesanan['id_pesanan']; ?>
    </strong>
</p>


<p>
    Nama Penerima:

    <?php
    echo htmlspecialchars(
        $pesanan['nama_penerima']
    );
    ?>
</p>


<p>

    Alamat:

    <?php
    echo nl2br(
        htmlspecialchars(
            $pesanan['alamat']
        )
    );
    ?>

</p>


<p>

    Subtotal:

    Rp

    <?php
    echo number_format(
        $pesanan['subtotal'],
        0,
        ',',
        '.'
    );
    ?>

</p>


<p>

    Ongkir:

    Rp

    <?php
    echo number_format(
        $pesanan['ongkir'],
        0,
        ',',
        '.'
    );
    ?>

</p>


<p>

    <strong>

        Total:

        Rp

        <?php
        echo number_format(
            $pesanan['total_harga'],
            0,
            ',',
            '.'
        );
        ?>

    </strong>

</p>


<p>

    Status:

    <strong>
        <?php
        echo htmlspecialchars(
            $pesanan['status']
        );
        ?>
    </strong>

</p>


<?php if ($pesanan['status'] == 'menunggu'): ?>


<h3>Konfirmasi Pembayaran</h3>

<p>
    Setelah melakukan pembayaran
    sesuai total pesanan, klik tombol
    berikut.
</p>


<form method="post">

    <button
        type="submit"
        name="konfirmasi"
    >
        Saya Sudah Bayar
    </button>

</form>


<?php endif; ?>


<p>

    <a href="index.php">
        Kembali ke halaman utama
    </a>

</p>


</body>
</html>