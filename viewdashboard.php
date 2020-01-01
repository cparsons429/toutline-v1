<?php
  session_start();
  $host = 'localhost';
  $user = 'phpaccess';
  $pass = 'MQhN/\:~57c@qPsrqhT2=';
  $db = 'TOUTLINE_OUTLINES';
  $mysqli = new mysqli($host, $user, $pass, $db);

  $stmt = $mysqli->prepare("SELECT name, slug FROM outlines WHERE team_id=?");
  $stmt->bind_param("i", $_SESSION['team_id']);
  $stmt->execute();
  $stmt->bind_result($names, $slugs);
  $stmt->fetch_all();
  $stmt->close();

  $outlines = [];

  for ($i = 0; $i < sizeof($names); $i++) {
    $outlines[$i]->name = $names[$i];
    $outlines[$i]->slug = $slugs[$i];
  }

  echo json_encode($outlines);
?>
