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
    <form action="form.php" enctype="multipart/form-data">
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