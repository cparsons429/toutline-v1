<?php
  session_start();
  $host = 'localhost';
  $user = 'phpaccess';
  $pass = 'MQhN/\:~57c@qPsrqhT2=';
  $db = 'TOUTLINE_OUTLINES';
  $mysqli = new mysqli($host, $user, $pass, $db);

  $stmt = $mysqli->prepare("INSERT INTO emails (email, team_id) VALUES (?, ?)");
  $stmt->bind_param("si", $_POST['email'], $_SESSION['team_id']);
  $stmt->execute();
  $stmt->close();
?>
