<?php
// подключаем бд
include('dbconnect.php');

$count_phone = 1;

// проверка данных на валидность
if (isset($_POST['submit'])) {

    $errors = array();

    if (empty($_POST["fio"])) {
        $errors[] = "Введите ФИО.";
    } else {
        $fio = input_valid($_POST["fio"]);

        if (strlen($fio) < 8){
            $errors[] = "ФИО: Минимум 9 символов";
        }
        if (!preg_match("/^[a-zа-яё\s]+$/iu",$fio)) {
            $errors[] = "ФИО: Разрешены только буквы и пробелы";
        }
    }

    if (empty($_POST["email"])) {
        $errors[] = "Введите email.";
    } else {
        $email = input_valid($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Введите правильный email.";
        }

        $result_query = $mysqli->query("SELECT `email` FROM `users` WHERE `email`='".$email."'");
        if ($result_query->num_rows == 1) {
            $errors[] = "Ошибка. Данный email уже используется.";
        }
    }

    if (empty($_POST["phone"])) {
        $errors[] = "Введите телефон.";
    } else {
        $phone = phone_valid($_POST["phone"]);
        if(!$phone) {
            $errors[] = "Введите корректный телефон. Пример 0995426374. 10 цифр";
        }
    }

    if (!empty($_POST["count_phone"])){
        $count_phone = $_POST["count_phone"];
    }

    if (empty($_POST["age"])) {
        $errors[] = "Укажите возраст.";
    } else {
        $age = input_valid($_POST["age"]);
    }

    if (empty($_FILES['photo']['name'])) {
        $errors[] = "Загрузите изображение.";
    } else {
        $file = $_FILES['photo'];
        $current_path = $file['tmp_name'];
        $filename = $file['name'];
        $new_path = dirname(__FILE__) . '/img/' . $filename;
    }

    if (empty($_POST["resume"])) {
        $errors[] = "Напишите резюме.";
    } else {
        $resume = input_valid($_POST["resume"]);
    }

}

/*
 * trim удаляет пробелы из начала и конца строки,
 * stripcslashes - удаляет экранированние символов
 * htmlspecialchars — преобразует специальные символы в HTML-сущности
 *
 */
function input_valid($data) {
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Функция Ищет в заданном массиве $data совпадения с шаблоном pattern
function phone_valid($data) {
    foreach ($data as $phone) {
        if(!preg_match('/^[0-9]{3}[0-9]{3}[0-9]{4}$/',$phone)) {
            return false;
        }
    }
    return $data;
}

if (empty($errors)) {
    $phone = serialize($phone);
    $result_query_insert = $mysqli->query("INSERT INTO `users` (FIO, email, phone, age, photo, resume) VALUES ('".$fio."', '".$email."', '".$phone."', '".$age."', '".$filename."', '".$resume."')");

    if ($result_query_insert) {
        move_uploaded_file($current_path, $new_path);
        echo 'Данные успешно добавлены';
    }
}

if (isset($_POST['add_phone'])){
    $count_phone += (int) $_POST['count_phone'];
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
    <div class="errors-massage">
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
    <form id="form" action="form.php" method="POST" enctype="multipart/form-data">
        <label>ФИО</label><br>
        <input type="text" name="fio" value="<?php echo $_POST['fio']; ?>"><br>
        <label>Email</label><br>
        <input type="text" name="email" value="<?php echo $_POST['email']; ?>"><br>

        <div id="phone">
            <label>Телефон</label><br>
            <input type="hidden" name="count_phone" value="<?php echo $count_phone; ?>">
            <?php for ($x=0; $x < $count_phone; $x++): ?>
                <input type="tel" name="phone[]" value="<?php echo $_POST["phone"][$x]; ?>" class="phone"><br>
            <?php endfor; ?>
            <br><input type="submit" name="add_phone" value="Добавить поле"><br><br>
        </div>

        <label>Возраст</label><br>
        <input type="number" name="age" value="<?php echo $_POST['age']; ?>"><br>
        <label>Фото</label><br>
        <input type="file" name="photo"><br>
        <label>Резюме</label><br>
        <textarea name="resume"><?php echo $_POST['resume']; ?></textarea><br>
        <input type="submit" name="submit">
    </form>
</body>
</html>