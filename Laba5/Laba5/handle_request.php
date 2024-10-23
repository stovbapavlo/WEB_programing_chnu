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
    <title>Інформація про область</title>
</head>
<body>

<?php
if (isset($_POST['oblast_id'])) {
    $oblast_id = intval($_POST['oblast_id']);

    if (isset($oblasts[$oblast_id])) {
        $oblast = $oblasts[$oblast_id];
        $universities_per_100k = ($oblast['universities'] / $oblast['population']) * 100;

        echo "<h1>Інформація про область: {$oblast['name']}</h1>";
        echo "<table>
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
