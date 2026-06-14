<?php

require 'config/db.php';

if(isset($_POST['register'])){

    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    mysqli_query(
        $conn,
        "INSERT INTO users
        (nama,username,password,role)

        VALUES

        (
            '$nama',
            '$username',
            '$password',
            'client'
        )"
    );

    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - PT Terradrill</title>

  <link rel="stylesheet" href="assets/css/register.css">
  <link rel="stylesheet" href="assets/css/styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Manrope:wght@300;400;500;600;700;800&family=Sora:wght@100;200;300;400;500;600;700;800&display=swap"
    rel="stylesheet" />
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar">
    <?php include 'includes/header.php'; ?>
  </nav>

  <section class="register-section">

    <div class="register-container">

      <h2 class="register-title">
        Client Registration
      </h2>

      <form method="POST" class="register-form">

        <input type="text" name="nama" placeholder="Company Name" required>

        <input type="text" name="username" placeholder="Username" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="register" class="register-btn">

          Register

        </button>

      </form>

    </div>

  </section>

</body>

</html>