<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вибір напряму навчання</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<div class="container">
    <h1>Оберіть напрям навчання</h1>
    <form action="process.php" method="POST">
        <?php
        $napr_file = '../assets/txt/napr.txt';
        $napr_list = file($napr_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        sort($napr_list);

        foreach ($napr_list as $napr) {
            echo '<div class="radio-item">';
            echo '<input type="radio" id="' . $napr . '" name="direction" value="' . $napr . '">';
            echo '<label for="' . $napr . '">' . $napr . '</label>';
            echo '</div>';
        }
        ?>
        <button type="submit" class="btn">Відправити запит</button>
    </form>
</div>
</body>
</html>
