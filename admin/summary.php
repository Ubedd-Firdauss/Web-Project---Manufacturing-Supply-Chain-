<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../config/db.php';

/* ==========================
   SUMMARY KPI
========================== */

$totalOrder = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders"
    )
);

$completed = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress
         LIKE '%Completed%'"
    )
);

$shipping = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress
         LIKE '%Transit%'"
    )
);

$production = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress
         LIKE '%Production%'"
    )
);

$pendingCount = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE 'Pending%'"
    )
);

$weldingCount = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE '%Welding%'"
    )
);

$assemblyCount = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE '%Assembly%'"
    )
);

$coatingCount = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE '%Coating%'"
    )
);

$qcCount = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE '%QC Testing%'"
    )
);

$shippingCount = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE '%Transit%'"
    )
);

$completedCount = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE '%Completed%'"
    )
);

/* ==========================
   STATUS CHART
========================== */

$pending = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE '%Pending%'"
    )
);

$productionChart = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE '%Production%'"
    )
);

$shippingChart = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE '%Transit%'"
    )
);

$completedChart = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE '%Completed%'"
    )
);

$pendingCount = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE 'Pending%'"
    )
);

$weldingCount = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE '%Welding%'"
    )
);

$assemblyCount = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE '%Assembly%'"
    )
);

$coatingCount = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE '%Coating%'"
    )
);

$qcCount = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE '%QC Testing%'"
    )
);

$shippingCount = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE '%Transit%'"
    )
);

$completedCount = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE '%Completed%'"
    )
);

$monthlyOrders = mysqli_query(
    $conn,
    "SELECT
        MONTH(created_at) AS bulan,
        COUNT(*) AS total
     FROM orders
     GROUP BY MONTH(created_at)
     ORDER BY MONTH(created_at)"
);

$monthLabels = [];
$monthTotals = [];

while($row = mysqli_fetch_assoc($monthlyOrders)){

    $monthLabels[] = date(
        'M',
        mktime(
            0,
            0,
            0,
            $row['bulan'],
            1
        )
    );

    $monthTotals[] = $row['total'];
}

$topClients = mysqli_query(
    $conn,
    "SELECT
        users.nama,
        COUNT(*) AS total_orders
     FROM orders
     JOIN users
     ON orders.client_id = users.id
     GROUP BY users.nama
     ORDER BY total_orders DESC
     LIMIT 5"
);

$recentActivities = mysqli_query(
    $conn,
    "SELECT
        kode_order,
        statusprogress,
        created_at
     FROM orders
     ORDER BY id DESC
     LIMIT 6"
);
?>

<?php

$pending = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE '%Pending%'"
    )
);

$welding = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE '%Welding%'"
    )
);

$assembly = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE '%Assembly%'"
    )
);

$coating = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE '%Coating%'"
    )
);

$qc = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE '%QC Testing%'"
    )
);

$shipping = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE '%Transit%'"
    )
);

$completed = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM orders
         WHERE statusprogress LIKE '%Completed%'"
    )
);
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Summary Dashboard</title>

  <link rel="stylesheet" href="css/admin.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

  <?php include 'includes/sidebar.php'; ?>

  <!-- Hamburger Menu -->
  <div class="hamburger" onclick="toggleSidebar()">
    <span></span>
    <span></span>
    <span></span>
  </div>

  <!-- Overlay (Klik untuk tutup sidebar) -->
  <div class="overlay" onclick="toggleSidebar()"></div>

  <script>
  function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('active');
    document.querySelector('.overlay').classList.toggle('active');
    document.querySelector('.hamburger').classList.toggle('active');
  }
  </script>

  <div class="content">

    <h1 class="summary-title">
      Manufacturing Summary
    </h1>

    <p class="summary-subtitle">
      Overview of Manufacturing Operations
    </p>

    <div class="summary-grid">

      <div class="summary-card">

        <div class="summary-icon">
          <i class="fas fa-boxes"></i>
        </div>

        <h3>Total Orders</h3>

        <span>
          <?= $totalOrder['total']; ?>
        </span>

      </div>

      <div class="summary-card">

        <div class="summary-icon">
          <i class="fas fa-industry"></i>
        </div>

        <h3>In Production</h3>

        <span>
          <?= $production['total']; ?>
        </span>

      </div>

      <div class="summary-card">

        <div class="summary-icon">
          <i class="fas fa-truck"></i>
        </div>

        <h3>Shipping</h3>

        <span>
          <?= $shipping['total']; ?>
        </span>

      </div>

      <div class="summary-card">

        <div class="summary-icon">
          <i class="fas fa-circle-check"></i>
        </div>

        <h3>Completed</h3>

        <span>
          <?= $completed['total']; ?>
        </span>

      </div>

    </div>
    <div class="analytics-card">

      <div class="analytics-header">

        <h2>
          Manufacturing Statistics
        </h2>

        <span>
          Real Time Production Overview
        </span>

      </div>

      <div class="analytics-chart">

        <canvas id="statisticsChart"></canvas>



      </div>

    </div>

    <div class="analytics-card">

      <div class="analytics-header">

        <h2>
          Monthly Order Trend
        </h2>

        <span>
          Order Growth Overview
        </span>

      </div>

      <div class="analytics-chart">

        <canvas id="monthlyTrendChart"></canvas>

      </div>

    </div>

    <div class="summary-grid">

      <!-- TOP CLIENT -->

      <div class="summary-card">

        <h2>
          Top Clients
        </h2>

        <div class="top-client-list">

          <?php

