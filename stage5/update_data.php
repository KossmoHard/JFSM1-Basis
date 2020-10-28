<?php
// подключаем бд
include('dbconnect.php');

// проверка данных на валидность
if (isset($_POST)) {

    $errors = array();

    if (empty($_POST["fio"])) {
        $errors["fio"] .= "Введите ФИО.";
    } else {
        $fio = input_valid($_POST["fio"]);

        if (strlen($fio) < 8){
            $errors["fio"] .= "ФИО: Минимум 9 символов";
        }
        if (!preg_match("/^[a-zа-яё\s]+$/iu",$fio)) {
            $errors[] = "ФИО: Разрешены только буквы и пробелы";
        }
    }

    if (empty($_POST["email"])) {
        $errors["email"] .= "Введите email.";
    } else {
        $email = input_valid($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] .= "Введите правильный email.";
        }

        $result_query = $mysqli->query("SELECT `email` FROM `users` WHERE `email`='".$email."'");
        if ($result_query->num_rows == 1) {
            $errors["email"] .= "Ошибка. Данный email уже используется.";
        }
    }

    if (empty($_POST["phone"])) {
        $errors["phone"] .= "Введите телефон.";
    } else {
        $phone = phone_valid($_POST["phone"]);
        if(!$phone) {
            $errors["phone"] .= "Введите корректный телефон. Пример 0995426374. 10 цифр";
        }
    }

    if ( empty($_POST["age"]) ) {
        $errors["age"] .= "Укажите возраст.";
    } else if (( $_POST["age"] > 60 ) || ($_POST["age"] < 8)) {
        $errors["age"] .= "Укажите допустимый возраст. От 8 до 60 лет.";
    } else {
        $age = input_valid($_POST["age"]);
    }

    if (empty($_FILES['photo']['name'])) {
        $errors["photo"] .= "Загрузите изображение.";
    } else {
        $file = $_FILES['photo'];
        $current_path = $file['tmp_name'];
        $filename = $file['name'];
        $new_path = dirname(__FILE__) . '/img/uploads/' . $filename;
    }

    if (empty($_POST["resume"])) {
        $errors["resume"] .= "Напишите резюме.";
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

// Функция ищет в заданном массиве $data совпадения с шаблоном pattern
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
        $result["ok"] = 'Данные успешно добавлены!';
        $data_json = json_encode($result, JSON_UNESCAPED_UNICODE);
        echo $data_json;
    }
} else {
    $data_json = json_encode($errors, JSON_UNESCAPED_UNICODE);
    echo $data_json;
}

?>
