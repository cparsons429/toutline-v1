<?php
  session_start();
  $host = 'localhost';
  $user = 'phpaccess';
  $pass = 'MQhN/\:~57c@qPsrqhT2=';
  $db = 'TOUTLINE_OUTLINES';
  $mysqli = new mysqli($host, $user, $pass, $db);

  foreach ($_POST as $key => $val) {
    $stmt = $mysqli->prepare("SELECT feedback_type FROM points WHERE id=?");
    $stmt->bind_param("i", intval($key));
    $stmt->execute();
    $stmt->bind_result($feedback_type);
    $stmt->fetch();
    $stmt->close();

    if ($feedback_type === 'category') {
      $stmt = $mysqli->prepare("INSERT INTO feedback (category_val, point_id) VALUES (?, ?)");
      $stmt->bind_param("ii", intval($val), intval($key));
      $stmt->execute();
      $stmt->close();
    } else if ($feedback_type === 'number') {
      $stmt = $mysqli->prepare("INSERT INTO feedback (number_val, point_id) VALUES (?, ?)");
      $stmt->bind_param("si", $val, intval($key));
      $stmt->execute();
      $stmt->close();
    } else if ($feedback_type === 'text') {
      $stmt = $mysqli->prepare("INSERT INTO feedback (text_val, point_id) VALUES (?, ?)");
      $stmt->bind_param("si", $val, intval($key));
      $stmt->execute();
      $stmt->close();
    } else {}
  }
?>
