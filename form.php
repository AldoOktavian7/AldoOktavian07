<?php
include 'config.php';

// Proses simpan komentar langsung di form.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama     = htmlspecialchars($_POST['Nama']);
  $email    = htmlspecialchars($_POST['Email']);
  $komentar = htmlspecialchars($_POST['Komentar']);

  $stmt = $koneksi->prepare("INSERT INTO komentar (nama, email, komentar) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $nama, $email, $komentar);
  $stmt->execute();

  echo "<script>alert('Komentar berhasil dikirim!'); window.location.href='index.php';</script>";
  exit();
}
?>

<!-- Tombol Komentar Mengambang -->
<button id="open-comment" class="comment-float-btn" title="Kritik & Saran">💬</button>

<!-- Section Popup Komentar -->
<div id="comment-popup" class="comment-popup" style="display: none;">
  <form method="post">
    <div class="comment-header">
      <h4>Saran Anda</h4>
      <button type="button" id="close-comment" class="close-btn" title="Tutup">×</button>
    </div>
    <input type="text" name="Nama" placeholder="Nama" required>
    <input type="email" name="Email" placeholder="Email" required>
    <textarea name="Komentar" rows="4" placeholder="Tulis Saran..." required></textarea>
    <button type="submit" class="submit-btn">Kirim</button>
  </form>
</div>

<script>
// JS untuk buka/tutup popup komentar
document.getElementById('open-comment').onclick = function () {
  document.getElementById('comment-popup').style.display = 'block';
};
document.getElementById('close-comment').onclick = function () {
  document.getElementById('comment-popup').style.display = 'none';
};
</script>
