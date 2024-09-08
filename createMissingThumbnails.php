<?php

use Plast\Laravel\Bootstrap\PublicImages;

require __DIR__ . '/vendor/autoload.php';

$publicPath = __DIR__ . '/laravel/public';

$maker = new PublicImages($publicPath);

$originals = \scanDir($publicPath . DIRECTORY_SEPARATOR . 'originals');
foreach ($originals as $original) {
    if (\in_array($original, ['.', '..'])) {
        continue;
    }
    $results = $maker->saveInOptimalFormat($original);
    foreach ($results as $result) {
        echo date('Y-m-d H:i:s') . " Converted $result..." . \PHP_EOL;
    }
}

echo date('Y-m-d H:i:s') . ' Done.' . \PHP_EOL;
