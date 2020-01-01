<?php
  session_start();
  $host = 'localhost';
  $user = 'phpaccess';
  $pass = 'MQhN/\:~57c@qPsrqhT2=';
  $db = 'TOUTLINE_OUTLINES';
  $mysqli = new mysqli($host, $user, $pass, $db);

  $stmt = $mysqli->prepare("SELECT id, feedback_type, point_text, low_num, high_num FROM points WHERE outline_id=?");
  $stmt->bind_param("i", $_POST['outline_id']);
  $stmt->execute();
  $stmt->bind_result($pt_ids, $types, $pt_texts, $low_nums, $high_nums);
  $stmt->fetch_all();
  $stmt->close();

  $points = [];

  for ($i = 0; $i < sizeof($point_ids); $i++) {
    $points[$i]->id = $pt_ids[$i];
    $points[$i]->type = $types[$i];
    $points[$i]->text = $pt_texts[$i];
    $points[$i]->low_num = $low_nums[$i];
    $points[$i]->high_num = $high_nums[$i];

    $stmt = $mysqli->prepare("SELECT id, category_text FROM categories WHERE point_id=?");
    $stmt->bind_param("i", intval($pt_ids[$i]));
    $stmt->execute();
    $stmt->bind_result($cat_ids, $cat_texts);
    $stmt->fetch_all();
    $stmt->close();

    $points[$i]->category_ids = $cat_ids;
    $points[$i]->category_texts = $cat_texts;
  }

  echo json_encode($points);
?>
