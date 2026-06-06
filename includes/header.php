<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>

<header class="navbar">

  <div class="nav-container">

    <a href="index.php" class="logo">
      <img src="assets/images/logo_abidzaros.png" alt="PT Terradrill">
    </a>

    <div class="hamburger">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <ul class="nav-menu">

      <li>
        <a href="index.php" class="nav-link">Home</a>
      </li>

      <li>
        <a href="about.php" class="nav-link">About</a>
      </li>

      <li>
        <a href="services.php" class="nav-link">Services</a>
      </li>

      <li>
        <a href="tracking.php" class="nav-link">Tracking</a>
      </li>

      <?php if (isset($_SESSION['login'])): ?>

        <li>
          <span class="user-name">
            <?php
            if (isset($_SESSION['admin_nama'])) {
              echo $_SESSION['admin_nama'];
            } elseif (isset($_SESSION['nama'])) {
              echo $_SESSION['nama'];
            } else {
              echo 'Guest';
            }
            ?>
          </span>
        </li>

        <li>
          <a href="logout.php" class="nav-link">
            Logout
          </a>
        </li>

      <?php else: ?>

        <li>
          <a href="login.php" class="nav-link">
            Login
          </a>
        </li>

        <li>
          <a href="register.php" class="nav-link">
            Register
          </a>
        </li>

      <?php endif; ?>

    </ul>

  </div>
  <script src="assets/js/main.js"></script>

</header>