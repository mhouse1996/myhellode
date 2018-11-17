<?php
include __DIR__ . "/../layout/header.php";
include __DIR__ . "/../../configs/msglist.php";
?>

<br>
<br>


Es ist ein Fehler aufgetreten: <?php echo $msglist[$msg]; ?>

<?php include __DIR__ . "/../layout/footer.php"; ?>