$rank = 1;

while($client = mysqli_fetch_assoc($topClients)):

?>

          <div class="client-item">

            <div class="client-left">

              <div class="client-rank">

                <?= $rank++; ?>

              </div>

              <div class="client-info">

                <h4>

                  <?= htmlspecialchars($client['nama']); ?>

                </h4>

                <span>

                  Manufacturing Partner

                </span>

              </div>

            </div>

            <div class="client-orders">

              <?= $client['total_orders']; ?>

            </div>

          </div>

          <?php endwhile; ?>

        </div>

      </div>

      <!-- ACTIVITY -->

      <div class="summary-card">

        <h2>
          Recent Activities
        </h2>

        <div class="activity-list">

          <?php while($activity = mysqli_fetch_assoc($recentActivities)): ?>

          <div class="activity-item">

            <div class="activity-dot"></div>

            <div>

              <strong>

                <?= htmlspecialchars(
                            $activity['kode_order']
                        ); ?>

              </strong>

              <p>

                <?= htmlspecialchars(
                            $activity['statusprogress']
                        ); ?>

              </p>

            </div>

          </div>

          <?php endwhile; ?>

        </div>

      </div>

    </div>

    <script>
    const chartCtx =
      document.getElementById('statisticsChart');

    new Chart(chartCtx, {

      type: 'line',

      data: {

        labels: [

          'Pending',
          'Welding',
          'Assembly',
          'Coating',
          'QC Testing',
          'Shipping',
          'Completed'

        ],

        datasets: [{

          label: 'Orders',

          data: [

            <?= $pendingCount['total']; ?>,
            <?= $weldingCount['total']; ?>,
            <?= $assemblyCount['total']; ?>,
            <?= $coatingCount['total']; ?>,
            <?= $qcCount['total']; ?>,
            <?= $shippingCount['total']; ?>,
            <?= $completedCount['total']; ?>

          ],

          borderColor: '#dc143c',

          backgroundColor: 'rgba(220,20,60,.15)',

          fill: true,

          tension: 0.4,

          pointRadius: 6,

          pointHoverRadius: 8

        }]

      },

      options: {

        responsive: true,

        maintainAspectRatio: false,

        plugins: {
          legend: {
            display: false
          }
        },

        scales: {
          y: {
            beginAtZero: true
          }
        }

      }

    });
    </script>

    <script>
    const monthlyCtx =
      document.getElementById(
        'monthlyTrendChart'
      );

    new Chart(monthlyCtx, {

      type: 'bar',

      data: {

        labels: <?= json_encode($monthLabels); ?>,

        datasets: [{

          label: 'Orders',

          data: <?= json_encode($monthTotals); ?>,

          borderRadius: 12,

          backgroundColor: [
            '#dc143c',
            '#ef4444',
            '#f97316',
            '#eab308',
            '#22c55e',
            '#3b82f6',
            '#8b5cf6'
          ]

        }]

      },

      options: {

        responsive: true,

        maintainAspectRatio: false,

        plugins: {

          legend: {
            display: false
          }

        }

      }

    });
    </script>


</body>

</html>