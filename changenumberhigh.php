<?php
  session_start();
  $host = 'localhost';
  $user = 'phpaccess';
  $pass = 'MQhN/\:~57c@qPsrqhT2=';
  $db = 'TOUTLINE_OUTLINES';
  $mysqli = new mysqli($host, $user, $pass, $db);

  $stmt = $mysqli->prepare("UPDATE points SET high_num=? WHERE id=?");
  $stmt->bind_param("ii", intval($_POST['high_num']), intval($_POST['id']));
  $stmt->execute();
  $stmt->close();
?>
