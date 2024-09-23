<?php
$file = fopen('oblinfo.txt', 'r');

if ($file) {
    $regions = [];

    for ($i = 0; !feof($file); $i++) {
        $regionName = trim(fgets($file));
        $population = (int)trim(fgets($file));
        $universities = (int)trim(fgets($file));

        $universitiesPer100k = ($population > 0) ? round(($universities / $population) * 100, 2) : 0;

        $regions[] = [
            'name' => $regionName,
            'population' => $population,
            'universities' => $universities,
            'universities_per_100k' => $universitiesPer100k
        ];
    }

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
