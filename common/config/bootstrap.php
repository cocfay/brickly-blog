<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

$envPath = dirname(dirname(__DIR__)) . '/.env';
if (is_file($envPath) && is_readable($envPath)) {
    foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) {
            continue;
        }
        if (!preg_match('/^([A-Z0-9_]+)\s*=\s*(.*)$/i', $line, $m)) {
            continue;
        }
        $key = $m[1];
        $val = trim($m[2]);
        if ((substr($val, 0, 1) === '"' && substr($val, -1) === '"') || (substr($val, 0, 1) === "'" && substr($val, -1) === "'")) {
            $val = substr($val, 1, -1);
        }
        if (getenv($key) === false || getenv($key) === '') {
            putenv("$key=$val");
            $_ENV[$key] = $val;
        }
    }
}
