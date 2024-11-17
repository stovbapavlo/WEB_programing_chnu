<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="utf-8">
    <title>Погода в містах України</title>
    <script>
        function showWeather() {
            const city = document.getElementById("citySelect").value;
            document.getElementById("weatherImage").src = "weather.php?city=" + city;
        }
    </script>
</head>
<body>
<p>Погода:</p>

<!-- Випадаючий список міст -->
<select id="citySelect" onchange="showWeather()">
    <option value="" disabled selected>Оберіть місто</option>
    <option value="4944">Київ</option>
    <option value="5053">Харків</option>
    <option value="4982">Одеса</option>
    <option value="4949">Львів</option>
</select>

<br><br>

<!-- Зображення погоди, яке оновлюється після вибору міста -->
<img id="weatherImage" src="" alt="Оберіть місто, щоб побачити погоду">

</body>
</html>
