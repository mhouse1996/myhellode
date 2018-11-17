<?php include __DIR__ . "/../layout/header.php"; ?>

<?php echo 'Willkommen '.$_SESSION['fullname'].'!<br>'; ?>

<ul>
  <li><a href="breaksystem">Pausensystem</a></li>
  <li><a href="logout">Logout</a></li>
</ul>

<?php include __DIR__ . "/../layout/footer.php"; ?>
