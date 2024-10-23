<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Прогноз погоди</title>

    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
require 'weather_data.php';

$city_id = isset($_GET['city']) ? $_GET['city'] : '5053';


$weather_data = get_weather_data($city_id);
?>

<div class="weather-container">
    <h2><?php echo $weather_data['city']; ?></h2>
    <p>Дата: <?php echo date('d.m.Y'); ?></p>
    <p>Схід сонця: <?php echo $weather_data['sunrise']; ?></p>
    <p>Захід сонця: <?php echo $weather_data['sunset']; ?></p>
    <p>Тривалість дня: <?php echo $weather_data['duration']; ?></p>

    <h3>Температура на певні години:</h3>
    <?php foreach ($weather_data['temperatures'] as $hour => $temperature): ?>
        <p><?php echo $hour; ?>:00 : <?php echo $temperature; ?> °C</p>
    <?php endforeach; ?>
</div>


<div class="button-container">
    <form method="GET">
        <button type="submit" name="city" value="4944" class="city-button">Київ</button>
        <button type="submit" name="city" value="5053" class="city-button">Харків</button>
    </form>
</div>

</body>
</html>
