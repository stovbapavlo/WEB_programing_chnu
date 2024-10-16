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
    <meta charset="UTF-8">
    <title>Інформація про область</title>
    <link rel="stylesheet" href="styles.css"> <!-- Підключення CSS файлу -->
</head>
<body>

<?php
// Отримуємо обрану область
if (isset($_POST['oblast_id'])) {
    $oblast_id = intval($_POST['oblast_id']);
    if (isset($oblasts[$oblast_id])) {
        $oblast = $oblasts[$oblast_id];

        // Обчислення кількості ВНЗ на 100 тис. населення
        $universities_per_100k = ($oblast['universities'] / $oblast['population']) * 100;

        echo "<h1>Інформація про область: {$oblast['name']}</h1>";
        echo "<table border='1' cellpadding='10' cellspacing='0'>
                <tr>
                    <th>Область</th>
                    <th>Населення, тис.</th>
                    <th>Число ВНЗ</th>
                    <th>Число ВНЗ на 100 тис. населення</th>
                </tr>
                <tr>
                    <td>{$oblast['name']}</td>
                    <td>{$oblast['population']}</td>
                    <td>{$oblast['universities']}</td>
                    <td>" . number_format($universities_per_100k, 2) . "</td>
                </tr>
              </table>";
        echo "<br><form action='menu.php' method='post'>
                <input type='submit' value='Повернутися до вибору'>
              </form>";
    } else {
        echo "Неправильний запит.";
    }
} else {
    echo "Область не вибрано.";
}
?>

</body>
</html>
