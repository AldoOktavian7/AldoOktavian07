<?php
include 'config.php'; // koneksi database
?>

<section id="produk" class="produk-background">
  <h2 class="section-tittle" data-aos="fade-up" data-aos-duration="1000">Produk Unggulan Kami</h2>

  <div class="produk-tombol-scroll">
    <button class="scroll-btn left" onclick="scrollProduk('left')">&#10094;</button>

    <div class="produk-scroll-container" id="produkContainer" data-aos="fade-up" data-aos-duration="1000">
      <?php
      $query = "SELECT `Nama Produk` AS NamaProduk, Harga, gambar, Stok FROM produk";
      $result = mysqli_query($koneksi, $query);

      while ($row = mysqli_fetch_assoc($result)) {
          $nama = $row['NamaProduk'];
          $harga = $row['Harga'];
          $gambar = $row['gambar'];
          $stok = $row['Stok'];

          $hargaFormat = "Rp " . number_format($harga, 0, ',', '.');

          // Escape string untuk keamanan JS
          $namaJS = htmlspecialchars($nama, ENT_QUOTES);
          $hargaJS = htmlspecialchars($hargaFormat, ENT_QUOTES);

          // Tambahkan class 'habis' jika stok kosong
          $stokClass = ($stok <= 0) ? 'habis' : '';

          echo '
          <div class="produk-item ' . $stokClass . '">
              <img src="img/' . $gambar . '" alt="' . $nama . '" onclick="tampilkanHarga(this, \'' . $hargaJS . '\')">
              <p onclick="alert(\'' . $hargaJS . '\')" style="cursor: pointer;">' . $nama . '</p>
              <p class="produk-harga">' . $hargaJS . '</p>
              <button onclick="tambahKeKeranjang(\'' . $namaJS . '\', \'' . $hargaJS . '\')" ' . ($stok <= 0 ? 'disabled' : '') . '>+ Keranjang</button>
          </div>';
      }
      ?>
    </div>
    <button class="scroll-btn right" onclick="scrollProduk('right')">&#10095;</button>
  </div>
</section>

<script>
  function scrollProduk(direction) {
    const container = document.getElementById('produkContainer');
    const scrollAmount = 300;
    container.scrollBy({
      left: direction === 'left' ? -scrollAmount : scrollAmount,
      behavior: 'smooth'
    });
  }
</script>

<script>
  const container = document.getElementById("produkContainer");
  const leftBtn = document.getElementById("scrollLeft");
  const rightBtn = document.getElementById("scrollRight");

  let scrollInterval;

  function startScroll(direction) {
    scrollInterval = setInterval(() => {
      container.scrollBy({
        left: direction === 'left' ? -5 : 5,
        behavior: 'auto'
      });
    }, 10);
  }

  function stopScroll() {
    clearInterval(scrollInterval);
  }

  leftBtn?.addEventListener("mousedown", () => startScroll('left'));
  rightBtn?.addEventListener("mousedown", () => startScroll('right'));
  document.addEventListener("mouseup", stopScroll);
  document.addEventListener("mouseleave", stopScroll);
</script>
