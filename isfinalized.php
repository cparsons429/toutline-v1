<?php
  session_start();
  $host = 'localhost';
  $user = 'phpaccess';
  $pass = 'MQhN/\:~57c@qPsrqhT2=';
  $db = 'TOUTLINE_OUTLINES';
  $mysqli = new mysqli($host, $user, $pass, $db);

  $stmt = $mysqli->prepare("SELECT finalized FROM outlines WHERE outline_id=?");
  $stmt->bind_param("i", $_POST['outline_id']);
  $stmt->execute();
  $stmt->bind_result($finalized);
  $stmt->fetch();
  $stmt->close();

  echo $finalized;
?>
