<?php include __DIR__ . "/../layout/header.php"; ?>

<br/>
<br/>

<ul>

<?php
if(isset($msg)){
  include __DIR__ . "/../../configs/msglist.php";
  if(isset($msglist[$msg])):?>
    <p><?php echo $msglist[$msg]['msg']; ?></p>
  <?php endif;
  if($msg == "userAlreadyInBreak"):?>
    <form method="POST" action="unbreak"><input type="submit" value="<?php echo $msglist[$msg]['buttontext']; ?>"/></form>
  <?php
  endif;
}
?>
<?php
$ticketCount = 0;
if($freeBreakTickets != 0)
{
  foreach($freeBreakTickets AS $breakTicket)
  {
    echo '<form method="POST" action="takeBreakTicket?id='.$breakTicket->id.'"">
            <select name="estimatedBreakDuration">
              <option value="short">Bis 10 Minuten</option>
              <option value="long">Bis 30 Minuten</option>
            </select>
            <input type="submit" value="Ticket nehmen"/>
          </form>';
    $ticketCount++;
  }
}


if($ticketCount > 1 OR $ticketCount == 0): echo "Es sind ".$ticketCount." Pausentickets f&uuml;r dich verf&uuml;gbar.<br>"; else: echo "Es ist ".$ticketCount." Pausenticket f&uuml;r dich verf&uuml;gbar.<br>"; endif;
?>

<?php include __DIR__ . "/../layout/footer.php"; ?>
