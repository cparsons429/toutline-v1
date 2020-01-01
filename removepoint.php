<?php
  session_start();
  $host = 'localhost';
  $user = 'phpaccess';
  $pass = 'MQhN/\:~57c@qPsrqhT2=';
  $db = 'TOUTLINE_OUTLINES';
  $mysqli = new mysqli($host, $user, $pass, $db);

  $preceding = 0;
  $following = 0;

  $stmt = $mysqli->prepare("DELETE FROM points WHERE id=?");
  $stmt->bind_param("i", intval($_POST['id']));
  $stmt->execute();
  $stmt->close();

  $stmt = $mysqli->prepare("SELECT COUNT(*), id FROM points WHERE following_id=?");
  $stmt->bind_param("i", intval($_POST['id']));
  $stmt->execute();
  $stmt->bind_result($preceding_ct_str, $preceding_id_str);
  $stmt->fetch();
  $stmt->close();

  $stmt = $mysqli->prepare("SELECT COUNT(*), id FROM points WHERE preceding_id=?");
  $stmt->bind_param("i", intval($_POST['id']));
  $stmt->execute();
  $stmt->bind_result($following_ct_str, $following_id_str);
  $stmt->fetch();
  $stmt->close();

  if (intval($preceding_ct_str) != 0 && intval($following_ct_str) != 0) {
    $stmt = $mysqli->prepare("UPDATE points SET following_id=? WHERE id=?");
    $stmt->bind_param("ii", intval($following_id_str), intval($preceding_id_str));
    $stmt->execute();
    $stmt->close();

    $stmt = $mysqli->prepare("UPDATE points SET preceding_id=? WHERE id=?");
    $stmt->bind_param("ii", intval($preceding_id_str), intval($following_id_str));
    $stmt->execute();
    $stmt->close();
  } else if (intval($preceding_ct_str) != 0) {
    $stmt = $mysqli->prepare("UPDATE points SET following_id=? WHERE id=?");
    $stmt->bind_param("ii", $following, intval($preceding_id_str));
    $stmt->execute();
    $stmt->close();
  } else if (intval($following_ct_str) != 0) {
    $stmt = $mysqli->prepare("UPDATE points SET preceding_id=? WHERE id=?");
    $stmt->bind_param("ii", $preceding, intval($following_id_str));
    $stmt->execute();
    $stmt->close();
  } else {}
?>
