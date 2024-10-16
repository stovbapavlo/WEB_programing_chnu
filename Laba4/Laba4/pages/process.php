<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статистика по напрямку</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<div class="container">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["direction"])) {
        $selected_direction = $_POST["direction"];
        $data_file = '../assets/txt/data.txt';
        $lines = file($data_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $found = false;
        $result = [];

        for ($i = 0; $i < count($lines); $i++) {
            if ($lines[$i] == $selected_direction) {
                $found = true;

                $num_universities = intval($lines[$i + 1]);

                for ($j = 0; $j < $num_universities; $j++) {
                    $start_index = $i + 2 + ($j * 4);
                    $result[] = [
                        'average_score' => $lines[$start_index],
                        'budget_students' => $lines[$start_index + 1],
                        'contract_students' => $lines[$start_index + 2],
                        'university_name' => $lines[$start_index + 3]
                    ];
                }
                break;
            }
        }

        if ($found) {
            echo '<h2>' . $selected_direction . '</h2>';
            echo '<table>';
            echo '<tr><th>N</th><th>Середній бал (бюджет)</th><th>К-ть студентів (бюджет)</th><th>Недобір</th><th>Число контрактників</th><th>ВНЗ</th></tr>';
            $row_number = 1;
            foreach ($result as $row) {
                echo '<tr>';
                echo '<td>' . $row_number . '</td>';
                echo '<td>' . $row['average_score'] . '</td>';
                echo '<td>' . $row['budget_students'] . '</td>';
                echo '<td>' . ($row['contract_students'] < 0 ? abs($row['contract_students']) : '-') . '</td>';
                echo '<td>' . ($row['contract_students'] >= 1 ? $row['contract_students'] : '-') . '</td>';
                echo '<td>' . $row['university_name'] . '</td>';
                echo '</tr>';
                $row_number++;
            }
            echo '</table>';
        } else {
            echo '<p>Напрямок не знайдено.</p>';
        }
    } else {
        echo '<p>Не вибрано напрямок.</p>';
    }
    ?>

    <a href="form.php" class="btn">Повернутися до вибору напряму</a>
</div>
</body>
</html>
