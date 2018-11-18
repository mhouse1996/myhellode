<?php include __DIR__ . "/../../layout/header.php"; ?>

<br/>
<br/>

<center>
<a href="?msgtype=">Zeige alle Logs</a><br/>
<a href="?msgtype=1">Leute, die in Pause gegangen sind</a><br/>
<a href="?msgtype=2">Leute, die die Pause beendet haben</a></br>
<a href="?msgtype=3">Leute, die vergessen haben ihre Pause zu beenden</a></br><br/><br/>

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

    echo "<tr>
      <td>".date("d.M.Y, H:i:s", $log->time)."</td>
      <td>{$log->controller}</td>
      <td>{$msgType}</td>
      <td>{$log->msg}</td>
    </tr>";
  }

  ?>
</table>

<?php include __DIR__ . "/../../layout/footer.php"; ?>
