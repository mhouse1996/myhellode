<title>Benutzerverwaltung</title>
<?php include __DIR__ . "/../../layout/header.php"; ?>

<br/>
<br/>

<center>
<form method="POST" action="searchUser?ref=showUser&user"><input type="text" name="keyword" /><input type="submit" value="Suchen" /></form>

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
  if(is_array($users)) {
    foreach($users as $user)
    {
      if($lastBreaks[$user->id] != "N/A") {
        $lastBreak = date("d.m.Y H:i:s", $lastBreaks[$user->id]);
      } else {
        $lastBreak = "Unbekannt";
      }
      echo "<tr>
      <td>{$user->id}</td>
      <td><a href='showUser?id={$user->id}'>{$user->username}</a></td>
      <td>{$user->fullname}</td>
      <td>{$user->email}</td>
      <td>{$user->usertype}</td>
      <td>{$user->grants}</td>
      <td>{$lastBreak}</td>
      </tr>";
    }
  } else {
    echo "<tr>
    <td>{$users->id}</td>
    <td><a href='showUser?id={$users->id}'>{$users->username}</a></td>
    <td>{$users->fullname}</td>
    <td>{$users->email}</td>
    <td>{$users->usertype}</td>
    <td>{$users->grants}</td>
    <td>{$lastBreak}</td>";
  }

  ?>

</center>
<?php include __DIR__ . "/../../layout/footer.php"; ?>
