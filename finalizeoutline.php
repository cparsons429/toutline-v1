<?php
  session_start();
  $host = 'localhost';
  $user = 'phpaccess';
  $pass = 'MQhN/\:~57c@qPsrqhT2=';
  $db = 'TOUTLINE_OUTLINES';
  $mysqli = new mysqli($host, $user, $pass, $db);

  $finalized = 1;

  $stmt = $mysqli->prepare("UPDATE outlines SET finalized=? WHERE id=?");
  $stmt->bind_param("ii", $finalized, intval($_POST['outline_id']));
  $stmt->execute();
  $stmt->close();
?>
