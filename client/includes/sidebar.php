<div class="sidebar">

  <div class="profile-box">

    <img src="../../assets/images/default-user.png" alt="Profile">

    <h3 class="client-name">
      <?= $_SESSION['nama']; ?>
    </h3>

    <span>
      Manufacturing Client Portal
    </span>

  </div>

  <ul class="menu">

    <li>
      <a href="dashboard_client.php">
        <i class="fa-solid fa-chart-line"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <li>
      <a href="tracking_client.php">
        <i class="fa-solid fa-location-dot"></i>
        <span>Tracking Center</span>
      </a>
    </li>

    <li>
      <a href="my_orders.php">
        <i class="fa-solid fa-box-open"></i>
        <span>My Orders</span>
      </a>
    </li>

    <li>
      <a href="../index.php">
        <i class="fa-solid fa-globe"></i>
        <span>Company Website</span>
      </a>
    </li>

    <li>
      <a href="../logout.php" class="logout">
        <i class="fa-solid fa-right-from-bracket"></i>
        <span>Logout</span>
      </a>
    </li>

  </ul>

</div>