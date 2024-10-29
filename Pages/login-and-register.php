<?php
require_once "../Configs/pdo-connection.php";

session_start();

$register_success_alert_show = false;
$register_danger_alert_show = false;

$login_success_alert_show = false;
$login_danger_alert_show = false;

if (isset($_POST['register_sub'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $search_query = "SELECT * FROM users WHERE email = ?";
    $search_result = $conn -> prepare($search_query);
    $search_result->bindValue(1, $email);
    $search_result->execute();

    if ($search_result->rowCount() > 0) {

        $register_danger_alert_show = true;
        
    } else {
      
        $insert_query = "INSERT INTO users SET name=? , email=? , password=?";
        $insert_result = $conn -> prepare($insert_query);

        $insert_result -> bindValue(1, $name);
        $insert_result -> bindValue(2, $email);
        $insert_result -> bindValue(3, $password);

        if ($insert_result -> execute()) {
            $register_success_alert_show = true;
        }
    }
}

if (isset($_POST['login_sub'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $search_query = "SELECT * FROM users WHERE email=?";
    $search_result = $conn -> prepare($search_query);

    $search_result -> bindValue(1, $email);

    $search_result -> execute();
    
    $user = $search_result -> fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['loggedin'] = true;
        $_SESSION['useremail'] = $email;

        $login_success_alert_show = true;
        header("Location: ./admin-panel.php");

        exit();

    } else {

        $login_danger_alert_show = true;

    }
}
?>


<!DOCTYPE html>
<html>
  <head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>ورود / ثبت نام</title>
    <link rel="stylesheet" type="text/css" href="../Assets/Styles/login-and-register-style.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <div>
    <?php if($register_success_alert_show) echo '<p style="text-align:center;" class="alert alert-success">ثبت نام با موفقیت انجام شد</p>'?>
    <?php if($register_danger_alert_show) echo '<p style="text-align:center;" class="alert alert-danger">ایمیل تکراری میباشد</p>'?>
      <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true" />
        <div class="signup">
          <form method="POST">
            <label for="chk" aria-hidden="true">ثبت نام</label>
            <input style="text-align:right;" type="text" name="name" placeholder="نام کاربری" required="" />
            <input style="text-align:right;" type="email" name="email" placeholder="ایمیل" required="" />
            <input style="text-align:right;" type="password" name="password" placeholder="رمز عبور" required="" />
            <button type="submit" name="register_sub">ثبت نام</button>
          </form>
            <button><a href="index.php">صفحه اصلی</a></button>
            </div>
        <div class="login">
          <form method="POST">
            <label for="chk" aria-hidden="true">ورود</label>
            <input style="text-align:right;" type="email" name="email" placeholder="ایمیل" required="" />
            <input style="text-align:right;" type="password" name="password" placeholder="رمز عبور" required="" />
            <button type="submit" name="login_sub">ورود</button>
            <?php if($login_success_alert_show) echo '<p style="text-align:center;" class="alert alert-success">ورود با موفقیت انجام شد</p>'?>
            <?php if($login_danger_alert_show) echo '<p style="text-align:center;" class="alert alert-danger">ایمیل یا رمز عبور صحیح نمیباشد</p>'?>
          </form>
          <button><a href="index.php">صفحه اصلی</a></button>
        </div>
      </div>
    </div>
  </body>
</html>
