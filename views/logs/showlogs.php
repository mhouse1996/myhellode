<?php include __DIR__ . "/../layout/header.php"; ?>

<br/>
<br/>

<table border="true">
  <tr>
    <th>
      Datum
    </th>
    <th>
      Programmodul
    </th>
    <th>
      Logtyp
    </th>
    <th>
      Nachricht
    </th>
    <th>
      Verursachende Nutzerid
    </th>
  </tr>

  <?php

  foreach($logs as $log)
  {
    $msgType = $log->msgtype == "ERR" ? "Fehler" : "Info";

    echo '
    <tr>
      <td>
        '.date("d.M.Y, H:i:s", $log->time).'
      </td>
      <td>
        '.$log->controller.'
      </td>
      <td>
        '.$msgType.'
      </td>
      <td>
        '.$log->msg.'
      </td>
      <td>
        '.$log->user.'
      </td>
    </tr>';
  }

  ?>
</table>

<?php include __DIR__ . "/../layout/footer.php"; ?>
