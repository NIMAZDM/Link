<?php

require_once "../Configs/pdo-connection.php";

$upload_success_show = false;
$upload_danger_show = false;

if (isset($_POST["submit"])) {

  $file_name = "format-" . time() . basename($_FILES["fileToUpload"]["name"]);

  $target_dir = "../Assets/Uploads/";
  $target_file = $target_dir . $file_name;
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  if ($uploadOk == 0) $upload_danger_show = true;

  else {

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

      $upload_success_show = true;

      $insert_query = "INSERT INTO files SET file_name=? , create_time=?";
      $insert_result = $conn -> prepare($insert_query);

      $insert_result -> bindValue(1, $file_name);
      $insert_result -> bindValue(2, time());

      $insert_result -> execute();

    } else $upload_danger_show = true;
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../Assets/Styles/upload.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap"
    rel="stylesheet" />
  <title>آپلودر</title>
</head>

<body>
  <div>
    <?php if ($upload_success_show) echo '<p class="alert alert-success" style="text-align:center;">فایل شما آپلود شد</p>'; ?>
    <?php if ($upload_danger_show) echo '<p class="alert alert-danger" style="text-align:center;">فایل شما آپلود نشد</p>'; ?>
    <div class="main">
      <input type="checkbox" id="chk" aria-hidden="true" />
      <div class="signup">
        <form method="POST" enctype="multipart/form-data">
          <label for="chk" style="font-size: 30px;" aria-hidden="true">آپلودر</label>
          <label for="file-upload" class="custom-file-upload">
            انتخاب فایل
          </label>
          <input id="file-upload" name="fileToUpload" type="file" />
          <input type="submit" value="آپلود فایل" name="submit" />
        </form>
        <button><a href="index.php">کوتاه کننده لینک</a></button>
        <button><a href="contact-us.php">تماس با ما</a></button>
        <button><a href="login-and-register.php">ثبت نام / ورود</a></button>
        <button><a href="upload.php">آپلود فایل</a></button>
      </div>
    </div>
</body>

</html>