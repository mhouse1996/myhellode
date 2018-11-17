<?php require ( __DIR__ . "/../layout/header.php"); ?>

<?php if (!empty($error)): ?>
  <p>
    Die Kombination aus Benutzername und Passwort ist falsch.
  </p>
<?php endif; ?>

<form method="POST" method="login" class="form-horizontal">
  <div class="form-group">
    <label class="control-label col-md-3">
      Benutzername:
    </label>
    <div class="col-md-9">
      <input type="text" name="username" class="form-control" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3">
      Passwort:
    </label>
    <div class="col-md-9">
      <input type="password" name="password" class="form-control" />
    </div>
  </div>

  <center><input type="submit" value="Einloggen" class="btn btn-primary" /></center>
</form>

<?php require ( __DIR__ . "/../layout/footer.php"); ?>
