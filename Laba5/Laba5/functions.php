<?php

function readOblastsFromFile($filename) {
    if (!file_exists($filename)) {
        return false;
    }

    $data = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $oblasts = [];

    for ($i = 0; $i < count($data); $i += 3) {
        $oblasts[] = [
            'name' => trim($data[$i]),
            'population' => trim($data[$i + 1]),
            'universities' => trim($data[$i + 2]),
        ];
    }

    return $oblasts;
}
?>
