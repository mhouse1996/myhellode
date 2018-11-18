<?php include __DIR__ . "/../../layout/header.php"; ?>

<br/>
<br/>

<center>
<table border="true">
  <tr>
    <th>Benutzer ID</th>
    <th>Benutzername</th>
    <th>Voller Name</th>
    <th>E-Mail Adresse</th>
    <th>Benutzergruppe</th>
    <th>Sicherheitslevel</th>
    <th>Letzte Pause</th>
  </tr>

  <?php

  foreach($users as $user)
  {
    echo "<tr>
    <td>{$user->id}</td>
    <td><a href='showUser?id={$user->id}'>{$user->username}</a></td>
    <td>{$user->fullname}</td>
    <td>{$user->email}</td>
    <td>{$user->usertype}</td>
    <td>{$user->grants}</td>
    <td>Coming soon</td>
    </tr>";
  }

  ?>

</center>
<?php include __DIR__ . "/../../layout/footer.php"; ?>
