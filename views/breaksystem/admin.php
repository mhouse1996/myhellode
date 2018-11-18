<?php include __DIR__ . "/../layout/header.php"; ?>

<br/>
<br/>

<?php
if(!empty($breakTickets)){
  echo 'Besetzte Pausentickets:<br/>
  <table border="true">
    <tr>
      <th>
        Besitzer
      </th>
      <th>
        Pausenbeginn
      </th>
      <th>
        Benutzergruppe
      </th>
      <th>
        Pausentyp
      </th>
      <th>
        Ticketg&uuml;ltigkeit
      </th>
    </tr>
  ';
}

foreach($breakTickets AS $breakTicket)
{
  if(isset($breakTicket->owner)){
    $userType = $breakTicket->userType == "sales" ? "Outbond" : $breakTicket->userType == "service" ? "Inbound" : 0;
    $breakType = $breakTicket->estimatedBreakDuration == "short" ? "Bis zu 10 Minuten" : $breakTicket->estimatedBreakDuration == "long" ? "Bis zu 30 Minuten" : 0;

    echo '
    <tr>
      <td>
        '.$breakController->userController->returnUserById($breakTicket->owner)->fullname.'
      </td>
      <td>
        '.date("H:i:s", $breakTicket->timeToken).'
      </td>
      <td>
        '.$userType.'
      </td>
      <td>
        '.$breakType.'
      </td>
      <td>
        Von '.$breakTicket->beginningTime.' bis '.$breakTicket->endingTime.'
      </td>
    </tr>';
  }
}
if(!empty($breakTickets)):echo "</table><br/>";endif;

echo 'Ticket hinzuf&uuml;gen:<br/>';
if($err){
  echo "Es ist ein Fehler aufgetreten.<br/>";
}
echo '<form method="POST" action="addTicket">
  <i>Uhrzeit bitte im Format Stunde:Minute angeben.</i><br/>
  <input type="number" name="count"></input> Ticket(s) f&uuml;r <select name="userType"><option value="sales">Outbond</option><option value="service">Inbound</option></select> von <input type="text" name="beginningTime"></input> bis <input type="text" name="endingTime"></input>
  <input type="submit" name="submit" value="Absenden"</input></form><br/>';

echo 'Aktuelle Regeln:<br/>
      <table border="true">
        <tr>
          <th>
            Nutzertyp
          </th>
          <th>
            Zeitraum
          </th>
        </tr>';
foreach($breakTickets AS $rule)
{
  $userType = $rule->userType == "service" ? "Inbound" : $rule->userType == "sales" ? "Outbound" : 0;
  echo '<tr>
          <td>
            '.$userType.'
          </td>
          <td>
            '.$rule->beginningTime.'-'.$rule->endingTime.'
          </td>
        </tr>';
}
echo '</table>';

?>

<?php include __DIR__ . "/../layout/footer.php"; ?>
