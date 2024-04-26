<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/currentversion.php',
        __DIR__ . '/displaychanges.php',
        __DIR__ . '/edit.php',
        __DIR__ . '/index.php',
        __DIR__ . '/phpinfo.php',
        __DIR__ . '/update_changelog.php',
        __DIR__ . '/includes',
    ]);
    $rectorConfig->sets([LevelSetList::UP_TO_PHP_82]);
};
