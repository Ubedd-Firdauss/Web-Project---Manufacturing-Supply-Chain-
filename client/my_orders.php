<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

require '../config/db.php';

/** @var mysqli $conn */
if (!isset($conn) || $conn === null) {
    die("Database connection failed.");
}

$client_id = $_SESSION['user_id'];
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';

$where = "WHERE client_id='$client_id'";

if(!empty($search)){
    $where .= " AND (
        kode_order LIKE '%$search%'
        OR produk LIKE '%$search%'
    )";
}

if(!empty($status)){
    $where .= " AND statusprogress LIKE '%$status%'";
}

$orders = mysqli_query(
    $conn,
    "SELECT *
    FROM orders
    $where
    ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>My Orders</title>

  <link rel="stylesheet" href="css/client.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


</head>

<body>

  <?php include 'includes/sidebar.php';?>
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
      My Orders
    </h1>

    <p class="dashboard-subtitle">
      List seluruh pesanan alat berat Anda
    </p>

    <div class="recent-orders">

      <div class="table-header">

        <h2>
          Order List
        </h2>

        <form method="GET" class="filter-form">

          <input type="text" name="search" placeholder="Search Order..." value="<?= htmlspecialchars($search); ?>">

          <select name="status">

            <option value="">
              All Status
            </option>

            <option value="Pending" <?= $status=='Pending'?'selected':''; ?>>
              Pending
            </option>

            <option value="Welding" <?= $status=='Welding'?'selected':''; ?>>
              Welding
            </option>

            <option value="Assembly" <?= $status=='Assembly'?'selected':''; ?>>
              Assembly
            </option>

            <option value="Coating" <?= $status=='Coating'?'selected':''; ?>>
              Coating
            </option>

            <option value="QC Testing" <?= $status=='QC Testing'?'selected':''; ?>>
              QC Testing
            </option>

            <option value="Transit" <?= $status=='Transit'?'selected':''; ?>>
              Shipping
            </option>

            <option value="Completed" <?= $status=='Completed'?'selected':''; ?>>
              Completed
            </option>

          </select>

          <button type="submit">
            Filter
          </button>

        </form>

      </div>

      <table>

        <thead>

          <tr>

            <th>Kode Order</th>

            <th>Produk</th>

            <th>Status</th>

            <th>Tanggal</th>

          </tr>

        </thead>

        <tbody>

          <?php if(mysqli_num_rows($orders) > 0): ?>

          <?php while($row = mysqli_fetch_assoc($orders)): ?>

          <tr>

            <td>
              <?= htmlspecialchars($row['kode_order']); ?>
            </td>

            <td>
              <?= htmlspecialchars($row['produk']); ?>
            </td>

            <td>

              <?php

                                $status = $row['statusprogress'];

                                if(strpos($status, 'Completed') !== false){
                                    echo '<span class="status-completed">'.$status.'</span>';
                                }

                                elseif(strpos($status, 'Transit') !== false){
                                    echo '<span class="status-transit">'.$status.'</span>';
                                }

                                elseif(strpos($status, 'Production') !== false){
                                    echo '<span class="status-production">'.$status.'</span>';
                                }

                                else{
                                    echo '<span class="status-pending">'.$status.'</span>';
                                }

                                ?>

            </td>

            <td>
              <?= date(
                                    "d M Y",
                                    strtotime($row['created_at'])
                                ); ?>
            </td>

          </tr>

          <?php endwhile; ?>

          <?php else: ?>

          <tr>

            <td colspan="4" style="text-align:center;">

              Tidak ada order ditemukan.

            </td>

          </tr>

          <?php endif; ?>

        </tbody>

      </table>

    </div>

  </div>

</body>

</html>