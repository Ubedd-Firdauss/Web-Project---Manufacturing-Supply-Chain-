<?php

session_start();

if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

require 'config/db.php';

$data = null;
$persen = 0;
$error_message = null; // Tambahan untuk menampung pesan error

if (isset($_POST['cari'])) {
  $kode = mysqli_real_escape_string($conn, $_POST['kode']); // Amankan dari SQL Injection
  $client_id = $_SESSION['user_id'];

  $query = mysqli_query(
    $conn,
    "SELECT *
        FROM orders
        WHERE kode_order='$kode'
        AND client_id='$client_id'"
  );

  if (mysqli_num_rows($query) > 0) {
    $data = mysqli_fetch_assoc($query);

    // --- LOGIKA MENGUBAH TEKS STATUSPROGRESS MENJADI PERSENTASE ANGKA ---
    // Ini digunakan agar width progress-bar di CSS kamu tetap bisa jalan dinamis
    $status_text = $data['statusprogress'];
    $persen = 0;

    if (strpos($status_text, 'Pending') !== false) {
      $persen = 15;
    } elseif (strpos($status_text, 'Welding') !== false) {
      $persen = 35;
    } elseif (strpos($status_text, 'Assembly') !== false) {
      $persen = 55;
    } elseif (strpos($status_text, 'Coating') !== false) {
      $persen = 75;
    } elseif (strpos($status_text, 'QC Testing') !== false) {
      $persen = 85;
    } elseif (strpos($status_text, 'In Transit') !== false) {
      $persen = 90;
    } elseif (strpos($status_text, 'Completed') !== false) {
      $persen = 100;
    }
  } else {
    $error_message = "Kode order tidak ditemukan atau bukan milik akun Anda.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tracking - PT Terradrill</title>

  <link rel="stylesheet" href="assets/css/styles.css">
  <link rel="stylesheet" href="assets/css/tracking.css">
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar">
    <?php include 'includes/header.php'; ?>
  </nav>

  <section class="tracking-section">

    <div class="tracking-container">

      <h2 class="tracking-title">
        Order Tracking
      </h2>

      <form method="POST" class="tracking-form">
        <input type="text" name="kode" placeholder="Masukkan Kode Order" required>
        <button type="submit" name="cari" class="tracking-btn">
          Cari
        </button>
      </form>

      <?php if ($data): ?>
      <div class="tracking-result">

        <h3><?= htmlspecialchars($data['produk']); ?></h3>

        <p>
          <strong>Status & Progress :</strong>
          <?= htmlspecialchars($data['statusprogress']); ?>
        </p>

        <p>
          <strong>Progress Bar :</strong>
          <?= $persen; ?>%
        </p>

        <div class="progress-wrapper">
          <div class="progress-bar" style="width: <?= $persen; ?>%;">
          </div>
        </div>

      </div>
      <?php endif; ?>

      <?php if ($error_message): ?>
      <div class="tracking-error" style="color: red; margin-top: 15px; text-align: center;">
        <p><?= $error_message; ?></p>
      </div>
      <?php endif; ?>

    </div>

  </section>

</body>

</html>