<?php
  session_start();
  $host = 'localhost';
  $user = 'phpaccess';
  $pass = 'MQhN/\:~57c@qPsrqhT2=';
  $db = 'TOUTLINE_OUTLINES';
  $mysqli = new mysqli($host, $user, $pass, $db);

  $stmt = $mysqli->prepare("SELECT COUNT(*) FROM teams WHERE name=?");
  $stmt->bind_param("s", $_POST['name']);
  $stmt->execute();
  $stmt->bind_result($count_str);
  $stmt->fetch();
  $stmt->close();

  echo $count_str;
?>
