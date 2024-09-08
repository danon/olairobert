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
        echo "Converted $result..." . \PHP_EOL;
    }
}

echo 'Done.' . \PHP_EOL;
