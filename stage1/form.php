<?php
// подключаем бд
include('dbconnect.php');

// проверка данных на валидность
if (isset($_POST['submit'])) {

    $errors = array();

    // trim — Удаляет пробелы из начала и конца строки
    $fio = trim($_POST['fio']);
    if ($fio == ''){
        $errors[] = "Введите ФИО.";
    }

    $email = trim($_POST['email']);
    if ($email == ''){
        $errors[] = "Введите email.";
    }

    $result_query = $mysqli->query("SELECT `email` FROM `users` WHERE `email`='".$email."'");
    if ($result_query->num_rows == 1){
        $errors[] = "Ошибка. Данный email уже используется.";
    }

    $phone = trim($_POST['phone']);
    if ($phone == ''){
        $errors[] = "Введите телефон.";
    }

    $age = trim($_POST['age']);
    if ($age == ''){
        $errors[] = "Укажите возраст.";
    }

    $resume = trim($_POST['resume']);
    if ($resume == ''){
        $errors[] = "Напишите резюме.";
    }

    if (isset($_FILES['photo'])) {
        $file = $_FILES['photo'];
        $current_path = $file['tmp_name'];
        $filename = $file['name'];
        $new_path = dirname(__FILE__) . '/img/' . $filename;
    }

}

if (empty($errors)){
    $result_query_insert = $mysqli->query("INSERT INTO `users` (FIO, email, phone, age, photo, resume) VALUES ('".$fio."', '".$email."', '".$phone."', '".$age."', '".$filename."', '".$resume."')");

    if ($result_query_insert){
        move_uploaded_file($current_path, $new_path);
        echo 'Данные успешно добавлены';
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stage1</title>
</head>
<body>
    <div class="error-massage">
        <ul>
        <?php
            // вывод ошибок полей формы, если найдены
            if (!empty($errors)) {
                foreach ($errors as $value) {
                    echo '<li>' . $value . '</li>';
                }
            }
        ?>
        </ul>
    </div>
    <form action="form.php" method="POST" enctype="multipart/form-data">
        <label>ФИО</label><br>
        <input type="text" name="fio"><br>
        <label>Email</label><br>
        <input type="text" name="email"><br>
        <label>Телефон</label><br>
        <input type="tel" name="phone"><br>
        <label>Возраст</label><br>
        <input type="number" name="age"><br>
        <label>Фото</label><br>
        <input type="file" name="photo"><br>
        <label>Резюме</label><br>
        <textarea name="resume"></textarea><br>
        <input type="submit" name="submit">
    </form>
</body>
</html>