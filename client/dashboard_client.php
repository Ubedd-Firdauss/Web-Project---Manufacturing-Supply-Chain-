<?php

session_start();

if (!isset($_SESSION['login'])) {
  header("Location: ../login.php");
  exit;
}

require '../config/db.php';
/** @var mysqli $conn */
if (!isset($conn) || !$conn) {
  die('Database connection failed.');
}

$client_id = $_SESSION['user_id'];

/* ==========================
   TOTAL ORDER
========================== */
$totalOrder = mysqli_fetch_assoc(
  mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
        FROM orders
        WHERE client_id='$client_id'"
  )
);

/* ==========================
   TOTAL QUANTITY
========================== */
$totalQty = mysqli_fetch_assoc(
  mysqli_query(
    $conn,
    "SELECT SUM(quantity) AS qty
        FROM orders
        WHERE client_id='$client_id'"
  )
);

/* ==========================
   TOTAL VALUE
========================== */
$totalValue = mysqli_fetch_assoc(
  mysqli_query(
    $conn,
    "SELECT SUM(total_price) AS total
        FROM orders
        WHERE client_id='$client_id'"
  )
);

/* ==========================
   RECENT ORDERS
========================== */
$recentOrders = mysqli_query(
  $conn,
  "SELECT *
    FROM orders
    WHERE client_id='$client_id'
    ORDER BY id DESC
    LIMIT 5"
);

/* ==========================
   LATEST ORDER STATUS
========================== */
$latestOrderStatus = mysqli_fetch_assoc(
  mysqli_query(
    $conn,
    "SELECT statusprogress
        FROM orders
        WHERE client_id='$client_id'
        ORDER BY id DESC
        LIMIT 1"
  )
);

$status = $latestOrderStatus['statusprogress'] ?? '';

$currentStage = 1;

if (strpos($status, 'Pending') !== false) {
  $currentStage = 1;
} elseif (strpos($status, 'Welding') !== false) {
  $currentStage = 2;
} elseif (strpos($status, 'Assembly') !== false) {
  $currentStage = 3;
} elseif (strpos($status, 'Coating') !== false) {
  $currentStage = 4;
} elseif (strpos($status, 'QC Testing') !== false) {
  $currentStage = 5;
} elseif (strpos($status, 'In Transit') !== false) {
  $currentStage = 6;
} elseif (strpos($status, 'Completed') !== false) {
  $currentStage = 7;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>
    Dashboard Client
  </title>


  <link rel="stylesheet" href="css/client.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>

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

    <h1 class="dashboard-title">
      Welcome,
      <?= $_SESSION['nama']; ?>
    </h1>

    <p class="dashboard-subtitle">
      Manufacturing Supply Chain Tracking Dashboard
    </p>

    <!-- STATISTICS CARD -->

    <div class="stats-grid">

      <div class="stat-card">

        <h3>Total Orders</h3>

        <span>
          <?= $totalOrder['total']; ?>
        </span>

      </div>

      <div class="stat-card">

        <h3>Total Quantity</h3>

        <span>
          <?= $totalQty['qty'] ?? 0; ?>
        </span>

      </div>

      <div class="stat-card">

        <h3>Total Value</h3>

        <span>
          Rp
          <?= number_format(
            $totalValue['total'] ?? 0,
            0,
            ',',
            '.'
          ); ?>
        </span>

      </div>

      <div class="stat-card">

        <h3>Account Status</h3>

        <span>
          Active
        </span>

      </div>

    </div>


    <div class="pipeline-wrapper">

      <h2>
        Manufacturing Production Flow
      </h2>

      <div class="pipeline">

        <!-- Procurement -->
        <div class="stage <?= $currentStage > 1 ? 'completed' : ($currentStage == 1 ? 'active' : ''); ?>">
          <div class="circle">
            <?= $currentStage > 1 ? '✓' : '1'; ?>
          </div>
          <span>Procurement</span>
        </div>

        <!-- Welding -->
        <div class="stage <?= $currentStage > 2 ? 'completed' : ($currentStage == 2 ? 'active' : ''); ?>">
          <div class="circle">
            <?= $currentStage > 2 ? '✓' : '2'; ?>
          </div>
          <span>Welding</span>
        </div>


        <!-- Assembly -->
        <div class="stage <?= $currentStage > 3 ? 'completed' : ($currentStage == 3 ? 'active' : ''); ?>">
          <div class="circle">
            <?= $currentStage > 3 ? '✓' : '3'; ?>
          </div>
          <span>Assembly</span>
        </div>



        <!-- Coating -->
        <div class="stage <?= $currentStage > 4 ? 'completed' : ($currentStage == 4 ? 'active' : ''); ?>">
          <div class="circle">
            <?= $currentStage > 4 ? '✓' : '4'; ?>
          </div>
          <span>Coating</span>
        </div>

        <!-- QC Testing -->
        <div class="stage <?= $currentStage > 5 ? 'completed' : ($currentStage == 5 ? 'active' : ''); ?>">
          <div class="circle">
            <?= $currentStage > 5 ? '✓' : '5'; ?>
          </div>
          <span>QC Testing</span>
        </div>


        <!-- Shipping -->
        <div class="stage <?= $currentStage > 6 ? 'completed' : ($currentStage == 6 ? 'active' : ''); ?>">
          <div class="circle">
            <?= $currentStage > 6 ? '✓' : '6'; ?>
          </div>
          <span>Shipping</span>
        </div>


        <!-- Delivered -->
        <div class="stage <?= $currentStage == 7 ? 'completed active' : ''; ?>">
          <div class="circle">
            <?= $currentStage == 7 ? '✓' : '7'; ?>
          </div>
          <span>Delivered</span>
        </div>

      </div>
    </div>

    <div class="recent-orders">

      <h2>
        Recent Orders
      </h2>

      <table>

        <thead>

          <tr>

            <th>Kode Order</th>

            <th>Produk</th>

            <th>Status</th>

          </tr>

        </thead>

        <tbody>

          <?php while ($row = mysqli_fetch_assoc($recentOrders)): ?>

          <tr>

            <td>
              <?= htmlspecialchars($row['kode_order']); ?>
            </td>

            <td>
              <?= htmlspecialchars($row['produk']); ?>
            </td>

            <td>
              <span class="status-badge">
                <?= htmlspecialchars($row['statusprogress']); ?>
              </span>
            </td>

          </tr>

          <?php endwhile; ?>

        </tbody>

      </table>

    </div>

</body>

</html>