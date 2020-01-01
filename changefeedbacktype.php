<?php
  session_start();
  $host = 'localhost';
  $user = 'phpaccess';
  $pass = 'MQhN/\:~57c@qPsrqhT2=';
  $db = 'TOUTLINE_OUTLINES';
  $mysqli = new mysqli($host, $user, $pass, $db);

  $stmt = $mysqli->prepare("UPDATE points SET feedback_type=? WHERE id=?");
  $stmt->bind_param("si", $_POST['feedback_type'], intval($_POST['id']));
  $stmt->execute();
  $stmt->close();
?>
