<title>Log&uuml;bersicht</title>
<?php include __DIR__ . "/../../layout/header.php"; ?>

<br/>
<br/>

<center>
<a href="?msgtype=">Zeige alle Logs</a><br/>
<a href="?msgtype=1">Leute, die in Pause gegangen sind</a><br/>
<a href="?msgtype=2">Leute, die die Pause beendet haben</a></br>
<a href="?msgtype=3">Leute, die vergessen haben ihre Pause zu beenden</a></br><br/><br/>

<select name="entriesperpage">
  <option value="10">10</option>
  <option value="25">25</option>
  <option value="50">50</option>
  <option value="100">100</option>
  <option value="250">250</option>
</select>

<?php

#echo "{$logs->rowCount()} Eintr&auml;ge pro Seite";

?>

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
