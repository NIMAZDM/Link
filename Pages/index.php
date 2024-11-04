<?php

require_once "../Configs/pdo-connection.php";

$success_alert_show = false;
$danger_alert_show = false;
$show_type = false;

$link_redirect = "";
$user_link = "";
$type = "";
$link_record = "";

if (isset($_GET['url'])) {

  $url = "https://localhost/link/pages?url=" . $_GET['url'];

  $search_query = "SELECT * FROM links WHERE custom_link=?";
  $result_search_query = $conn->prepare($search_query);

  $result_search_query->bindValue(1, $url);

  $result_search_query->execute();
  $link_record = $result_search_query->fetch(PDO::FETCH_ASSOC);

  $link_redirect = $link_record["user_link"];

  if ($link_record["type"] == "indirect") $show_type = true;
  else header("Location: " . $link_redirect);
}

if (isset($_POST['sub'])) {

  $user_link = $_POST['user_link'];
  $custom_link = "https://localhost/link/pages?url=" . $_POST['custom_link'];
  $type = $_POST['type'];


  $select_query = "SELECT * FROM links WHERE custom_link=?";
  $select_result = $conn->prepare($select_query);

  $select_result->bindValue(1, $custom_link);

  $select_result->execute();

  if ($select_result->rowcount()) $danger_alert_show = true;
  else {

    $insert_query = "INSERT INTO links SET user_link=? , custom_link=? , type=?";
    $insert_result = $conn->prepare($insert_query);

    $insert_result->bindValue(1, $user_link);
    $insert_result->bindValue(2, $custom_link);
    $insert_result->bindValue(3, $type);

    if ($insert_result->execute()) $success_alert_show = true;
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../Assets/Styles/style.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap"
    rel="stylesheet" />
  <title>کوتاه کننده لینک</title>
</head>

<body>
  <?php if (!$show_type) { ?>
    <div>
      <?php if ($success_alert_show) echo '<p style="text-align:center;" class="alert alert-success"><a style="color:blue;" href="' . $custom_link . '">لینک شما ساخته شد</a></p>' ?>
      <?php if ($danger_alert_show) echo '<p style="text-align:center;" class="alert alert-danger">لینک شما از قبل وجود داشته است</p>' ?>
      <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true" />
        <div class="signup">
          <form method="POST">
            <label for="chk" style="font-size: 30px;" aria-hidden="true">کوتاه کننده لینک</label>
            <input type="url" name="user_link" style="text-align:right;" placeholder="لینک خود را وارد کنید" required="" />
            <input type="text" name="custom_link" placeholder="لینک کوتاه خود راوارد کنید" required="" />
            <select name="type" class="select">
              <option value="direct">مستقیم</option>
              <option value="indirect">غیرمسقتیم</option>
            </select>
            <button type="submit" name="sub">کوتاه کردن</button>
          </form>
          <button><a href="contact-us.php">تماس با ما</a></button>
          <button><a href="login-and-register.php">ثبت نام / ورود</a></button>
          <button><a href="upload.php">آپلود فایل</a></button>
        </div>
      </div>
    <?php } else { ?>
      <div>
        <img src="https://biz-cdn.varzesh3.com/banners/2024/09/24/C/d2na2ut3.gif" />
        <img src="https://biz-cdn.varzesh3.com/banners/2024/08/31/B/f0hgn1ix.gif" />
        <a style="margin-top:5%;margin-left:35%;" target="_blank" href="<?= $link_redirect ?>" class="btn btn-primary">کلیک کن</a>
      </div>

    <?php } ?>
</body>

</html>