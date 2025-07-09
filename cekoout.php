<?php
include "config.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !is_array($data)) {
    http_response_code(400);
    echo "Data kosong!";
    exit;
}

// Hitung total belanja
$total = 0;
foreach ($data as $item) {
    $harga = preg_replace('/[^\d]/', '', $item["harga"]);
    $total += (int)$harga;
}

// Simpan ke tabel nota
$tanggal = date("Y-m-d");
$query = "INSERT INTO nota (Tanggal, Total) VALUES ('$tanggal', $total)";
$sukses = mysqli_query($koneksi, $query);

if ($sukses) {
    $idNota = mysqli_insert_id($koneksi);

    // Simpan ke nota_detail
    foreach ($data as $item) {
        $nama = mysqli_real_escape_string($koneksi, $item["nama"]);
        $harga = (int) preg_replace('/[^\d]/', '', $item["harga"]);

        // Ambil IdProduk berdasarkan nama
        $q = mysqli_query($koneksi, "SELECT IdProduk FROM produk WHERE `Nama Produk` = '$nama'");
        $produk = mysqli_fetch_assoc($q);

        if ($produk) {
            $idProduk = $produk["IdProduk"];

            // Simpan ke nota_detail (jumlah diset 1 per item)
            $queryDetail = "INSERT INTO nota_detail (IdNota, IdProduk, Jumlah, Subtotal)
                            VALUES ($idNota, $idProduk, 1, $harga)";
            mysqli_query($koneksi, $queryDetail);
        }
    }

    echo "Nota $idNota Berhasil disimpan!";
} else {
    http_response_code(500);
    echo "Gagal menyimpan nota: " . mysqli_error($koneksi);
}
?>
