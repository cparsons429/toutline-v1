<?php
  session_start();
  $host = 'localhost';
  $user = 'phpaccess';
  $pass = 'MQhN/\:~57c@qPsrqhT2=';
  $db = 'TOUTLINE_OUTLINES';
  $mysqli = new mysqli($host, $user, $pass, $db);

  $stmt = $mysqli->prepare("SELECT COUNT(*), id FROM teams WHERE name=?");
  $stmt->bind_param("s", $_POST['name']);
  $stmt->execute();
  $stmt->bind_result($count_str, $team_str);
  $stmt->fetch();
  $stmt->close();

  if (intval($count_str) == 0) {
    // create new team
    $stmt = $mysqli->prepare("INSERT INTO teams (name) VALUES (?)");
    $stmt->bind_param("s", $_POST['name']);
    $stmt->execute();
    $stmt->close();

    $stmt = $mysqli->prepare("SELECT LAST_INSERT_ID()");
    $stmt->execute();
    $stmt->bind_result($team_str);
    $stmt->fetch();
    $stmt->close();

    $points = [];
    $categories = [];
    $numbers = [];
    $texts = [];

    // create "getting started" tutorial
    $name = "Getting started";

    $points[0] = "Welcome to Toutline! This outline will show you everything you need to get started.";
    $categories[0] = null;
    $numbers[0] = null;
    $texts[0] = null;

    $points[1] = "On Toutline, you can create outlines. Outlines are saved automatically as you edit them.";
    $categories[1] = null;
    $numbers[1] = null;
    $texts[1] = null;

    $points[2] = "Outlines are made of points (like this!) Points convey information, and let you solitic feedback.";
    $categories[2] = null;
    $numbers[2] = null;
    $texts[2] = null;

    $points[3] = "There are three types of feedback you can solicit: categories, numbers, and text. You can also not ask for
                 feedback on a point (like these first points).";
    $categories[3] = null;
    $numbers[3] = null;
    $texts[3] = null;

    $points[4] = "Here's an example of a point asking for categorical feedback: what's your job role?";
    $categories[4] = [];
      $categories[4][0] = 'Technical';
      $categories[4][1] = 'Sales';
      $categories[4][2] = 'Marketing';
      $categories[4][3] = 'People Ops / HR';
      $categories[4][4] = 'BizDev';
      $categories[4][5] = 'Other';
    $numbers[4] = null;
    $texts[4] = null;

    $points[5] = "To add a category, just click the +C icon at the bottom of the point.";
    $categories[5] = [];
      $categories[5][0] = "If you only want people to select one category, remind them!";
      $categories[5][1] = "If you want to delete a category, click the trash icon next to it.";
    $numbers[5] = null;
    $texts[5] = null;

    $points[6] = "Now for the next type of feedback: a number. For example, how old are you?";
    $categories[6] = null;
    $numbers[6] = [0, 125];
    $texts[6] = null;

    $points[7] = "The final type of feedback is text, which allows people to reply however they want. You might ask an
                 open-ended question for this kind of point, like \"how has your week been?\"";
    $categories[7] = null;
    $numbers[7] = null;
    $texts[7] = 1;

    $points[8] = "To add a point, just click the +P icon at the bottom of the outline. To delete a point, click the trash
                 icon below it.";
    $categories[8] = null;
    $numbers[8] = null;
    $texts[8] = null;

    $points[9] = "To allow team members to edit an outline, just send them the link. They'll automatically be able to edit!
                 Careful: anyone with the link can edit the outline before it's finalized.";
    $categories[9] = null;
    $numbers[9] = null;
    $texts[9] = null;

    $points[10] = "When you've completed an outline, click the \"Finalize my outline\" button at the bottom of the page (try
                  this now!) In general, be careful when you do this: once an outline is finalized, you can no longer edit it.";
    $categories[10] = null;
    $numbers[10] = null;
    $texts[10] = null;

    $points[11] = "Once your outline is finished, people who read it will be able to submit feedback (try this yourself!)
                  When you're done with your feedback, click the \"Submit my feedback\" button at the bottom of the outline.";
    $categories[11] = null;
    $numbers[11] = null;
    $texts[11] = null;

    $points[12] = "When you want team members to read your outline and submit feedback, just send them the link! Careful:
                  anyone with the link can submit feedback once your outline's finalized.";
    $categories[12] = null;
    $numbers[12] = null;
    $texts[12] = null;

    $points[13] = "If you want to view peoples' feedback, or analyze it (for example, see how peoples' replies to \"how has
                  your week been\" change over time), drop your email in the box at the bottom of the Dashboard page. We're alpha testing our analysis software, so we can set you up with an alpha trial!";
    $categories[13] = null;
    $numbers[13] = null;
    $texts[13] = null;

    $points[14] = "You're ready to begin! How helpful was this \"Getting started\" outline?";
    $categories[14] = null;
    $numbers[14] = [1, 10];
    $texts[14] = null;

    // this will have to change eventually, there can be collisions between 6 random bytes if there are lots of users
    $slug = bin2hex(random_bytes(6));

    $stmt = $mysqli->prepare("INSERT INTO outlines (name, slug, team_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $name, $slug, intval($team_str));
    $stmt->execute();
    $stmt->close();

    $stmt = $mysqli->prepare("SELECT LAST_INSERT_ID()");
    $stmt->execute();
    $stmt->bind_result($outline_str);
    $stmt->fetch();
    $stmt->close();

    $point_ids = [];

    // automatically include first point
    $typefirst = 'none';
    $stmt = $mysqli->prepare("INSERT INTO points (point_text, feedback_type, outline_id, created) VALUES (?, ?, ?, null)");
    $stmt->bind_param("ssi", $points[0], $typefirst, intval($outline_str));
    $stmt->execute();
    $stmt->close();

    $stmt = $mysqli->prepare("SELECT LAST_INSERT_ID()");
    $stmt->execute();
    $stmt->bind_result($point_ids[0]);
    $stmt->fetch();
    $stmt->close();

    // automatically include two categories
    $stmt = $mysqli->prepare("INSERT INTO categories (point_id, created) VALUES (?, null)");
    $stmt->bind_param("i", intval($point_ids[0]);
    $stmt->execute();
    $stmt->close();

    $stmt = $mysqli->prepare("SELECT LAST_INSERT_ID()");
    $stmt->execute();
    $stmt->bind_result($categorya);
    $stmt->fetch();
    $stmt->close();

    $stmt = $mysqli->prepare("INSERT INTO categories (preceding_id, point_id, created) VALUES (?, ?, null)");
    $stmt->bind_param("ii", intval($categorya), intval($point_ids[0]));
    $stmt->execute();
    $stmt->close();

    $stmt = $mysqli->prepare("SELECT LAST_INSERT_ID()");
    $stmt->execute();
    $stmt->bind_result($categoryb);
    $stmt->fetch();
    $stmt->close();

    $stmt = $mysqli->prepare("UPDATE categories SET following_id=? WHERE id=?");
    $stmt->bind_param("ii", intval($categoryb), intval($categorya));
    $stmt->execute();
    $stmt->close();

    // algorithmically create all following points
    for ($i = 1; $i < sizeof($points); $i++) {
      if (!(is_null($categories[$i]))) {
        $type = 'category';
        $stmt = $mysqli->prepare("INSERT INTO points (point_text, preceding_id, feedback_type, outline_id, created) VALUES (?, ?, ?, ?, null)");
        $stmt->bind_param("sisi", $points[$i], intval($point_ids[$i-1]), $type, intval($outline_str));
        $stmt->execute();
        $stmt->close();

        $stmt = $mysqli->prepare("SELECT LAST_INSERT_ID()");
        $stmt->execute();
        $stmt->bind_result($point_ids[$i]);
        $stmt->fetch();
        $stmt->close();

        $category_ids = [];

        // automatically create first category
        $stmt = $mysqli->prepare("INSERT INTO categories (category_text, point_id, created) VALUES (?, ?, null)");
        $stmt->bind_param("si", $categories[$i][0], intval($point_ids[$i]);
        $stmt->execute();
        $stmt->close();

        $stmt = $mysqli->prepare("SELECT LAST_INSERT_ID()");
        $stmt->execute();
        $stmt->bind_result($category_ids[0]);
        $stmt->fetch();
        $stmt->close();

        // algorithmically create all following categories
        for ($j = 1; $j < sizeof($categories[$i]); $j++) {
          $stmt = $mysqli->prepare("INSERT INTO categories (category_text, preceding_id, point_id, created) VALUES (?, ?, ?, null)");
          $stmt->bind_param("sii", $categories[$i][$j], intval($category_ids[$j-1]), intval($point_ids[$i]));
          $stmt->execute();
          $stmt->close();

          $stmt = $mysqli->prepare("SELECT LAST_INSERT_ID()");
          $stmt->execute();
          $stmt->bind_result($category_ids[$j]);
          $stmt->fetch();
          $stmt->close();
        }

        for ($j = 0; $j < sizeof($categories[$i]) - 1; $j++) {
          $stmt = $mysqli->prepare("UPDATE categories SET following_id=? WHERE id=?");
          $stmt->bind_param("ii", intval($category_ids[$j+1]), intval($category_ids[$j]));
          $stmt->execute();
          $stmt->close();
        }
      } else {
        if (!(is_null($numbers[$i]))) {
          $type = 'number';
          $stmt = $mysqli->prepare("INSERT INTO points (point_text, preceding_id, feedback_type, low_num, high_num, outline_id, created) VALUES (?, ?, ?, ?, ?, ?, null)");
          $stmt->bind_param("sisiii", $points[$i], intval($point_ids[$i-1]), $type, $numbers[$i][0], $numbers[$i][1], intval($outline_str));
          $stmt->execute();
          $stmt->close();
        } else if (!(is_null($texts[$i]))) {
          $type = 'text';
          $stmt = $mysqli->prepare("INSERT INTO points (point_text, preceding_id, feedback_type, outline_id, created) VALUES (?, ?, ?, ?, null)");
          $stmt->bind_param("sisi", $points[$i], intval($point_ids[$i-1]), $type, intval($outline_str));
          $stmt->execute();
          $stmt->close();
        } else {
          $type = 'none';
          $stmt = $mysqli->prepare("INSERT INTO points (point_text, preceding_id, feedback_type, outline_id, created) VALUES (?, ?, ?, ?, null)");
          $stmt->bind_param("sisi", $points[$i], intval($point_ids[$i-1]), $type, intval($outline_str));
          $stmt->execute();
          $stmt->close();
        }

        $stmt = $mysqli->prepare("SELECT LAST_INSERT_ID()");
        $stmt->execute();
        $stmt->bind_result($point_ids[$i]);
        $stmt->fetch();
        $stmt->close();

        // automatically include two categories
        $stmt = $mysqli->prepare("INSERT INTO categories (point_id, created) VALUES (?, null)");
        $stmt->bind_param("i", intval($point_ids[$i]);
        $stmt->execute();
        $stmt->close();

        $stmt = $mysqli->prepare("SELECT LAST_INSERT_ID()");
        $stmt->execute();
        $stmt->bind_result($categorya);
        $stmt->fetch();
        $stmt->close();

        $stmt = $mysqli->prepare("INSERT INTO categories (preceding_id, point_id, created) VALUES (?, ?, null)");
        $stmt->bind_param("ii", intval($categorya), intval($point_ids[$i]));
        $stmt->execute();
        $stmt->close();

        $stmt = $mysqli->prepare("SELECT LAST_INSERT_ID()");
        $stmt->execute();
        $stmt->bind_result($categoryb);
        $stmt->fetch();
        $stmt->close();

        $stmt = $mysqli->prepare("UPDATE categories SET following_id=? WHERE id=?");
        $stmt->bind_param("ii", intval($categoryb), intval($categorya));
        $stmt->execute();
        $stmt->close();
      }
    }

    for ($i = 0; $i < sizeof($points) - 1; $i++) {
      $stmt = $mysqli->prepare("UPDATE points SET following_id=? WHERE id=?");
      $stmt->bind_param("ii", intval($point_ids[$i+1]), intval($point_ids[$i]));
      $stmt->execute();
      $stmt->close();
    }
  }

  $_SESSION['team_id'] = intval($team_str);
?>
