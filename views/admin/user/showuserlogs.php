<title>Benutzerverwaltung</title>
<?php include __DIR__ . "/../../layout/header.php"; ?>

<br/>
<br/>

<center>
<a href="showUser">Zur&uuml;ck zur &Uuml;bersicht</a><br/>

<table border="true">
  <tr>
    <th>Datum</th>
    <th>Programmodul</th>
    <th>Logtyp</th>
    <th>Nachricht</th>
  </tr>

  <?php

  foreach($logs as $log)
  {
    $msgType = $log->msgtype == "ERR" ? "Fehler" : "Info";

    echo "
    <tr>
      <td>".date("d.M.Y, H:i:s", $log->time)."</td>
      <td>{$log->controller}</td>
      <td>{$msgType}</td>
      <td>{$log->msg}</td>
    </tr>";
  }

  ?>
</table>
</center>
<?php include __DIR__ . "/../../layout/footer.php"; ?>
