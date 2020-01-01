<?php
  session_start();
  $host = 'localhost';
  $user = 'phpaccess';
  $pass = 'MQhN/\:~57c@qPsrqhT2=';
  $db = 'TOUTLINE_OUTLINES';
  $mysqli = new mysqli($host, $user, $pass, $db);

  // this will have to change eventually, there can be collisions between 6 random bytes if there are lots of users
  $slug = bin2hex(random_bytes(6));

  $stmt = $mysqli->prepare("INSERT INTO outlines (slug, team_id) VALUES (?, ?)");
  $stmt->bind_param("si", $slug, $_SESSION['team_id']);
  $stmt->execute();
  $stmt->close();

  $stmt = $mysqli->prepare("SELECT LAST_INSERT_ID()");
  $stmt->execute();
  $stmt->bind_result($outline_str);
  $stmt->fetch();
  $stmt->close();

  // automatically include first point
  $stmt = $mysqli->prepare("INSERT INTO points (outline_id, created) VALUES (?, null)");
  $stmt->bind_param("i", intval($outline_str));
  $stmt->execute();
  $stmt->close();

  $stmt = $mysqli->prepare("SELECT LAST_INSERT_ID()");
  $stmt->execute();
  $stmt->bind_result($point0_str);
  $stmt->fetch();
  $stmt->close();

  // automatically include two categories
  $stmt = $mysqli->prepare("INSERT INTO categories (point_id, created) VALUES (?, null)");
  $stmt->bind_param("i", intval($point0_str));
  $stmt->execute();
  $stmt->close();

  $stmt = $mysqli->prepare("SELECT LAST_INSERT_ID()");
  $stmt->execute();
  $stmt->bind_result($category0a_str);
  $stmt->fetch();
  $stmt->close();

  $stmt = $mysqli->prepare("INSERT INTO categories (preceding_id, point_id, created) VALUES (?, ?, null)");
  $stmt->bind_param("ii", intval($category0a_str), intval($point0_str));
  $stmt->execute();
  $stmt->close();

  $stmt = $mysqli->prepare("SELECT LAST_INSERT_ID()");
  $stmt->execute();
  $stmt->bind_result($category0b_str);
  $stmt->fetch();
  $stmt->close();

  $stmt = $mysqli->prepare("UPDATE categories SET following_id=? WHERE id=?");
  $stmt->bind_param("ii", intval($category0b_str), intval($category0a_str));
  $stmt->execute();
  $stmt->close();

  // automatically include second point
  $stmt = $mysqli->prepare("INSERT INTO points (preceding_id, outline_id, created) VALUES (?, ?, null)");
  $stmt->bind_param("ii", intval($point0_str), intval($outline_str));
  $stmt->execute();
  $stmt->close();

  $stmt = $mysqli->prepare("SELECT LAST_INSERT_ID()");
  $stmt->execute();
  $stmt->bind_result($point1_str);
  $stmt->fetch();
  $stmt->close();

  $stmt = $mysqli->prepare("UPDATE points SET following_id=? WHERE id=?");
  $stmt->bind_param("ii", intval($point1_str), intval($point0_str));
  $stmt->execute();
  $stmt->close();

  // automatically include two categories
  $stmt = $mysqli->prepare("INSERT INTO categories (point_id, created) VALUES (?, null)");
  $stmt->bind_param("i", intval($point1_str));
  $stmt->execute();
  $stmt->close();

  $stmt = $mysqli->prepare("SELECT LAST_INSERT_ID()");
  $stmt->execute();
  $stmt->bind_result($category1a_str);
  $stmt->fetch();
  $stmt->close();

  $stmt = $mysqli->prepare("INSERT INTO categories (preceding_id, point_id, created) VALUES (?, ?, null)");
  $stmt->bind_param("ii", intval($category1a_str), intval($point1_str));
  $stmt->execute();
  $stmt->close();

  $stmt = $mysqli->prepare("SELECT LAST_INSERT_ID()");
  $stmt->execute();
  $stmt->bind_result($category1b_str);
  $stmt->fetch();
  $stmt->close();

  $stmt = $mysqli->prepare("UPDATE categories SET following_id=? WHERE id=?");
  $stmt->bind_param("ii", intval($category1b_str), intval($category1a_str));
  $stmt->execute();
  $stmt->close();

  echo $slug;
?>
