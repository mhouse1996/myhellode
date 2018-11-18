<?php include __DIR__ . "/../layout/header.php"; ?>

<br/>
<br/>
<center>

<?php
$inboundFreeTicketCount = 0;
$inboundUsedTicketCount = 0;
$outboundFreeTicketCount = 0;
$outboundUsedTicketCount = 0;

foreach($breakTickets as $breakTicket)
{
  if($breakTicket->activity == 1){
    if($breakTicket->userType == "service"){
      if($breakTicket->owner == null){
        $inboundFreeTicketCount++;
      } else {
        $inboundUsedTicketCount++;
      }
    } elseif($breakTicket->userType == "sales") {
      if($breakTicket->owner == null){
        $outboundFreeTicketCount++;
      } else {
        $outboundUsedTicketCount++;
      }
    }
  }
}

echo "Aus dem Inbound-Team sind ".$inboundUsedTicketCount." aktive Pausenticket(s) belegt, ".$inboundFreeTicketCount." Pausentickets sind noch verf&uuml;gbar.<br/>";
echo "Aus dem Outbound-Team sind ".$outboundUsedTicketCount." aktive Pausenticket(s) belegt, ".$outboundFreeTicketCount." Pausentickets sind noch verf&uuml;gbar.<br/>";


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

foreach($breakTickets as $breakTicket)
{
  if(isset($breakTicket->owner)){
    $userType = $breakTicket->userType == "sales" ? "Outbond" : "Inbound";
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
if(!empty($breakTickets)):echo "</table><br/><br/><br/><br/>";endif;

echo 'Ticket hinzuf&uuml;gen:<br/>';
if($err){
  echo "Es ist ein Fehler aufgetreten.<br/>";
}
echo '<form method="POST" action="addTicket">
  <i>Uhrzeit bitte im Format Stunde:Minute angeben.</i><br/>
  <input type="number" name="count" max="10"></input> Ticket(s) f&uuml;r <select name="userType"><option value="sales">Outbond</option><option value="service">Inbound</option></select> von <input type="text" name="beginningTime" maxlength="5"></input> bis <input type="text" name="endingTime" maxlength="5"></input>
  <input type="submit" name="submit" value="Absenden"</input></form><br/><br/><br/><br/><br/>';

echo 'Aktuelle Regeln:<br/>
      <table border="true">
        <tr>
          <th>
            Nutzertyp
          </th>
          <th>
            Zeitraum
          </th>
          <th>
            Aktionen
          </th>
        </tr>';

foreach($breakTickets as $rule)
{
  $userType = $rule->userType == "service" ? "Inbound" : "Outbond";
  $toggleMsg = $rule->activity == 1 ? "Deaktivieren" : "Aktivieren" ;
  $oppositeState = $rule->activity == 1 ? 0 : 1;
  echo '<tr>
          <td>
            '.$userType.'
          </td>
          <td>
            '.$rule->beginningTime.'-'.$rule->endingTime.'
          </td>
          <td>
            <form method="POST" action="changeTicket?action=remove&id='.$rule->id.'"><input type="submit" value="Entfernen" /></form>
            <form method="POST" action="changeTicket?action=toggle&id='.$rule->id.'&state='.$oppositeState.'"><input type="submit" value="'.$toggleMsg.'" /></form>
        </tr>';
}
echo '</table>';

?>

</center>

<?php include __DIR__ . "/../layout/footer.php"; ?>
