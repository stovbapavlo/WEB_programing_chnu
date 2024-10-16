<?php
// Читання файлу oblinfo.txt
$filename = "oblinfo.txt";
if (file_exists($filename)) {
    $file = fopen($filename, "r");
    $oblasts = [];

    // Читання даних по кожній області
    while (!feof($file)) {
        $oblast_name = trim(fgets($file)); // Назва області
        $population = trim(fgets($file));  // Населення
        $universities = trim(fgets($file)); // Кількість ВНЗ
        if ($oblast_name && $population && $universities) {
            $oblasts[] = [
                'name' => $oblast_name,
                'population' => $population,
                'universities' => $universities
            ];
        }
    }
    fclose($file);
} else {
    echo "Файл обласної інформації не знайдено.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
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
