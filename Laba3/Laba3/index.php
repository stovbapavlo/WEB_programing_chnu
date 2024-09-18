<?php
// Відкриваємо файл для читання
$file = fopen('oblinfo.txt', 'r');

// Перевіряємо, чи вдалося відкрити файл
if ($file) {
    $regions = [];

    // Читаємо файл за допомогою циклу for
    for ($i = 0; !feof($file); $i++) {
        $regionName = trim(fgets($file)); // Читаємо назву області
        $population = (int)trim(fgets($file)); // Читаємо населення
        $universities = (int)trim(fgets($file)); // Читаємо кількість вузів

        // Рахуємо число вузів на 100 тис. населення
        $universitiesPer100k = ($population > 0) ? round(($universities / $population) * 100, 2) : 0;

        // Зберігаємо дані про область
        $regions[] = [
            'name' => $regionName,
            'population' => $population,
            'universities' => $universities,
            'universities_per_100k' => $universitiesPer100k
        ];
    }

    // Закриваємо файл після завершення читання
    fclose($file);
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Таблиця областей України</title>
</head>
<body>

<h1>Таблиця областей України</h1>

<table>
    <thead>
    <tr>
        <th>N</th>
        <th>Область</th>
        <th>Населення, тис.</th>
        <th>Число вузів</th>
        <th>Число вузів на 100 тис. населення</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($regions as $index => $region): ?>
        <tr>
            <td><?php echo $index + 1; ?></td>
            <td><?php echo htmlspecialchars($region['name']); ?></td>
            <td><?php echo number_format($region['population'], 0, '.', ' '); ?></td>
            <td><?php echo $region['universities']; ?></td>
            <td><?php echo $region['universities_per_100k']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
