
<?php

    require_once "../Configs/pdo-connection.php";

    $success_alert_show = false;

    if(isset($_POST['sub'])) {

      $name = $_POST['name'];
      $email = $_POST['email'];
      $phone = $_POST['phone'];
      $caption = $_POST['caption'];

      $insert_query = "INSERT INTO contacts SET name=? , email=? , phone=? , caption=?";
      $insert_result = $conn -> prepare($insert_query);

      $insert_result -> bindValue(1, $name);
      $insert_result -> bindValue(2, $email);
      $insert_result -> bindValue(3, $phone);
      $insert_result -> bindValue(4, $caption);

      if($insert_result -> execute()) $success_alert_show = true;

    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../Assets/Styles/contact-us-style.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap"
      rel="stylesheet"
    />
    <title>تماس با ما</title>
  </head>
  <body>
    <div>
    <?php if($success_alert_show) echo '<p style="text-align:center;" class="alert alert-success">فرم شما با موفقیت ارسال شد</p>'; ?>
      <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true" />
  
        <div class="signup">
          <form method="POST">
            <label for="chk" aria-hidden="true"> تماس با ما </label>
            <input type="text" style="text-align:right;" name="name" placeholder="نام" required="" />
            <input type="email" style="text-align:right;" name="email" placeholder="ایمیل" required="" />
            <input type="tel" style="text-align:right;" name="phone" placeholder="شماره تلفن" required="" maxlength="11"/>
            <textarea cols="30" style="text-align:right;" rows="5" name="caption" placeholder="...متن پیام" maxlength="2000"></textarea>
            <button type="submit" name="sub">ارسال</button>
          </form>
          <button><a href="index.php">صفحه اصلی</a></button>
          <button><a href="login-and-register.php">ثبت نام / ورود</a></button>
          </div>
          </div>
  </body>
</html>
