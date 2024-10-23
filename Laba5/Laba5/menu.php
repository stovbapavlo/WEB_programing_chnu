<?php
// Підключення файлу з функціями
require_once 'functions.php';

$filename = "oblinfo.txt";
$oblasts = readOblastsFromFile($filename);

if ($oblasts === false) {
    echo "Файл обласної інформації не знайдено.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <title>Вибір області</title>
</head>
<body>
<form action="handle_request.php" method="post">
    <label for="oblast">Виберіть область:</label>
    <select name="oblast_id" id="oblast">
        <?php
        foreach ($oblasts as $index => $oblast) {
            echo "<option value=\"$index\">{$oblast['name']}</option>";
        }
        ?>
    </select>
    <br><br>
    <input type="submit" value="Відправити запит">
</form>
</body>
</html>
