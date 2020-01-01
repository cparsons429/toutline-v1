<?php
  session_start();
  $host = 'localhost';
  $user = 'phpaccess';
  $pass = 'MQhN/\:~57c@qPsrqhT2=';
  $db = 'TOUTLINE_OUTLINES';
  $mysqli = new mysqli($host, $user, $pass, $db);

  $stmt = $mysqli->prepare("INSERT INTO points (preceding_id, outline_id, created) VALUES (?, ?, null)");
  $stmt->bind_param("ii", intval($_POST['preceding_id']), intval($_POST['outline_id']));
  $stmt->execute();
  $stmt->close();

  $stmt = $mysqli->prepare("SELECT LAST_INSERT_ID()");
  $stmt->execute();
  $stmt->bind_result($point_str);
  $stmt->fetch();
  $stmt->close();

  $stmt = $mysqli->prepare("UPDATE points SET following_id=? WHERE id=?");
  $stmt->bind_param("ii", intval($point_str), intval($_POST['preceding_id']));
  $stmt->execute();
  $stmt->close();

  // automatically include two categories
  $stmt = $mysqli->prepare("INSERT INTO categories (point_id, created) VALUES (?, null)");
  $stmt->bind_param("i", intval($_POST['point_id']));
  $stmt->execute();
  $stmt->close();

  $stmt = $mysqli->prepare("SELECT LAST_INSERT_ID()");
  $stmt->execute();
  $stmt->bind_result($categorya_str);
  $stmt->fetch();
  $stmt->close();

  $stmt = $mysqli->prepare("INSERT INTO categories (preceding_id, point_id, created) VALUES (?, ?, null)");
  $stmt->bind_param("ii", intval($categorya_str), intval($_POST['point_id']));
  $stmt->execute();
  $stmt->close();

  $stmt = $mysqli->prepare("SELECT LAST_INSERT_ID()");
  $stmt->execute();
  $stmt->bind_result($categoryb_str);
  $stmt->fetch();
  $stmt->close();

  $stmt = $mysqli->prepare("UPDATE categories SET following_id=? WHERE id=?");
  $stmt->bind_param("ii", intval($categoryb_str), intval($categorya_str));
  $stmt->execute();
  $stmt->close();

  echo $point_str;
?>
