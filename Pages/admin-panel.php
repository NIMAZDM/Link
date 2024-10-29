<?php
require_once "../Configs/pdo-connection.php";
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {

    header("Location: ./login-and-register.php");

    exit();

}

#region contact-data
$contact_select_query = "SELECT * FROM contacts";
$contact_select_result = $conn->prepare($contact_select_query);

$contact_select_result -> execute();

$contact_data = $contact_select_result -> fetchAll(PDO::FETCH_OBJ);
#endregion

#region file-data
$file_select_query = "SELECT * FROM files";
$file_select_result = $conn->prepare($file_select_query);

$file_select_result -> execute();

$file_data = $file_select_result -> fetchAll(PDO::FETCH_OBJ);
#endregion


if (isset($_GET['messagedelete'])) {

    $delete_query = "DELETE FROM contacts WHERE id = ?";
    $delete_result = $conn->prepare($delete_query);

    $delete_result -> bindValue(1, $_GET['messagedelete']);

    $delete_result -> execute();

    header("Location: ./admin-panel.php");

    exit();
}

if (isset($_GET['filedelete'])) {

    $delete_query = "DELETE FROM files WHERE id=?";
    $delete_result = $conn->prepare($delete_query);

    $delete_result -> bindValue(1, $_GET['filedelete']);

    $delete_result -> execute();

    header("Location: ./admin-panel.php");

    exit();
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        @font-face {
            font-family:'iranian-sans' ;
            src: url('font/iranian-sans.otf') format('otf'),
                 url('font/iranian-sans.woff2') format('woff2');
        }
        body {
            direction: rtl;
            text-align: right;
            font-family: iranian-sans;
        }
    </style>
    <title>پنل ادمین</title>
    <link rel="stylesheet" type="text/css" href="../Assets/Styles/admin-panel-style.css" />
</head>
<body>
    <div class="container table-responsive py-5">
        <table style="text-align:center;" class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ردیف</th>
                    <th scope="col">نام</th>
                    <th scope="col">شماره همراه</th>
                    <th scope="col">ایمیل</th>
                    <th scope="col">عملیات</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($contact_data as $key => $value): ?>
                <tr>
                    <th scope="row"><?= ++$key ?></th>
                    <td><?= htmlspecialchars($value->name) ?></td>
                    <td><?= htmlspecialchars($value->phone) ?></td>
                    <td><?= htmlspecialchars($value->email) ?></td>
                    <td>
                        <a href="?messageshow=<?= $value->id ?>" class="btn btn-primary">نمایش</a>
                        <a href="?messagedelete=<?= $value->id ?>" class="btn btn-danger" style="margin-right:20px;">حذف</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="container table-responsive py-5">
        <table style="text-align:center;" class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ردیف</th>
                    <th scope="col">نام</th>
                    <th scope="col">عملیات</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($file_data as $key => $value): ?>
                <tr>
                    <th scope="row"><?= ++$key ?></th>
                    <td><?= htmlspecialchars($value -> file_name) ?></td>
                    <td>
                        <a href="../Assets/Uploads/<?=$value -> file_name?>" download class="btn btn-primary">دانلود</a>
                        <a href="?filedelete=<?= $value -> id ?>" class="btn btn-danger" style="margin-right:20px;">حذف</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
