<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . '/../config/db.php';

if (!isset($conn)) {
    $conn = null;
}

$data = null;
$persen = 0;
$error_message = null;

if (isset($_POST['cari'])) {

    $kode = mysqli_real_escape_string(
        $conn,
        $_POST['kode']
    );

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

        $status_text = $data['statusprogress'];

        if (strpos($status_text, 'Pending') !== false) {
            $persen = 15;
        }
        elseif (strpos($status_text, 'Welding') !== false) {
            $persen = 35;
        }
        elseif (strpos($status_text, 'Assembly') !== false) {
            $persen = 55;
        }
        elseif (strpos($status_text, 'Coating') !== false) {
            $persen = 75;
        }
        elseif (strpos($status_text, 'QC Testing') !== false) {
            $persen = 85;
        }
        elseif (strpos($status_text, 'In Transit') !== false) {
            $persen = 90;
        }
        elseif (strpos($status_text, 'Completed') !== false) {
            $persen = 100;
        }
    }
    else {

        $error_message =
        "Kode order tidak ditemukan atau bukan milik akun Anda.";

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>
    Tracking Order
  </title>

  <link rel="stylesheet" href="css/client.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


</head>

<body>

  <?php include 'includes/sidebar.php'; ?>
  <div class="hamburger" onclick="toggleSidebar()">
    <span></span>
    <span></span>
    <span></span>
  </div>
  <script>
  function toggleSidebar() {

    document
      .querySelector('.sidebar')
      .classList.toggle('active');

    document
      .querySelector('.overlay')
      .classList.toggle('active');

    document
      .querySelector('.hamburger')
      .classList.toggle('active');

  }
  </script>

  <div class="overlay" onclick="toggleSidebar()"></div>
  <div class="content">

    <h1 class="page-title">
      Tracking Order
    </h1>

    <div class="top-actions">

      <a href="dashboard_client.php" class="back-btn">

        ← Dashboard

      </a>

    </div>
    <div class="tracking-wrapper">
      <div class="tracking-container">

        <h2 class="tracking-title">
          Cari Status Pesanan
        </h2>

        <form method="POST" class="tracking-form">

          <input type="text" name="kode" placeholder="Masukkan Kode Order" required>

          <button type="submit" name="cari" class="tracking-btn">

            Cari

          </button>

        </form>

        <?php if($data): ?>

        <div class="tracking-result">

          <div class="machine-header">

            <div>

              <h2>
                <?= htmlspecialchars($data['produk']); ?>
              </h2>

              <span class="order-code">
                <?= htmlspecialchars($data['kode_order']); ?>
              </span>

            </div>

            <div class="status-badge">

              <?= htmlspecialchars($data['statusprogress']); ?>

            </div>

          </div>

          <div class="info-grid">

            <div class="info-card">

              <h4>Quantity</h4>

              <span>
                <?= $data['quantity']; ?>
              </span>

            </div>

            <div class="info-card">

              <h4>Total Value</h4>

              <span>
                Rp <?= number_format($data['total_price'],0,',','.'); ?>
              </span>

            </div>

            <div class="info-card">

              <h4>Progress</h4>

              <span>
                <?= $persen; ?>%
              </span>

            </div>

          </div>

          <div class="progress-section">

            <div class="progress-top">

              <span>Manufacturing Progress</span>

              <span><?= $persen; ?>%</span>

            </div>

            <div class="progress-wrapper">

              <div class="progress-bar" style="width:<?= $persen; ?>%;">
              </div>

            </div>

          </div>

        </div>

        <?php endif; ?>

        <?php if($error_message): ?>

        <div class="tracking-error">

          <?= $error_message; ?>

        </div>

        <?php endif; ?>

      </div>

    </div>

</body>

</html>